<?php
    
    // Fonction qui s'applique quand le shortcode est activé 
    function championnatFFT_resultats($atts) { 

        
        require plugin_dir_path(__FILE__).'/utils/Classement.php';
        require_once plugin_dir_path(__FILE__).'/bdd/Requetes.php';
        require plugin_dir_path(__FILE__).'/constantes/constantes.php';
        require_once plugin_dir_path(__FILE__).'/utils/Equipe.php';
        global $wpdb;
        $requetes = new Requetes($wpdb);
      
        //1 récupérer les données de l'équipe

        //recupérer l'id de l'equipe 
        $atts = shortcode_atts( array(
            'id'=>''//doit recupérer l'attribut id du shortcode
            ),$atts,'championnatFFT');

        if(!$atts['id']){
            $message="l'id est invalide";
            return $message;
        }

        //quand on met l'attribut id dans le shortcode cela declanche une erreur signalant un json invalide
        $idEquipe = $atts['id']; //doit changer en fonction de l'id recupérer dans le shortcode $idEquipe = $atts['id'];
        //utiliser la fonction getEquipe($idEquipe)
        $equipe = $requetes->getEquipe($idEquipe);
        //valoriser les variables

        $numero_championnat = $equipe->numero_championnat;
        $division_championnat = $equipe->division_championnat; 
        $phase_championnat = $equipe->phase_championnat;
        $poule_championnat = $equipe->poule_championnat;
        
        
        //2 récupérer les données de parametrage

        //utiliser la fonction getAllParametrage
        $listeParametres = $requetes->getAllParametrages();
        // on as donc les valeur de $URL_POST, $URL_FEUILLE_MATCH
        //recupère la clé URL_POST dont la $valeur est en base
        foreach ($listeParametres as $parametre) {
            $cle = $parametre->cle;
            $valeur = $parametre->valeur;
    
            if (strcmp($cle, $URL_POST) == 0) {
                $url_post = $valeur;
            } elseif (strcmp($cle, $URL_FEUILLE_MATCH) == 0) {
                $url_feuille_match = $valeur;
            }
        }

        //3 établir le curl 

        //simulation d'un remplissage de formulaire!!

        //l'url ou on veut recupérer les données    
        $url = $url_post;
        //Les données que l'on veut envoyer en POST 
        $data = array('fiche_championnat'=>$numero_championnat,'division'=>$division_championnat,'phase'=>$phase_championnat,'poule'=>$poule_championnat,'formSubmit'=>true);
        //la requete 
        $option = array(
            'http'=> array( 
                //header
                'header'=> "content-type: application/x-www-form-urlencoded\r\n" .
                        "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n",
                'method'=>'POST',
                //le body facultatif      url-ifier les donnees pour le POST
                'content'=>http_build_query($data)
            ),
            //verifier le certificat SSL (secure sockets layer)
            'ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_singed'=>true
            )    
        );

        //4 récupérer le fichier le JSON
        $context = stream_context_create($option);
        //on transforme le json en phrase
        $result = file_get_contents($url, false, $context);

        //parser le json pour extraire les informations de la phrase json creer et recuperer par le file_get_contents()
        $parsed_Json = json_decode($result,true);
        //5 parcourir le fichier JSON
        $resultsEquipes = $parsed_Json['results'];
        $raw_data = $resultsEquipes["raw_data"];
        $jsonEquipes = $raw_data["equipes"];
        
        //var_dump($jsonEquipes);

        //6 fonction de récupération des classement 
        $classement = new Classement($jsonEquipes);
        print_r($classement);

        /*
        echo "<h1>". $nom ."</h1>
        <tr>
        <td>". $place ."</td>
        <td>". $nbVictoires ."</td>
        <td>". $nbDefaites ."</td>
        <td>". $nombreMatchesGagnes ."</td>
        <td>". $nombreMatchesPerdus ."</td>
        <td>". $nombreSetsGagnes ."</td>
        <td>". $nombreSetsPerdus ."</td>
        <td>". $nombreJeuxGagnes ."</td>
        <td>". $nombreJeuxPerdus ."</td>
        </tr>
        ";*/
       
        //trier en fonction du numéro d'équipe en comparant la base et le numéro dans le json
     
        if($result===FALSE){ 
            echo "Une erreur est survenue lors de la lecture des données";
            die;
        }
        
        //7 fonction de récupération match et résultat

        //8 afficher le résultat des fonctions sur la page de l'équipe
        
        return $result;//le fichier json est en raw 
        
    }
    // ajouter shortcode
    add_shortcode('championnatFFT', 'championnatFFT_resultats');

?>