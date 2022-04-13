<?php

//1 récupérer les données de l'équipe

//recupérer l'id de l'equipe
//$idEquipe = $_POST['idEquipe'];			
//utiliser la fonction getEquipe($idEquipe)
//$equipe = $requetes->getEquipe($idEquipe);

//2 récupérer les données de parametrage

//utiliser la fonction getAllParametrage
//$listeParametres = $requetes->getAllParametrages();
// on as donc les valeur de $url_post, $url_feuille_match

//3 établir le curl 

//curl--location__request POST 'https://tenup.fft.fr/championnat/request/ajax'\
//--header'Content-Type:application/x-www-form-urlencoded'\
//--data-urlencoded 'fiche_championnat=82297029'\
//--data-urlencoded 'division=109411'\
//--data-urlencoded 'phase=109411'\
//--data-urlencoded 'poule=173681'\
//--data-urlencoded 'formsubmit=true'

//simulation d'un remplissage de formulaire!!

//l'url ou on veut recupérer les données    la requète en mode POST en fonction de la feuille de match choisi $url_feuille_match et du pattern $url_post
$url = 'https://tenup.fft.fr/championnat/request/ajax';
//Les données que l'on veut envoyer en POST 
$data = array('fiche_championnat'=>82297029, 'division'=>109411,'phase'=>173681,'poule'=>409913,'formSubmit'=>true);
//la requete 
$option = array(
    'http'=> array( 
        //header
        'header'=> "content-type: application/x-www-form-urlencoded",
        //methode
        'method'=>'POST',
        //le body facultatif      url-ifier les donnees pour le POST
        'content'=>http_build_query($data)
    )    
);

//4 récupérer le fichier le JSON
$context = stream_context_create($option);
$result = file_get_contents($url, false, $context);
//arriver a parser le json utilise json_decode pour extraire les informations de la phrse json creer et recuperer par le file_get_contents() le json_encode() serai pour passer des données php en phrase json
//$decode_json = json_decode($result,true);//true retourne un tableau false un objet
//5 parcourir le fichier JSON
/*foreach($decode_json as $key => $value){
    //boucler pour trouver toute les occurences de chaque entrée
    $division = $decode_json[$key]["division"];
    $poule = $decode_json[$key]["poule"];
}*/
if($result===FALSE){ 
   //génerer un message d'erreur 
   //sortir de la fonction
 }
var_dump($result);
//echo $division.' et '.$poule. 'ect';
//arriver a n'avoir que le body dans la reponse json

//cette connexion fonctionne maintenant faut trouver comment la rendre générique!!!! le jsondecode() a tout planter
/*$url = $url_post
$data= array(clé=>valeur )//données presente sur le site de tenup par exemple pas dans notre BDD trouver le moyen de les liées justement 

*/
//6 fonction de récupération des classement 

//7 fonction de récupération match et résultat

//8 afficher le résultat des fonctions sur la page de l'équipe