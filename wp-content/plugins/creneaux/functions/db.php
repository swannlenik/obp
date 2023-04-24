<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

function getProchainCreneau(): ?object {
    global $wpdb;
    $today = new DateTime();
    $prochainCreneauSQL = sprintf('SELECT * FROM %souverture WHERE jour >= "%s" LIMIT 1', $wpdb->prefix, $today->format('Y-m-d'));
    $prochainCreneau = $wpdb->get_results($prochainCreneauSQL);
    
    return $prochainCreneau[0] ?? null;
}

function getProchaineSemaine(): array {
    global $wpdb;
    $today = new DateTime();
    $results = [];
    $prochaineSemaineSQL = sprintf('SELECT * FROM %souverture WHERE jour BETWEEN "%s" AND "%s"',
        $wpdb->prefix,
        $today->format('Y-m-d'),
        $today->add(new DateInterval('P6D'))->format('Y-m-d')
    );
    $prochaineSemaine = $wpdb->get_results($prochaineSemaineSQL);
    
    if (!empty($prochaineSemaine)) {
        foreach ($prochaineSemaine as $c) {
            $results[$c->jour] = $c;
        }
        return $results;
    }
    return [];
}

function getCreneaux() {
     global $wpdb;
    $creneauxSQL = sprintf('SELECT * FROM %screneaux ORDER BY id_jour ASC', $wpdb->prefix);
    $creneaux = $wpdb->get_results($creneauxSQL);
    
    return $creneaux ?? [];   
}

function inserer_creneau() {
    global $wpdb;
    
    if (empty($_POST['existe'])) {
        $wpdb->insert($wpdb->prefix . 'ouverture',
            [
                'id_creneau' => $_POST['id_creneau'],
                'jour' => $_POST['jour'],
                'ouverture' => $_POST['ouverture'] ?? '',
                'heure_ouverture' => $_POST['heure_ouverture'] ?? '',
                'fermeture' => $_POST['fermeture'] ?? '',
                'heure_fermeture' => $_POST['heure_fermeture'] ?? '',
            ], 
            ['%d', '%s', '%s', '%s', '%s', '%s'],
        );
    } else {
        if (isset($_POST['ouverture'])) {
            $wpdb->update($wpdb->prefix . 'ouverture',
                ['ouverture' => $_POST['ouverture'] ?? '', 'heure_ouverture' => $_POST['heure_ouverture'] ?? ''], 
                ['id' => $_POST['id']],
                ['%s', '%s'],
                ['%d'],  
            );
        } elseif (isset($_POST['fermeture'])) {
            $wpdb->update($wpdb->prefix . 'ouverture',
                ['fermeture' => $_POST['fermeture'] ?? '', 'heure_fermeture' => $_POST['heure_fermeture'] ?? ''], 
                ['id' => $_POST['id']],
                ['%s', '%s'],
                ['%d'],  
            );
        }
    }
    wp_redirect(wp_get_referer());
}

function maj_fermeture_creneau() {
    global $wpdb;
    $sqlAjoutFermeture = sprintf(
        'UPDATE %souverture SET fermeture = \'%s\', heure_fermeture = \'%s\' WHERE id = %d',
        $wpdb->prefix,
        getUserFullName(),
        $_POST['heure_fermeture'],
        $_POST['id_creneau']
    );
    $wpdb->query($sqlAjoutFermeture);
    wp_redirect(wp_get_referer());
}

function maj_ouverture_creneau() {
    global $wpdb;
    $sqlAjoutOuverture = sprintf(
        'UPDATE %souverture SET ouverture = \'%s\', heure_ouverture=\'%s\' WHERE id = %d',
        $wpdb->prefix,
        getUserFullName(),
        $_POST['heure_ouverture'],
        $_POST['id_creneau']
    );
    $wpdb->query($sqlAjoutOuverture);
    wp_redirect(wp_get_referer());
}

function supprimer_de_creneau() {
    global $wpdb;
    $sqlAjoutOuverture = sprintf(
        'UPDATE %souverture SET %s = null WHERE id = %d',
        $wpdb->prefix,
        $_POST['type'],
        $_POST['id_creneau']
    );
    $wpdb->query($sqlAjoutOuverture);
    wp_redirect(wp_get_referer());
}

function annuler_creneau() {
    global $wpdb;

    if (!empty($_POST['id']) && $_POST['id'] > 0) {
        $sqlAnnulerCreneau = sprintf(
            'UPDATE %souverture SET annule = %d WHERE id = %d',
            $wpdb->prefix,
            $_POST['annule'],
            $_POST['id']
        );
    } else {
        $sqlAnnulerCreneau = sprintf('INSERT INTO %souverture (`id_creneau`, `jour`, `annule`) VALUES (%d, \'%s\', %d)',
            $wpdb->prefix,
            $_POST['id_creneau'],
            $_POST['jour'],
            $_POST['annule']
        );
    }
    $wpdb->query($sqlAnnulerCreneau);
    wp_redirect(wp_get_referer());
}
