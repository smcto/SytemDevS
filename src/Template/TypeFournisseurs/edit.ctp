<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur $typeFournisseur
 */
?>
<?php
$titrePage = "Modifier un type de fournisseur" ;
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
        <div class="card-header">
            <h4 class="m-b-0 text-white">Informations </h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($typeFournisseur) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('nom',['label' => 'Nom *','type'=>'text']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('description',['label'=>'Description',"class"=>"textarea_editor form-control", "rows"=>"6",'type'=>'textarea']); ?>
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
