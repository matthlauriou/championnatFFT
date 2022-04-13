<?php
  
  // Ajout d'un menu dans le dashboard administration
  function championnats_menu() {
    add_menu_page("Championnats Options", "Championnats","manage_options", "championnats", "affichageListeEquipe", plugins_url('/championnatFFT/img/TCicon.png'));
    add_submenu_page("championnats","Liste Equipe", "Liste Equipe","manage_options", "listequipe", "affichageListeEquipe");
    add_submenu_page("championnats","Creation", "Création","manage_options", "gestionEquipe", "gestionEquipe");
    add_submenu_page("championnats","Parametrage", "Paramétrage","manage_options", "parametrage", "parametrage");
  }

  
  // Appeler la fonction 'championnats_menu()'et la réaliser
  add_action( 'admin_menu', 'championnats_menu' );

  //fonction pour rediriger vers la page d'affichage de la liste des équipes
  function affichageListeEquipe() {
  	include "affichageListeEquipe.php";
  }

  //fonction pour rediriger vers la page de gestion des équipes
  function gestionEquipe() {
  	include "gestionEquipe.php";
  }

  //fonction pour rediriger vers la page de paramétrage
  function parametrage() {
    include "parametrage.php";
  }
?>