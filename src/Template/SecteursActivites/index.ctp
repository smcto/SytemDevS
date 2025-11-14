<?php
    $this->assign('title', 'Secteur d\'activité');
    $titrePage = "Liste des secteurs d'activité" ;
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
        <?php if (!$secteursActivites->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Secteur d'activité</th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($secteursActivites as $secteursActivite): ?>
                            <tr>
                                <td><?= $secteursActivite->name ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('<i class="fa fa-pencil text-inverse"></i>'), ['action' => 'add', $secteursActivite->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink(__('<i class="mdi mdi-delete text-inverse"></i>'), ['action' => 'delete', $secteursActivite->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape' => false]) ?>
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
