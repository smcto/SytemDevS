<?php
    $this->assign('title', 'Secteur d\'activité');
    $titrePage = "Ajout secteur d'activité" ;

    if ($id) {
        $titrePage = "Modification secteur d'activité" ;
    }

    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
        );

        $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<div class="card card-outline-info">

    <div class="card-header">
        <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
    </div>

    <div class="card-body">
        <?= $this->Form->create($secteursActiviteEntity) ?>
            <div class="form-body">
                <?= $this->Form->control('name', ['label' => 'Name']); ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->button(__('Save'), ['class' => 'btn btn-rounded btn-success']) ?>
                <?= $this->Form->button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>

</div>

