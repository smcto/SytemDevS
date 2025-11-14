<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fournisseur $fournisseur
 */
?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>



<?= $this->Html->script('bornes.js', ['block' => true]); ?>
<?php
$titrePage = "Ajout d'un fournisseur" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Fournisseurs',
    ['controller' => 'Fournisseurs', 'action' => 'index']
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
            <?= $this->Form->create($fournisseur) ?>
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('nom',['label' => 'Nom commercial *','type'=>'text']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                           <?php echo $this->Form->control('type_fournisseur_id',['label' => 'Type de fournisseur *', 'options'=>$typeFournisseurs,'empty'=>'Séléctionner']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('adresse',['label' => 'Adresse','type'=>'text']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                           <?php echo $this->Form->control('cp',['label' => 'Cp']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('ville',['label' => 'Ville','type'=>'text']); ?>
                        </div>
                        <!--/span-->
                        <!--<div class="col-md-6">
                           <?php echo $this->Form->control('antenne_id',['label' => 'Antenne rattachée', 'options'=>$antennes,'empty'=>' ']); ?>
                        </div>-->
                        <!--/span-->
                        <div class="col-md-6">
                           <?php echo $this->Form->control('contact',['label' => 'Contact','type'=>'textarea']); ?>
                        </div>
                    </div>
                    <!--/row-->

                    <div class="row">

                      <div class="col-md-6">
                        <?php echo $this->Form->control('commentaire',['label'=>'Commentaire court','type'=>'textarea']); ?>
                    </div>
                    <div class="col-md-6">
                      <?php echo $this->Form->control('description',['label'=>'Description détaillée',"class"=>"textarea_editor form-control", 'type'=>'textarea']); ?>
                  </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?php //echo $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>




