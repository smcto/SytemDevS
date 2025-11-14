<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeEvenement[]|\Cake\Collection\CollectionInterface $typeEvenements
 */
?>
<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des types événements" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
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
                            <th scope="col"><?= $this->Paginator->sort('nom', 'Nom') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($typeEvenements as $typeEvenement): ?>
                        <tr>
                            <td><?= h($typeEvenement->nom) ?></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $typeEvenement->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $typeEvenement->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
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
