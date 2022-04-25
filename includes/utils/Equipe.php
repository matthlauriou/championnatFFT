<?php
	class Equipe {

		public string $nom;
        public int $place;
        public int $points;
        public int $nbVictoires;
        public int $nbDefaites;
        public int $diffNombreMatchs;
        public int $nombreMatchsGagnes;
        public int $nombreMatchsPerdus;
        public int $diffNombreSets;
        public int $nombreSetsGagnes;
        public int $nombreSetsPerdus;
        public int $diffNombreJeux;
        public int $nombreJeuxGagnes;
        public int $nombreJeuxPerdus;

		function __construct($jsonEquipe) {
            //Recupèrations des données concernant l'équipe
            if (isset($jsonEquipe["name"]) == 0){
                $this->nom = '-';
            } else {
                $this->nom = $jsonEquipe["name"];
            }
            
            // Descente d'un niveau pour récupérer les valeurs du championnat d'une équipe
            $jsonClassementEquipes = $jsonEquipe["classement"];

            if (isset($jsonClassementEquipes["place"]) == 0){
                $this->place = 0;
            } else {
            $this->place = $jsonClassementEquipes["place"];
            }

            if (isset($jsonClassementEquipes["points"]) == 0){
                $this->points = 0;
            } else {
                $this->points = $jsonClassementEquipes["points"];
            }

            if (isset($jsonClassementEquipes["victoires"]) == 0){
                $this->nbVictoires = 0;
            } else {
                $this->nbVictoires = $jsonClassementEquipes["victoires"];
            }

            if (isset($jsonClassementEquipes["defaites"]) == 0){
                $this->nbDefaites = 0;
            } else {
                $this->nbDefaites = $jsonClassementEquipes["defaites"];
            }

            if (isset($jsonClassementEquipes["nombreMatchesGagnes"]) == 0){
                $this->nombreMatchsGagnes = 0;
            } else {
                $this->nombreMatchsGagnes = $jsonClassementEquipes["nombreMatchesGagnes"];
            }

            if (isset($jsonClassementEquipes["nombreMatchesPerdus"]) == 0){
                $this->nombreMatchsPerdus = 0;
            } else {
                $this->nombreMatchsPerdus = $jsonClassementEquipes["nombreMatchesPerdus"];
            }

            if (isset($jsonClassementEquipes["nombreSetsGagnes"]) == 0){
                $this->nombreSetsGagnes = 0;
            } else {
                $this->nombreSetsGagnes = $jsonClassementEquipes["nombreSetsGagnes"];
            }

            if (isset($jsonClassementEquipes["nombreSetsPerdus"]) == 0){
                $this->nombreSetsPerdus = 0;
            } else {
                $this->nombreSetsPerdus = $jsonClassementEquipes["nombreSetsPerdus"];
            }

            if (isset($jsonClassementEquipes["nombreJeuxGagnes"]) == 0){
                $this->nombreJeuxGagnes = 0;
            } else {
                $this->nombreJeuxGagnes = $jsonClassementEquipes["nombreJeuxGagnes"];
            }

            if (isset($jsonClassementEquipes["nombreJeuxPerdus"]) == 0){
                $this->nombreJeuxPerdus = 0;
            } else {
                $this->nombreJeuxPerdus = $jsonClassementEquipes["nombreJeuxPerdus"];
            }
            
            //Calcul des diff pour l'affichage dans le tableau de classement
            $this->diffNombreMatchs = $this->nombreMatchsGagnes - $this->nombreMatchsPerdus;
            $this->diffNombreSets = $this->nombreSetsGagnes - $this->nombreSetsPerdus;
            $this->diffNombreJeux = $this->nombreJeuxGagnes - $this->nombreJeuxPerdus;
		}
	}
?>