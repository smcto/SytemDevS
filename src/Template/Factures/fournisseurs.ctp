<?php
    $this->assign('title', 'Liste des factures fournisseurs');
    $titrePage = "Liste des factures fournisseurs" ;
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
            'Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
    );
    $this->Breadcrumbs->add(
            'Réglages',
            ['controller' => 'Dashboards', 'action' => 'reglages']
    );

    $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();

    $this->start('actionTitle');
    $this->end();
?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    
                <div class="form-body">
                        <?= $this->Form->create(null, ['type' => 'get', 'role'=>'form' ]); ?>
                        <div class="row">

                            <div class="col-md-3">
                                <?= $this->Form->control('titre', ['label' => false, 'default' => $titre, 'class'=> 'form-control search', 'placeholder' => 'Numéro de facture']); ?>
                            </div>

                            <div class="col-md-3">
                                <?= $this->Form->control('fournisseur_id', ['empty' => 'Sélectionner parmi les fournisseurs', 'label' => false, 'default' => $fournisseur_id, 'class'=> 'form-control search', 'placeholder' => 'Numéro de facture']); ?>
                            </div>

                            <div class="col-md-3 p-l-0">
                                <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                <?= $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'Equipements', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                            </div>
                        </div>
                        
                        <?= $this->Form->end(); ?>
                </div>

                <div class="table-responsive">
                    <table class="table">

                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('created', ['title' => 'Date']) ?></th>
                                <th class="actions">Fournisseur</th>
                                <th class="actions">Montant</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($factures as $facture): ?>
                                <tr>
                                    <td><?= $facture->created->format('d/m/Y à H:i') ?></td>
                                    <td><?= $facture->fournisseur->nom ?></td>
                                    <td><?= $facture->montant ?> EUR</td>
                                    <td><a href="<?= $this->Url->build(['action' => 'ficheFactureFournisseur', $facture->id]) ?>">Voir détail</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <?= $this->element('tfoot_pagination') ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
