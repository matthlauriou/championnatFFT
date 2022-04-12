<?php
	require('constantes.php');
	require_once("requetesBDD.php");

	// Variables globales de la zone d'information
	$zoneInformation = true;
	$message = "";

	// Vérification du queryParam "action" qu'il soit bien valorisé dans le chemin d'accès
	if (isset($_GET["action"])) {

		// Désactivation de la zone d'information
		$zoneInformation = false;

		// Vérification si nous sommes dans une action de création d'équipe
		if (strcmp($_GET["action"], $CREER) == 0) {
			// Création d'équipe, on intialise l'ensemble des valeurs avec les valeurs par défaut
			$titre = "Création";
			$libelle = "";
			$annee = "";
			$numero_championnat = "";
			$division_championnat = "";
			$phase_championnat = "";
			$poule_championnat = "";
			$numero_equipe = "";
		// Vérification si nous sommes dans une action de modification d'équipe
		} elseif (strcmp($_GET["action"], $MODIFIER) == 0) {
			// Modification d'équipe, on intialise l'ensemble des valeurs avec les valeurs de la BDD
			$idEquipe = $_GET['idEquipe'];
			$listeEquipes = getEquipe($idEquipe);
			
			if (count($listeEquipes) == 1) {
				// Valorisation des valeurs de l'équipe vis à vis des données présentes dans la BDD
				$titre = "Modification";
				foreach($listeEquipes as $equipe){
					$libelle = $equipe->libelle;
					$annee = $equipe->annee;
					$numero_championnat = $equipe->numero_championnat;
					$division_championnat = $equipe->division_championnat;
					$phase_championnat = $equipe->phase_championnat;
					$poule_championnat = $equipe->poule_championnat;
					$numero_equipe = $equipe->numero_equipe;
				}
			} else {
				// Nous n'avons pas ou plus d'une équipe suite à la recherche, cas d'erreur remontée
				$zoneInformation = true;
				$message = "Erreur vis à vis de l'équipe sélectionnée : ".$idEquipe;
			}
		} else {
			// L'action souhaitée n'existe pas, on remonte une erreur
			$zoneInformation = true;
			$message = "L'action ".$_GET["action"]." demandée est impossible";
		}
	} else {
		// La variable "action" n'est pas initialisée, on lève une erreur
		$zoneInformation = true;
		$message = "L'action non valorisée";
	}

	// Vérification qu'aucune erreur ne soit levée au préalable et enregistrement si la variable $_POST est valorisée
	if ($zoneInformation == false && !empty($_POST)) {
		
		$zoneInformation = true;
		// On récupere le données en les protégeant contre les failles XSS
		$libelle = strip_tags( $_POST['txt_libelle']);
		$annee = strip_tags( $_POST['txt_annee']);
		$numero_championnat = strip_tags($_POST['txt_numero_championnat']);
	    $division_championnat = strip_tags($_POST['txt_division_championnat']);
	    $phase_championnat = strip_tags($_POST['txt_phase_championnat']);
	    $poule_championnat = strip_tags($_POST['txt_poule_championnat']);
	    $numero_equipe = strip_tags($_POST['txt_numero_equipe']);
	    $archivee = strip_tags($_POST['txt_archivee']);
			
		//si $_get['action']==$CREER inserer donnée en base préparer les paramêtre pour se protéger contre injection sql 
		if (strcmp($_GET["action"], $CREER) == 0) {
			// Action de création on insert donc les données en base en préparant les paramètres pour eviter les injections sql
			$inserted = insertEquipe($libelle, $annee, $numero_championnat, $division_championnat, $phase_championnat, $poule_championnat, $numero_equipe);

			// Vérification que la requête se soit bien éxécutée
			if ($inserted === false) {
				$message = "Création d'équipe impossible";
			} else {
				$message = "Equipe créée avec succès";
			}
		} elseif (strcmp($_GET["action"], $MODIFIER) == 0) {
			// Action de mise à jours de l'équipe en préparant les paramètres pour eviter injection sql
			$updated = updateEquipe($idEquipe, $annee, $numero_championnat, $division_championnat, $phase_championnat, $poule_championnat, $numero_equipe, $archivee);

			if ($updated === false) {
				$message = "Modification d'équipe impossible";
			} else{ 
				$message = "Equipe modifiée avec succès";
			}		
		}
	}

	// Soit on affiche la zone d'information avec le message
	if ($zoneInformation) {
		echo "<h1> $message </h1>
			<button><a href ='?page=championnats'>Retour</a></button>";
	} else {
		// Soit on affiche le formulaire de l'équipe à créer ou à mettre à jours
		echo "<h1>$titre Equipe</h1>
			<form method='post' action='#'id='myform' name='myform'>
				<table>
					<tr>
						<td>Libelle</td>
						<td><input type='text' name='txt_libelle'pattern='[a-zA-Z0-9]+' required='required' value='$libelle'></td>
					</tr>
					<tr>
						<td>Année</td>
						<td><input type='text' name='txt_annee'pattern='[0-9]{4}' required='required' value='$annee'></td>
					</tr>
					<tr>
						<td>Numéro de Championnat</td>
						<td><input type='text' name='txt_numero_championnat'pattern='[0-9]+' required='required' value='$numero_championnat'></td>
					</tr>
					<tr>
						<td>Division</td>
						<td><input type='text' name='txt_division_championnat'pattern='[0-9]+' required='required' value='$division_championnat'></td>
					</tr>
					<tr>
						<td>Phase</td>
						<td><input type='text' name='txt_phase_championnat'pattern='[0-9]+' required='required' value='$phase_championnat'></td>
					</tr>
					<tr>
						<td>Poule</td>
						<td><input type='text' name='txt_poule_championnat' pattern='[0-9]+' required='required' value='$poule_championnat'></td>
					</tr>
					<tr>
						<td>Equipe</td>
						<td><input type='text' name='txt_numero_equipe' pattern='[0-9]+' required='required' value ='$numero_equipe'></td>
					</tr>
					<tr>
						<td>Archiver</td>
						<td><input type='checkbox' name='txt_archivee' value='1'></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type='submit' id='but_submit'name='but_submit' value='Enregister'></td>
					</tr>	
				</table>
			</form>"; 
	}
?>