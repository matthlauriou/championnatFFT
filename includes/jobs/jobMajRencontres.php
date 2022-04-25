<?php

    // Fonction qui se lance par la tâche récurrente via le CRON
    function chmptFFT_cron_exec() {
        error_log("[JOB-MAJ-RENCONTRE] Debut");

        require_once PREFIX_BASE_PATH.'includes/bdd/Requetes.php';
        require_once PREFIX_BASE_PATH.'includes/constantes/constantes.php';
        require_once PREFIX_BASE_PATH.'includes/utils/Matchs.php';
        require_once PREFIX_BASE_PATH.'includes/utils/Rencontre.php';

        global $wpdb;
        $requetes = new Requetes($wpdb);
      
        // Récupérer l'ensemble des équipes associées à l'année sportive en cours
        $equipesSaisonEnCours = $requetes->getAllEquipesSaisonEnCours();
        
        // 1 - Récupérer les données de Paramétrage depuis la BDD

        // On récupère l'url de Ten'Up pour récupérer les valeurs
        $urlDonneesChampionnat = $requetes->getParametrageUrlPost()->valeur;

        if(strcmp($urlDonneesChampionnat, '') == 0
            || !str_contains($urlDonneesChampionnat, $PATTERN_HTTPS)) {
            error_log("[JOB-MAJ-RENCONTRE] URL de recuperation du championnat invalide");
            return;
        }

        $rencontres = array();
        
        // 2 - Appel du curl sur chaque équipe pour récupérer l'ensemble des matchs des équipes
        foreach($equipesSaisonEnCours as $equipeSaisonEnCours) {
            //Les données que l'on veut envoyer en POST 
            $body = array('fiche_championnat' => $equipeSaisonEnCours->numero_championnat, 
                'division' => $equipeSaisonEnCours->division_championnat,
                'phase' => $equipeSaisonEnCours->phase_championnat, 
                'poule' => $equipeSaisonEnCours->poule_championnat, 
                'formSubmit' => true);
            
            $options = array(
                'http' => array( 
                    'header' => "content-type: application/x-www-form-urlencoded\r\n"
                            ."User-Agent: " .$_SERVER['HTTP_USER_AGENT'],
                    'method' => 'POST',
                    'content' => http_build_query($body)
                ),
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_singed' => true
                )
            );

            $context = stream_context_create($options);

            if($context == 0){ 
                error_log("[JOB-MAJ-RENCONTRE] Probleme context ".var_dump($options));
                continue;
            } else{
                // 3 - Récupérer le JSON depuis le CURL
                $result = file_get_contents($urlDonneesChampionnat, false, $context);

                if($result == false){ 
                    error_log("[JOB-MAJ-RENCONTRE] Erreur reponse FFT : $urlDonneesChampionnat avec options ".var_dump($options));
                    continue;
                }
            }

            //parser le json pour extraire les informations de la phrase json creer et recuperer par le file_get_contents()
            $parsedJson = json_decode($result, true);

            // 4 - Parcourir le fichier JSON
            $parsedJsonResults = $parsedJson['results'];
            $parsedJsonResultsRawDataComponents = $parsedJsonResults["components"];
            $parsedJsonResultsRawDataComponentsCalendrier = $parsedJsonResultsRawDataComponents["calendrier"];
            $jsonCalendrierMatchs = $parsedJsonResultsRawDataComponentsCalendrier["rows"];

            // 5 - Générer la liste des matchs
            $matchsEquipeSaisonEnCours = new Matchs($equipeSaisonEnCours->numero_equipe, null, $jsonCalendrierMatchs);
          
            $rencontres = ajouterRencontre($rencontres, $equipeSaisonEnCours->libelle, $equipeSaisonEnCours->lien_page, $matchsEquipeSaisonEnCours);
        }
     
        // 6 - Trier par date de match pour récupérer le plus récent
        usort($rencontres, function($a, $b) {
            return ($a->dateTime < $b->dateTime) ? 1 : -1;
        });

        // 7 - Récupération des 5 premières rencontres les plus récentes
        $rencontresBDD = array();
        $i = 0;
        foreach($rencontres as $rencontre) {
            array_push($rencontresBDD, $rencontre);
            $i++;

            if($i >= 5) {
                break;
            }
        }

        // 8 - En cas de résultat des équipes, on vide la table d'historique et on ajoute l'ensemble des rencontres
        if(sizeof($rencontresBDD) > 0) {

            // Drop de la table HISTORIQUE
            $requetes->viderHistorique();

            // Ajout de l'ensemble des valeurs dans la BDD
            foreach($rencontresBDD as $rencontre) {
                $requetes->insertHistorique(
                    $rencontre->libelleEquipe,
                    $rencontre->date,
                    $rencontre->resultat,
                    $rencontre->score,
                    $rencontre->lienPage);
            }
        }

        error_log("[JOB-MAJ-RENCONTRE] Fin");
    }

    // Ajouter une rencontre à la liste de toutes les rencontres
    function ajouterRencontre($rencontres, $libelleEquipe, $lienPage, $matchsEquipeSaisonEnCours) {
        // On boucle sur l'ensemble des matchs pour l'ajouter à toutes les rencontres
        foreach($matchsEquipeSaisonEnCours->matchs as $match) {
            
            if(strcmp($match->visitee->score, '-') == 0
                || strcmp($match->visiteuse->score, '-') == 0
                || ($match->visitee->score + $match->visiteuse->score == 0)) {
                // Aucun résultat de match, on passe au match suivant
                continue;
            }
            $rencontre = new Rencontre($libelleEquipe, $lienPage, $match);

            array_push($rencontres, $rencontre);
        }

        return $rencontres;
    }

    // ajouter action
    add_action('chmptFFT_cron_hook', 'chmptFFT_cron_exec');
?>