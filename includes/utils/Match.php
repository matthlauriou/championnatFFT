<?php
    require 'Club.php';

	class Match {

		public string $date;
        public int $numeroJournee;
        public Club $visitee;
        public Club $visiteuse;
        public string $lienFeuilleMatch;
        
		function __construct($patternUrlFeuilleMatch, $jsonMatch) {
            //On récupère les données de chaque match dans le JSON
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
            //On récupère le lien de la feuille de match apres avoir reifié que l'equipe visiteuse ou visitée est un score c'est-à-dire un match terminé
            if (isset($jsonMatch["feuille_match_url"]) == 0 
                || strcmp($this->visitee->score, '-') == 0
                || strcmp($this->visiteuse->score, '-') == 0) {
                $this->lienFeuilleMatch = '-';
            } else {
                $this->lienFeuilleMatch = $patternUrlFeuilleMatch.$jsonMatch["feuille_match_url"];
            }

		}
	}
?>
