<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur $typeFournisseur
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
$titrePage = "Détail type fournisseur " ;
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
            <h3><?= h($typeFournisseur->nom) ?></h3>
        </div>
        <div class="card-body">
            <?= $this->Form->create($typeFournisseur) ?>
                <div class="form-body">

                    <hr>
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

            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
