<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>
<?= $this->Html->css('devisFactures/add-client-in-devis.css?time='.time(), ['block' => true]); ?>
<?= $this->Html->css('devisFactures/index.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>

<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('devisFactures/index.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('moment-range', ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>


<?php

$titrePage = "Liste factures" ;

$this->assign('title', 'Factures');

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$customCheckBoxMultiSelect = [
    'nestingLabel' => '{{hidden}}<label{{attrs}} class="custom-control ml-3 px-2 m-0 custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',
];

$customFinderOptions[] = 'csv';
?>


<?php $this->start('actionTitle'); ?>
    <a class="btn pull-right hidden-sm-down btn-rounded btn-success create-facture" data-toggle="modal" href="#add_devis_factures" data-title="Créer une factures" data-submit="Créer une facture" data-href="<?= $this->Url->build(['action' => 'index']) ?>">Créer une facture</a>
    <a href="<?= $this->Url->build(array_filter($customFinderOptions)) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Exporter en csv</a>
    <!--a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste factures manager</a> -->
<?php $this->end(); ?>

<!-- BEGIN MODAL -->
<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'editClient'] ,'id' => 'edit_client_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Affecter à un autre client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le client'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="form_client_2" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'lierClient2'] ,'id' => 'client_2_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Lier à un 2ème client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id_2', ['options' => [], 'empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id_2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Lier '), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_commercial" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'editCommercial'] ,'id' => 'edit_commercial_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Changer de commercial </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Commercial : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'empty' => 'Sélectionner', 'class' => 'selectpicker form-control', 'data-live-search' => true, 'label' => false,'style' => 'width:100%', 'id' => 'edit_commercial_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le commercial'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="add_devis_factures" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Créer une factures</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="">

                        <div class="row row-client for-duplicat hide">
                            <div class="col-md-5 mt-2 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-3" id="group_radios_client_3" name="client" value="3">
                                    <label class="custom-control-label" for="group_radios_client_3">Pour ce même client </label>
                                </div>
                            </div>
                        </div>

                        <div class="row row-client">
                            <div class="col-md-5 mt-3 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-1" id="group_radios_client_1" name="client" value="1" checked>
                                    <label class="custom-control-label" for="group_radios_client_1">Pour un client / prospect existant </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 row col-md-12 existing-client">
                            <div class="col-md-6 row">
                                <label class="control-label col-md-2 m-t-5">Genre</label>
                                <div class="col-md-10">
                                    <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-genre', 'empty' => 'Sélectionner' , 'value' => 'corporation']) ?>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="control-label col-md-2 m-t-5">Client</label>
                                <div class="col-md-10">
                                    <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="custom-control custom-radio mt-3">
                            <input type="radio" class="custom-control-input radios-client-2" id="group_radios_client_2" value="2" name="client">
                            <label class="custom-control-label" for="group_radios_client_2">Pour un nouveau client / prospect</label>
                        </div>

                        <div class="mt-4 hide nouveau-client">

                            <h3 class="pb-2 mb-3 bordered">Informations client</h3>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Genre</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-type']) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-name">Raison sociale (*)</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.nom', ['label' => false, 'class' => 'client-required form-control']); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 client-lastname hide row">
                                    <label class="control-label col-md-4 m-t-5">Prénom (*)</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.prenom', ['label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5 ">Enseigne</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.enseigne', ['label' => false, 'class' => 'form-control']); ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Adresse</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.adresse', ['type'=>'text', 'class' => 'form-control new-clients','label' => false, 'maxlength' => 255, 'id' => 'adresse']); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Adresse complémentaire</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.adresse_2', ['type' => 'text', 'class' => 'form-control new-clients','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Code postal</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.cp', ['type'=>'text', 'class' => 'form-control cp', 'id' => 'cp',  'label' => false , 'maxlength' => 255]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Ville</label>
                                    <div class="col-md-8 bloc-ville">
                                        <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                                        <div class="clearfix select"><?= $this->Form->control('new_client.ville', ['empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                        <div class="clearfix input d-none"><?= $this->Form->control('new_client.ville', ['type' => 'text', 'label' => false, 'disabled', 'id' => 'ville']); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Pays</label>
                                    <div class="col-md-8">
                                        <div class="clearfix select"><?= $this->Form->control('new_client.pays_id', ['options' => $payss, 'default' => 5, 'empty' => 'Sélectionner', 'class' => 'form-control selectpicker', 'id' => 'country', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-tel">Tél entreprise</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.telephone', ['type'=>'text', 'class' => 'form-control','label' => false ]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-mail">Email général</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.email', ['class' => 'form-control','label' => false ]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Tva Intracommunautaire</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.tva_intra_community', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Siren</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.siren', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Siret</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.siret', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>
                            </div>

                            <h3 class="pb-2 mb-3 bordered">Qualification client</h3>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Type commercial *</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.type_commercial', ['options' => $type_commercials, 'class' => 'client-required selectpicker', 'empty' => 'Sélectionner', 'label' => false]) ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Groupes de clients</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.groupe_client_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker form-control client_id', 'data-live-search' => true, 'label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Secteur d'activité</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites client-required form-control', 'label' => false, 'options' => $secteursActivites, 'style' => 'width:100%']); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4">Comment a-t-il connu Selfizee ?</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Séléctionner']); ?>
                                    </div>
                                </div>
                            </div>

                            <h3 class="pb-2 mb-3 bordered">Contacts associés</h3>

                            <div class="row-fluid">
                                <div class="d-block clearfix">
                                    <button type="button" class="btn btn-success add-data float-right mt-2">Ajouter un contact</button>
                                </div>

                                <table class="tables mt-2">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Fonction </th>
                                            <th>Email</th>
                                            <th>Téléphone Portable</th>
                                            <th>Téléphone Fixe</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>

                                    <tbody class="default-data">
                                        <?php $init = 0 ?>
                                        <tr>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr class="d-none clone added-tr">
                                            <td><?= $this->Form->control('new_client.client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel', 'requered' => false]); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <hr>
                        </div>
                        <fieldset class="fieldset-devis-factures">
                            <legend class="legend-fieldset-devis-factures">Paramètres du document:</legend>
                            <div class="row hide">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Catégorie modèle factures</label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('category_model_devis_facture_id', ['id' => 'category', 'options' => $modelCategories, 'label' => false, 'empty' => 'Catégorie du modèle', 'data-placeholder' => 'Catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row hide sous-cat m-t-10">
                                <div class="col-md-5 m-t-10">
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('sous_category_model_devis_facture_id', ['id' => 'sous_category', 'options' => [], 'label' => false, 'empty' => 'Sous catégorie du modèle', 'data-placeholder' => 'Sous catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row hide m-t-10">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Créer à partir du modèle </label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('model_devis_facture_id', ['id' => 'model_devis_factures', 'options' => $modelDevisFactures, 'label' => false, 'empty' => 'Modèle factures', 'data-placeholder' => 'Modèle factures', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row row-client m-t-10">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Catégorie tarifaire </label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('categorie_tarifaire', ['options' => $categorie_tarifaire, 'label' => false, 'empty' => 'Catégorie tarifaire']); ?>
                                </div>
                            </div>

                            <div class="row row-client m-t-30">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Type de document </label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'id' => 'type_doc_id', 'label' => false, 'empty' => 'Type de document', 'required']); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Créer une facture'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<div class="modal fade" id="facture_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état de la factures <span class="num_facture"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mt-2 m-b-30">
                            <label>Etat : </label>
                        </div>
                        <div class="col-md-8 existing-client">
                            <?= $this->Form->control('status', ['id' => 'modif_status', 'options' => $devis_factures_status, 'empty' => 'Sélectionner', 'label' => false,'required']) ?>
                        </div>
                        <input type="hidden" value='<?= json_encode($customFinderOptions) ?>' name="paramsurl">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<?= $this->element('devis_et_factures/popup_edit_type_doc') ?>


<div class="row" id="body_borne">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'mt-4 form-filtre']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="filter-list-wrapper facture-filter-wrapper">
                        <div class="filter-block">
                            <?= $this->Form->control('keyword', ['label' => false, 'default' => $keyword, 'class' => 'form-control', 'placeholder' => 'Rechercher','id'=>'id_keyword']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => false, 'default' => $ref_commercial_id, 'class' => 'selectpicker', 'empty' => 'Contact','id'=>'id_ref_commercial_id']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('client_type', ['label' => false, 'options' => $genres, 'default' => $client_type, 'class' => 'selectpicker', 'empty' => 'Type','id'=>'id_client_type']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('antenne_id', ['label' => false, 'default' => $antenne_id, 'class' => 'selectpicker', 'data-live-search' => true, 'empty' => 'Antennes','id'=>'id_antenne_id']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('periode', ['label' => false, 'default' => $periode, 'options' => $periodes, 'class' => 'selectpicker periode', 'empty' => 'Période','id'=>'id_periode']); ?>
                        </div>

                        <div class="filter-block container_date_threshold <?= $periode == 'custom_threshold' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false, 'default' => $date_threshold, 'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
                        </div>

                        <div class="filter-block container-mois <?= $periode == 'list_month' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('mois_id', ['label' => false, 'default' => $mois_id, 'options' => $mois, 'class' => 'selectpicker']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('status', ['options' => $devis_factures_status, 'label' => false, 'default' => $status, 'class' => 'selectpicker', 'empty' => 'Etat', 'id'=>'id_status']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'Type de document', 'default' => $type_doc_id]); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>

                <?= $this->Form->end(); ?>

                <div class="all-total-info-wrap">
                    <span>Factures globales (tous états confondus) :</span>
                    <div class="text-uppercase">Total facturé HT : <strong> <?= $this->Utilities->formatCurrency($sumFacturesAll->sumOf('total_ht')) ?></strong></div>
                    <div class="text-uppercase">Total facturé TTC : <strong> <?= $this->Utilities->formatCurrency($sumFacturesAll->sumOf('total_ttc')) ?></strong></div>
                </div>
                    
                <div class="all-total-info-wrap">
                    <span>Factures réelles (excluant factures annulées) : </span>
                    <div class="text-uppercase">Total facturé HT : <strong> <?= $this->Utilities->formatCurrency($sumFactures->sumOf('total_ht')) ?></strong></div>
                    <div class="text-uppercase">Total facturé TTC : <strong> <?= $this->Utilities->formatCurrency($sumFactures->sumOf('total_ttc')) ?></strong></div>
                </div>
                <div class="clearfix"></div>

                <?= $this->Form->create(false, ['url' => ['action' => 'multipleAction'], 'class' => '']); ?>
                    <div class="row bloc-actions selection-table-action d-none">
                        <div class="action-block">
                            <?= $this->Form->control('action', ['options' => ['zip' => 'Télécharger au format ZIP'], 'type' => 'select', 'label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner une action']); ?>
                        </div>
                        <div class="action-block">
                            <?= $this->Form->submit('Valider', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </div>

                    <div class="btn-tbl-select-element clearfix">
                        <a href="javascript:void(0);" class="active-col-checkbox float-right">Sélectionner des éléments</a>
                    </div>

                    <div class="table-responsive clearfix">
                        <table class="table table-striped liste-items table-factures" id="div_table_bornes">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th class="th-numero"><?= $this->Paginator->sort('DevisFactures.indent', 'N°') ?></th>
                                    <th class="th-client"><?= $this->Paginator->sort('Clients.nom', 'Client') ?></th>
                                    <th><?= $this->Paginator->sort('DevisFactures.created', 'Date') ?></th>
                                    <th><?= $this->Paginator->sort('date_evenement', 'Event') ?></th>
                                    <th class="th-antenne">Antenne(s)</th>
                                    <th><?= $this->Paginator->sort('Clients.client_type', 'Type') ?></th> <!-- Corporation (pro) ou person (particulier) -->
                                    <th class="th-document"><?= $this->Paginator->sort('DevisTypeDocs.nom', 'Doc') ?></th>
                                    <th><?= $this->Paginator->sort('Commercial.nom', 'Com') ?></th>
                                    <th class="th-montant text-right"><?= $this->Paginator->sort('total_ht', 'HT') ?></th>
                                    <th class="th-montant text-right"><?= $this->Paginator->sort('total_ttc', 'TTC') ?></th>
                                    <th class="th-montant">Restant dû</th>
                                    <th class="th-etat"><?= $this->Paginator->sort('status', 'Etat') ?></th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($listeDevisFactures as $key => $facture){
                                ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><?= $this->Form->control("devis_factures.$facture->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $facture->get('ObjetAsTitle') ?>" href="<?= $this->Url->build(['action' => 'view', $facture->id]) ?>"><?= $facture->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $facture->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>

                                        <td>
                                            <?php if ($facture->client): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client->id]) ?>"><?= $facture->client->full_name?></a>
                                                <?php if ($facture->client2): ?>
                                                    <br>Lié à <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client2->id]) ?>"><?= $facture->client2->full_name ?></a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?= $facture->client_nom ?>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $facture->created ? $facture->created->format('d/m/y') : "-" ?></td>
                                        <td>
                                            <?php if ($facture->date_evenement) {
                                            $date_evenement = explode('/', $facture->date_evenement);
                                            $date = date_create(@$date_evenement[2] . '-' . @$date_evenement[1] . '-' . @$date_evenement[0]);
                                            echo date_format($date,"d/m/y");
                                            } ?>
                                        </td>
                                        <td><?= $facture->get('ListeAntennes'); ?></td>
                                        <td><?= @$genres_short[$facture->client->client_type] ?? '' ?></td>
                                        <td><?= @$type_docs[$facture->type_doc_id] ?? '--' ?></td>
                                        <td>
                                            <?php if ($facture->commercial) : ?>
                                                <img alt="Image" src="<?= $facture->commercial->url_photo ?>" class="avatar" data-title="<?= $facture->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right"><?= $facture->get('MontantHT') ?></td>
                                        <td class="text-right"><?= $facture->get('TotalTtcWithCurrency') ?></td>
                                        <td><?= $facture->reste_echeance_impayee ?> €</td>
                                        <td><div class="table-status-wrap"><i class="fa fa-circle <?= $facture->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_factures_status[$facture->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_factures_status[$facture->status] ?></div></td>
                                        <td>
                                            <?php if (!$facture->is_in_sellsy): ?>
                                                <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $facture->id]) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'historique', $facture->id]) ?>" >Voir l'historique</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $facture->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $facture->id, 1]) ?>">Modifier le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]) ?>" target="_blank">Imprimer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]).'?forceGenerate=1' ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $facture->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#form_client_2" data-title="Lier à un 2ème client (<?= $facture->indent ?>)" data-devi="<?= $facture->id ?>" >Lier à un 2ème client </a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Changer le commercial</a>
                                                        <a href="javascript:void(0);" class="dropdown-item duplicate-facture" data-toggle="modal" data-target="#add_devis_factures" data-title="Dupliquer la facture" data-submit="Dupliquer" data-href="<?= $this->Url->build(['action' => 'duplicatFacture', $facture->id]) ?>">Dupliquer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'toAvoir', $facture->id]) ?>">Convertir en avoir</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $facture->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#form_client_2" data-title="Lier à un 2ème client (<?= $facture->indent ?>)" data-devi="<?= $facture->id ?>" >Lier à un 2ème client </a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Changer le commercial</a>

                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?= $this->form->end() ?>

                <div class="mt-4 clearfix"><?= $this->element('tfoot_pagination') ?></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var modelDevisFactures = <?php echo json_encode($modelDevisFactures); ?>;
    var modelSousCategories = <?php echo json_encode($modelSousCategories); ?>;
</script>
