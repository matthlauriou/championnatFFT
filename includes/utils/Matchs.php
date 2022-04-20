<?php
    require 'Match.php';

	class Matchs {

		public $matchs;
        
		function __construct($idEquipeBDD, $patternUrlFeuilleMatch, $jsonMatchs) { 
            $this->matchs = array();

            // Boucle sur l'ensemble des journées de championnats
            foreach($jsonMatchs as $key => $jsonJourneeChampionnat){
                // On boucle sur toutes les rencontres de la journée de championnat
                if (strcmp($key, "id_all_days") != 0) {
                    foreach($jsonJourneeChampionnat as $jsonMatch) {
                        // Dès qu'une équipe correspond à l'équipe de la BDD, on ajoute le match à la liste des équipes
                        if (strcmp($jsonMatch["team_home"]["id"], $idEquipeBDD) == 0 
                            || strcmp($jsonMatch["team_visitor"]["id"], $idEquipeBDD) == 0) {
                            $match = new Match($patternUrlFeuilleMatch, $jsonMatch);
                            array_push($this->matchs, $match);
                            break;
                        }
                    }
                }  
            }
		}
	}
?>





