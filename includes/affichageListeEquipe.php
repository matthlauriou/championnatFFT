<?php
	global $wpdb;
	require plugin_dir_path(__FILE__).'/bdd/Requetes.php';
	
	
	// supprimer un enregistrement
	// Variables globales de la zone d'information
	$zoneInformation = true;
	$message = "";

	// Vérification du queryParam "action" qu'il soit bien valorisé dans le chemin d'accès
	if (isset($_GET["action"])) {
		// Désactivation de la zone d'information
		$zoneInformation = false;

		// Vérification si nous sommes dans une action de création d'équipe
		if (strcmp($_GET["action"], $SUPPRIMER) == 0) {	
	    $idEquipe = $_GET['idEquipe'];
	    deleteEquipe($idEquipe);
		} else {
			// L'action souhaitée n'existe pas, on remonte une erreur
			$zoneInformation = true;
			$message = "L'action ".$_GET["action"]." demandée est impossible";
		}
	}else {
		// La variable "action" n'est pas initialisée, on lève une erreur
		$zoneInformation = true;
		$message = "L'action non valorisée";
	}

?>

<h1>Liste des équipes</h1>

<div class="wrap">
    <button  type="button" class="btn btn-light btn-lg" id="listeEquipe" name="listeEquipe"><a href="?page=listequipe">Liste des équipes</a></button>
    <button  type="button" class="btn btn-light btn-lg" id="parametrage" name="parametrage"><a href="?page=parametrage">Paramétrage</a></button>
    <button  type="button" class="btn btn-light btn-lg" id="creationEquipe" name="creationEquipe"><a href="?page=gestionEquipe&action=creer">+</a></button>
</div>

<br/>


<table>
    <tr>
        <th>Shortcode</th>
        <th>Annee Sportive</th>
        <th>Libelle équipe</th>
        <th>Détails</th>
        <th>&nbsp;</th>
    </tr>

<?php

	$requetes = new Requetes($wpdb);
	// Récupération de l'ensemble des equipes
	$listeEquipes = $requetes->getAllEquipes($wpdb);
	if (count($listeEquipes) > 0) {
		// Si on a au moins 1 équipe, on affiche l'ensemble des équipes dans un tableau
	    foreach ($listeEquipes as $equipe) {
	        $id                   = $equipe->id;
	        $annee                = $equipe->annee;
	        $libelle              = $equipe->libelle;
	        $numero_championnat   = $equipe->numero_championnat;
	        $division_championnat = $equipe->division_championnat;
	        $phase_championnat    = $equipe->phase_championnat;
	        $poule_championnat    = $equipe->poule_championnat;
	        $numero_equipe        = $equipe->numero_equipe;
	        
	        echo "<tr>
	                <td>[championnatFFT id=\"$id\"]</td>
	                <td>$annee</td>
	                <td>$libelle</td>
	                <td> Numero championnat : $numero_championnat<br/> 
						Division : $division_championnat<br/> 
						Phase : $phase_championnat<br/> 
						Poule : $poule_championnat<br/> 
						Equipe : $numero_equipe</td>
	                <td><a href='?page=gestionEquipe&action=modifier&idEquipe=$id' name='sub_modifier'>Modifier</a>
	                <br/>
	                <a href='?page=gestionEquipe&action=supprimer&idEquipe=$id' name='sub_supprimer'>Supprimer</a>
	                </td>
	            </tr>
	            ";
	        
	    }
	} else {
	    echo "<tr><td>Aucun résultats trouvés</td></tr>";
	}

?>
</table>