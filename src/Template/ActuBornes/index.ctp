<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActuBorne[]|\Cake\Collection\CollectionInterface $actuBornes
 */
?>
<?php

$this->assign('title', 'Tickets bornes');

$titrePage = "Liste des tickets bornes" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
    echo $this->Html->link('Create',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
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
                                <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                                <!--<th scope="col"><?= $this->Paginator->sort('categorie') ?></th>-->
                                <th scope="col"><?= $this->Paginator->sort('borne_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($actuBornes as $actuBorne): ?>
                                <tr>
                                   <td><?= $this->Html->link($actuBorne->titre, ['action' => 'edit', $actuBorne->id]) ?></td>
                                   <!--<td><?= $actuBorne->has('categorie_actus') ? $this->Html->link($actuBorne->categorie_actus->titre, ['controller' => 'CategorieActus', 'action' => 'edit', $actuBorne->categorie_actus->id]) : '' ?></td>-->
                                   <td><?= $actuBorne->has('borne') ? $this->Html->link($actuBorne->borne->format_numero, ['controller' => 'Bornes', 'action' => 'view', $actuBorne->borne->id]) : '' ?></td>
                                   <td><?= h($actuBorne->created) ?></td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $actuBorne->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
