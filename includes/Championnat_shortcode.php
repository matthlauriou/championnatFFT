<?php
    
    // Fonction qui s'applique quand le shortcode est activé 
    function championnatFFT_resultats($atts) { 

        require_once plugin_dir_path(__FILE__).'/bdd/Requetes.php';
        require plugin_dir_path(__FILE__).'/constantes/constantes.php';
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
        print_r($idEquipe);
        //utiliser la fonction getEquipe($idEquipe)
        $equipe = $requetes->getEquipe($idEquipe);
        //valoriser les variables
        print_r($equipe);

        $numero_championnat = $equipe->numero_championnat;
        $division_championnat = $equipe->division_championnat; 
        $phase_championnat = $equipe->phase_championnat;
        $poule_championnat = $equipe->poule_championnat;
        $numero_equipe = $equipe->numero_equipe;
        
        //2 récupérer les données de parametrage

        //utiliser la fonction getAllParametrage
        $listeParametres = $requetes->getAllParametrages();
        print_r($listeParametres);
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
        
        print_r($url_post);

        //3 établir le curl 

        //simulation d'un remplissage de formulaire!!

        //l'url ou on veut recupérer les données    la requète en mode POST en fonction de la feuille de match choisi $url_feuille_match et du pattern $url_post
        $url = $url_post;
        //Les données que l'on veut envoyer en POST 
        $data = array('fiche_championnat'=>$numero_championnat,'division'=>$division_championnat,'phase'=>$phase_championnat,'poule'=>$poule_championnat,'equipe'=>$numero_equipe,'formSubmit'=>true);
        //la requete 
        $option = array(
            'http'=> array( 
                //header
                'header'=> "content-type: application/x-www-form-urlencoded\r\n",
                //methode
                'method'=>'POST',
                //le body facultatif      url-ifier les donnees pour le POST
                'content'=>http_build_query($data)
            )    
        );

        //4 récupérer le fichier le JSON
        $context = stream_context_create($option);
        //on transforme le json en phrase
        $result = file_get_contents($url, false, $context);

        //arriver a parser le json utilise json_decode pour extraire les informations de la phrase json creer et recuperer par le file_get_contents() le json_encode() serai pour passer des données php en phrase json

        var_dump(json_decode($result));
        //retourn null ce qui veut dire le paramètre json n'a pu être décodé ou si les données encodées sont plus profondes que la limite d'imbrication fournie.
        
        //5 parcourir le fichier JSON
     
        if($result===FALSE){ 
        echo "Une erreur est survenue lors de la lecture des données";
        die;
        }
        
        //6 fonction de récupération des classement 

        //7 fonction de récupération match et résultat

        //8 afficher le résultat des fonctions sur la page de l'équipe      
        return $result;//le fichier json est en raw ....le passer en pretty et sans le header
        
        
        //arriver a n'avoir que le body dans la réponse json ?

    }
    // ajouter shortcode
    add_shortcode('championnatFFT', 'championnatFFT_resultats');

?>