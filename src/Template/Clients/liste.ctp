<?= $this->Html->css('clients/client.css', ['block' => true]) ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'css']); ?>

<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('Clients/clients.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?php
    $titrePage = "Clients / prospects" ;
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
?>

<?php $this->start('actionTitle'); ?>
    <?= $this->Html->link('Ajouter', ['action'=> 'add'], ['escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-success mr-2" ]); ?>

     <div class="pull-right loadingClient">
         <svg class="kl_loadingclient" viewBox="25 25 50 50">
             <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
         </svg>
     </div>
<?php $this->end(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                           <?php  echo $this->Form->create(null, ['type' => 'get' ,'role'=>'form', 'class' => 'form-filtre']);   ?>
                                <div class="filter-list-wrapper client-filter-wrapper">
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher par client']);  ?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('contact_key',['value'=> $contact_key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher par contact client']);  ?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('type', ['label' => false ,'options'=>$genres, 'value'=> $type, 'class' => 'selectpicker', 'data-live-search' => true,'empty'=>'Sélectionnez le type '] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('type_commercial', ['label' => false ,'options'=>$type_commercials, 'value'=> $type_commercial, 'class' => 'selectpicker', 'data-live-search' => true,'empty'=>'Sélectionnez client/prospect'] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('groupe_client_id', ['label' => false ,'options'=>$groupeClients, 'value'=> $groupe_client_id, 'class' => 'selectpicker', 'data-live-search' => true,'empty'=>'Groupe de clients ', 'id' => ''] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('type_contrats._ids', ['multiple' => true, 'label' => false ,'options' => $filtres_contrats, 'default' => @$type_contrats['_ids'], 'class' => 'select2 form-control', 'data-placeholder'=>'Type contrat'] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => false, 'default' => $ref_commercial_id, 'class' => 'selectpicker', 'empty' => 'Contact','id'=>'id_ref_commercial_id']); ?>
                                    </div>
                                    <div class="filter-block">
                                        <?= $this->Form->control('adresse_key', ['value' => $adresse_key, 'empty' => 'Adresse', 'class' => 'selectpicker form-control', 'label' => false, 'options' => ['non' => 'NON', 'oui' => 'OUI']]); ?>
                                    </div>
                                    <div class="filter-block">
                                        <?= $this->Form->control('secteurs_activite', ['multiple'=> "multiple", 'value' => $secteurs_activite, 'class' => 'select2 form-control', 'data-placeholder' => "Secteur d'activité", 'label' => false, 'options' => $secteursActivites]); ?>
                                    </div>

                                    <div class="filter-block">
                                        <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                        <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'liste'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                    </div>
                                </div>

                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <?= $this->Form->create(false, ['url' => ['action' => 'multipleAction'], 'class' => 'multi-actions']); ?>
                    <div class="row bloc-actions selection-table-action d-none">
                        <div class="action-block">
                            <?= $this->Form->control('action', ['options' => ['secteurActivite' => 'Affecter à un secteur d\'activité', 'delete' => 'Supprimer'], 'type' => 'select', 'label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner une action', 'required' => true]); ?>
                        </div>
                        <div class="action-block">
                            <?= $this->Form->submit('Valider', ['class' => 'btn btn-primary submit-pultiple']); ?>
                        </div>
                    </div>

                    <div class="modal fade" id="secteur-activite" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title">Affecter à des secteurs d'activités</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row-fluid">
                                            <?= $this->Form->control('secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites form-control', 'label' => false, 'options' => $secteursActivites, 'style' => 'width:100%']); ?>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                                        <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit-secteur-activite','escape' => false]) ?>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-tbl-select-element clearfix">
                        <a href="javascript:void(0);" class="active-col-checkbox float-right">Sélectionner des éléments</a>
                    </div>
                    <div class="table-responsive clearfix">
                        <table class="table liste-items" id="client-list-table">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th><?= $this->Paginator->sort('Clients.nom', 'Nom') ?></th>
                                    <th><?= $this->Paginator->sort('GroupeClients.nom', 'Groupe') ?></th>
                                    <th><?= $this->Paginator->sort('client_type', 'Genre') ?></th>
                                    <th><?= $this->Paginator->sort('type_commercial', 'Type') ?></th>
                                    <th><?= $this->Paginator->sort('Clients.created', 'Ajout') ?></th>
                                    <th>Contact</th>
                                    <th>Adresse</th>
                                    <th>Secteur</th>
                                    <th>Comm.</th>
                                    <th>Devis</th>
                                    <th>Facture</th>
                                    <th>Avoir</th>
                                    <th>Borne(s)</th>
                                    <th>Contrat(s)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php foreach ($clients as $key => $client): ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><?= $this->Form->control("clients.$client->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                        <?php if($client->client_type == 'corporation') : ?>
                                            <td><?= $this->Html->link(h($client->nom_enseigne), ['action' => 'fiche', $client->id], ['escape' => false]) ?></td>
                                        <?php else : ?>
                                            <td><?= $this->Html->link(h($client->full_name), ['action' => 'fiche', $client->id], ['escape' => false]) ?></td>
                                        <?php endif; ?>
                                        <td><?= $client->groupe_client?$client->groupe_client->nom:'-' ?></td>
                                        <td><?= @$genres_short[$client->client_type] ?? '-' ?></td>
                                        <td><?= @$type_commercials_short[$client->type_commercial] ?? '-' ?></td>
                                        <td><?= $client->created->format('d/m/y') ?></td>
                                        <td><?= count($client->client_contacts) ?></td>
                                        <td><?= $client->get('hasAdress') ? 'OK' : 'NON' ?></td>
                                        <td><?= $client->get('listeSecteursActivites') ?? '-' ?></td>
                                        <td>
                                            <?php if ($client->devis) : ?>
                                            <div class="avatars d-flex align-self-center">
                                                <?php $users_com = []; ?>
                                                <?php foreach ($client->devis as $devis) : ?>
                                                <?php if(!in_array($devis->ref_commercial_id, $users_com)  && $devis->commercial) : $users_com[] = $devis->ref_commercial_id ?>
                                                    <img alt="Image" src="<?= $devis->commercial->url_photo ?>" class="avatar" data-title="<?= $devis->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                        
                                            <!--</div>-->
                                            <?php else : ?>
                                            --
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $client->get('CountDevis') ? $client->get('CountDevis') : '-' ?></td>
                                        <td><?= $client->get('CountFactures') ? $client->get('CountFactures') : '-' ?></td>
                                        <td><?= $client->get('CountAvoirs') ? $client->get('CountAvoirs') : '-' ?></td>
                                        <td>
                                            <?php 
                                                if($client->bornes) {
                                                    foreach ($client->bornes as $borne) {
                                                        $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                                                        echo $this->Html->link(($text), ['controller' => 'Bornes', 'action' => 'view', $borne->id]) . '<br>';
                                                    }
                                                } else {
                                                    echo "--";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php foreach ($filtres_contrats as $field => $contrat): ?>
                                                <?= $client->{$field} ? $contrat . '<br>' : '' ?> 
                                            <?php endforeach ?>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline container-bornes-actions inner-table-menu">
                                                <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#edit_client" data-client="<?= $client->id ?>"  data-href="<?= $this->Url->build(['action' => 'add', $client->id, 'referer']) ?>">Modifier</a>
                                                    <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#checkbox-secteur-activite" data-client="<?= $client->id ?>" data-href="<?= $this->Url->build(['action' => 'editSectuerActivities', $client->id]) ?>">Affecter à  des secteurs d’activités</a>
                                                    <?= $this->Html->link('Ouvrir la page de modification', ['action' => 'add', $client->id], ['escape' => false, 'class'=> "dropdown-item"]) ?> 
                                                    <a class="dropdown-item delete-client" href="javascript:void(0);">Supprimer</a>
                                                    <input type="hidden" value="<?= $client->id ?>" id="client-id">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                 <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $this->form->end() ?>

                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($client, ['id' => 'form-edit-client']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modification client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="nouveau-client">

                        <h3 class="pb-2 mb-3 bordered">Informations client</h3>

                        <div class="row">
                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5">Genre</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-type']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5 client-name">Raison sociale (*)</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('nom', ['label' => false, 'class' => 'client-required form-control', 'required']); ?>
                                </div>
                            </div>
                            <div class="col-md-6 client-lastname hide row">
                                <label class="control-label col-md-4 m-t-5">Prénom (*)</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('prenom', ['label' => false]); ?>
                                </div>
                            </div>

                            <div class="col-md-6 enseigne row">
                                <label class="control-label col-md-4 m-t-5 ">Enseigne</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('enseigne', ['label' => false, 'class' => 'form-control']); ?>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5">Adresse</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('adresse', ['type'=>'text', 'class' => 'form-control new-clients','label' => false, 'maxlength' => 255]); ?>
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
                                    <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                                    <div class="clearfix select"><?= $this->Form->control('ville', ['empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'ville-select']); ?></div>
                                    <div class="clearfix input d-none"><?= $this->Form->control('ville', ['label' => false, 'disabled']); ?></div>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5">Pays</label>
                                <div class="col-md-8">
                                    <div class="clearfix select"><?= $this->Form->control('new_client.pays_id', ['options' => $payss, 'empty' => 'Sélectionner', 'class' => 'form-control selectpicker', 'id' => 'country', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5 client-tel">Tél entreprise</label>
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
                                <label class="control-label col-md-4 m-t-5 client-mail">Email général</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('email', ['class' => 'form-control','label' => false ]); ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
                                <label class="control-label col-md-4 m-t-5">Tva Intracommunautaire</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('tva_intra_community', ['class' => 'form-control pro','label' => false]); ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
                                <label class="control-label col-md-4 m-t-5">Siren</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('siren', ['class' => 'form-control pro','label' => false]); ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
                                <label class="control-label col-md-4 m-t-5">Siret</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('siret', ['class' => 'form-control pro','label' => false]); ?>
                                </div>
                            </div>
                        </div>

                        <h3 class="pb-2 mb-3 bordered">Qualification client</h3>

                        <div class="row">
                            <div class="col-md-6 row">
                                <label class="control-label col-md-4 m-t-5">Type commercial *</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('type_commercial', ['options' => $type_commercials, 'class' => 'client-required selectpicker', 'empty' => 'Sélectionner', 'label' => false]) ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
                                <label class="control-label col-md-4 m-t-5">Type</label>
                                <div class="col-md-8 row my-auto" id="types">
                                    <?php foreach ($filtres_contrats as $fied => $label) : ?>
                                        <div class="col-6 mt-2"><?= $this->Form->control($fied, ['type' => 'checkbox' ,'label' => $label]); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
                                <label class="control-label col-md-4 m-t-5">Groupes de clients</label>
                                <div class="col-md-8">
                                    <?= $this->Form->control('groupe_client_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker client_id', 'label' => false]); ?>
                                </div>
                            </div>

                            <div class="col-md-6 row client-pro">
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
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>



<div class="modal fade" id="gerer_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($client); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Gerer les contacts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="row-fluid">
                        <button type="button" class="btn btn-primary add-data float-right mt-2 mb-4">Ajouter un contact</button>

                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th>Prénom (*)</th>
                                    <th>Nom (*)</th>
                                    <th>Fonction </th>
                                    <th>Email (*)</th>
                                    <th>Téléphone </th>
                                    <th>Téléphone 2</th>
                                </tr>
                            </thead>

                            <tbody class="default-data">
                                <?php if (isset($clientEntity)): ?>
                                    <?php if ($clientEntity->client_contacts): ?>
                                        <?php foreach ($clientEntity->client_contacts as $key => $client_contact): ?>
                                            <?php if (!$client_contact->get('IsInfosEmpty')): ?>
                                                <tr>
                                                    <td class="d-none"><?= $this->Form->hidden("client_contacts.$key.id", ['input-name' => 'id', 'label' => false, 'id' => 'email']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.prenom", ['required', 'input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.nom", ['required', 'input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                                    <td><?= $this->Form->control("client_contacts.$key.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                                    <td><a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxClients', 'action' => 'deleteContact', $client_contact->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                                </tr>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                <?php endif ?>

                                <?php $init = isset($key) ? $key+1 : 0 ?>

                                <tr>
                                    <td><?= $this->Form->control("client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>

                                    <td><?= $this->Form->control("client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="d-none clone added-tr">
                                    <td><?= $this->Form->control('client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>

                                    <td><?= $this->Form->control('client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                            
                        </table>

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

<div class="modal fade" id="checkbox-secteur-activite" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'form-checkbox-secteur-activite']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Affecter à des secteurs d'activités</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <?php foreach ($secteursActivites as $fied => $label) : ?>
                            <div class="col-4 mt-2"><?= $this->Form->control("secteurs_activites._ids.$fied", ['type' => 'checkbox' ,'label' => $label, 'value' => $fied]); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit-secteur-activite','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
