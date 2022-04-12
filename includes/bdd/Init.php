<?php
	require 'Base.php';

	class Init extends Base {

		// Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
		}

		// TODO : commentaires ?
		function creerTableEquipe() {
			$charset_collate = $this->wpdb->get_charset_collate();

			$sql_equipe      = "CREATE TABLE $this->TABLE_EQUIPE (
				id mediumint(11) NOT NULL AUTO_INCREMENT,
				libelle varchar(100) NOT NULL,
				annee varchar(4) NOT NULL,
				numero_championnat mediumint(11) NOT NULL,
				division_championnat mediumint(11) NOT NULL,
				phase_championnat mediumint(11) NOT NULL,
				poule_championnat mediumint(11) NOT NULL,
				numero_equipe mediumint(11) NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";

			return $sql_equipe;
		}

		// TODO : commentaires ?
		function creerTableParametrage() {
			$charset_collate = $this->wpdb->get_charset_collate();

			$sql_parametrage = "CREATE TABLE $this->TABLE_PARAMETRAGE (
				cle varchar(50) NOT NULL,
				valeur varchar(255) NOT NULL,
				PRIMARY KEY  (cle)
			) $charset_collate;";

			return $sql_parametrage;
		}

		// Création des clés des URL
		function insertParametrage($cle) {
				$this->wpdb->insert($this->TABLE_PARAMETRAGE, array(
				'cle' => $cle,
				'valeur' => 'A DEFINIR'
			));
		}
	}
?>