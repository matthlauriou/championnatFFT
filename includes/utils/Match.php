<?php
    require_once 'Club.php';

	class Match {

		public string $date;
        public int $numeroJournee;
        public Club $visitee;
        public Club $visiteuse;
        public string $lienFeuilleMatch;
        
		function __construct($patternUrlFeuilleMatch, $idEquipeBDD, $jsonMatch) {
            require PREFIX_BASE_PATH.'includes/constantes/constantes.php';

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
                $this->visitee = new Club($idEquipeBDD, $jsonMatch["team_home"]);
            }

            if (isset($jsonMatch["team_visitor"]) == 0) {
                $this->visiteuse  = new Club();
            } else {
                $this->visiteuse = new Club($idEquipeBDD, $jsonMatch["team_visitor"]);
            }
            //On récupère le lien de la feuille de match apres avoir vérifiée 
            //que l'equipe visiteuse ou visitée est un score c'est-à-dire un match terminé
            //et que le pattern de feuille de match soit valorisé
            //et que nous ne sommes pas dans une url de création d'une feuille de match
            if (isset($jsonMatch["feuille_match_url"]) == 0 
                || strcmp($this->visitee->score, '-') == 0
                || strcmp($this->visiteuse->score, '-') == 0
                || $patternUrlFeuilleMatch == null
                || str_contains($jsonMatch["feuille_match_url"], $EXCLUSION_CREATE)) {
                $this->lienFeuilleMatch = '-';
            } else {
                $this->lienFeuilleMatch = $patternUrlFeuilleMatch.$jsonMatch["feuille_match_url"];
            }

		}
	}
?>
