<?php
    $this->assign('title', 'Infos Bancaire');
    $titrePage = "Liste des Infos Bancaire" ;
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
        <?php if (!$infosBancaires->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('name', 'Nom de la banque') ?></th>
                            <th><?= $this->Paginator->sort('adress', 'Adresse') ?></th>
                            <th><?= $this->Paginator->sort('bic') ?></th>
                            <th><?= $this->Paginator->sort('iban') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($infosBancaires as $infosBancaire): ?>
                            <tr>
                                <td><a href="<?= $this->Url->build(['action' => 'add', $infosBancaire->id]) ?>"><?= $infosBancaire->name ?></a></td>
                                <td><?= $infosBancaire->adress ?></td>
                                <td><?= $infosBancaire->bic ?></td>
                                <td><?= $infosBancaire->iban ?></td>
                                <td class="actions">
                                    <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $infosBancaire->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete ?')]) ?>
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
