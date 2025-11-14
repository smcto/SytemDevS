<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('type_equipements/type_equipements.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>


<?php
    $titrePage = "Ajout d'une nouvelle déclinaison de consommable" ;

    $this->start('breadcumb');
        $this->Breadcrumbs->add(
            'Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
        );

        $this->Breadcrumbs->add(
            'Types consommable',
            ['controller' => 'TypeConsommables', 'action' => 'index']
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
                <?= $this->Form->create($sousTypesConsommable, ['url' => [$type_consommable_id, $sous_types_consommable_id]]) ?>
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('type_consommable_id', ['default' => $type_consommable_id, 'empty' => 'Sélectionner', 'label' => 'Type consommable *', 'class' => 'form-control selectpicker', 'required']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('name', ['label' => 'Nom *', 'required']); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $this->Form->control('content', ['label' => 'Description']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Html->link(__('Cancel'),['controller' => 'TypeConsommables', 'action' => 'index',],["class"=>"btn btn-rounded btn-inverse", "escape"=>false]);?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>