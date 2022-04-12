<?php
  /*
  Plugin Name: Championnats FFT
  Plugin URI: https://tcgrandchamp.fr
  Description: Ce plugin permet d'alimenter le site automatiquement avec les resultats des championnats par equipes sans aller sur le site internet de Ten'Up
  Version: 0.1
  Author: TC-Grandchamp
  */

  // TODO : Pas de franglish
  // Include champ-functions.php, use require_once to stop the script if mfp-functions.php is not found
  require_once plugin_dir_path(__FILE__).'includes/champ-functions.php';

  defined('ABSPATH') or die('Hey, you can\t access this file, you silly humain!!!');

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
      function activationPlugin()
      {
        global $wpdb;

        require plugin_dir_path(__FILE__).'includes/constantes/constantes.php';
        require plugin_dir_path(__FILE__).'includes/bdd/Init.php';

        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        $init = new Init($wpdb);

        dbDelta($init->creerTableEquipe());
        dbDelta($init->creerTableParametrage());

        $init->insertParametrage($URL_POST);
        $init->insertParametrage($URL_FEUILLE_MATCH);
      }
      
      // Fonction de désactivation du plugin Championnats
      function desactivationPlugin()
      {
        global $wpdb; 

        require plugin_dir_path(__FILE__).'includes/bdd/Uninstall.php';

        $uninstall = new Uninstall($wpdb);

        $uninstall->dropEquipe();
        $uninstall->dropParametrage();
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
    'activationPlugin'
  ));

  // TODO : A mieux commenter
  //deactivate
  register_deactivation_hook(__FILE__, array(
    $championnatsPlugin,
    'desactivationPlugin'
  ));

?>