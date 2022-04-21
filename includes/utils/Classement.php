<?php
    require 'Equipe.php';

	class Classement {

		public $equipes;
        
		function __construct($jsonEquipes) { 
            $this->equipes = array();

            foreach($jsonEquipes as $jsonEquipe){
                $equipe = new Equipe($jsonEquipe);
                array_push($this->equipes, $equipe);
            }
		}
        function allEquipe(){
            return $this->equipes;
        }
	}
?>
