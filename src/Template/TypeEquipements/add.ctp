<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->script('type_equipements/type_equipements.js', ['block' => true]); ?>

<?php
$titrePage = "Ajout d'un nouveau type d'équipement" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Equipement',
    ['controller' => 'Equipements', 'action' => 'index']
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
                        <div class="col-md-4">
                            <?php echo $this->Form->control('nom',['label' => 'Nom *','type'=>'text', 'required' => true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('gammes_bornes._ids',['label' => 'Gamme ', 'class' => 'form-control select2',]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('types',['label' => 'Type ', 'value' => $type_value, 'required' => true, 'data-placeholder' => 'Type', 'empty' => 'Type', 'class' => 'form-control select2', 'multiple' => true, 'options' => ['is_structurel' => 'équipement structurel', 'is_accessoire' => 'équipement accessoire', 'is_protection' => 'équipement protection']]); ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-md-6 m-t-30">
                            <?php echo $this->Form->control('is_filtrable',['label'=> "Créer un filtre pour ce type d'équipement dans la liste des produits"]); ?>
                        </div>
                
                        <div class="col-md-6 m-t-30">
                            <?php echo $this->Form->control('is_vente',['label'=>'Faire apparaitre dans le formulaire de vente']); ?>
                        </div>
                
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-rounded btn-inverse"><?= __('Cancel') ?></a>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>



