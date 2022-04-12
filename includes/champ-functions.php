<?php
  // TODO : Pas de franglish
  // Add a new top level menu link to the ACP
  function championnats_menu() {
    add_menu_page("Championnats Options", "Championnats","manage_options", "championnats", "affichageListeEquipe", plugins_url('/championnats/img/TCicon.png'));
    add_submenu_page("championnats","Liste Equipe", "Liste Equipe","manage_options", "listequipe", "affichageListeEquipe");
    add_submenu_page("championnats","Creation", "Création","manage_options", "gestionEquipe", "gestionEquipe");
    add_submenu_page("championnats","Parametrage", "Paramétrage","manage_options", "parametrage", "parametrage");
  }

  // TODO : Pas de franglish
  // Hook the 'admin_menu' action hook, run the function named 'championnats_menu()'
  add_action( 'admin_menu', 'championnats_menu' );

  // TODO : commentaires ?
  function affichageListeEquipe() {
  	include "affichageListeEquipe.php";
  }

  // TODO : commentaires ?
  function gestionEquipe() {
  	include "gestionEquipe.php";
  }

  // TODO : commentaires ?
  function parametrage() {
    include "parametrage.php";
  }