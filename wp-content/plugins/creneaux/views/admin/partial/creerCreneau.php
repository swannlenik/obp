<?php
$creneaux = getNextCreneaux();
$userName = getUserFullName();
?>

<div class="creer-creneau__div">
    <h1>Liste des créneaux des 7 prochains jours</h1>
    <table class="creer-creneau__table">
        <thead>
            <tr class="creer_creneau__table--line">
                <th class="creer_creneau__table--header-cell">Date du créneau</th>
                <th class="creer_creneau__table--header-cell">Horaires</th>
                <th class="creer_creneau__table--header-cell">Ouvert par</th>
                <th class="creer_creneau__table--header-cell">Fermé par</th>
                <th class="creer_creneau__table--header-cell">Annuler créneau</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($creneaux as $date => $c): ?>
            <tr class="creer_creneau__table--line">
                <td class="creer_creneau__table--body-cell">
                    <?php echo $date; ?> - <?php $dt = new DateTime($c->jour); echo getJourParIndice($dt->format('w')); ?>
                </td>
                <td class="creer_creneau__table--body-cell">
                    De <?php echo $c->horaires['ouverture']; ?> à <?php echo $c->horaires['fermeture']; ?>
                </td>
                <td class="creer_creneau__table--body-cell">
                    <?php if( !empty($c->annule)): ?>
                        Créneau annulé
                    <?php else: ?>
                        <?php if (empty($c->ouverture) || $c->ouverture === $userName): ?>
                         <form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
                            <input type="hidden" name="action" value="inserer_creneau">
                            <input type="hidden" name="existe" value="<?php echo $c->existe ? 1 : 0; ?>" />
                            <input type="hidden" name="id_creneau" value="<?php echo $c->id_creneau ?? 0; ?>" />
                            <input type="hidden" name="id" value="<?php echo $c->id ?? 0; ?>" />
                            <input type="hidden" name="jour" value="<?php echo $c->jour; ?>" />
                            <input type="hidden" name="ouverture" value="<?php echo (!empty($c->ouverture) && $c->ouverture === $userName) ? '' : $userName; ?>" />
                            <?php echo !empty($c->ouverture) ? sprintf('Ouvert par %s à %s', $c->ouverture, $c->heure_ouverture) : 'Personne'; ?>
                            <br />
                            <?php if(empty($c->ouverture)): ?>
                            <select name="heure_ouverture">
                                <?php
                                $t = DateTime::createFromFormat('H:i', $c->horaires['ouverture']);
                                $interval = new DateInterval('PT15M');
                                for ($i = 0; $i <= 4; $i ++):
                                ?>
                                <option value="<?php echo $t->format('H:i'); ?>"><?php echo $t->format('H:i'); ?></option>
                                <?php 
                                $t->add($interval);
                                endfor; 
                                ?>
                            </select>
                            <?php endif; ?>
                            <input type="submit" value="<?php echo empty($c->ouverture) ? 'J\'ouvre ce créneau' : 'Supprimer'; ?>" />
                        </form>
                        <?php else: ?>
                            <?php echo $c->ouverture; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td class="creer_creneau__table--body-cell">
                    <?php if( !empty($c->annule)): ?>
                        Créneau annulé
                    <?php else: ?>
                        <?php if (empty($c->fermeture) || $c->fermeture === $userName): ?>
                        <form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
                            <input type="hidden" name="action" value="inserer_creneau">
                            <input type="hidden" name="existe" value="<?php echo $c->existe ? 1 : 0; ?>" />
                            <input type="hidden" name="id_creneau" value="<?php echo $c->id_creneau ?? 0; ?>" />
                            <input type="hidden" name="id" value="<?php echo $c->id ?? 0; ?>" />
                            <input type="hidden" name="jour" value="<?php echo $c->jour; ?>" />
                            <input type="hidden" name="fermeture" value="<?php echo (!empty($c->fermeture) && $c->fermeture === $userName) ? '' : $userName; ?>" />
                            <?php echo !empty($c->fermeture) ? sprintf('Fermé par %s à %s', $c->fermeture, $c->heure_fermeture) : 'Personne'; ?>
                            <br />
                            <?php if(empty($c->fermeture)): ?>
                            <select name="heure_fermeture">
                                <?php
                                $t = DateTime::createFromFormat('H:i', $c->horaires['fermeture']);
                                $interval = new DateInterval('PT1H');
                                $interval->invert = 1;
                                $t->add($interval);

                                $interval2 = new DateInterval('PT15M');
                                for ($i = 0; $i <= 4; $i ++):
                                ?>
                                <option value="<?php echo $t->format('H:i'); ?>"><?php echo $t->format('H:i'); ?></option>
                                <?php 
                                $t->add($interval2);
                                endfor; 
                                ?>
                            </select>
                            <?php endif; ?>
                            <input type="submit" value="<?php echo empty($c->fermeture) ? 'Je ferme ce créneau' : 'Supprimer'; ?>" />
                        </form>
                        <?php else: ?>
                            <?php echo $c->fermeture; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
                <td class="creer_creneau__table--body-cell">
                    <form method="POST" action="<?php echo admin_url('admin-post.php'); ?>">
                        <input type="hidden" name="action" value="annuler_creneau">
                        <input type="hidden" name="id" value="<?php echo $c->id ?? 0; ?>" />
                        <input type="hidden" name="id_creneau" value="<?php echo $c->id_creneau ?? 0; ?>" />
                        <input type="hidden" name="jour" value="<?php echo $c->jour; ?>" />     
                        <input type="hidden" name="annule" value="<?php echo empty($c->annule) || $c->annule === 0 ? 1 : 0; ?>" />
                        <input type="submit" value="<?php echo empty($c->annule) ? 'Annuler le créneau' : 'Supprimer annulation'; ?>" />
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>