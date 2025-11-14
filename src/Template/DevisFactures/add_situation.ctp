<?php use Cake\Routing\Router; ?>
<?php $this->Html->css('devisFactures/add.css?time='.time(), ['block' => 'css']); ?>
<?php $this->Html->css('facture-situations/add.css?time='.time(), ['block' => 'css']); ?>
<?php $this->Html->css('fontawesome5/css/all.min.css', ['block' => 'css']); ?>
<?php $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?php $this->Html->script('moment/moment.js', ['block' => 'script']); ?>
<?php $this->Html->script('facture-situations/add.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('calendar/dist/lib/jquery-ui.min.js', ['block' => 'script']); ?>
<!-- A placer après add.js, corps_devis.js et autre.js peut dépendre des fonctions dedans -->
<?php $this->Html->script('devis/commun_devis_et_facture.js?time='.time(), ['block' => 'script']); ?>

<!-- Modal -->
<?= $this->element('devis_et_factures/proposition-save') ?>

<?php $custum_title = $id?'Modification facture de situation':'Création facture de situation';?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <?php if($factureSituationEntity->id) : ?>
            <a href="<?= $this->Url->build(['action' => 'addSituation', 'devis_id' => $factureSituationEntity->devis_id]) ?>" target="_blank" class="btn btn-sm btn-rounded btn-primary">Ajouter une Situation</a>
        <?php endif ?>
        <a href="javascript:void(0);" class="btn btn-sm btn-rounded btn-primary save_continuer">Enregistrer et continuer</a>
        <a href="javascript:void(0);" class="btn btn-sm btn-rounded btn-primary save">Enregistrer et quitter</a>
        <a href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis_id]) ?>" class="btn btn-sm btn-rounded btn-inverse">Annuler</a>
    </div>
<?php $this->end() ?>

<?php $this->assign('custom_title', '<h1 class="m-0 top-title">' . $custum_title . '</h1>'); ?>
<?php $this->assign('title', $custum_title) ?>

<div class="checkbox d-none"> <label for="sn-checkbox-open-in-new-window"> <input type="checkbox" id="sn-checkbox-open-in-new-window" checked="">Ouvrir dans une nouvelle fenêtre</label></div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="devis_factures_client_adress" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['url' => ['action' => 'editInfosClient'], 'class' => '']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier adresse client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->control('adresse', ['id' => 'edit_client_adress']); ?>
                    <?= $this->Form->control('cp', ['label' => 'Code postal', 'id' => 'edit_client_cp']); ?>
                    <?= $this->Form->control('ville', ['id' => 'edit_client_ville']); ?>
                    <?= $this->Form->control('country', ['label' => 'Pays', 'id' => 'edit_client_pays']); ?>
                    <?= $this->Form->control('adresse_2', ['type' => 'text', 'id' => 'edit_client_adress_2', 'label' => 'Adresse complémentaire']); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" id="edit_client_btn" class="btn btn-primary">Enregistrer</button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="devis_factures_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($newContact, ['id' => 'add_contact_client']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Attribuer un contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row row-client">
                        <div class="col-md-5 mt-2 m-b-30">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input radios-existing-contact" id="group_radios_client_1" name="client_contact" value="1" checked>
                                <label class="custom-control-label" for="group_radios_client_1">Contact existant </label>
                            </div>
                        </div>
                        <div class="col-md-6 existing-contact">
                            <?= $this->Form->control('contact_id', ['empty' => 'Sélectionner', 'options' => $clientContacts, 'label' => false, 'id' => 'contact_id']) ?>
                        </div>
                    </div>

                    <div class="custom-control custom-radio mt-3">
                        <input type="radio" class="custom-control-input radios-new-contact" id="group_radios_client_2" value="2" name="client_contact">
                        <label class="custom-control-label" for="group_radios_client_2">Nouveau contact </label>
                    </div>

                    <div class="mt-4  nouveau-contact hide">

                        <h3 class="pb-2 mb-3 bordered">Informations contact</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Information générales:</legend>
                                    <div class="row">
                                        <label class="control-label col-md-4 m-t-10">Civilité</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('civilite', [
                                                        'options' => $civilite, 
                                                        'type' => 'radio', 
                                                        'label'=>false,
                                                        'hiddenField'=>false,
                                                        'legend'=>false,
                                                        'class' => 'row',
                                                        'templates' => [
                                                            'inputContainer' => '<div class="form-group row">{{content}}</div>',
                                                            'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}} class="label-civilite">{{text}}</label>',
                                                            'radioWrapper' => '<div class="radio radio-success radio-inline  m-l-15">{{label}}</div>'
                                                        ]
                                                ]) ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name">Prénom</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('prenom', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name">Nom</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('nom', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Fonction </label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('position', ['label' => false, 'id' => false]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Email</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('email', ['class' => 'form-control','label' => false, 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Tél</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('tel', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Mobile</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('telephone_2', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Fax</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('fax', ['class' => 'form-control','label' => false ]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-mail">Site web</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('site_web', ['class' => 'form-control','label' => false ]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Date de naissance</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->text('date_naiss', ['type' => 'date', 'class' => 'form-control pro','label' => false]); ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Social :</legend>
                                    <div class="row">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('twitter', ['id' => 'client-type','label' => false]) ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('facebook', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIN </label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('linkedin', ['label' => false]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-viadeo-square" aria-hidden="true"></i> Viadeo</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('viadeo', ['class' => 'form-control','label' => false]); ?>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Note :</legend>
                                    <?= $this->Form->control('contact_note', ['type'=>'textarea', 'class' => 'tinymce-note', 'label' => false]); ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Ajouter le contact'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<?= $this->element('../DevisFactures/modal_catalog') ?>
<!-- END MODAL -->



<?= $this->Form->create($factureSituationEntity, ['class' => 'form-facture-situation']); ?>

    <?= $this->Form->hidden('devis_id', ['value' => $devis_id]); ?>
    <?= $this->Form->hidden('client_id', ['id' => 'client_id']); ?>

    <div class="card">
        <div class="card-body">
            <input type="hidden" id="is_continue" value="0" name="is_continue">
            <div class="row">
                <div class="col-md-3">
                    <div class="row-fluid">
                        <?= $this->Form->hidden('nom_societe', ['placeholder' => '' ,'label' => 'Nom de la société', 'value' => 'KONITYS']); ?>
                        <div class="bloc-addr">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => 'Réf. commercial', 'class' => 'selectpicker']); ?>
                            KONITYS <br>
                            <b>Contact : </b> <span id="full_name"><?= $currentUser->get('full_name') ?></span>
                        </div>

                        <div class="infos row-fluid">
                            <span class="text-grey"> Tel : </span> <span id="telephone_fixe"><?= $currentUser->telephone_fixe ?></span> <br>
                            <span class="text-grey"> Email : </span><span id="email"><?= $currentUser->email ?></span>
                            <a class="mb-4 d-none" id="link-user" target="_blank" href="<?= $this->Url->build(['controller' => 'users', 'action' => 'edit', $currentUser->id]) ?>">Modifier les informations par défaut</a>
                        </div>
                    </div>
                </div>

                <div class="offset-xl-6 offset-md-3 col-xl-3 col-md-6 col-sm-6">
                    <div class="row-fluid no-spin">
                        <?php if (!is_null($id)): ?>
                            <?= $this->Form->control('status', ['options' => $facture_situations_status, 'label' => 'Etat', 'default' => 'draft', 'empty' => 'Séléctionner', 'templates' => 'app_form_inline']); ?>
                        <?php endif ?>
                        <?= $this->Form->control('indent', ['label' => 'Facture de situation N°', 'templates' => 'app_form_inline']); ?>
                        <div class="form-group row">
                            <label class="col-md-5" for="date-crea">Situation n° <?= $factureSituationEntity->numero ?></label><div class="col-md-7 hide"><?= $this->Form->text('numero'); ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5" for="date-crea">En date du</label><div class="col-md-7"><?= $this->Form->text('date_crea', ['type' => 'date', 'value' => $factureSituationEntity->date_crea? $factureSituationEntity->date_crea->format('Y-m-d') : ""]); ?></div>
                        </div>
                        <div class="form-group row hide">
                            <label class="col-md-5" for="date-sign-before">A signer avant le</label><div class="col-md-7"><?= $this->Form->text('date_sign_before', ['type' => 'date', 'value' => $factureSituationEntity->date_sign_before? $factureSituationEntity->date_sign_before->format('Y-m-d') : ""]); ?></div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <span><b>Nom du client : <?= $factureSituationEntity->client->full_name ?></b></span><br>
                        <span class="client_contact">
                            <?php if ($factureSituationEntity->facture_client_contact) : ?>
                            À l'attention de <b><?= $factureSituationEntity->facture_client_contact->civilite ?> <?= $factureSituationEntity->facture_client_contact->full_name ?></b><br>
                            <?php endif; ?>
                        </span>
                        <span class="clinet_info">
                            <?= $factureSituationEntity->client_adresse ? $factureSituationEntity->client_adresse."<br>": "" ?>
                            <?= $factureSituationEntity->client_adresse_2? $factureSituationEntity->client_adresse_2."<br>":"" ?>
                            <?= $factureSituationEntity->client_cp .' '. $factureSituationEntity->client_ville ?> <br>
                            <?= $factureSituationEntity->client_country ?>
                        </span>
                        
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="container-objet">
                        <div class="row-fluid bloc-objet">
                            <?= $this->Form->control('objet', ['label' => false, 'class' => 'tinymce-note form-control', 'type' => 'textarea', 'label' => 'Objet']); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 hide">
                    <div class="row <?= $factureSituationEntity->is_model ? "hide" :"" ?>">
                        <div class="col-md-6">
                            <div class="row-fluid bloc-objet">
                                <div class="form-group">
                                    <?= $this->Form->control('antennes._ids', ['class' => 'form-control select2','label' => 'Antenne(s) locale(s)','data-placeholder' => 'choisir des antennes', 'multiple'=> "multiple"]); ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row-fluid bloc-objet">
                                <div class="form-group">
                                    <?= $this->Form->control('model_type', ['class' => 'form-control','label' => 'Type de la borne', 'empty' => 'Séléctionner']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="<?= $factureSituationEntity->is_model ? "hide" :"" ?>">
                        <div class="">
                            <div class="row-fluid bloc-objet">
                                <label>Date événement</label>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <?= $this->Form->control('periode', ['label' => false, 'options' => ['1' => 'Le jour du', '2' => 'Période du'], 'value' => $factureSituationEntity->date_evenement_fin?2 : 1]); ?>
                                    </div>
                                    <div class="form-group debut_evenement <?= $factureSituationEntity->date_evenement_fin ?'col-md-4' : 'col-md-9' ?>">
                                        <?= $this->Form->text('date_evenement', ['type' => 'date', 'value' => $factureSituationEntity->date_evenement? $factureSituationEntity->date_evenement->format('Y-m-d') : ""]); ?>
                                    </div>
                                    <div class="m-l-15 m-r-15 m-t-10 fin_evenement <?= $factureSituationEntity->date_evenement_fin ? '': 'hide' ?>">
                                         au 
                                    </div>
                                    <div class="form-group  col-md-4 fin_evenement <?= $factureSituationEntity->date_evenement_fin ? '': 'hide' ?>">
                                        <?= $this->Form->text('date_evenement_fin', ['id' => 'date_evenement_fin', 'type' => 'date', 'value' => $factureSituationEntity->date_evenement_fin? $factureSituationEntity->date_evenement_fin->format('Y-m-d') : ""]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid ">
                <h3>Détails</h3>
                
                <div class="">
                    <table class="table table-uniforme table_bloc_devis_factures table-bordered  detail-form ">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">Référence</th>
                                <th class="th-descr" width="450px">Description</th>
                                <th>Remise</th>
                                <th>Coût unitaire HT</th>
                                <th>Facturé <br> Prévu</th>
                                <th>Avancement</th>
                                <th width="6%">TVA</th>
                                <th width="10%" class="text-right">Montant HT</th>
                                <th width="10%" class="text-right">Montant TTC</th>
                            </tr>
                        </thead>
                        
                        <!-- Recois les params -->
                        <?= $this->Form->hidden('col_visibility_params'); ?>

                        <tbody id="sortable" class="default-data">
                            <?php if($factureSituationEntity->devis_factures_produits) : ?>
                                <?php foreach ($factureSituationEntity->devis_factures_produits as $key => $ligne) : ?>
                            
                                    <?php if($ligne->type_ligne == 'produit' || $ligne->type_ligne == 'abonnement') : ?>
                                        <tr class="clone added-tr <?= $ligne->line_option?'ligne-option':'' ?>">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.catalog_produits_id", ['input-name' => 'catalog_produits_id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.line_option", ['input-name' => 'line_option', 'label' => false, 'class' => '']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne']); ?>
                                            </td>
                                            <td>
                                                <?= $ligne-> reference ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.reference", ['input-name' => 'reference', 'label' => false]); ?>
                                            </td> 
                                            <td class="p-0"><?= $this->Form->control("devis_factures_produits.$key.description_commercial", ['input-name' => 'description_commercial', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?> </td>
                                            <td class="block-remise remise">
                                                <div class="col-12"><?= $ligne->remise_value . $ligne->remise_unity ?></div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.remise_value", ['input-name' => 'remise_value', 'label' => false, 'type' => 'number']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.remise_unity", ['input-name' => 'remise_unity']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.remise_euro", ['input-name' => 'remise_euro', 'class' => 'remise_euro']); ?>
                                            </td>
                                            <td class="block-remise">
                                                <div class="col-12"><?= $ligne->prix_reference_ht ?></div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.prix_reference_ht", ['input-name' => 'prix_reference_ht', 'label' => false,]); ?>
                                            </td>
                                            <td class="text-right">
                                                <div class="col-12">
                                                    <div class="facture_pourcent"><?= $ligne->facture_pourcentage? : 0 ?> %</div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.facture_pourcentage", ['input-name' => 'facture_pourcentage', 'label' => false,]); ?>
                                                    <div class="facture_euro m-t-30"><?= $ligne->facture_euro? : 0 ?> €</div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.facture_euro", ['input-name' => 'facture_euro', 'label' => false,]); ?>
                                                    <div class="m-t-30">
                                                        <?= $ligne->quantite_usuelle ?> <br>
                                                        <?php
                                                            $montant = $ligne->prix_reference_ht * $ligne->quantite_usuelle;
                                                            if($factureSituationEntity->remise_line && $ligne->remise_value) {
                                                                if($ligne->remise_unity == '%') {
                                                                    $montant -= $montant * $ligne->remise_value / 100;
                                                                } else {
                                                                    $montant-= $ligne->remise_value;
                                                                }
                                                            } 
                                                            ?>
                                                        <?= $this->Utilities->formatCurencyPdf($montant) ?> €
                                                    </div>
                                                    <div class="quantite_usuelle  hide">
                                                        <?= $ligne->quantite_usuelle ?>
                                                    </div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.quantite_usuelle", ['input-name' => 'quantite_usuelle', 'label' => false,]); ?>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.catalog_unites_id", ['input-name' => 'catalog_unites_id', 'label' => false,]); ?>
                                                </div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.facture_prevu_value", ['input-name' => 'facture_prevu_value', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.facture_prevu_unity", ['input-name' => 'facture_prevu_unity', 'label' => false]); ?>
                                            </td>
                                            <td class="text-right">
                                                <div class="col-12">
                                                    <div class="row m-l-10"><?= $this->Form->control("devis_factures_produits.$key.avancement_pourcentage", ['input-name' => 'avancement_pourcentage', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control avancement_pourcentage']); ?><span class="suffix">%</span></div>
                                                    <div class="row m-l-10"><?= $this->Form->control("devis_factures_produits.$key.avancement_euro", ['input-name' => 'avancement_euro', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control avancement_euro']); ?><span class="suffix">€</span></div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.avancement_quantite", ['input-name' => 'avancement_quantite', 'label' => false, 'class' => 'avancement_quantite']); ?>
                                                    <div class="m-t-20 m-r-20"><span class="quantite_avancement"><?= $ligne->avancement_quantite ?></span> </div>
                                                    <div class="m-t-20 m-r-20"></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-12"><?= $ligne->tva ?>%</div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.tva", ['input-name' => 'tva', 'label' => false]); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <div class="col-12">
                                                    <div class="montant_ht_value">0</div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.montant_ht", ['input-name' => 'montant_ht', 'label' => false]); ?>
                                                </div>
                                            </td>
                                            <td class="montant_ttc text-right">
                                                <div class="col-12">
                                                    <div class="montant_ttc_value">0</div>
                                                    <?= $this->Form->hidden("devis_factures_produits.$key.montant_ttc", ['input-name' => 'montant_ttc', 'label' => false]); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                    <?php if($ligne->type_ligne == 'sous_total') : ?>
                                        <tr class="clone-sous-total added-tr hide">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="8" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Sous-total</h4></div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.sous_total", ['input-name' => 'sous_total', 'label' => false, ]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'sous_total']); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <div class="row">
                                                    <div class="col-12"><div class="montant_ht_value sous-total-value"><?= $ligne->sous_total ?></div></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'titre') : ?>
                                        <tr class="clone-titre added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("devis_factures_produits.$key.titre_ligne", ['input-name' => 'titre_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'titre']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'commentaire') : ?>
                                        <tr class="clone-commentaire added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("devis_factures_produits.$key.commentaire_ligne", ['input-name' => 'commentaire_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'commentaire']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_ligne') : ?>
                                        <tr class="clone-saut-ligne added-tr hide">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de ligne</h4></div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_ligne']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevisFactures', 'action' => 'deleteLineDevisFacturesProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_page') : ?>
                                        <tr class="clone-saut-page added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_factures_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de page</h4></div>
                                                <?= $this->Form->hidden("devis_factures_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_page']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                <?php endforeach; ?>
                                        
                            <?php else : ?>
                                <tr><td colspan="9" class="text-center first-tr py-5 dynamic-colspan">Aucun ligne</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5"></td>
                                <td>
                                    <div class="row pourcentage_global_filed m-l-10 <?= $factureSituationEntity->pourcentage_global?:'hide' ?>"><?= $this->Form->control("pourcentage_global", ['input-name' => 'pourcentage_global', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control pourcentage_global']); ?><span class="suffix">%</span></div>
                                    <div class="row pourcentage_global_button m-l-10 <?= $factureSituationEntity->pourcentage_global?'hide':'' ?>"><button type="button" class="btn btn-rounded btn-primary pourcentage_global_button"> <span aria-hidden="true">%Global</span> </button></div>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row m-t-40">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            Nombre de produit(s) du document <br>
                            <b class="nombre_produit">0</b>
                        </div>
                    </div>
                    <?= $this->Form->control('note', ['class' => 'tinymce-note', 'data-height' => 120]); ?>
                </div>

                <div class="col-md-6">
                    <table class="table table-uniforme">
                        <thead class="">
                            <tr class="hide">
                                <th width="90%"></th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                            <tr class="total-avec-abonnement d-none">
                                <th colspan="3"><b>Total interne</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-montant-ht">Montant total HT</td>
                                <td class="text-right montant_general total_general_ht"><?= $factureSituationEntity->total_ht?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ht', ['id' => 'total_ht']); ?>
                            </tr>
                            <tr  class="total-remise-global hide">
                                <td>Réduction HT</td>
                                <td class="text-right montant_general remise-global-ht"><?= $factureSituationEntity->total_reduction?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_reduction'); ?>
                            </tr>
                            <tr class="total-remise-global hide">
                                <td>Total HT après réduction</td>
                                <td class="text-right montant_general total-after-remise"><?= $factureSituationEntity->total_remise?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_remise'); ?>
                            </tr>
                            <tr>
                                <td class="tva-label">TVA</td>
                                <td class="text-right montant_general total_general_tva"><?= $factureSituationEntity->total_tva?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_tva', ['id' => 'total_tva']); ?>
                            </tr>
                            <tr>
                                <td>Montant total TTC</td>
                                <td class="text-right montant_general total_general_ttc"><?= $factureSituationEntity->total_ttc?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ttc',['id' => 'total_ttc']); ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->hidden('is_text_loi_displayed', ['value' => 0]); ?>
    <?= $this->Form->hidden('is_situation', ['value' => 1]); ?>

<?= $this->form->end() ?>
