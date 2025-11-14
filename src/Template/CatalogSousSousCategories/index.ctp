<?php
    $this->assign('title', 'Catalogue sous sous catégorie');
    $titrePage = "Liste sous sous catégories" ;
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

        <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'mt-4']); ?>
            <div class="row custom-col-width">
                <div class="col-md-2">
                    <?= $this->Form->control('nom', ['label' => false, 'default' => $nom, 'class' => 'form-control', 'placeholder' => 'Rechercher']); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->control('catalog_category_id', ['empty' => 'Sélectionner', 'options' => $catalogCategories, 'class' => 'form-control selectpicker', 'label' => false, 'default' => $catalog_category_id]); ?>
                </div>
                <div class="col-md-2">
                    <?= $this->Form->control('catalog_sous_category_id', ['empty' => 'Sélectionner', 'options' => $catalogSousCategories, 'class' => 'form-control selectpicker', 'label' => false, 'default' => $catalog_sous_category_id]); ?>
                </div>

                <div class="col-md-2 col-filter">
                    <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                    <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                </div>
            </div>
        <?= $this->Form->end(); ?>

        <?php if (!$catalogSousSousCategories->isEmpty()): ?>
            <div class="table-responsive">

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Sous catégorie</th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($catalogSousSousCategories as $catalogSousSousCategory): ?>
                            <tr>
                                <td><?= $catalogSousSousCategory->nom ?></td>
                                <td><?= $catalogSousSousCategory->catalog_sous_category->catalog_category->nom ?></td>
                                <td><?= $catalogSousSousCategory->has('catalog_sous_category') ? $catalogSousSousCategory->catalog_sous_category->nom : '' ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('<i class="fa fa-pencil text-inverse"></i>'), ['action' => 'add', $catalogSousSousCategory->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink(__('<i class="mdi mdi-delete text-inverse"></i>'), ['action' => 'delete', $catalogSousSousCategory->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape' => false]) ?>
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
