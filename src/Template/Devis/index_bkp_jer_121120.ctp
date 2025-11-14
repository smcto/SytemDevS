<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>
<?= $this->Html->css('devis/add-client-in-devis.css?time='.time(), ['block' => true]); ?>
<?= $this->Html->css('devis/index.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('gif/gif.css', ['block' => true]) ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>

<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/index.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('gif/gif.js', ['block' => true]); ?>
<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>


<?php

$titrePage = "Liste devis" ;

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
]

?>

<?php $this->start('actionTitle') ?>
    <a data-toggle="modal" href="#add_devis" data-title="Créer un devis" data-submit="Créer le document" data-href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-success create-devis">Créer un nouveau</a>
    <!-- <a href="<?= $this->Url->build([1]) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste devis</a>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste devis manager</a> -->
    <?php if ($this->request->getQuery('test')): ?>
        <a href="<?= $this->Url->build(['action' => 'import']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Importer</a>
    <?php endif ?>
<?php $this->end() ?>


<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisEntity, ['url' => ['action' => 'editClient'] ,'id' => 'edit_client_form']); ?>
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
                                <input type="hidden" name="devi_id" id="devi_id">
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

<!-- BEGIN MODAL -->
<div class="modal fade" id="add_devis" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisEntity); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Créer un devis</h5>
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
                                    <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control test', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
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
                                        <?= $this->Form->control('new_client.cp', ['type'=>'text', 'class' => 'form-control cp', 'label' => false , 'id' => 'cp', 'maxlength' => 255]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row ">
                                    <label class="control-label col-md-4 m-t-5">Ville</label>
                                    <div class="col-md-8 bloc-ville">
                                        <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                                        <div class="clearfix select"><?= $this->Form->control('new_client.ville', ['empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                        <div class="clearfix input d-none"><?= $this->Form->control('new_client.ville', ['label' => false, 'disabled', 'id' => 'ville']); ?></div>
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
                                    <label class="control-label col-md-4 m-t-5">Type</label>
                                    <div class="col-md-8 row my-auto" id="types">
                                        <div class="col-6 mt-2"><?= $this->Form->control('new_client.is_location_event', ['type' => 'checkbox' ,'label' => 'Location event']); ?></div>
                                        <div class="col-3 mt-2"><?= $this->Form->control('new_client.is_vente', ['type' => 'checkbox' ,'label' => 'Vente']); ?></div>
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
                                        <?= $this->Form->control('new_client.connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Sélectionner']); ?>
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
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr class="d-none clone added-tr">
                                            <td><?= $this->Form->control('new_client.client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <hr>
                        </div>

                        <fieldset class="fieldset-devis">
                            <legend class="legend-fieldset-devis">Paramètres du document:</legend>
                            <div class="row row-client">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Catégorie modèle devis</label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('category_model_devis_id', ['id' => 'category', 'options' => $modelCategories, 'label' => false, 'empty' => 'Catégorie du modèle', 'data-placeholder' => 'Catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row row-client hide sous-cat m-t-10">
                                <div class="col-md-5 m-t-10">
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('sous_category_model_devis_id', ['id' => 'sous_category', 'options' => [], 'label' => false, 'empty' => 'Sous catégorie du modèle', 'data-placeholder' => 'Sous catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row row-client m-t-10">
                                <div class="col-md-5 m-t-10">
                                    <label class=""> Créer à partir du modèle </label>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('model_devis_id', ['id' => 'model_devis', 'options' => $modelDevis, 'label' => false, 'empty' => 'Modèle devis', 'data-placeholder' => 'Modèle devis', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                                </div>
                            </div>
                            <div class="row row-client m-t-30">
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
                                    <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'id' => 'type_doc_id', 'label' => false, 'class' => 'form-control select2', 'empty' => 'Type de document','data-placeholder' => 'Type de document', 'required','style' => 'width:100%']); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Créer le document'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<div class="modal fade" id="devis_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'form-edit-status']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état du devis <span class="num_devis"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mt-2 m-b-30">
                                <label>Etat : </label>
                            </div>
                            <div class="col-md-8">
                                <?= $this->Form->control('status', ['id' => 'modif_status', 'options' => $devis_status, 'empty' => 'Sélectionner', 'label' => false,'required']) ?>
                                <input type="hidden" name="devis_id" id="devis_id">
                            </div>
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
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'form-filtre mt-4']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="row custom-col-width <?= $periode == 'custom_threshold' ? 'custom-col-width-small' : '' ?>">
                        <div class="col-md-1">
                            <?= $this->Form->control('client', ['label' => false, 'default' => $client, 'placeholder' => 'Rechercher par client']); ?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->control('contact_client', ['label' => false, 'default' => $contact_client, 'placeholder ' => 'Rechercher par contact client']); ?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->control('keyword', ['label' => false, 'default' => $keyword, 'placeholder' => 'Rechercher document','id'=>'id_keyword']); ?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->control('montant', ['label' => false, 'default' => $montant, 'placeholder' => 'Rechercher par montant']); ?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => false, 'default' => $ref_commercial_id, 'class' => 'selectpicker', 'empty' => 'Contact','id'=>'id_ref_commercial_id']); ?>
                        </div>

                        <div class="col-md-1">
                            <?= $this->Form->control('client_type', ['label' => false, 'options' => $genres, 'default' => $client_type, 'class' => 'selectpicker', 'empty' => 'Type','id'=>'id_client_type']); ?>
                        </div>

                        <div class="col-md-1">
                            <?= $this->Form->control('antennes_id', ['label' => false, 'default' => $antennes_id, 'class' => 'selectpicker', 'data-live-search' => true, 'empty' => 'Antennes','id'=>'id_antenne_id']); ?>
                        </div>

                        <div class="col-md-1">
                            <?= $this->Form->control('periode', ['label' => false, 'default' => $periode, 'options' => $periodes, 'class' => 'selectpicker periode', 'empty' => 'Période','id'=>'id_periode']); ?>
                        </div>

                        <div class="col-md-1 container-mois <?= $periode == 'list_month' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('mois_id', ['label' => false, 'default' => $mois_id, 'options' => $mois, 'class' => 'selectpicker']); ?>
                        </div>

                        <div class="col-md-1 container_date_threshold <?= $periode == 'custom_threshold' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false, 'value' => $date_threshold, 'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
                        </div>

                        <div class="col-md-1">
                            <?= $this->Form->control('status', ['options' => $devis_status, 'label' => false, 'default' => $status, 'class' => 'selectpicker', 'empty' => 'Etat','id'=>'id_status']); ?>
                        </div>

                        <div class="col-md-1">
                            <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'Type de document', 'default' => $type_doc_id]); ?>
                        </div>

                        <div class="col-md-2 col-filter">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
                <!-- <input type="hidden" id="id_inSellsy" value="<?= $is_in_sellsy ?>"> -->

                <div class="row-fluid d-block clearfix mt-3">
                </div>
                <div class="float-left mb-5">
                    <div class="text-uppercase">Total Devisé HT : <strong>  <?= $this->Utilities->formatCurrency($total_ht) ?></strong></div>
                    <div class="text-uppercase">Total Devisé TTC : <strong> <?= $this->Utilities->formatCurrency($total_ttc) ?></strong></div>
                </div>
                <div class="clearfix"></div>

                <?= $this->Form->create(false, ['url' => ['action' => 'multipleAction'], 'class' => 'multi-actions']); ?>
                    <div class="row bloc-actions d-none">
                        <div class="col-md-3">
                            <?= $this->Form->control('action', ['options' => ['zip' => 'Télécharger au format ZIP', 'delete' => 'Supprimer'], 'type' => 'select', 'label' => false, 'class' => 'custom-selectpicker', 'empty' => 'Sélectionner une action']); ?>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->submit('Valider', ['class' => 'btn btn-primary submit-pultiple']); ?>
                        </div>
                    </div>
                    <div class="clearfix pb-2">
                        <a href="javascript:void(0);" class="active-col-checkbox float-right">Sélectionner des éléments</a>
                    </div>
                    <div class="table-responsive clearfix">
                        <table class="table table-striped devis-table liste-items" id="div_table_bornes">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th><?= $this->Paginator->sort('indent', 'N°') ?></th>
                                    <th><?= $this->Paginator->sort('Clients.nom', 'Client/Prospect') ?></th>
                                    <th>Antenne(s)</th>
                                    <th><?= $this->Paginator->sort('Clients.client_type', 'Type') ?></th> <!-- Corporation (pro) ou person (particulier) -->
                                    <th><?= $this->Paginator->sort('model_type', 'Borne') ?></th>
                                    <th><?= $this->Paginator->sort('date_evenement', 'Event') ?></th>
                                    <th><?= $this->Paginator->sort('DevisTypeDocs.nom', 'Document') ?></th>
                                    <th><?= $this->Paginator->sort('Commercial.nom', 'Contact') ?></th>
                                    <th><?= $this->Paginator->sort('date_crea', 'Date devis') ?></th>
                                    <th class="text-right"><?= $this->Paginator->sort('total_ht', 'HT') ?></th>
                                    <th class="text-right"><?= $this->Paginator->sort('total_ttc', 'TTC') ?></th>
                                    <!-- <th>Règlement</th> -->
                                    <th><?= $this->Paginator->sort('date_sign_before', 'Expire') ?></th>
                                    <th><?= $this->Paginator->sort('status', 'Etat') ?></th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listeDevis as $key => $devis): ?>

                                    <tr sellsy-doc-id="<?= $devis->sellsy_doc_id ?>" sellsy-client-id="<?= $devis->sellsy_client_id ?>">
                                        <td class="col-checkbox d-none"><?= $this->Form->control("devis.$devis->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $devis->get('ObjetAsTitle') ?>" href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>"><?= $devis->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $devis->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($devis->client): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $devis->client->id]) ?>"><?= $devis->client->full_name ?></a>
                                            <?php else: ?>
                                                <?= $devis->client_nom ?>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $devis->get('ListeAntennes'); ?></td>
                                        <td><?= $genres_short[@$devis->client->client_type] ?? '' ?></td>
                                        <td><?= @$type_bornes[$devis->model_type] ?? '' ?></td>
                                        <td>
                                                <?= $devis->date_evenement?$devis->date_evenement->format('d/m/y'):"--" ?>
                                        </td>
                                        <td><?= @$type_docs[$devis->type_doc_id] ?? '--' ?></td>
                                        <td>
                                            <?php if ($devis->commercial) : ?>
                                                <img alt="Image" src="<?= $devis->commercial->url_photo ?>" class="avatar" data-title="<?= $devis->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $devis->date_crea?$devis->date_crea->format('d/m/y') : "-" ?></td>
                                        <td class="text-right"><?= $devis->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $devis->get('TotalTtcWithCurrency') ?></td>
                                        <!-- <td><?php count($devis->devis_reglements) ?></td> -->
                                        <td>
                                            <?php if (!$devis->is_in_sellsy): ?>
                                                <?= $devis->date_sign_before ? $devis->date_sign_before->format('d/m/y') : '' ?>
                                            <?php else: ?>
                                                <?= $devis->date_validite ? $devis->date_validite->format('d/m/y') : '' ?>
                                            <?php endif ?>
                                        </td>
                                        <td><i class="fa fa-circle <?= $devis->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devis->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_status[$devis->status] ?></td>
                                        <td>
                                            <?php if (!$devis->is_in_sellsy): ?>
                                                <div class="dropdown d-inline container-ventes-actions">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item delete-devis" href="javascript:void(0);">Supprimer</a>
                                                        <input type="hidden" value="<?= $devis->id ?>" id="delete-devi-id">
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'historique', $devis->id]) ?>" >Voir l'historique</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $devis->id, 1]) ?>">Modifier le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id]) ?>" target="_blank">Imprimer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id]).'?forceGenerate=1' ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($devis->get('EncryptedUrl')) ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $devis->id]) ?>" data-value='<?= $devis->status ?>' data-indent='<?= $devis->indent ?>' data-devis="<?= $devis->id ?>">Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $devis->id]) ?>" data-value='<?= $devis->type_doc_id ?>' data-indent='<?= $devis->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $devis->indent ?>)" data-devi="<?= $devis->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item duplicate-devis" data-toggle="modal" data-target="#add_devis" data-title="Dupliquer le devis" data-submit="Dupliquer" data-href="<?= $this->Url->build(['action' => 'duplicatDevis', $devis->id]) ?>">Dupliquer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'toFacture', $devis->id]) ?>">Facturer ce devis</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $devis->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                            <a class="dropdown-item" href="<?= $this->Url->build($devis->get('SellsyDocUrl')) ?>">Url sellsy</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="dropdown d-inline container-ventes-actions">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build($devis->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($devis->get('EncryptedUrl')) ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $devis->id]) ?>" data-value='<?= $devis->status ?>' data-indent='<?= $devis->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $devis->id]) ?>" data-value='<?= $devis->type_doc_id ?>' data-indent='<?= $devis->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $devis->indent ?>)" data-devi="<?= $devis->id ?>" >Affecter à un autre client</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $devis->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($devis->get('SellsyDocUrl')) ?>">Url sellsy</a>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
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
    var modelDevis = <?php echo json_encode($modelDevis); ?>;
    var modelSousCategories = <?php echo json_encode($modelSousCategories); ?>;
    var devis_status = <?php echo json_encode($devis_status) ?>;
</script>
