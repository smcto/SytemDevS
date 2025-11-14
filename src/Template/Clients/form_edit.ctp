<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?php 
    $isVilleManuelChecked = false;
    if (!(!empty($clientEntity->ville ?? '') && @count($villesFrances) > 0 && $isVilleClientInVilleFrances == true)) {
        $isVilleManuelChecked = true;
    }
?>

<div class="nouveau-client">

    <h3 class="pb-2 mb-3 bordered">Informations client</h3>

    <div class="row">
        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Genre</label>
            <div class="col-md-8">
                <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client_type']) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5 edit-client-name">Raison sociale (*)</label>
            <div class="col-md-8">
                <?= $this->Form->control('nom', ['label' => false, 'class' => 'edit-client-required form-control']); ?>
            </div>
        </div>
        <div class="col-md-6 edit-client-lastname hide row">
            <label class="control-label col-md-4 m-t-5">Prénom (*)</label>
            <div class="col-md-8">
                <?= $this->Form->control('prenom', ['label' => false]); ?>
            </div>
        </div>

        <div class="col-md-6 edit-enseigne row">
            <label class="control-label col-md-4 m-t-5 ">Enseigne</label>
            <div class="col-md-8">
                <?= $this->Form->control('enseigne', ['label' => false, 'class' => 'form-control']); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Adresse</label>
            <div class="col-md-8">
                <?= $this->Form->control('adresse', ['type'=>'text', 'class' => 'form-control new-clients', 'id' => 'adresse', 'label' => false, 'maxlength' => 255]); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Adresse complémentaire</label>
            <div class="col-md-8">
                <?= $this->Form->control('adresse_2', ['type' => 'text', 'class' => 'form-control new-clients','label' => false]); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Code postal</label>
            <div class="col-md-8">
                <?= $this->Form->control('cp', ['type'=>'text', 'class' => 'form-control cp', 'label' => false , 'maxlength' => 255]); ?>
            </div>
        </div>

        <div class="col-md-6 row ">
            <label class="control-label col-md-4 m-t-5">Ville</label>
            <div class="col-md-8 bloc-ville">
                <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox', 'checked' => $isVilleManuelChecked]); ?>
                <?php if (!$clientEntity->id): ?>
                    <div class="clearfix select"><?= $this->Form->control('ville', ['default' => $clientEntity->ville ?? '', 'empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances ?? [], 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'select-ville']); ?></div>
                    <div class="clearfix input d-none"><?= $this->Form->control('ville', ['label' => false, 'disabled', 'type' => 'text']); ?></div>
                <?php else: ?>
                    <?php if (!empty($clientEntity->ville) && count($villesFrances) > 0 && $isVilleClientInVilleFrances == true): ?>
                        <div class="clearfix select <?= $isVilleClientInVilleFrances ? '' : 'd-none' ?>"><?= $this->Form->control('ville', ['value' => strtoupper($clientEntity->ville) ?? '', 'empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances ?? [], 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'select-ville']); ?></div>
                        <div class="clearfix input <?= $isVilleClientInVilleFrances ? 'd-none' : '' ?>"><?= $this->Form->control('ville', ['label' => false, 'value' => $clientEntity->ville]); ?></div>
                    <?php else: ?>
                        <div class="clearfix select d-none"><?= $this->Form->control('ville', ['default' => $clientEntity->ville ?? '', 'disabled', 'empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances ?? [], 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'select-ville']); ?></div>
                        <div class="clearfix input"><?= $this->Form->control('ville', ['default' => $clientEntity->ville ?? '', 'label' => false, 'type' => 'text']); ?></div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Pays</label>
            <div class="col-md-8">
                <div class="clearfix select"><?= $this->Form->control('new_client.pays_id', ['options' => $payss, 'default' => $clientEntity->pays_id ?? '', 'empty' => 'Sélectionner', 'class' => 'form-control selectpicker', 'id' => 'country', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5 edit-client-tel">Tél entreprise</label>
            <div class="col-md-8">
                <?= $this->Form->control('telephone', ['type'=>'text', 'class' => 'form-control','label' => false ]); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5 ">2ème Téléphone</label>
            <div class="col-md-8">
                <?= $this->Form->control('telephone_2', ['class' => 'form-control','label' => false ]); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5 edit-client-mail">Email général</label>
            <div class="col-md-8">
                <?= $this->Form->control('email', ['class' => 'form-control','label' => false ]); ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Tva Intracommunautaire</label>
            <div class="col-md-8">
                <?= $this->Form->control('tva_intra_community', ['class' => 'form-control edit-pro','label' => false]); ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Siren</label>
            <div class="col-md-8">
                <?= $this->Form->control('siren', ['class' => 'form-control edit-pro','label' => false]); ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Siret</label>
            <div class="col-md-8">
                <?= $this->Form->control('siret', ['class' => 'form-control edit-pro','label' => false]); ?>
            </div>
        </div>
    </div>

    <h3 class="pb-2 mb-3 bordered">Qualification client</h3>

    <div class="row">
        <div class="col-md-6 row">
            <label class="control-label col-md-4 m-t-5">Type commercial *</label>
            <div class="col-md-8">
                <?= $this->Form->control('type_commercial', ['options' => $type_commercials, 'class' => 'edit-client-required selectpicker', 'empty' => 'Sélectionner', 'label' => false]) ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Type</label>
            <div class="col-md-8 row my-auto" id="types">
                <?php foreach ($filtres_contrats as $fied => $label) : ?>
                    <div class="col-6 mt-2"><?= $this->Form->control($fied, ['type' => 'checkbox' ,'label' => $label]); ?></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Groupes de clients</label>
            <div class="col-md-8">
                <?= $this->Form->control('groupe_client_id', ['options'=> $groupeClients, 'empty' => 'Sélectionner', 'class' => 'selectpicker client_id', 'label' => false]); ?>
            </div>
        </div>

        <div class="col-md-6 row edit-client-pro">
            <label class="control-label col-md-4 m-t-5">Secteur d'activité</label>
            <div class="col-md-8">
                <?= $this->Form->control('secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites form-control', 'label' => false, 'options' => $secteursActivites, 'style' => 'width:100%']); ?>
            </div>
        </div>

        <div class="col-md-6 row">
            <label class="control-label col-md-4">Comment a-t-il connu Selfizee ?</label>
            <div class="col-md-8">
                <?= $this->Form->control('connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Sélectionner']); ?>
            </div>
        </div>
    </div>

</div>