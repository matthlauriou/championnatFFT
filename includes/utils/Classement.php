<?php

    require 'Equipe.php';

	class Classement {

		public $equipes;
                

		function __construct($jsonEquipes) { 
            $this ->equipes = array() ;

            foreach($jsonEquipes as $jsonEquipe){
                //print_r($jsonEquipe);
                $equipe = new Equipe($jsonEquipe);
                array_push($this->equipes,$equipe);
                
            } 
            //print_r($jsonEquipes);
		}
	}
    /*
        public $list;
        //fonction constructeur 
        public function__construct(Equipe $Equipe){
            $this->list = $equipe;
        }
        //fonction pour ajouter une equipe a la liste
        public function add(Equipe $Equipe){
            $this->list[] = $$equipe;
        }
        //fonction pour retourner toute la collection
        public function all(){
            return $this->list;
        }
    }
    //creer une nouvelle collection d'equipes
    $listEquipe = new ListEquipe();
    //ajouter des nouvelles equipes a la collection
    $listEquipe->add(new Equipe());

    foreach($listEquipe->all() as $equipe){
        // boucler dans la collection    
    }*/
?>





