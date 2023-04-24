<?php
$currentUser = wp_get_current_user();


if (in_array('administrator', $currentUser->roles)) {
    include getAdminPartialViewPath('creerCreneau.php');
}