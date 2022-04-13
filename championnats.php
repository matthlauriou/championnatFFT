<?php
  /*
  Plugin Name: Championnats FFT
  Plugin URI: https://tcgrandchamp.fr
  Description: Ce plugin permet d'alimenter le site automatiquement avec les resultats des championnats par equipes sans aller sur le site internet de Ten'Up
  Version: 0.1
  Author: TC-Grandchamp
  */

  
  // Inclure champ-functions.php, utilise require_once pour arreter le deroulement du script si champ-functions.php n'est pas trouvé
  require_once plugin_dir_path(__FILE__).'includes/champ-functions.php';

  defined('ABSPATH') or die('Hey, you can\t access this file, you silly humain!!!');

  //Classe php dans l'object de respecter la Programmation Orienté Objet
  class ChampionnatsPlugin
  {
      //fonction générale de la classe
      function __construct()
      {
        //règles à appliquer de manières générale
      }

      // lecture des scripts mis en file d'attente
      function register()
      {
        add_action('admin_enqueue_scripts', array(
            $this,
            'enqueue'
        ));
      }
      
      // fonction pour la mise en attente des scripts
      function enqueue()
      {
        //mise en attente des scripts exemple css js etc pour la lecture
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

  //verifier que la classe existe 
  if (class_exists('ChampionnatsPlugin')) {
    $championnatsPlugin = new ChampionnatsPlugin();
    $championnatsPlugin->register();
  }

  // Appel de la fonction d'activationPlugin et réalisation des actions associées
  
  register_activation_hook(__FILE__, array(
    $championnatsPlugin,
    'activationPlugin'
  ));

  // Appel de la fonction de desactivationPlugin et réalisation des actions associées
  
  register_deactivation_hook(__FILE__, array(
    $championnatsPlugin,
    'desactivationPlugin'
  ));

?>