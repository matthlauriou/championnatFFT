<?php
  /*
  Plugin Name: Championnats FFT
  Plugin URI: https://tcgrandchamp.fr
  Description: Ce plugin permet d'alimenter le site automatiquement avec les resultats des championnats par equipes sans aller sur le site internet de Ten'Up
  Version: 0.1
  Author: TC-Grandchamp
  */

  define( 'PREFIX_BASE_PATH', plugin_dir_path( __FILE__ ) );
  include_once( PREFIX_BASE_PATH . 'includes/bdd/Requetes.php' );
  include_once( PREFIX_BASE_PATH . 'includes/utils/Rencontre.php' );
  include_once( PREFIX_BASE_PATH . 'includes/utils/Matchs.php' );
  include_once( PREFIX_BASE_PATH . 'includes/utils/Match.php' );
  include_once( PREFIX_BASE_PATH . 'includes/jobs/jobMajRencontres.php' );
  
  // Inclure champ-functions.php, utilise require_once pour arreter le deroulement du script si champ-functions.php n'est pas trouvé
  require_once plugin_dir_path(__FILE__).'includes/champ-functions.php';
  require_once plugin_dir_path(__FILE__).'includes/championnatShortcode.php';
  require_once plugin_dir_path(__FILE__).'includes/rencontresShortcode.php';
  require_once plugin_dir_path(__FILE__).'includes/jobs/jobMajRencontres.php';

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
        add_action('wp_enqueue_scripts', array(
            $this,
            'enqueueStyle'
        ));
      
      }
      
      // fonction pour la mise en attente des scripts
      function enqueueStyle()
      {
        //mise en attente des scripts exemple css js etc pour la lecture
        wp_enqueue_style( 'championnatFFTStyle', plugin_dir_url(__FILE__) . '/styles/championnatFFTStyle.css',array(), time(), false);
      }

      function dequeueStyle()
      {
        //mise en attente des scripts exemple css js etc pour la lecture
        wp_dequeue_style( 'championnatFFTStyle');
      }
      function registerPopup(){
        add_action('admin_enqueue_scripts',array(
          $this,
          'enqueuePopup'
        ));
      }
      function enqueuePopup($hook){
        if('edit.php'!=$hook){
          return;
        }
        wp_enqueue_style('championnatPopup',plugin_dir_url(__FILE__) .'/styles/championnatPopup.css');
        wp_enqueue_script('championnatPopupJs', get_template_directory_uri() .'/script/championnatPopupJs.js');
      }
      

      // Fonction d'installation du plugin Championnats
      function activationPlugin()
      {
        // Initialisation de la BDD
        global $wpdb;

        require plugin_dir_path(__FILE__).'includes/constantes/constantes.php';
        require plugin_dir_path(__FILE__).'includes/bdd/Init.php';

        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        $init = new Init($wpdb);

        dbDelta($init->creerTableEquipe());
        dbDelta($init->creerTableParametrage());
        dbDelta($init->creerTableHistorique());

        $init->insertParametrage($URL_POST);
        $init->insertParametrage($URL_FEUILLE_MATCH);
        $init->insertParametrage($ANNEE_SPORTIVE);

        // Initialisation des tâches CRON
        if(!wp_next_scheduled('chmptFFT_cron_hook')) {
          wp_schedule_event(time(), 'hourly', 'chmptFFT_cron_hook');
        }
      }
      
      // Fonction de désactivation du plugin Championnats
      function desactivationPlugin()
      {
        // Suppression de la BDD
        global $wpdb; 

        require plugin_dir_path(__FILE__).'includes/bdd/Uninstall.php';

        $uninstall = new Uninstall($wpdb);

        $uninstall->dropEquipe();
        $uninstall->dropParametrage();
        $uninstall->dropHistorique();

        // Désactivation des tâches CRON
        $timestamp = wp_next_scheduled( 'chmptFFT_cron_hook' );
        wp_unschedule_event( $timestamp, 'chmptFFT_cron_hook' );

        add_action('wp_enqueue_scripts',  array(
          $this,
          'dequeueStyle')
          , 100);
      }
  }


  // Verifier que la classe existe 
  if (class_exists('ChampionnatsPlugin')) {
    $championnatsPlugin = new ChampionnatsPlugin();
    $championnatsPlugin->register();
    $championnatsPlugin->registerPopup();
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