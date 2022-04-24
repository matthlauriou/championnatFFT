<?php
	class Base {

		public Object $wpdb;
		public string $TABLE_EQUIPE;
		public string $TABLE_PARAMETRAGE;
		public string $TABLE_HISTORIQUE;

		function __construct($wpdb) {
			$this->wpdb = $wpdb;
			$this->TABLE_EQUIPE = $wpdb->prefix."chmp_equipe";
			$this->TABLE_PARAMETRAGE = $wpdb->prefix."chmp_parametrage";
			$this->TABLE_HISTORIQUE = $wpdb->prefix."chmp_historique";
		}
	}
?>