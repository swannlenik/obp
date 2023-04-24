<?php

function inserer_creneau_page() {
    $user = wp_get_current_user();
    
    if (false && in_array('administrator', $user->roles)) {
        creneauAdminHeader();
    }
    
    $contentPage = getPageViewContent();
    $contentTable = creerHtmlTablePage();
    
    return str_replace('{{contentPage}}', $contentTable, $contentPage);
}

function creerHtmlTablePage(): string {
    $creneaux = getNextCreneaux();
    $lignes = [];
    
    foreach ($creneaux as $date => $c) {
        $dt = new DateTime($c->jour);
        
        if (!empty($c->annule)) {
            $ligne = sprintf('<tr class="creer_creneau__table--line">
                <td class="creer_creneau__table--body-cell">
                    %s %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    De %s à %s
                </td>
                <td class="creer_creneau__table--body-cell cell--text-centered cell--text-alert" colspan="4">
                    Créneau annulé
                </td>
            </tr>',
                getJourParIndice($dt->format('w')),
                $date,
                $c->horaires['ouverture'],
                $c->horaires['fermeture']
            );

        } else {
            $ligne = sprintf(
            '<tr class="creer_creneau__table--line">
                <td class="creer_creneau__table--body-cell">
                    %s %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    De %s à %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    %s
                </td>
                <td class="creer_creneau__table--body-cell">
                    %s
                </td>
            </tr>',
                getJourParIndice($dt->format('w')),
                $date,
                $c->horaires['ouverture'],
                $c->horaires['fermeture'],
                $c->ouverture ?? '',
                $c->heure_ouverture ?? '',
                $c->fermeture ?? '',
                $c->heure_fermeture ?? ''
            );
        }
        $lignes[] = $ligne;
    }

    return implode('<br />', $lignes);
}