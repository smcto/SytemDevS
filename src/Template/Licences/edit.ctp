<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Licence $licence
 */
?>



<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->script('licences/licence.js', ['block' => true]); ?>
<?php
$titrePage = "Modifier une licence" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Licences',
    ['controller' => 'Licences', 'action' => 'index']
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
            <?= $this->Form->create($licence) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('type_licence_id',['id'=>'type_licence_id','label' => 'Type licence *', 'options'=>$typeLicences,'empty'=>'Séléctionner','required'=>true]); ?>
                        </div>
                        <div class="col-md-6 hide">
                           <?php echo $this->Form->control('nombre_utilisateur',['label' => 'Nombre d\'utilisation ']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Date achat</label>
                                <input type="date" id="date_achat" name="date_achat" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($licence->date_achat)) echo $licence->date_achat->format('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Date renouvellement</label>
                                <input type="date" id="date_renouvellement" name="date_renouvellement" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($licence->date_renouvellement)) echo $licence->date_renouvellement->format('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-6">
                               <?php
                                echo $this->Form->control('bornes._ids', [
                                    'type' => 'select',
                                    'multiple' => true,
                                    'options' => $bornes,
                                    "class"=>"select2 form-control select2-multiple",
                                    "data-placeholder"=>"Choisir"
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo $this->Form->control('numero_serie',['label' => 'Numéro de série']); ?>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('email',['label' => 'Email','type'=>'email']); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo $this->Form->control('version',['label' => 'Version']); ?>
                            </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
