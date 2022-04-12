<?php
	global $wpdb;
	require_once("paramBDD.php");

	// Suppression de la table EQUIPE
	function dropEquipe() {
		$sql = "DROP TABLE IF EXISTS $TABLE_EQUIPE";
		$wpdb->query($sql);
	}
  
  	// TODO : commentaires ?
    function dropParametrage() {
		$sql = "DROP TABLE IF EXISTS $TABLE_PARAMETRAGE";
		$wpdb->query($sql);
	}
?>