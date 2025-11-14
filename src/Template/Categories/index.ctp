<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\ModelBorne[]|\Cake\Collection\CollectionInterface $modelBornes
*/
?>

<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>
    
<?php
$titrePage = "Catégorie de documentation" ;
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
                                <th scope="col">Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php //debug($categories->toArray()); ?>
                             <?php foreach ($categories as $key => $categorie): ?>
                                <tr>
                                    <td><?= h($categorie) ?></td>
                             
                                    <td>
                                        <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'edit', $key], ['escape'=>false]) ?>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $key], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
