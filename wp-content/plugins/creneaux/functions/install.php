<?php

function install_creneaux() {
    	global $wpdb;

	$tableCreneaux = $wpdb->prefix . 'creneaux';
        $tableOuverture = $wpdb->prefix . 'ouverture';
	
	$charsetCollate = $wpdb->get_charset_collate();

	$sqlCreneaux = "CREATE TABLE $tableCreneaux (
		id int(10) NOT NULL AUTO_INCREMENT,
		jour_creneau VARCHAR(10),
		id_jour int(10) NOT NULL,
		heure_debut VARCHAR(5),
                heure_fin VARCHAR(5),
		PRIMARY KEY  (id)
	) $charsetCollate;";

	$sqlOuverture = "CREATE TABLE $tableOuverture (
		id int(10) NOT NULL AUTO_INCREMENT,
		id_creneau int(10) NOT NULL,
		jour DATE,
                ouverture VARCHAR(64),
                heure_ouverture VARCHAR(5),
                fermeture VARCHAR(64),
                heure_fermeture VARCHAR(5),
                annule TINYINT(1),
		PRIMARY KEY  (id)
	) $charsetCollate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta($sqlCreneaux);
        dbDelta($sqlOuverture);


}