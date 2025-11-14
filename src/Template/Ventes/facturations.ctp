<?= $this->Html->script('ventes/facturation', ['block' => 'script']); ?>
<?php 
    if ($parc_id == null) {
        $breadcrumb = 'Liste des ventes dans parcs des ventes et en location financière';
    } elseif ($parc_id == 1) {
        $breadcrumb = 'Liste des ventes dans parcs des ventes';
    } elseif ($parc_id == 4) {
        $breadcrumb = 'Liste des ventes en location financière';
    } 

    if($isArchive) {
        $breadcrumb = 'Liste des ventes archivées';
    } 

    $titrePage = 'A facturer';
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($breadcrumb);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();   
?>

<?php $this->start('actionTitle'); ?>

    <?php if ($isArchive): ?>
        <?= $this->Html->link('Ventes non archivées', ['action'=> 'facturations'], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php else: ?>
        <?= $this->Html->link('Ventes archivées', ['action'=> 'facturations', 1], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php endif ?>
    
    <?= $this->Html->link('Parc des ventes', ['action'=> 'facturations', 'parc' => 1], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?= $this->Html->link('Location financière', ['action'=> 'facturations', 'parc' => 4], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>

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
                        <?= $this->Form->select('etat_facturation', $vente_etat_facturations, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker etat_facturation']); ?>
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
    
        <?php if (!$ventes->isEmpty()): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">Vente</th>
                            <th width="5%">Borne</th>
                            <th width="8%">Enseigne</th>
                            <th width="7%">Commercial</th>
                            <th width="8%">Destination</th>
                            <th width="5%">Gamme</th>
                            <th width="8%">Etat</th>
                            <th width="8%">Date expédition</th>
                            <th width="8%">Etat facturation</th>
                            <th width="8%">Date ajout</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php  foreach ($ventes as $key => $vente): ?>
                            <tr>
                                <td><a href="<?= $this->Url->build(['action' => 'view', $vente->id]) ?>"><?= $vente->id ?></a></td>
                                <td><?= $vente->borne != null ? $vente->borne->model_borne->gammes_borne->notation . $vente->borne->numero : '--' ?></td>
                                <td><?= $vente->is_client_not_in_sellsy == true ? $vente->client_name_notsellsy : $vente->client->nom  ?></td>
                                <td><?= $vente->user != null ? $vente->user->prenom : '--'?></td>
                                <td><?= $vente->has('parc') ? $vente->parc->nom2 : '' ?></td>
                                <td><?= $vente->has('gammes_borne') ? $vente->gammes_borne->name : '' ?></td>
                                <td><?= @$vente_statuts[$vente->vente_statut] ?></td>
                                <td><?= $vente->date_depart_atelier ?></td>
                                <td><?= @$vente_etat_facturations[$vente->etat_facturation]; ?></td>
                                <td><?= $vente->created->format('d/m/Y') ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm change-state" data-etat-facturation="<?= $vente->etat_facturation ?>" data-date-facturation="<?= $vente->date_facturation ? $vente->date_facturation->format('Y-m-d') : ''; ?>" data-id="<?= $vente->id ?>"  data-receptionclient="<?= $vente->date_reception_client ? $vente->date_reception_client->format('Y-m-d') : ''; ?>" data-id="<?= $vente->id ?>" data-action="<?= $this->Url->build(['action' => 'majStateBilling', $vente->id, $isArchive]) ?>" data-toggle="modal" data-target="#change-state" data-bondelivraison="<?= $this->Url->build($vente->get('bon_de_livraison_path')) ?>">Etat facturation</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            Aucune vente
        <?php endif ?>

    </div>
</div>