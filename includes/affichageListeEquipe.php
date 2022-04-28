<?php
	global $wpdb;
	require_once plugin_dir_path(__FILE__).'/bdd/Requetes.php';
	
	
	// supprimer un enregistrement
	// Variables globales de la zone d'information
	$zoneInformation = true;
	$message = "";

	// Vérification du queryParam "action" qu'il soit bien valorisé dans le chemin d'accès
	if (isset($_GET["action"])) {
		// Désactivation de la zone d'information
		$zoneInformation = false;
		print_r($_GET);

		// Vérification si nous sommes dans une action de création d'équipe
		if (strcmp($_GET["action"], $SUPPRIMER) == 0) {	
			$idEquipe = $_GET['idEquipe'];
			
			deleteEquipe($idEquipe);
		} else {
			// L'action souhaitée n'existe pas, on remonte une erreur
			$zoneInformation = true;
			$message = "L'action ".$_GET["action"]." demandée est impossible";
		}
	}else {
		// La variable "action" n'est pas initialisée, on lève une erreur
		$zoneInformation = true;
		$message = "L'action non valorisée";
	}

	echo "<h1>Liste des équipes</h1>

		<div class=\"wrap\">
			<button  type=\"button\" class=\"btn btn-light btn-lg\" id=\"listeEquipe\" name=\"listeEquipe\"><a href=\"?page=listequipe\">Liste des équipes</a></button>
			<button  type=\"button\" class=\"btn btn-light btn-lg\" id=\"parametrage\" name=\"parametrage\"><a href=\"?page=parametrage\">Paramétrage</a></button>
			<button  type=\"button\" class=\"btn btn-light btn-lg\" id=\"creationEquipe\" name=\"creationEquipe\"><a href=\"?page=gestionEquipe&action=creer\">+</a></button>
		</div>

		<br/>

		<table>
			<thead>
				<tr>
					<th>Shortcode</th>
					<th>Annee Sportive</th>
					<th>Libelle équipe</th>
					<th>Détails</th>
					<th>Slug Page</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>";

	$requetes = new Requetes($wpdb);
	// Récupération de l'ensemble des equipes
	$listeEquipes = $requetes->getAllEquipes($wpdb);
	if (count($listeEquipes) > 0) {
		// Si on a au moins 1 équipe, on affiche l'ensemble des équipes dans un tableau
	    foreach ($listeEquipes as $equipe) {
	        $id                   = $equipe->id;
	        $annee                = $equipe->annee;
	        $libelle              = $equipe->libelle;
	        $numero_championnat   = $equipe->numero_championnat;
	        $division_championnat = $equipe->division_championnat;
	        $phase_championnat    = $equipe->phase_championnat;
	        $poule_championnat    = $equipe->poule_championnat;
	        $numero_equipe        = $equipe->numero_equipe;
			$lien_page       	 = $equipe->lien_page;
	        
	        echo "<tr>
	                <td>[championnatFFT id='$id']</td>
	                <td>$annee</td>
	                <td>$libelle</td>
	                <td> Numero championnat : $numero_championnat<br/> 
						Division : $division_championnat<br/> 
						Phase : $phase_championnat<br/> 
						Poule : $poule_championnat<br/> 
						Equipe : $numero_equipe</td>
					<td>$lien_page</td>
	                <td><a href='?page=gestionEquipe&action=modifier&idEquipe=$id' name='sub_modifier'>Modifier</a></td>
	                <td>
					
					<button id='myBtn' class='openModal' oncClick='openModal($id)'>supprimer</button>
						<div id='myModal' class='modal'>
							<div class='modalContent'>
								<span class='close'>×</span>
								<p>Etes vous sur de vouloir supprimer l'équipe $id ?</p>
								<button class='del' onclick='supprimerEquipe($id)'>Supprimer l'équipe</button>
								<button class='cancel' onclick='hideModal()'>Annuler</button>
							</div>
						</div>	
	                </td>
	            </tr>
	            ";    
	    }
	} else {
	    echo "<tr><td>Aucun résultats trouvés</td></tr>";
	}
	echo "</tbody>
	</table>
	<style>
	.modal {
		text-align: center;
		display: none;
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.4);
	}
	.modalContent {
		font-size: 20px;
		font-weight: bold;
		background-color: #e3e3e5;
		margin: auto;
		padding: 20px;
		border: 1px solid #888;
		width: 80%;
	}
	.close {
		color: #b2261d;
		float: right;
		font-size: 40px;
		font-weight: bold;
	}
	.close:hover, .close:focus {
		color: #ef952e;
		cursor: pointer;
	}
	.modalContent button {
		border: none;
		border-radius: 4px;
		font-size: 18px;
		font-weight: bold;
		padding: 10px;
	}
	.del {
		color: #e3e3e5;
		background-color: #71757e;
	}
	.del:hover {
		color: #e3e3e5;
		background-color: #1c2230;
	}
	.cancel {
		color: #e3e3e5;
		background-color: #71757e;
	}
	.cancel:hover {
		color: #e3e3e5;
		background-color: #1c2230;
	}
	</style><script>
	var modal = document.getElementById('myModal');
	var btn = document.getElementById('myBtn');
	var span = document.getElementsByClassName('close')[0];

	btn.onclick = function() {
		modal.style.display = 'block';
	}
	span.onclick = function() {
		hideModal();
	}
	function openModal(id) {
		var id = openModal.arguments[0];
	}
	function supprimerEquipe(id) {
		location.replace('?page=gestionEquipe&action=supprimer&idEquipe=$id');
	}
	function hideModal() {
		modal.style.display = 'none';
	}
	
	window.onclick = function(event) {
		if (event.target == modal) {
			hideModal();
		}
	}
	</script>";
	//charger script championnatPopup.js et le style championnatPopup.css
?>