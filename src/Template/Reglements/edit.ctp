<?= $this->Html->css(["https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css", ], ['block' => 'css'] ); ?>
<?= $this->Html->css('reglements/reglements.css?time='.time(), ['block' => 'css']); ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('reglements/reglements.js?'.  time(), ['block' => 'script']); ?>

<?php
$titrePage = "Modification d'un réglement" ;
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
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($reglement) ?>
                    <div class="form-body">
                        <input type="hidden" id="position" value="bottom">
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Type de réglement</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('type',[
                                            'type'=>'radio',
                                            'options'=>$type_reglement,
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
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Client</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('client_id',['options' => $client, 'empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher", 'value' => $reglement->client_id]) ?>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Date de réglement</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="date" name="date" id="date" class="form-control" required="required" value="<?= $reglement->date->format('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Nom de la banque</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('info_bancaire_id', ['empty' => 'Sélectionner', 'options' => $infosBancaires, 'label' => false, 'class' => 'selectpicker coord_bq']); ?>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Moyen de paiement</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('moyen_reglement_id',['label' => false, 'options' => $moyen_reglements]) ?>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Montant de réglement</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('montant',['label' => false]) ?>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Référence</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('reference',['label' => false]) ?>
                            </div>
                        </div>
                        <div class="row reglement-row">
                            <label class="control-label col-md-4 m-t-5">Note</label>
                            <div class="col-md-8">
                                <?= $this->Form->control('note',['label' => false,'type' => 'textarea', 'class' => 'summernote form-control']) ?>
                            </div>
                        </div>

                           <div class="form-actions">
                           <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                           <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                       </div>
                    </div>
               <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
