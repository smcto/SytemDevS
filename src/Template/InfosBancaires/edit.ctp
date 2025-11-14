<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InfosBancaire $infosBancaire
 */
?>
<?php
    $this->assign('title', 'Infos Bancaire');
    $titrePage = "Ajout Infos Bancaire" ;

    if ($id) {
        $titrePage = "Modification Infos Bancaire" ;
    }

    $this->start('breadcumb');

    $this->Breadcrumbs->add('Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );

    $this->Breadcrumbs->add('Reglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
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
        <div class="form-body">
            <?= $this->Form->create($infosBancaire) ?>
                <?= $this->Form->control('name'); ?>
                <?= $this->Form->control('adress'); ?>
                <?= $this->Form->control('bic'); ?>
                <?= $this->Form->control('iban'); ?>
            <?= $this->Form->end() ?>
        </div>

        <div class="form-actions">
            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-rounded btn-success']) ?>
            <?= $this->Form->button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) ?>
        </div>
    </div>

</div>

