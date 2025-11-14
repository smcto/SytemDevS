<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsv $stripeCsv
 */
?>


<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->script('stripes/stripes.js', ['block' => true]); ?>

<?php
$titrePage = "Import Stripe csv" ;
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
                <?= $this->Form->create($stripeCsv, ['type' => 'file']) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Date * </label>
                            <input type="date" name="date_import" class="form-control" placeholder="dd/mm/yyyy">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('stripe_csv_file',["id"=>"", "label"=>"Fichier CSV : ","class"=>"dropify", "type"=>"file", "data-height"=>"100", "accept"=>".csv"]) ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
