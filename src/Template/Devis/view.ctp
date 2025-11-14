<?= $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('gif/gif.css', ['block' => true]) ?>
<?= $this->Html->script('gif/gif.js', ['block' => true]); ?>
<?= $this->Html->css('devis/view.css?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/view.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?php $this->assign('title', 'Devis ' . $devisEntity->indent . ' : ' . $devisEntity->client->full_name) ; ?>

<?php $this->start('custom_title') ?>
    <?php if($devisEntity->is_model) : ?>
    <div id="id_nom_du_model" ><h1 class="m-0 top-title"><strong>Nom du modèle :</strong> <?= $devisEntity->model_name ?>  </h1></div>
    <?php else : ?>
    <div class="row m-l-20">
        <h1 class="m-0 top-title"><?= $devisEntity->indent ?> <span class="title-separator">&nbsp;| &nbsp;</span></h1><?= $this->Html->image($devisEntity->commercial->url_photo,['width' => 150, 'class'=>'avatar header-avatar']) ?> <h3 class="card-title header-commercial"><?= $devisEntity->commercial->full_name ?></h3>
    </div>
    <?php endif; ?>
<?php $this->end() ?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <!--a  href="<?= $this->Url->build(['controller' => 'devis', 'action' => 'paiement', $devisEntity->id, 'test' => 1]) ?>" class="btn btn-rounded btn-primary btn-duplicate-pdf <?= $devisEntity->is_model?'hide':'' ?>">Test paiement</a-->
        <a data-toggle="modal" href="#duplicat_devis" class="btn btn-rounded btn-primary btn-duplicate-pdf <?= $devisEntity->is_model?'hide':'' ?>">Dupliquer</a>
        <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => 'add', $devisEntity->id]) ?>" class="btn btn-rounded btn-primary save_devis btn-save-pdf <?= $devisEntity->is_in_sellsy?'hide':'' ?>">Éditer</a>
        <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => $devisEntity->is_model?'modelList':'index']) ?>" class="btn btn-rounded btn-inverse btn-quit-pdf">Quitter</a>
    </div>
<?php $this->end() ?>

<div class="m-l-20">
    <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => $devisEntity->is_model?'modelList':'index']) ?>">Liste des devis</a>
</div>
<div class="pdf-content-view-wrapper row m-t-20">
    <div class="col-3">
        <div class="card pdf-main-info-wrapper">
            <div class="card-body">
                <h3>Devis Selfizee</h3>
                <h6><?= @$devisEntity->devis_type_doc->nom ?></h6>
                <div class="row show-list-status main-select-status">
                    <div class="col-9 status-devis">
                        <small>
                            <i class="fa fa-circle <?= $devisEntity->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devisEntity->status] ?>" data-original-title="Brouillon"></i>
                            <?= @$devis_status[$devisEntity->status] ?>
                        </small>
                    </div>
                    <div class="col-3">
                        <i class="fa fa-sort-desc" aria-hidden="true" ></i>
                    </div>
                </div>
                <div class="liste-status hide">
                    <?= $this->Form->control('status', ['options' => $devis_status, 'label' => false, 'value' => $devisEntity->status, 'id' => 'change_status']); ?>
                    <input type="hidden" id="devis_id" value="<?= $devisEntity->id ?>">
                </div>
                <div class="m-t-10">
                    <a data-toggle="modal" href="#liste_historique" >Voir historique</a>
                </div>
                <hr>
                <div class="inner-pdf-detail-wrapper">
                    <div class="pdf-info-wrap">
                        Client <br>
                        <?php if ($devisEntity->client) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $devisEntity->client->id]) ?>"><?= $devisEntity->client->nom?></a>
                        <?php else : ?>
                            <?= $devisEntity->client_nom ?>
                        <?php endif; ?>
                    </div>
                    <div class="pdf-info-wrap">
                        Date du document <br>
                        <b><?= $devisEntity->date_crea->format('d/m/Y') ?></b>
                    </div>

                    <?php if ($devisEntity->total_ht_client) : ?>
                    <div class="pdf-info-wrap">
                        <h4 style="border-bottom: 1px solid grey;">Total client</h4>
                        <div class="m-t-15">
                            Montant HT <br>
                            <b><?= $this->Utilities->formatCurrency($devisEntity->total_ht_client) ?></b>
                        </div>
                        <div class="m-t-15">
                            Montant TTC <br>
                            <b><?= $this->Utilities->formatCurrency($devisEntity->total_ttc_client) ?></b>
                        </div>

                        <br>
                        <h4 style="border-bottom: 1px solid grey;">Total interne</h4>
                    </div>
                    <?php endif; ?>

                    <div class="pdf-info-wrap">
                        Montant HT <br>
                        <b><?= $devisEntity->get('TotalHtWithCurrency') ?></b>
                    </div>
                    <div class="pdf-info-wrap">
                        Montant TTC <br>
                        <b><?= $devisEntity->get('TotalTtcWithCurrency') ?></b>
                    </div>
                    <div class="pdf-info-wrap <?= $devisEntity->is_model? 'hide':'' ?>">
                        Lien public <br>
                        <?= $devisEntity->short_links ?  '<a href="' . $domaine . $devisEntity->short_links[0]->short_link . '"  target="_blank">'. $domaine . $devisEntity->short_links[0]->short_link .'</a>': '<a href="' . $domaine . $this->Url->build($devisEntity->get('EncryptedUrl')) . '"  target="_blank">Lien devis public </a>' ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Sauvegarder / Envoyer</h4>
                <div class="m-t-20 hide">
                    <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $devisEntity->client->id]) ?>">Envoyer par mail</a>
                </div>
                <div class="m-t-5">
                    <a href="<?= $this->Url->build(['action' => 'pdfversion', $devisEntity->id, 'download' => 'true']) ?>">Enregistrer la version pdf</a>
                </div>
                <div class="m-t-5">
                    <a href="<?= $this->Url->build(['action' => 'pdfversion', $devisEntity->id]) ?>" target="_blank">Imprimer le document</a>
                </div>
                <div class="m-t-5">
                    <a href="<?= $this->Url->build(['action' => 'add', 'is_model' => 1, 'model_devis_id' => $devisEntity->id]) ?>"  target="_blank">Convertir en modèle</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Facturation</h4>
                <div class="m-t-20">
                    <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => 'toFacture', $devisEntity->id]) ?>" target="_blank" class="">Facturer ce devis</a>
                </div>
                <div class="m-t-5 <?= $devisEntity->is_in_sellsy ? 'hide' : '' ?>">
                    <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'addSituation', 'devis_id' => $devisEntity->id]) ?>" target="_blank" class="">Créer une facture de situation</a>
                </div>
                <div class="m-t-5 <?= $devisEntity->is_in_sellsy ? 'hide' : '' ?>">
                    <a data-toggle="modal" href="#liste_facture_situation" class="<?= count($devisEntity->facture_situations) ? : 'hide' ?>">Liste facture de situation</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <iframe src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf"></iframe>
    </div>
</div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="duplicat_devis" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($newDevisEntity, ['url' => ['action' => 'DuplicatDevis', $devisEntity->id]]); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Dupliquer le document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        
                        <div class="row row-client">
                            <div class="col-md-5 mt-2 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-3" id="group_radios_client_3" name="client" value="3">
                                    <label class="custom-control-label" for="group_radios_client_3">Pour ce même client </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row row-client">
                            <div class="col-md-5 mt-2 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-1" id="group_radios_client_1" name="client" value="1" checked>
                                    <label class="custom-control-label" for="group_radios_client_1">Pour un client / prospect existant </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row col-md-12 existing-client">
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
                                        <?= $this->Form->control('new_client.cp', ['type'=>'text', 'class' => 'form-control cp', 'label' => false , 'maxlength' => 255, 'id' => 'cp']); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row ">
                                    <label class="control-label col-md-4 m-t-5">Ville</label>
                                    <div class="col-md-8 bloc-ville">
                                        <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                                        <div class="clearfix select"><?= $this->Form->control('new_client.ville', ['id' => 'select_ville', 'empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                        <div class="clearfix input d-none"><?= $this->Form->control('new_client.ville', ['label' => false, 'disabled', 'id' => 'ville']); ?></div>
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
                                        <?= $this->Form->control('new_client.groupe_client_id', ['empty' => 'Sélectionner', 'options' => $groupeClients, 'class' => 'selectpicker form-control client_id', 'data-live-search' => true, 'label' => false]); ?>
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
                                        <?= $this->Form->control('new_client.connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Séléctionner', 'class' => 'selectpicker', 'data-live-search' => true]); ?>
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
                                            <th>Tél. Portable</th>
                                            <th>Tél. Fixe</th>
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

<!-- historique -->
<div class="modal font-14" id="liste_historique" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Historique</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div class="related">
                    
                    <table class="table table-striped" >
                        <tr class="bold">
                            <th scope="col"><?= __('Action') ?></th>
                            <th scope="col"><?= __('Date') ?></th>
                            <th scope="col"><?= __('Heure') ?></th>
                            <th scope="col"><?= __('User') ?></th>
                        </tr>
                        
                        <?php if (!empty($devisEntity->statut_historiques)) : ?>
                            <?php foreach ($devisEntity->statut_historiques as $historique) { ?>
                            <tr>
                                <td>
                                    <i class="fa fa-circle <?= $historique->statut_document ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$historique->statut_document] ?>" data-original-title="Brouillon"></i> 
                                    <?= @$devis_status[$historique->statut_document] ?>
                                </td>
                                <td><?= $historique->time->i18nFormat('dd/MM/yy', 'Europe/Paris') ?></td>
                                <td><?= $historique->time->i18nFormat('HH:mm', 'Europe/Paris') ?></td>
                                <td>
                                    <?php if ($historique->user) : ?>
                                        <img alt="Image" src="<?= $historique->user->url_photo ?>" class="avatar" data-title="<?= $historique->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        <img alt="Image" src="<?= $commercial->url_photo ?>" class="avatar" data-title="Mail Jet" data-toggle="tooltip" />
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } ?>
                        <?php endif; ?>
                        
                        <tr>
                            <td>Création devis</td>
                            <td><?= $devisEntity->created->format('d/m/y') ?></td>
                            <td><?= $devisEntity->created->i18nFormat('HH:mm', 'Europe/Paris')  ?></td>
                            <td><img alt="Image" src="<?= $devisEntity->commercial?$devisEntity->commercial->url_photo : '' ?>" class="avatar" data-title="<?= $devisEntity->commercial?$devisEntity->commercial->get('FullNameShort') : '-' ?>" data-toggle="tooltip" /></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Fermer</span> </button>
            </div>
        </div>
    </div>
</div>

<div class="modal font-14" id="liste_facture_situation" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Facture de situations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div class="related">
                    <?php if (!empty($devisEntity->facture_situations)) : $total_ht = $total_ttc = 0?>
                    <table class="table table-striped" >
                        <tr>
                            <th scope="col"><?= __('Indent') ?></th>
                            <th scope="col"><?= __('Numero') ?></th>
                            <th scope="col"><?= __('Montant HT') ?></th>
                            <th scope="col"><?= __('Montant TTC') ?></th>
                        </tr>
                        <?php foreach ($devisEntity->facture_situations as $situation) { 
                                    $total_ht += $situation->total_ht;
                                    $total_ttc += $situation->total_ttc;
                        ?>
                        <tr>
                            <td><?= $this->Html->link($situation->indent, ['controller' => 'DevisFactures', 'action' => 'view', $situation->id], ["escape" => false]);?></td>
                            <td><?= $situation->numero ?></td>
                            <td><?= $situation->total_ht ?></td>
                            <td><?= $situation->total_ttc ?></td>
                        </tr>
                        <?php } ?>
                        
                        <tr>
                            <td colspan="2"><b>Total HT : </b><?= $total_ht ?></td>
                            <td colspan="2"><b>Total TTC : </b><?= $total_ttc ?></td>
                        </tr>
                    </table>
                    <?php else : ?>
                        <p>Aucune facture de situation.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Fermer</span> </button>
            </div>
        </div>
    </div>
</div>

