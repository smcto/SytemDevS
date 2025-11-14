<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Materiel $materiel
 */
?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>

<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('materiels.js', ['block' => true]); ?>

<?php
$titrePage = "Ajout d'un nouveau matériel" ;
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
            <h4 class="m-b-0 text-white">Informations générales</h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($materiel, ['type'=>'file']) ?>
                <div class="form-body">
                   <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('materiel',['label' => 'Matériel *','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                           <?php echo $this->Form->control('descriptif',['label' => 'Description *', "class"=>"textarea form-control", "rows"=>"6",'type'=>'textarea']); ?>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->control('photos',["id"=>"photos","label"=>"Photo : ","class"=>"dropify", "type"=>"file"]) ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('notice_tuto',['label'=>'Notice',"class"=>"textarea_editor form-control", "rows"=>"4",'type'=>'textarea']); ?>
                        </div>
                   </div>
                   <div class="row">
                         <div class="col-md-6">
                            <?php echo $this->Form->control('dimension',['label' => 'Dimension ','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('poids',['label' => 'Poids','type'=>'text']); ?>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('consignes',['label' => 'Consignes ',"rows"=>"6",'type'=>'textarea']); ?>
                       </div>
                       <div class="form-group">
                           <label class="control-label">Variation du stock </label></br>
                           <?php //echo $this->Form->radio('variation_stok', ['Anormal ',' Normal']); ?>
                           <?= $this->Form->control('variation_stok',[
                           'type'=>'radio',
                           'options'=>[
                           ['value' => 0, 'text' => ' Anormal'],
                           ['value' => 1, 'text' => ' Normal']
                           ],
                           'label'=>false,
                           'required'=>true,
                           'hiddenField'=>false,
                           'legend'=>false,
                           'templates' => [
                           'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                           'radioWrapper' => '<div class="radio radio-success radio-inline">{{label}}</div>'
                           ]
                           ]); ?>

                       </div>
                  </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>



