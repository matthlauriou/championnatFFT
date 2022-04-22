<?php
    
    // Fonction qui s'applique quand le shortcode est activé 
    function championnatFFT_resultats($atts) { 

        require_once plugin_dir_path(__FILE__).'/bdd/Requetes.php';
        require_once plugin_dir_path(__FILE__).'/constantes/constantes.php';
        require_once plugin_dir_path(__FILE__).'/utils/Classement.php';
        require_once plugin_dir_path(__FILE__).'/utils/Equipe.php';
        require_once plugin_dir_path(__FILE__).'/utils/Matchs.php';

        global $wpdb;
        $requetes = new Requetes($wpdb);
      
        // 1 - Récupérer les données de l'équipe depuis la BDD

        //recupérer l'id de l'equipe 
        $atts = shortcode_atts(
            array(
                'id' => '' //doit recupérer l'attribut id du shortcode
            ), $atts, 'championnatFFT');

        if(!$atts['id']){
            // TODO : faire une balise HTML pour le message s'affiche joliment
            $message = "L'id est invalide";
            return $message;
        }

        //quand on met l'attribut id dans le shortcode cela declanche une erreur signalant un json invalide
        $idEquipe = $atts['id']; //doit changer en fonction de l'id recupérer dans le shortcode $idEquipe = $atts['id'];
        //utiliser la fonction getEquipe($idEquipe)
        $donneesEquipeBDD = $requetes->getEquipe($idEquipe);

        //valoriser les variables
        $numeroChampionnatEquipeBDD = $donneesEquipeBDD->numero_championnat;
        $divisionChampionnatEquipeBDD = $donneesEquipeBDD->division_championnat; 
        $phaseChampionnatEquipeBDD = $donneesEquipeBDD->phase_championnat;
        $pouleChampionnatEquipeBDD = $donneesEquipeBDD->poule_championnat;
        $identifiantEquipeBDD = $donneesEquipeBDD->numero_equipe;
        
        // 2 - Récupérer les données de Paramétrage depuis la BDD

        //utiliser la fonction getAllParametrage
        $listeParametres = $requetes->getAllParametrages();
        // on a donc les valeurs de $URL_POST, $URL_FEUILLE_MATCH
        //recupère la clé URL_POST dont la $valeur est en base
        $urlDonneesChampionnat = '';
        $urlPatternFeuilleMatch = '';
        foreach ($listeParametres as $parametre) {
            $cle = $parametre->cle;
            $valeur = $parametre->valeur;
    
            if (strcmp($cle, $URL_POST) == 0) {
                $urlDonneesChampionnat = $valeur;
            } elseif (strcmp($cle, $URL_FEUILLE_MATCH) == 0) {
                $urlPatternFeuilleMatch = $valeur;
            }
        }

        if(strcmp($urlDonneesChampionnat, '') == 0 || strcmp($urlPatternFeuilleMatch, '') == 0) {
            // TODO : faire une balise HTML pour le message s'affiche joliment
            $message = "URLs invalides";
            return $message;
        }

        // 3 - Préparer le curl

        //Les données que l'on veut envoyer en POST 
        $body = array('fiche_championnat' => $numeroChampionnatEquipeBDD, 'division' => $divisionChampionnatEquipeBDD,
            'phase' => $phaseChampionnatEquipeBDD, 'poule' => $pouleChampionnatEquipeBDD, 'formSubmit' => true);
        
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
            $affichageHTML =  "<p>Une erreur est survenue lors de la création du contexte avec les paramètres fournis</p>";
                return $affichageHTML;
        } else{
            // 4 - Récupérer le JSON depuis le CURL
            $result = file_get_contents($urlDonneesChampionnat, false, $context);

            if($result == false){ 
                $affichageHTML =  "<p>Une erreur est survenue lors de la lecture des données</p>";
                return $affichageHTML;
            }
        }

        //parser le json pour extraire les informations de la phrase json creer et recuperer par le file_get_contents()
        $parsedJson = json_decode($result, true);

        // 5 - Parcourir le fichier JSON
        $parsedJsonResults = $parsedJson['results'];
        $parsedJsonResultsRawData = $parsedJsonResults["raw_data"];
        $jsonEquipes = $parsedJsonResultsRawData["equipes"];

        $parsedJsonResultsRawDataComponents = $parsedJsonResults["components"];
        $parsedJsonResultsRawDataComponentsCalendrier = $parsedJsonResultsRawDataComponents["calendrier"];
        $jsonCalendrierMatchs = $parsedJsonResultsRawDataComponentsCalendrier["rows"];

        // 6 - Fonction de récupération des classement 
        $classement = new Classement($jsonEquipes);

        // 7 - Générer la liste des matchs
        $matchs = new Matchs($identifiantEquipeBDD, $urlPatternFeuilleMatch, $jsonCalendrierMatchs);
               
        // 8 - Trier $classement et $matchs si besoin : pour le moment N/A

        // 9 - Afficher le résultat des fonctions sur la page de l'équipe

        //On crée le tableau dans lequelle on va afficher les données
        $affichageHTML =  "<h1>Le classement</h1><br/>
        
        <figure class='wp-block-table is-style-stripes'>
            <table>
                <tbody>
                    <tr>
                        <th>Classement</th>
                        <th>Equipes</th>
                        <th>Points</th>
                        <th>Diff.Matchs</th>
                        <th>Diff.Sets</th>
                        <th>Diff.Jeux</th>
                    </tr>";
        
        // On boucle sur l'ensemble du classement afin d'ajouter chaque équipe dans le tableau HTML de classement à afficher à l'écran
        foreach($classement->equipes as $equipe){
            $nom = $equipe->nom;
            $place = $equipe->place;
            $points = $equipe->points;
            $diffNombreMatchs = $equipe->diffNombreMatchs;
            $nombreMatchsGagnes = $equipe->nombreMatchsGagnes;
            $nombreMatchsPerdus = $equipe->nombreMatchsPerdus;
            $diffNombreSets = $equipe->diffNombreSets;
            $nombreSetsGagnes = $equipe->nombreSetsGagnes;
            $nombreSetsPerdus = $equipe->nombreSetsPerdus;
            $diffNombreJeux = $equipe->diffNombreJeux;
            $nombreJeuxGagnes = $equipe->nombreJeuxGagnes;
            $nombreJeuxPerdus = $equipe->nombreJeuxPerdus;
        
            $affichageHTML = $affichageHTML
                ."<tr>
                    <td>$place</td>
                    <td>$nom</td>
                    <td>$points</td>
                    <td>$diffNombreMatchs (+$nombreMatchsGagnes/-$nombreMatchsPerdus)</td>
                    <td>$diffNombreSets  (+$nombreSetsGagnes/-$nombreSetsPerdus)</td>
                    <td>$diffNombreJeux  (+$nombreJeuxGagnes/-$nombreJeuxPerdus)</td>
                </tr>";
        }
        //On ferme le tableau de classement
        $affichageHTML = $affichageHTML."
                    </tbody>
                </table>
            </figure>";

        //On crée un nouvelle affichage a la suite du premier tableau 
        $affichageHTML = $affichageHTML. "<h1>Les Résultats</h1><br/>";
        // On boucle sur l'ensemble des matchs afin d'afficher chaque match dans un tableau HTML
        foreach($matchs->matchs as $match){
            $date = $match->date;
            $visiteeNom = $match->visitee->nom;
            $visiteeScore = $match->visitee->score;
            $visiteuseNom = $match->visiteuse->nom;
            $visiteuseScore = $match->visiteuse->score;
            $lienFeuilleMatch = $match->lienFeuilleMatch;

            //On crée un tableau de resultat pour chaque match avec son propre lien vers la feuille de match
            $affichageHTML = $affichageHTML."

            <figure class='wp-block-table is-style-stripes'>
                <table>
                    <tbody>
                        <tr>
                            <th>Date du match $date</th>
                        </tr>
                        <tr>
                            <td>$visiteeNom / $visiteuseNom</td>
                        </tr>
                        <tr>
                            <td>$visiteeScore / $visiteuseScore</td>
                        </tr>";

            // Ajout du lien de la feuille de match seulement s'il y a eu un score de définit
            if(strcmp($lienFeuilleMatch, '-') != 0) {
                $affichageHTML = $affichageHTML
                    ."<tr>
                        <td><a href=\"$lienFeuilleMatch\" target=\"_blank\">Accès à la feuille de match</a></td>
                    </tr>";
            }
                        
            $affichageHTML = $affichageHTML."</tbody>
                    </table>
                </figure>";
        }

       
        //On affiche le HTML sur la page 
        return $affichageHTML;
    }
    // ajouter shortcode
    add_shortcode('championnatFFT', 'championnatFFT_resultats');

?>