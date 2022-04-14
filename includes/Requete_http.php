<?php
//créer une classe php requeteHTTP qui hérite de la classe requetes ?
/*Class RequetesHTTP extends Requetes{
    // Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
}
*/
//require 'Requetes.php';
    require plugin_dir_path(__FILE__).'/bdd/Requetes.php'; //fatal error plugin_dir_path undifined
    global $wpdb;
    $requetes = new Requetes($wpdb);
    
//1 récupérer les données de l'équipe

//recupérer l'id de l'equipe //numéro_equipe pcq id présent que dans notre bdd alors que numero_equipe est une donnée commune avec tenup
$idEquipe = $_POST['idEquipe'];		
//utiliser la fonction getEquipe($idEquipe)
$equipe = $requetes->getEquipe($idEquipe);
//valoriser les variables
//$numéro_championnat=82297029; 
$numero_championnat   = $equipe->numero_championnat;
//$division_championnat=109411; 
$division_championnat = $equipe->division_championnat;
//$phase_championnat=173681; 
$phase_championnat    = $equipe->phase_championnat;
//$poule_championnat=409913;
$poule_championnat    = $equipe->poule_championnat;

var_dump($numero_championnat);
//2 récupérer les données de parametrage 

//utiliser la fonction getAllParametrage
/*$listeParametres = $requetes->getAllParametrages();
foreach ($listeParametres as $parametre) {
    $cle = $parametre->cle;
    $valeur = $parametre->valeur;
}
if (strcmp($cle, $URL_POST) == 0) {
            $url_post = $valeur;
        } elseif (strcmp($cle, $URL_FEUILLE_MATCH) == 0) {
            $url_feuille_match = $valeur;
*/
// on as donc les valeur de $url_post, $url_feuille_match
/*$url_post='https://tenup.fft.fr/championnat/request/ajax';
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
$url = $url_post;
//Les données que l'on veut envoyer en POST 
//$data = array('fiche_championnat'=>82297029, 'division'=>109411,'phase'=>173681,'poule'=>409913,'formSubmit'=>true);
$data = array('fiche_championnat'=>$numéro_championnat,'division'=>$division_championnat,'phase'=>$phase_championnat,'poule'=>$poule_championnat,'formSubmit'=>true);
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
//$decode_json = json_decode($result,true);//true retourne un tableau d'objets false un objets ,null objets ou tableau d'objets si const JSON_OBJECT_AS_ARRAY à été defini dans le parametre flags
//5 parcourir le fichier JSON
/*foreach($decode_json as $key => $value){
    //boucler pour trouver toute les occurences de chaque entrée
    $division = $decode_json[$key]["division"];
    $poule = $decode_json[$key]["poule"];
}*/
/*if($result===FALSE){ 
   //génerer un message d'erreur 
   //sortir de la fonction
 }
var_dump($result);*/
//echo $division.' et '.$poule. 'ect';

//arriver a n'avoir que le body dans la réponse json

//cette connexion fonctionne maintenant faut trouver comment la rendre générique!!!! le jsondecode() a tout planter

/*$url = $url_post
$data= array(clé=>valeur )//données présente sur le site de tenup par exemple pas dans notre BDD trouver le moyen de les liées justement 
fiche_championnat=$numéro_championnat,division=$division_championnat,phase=$phase_championnat,poule=$poule_championnat
récupére en fonction de l'idEquipe
*/

//6 fonction de récupération des classement 

//7 fonction de récupération match et résultat

//8 afficher le résultat des fonctions sur la page de l'équipe