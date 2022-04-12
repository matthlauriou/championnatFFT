<?php
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	require('constantes.php');
	require_once("paramBDD.php");

	$charset_collate = $wpdb->get_charset_collate();

	// TODO : commentaires ?
	function creerTableEquipe() {
		$sql_equipe      = "CREATE TABLE $TABLE_EQUIPE (
	        id mediumint(11) NOT NULL AUTO_INCREMENT,
	        libelle varchar(100) NOT NULL,
	        annee varchar(4) NOT NULL,
	        numero_championnat mediumint(11) NOT NULL,
	        division_championnat mediumint(11) NOT NULL,
	        phase_championnat mediumint(11) NOT NULL,
	        poule_championnat mediumint(11) NOT NULL,
	        numero_equipe mediumint(11) NOT NULL,
	        archivee mediumint(11) NOT NULL,
	        PRIMARY KEY  (id)
	      ) $charset_collate;";

		dbDelta($sql_equipe);
	}

	// TODO : commentaires ?
	function creerTableParametrage() {
		$sql_parametrage = "CREATE TABLE $TABLE_PARAMETRAGE (
	        cle varchar(50) NOT NULL,
	        valeur varchar(255) NOT NULL,
	        PRIMARY KEY  (cle)
	      ) $charset_collate;";

		dbDelta($sql_parametrage);
	}

	// Création des clés des URL
	function insertParametrage($cle) {
		$wpdb->insert($TABLE_PARAMETRAGE, array(
          'cle' => $cle,
          'valeur' => 'TO DEFINE'
      ));
	}
?>