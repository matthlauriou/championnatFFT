<?php
	require_once 'Base.php';

	class Uninstall extends Base {

		// Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
		}
		// Suppression de la table EQUIPE
		function dropEquipe() {
			$sql = "DROP TABLE IF EXISTS $this->TABLE_EQUIPE";
			$this->wpdb->query($sql);
		}
	
		// Suppression de la table PARAMETRAGE
		function dropParametrage() {
			$sql = "DROP TABLE IF EXISTS $this->TABLE_PARAMETRAGE";
			$this->wpdb->query($sql);
		}

		// Suppression de la table HISTORIQUE
		function dropHistorique() {
			$sql = "DROP TABLE IF EXISTS $this->TABLE_HISTORIQUE";
			$this->wpdb->query($sql);
		}
	}
?>