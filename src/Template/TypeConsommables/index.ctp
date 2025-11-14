<?= $this->Html->css('table-uniforme', ['block' => 'css']); ?>

<?php
    $this->assign('title', 'Types de consommables');
    $titrePage = "Liste des types de consommables" ;
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
                    <table class="table table-uniforme">

                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Déclinaison</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($typeConsommables as $typeConsommable): ?>
                            <tr class="bg-light">
                                <td><?= $this->Html->link($typeConsommable->name, ['action' => 'add', $typeConsommable->id]) ?></td>
                                <td></td>
                                <td>
                                    <a href="<?= $this->Url->build(['controller' => 'SousTypesConsommables', 'action' => 'add', $typeConsommable->id]) ?>">Ajouter une déclinaison</a>
                                    <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $typeConsommable->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                </td>
                            </tr>

                                <?php foreach ($typeConsommable->sous_types_consommables as $key => $sous_types_consommable): ?>
                                    <tr>
                                        <td colspan="1"></td>
                                        <td><a href="<?= $this->Url->build(['controller' => 'SousTypesConsommables', 'action' => 'add', $sous_types_consommable->type_consommable_id, $sous_types_consommable->id]) ?>">- <?= $sous_types_consommable->name ?></a> <br></td>
                                        <td>
                                            <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['controller' => 'SousTypesConsommables', 'action' => 'delete', $sous_types_consommable->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                        </td>
                                    </tr>
                                    
                                <?php endforeach ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
