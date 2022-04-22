<?php
	class Club {

		public string $nom;
        public string $score;
        
		function __construct($jsonClub) {
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
		}
	}
?>