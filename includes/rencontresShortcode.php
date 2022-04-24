<?php
    
    // Fonction qui s'applique quand le shortcode est activé 
    function rencontresFFT_resultats() { 

        require_once plugin_dir_path(__FILE__).'/bdd/Requetes.php';
        require_once plugin_dir_path(__FILE__).'/utils/Rencontre.php';
        require_once plugin_dir_path(__FILE__).'/constantes/constantes.php';

        // 1 - Récupérer données de la BDD
        global $wpdb;
        $requetes = new Requetes($wpdb);

        $rencontresBDD = $requetes->getAllHistorique();

        // 2 - Préparation de l'affichage HTML
        $affichageHTML = "<ul>";

        if(sizeof($rencontresBDD) > 0) {
            
            foreach($rencontresBDD as $rencontre) {
                $url = $URL_TC_GRANDCHAMP.$rencontre->lien_page;

                $affichageHTML = $affichageHTML
                    ."<li><a href=\"".$url."\" target=\"_self\">".$rencontre->date_rencontre
                    ." : ".$rencontre->libelle_equipe
                    ."<br/>".$rencontre->resultat." : ".$rencontre->score
                    ."</a></li>";
            }
            
        } else {
            $affichageHTML = $affichageHTML."<li>Les matchs arrivent bientôt</li>";
        }

        $affichageHTML = $affichageHTML."</ul>";

        return $affichageHTML;
    }

    // ajouter shortcode
    add_shortcode('rencontresFFT', 'rencontresFFT_resultats');

?>