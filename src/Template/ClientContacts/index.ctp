<?= $this->Html->css('table-uniforme', ['block' => true]) ?>
<?= $this->Html->css('clients/client.css', ['block' => true]) ?>
<?= $this->Html->css('contacts/contact_form.css', ['block' => true]) ?>
<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?><?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('Clients/clients.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('contacts/contact_client.js?' . time(), ['block' => 'script']); ?>

<?php

    $this->assign('title', $type == 'person' ? 'Contact particuliers' : 'Contact professionnel');

    $titrePage = "Liste des contacts clients " . ($type == 'person' ? 'particuliers' : 'professionnel');
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );

    $this->Breadcrumbs->add($titrePage);

    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<?php $this->start('actionTitle'); ?>
<!--a href="javascript:void(0);" data-toggle="modal" data-target="#edit_contact"  data-href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-rounded pull-right hidden-sm-down btn-success mr-2 add-contact">Ajouter</a-->

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
                           <?php  echo $this->Form->create(null, ['type' => 'get' ,'role'=>'form']);   ?>
                                <div class="filter-list-wrapper client-contact-filter-wrapper">
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher par client']);  ?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('contact_key',['value'=> $contact_key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher par contact client']);  ?>
                                    </div>
                                    <div class="filter-block hide">
                                        <?php echo $this->Form->control('type', ['label' => false ,'options'=>$genres, 'value'=> $type, 'class'=>'form-control select2' ,'empty'=>'Séléctionnez le type '] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('groupe_client_id', ['label' => false ,'options'=>$groupeClients, 'value'=> $groupe_client_id, 'class' => 'selectpicker', 'data-live-search' => true, 'empty'=>'Groupe de clients ', 'id' => ''] );?>
                                    </div>
                                    <div class="filter-block">
                                        <?php echo $this->Form->control('type_contrats._ids', ['multiple' => true, 'label' => false ,'options' => $filtres_contrats, 'default' => @$type_contrats['_ids'], 'class'=> 'form-control select2' ,'data-placeholder'=>'Type contrat'] );?>
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

                    <div class="table-responsive clearfix">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('Clients.nom', 'Nom') ?></th>
                                    <th><?= $this->Paginator->sort('GroupeClients.nom', 'Groupe Client') ?></th>
                                    <th><?= $this->Paginator->sort('client_type', 'Genre') ?></th>
                                    <th><?= $this->Paginator->sort('type_commercial', 'Type commercial') ?></th>
                                    <th><?= $this->Paginator->sort('Clients.created', 'Date ajout') ?></th>
                                    <th>Contact</th>
                                    <th>Devis</th>
                                    <th>Facture</th>
                                    <th>Avoir</th>
                                    <th>Borne(s)</th>
                                    <th>Contrat(s)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hide"></tr>
                                 <?php foreach ($clients as $client): ?>
                                    <tr>
                                        <?php if($client->client_type == 'corporation' && $client->enseigne) : ?>
                                            <td><?= $this->Html->link(h($client->nom) . ' - ' . $client->enseigne, ['controller'=> 'Clients', 'action' => 'fiche', $client->id], ['escape' => false]) ?></td>
                                        <?php else : ?>
                                            <td><?= $this->Html->link(h($client->nom), ['controller'=> 'Clients', 'action' => 'fiche', $client->id], ['escape' => false]) ?></td>
                                        <?php endif; ?>
                                        <td><?= $client->groupe_client?$client->groupe_client->nom:'-' ?></td>
                                        <td><?= $genres[$client->client_type] ?? '-' ?></td>
                                        <td><?= $type_commercials[$client->type_commercial] ?? '-' ?></td>
                                        <td><?= $client->created->format('d/m/Y') ?></td>
                                        <td><?= count($client->client_contacts) ?></td>
                                        <td><?= $client->get('CountDevis') ?></td>
                                        <td><?= $client->get('CountFactures') ?></td>
                                        <td><?= $client->get('CountAvoirs') ?></td>
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
                                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#edit_contact"  data-href="<?= $this->Url->build(['action' => 'add']) ?>" data-client="<?= $client->id ?>" class="add-contact dropdown-item">Ajouter contact</a>
                                                    <?= $this->Html->link('Modifier le client', ['controller'=> 'Clients', 'action' => 'add', $client->id], ['escape' => false, 'class'=> "dropdown-item"]) ?> 
                                                    <?= $this->Form->postLink('Supprimer', ['controller'=> 'Clients', 'action' => 'delete-client', $client->id], ['confirm' => __('Êtes-vous sûr de vouloir supprimer?'), 'escape' => false, 'class'=> "dropdown-item"]) ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php if (!empty($client->client_contacts)): ?>
                                    <tr class="client-contact">
                                        <td colspan="12">
                                            <table class="table table-uniforme">
                                                <tbody>                                                
                                                    <?php foreach ($client->client_contacts as $key => $clientContact): ?>
                                                        <tr>
                                                            <td width="15%"><?= $clientContact->prenom?:"--" ?></td>
                                                            <td width="10%"><?= $clientContact->nom?:"--" ?></td>
                                                            <td width="10%"><?= $clientContact->position?:"--" ?></td>
                                                            <td width="20%"><?= $clientContact->email?:"--" ?></td>
                                                            <td width="10%"><?= $clientContact->tel?:"--" ?></td>
                                                            <td width="10%"><?= $clientContact->telephone_2?:"--" ?></td>
                                                            <td width="5%">
                                                                <?= $this->Html->link('<i class="fa fa-eye text-inverse" style="margin-right:15px"></i>', ['action' => 'view', $clientContact->id], ["escape"=>false]) ?>
                                                                <a href="javascript:void(0);" class="edit-contact" data-toggle="modal" data-target="#edit_contact" data-client="<?= $client->id ?>" data-contact="<?= $clientContact->id ?>"  data-href="<?= $this->Url->build(['action' => 'edit', $clientContact->id]) ?>"><i class="fa fa-pencil text-inverse"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($newContact, ['id' => 'contact']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modification contact </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <!--div class="mt-4 row col-md-12 client">
                        <div class="col-md-6 row">
                            <label class="control-label col-md-2 m-t-5">Genre</label>
                            <div class="col-md-10">
                                <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-genre', 'empty' => 'Sélectionner' , 'value' => $type]) ?>
                            </div>
                        </div>

                        <div class="col-md-6 row">
                            <label class="control-label col-md-2 m-t-5">Client</label>
                            <div class="col-md-10">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control test', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                            </div>
                        </div>
                    </div-->
                    <input type="hidden" name="client_id" id="client_id">
                    <?= $this->element('../ClientContacts/form_contact') ?>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
