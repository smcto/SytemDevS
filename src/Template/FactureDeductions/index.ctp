
<?php
    $titrePage = "Tableau de facturation" ;
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
            'Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
    );
    $this->Breadcrumbs->add(
            'Regalges',
            ['controller' => 'Dashboards', 'action' => 'reglages']
    );

    $this->Breadcrumbs->add($titrePage);

    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();

    $this->start('actionTitle');
    echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
    $this->end();

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>CA HT à déduire</th>      
                                <th>Avoirs HT à déduire</th>     
                                <th>PCA PART  N-1 à ajouter</th>    
                                <th>PCA PRO N-1 à ajouter</th> 
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($factureDeductions as $factureDeduction): ?>
                            <tr>
                                <td><?= $factureDeduction->annee ?></td>      
                                <td><?= $factureDeduction->ca_ht_deduire ?></td>     
                                <td><?= $factureDeduction->avoir_ht_deduire ?></td>
                                <td><?= $factureDeduction->pca_part ?></td>
                                <td><?= $factureDeduction->pca_pro ?></td> 
                                <td class="actions">
                                    <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $factureDeduction->id]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
 