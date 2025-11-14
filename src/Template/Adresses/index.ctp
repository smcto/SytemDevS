<?php
    $this->assign('title', 'Adresse');
    $titrePage = "Liste des Adresses" ;
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
        echo $this->Html->link(__('Create'), ['action'=>'add'], ['escape' => false, 'class' => 'btn btn-rounded pull-right hidden-sm-down btn-success']);
    $this->end();
?>

<div class="card">
    <div class="card-body">
        <?php if (!$adresses->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('adresse') ?></th>
                            <th><?= $this->Paginator->sort('cp') ?></th>
                            <th><?= $this->Paginator->sort('ville') ?></th>
                            <th><?= $this->Paginator->sort('pays') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($adresses as $adress): ?>
                            <tr>
                                <td><?= $adress->adresse ?></td>
                                <td><?= $adress->cp ?></td>
                                <td><?= $adress->ville ?></td>
                                <td><?= $adress->pays ?></td>
                                <td class="actions">
                                    <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'add', $adress->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $adress->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape' => false]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        <?php else: ?>
            Aucune information
        <?php endif ?>
    </div>
</div>
