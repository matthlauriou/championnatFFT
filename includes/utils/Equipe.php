<?php
	class Equipe {

		public string $nom;
        public int $place;
        public int $nbVictoires;
        public int $nbDefaites;
        public int $nombreMatchesGagnes;
        public int $nombreMatchesPerdus;
        public int $nombreSetsGagnes;
        public int $nombreSetsPerdus;
        public int $nombreJeuxGagnes;
        public int $nombreJeuxPerdus;

		function __construct($jsonEquipe) {

            //récupération des donnée est ok mais les paramêtre déclenches des erreurs 

            $this->nom = $jsonEquipe["name"];
            //print_r($this->nom);
            $classementEquipes = $jsonEquipe ["classement"];
            $this->place = $classementEquipes["place"];
            //print_r($this->place);
            if(isset($classementEquipes["victoires"]) == 0){
                $nbVictoires = 0;
            }else{
                $this->nbVictoires = $classementEquipes["victoires"];
                //print_r($this->nbVictoires);
            }
            if(isset($classementEquipes["defaites"]) == 0){
                $nbDefaites = 0;
            }else{
                $this->nbDefaites = $classementEquipes["defaites"];
                //print_r($this->nbDefaites);
            }
            if(isset($classementEquipes["nombreMatchesGagnes"])== 0){
                $nombreMatchesGagnes = 0;
            }else{
                $this->nombreMatchesGagnes = $classementEquipes["nombreMatchesGagnes"];
                //print_r($this->nombreMatchesGagnes);
            }
            if(isset($classementEquipes["nombreMatchesPerdus"])== 0){
                $nombreMatchesPerdus = 0;
            }else{
                $this->nombreMatchesPerdus = $classementEquipes["nombreMatchesPerdus"];
                //print_r($this->nombreMatchesPerdus);
            }
            if(isset($classementEquipes["nombreSetsGagnes"])== 0){
                $nombreSetsGagnes = 0;
            }else{
                $this->nombreSetsGagnes = $classementEquipes["nombreSetsGagnes"];
                //print_r($this->nombreSetsGagnes);
            }
            if(isset($classementEquipes["nombreSetsPerdus"])== 0){
                $nombreSetsPerdus = 0;
            }else{
                $this->nombreSetsPerdus = $classementEquipes["nombreSetsPerdus"];
                //print_r($this->nombreSetsPerdus);
            }
            if(isset($classementEquipes["nombreJeuxGagnes"])== 0){
                $nombreJeuxGagnes = 0;
            }else{
                $this->nombreJeuxGagnes = $classementEquipes["nombreJeuxGagnes"];
                //print_r($this->nombreJeuxGagnes);
            }
            if(isset($classementEquipes["nombreJeuxPerdus"])== 0){
                $nombreJeuxPerdus = 0;
            }else{
                $this->nombreJeuxPerdus = $classementEquipes["nombreJeuxPerdus"];
                //print_r($this->nombreJeuxPerdus);
            }
            
            //mettre ne place les opérations pour les différences 
            /*
            pour chaque equipe 
            $nombreMatches = $nombreMatchesGagnes - $nombreMatchesPerdus;
            $nombreSets = $nombreSetsGagnes - $nombreSetsPerdus;
            $nombreJeux = $nombreJeuxGagnes - $nombreJeuxPerdus;
            */    
		}
	}
?>
