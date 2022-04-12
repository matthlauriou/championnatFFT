<?php
	require_once("requetesBDD.php");

	// TODO 1 : Cela veut dire que si tu as ?page=...&action= tu peux supprimer. Il faut impérativement tester la valeur de $_GET["action"] à savoir si tu es bien dans une action de suppression et que $_GET['idEquipe'] est "isset" et que $_GET['idEquipe'] est valorisé et que $_GET['idEquipe'] existe en BDD sinon on pourrait supprimer une équipe 999999 qui n'existe pas (soit tu t'ouvres un genre de DELETE IF EXISTS avec l'idEquipe ou sinon tu fais un select * .... et tu vérifies que tu n'as bien qu'une seule occurence de cet id)
	// TODO 2 : une autre problématique se pose ici, tu fais un refresh de l'url, tu vas essayé à nouveau de supprimer cette même équipe. Il vaut mieux que tu passes par un $_POST que tu valorises à null afin d'éviter une action de refresh.
	// supprimer un enregistrement
	if (isset($_GET["action"])) {
	    $idEquipe = $_GET['idEquipe'];
	    deleteEquipe($idEquipe);
	}

?>

<h1>Liste des équipes</h1>

<div class="wrap">
    <button  type="button" class="btn btn-light btn-lg" id="listeEquipe" name="listeEquipe"><a href="?page=listequipe">Liste des équipes</a></button>
    <button  type="button" class="btn btn-light btn-lg" id="parametrage" name="parametrage"><a href="?page=parametrage">Paramétrage</a></button>
    <button  type="button" class="btn btn-light btn-lg" id="creationEquipe" name="creationEquipe"><a href="?page=gestionEquipe&action=creer">+</a></button>
</div>

<br/>

<!-- TODO : ajouter du CSS dans du HTML est une mauvaise pratique, le CSS doit être dans des fichiers .css en passant par des classes CSS comme les boutons au dessus -->
<table width='100%' border='1' style='border-collapse: collapse;'>
    <tr>
        <th>id</th>
        <th>Annee Sportive</th>
        <th>Libelle équipe</th>
        <th>Détails</th>
        <th>&nbsp;</th>
    </tr>

<?php

	// Récupération de l'ensemble des equipes
	$listeEquipes = getAllEquipes();
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
	        
	        echo "<tr>
	                <td>" . $id . "</td>
	                <td>" . $annee . "</td>
	                <td>" . $libelle . "</td>
	                <td> Numero championnat : " . $numero_championnat . "<br/> Division : " . $division_championnat . "<br/> Phase : " . $phase_championnat . "<br/> Poule : " . $poule_championnat . "<br/> Equipe : " . $numero_equipe . "</td>
	                <td><a href='?page=gestionEquipe&action=modifier&idEquipe=" . $id . "' name='sub_modifier'>Modifier</a>
	                <br/>
	                <a href='?page=affichageListeEquipe&supprimer=" . $id . "' name='sub_supprimer'>Supprimer</a>
	                </td>
	            </tr>
	            ";
	        
	    }
	} else {
	    echo "<tr><td colspan='5'>Aucun résultats trouvés</td></tr>";
	}

?>
</table>