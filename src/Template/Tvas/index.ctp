<?php
    $this->assign('title', 'Tva');
    $titrePage = "Liste des Tva" ;
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
        <?php if (!$tvas->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('valeur') ?></th>
                            <th><?= $this->Paginator->sort('is_default', 'Valeur par défaut') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tvas as $tva): ?>
                            <tr>
                                <td><?= $this->Number->format($tva->valeur) ?></td>
                                <td><?= $tva->is_default ? 'Oui' : 'Non' ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('<i class="fa fa-pencil text-inverse"></i>'), ['action' => 'add', $tva->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink(__('<i class="mdi mdi-delete text-inverse"></i>'), ['action' => 'delete', $tva->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape' => false]) ?>
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
