<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategorieActus $categorieActus
 */
?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>


<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('categorieticket/categorieticket.js', ['block' => true]); ?>

<?php
$titrePage = "Modifier catégorie ticket" ;
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
            <h4 class="m-b-0 text-white">Informations</h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($categorieActus) ?>
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('titre',['label' => 'Titre * ','type'=>'text', 'required'=>'true']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                           <?php echo $this->Form->control('description',['label'=>'Description',"class"=>"textarea_editor form-control", "rows"=>"10",'type'=>'textarea']); ?>
                        </div>
                    </div>

                </div></br>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
