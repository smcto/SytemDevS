<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('ventes/index.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('ventes_consommables/ventes_consommables.js?'.time(), ['block' => true]); ?>

<?php
    $this->assign('title', 'Ventes consommables');
    $titrePage = "Liste ventes options / consommables" ;

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
    <?php if ($consommable_statut == null): ?>
        <?= $this->Html->link('Commande consommable expédiée', ['controller' => 'VentesConsommables', 'action'=> 'index', 'expedie'], ['escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-primary mr-2" ]); ?>
    <?php else: ?>
        <?= $this->Html->link('Commande consommable non expédiée', ['controller' => 'VentesConsommables', 'action'=> 'index'], ['escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-primary mr-2" ]); ?>
    <?php endif ?>
    <?= $this->Html->link('Créer vente option / consommable', ['controller' => 'VentesConsommables', 'action'=> 'add'], ['escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-success mr-2" ]); ?>
<?php $this->end(); ?>

<div class="modal fade" id="change-state" role="dialog">
    <div class="modal-dialog modal-lg">

        <?= $this->Form->create(false, ['type' => 'file']); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mettre à jour l'état de la commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
    
                    <div class="alert-modal alert d-none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="msg"></div>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Choisir parmi la liste</label>
                        <?= $this->Form->select('consommable_statut', $vente_etat_consommables, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker vente_statut']); ?>
                    </div>

                    <div class="form-group is_expedie d-none">
                        <label for="date_depart_atelier">Date de départ de l'atelier *</label>
                        <?= $this->Form->text('date_depart_atelier', ['type' => 'date', 'id' => 'date_depart_atelier']); ?>
                    </div>

                    <div class="form-group is_partiel_expedie d-none">
                        <!-- AJAX -->
                    </div>
    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save">Enregistrer</button>
                </div>
            </div>
        <?= $this->form->end() ?>

    </div>
</div>

<div class="card">
    <div class="card-body">

        <?= $this->Form->create(null, ['type' => 'GET', 'role'=>'form']); ?>
            <div class="row">

                <div class="col-md-2">
                    <?= $this->Form->control('client', ['default' => $client_id, 'options' => $clientsCorporations, 'empty' => 'Client', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->control('groupe_client', ['default' => $groupe_client_id, 'options' => $groupeClients, 'empty' => 'Réseau client', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->control('user', ['default' => $user_id, 'options' => $users, 'empty' => 'Commercial', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->select('consommable_statut', $vente_etat_consommables, ['default' => $statut_consommable ,'empty' => 'Etat', 'class' => 'selectpicker vente_statut']); ?>
                </div>

                <div class="col-md-3">
                    <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                    <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                </div>
            </div>
        <?= $this->Form->end(); ?>
        

        <div class="row m-t-5">
            <?php foreach ($countVentes as $key => $nombre) : ?>
                <?php if ($key != 'expedie'): ?>
                    <?php $couleur = str_replace('text-', 'card-', $vente_consommable_couleurs[$key]); ?>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-4">
                        <div class="card card-inverse <?= $couleur ?>">
                            <div class="box text-center">

                                <?php if ($nombre > 1): ?>
                                    <h1 class="font-light text-white"><?= $nombre ?></h1><h6 class="text-white"><?=@$vente_etat_consommables[$key]?></h6>
                                <?php endif ?>

                                <?php if ($nombre <= 1): ?>
                                    <h1 class="font-light text-white"><?= $nombre ?></h1><h6 class="text-white"><?=@$vente_etat_consommables[$key]?></h6>
                                <?php endif?>

                            </div>
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th># Commande</th>
                        <th>Enseigne</th>
                        <th>Commercial</th>
                        <th>Parc</th>
                        <th>Commande accessoires</th>
                        <th>Commande consommables</th>
                        <th>Date ajout</th>
                        <th>Date livraison</th>
                        <th class="<?= $consommable_statut == 'expedie' ? 'd-none' : '' ?>">Etat</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php  foreach ($ventesConsommables as $key => $ventesConsommable): ?>
                        <tr>
                            <td><?= $this->Html->link($ventesConsommable->id, ['action' => 'view', $ventesConsommable->id]); ?></td>
                            <td><?= $ventesConsommable->client->nom ?></td>
                            <td><?= $ventesConsommable->user->nom ?></td>
                            <td><?= $ventesConsommable->parc->nom ?></td>
                            <td>
                                <?php $devisProduitsConsomables = collection($ventesConsommable->ventes_has_devis_produits)->match(['devis_produit.catalog_produit.catalog_sous_categories_id' => 2 /*Accessoires*/]) ?>
                                <?php foreach ($devisProduitsConsomables as $key => $devisProduitsConsomable): ?>
                                    <?= $devisProduitsConsomable->qty ?> : <?= $devisProduitsConsomable->devis_produit->reference ?> <br>
                                <?php endforeach ?>
                            </td>

                            <td>
                                <?php $devisProduitsConsomables = collection($ventesConsommable->ventes_has_devis_produits)->match(['devis_produit.catalog_produit.catalog_sous_categories_id' => 16 /*Consommables*/]) ?>
                                <?php foreach ($devisProduitsConsomables as $key => $devisProduitsConsomable): ?>
                                    <?= $devisProduitsConsomable->qty ?> : <?= $devisProduitsConsomable->devis_produit->reference ?> <br>
                                <?php endforeach ?>
                            </td>
                            <td><?= $ventesConsommable->created->format('d/m/Y') ?></td>
                            <td><?= $ventesConsommable->livraison_date->format('d/m/Y') ?></td>
                            <td class="<?= $consommable_statut == 'expedie' ? 'd-none' : '' ?>">
                                <i class="fa fa-circle <?= @$vente_consommable_couleurs[$ventesConsommable->consommable_statut] ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$vente_etat_consommables[$ventesConsommable->consommable_statut] ?>"></i>
                           </td>
                            <td>
                                <div class="dropdown d-inline container-ventes-actions">
                                    <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a href="javascript:void(0);" class="dropdown-item change-state" data-consommable-statut="<?= $ventesConsommable->consommable_statut ?>" data-id="<?= $ventesConsommable->id ?>" data-action="<?= $this->Url->build(['action' => 'majState', $ventesConsommable->id]) ?>" data-toggle="modal" data-target="#change-state">Modifier état</a>
                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $ventesConsommable->id]) ?>">Modifier fiche</a>
                                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $ventesConsommable->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>