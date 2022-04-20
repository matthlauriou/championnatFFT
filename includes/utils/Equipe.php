<?php
	class Equipe {

		public string $nom;
        public int $place;
        public int $nbVictoire;
        public int $nbDefaite;
        public int $nombreMatchesGagnes;
        public int $nombreMatchesPerdus;
        public int $nombreSetsGagnes;
        public int $nombreSetsPerdus;
        public int $nombreJeuxGagnes;
        public int $nombreJeuxPerdus;

		function __construct($jsonEquipe) {

            $this->nom = $jsonEquipe["name"];
            /*$this->place = $jsonEquipe["classement"]["place"];
            $this->nbVictoire = $jsonEquipe["classement"]["victoires"];
            $this->nbDefaite = $jsonEquipe["classement"]["defaites"];
            $this->nombreMatchesGagnes = $jsonEquipe["classement"]["nombreMatchesGagnes"];
            $this->nombreMatchesPerdus = $jsonEquipe["classement"]["nombreMatchesPerdus"];
            $this->nombreSetsGagnes = $jsonEquipe["classement"]["nombreSetsGagnes"];
            $this->nombreSetsPerdus = $jsonEquipe["classement"]["nombreSetsPerdus"];
            $this->nombreJeuxGagnes = $jsonEquipe["classement"]["nombreJeuxGagnes"];
            $this->nombreJeuxPerdus = $jsonEquipe["classement"]["nombreJeuxPerdus"];
            */

            //mettre ne palce les opérations pour les différences
            

		}
	}
?>
