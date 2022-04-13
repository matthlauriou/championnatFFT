<?php
	require 'Base.php';

	class Requetes extends Base {
		
		// Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
		}

		// fonction permettant de recupérer toutes les valeurs enregistrer dans la table Parametrage en base de donnée
		function getAllParametrages() {
			return $this->wpdb->get_results("SELECT * FROM ". $this->TABLE_PARAMETRAGE);
		}

		// fonction permettant de modifier les valeurs enregistrer dans la table Parametrage en base de donnée en fonction de si la valeur est différente
		function updateTableParametrage($cle, $valeur) {
			$retour = false;
			$ligne = $this->wpdb->get_row("SELECT * FROM ". $this->TABLE_PARAMETRAGE ." WHERE cle = '".$cle."'");

			// Si la nouvelle valeur est différente de la valeur en BDD, on provoque la mise à jours de la BDD sinon, on sort de la fonction
			if(strcmp($ligne->valeur, $valeur) !== 0) {
				$retour = $this->wpdb->update($this->TABLE_PARAMETRAGE, array('valeur'=> $valeur), array('cle' => $cle), $format = null, $where_format = null);
			} else {
				$retour = true;
			}
			return $retour;
		}

		//fonction permettant de recupérer les valeurs d'une Equipe enregistrer dans la table Equipe en base de donnée en fonction de son id
		function getEquipe($idEquipe) {
			return $this->wpdb->get_row("SELECT * FROM ". $this->TABLE_EQUIPE ." WHERE id = ".$idEquipe);
		}

		//fonction permettant de recupérer toutes les valeurs des Equipes enregistrer dans la table Equipe en base de donnée
		function getAllEquipes() {
			return $this->wpdb->get_results("SELECT * FROM ". $this->TABLE_EQUIPE ." order by id desc");
		}

		// fonction permettant de recupérercréer une equipe dans la table Equipe en base de donnée
		function insertEquipe($libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe) {
			return $this->wpdb->insert($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat ,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe));
		}

		// fonction permettant de modifier les valeurs enregistrer pour une Equipe dans la table Equipe en base de donnée en verifiant que la valeur est différente de celle présente en BDD, si oui la misa a jour a lieu sinon on sort de la fonction
		function updateEquipe($idEquipe, $libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe) {
			return $this->wpdb->update($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe), array('id' => $idEquipe), $format = null, $where_format = null);
		}

		// fonction permettant de supprimer une équipe avec toutes ces valeurs en base de données grace à son id
		function deleteEquipe($idEquipe) {
			$this->wpdb->query("DELETE FROM " . $this->TABLE_EQUIPE . " WHERE id = " . $idEquipe);
		}
	}
?>