<?php
	global $wpdb;  
	require_once("paramBDD.php");

	// TODO : commentaires ?
	function getAllParametrages () {
		return $wpdb->get_results("SELECT * FROM ".$TABLE_PARAMETRAGE);
	}

	// TODO : commentaires ?
	function updateTableParametrage($cle, $valeur) {
		return $wpdb->update($TABLE_PARAMETRAGE, array('valeur'=> $valeur), array('cle' => $cle), $format = null, $where_format = null);
	}

	// TODO : commentaires ?
	function getEquipe($idEquipe) {
		return $wpdb->get_results("SELECT * FROM ".$TABLE_EQUIPE." WHERE id = ".$idEquipe);
	}

	// TODO : commentaires ?
	function getAllEquipes() {
		return $wpdb->get_results("SELECT * FROM " . $TABLE_EQUIPE . " where archivee = 0 order by id desc");
	}

	// TODO1 : commentaires ?
	// TODO2 : lors de la création d'une équipe, on ne peut pas archiver une équipe par défaut, cette valorisation doit donc être automatiquement à false par défaut
	function insertEquipe($libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe) {
		// FIXME voir TODO2
		$archivee = false;
		return $wpdb->insert($TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat ,'poule_championnat'=>$pouleChampionnat,'numero_equipe'=>$numero_equipe,'archivee'=>$archivee));
	}

	// TODO : commentaires ?
	function updateEquipe($idEquipe, $libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe, $archivee) {
		return $wpdb->update($TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat,'poule_championnat'=>$pouleChampionnat,'numero_equipe'=>$numeroEquipe,'archivee'=>$archivee), array('id' => $idEquipe), $format = null, $where_format = null);

	}

	// TODO : commentaires ?
	function deleteEquipe($idEquipe) {
		$wpdb->query("DELETE FROM " . $TABLE_EQUIPE . " WHERE id = " . $idEquipe);
	}


?>