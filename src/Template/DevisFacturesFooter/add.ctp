<?= $this->Html->css(["https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css", ], ['block' => 'css'] ); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('devis_factures_footer/footer.js?'.  time(), ['block' => 'script']); ?>

<?php
$titrePage = "Footer pdf factures " ;
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
                <?= $this->Form->create($devisFacturesFooter) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('text',["label"=>"Text bas de page pdf *: ","class"=>"form-control summernote", 'required' => 'required']) ?>
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
</div>



