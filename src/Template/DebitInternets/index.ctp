<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitInternet[]|\Cake\Collection\CollectionInterface $debitInternets
 */
?>

<?php
$titrePage = "Liste des debits internets" ;
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
                            <th scope="col">Valeur</th>
                            <th scope="col" class="hide">Information</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($debitInternets as $debitInternet):;?>
                        <tr>

                            <td><?= h($debitInternet->valeur) ?></td>
                            <td class="hide"><?= h($debitInternet->information) ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'edit', $debitInternet->id], ['escape'=>false]) ?>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $debitInternet->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
        <li><?= $this->Html->link(__('New Debit Internet'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="debitInternets index large-9 medium-8 columns content">
    <h3><?= __('Debit Internets') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valeur') ?></th>
                <th scope="col"><?= $this->Paginator->sort('information') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($debitInternets as $debitInternet): ?>
            <tr>
                <td><?= $this->Number->format($debitInternet->id) ?></td>
                <td><?= h($debitInternet->valeur) ?></td>
                <td><?= h($debitInternet->information) ?></td>
                <td><?= h($debitInternet->created) ?></td>
                <td><?= h($debitInternet->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $debitInternet->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $debitInternet->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $debitInternet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitInternet->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>-->
