<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne $etatBorne
 */
?>

<?php $this->start('borne') ?>
    #<?= ($borneEntity->has('model_borne') ? $borneEntity->model_borne->gammes_borne->notation:'') . $borneEntity->numero ?>
<?php $this->end() ?>
<?php

$this->assign('title', 'Contrat borne');
$titrePage = "Ajouter garantie de borne" ;
if ($borneId) {
    $titrePage = "Modifier les informations de vente : ". $this->fetch('borne');
}
$this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );

    $this->Breadcrumbs->add($titrePage);

    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-body">
                <?= $this->Form->create($borneEntity) ?>
                    <div class="form-body col-lg-6">
                        <?= $this->element('../Bornes/form_edit_garantie') ?>
                        <div class="form-actions">
                            <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded  btn-success",'escape'=>false]) ?>
                            <?= $this->Form->button(__('Cancel'),["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>