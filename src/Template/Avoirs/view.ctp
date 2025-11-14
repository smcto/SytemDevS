<?php use Cake\Routing\Router; ?>
<?= $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('avoirs/view.css?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('avoirs/view.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>

<?php 
$this->assign('title', 'Information avoir') ;
?>

<?php $this->start('custom_title') ?>
    <?php if($avoirEntity->is_model) : ?>
    <div id="id_nom_du_model" ><h1 class="m-0 top-title"><strong>Nom du modèle :</strong> <?= $avoirEntity->model_name ?>  </h1></div>
    <?php else : ?>
    <div class="row m-l-20">
        <h1 class="m-0 top-title"><?= $avoirEntity->indent ?> <span class="title-separator">&nbsp;| &nbsp;</span></h1><?= $this->Html->image($avoirEntity->commercial->url_photo,['width' => 150, 'class'=>'avatar header-avatar']) ?> <h3 class="card-title header-commercial"><?= $avoirEntity->commercial->full_name ?></h3>
    </div>
    <?php endif; ?>
<?php $this->end() ?>
    
<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <a data-toggle="modal" href="#duplicat_avoir" class="btn btn-rounded btn-primary btn-duplicate-pdf">Dupliquer</a>
        <a href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'add', $avoirEntity->id]) ?>" class="btn btn-rounded btn-primary save_devis btn-save-pdf">Éditer</a>
        <a href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'index']) ?>" class="btn btn-rounded btn-inverse btn-quit-pdf">Quitter</a>
    </div>
<?php $this->end() ?>

<div class="m-l-20">
    <a href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'index']) ?>">Liste des avoirs</a>
</div>
<div class="pdf-content-view-wrapper row m-t-20">
    <div class="col-3">
        <div class="card pdf-main-info-wrapper">
            <div class="card-body">
                <h4>Avoir selfizee</h4>
                <div class="row main-select-status">
                    <div class="col-9 status-devis">
                        <small>
                            <i class="fa fa-circle <?= $avoirEntity->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_avoirs_status[$avoirEntity->status] ?>" data-original-title="Brouillon"></i>
                                <?= @$devis_avoirs_status[$avoirEntity->status] ?>
                        </small>
                    </div>
                    <div class="col-3">
                        <i class="fa fa-sort-desc show-list-status" aria-hidden="true" ></i>
                    </div>
                </div>
                <div class="liste-status hide">
                    <?= $this->Form->control('status', ['options' => $devis_avoirs_status, 'label' => false, 'value' => $avoirEntity->status, 'id' => 'change_status']); ?>
                    <input type="hidden" id="avoir_id" value="<?= $avoirEntity->id ?>">
                </div>
                <div class="m-t-10">
                    <a href="<?= $this->Url->build(['action' => 'historique', $avoirEntity->id]) ?>" target="_blank">Voir historique</a>
                </div>
                <hr>
                <div class="inner-pdf-detail-wrapper">
                    <div class="pdf-info-wrap">
                        Client <br>
                        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $avoirEntity->client->id]) ?>"><?= $avoirEntity->client->nom?></a>
                    </div>
                    <div class="pdf-info-wrap">
                        Date du document <br>
                        <b><?= $avoirEntity->date_crea->format('d/m/Y') ?></b>
                    </div>
                    <div class="pdf-info-wrap">
                        Montant HT <br>
                        <b><?= $avoirEntity->get('TotalHtWithCurrency') ?></b>
                    </div>
                    <div class="pdf-info-wrap">
                        Montant TTC <br>
                        <b><?= $avoirEntity->get('TotalTtcWithCurrency') ?></b>
                    </div>
                    <div class="pdf-info-wrap">
                        Lien public <br>
                        <?= $avoirEntity->short_links ?  '<a href="' . $this->Url->build('/', true) . $avoirEntity->short_links[0]->short_link . '"  target="_blank">'. $this->Url->build('/', true) . $avoirEntity->short_links[0]->short_link .'</a>': '<a href="' . $this->Url->build($avoirEntity->get('EncryptedUrl')) . '"  target="_blank">Lien devis public </a>' ?>
                    </div>
                    <div class="pdf-info-wrap <?= $avoirEntity->devis_facture?'':'hide' ?>">
                        Lié à <br>
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $avoirEntity->devis_facture->id]) ?>"  target="_blank"> <?= $avoirEntity->devis_facture->indent ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Sauvegarder / Envoyer</h4>
                <div class="m-t-20">
                    <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $avoirEntity->client->id]) ?>">Envoyer par mail</a>
                </div>
                <div class="m-t-5">
                    <a href="<?= $this->Url->build(['action' => 'pdfversion', $avoirEntity->id, 'download' => 'true']) ?>">Enregistrer la version pdf</a>
                </div>
                <div class="m-t-5">
                    <a href="<?= $this->Url->build(['action' => 'pdfversion', $avoirEntity->id]) ?>" target="_blank">Imprimer le document</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9 ">
        <iframe src="<?= $this->Url->build(['action' => 'pdfversion', $avoirEntity->id]) ?>" type="application/pdf" title="devis" class="object-pdf"></iframe>
    </div>
</div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="duplicat_avoir" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($newAvoirEntity, ['url' => ['action' => 'duplicatFacture', $avoirEntity->id]]); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Dupliquer le document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <div class="col-md-5 mt-2 m-b-30">
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
                                        <?= $this->Form->control('new_client.adresse', ['type'=>'text', 'class' => 'form-control new-clients','label' => false, 'maxlength' => 255]); ?>
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
                                        <?= $this->Form->control('new_client.cp', ['type'=>'text', 'class' => 'form-control cp', 'label' => false , 'maxlength' => 255]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row ">
                                    <label class="control-label col-md-4 m-t-5">Ville</label>
                                    <div class="col-md-8 bloc-ville">
                                        <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                                        <div class="clearfix select"><?= $this->Form->control('new_client.ville', ['empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                        <div class="clearfix input d-none"><?= $this->Form->control('ville', ['label' => false, 'disabled']); ?></div>
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
                                        <?= $this->Form->control('new_client.secteurs_activites._ids', ['empty' => 'Sélectionner','multiple'=> "multiple", 'class' => 'select2 secteurs_activites client-required form-control', 'label' => false, 'options' => $secteursActivites, 'style' => 'width:100%']); ?>
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
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Dupliquer le document'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
