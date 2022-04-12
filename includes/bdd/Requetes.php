<?php
	require 'Base.php';

	class Requetes extends Base {
		
		// Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
		}

		// TODO : commentaires ?
		function getAllParametrages() {
			return $this->wpdb->get_results("SELECT * FROM ". $this->TABLE_PARAMETRAGE);
		}

		// TODO : commentaires ?
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

		// TODO : commentaires ?
		function getEquipe($idEquipe) {
			return $this->wpdb->get_row("SELECT * FROM ". $this->TABLE_EQUIPE ." WHERE id = ".$idEquipe);
		}

		// TODO : commentaires ?
		function getAllEquipes() {
			return $this->wpdb->get_results("SELECT * FROM ". $this->TABLE_EQUIPE ." order by id desc");
		}

		// TODO1 : commentaires ?
		function insertEquipe($libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe) {
			return $this->wpdb->insert($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat ,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe));
		}

		// TODO : commentaires ?
		function updateEquipe($idEquipe, $libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe) {
			return $this->wpdb->update($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe), array('id' => $idEquipe), $format = null, $where_format = null);
		}

		// TODO : commentaires ?
		function deleteEquipe($idEquipe) {
			$this->wpdb->query("DELETE FROM " . $this->TABLE_EQUIPE . " WHERE id = " . $idEquipe);
		}
	}
?>