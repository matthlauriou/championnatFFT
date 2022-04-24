<?php
	require_once 'Base.php';

	class Requetes extends Base {
		
		// Constructeur par défaut avec l'appel de l'héritage
		function __construct($wpdb) {
			parent::__construct($wpdb);
		}

		// fonction permettant de recupérer la valeur de l'url de récupération
		function getParametrageUrlPost() {
			require PREFIX_BASE_PATH.'includes/constantes/constantes.php';
			return $this->wpdb->get_row("SELECT valeur FROM $this->TABLE_PARAMETRAGE WHERE cle = '$URL_POST'");
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

		//fonction permettant de recupérer toutes les valeurs des Equipes enregistrer dans la table Equipe en base de donnée sur l'année sportive en cours
		function getAllEquipesSaisonEnCours() {
			require PREFIX_BASE_PATH.'includes/constantes/constantes.php';
			return $this->wpdb->get_results("SELECT * FROM $this->TABLE_EQUIPE as equipe WHERE equipe.annee 
				in (SELECT param.valeur FROM $this->TABLE_PARAMETRAGE as param WHERE param.cle = '$ANNEE_SPORTIVE')");
		}

		// fonction permettant de recupérercréer une equipe dans la table Equipe en base de donnée
		function insertEquipe($libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe, $lienPage) {
			return $this->wpdb->insert($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat ,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe,'lien_page'=>$lienPage));
		}

		// fonction permettant de modifier les valeurs enregistrer pour une Equipe dans la table Equipe en base de donnée en verifiant que la valeur est différente de celle présente en BDD, si oui la misa a jour a lieu sinon on sort de la fonction
		function updateEquipe($idEquipe, $libelle, $annee, $numeroChampionnat, $divisionChampionnat, $phaseChampionnat, $pouleChampionnat, $numeroEquipe, $lienPage) {
			return $this->wpdb->update($this->TABLE_EQUIPE, array('libelle'=>$libelle,'annee'=>$annee,'numero_championnat'=>$numeroChampionnat,
				'division_championnat'=>$divisionChampionnat,'phase_championnat'=>$phaseChampionnat,'poule_championnat'=>$pouleChampionnat,
				'numero_equipe'=>$numeroEquipe,'lien_page'=>$lienPage), array('id' => $idEquipe), $format = null, $where_format = null);
		}

		// fonction permettant de supprimer une équipe avec toutes ces valeurs en base de données grace à son id
		function deleteEquipe($idEquipe) {
			$this->wpdb->query("DELETE FROM " . $this->TABLE_EQUIPE . " WHERE id = " . $idEquipe);
		}

		// Fonction permettant de vider la table historique
		function viderHistorique() {
			$sql = "DELETE FROM $this->TABLE_HISTORIQUE";
			$this->wpdb->query($sql);
			// Reinitilisation de l'auto-increment de la Primary Key à 1
			//$sql = "ALTER TABLE $this->TABLE_HISTORIQUE AUTO_INCREMENT = 1";
			//$this->wpdb->query($sql);
		}

		// Fonction permettant d'ajouter une nouvelle entrée dans la table historique
		function insertHistorique($libelleEquipe, $dateRencontre, $resultat, $score, $lienPage) {
			return $this->wpdb->insert($this->TABLE_HISTORIQUE, array('libelle_equipe'=>$libelleEquipe,
				'date_rencontre'=>$dateRencontre,'resultat'=>$resultat,'score'=>$score,'lien_page'=>$lienPage));
		}

		// Fonction permettant de récupérer toutes les données de la table historique
		function getAllHistorique() {
			return $this->wpdb->get_results("SELECT * FROM ". $this->TABLE_HISTORIQUE);
		}
	}
?>