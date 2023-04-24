<?php
$creneaux = getNextCreneaux();
?>

<div class="creer-creneau__div is-style-wide">
    <h1 class="creer-creneau__h1">Créneaux des 7 prochains jours</h1>
    <table class="creer-creneau__table">
        <thead>
            <tr class="creer_creneau__table--line">
                <th class="creer_creneau__table--header-cell">Créneau</th>
                <th class="creer_creneau__table--header-cell">Horaires</th>
                <th class="creer_creneau__table--header-cell">Ouvert par</th>
                <th class="creer_creneau__table--header-cell">Heure d'ouverture</th>
                <th class="creer_creneau__table--header-cell">Fermé par</th>
                <th class="creer_creneau__table--header-cell">Heure de fermeture</th>
            </tr>
        </thead>
        <tbody>
            {{contentPage}}
        </tbody>
    </table>
</div>