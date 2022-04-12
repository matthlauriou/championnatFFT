<?php
/*
Plugin Name: Championnats
Plugin URI: https://tcgrandchamp.fr/
Description: Ce plugin permet d'alimenter le site automatiquement avec les resultats des championnats par equipes sans aller sur le site internet de ten'up
Version: 1.0
Author: de Montgolfier Aurelie
*/

// TODO : Pas de franglish
// Include champ-functions.php, use require_once to stop the script if mfp-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/champ-functions.php';

defined('ABSPATH') or die('Hey, you can\t acces this file, you silly humain!!!');

// TODO : commentaires ?
class ChampionnatsPlugin
{
    // TODO : commentaires ?
    function __construct()
    {
       // TODO : commentaires ?
    }

    // TODO : commentaires ?
    function register()
    {
      add_action('admin_enqueue_scripts', array(
          $this,
          'enqueue'
      ));
    }
    
    // TODO : commentaires ?
    function enqueue()
    {
      //enqueue all our scripts
      wp_enqueue_style('mypluginstyle', plugins_url('/styles/style.css', __FILE__), array(
          ''
      ));
    }

    // Fonction d'installation du plugin Championnats
    function championnats_table()
    {
      require('constantes.php');
      require_once("initBDD.php");

      creerTableEquipe();
      creerTableParametrage();
      insertParametrage($URL_POST);
      insertParametrage($URL_FEUILLE_MATCH);
    }
    
    // TODO : commentaires ?
    function deactivate()
    {
      // TODO : Pas de franglish
      //flush rewrite rules
    }

    // Fonction de déinstallation du plugin Championnats
    function uninstall()
    {
      require_once("uninstallBDD.php");

      dropEquipe();
      dropParametrage();
    }    
}

// TODO : commentaires ?
if (class_exists('ChampionnatsPlugin')) {
  $championnatsPlugin = new ChampionnatsPlugin();
  $championnatsPlugin->register();
}

// TODO : A mieux commenter
//activation
register_activation_hook(__FILE__, array(
  $championnatsPlugin,
  'championnats_table'
));

// TODO : A mieux commenter
//deactivate
register_deactivation_hook(__FILE__, array(
  $championnatsPlugin,
  'deactivate'
));

// TODO : A mieux commenter
//uninstall
register_uninstall_hook(__FILE__, array(
  $championnatsPlugin,
  'uninstall'
));