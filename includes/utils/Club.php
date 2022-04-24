<?php
	class Club {

		public string $nom;
        public string $score;
		public bool $equipeGrandchamp;
        
		function __construct($idEquipeBDD, $jsonClub) {
			//On récupère le nom et le score des équipes
			if (isset($jsonClub["name"]) == 0) {
            	$this->nom = 'CLUB';
			} else {
				$this->nom = $jsonClub["name"];
			}

			//On vérifie que le score est déclaré et valorisé avant de le recupérer
			if (isset($jsonClub["score"]) == 0 || strcmp($jsonClub["score"], '') == 0) {
            	$this->score = '-';
			} else {
				$this->score = $jsonClub["score"];
			}

			//On précise si cette équipe est l'équipe de Grandchamp
			if (strcmp($idEquipeBDD, $jsonClub["id"]) == 0) {
				$this->equipeGrandchamp = true;
			} else {
				$this->equipeGrandchamp = false;
			}
		}
	}
?>