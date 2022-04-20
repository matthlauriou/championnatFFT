<?php
    require 'Club.php';

	class Match {

		public string $date;
        public int $numeroJournee;
        public Club $visitee;
        public Club $visiteuse;
        public string $lienFeuilleMatch;
        
		function __construct($patternUrlFeuilleMatch, $jsonMatch) {
            if (isset($jsonMatch["date"]) == 0) {
                $this->date = 'JJ/MM/AAAA';
            } else {
                $this->date = $jsonMatch["date"];
            }
            
            if (isset($jsonMatch["journee"]) == 0) {
                $this->numeroJournee = 0;
            } else {
                $this->numeroJournee = $jsonMatch["journee"];
            }

            if (isset($jsonMatch["team_home"]) == 0) {
                $this->visitee = new Club();
            } else {
                $this->visitee = new Club($jsonMatch["team_home"]);
            }

            if (isset($jsonMatch["team_visitor"]) == 0) {
                $this->visiteuse  = new Club();
            } else {
                $this->visiteuse = new Club($jsonMatch["team_visitor"]);
            }

            if (isset($jsonMatch["feuille_match_url"]) == 0) {
                $this->lienFeuilleMatch = '-';
            } else {
                $this->lienFeuilleMatch = $patternUrlFeuilleMatch.$jsonMatch["feuille_match_url"];
            }

		}
	}
?>
