<div class="row">
    <div class="col-md-12 nb_mois">
        <?= $this->Form->control('parc_duree_id', ['default' => 36, 'value' =>$borneEntity->parc_duree_id,  'options' => @$parc_durees, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Nombre de mois']); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <label for="">Date début</label>
        <?= $this->Form->text('contrat_debut', ['type' => 'date', 'value' => $borneEntity->contrat_debut == null ?: $borneEntity->contrat_debut->format('Y-m-d'), 'id' => 'facturation-date-signature']); ?>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <?= $this->Form->control('user_id', ['options' => $commercials, 'value' =>$borneEntity->user_id, 'empty' => 'Sélectionner', 'class' => 'selectpicker contact_client_id', 'data-live-search' => true, 'label' => 'Contact commercial']); ?>
    </div>
</div>
