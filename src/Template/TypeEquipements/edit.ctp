<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->script('type_equipements/type_equipements.js', ['block' => true]); ?>

<?php
$titrePage = "Modification d'un type d'équipement" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Type d\'équipements',
    ['controller' => 'TypeEquipements', 'action' => 'index']
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
            <?= $this->Form->create($typeEquipement) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('nom',['label' => 'Nom *','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('gammes_bornes._ids',['label' => 'Gamme ', 'class' => 'form-control select2',]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('is_filtrable',['label'=>'Filtrable']); ?>
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



