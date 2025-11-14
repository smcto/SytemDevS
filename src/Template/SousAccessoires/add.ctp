<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('type_equipements/type_equipements.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>


<?php
    $titrePage = "Ajout d'une nouvelle déclinaison d'accéssoire" ;

    $this->start('breadcumb');
        $this->Breadcrumbs->add(
            'Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
        );

        $this->Breadcrumbs->add(
            'Accessoires',
            ['controller' => 'Accessoires', 'action' => 'index']
        );

        $this->Breadcrumbs->add($titrePage);

        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Informations</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($sousAccessoire, ['url' => [$accessoire_id]]) ?>
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('accessoire_id', ['default' => $accessoire_id, 'empty' => 'Sélectionner', 'label' => 'Accessoire *', 'class' => 'form-control selectpicker', 'required']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('name', ['label' => 'Nom *', 'required']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $this->Form->control('gammes_bornes._ids', ['label' => 'Gamme ', 'class' => 'form-control select2',]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->control('content'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Form->button(__('Cancel'),["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>