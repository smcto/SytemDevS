<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur[]|\Cake\Collection\CollectionInterface $typeFournisseurs
 */
?>
<?php
$titrePage = "Liste des types de fournisseurs" ;
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
    echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
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
                                <th>Type</th>
                                <th>Nombre fournisseurs</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($typeFournisseurs as $typeFournisseur): ?>
                                <tr>
                                   <td><?= $this->Html->link($typeFournisseur->nom, ['action' => 'edit', $typeFournisseur->id]) ?></td>
                                   <td><?= count($typeFournisseur->fournisseurs) ?></td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $typeFournisseur->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                    </td>
                                </tr>
                             <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>

</div>


