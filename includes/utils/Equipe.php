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
            /*
            $this->nbVictoires = $classementEquipes["victoires"];
            //print_r($this->victoires);
            $this->nbDefaites = $classementEquipes["defaites"];//fait planter pcq  Undefined index: defaites Equipe::$defaites must be int, null used
            //print_r($this->defaites);
            $this->nombreMatchesGagnes = $classementEquipes["nombreMatchesGagnes"];
            //print_r($this->nombreMatchesGagnes);
            $this->nombreMatchesPerdus = $classementEquipes["nombreMatchesPerdus"];
            //print_r($this->nombreMatchesPerdus);
            $this->nombreSetsGagnes = $classementEquipes["nombreSetsGagnes"];
            //print_r($this->nombreSetsGagnes);
            $this->nombreSetsPerdus = $classementEquipes["nombreSetsPerdus"];
            //print_r($this->nombreSetsPerdus);
            $this->nombreJeuxGagnes = $classementEquipes["nombreJeuxGagnes"];
            //print_r($this->nombreJeuxGagnes);
            $this->nombreJeuxPerdus = $classementEquipes["nombreJeuxPerdus"];
            //print_r($this->nombreJeuxPerdus);
            */

            //mettre ne place les opérations pour les différences 
            /*
            $nombreMatches = $nombreMatchesGagnes - $nombreMatchesPerdus;
            $nombreSets = $nombreSetsGagnes - $nombreSetsPerdus;
            $nombreJeux = $nombreJeuxGagnes - $nombreJeuxPerdus;
            */


            

		}
	}
?>
