<?php
    $this->assign('title', 'infos bancaire');
    $titrePage = "Ajout infos bancaire" ;

    if ($id) {
        $titrePage = "Modification infos bancaire" ;
    }

    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
        );
        $this->Breadcrumbs->add('Reglages',
            ['controller' => 'Dashboards', 'action' => 'reglages']
        );
        $this->Breadcrumbs->add('Infos bancaires',
            ['controller' => 'InfosBancaires', 'action' => 'index']
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
        <?= $this->Form->create($infosBancaire) ?>
            <div class="form-body">
                <?= $this->Form->control('name', ['label' => 'Nom de la banque']); ?>
                <?= $this->Form->control('adress', ['label' => 'Adresse']); ?>
                <?= $this->Form->control('bic', ['label' => 'Bic']); ?>
                <?= $this->Form->control('iban', ['label' => 'Iban']); ?>
            </div>

            <div class="form-actions">
                <?= $this->Form->button(__('Save'), ['class' => 'btn btn-rounded btn-success']) ?>
                <?= $this->Form->button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) ?>
            </div>
        <?= $this->Form->end() ?>
    </div>

</div>

