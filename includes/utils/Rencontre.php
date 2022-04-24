<?php
	class Rencontre {

        public string $libelleEquipe;
		public string $date;
        public $dateTime;
        public string $resultat;
        public string $score;
        public string $lienPage;
        
        // Constructeur
		function __construct($libelleEquipe, $lienPage, $match) { 
            require PREFIX_BASE_PATH.'includes/constantes/constantes.php';

            $this->libelleEquipe = $libelleEquipe;
            $this->date = $match->date;
            $this->dateTime = DateTime::createFromFormat($PATTERN_DATE_TEN_UP, $match->date);
            $this->dateTime->setTime(0, 0);
            $this->lienPage = $lienPage;

            // Récupération de l'équipe de Grandchamp
            if(boolval($match->visitee->equipeGrandchamp)) {
                // Calcul du resultat de la rencontre
                if($match->visitee->score - $match->visiteuse->score == 0) {
                    // Match Nul de Grandchamp
                    $this->resultat = $MATCH_NUL;
                } elseif($match->visitee->score - $match->visiteuse->score > 0) {
                    // Victoire de Grandchamp
                    $this->resultat = $VICTOIRE;
                } else {
                    // Défaite de Grandchamp
                    $this->resultat = $DEFAITE;
                }
                $this->score = $match->visitee->score." / ".$match->visiteuse->score;
            } else {
                // Calcul du resultat de la rencontre
                if($match->visiteuse->score - $match->visitee->score == 0) {
                    // Match Nul de Grandchamp
                    $this->resultat = $MATCH_NUL;
                } elseif($match->visiteuse->score - $match->visitee->score > 0) {
                    // Victoire de Grandchamp
                    $this->resultat = $VICTOIRE;
                } else {
                    // Défaite de Grandchamp
                    $this->resultat = $DEFAITE;
                }
                $this->score = $match->visiteuse->score." / ".$match->visitee->score;
            }
		}
	}
?>