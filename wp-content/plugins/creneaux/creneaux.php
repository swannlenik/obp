<?php
/**
 * @package Creneaux-OBP
 * @version 1.1.0
 */
/*
Plugin Name: Ouverture des Créneaux
Plugin URI: http://oympic-pdb.fr
Description: Sélectionner qui ouvre/ferme les créneaux de l'OBP
Author: Swann Lenik
Version: 1.1.0
Author URI: http://olympic-pdb.fr
*/

global $wpdb;

require __DIR__ . '/functions/functions.php';
require __DIR__ . '/functions/install.php';
require __DIR__ . '/functions/page.php';
require __DIR__ . '/functions/db.php';

function creneauAdminHeader() {
    $pc = getProchainCreneau();
    if (!empty($pc)) {
        $dt = DateTime::createFromFormat('Y-m-d', $pc->jour);

        $mainContent = getMainViewContent();
        if (!empty($dt)) {
            $partialContent = getPartialViewContent('prochain.php');
            $partialContent = str_replace([
                '{{titre_creneau}}',
                '{{ouverture_creneau}}',
                '{{fermeture_creneau}}'
            ], [
                sprintf('Créneau du %s', $dt ? $dt->format('d/m/Y') : ''),
                empty($pc->ouverture) ? ouvrirGymnase($pc) : supprimer($pc, 'ouverture'),
                empty($pc->fermeture) ? fermerGymnase($pc) : supprimer($pc, 'fermeture'),
            ], $partialContent);
        } else {
            $partialContent = getPartialViewContent('vide.php');
        }

        $mainContent = str_replace('{{main_content}}', $partialContent, $mainContent);
    } else {
        $mainContent = '';
    }
    echo $mainContent;
}

function supprimer($pc, $type) {
    $nom = $pc->$type;
    if ($nom === getUserFullName()) {
        return str_replace(
        ['{{id}}', '{{action}}', '{{type}}', '{{type_string}}'], 
        [$pc->id, admin_url('admin-post.php'), $type, $type === 'ouverture' ? 'J\'ouvre' : 'Je ferme'],
        getPartialViewContent('supprimer.php')
    );

    } else {
        return ($type === 'ouverture' ? 'Ouvert' : 'Fermé') . ' par ' . $nom;
    }
}

function ouvrirGymnase($creneau) {
    return str_replace(
        ['{{id}}', '{{action}}'], 
        [$creneau->id, admin_url('admin-post.php')],
        getPartialViewContent('ouverture.php')
    );
}

function fermerGymnase($creneau) {
    return str_replace(
        ['{{id}}', '{{action}}'], 
        [$creneau->id, admin_url('admin-post.php')],
        getPartialViewContent('fermeture.php')
    );
}

/*
 * Actions
 */
//add_action('admin_notices', 'creneauAdminHeader');
add_action('admin_head', 'creneau_css');
add_action('wp_head', 'creneau_css');
add_action('admin_post_maj_ouverture_creneau', 'maj_ouverture_creneau');
add_action('admin_post_maj_fermeture_creneau', 'maj_fermeture_creneau');
add_action('admin_post_inserer_creneau', 'inserer_creneau');
add_action('admin_post_annuler_creneau', 'annuler_creneau');
add_action('admin_post_supprimer_de_creneau', 'supprimer_de_creneau');
add_action('admin_menu', 'ajouter_menu_gestion_creneau');

// Install
register_activation_hook( __FILE__, 'install_creneaux' );

/* 
 * Page du site
 * 
 * Pour ajouter le tableau d'ouverture dans une page:
 *   - éditer la page
 *   - ajouter le morceau de code `[action_page_creneaux]` à l'emplacement souhaité
 *   - Dans notre cas, ce sera sur la page "Les créneaux"
 */
add_shortcode('action_page_creneaux', 'inserer_creneau_page');
