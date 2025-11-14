<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne[]|\Cake\Collection\CollectionInterface $etatBornes
 */
?>

<?php
$titrePage = "Liste des états de borne" ;
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
                            <th scope="col">Etat général</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($etatBornes as $etatBorne): ?>
                        <tr>
                            <td><?= $this->Html->link($etatBorne->etat_general, ['action' => 'edit', $etatBorne->id]) ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $etatBorne->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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

<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Etat Borne'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="etatBornes index large-9 medium-8 columns content">
    <h3><?= __('Etat Bornes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('etat_general') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etatBornes as $etatBorne): ?>
            <tr>
                <td><?= $this->Number->format($etatBorne->id) ?></td>
                <td><?= h($etatBorne->etat_general) ?></td>
                <td><?= h($etatBorne->created) ?></td>
                <td><?= h($etatBorne->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $etatBorne->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $etatBorne->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $etatBorne->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>-->
