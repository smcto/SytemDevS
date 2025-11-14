<?= $this->Html->script('ventes_consommables/facturation', ['block' => 'script']); ?>

<?php 
    $titrePage = $breadcrumb = 'A facturer';
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($breadcrumb);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();   
?>

<?php $this->start('actionTitle'); ?>

    <?php if ($isArchive): ?>
        <?= $this->Html->link('Ventes consommables non archivées', ['action'=> 'facturations'], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php else: ?>
        <?= $this->Html->link('Ventes consommables archivées', ['action'=> 'facturations', 1], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php endif ?>

<?php $this->end(); ?>

<div class="modal fade" id="change-state" role="dialog">
    <div class="modal-dialog modal-lg">

        <?= $this->Form->create(false, []); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mettre à jour l'état de la facturation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
    
                    <div class="alert-modal alert d-none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="msg"></div>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Choisir parmi la liste *</label>
                        <?= $this->Form->select('etat_facturation', $vente_consommable_etat_facturations, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker etat_facturation']); ?>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Date *</label>
                        <?= $this->Form->text('date_facturation', ['type' => 'date', 'required', 'empty' => 'Seléctionner', 'class' => 'form-control date_facturation']); ?>
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
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th># Commande</th>
                        <th>Enseigne</th>
                        <th>Commercial</th>
                        <th>Parc</th>
                        <?php $this->start('to_delete') ?>
                            <th>Commande accessoires</th>
                            <th>Commande consommables</th>
                        <?php $this->end() ?>
                        <th>Date ajout</th>
                        <th>Date livraison</th>
                        <th>Etat facturation</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($ventesConsommables as $key => $ventesConsommable): ?>
                        <tr>
                            <td><?= $this->Html->link($ventesConsommable->id, ['action' => 'view', $ventesConsommable->id]); ?></td>
                            <td><?= $ventesConsommable->client->nom ?></td>
                            <td><?= $ventesConsommable->user->nom ?></td>
                            <td><?= $ventesConsommable->parc->nom ?></td>
                            <?php $this->start('to_delete_detail') ?>
                                <td>
                                    <?php foreach ($ventesConsommable->get('list_accessoires') as $accessoire_name => $qty): ?>
                                    <?= $qty > 0 ? $qty.' : '.$accessoire_name .'<br>' : '' ?>
                                    <?php endforeach ?>
                                </td>
                                <td>
                                    <?php foreach ($ventesConsommable->get('list_consommables') as $consommable_name => $qty): ?>
                                    <?= $qty > 0 ? $qty.' : '.$consommable_name .'<br>' : '' ?>
                                    <?php endforeach ?>
                                </td>
                            <?php $this->end() ?>
                            <td><?= $ventesConsommable->created->format('d/m/Y') ?></td>
                            <td><?= $ventesConsommable->livraison_date->format('d/m/Y') ?></td>
                            <td><?= $vente_consommable_etat_facturations[$ventesConsommable->etat_facturation] ?? '' ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm change-state" data-etat-facturation="<?= $ventesConsommable->etat_facturation ?>" data-date-facturation="<?= $ventesConsommable->date_facturation ? $ventesConsommable->date_facturation->format('Y-m-d') : ''; ?>" data-id="<?= $ventesConsommable->id ?>" data-action="<?= $this->Url->build(['action' => 'majStateBilling', $ventesConsommable->id, $isArchive]) ?>" data-toggle="modal" data-target="#change-state">Etat facturation</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>