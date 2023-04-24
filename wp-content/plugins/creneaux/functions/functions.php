<?php

function getRootDir(): string {
    return dirname(__DIR__, 1);
}

function getMainViewContent() {
    return file_get_contents(getRootDir() . '/views/main.php');
}

function getPageViewContent() {
    return file_get_contents(getRootDir() . '/views/page.php');
}

function getPartialViewPath($file = ''): string {
    return getRootDir() . '/views/partial/' . $file;
}

function getAdminPartialViewPath($file = ''): string {
    return getRootDir() . '/views/admin/partial/' . $file;
}

function getCss() {
    return file_get_contents(getRootDir() . '/views/css/creneau.css');
}

function getPartialViewContent($file) {
    return file_get_contents(getPartialViewPath($file));
}

function getAdminPartialViewContent($file) {
    return file_get_contents(getAdminPartialViewPath($file));
}

function getUserFullName(): string {
    $user = wp_get_current_user();
    if (empty($user->first_name) && empty ($user->last_name)) {
        return $user->display_name;
    } else {
        $firstName = ucfirst(strtolower($user->first_name));
        $lastName = ucfirst(strtolower($user->last_name));
        return trim($firstName . ' ' . $lastName);
    }
}

function getNextCreneaux(): array {
    $next = [];
    $creneaux = getCreneaux();
    $prochaineSemaine = getProchaineSemaine();
    
    foreach ($creneaux as $c) {
        $today = new DateTime();
        if ($c->id_jour >= $today->format('w')) {
            $diff = $c->id_jour - $today->format('w');
        } else {
            $diff = 7 + ($c->id_jour - $today->format('w'));
        }
        $today->add(new DateInterval(sprintf('P%dD', $diff)));
        $next[$today->format('d/m/Y')] = $prochaineSemaine[$today->format('Y-m-d')] ?? new stdClass();
        $next[$today->format('d/m/Y')]->horaires = [
            'ouverture' => $c->heure_debut,
            'fermeture' => $c->heure_fin,
        ];
        $next[$today->format('d/m/Y')]->existe = true;
        
        if (empty($next[$today->format('d/m/Y')]->id_creneau)) {
            $next[$today->format('d/m/Y')]->id_creneau = $c->id;
            $next[$today->format('d/m/Y')]->jour = $today->format('Y-m-d');
            $next[$today->format('d/m/Y')]->existe = false;
        }
    }
    
    ksort($next);
    return $next;
}

function getJourParIndice($indiceJour): string {
    switch($indiceJour) {
        case 0: return 'Dimanche';
        case 1: return 'Lundi';
        case 2: return 'Mardi';
        case 3: return 'Mercredi';
        case 4: return 'Jeudi';
        case 5: return 'Vendredi';
        case 6: return 'Samedi';
        default: return '';
    }
}

// We need some CSS to position the paragraph.
function creneau_css() {
    echo '<style id="creneaux_css" type="text/css">'. getCss() . '</style>';
}

function ajouter_menu_gestion_creneau(){
    add_menu_page(
		'Gestion créneaux',
		'Gestion créneaux',
		'administrator',
		'creneaux/views/admin/gestion.php',
	);
}
