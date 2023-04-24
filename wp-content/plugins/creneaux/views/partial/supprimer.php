<form method="POST" action="{{action}}" class="creneau_form">
    <p style="display: inline; margin: 0;">{{type_string}} ce créneau</p>
    <input type="hidden" name="action" value="supprimer_de_creneau">
    <input type="hidden" name="id_creneau" value="{{id}}" />
    <input type="hidden" name="type" value="{{type}}" />
    <input type="submit" value="Annuler">
</form>