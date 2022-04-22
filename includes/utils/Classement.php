<?php
    require 'Equipe.php';

	class Classement {

		public $equipes;
        
		function __construct($jsonEquipes) { 
            //Création d'un tableau de données
            $this->equipes = array();
            
            //boucle dans le JSON afin de récupérer une liste d'équipes
            foreach($jsonEquipes as $jsonEquipe){
                $equipe = new Equipe($jsonEquipe);
                array_push($this->equipes, $equipe);
            }
		}
	}
?>
