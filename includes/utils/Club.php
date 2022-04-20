<?php
	class Club {

		public string $nom;
        public string $score;
        
		function __construct($jsonClub) {
			if (isset($jsonClub["name"]) == 0) {
            	$this->nom = 'CLUB';
			} else {
				$this->nom = $jsonClub["name"];
			}

			if (isset($jsonClub["score"]) == 0 || strcmp($jsonClub["score"], '') == 0) {
            	$this->score = '-';
			} else {
				$this->score = $jsonClub["score"];
			}
		}
	}
?>