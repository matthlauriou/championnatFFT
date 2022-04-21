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

        // 4 - Récupérer le JSON depuis le CURL
        $result = file_get_contents($urlDonneesChampionnat, false, $context);

        if($result===FALSE){ 
            echo "Une erreur est survenue lors de la lecture des données";
            die;
        }

        // TODO gérer une erreur de retour de la réponse HTTP

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
        //print("<pre>".print_r($classement,true)."</pre>");

        // 7 - Générer la liste des matchs
        $matchs = new Matchs($identifiantEquipeBDD, $urlPatternFeuilleMatch, $jsonCalendrierMatchs);
        //print("<pre>".print_r($matchs,true)."</pre>");
       
        // 8 - Trier $classement et $matchs si besoin : pour le moment N/A

        // 9 - Afficher le résultat des fonctions sur la page de l'équipe

        $affichageHTML =  "<h1>Le classement</h1><br><figure class='wp-block-table is-style-stripes'><table>
        <tbody>
        <tr>
        <th>Classement</th>
        <th>Equipes</th>
        <th>Points</th>
        <th>Diff.Matchs</th>
        <th>Diff.Sets</th>
        <th>Diff.Jeux</th>
        </tr>
        </tbody></table></figure>";

        $equipes = array();
        $equipe = new Equipe($jsonEquipes);            
        foreach($equipes as $equipe){
            $nom = $equipe->nom;
            $place = $equipe->place;
            $points = $equipe->points;
            $diffNombreMatchs = $equipe->diffNombreMatchs;
            $diffNombreSets = $equipe->diffNombreSets;
            $diffNombreJeux = $equipe->diffNombreJeux;
        }
        echo "
        <tr>
        <td>". $place ."</td>
        <td>". $nom ."</td>
        <td>". $points ."</td>
        <td>". $diffNombreMatchs ."</td>
        <td>". $diffNombreSets ."</td>
        <td>". $diffNombreJeux ."</td>
        </tr>
        ";
        
       
        
        return $affichageHTML;
    }
    // ajouter shortcode
    add_shortcode('championnatFFT', 'championnatFFT_resultats');

?>