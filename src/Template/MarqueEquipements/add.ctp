<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MarqueEquipements $marqueEquipement
 */
?>
<?php
$titrePage = "Modification d'une marque d'équipement" ;
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
            <?= $this->Form->create($marqueEquipement) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('marque',['label' => 'Marque *','type'=>'text']); ?>
                        </div>
                    </div>
                    <!--div class="row">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('is_filtrable',['label'=>'Filtrable']); ?>
                        </div>
                
                    </div-->
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?php //echo $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>



