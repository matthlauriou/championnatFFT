<?php

    // Définition des variables globales
    require('constantes.php');
    require_once("requetesBDD.php");

    $url_post = "Aucune valeur";
    $url_feuille_match = "Aucune valeur";

    $zoneInformation = false;
    $message = "";

    // Récupération de l'ensemble des valeurs de la table "parametrage"
    $listeParametres = getAllParametrages();
    
    // On boucle sur l'ensemble des cle/valeur afin de valoriser le formulaire
    foreach ($listeParametres as $parametre) {
        $cle = $parametre->cle;
        $valeur = $parametre->valeur;

        // TODO : URL_POST & URL_FEUILLE_MATCH a définir dans des variables GLOBALES tout comme les noms des tables de la BDD
        if (strcmp($cle, $URL_POST) == 0) {
            $url_post = $valeur;
        } elseif (strcmp($cle, $URL_FEUILLE_MATCH) == 0) {
            $url_feuille_match = $valeur;
        } else {
            // Log précisant la clé inconnue
            $zoneInformation = true;
            $message = "Une clé : ".$cle." est définit en BDD est n'est pas exploitable";
            break;
        }
    }

    // Si nous sommes dans un cas de mise à jours, on vérifie que nous n'avons pas de cas d'erreur et qu'une variable $_POST soit bien définit
    if (!$zoneInformation && !empty($_POST)) {    
        // On récupere les données en les protégeant contre la faille XSS
        $txt_url_post = strip_tags($_POST['txt_url_post']);
        $txt_url_feuille_match = strip_tags($_POST['txt_url_feuille_match']);

        // Mise à jours des valeurs l'une après l'autre vis à vis de sa clé primaire
        if (!updateTableParametrage($URL_POST, $txt_url_post)) {
            $zoneInformation = true;
            $message = "La mise à jours de la clé ".$URL_POST." avec la valeur ".$txt_url_post." est impossible. ";
        }
        if (!updateTableParametrage($URL_FEUILLE_MATCH, $txt_url_feuille_match)) {
            $zoneInformation = true;
            $message = $message ."La mise à jours de la clé ".$URL_FEUILLE_MATCH." avec la valeur ".$txt_url_feuille_match." est impossible. ";
        }

        if (!$zoneInformation) {
            // Pas d'erreur détectée, on affiche un message de succès de mise à jours
            $zoneInformation = true;
            $message = "La mise à jours des valeurs a été effectuée avec succès"
            // Destruction de corps du $_POST
            $_POST = null;
        }       
    }

    if ($zoneInformation) {
        // Demande d'affichage du message d'information/avertissement
        echo "<h1> $message </h1>
            <button><a href ='?page=championnats'>Retour</a></button>";
    } else {
        // Pas de message d'information à afficher, on affiche le formulaire
        echo "<h1>Paramétrage</h1>
            <div class='wrap'>
                <button  type='button' class='btn btn-light btn-lg' id='listeEquipe' name='listeEquipe'><a href='?page=listequipe'>Liste des équipes</a></button>
                <button  type='button' class='btn btn-light btn-lg' id='parametrage' name='parametrage'><a href='?page=parametrage'>Paramétrage</a></button>
            </div>
            <form method='post' action='#'id='form' name='form'>
                <table>
                    <tr>
                        <td>URL de récupération :</td>
                        <td><input type='text' name='txt_url_post' pattern='https://.*' required='required' value='$url_post'></td>
                    </tr>
                    <tr>
                        <td>Pattern lien accès feuille de match :</td>
                        <td><input type='text' name='txt_url_feuille_match' pattern='https://.*' required='required' value='$url_feuille_match'></td>
                    </tr>
                    <tr>
        				<td>&nbsp;</td>
        				<td><input type='submit' id='but_submit'name='but_submit' value='Enregister'></td>
        			</tr>
                </table>
            </form>";
    }
?>