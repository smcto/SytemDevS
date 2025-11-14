<?php
    $this->assign('title', 'Devis Preference');
    $titrePage = "Liste des Devis Preference" ;
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
        <?php if (!$devisPreferences->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('moyen_reglements') ?></th>
                            <th><?= $this->Paginator->sort('delai_reglements') ?></th>
                            <th><?= $this->Paginator->sort('info_bancaire_id') ?></th>
                            <th><?= $this->Paginator->sort('accompte_value') ?></th>
                            <th><?= $this->Paginator->sort('accompte_unity') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($devisPreferences as $devisPreference): ?>
                            <tr>
                                <td><?= $this->Number->format($devisPreference->id) ?></td>
                                <td><?= $devisPreference->moyen_reglements ?></td>
                                <td><?= $devisPreference->delai_reglements ?></td>
                                <td><?= $devisPreference->has('infos_bancaire') ? $devisPreference->infos_bancaire->name : '' ?></td>
                                <td><?= $this->Number->format($devisPreference->accompte_value) ?></td>
                                <td><?= $devisPreference->accompte_unity ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['action' => 'view', $devisPreference->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'add', $devisPreference->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $devisPreference->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        <?php else: ?>
            Aucun résultat
        <?php endif ?>
    </div>
</div>
