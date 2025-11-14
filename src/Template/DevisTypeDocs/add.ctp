<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne $etatBorne
 */
?>
<?= $this->Html->css(["https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css", ], ['block' => 'css'] ); ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>

<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-cleaner.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('devis_type_docs/add.js', ['block' => true]); ?>

<?php
$file_default = "";
if ($devisTypeDoc && !empty($devisTypeDoc->image)) {
    $file_default = '/img/devis/fond_pdf/' . $devisTypeDoc->image;
}

$titrePage = $id? "Modifier un type de document" : "Ajouter un type de document" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
    'Réglages',
    ['controller' => 'Dashboards', 'action' => 'reglages']
);
$this->Breadcrumbs->add(
    'Type du document',
    ['controller' => 'DevisTypeDocs', 'action' => 'index']
);
$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $id?'Modifier un document':'Ajouter un document']);
$this->end();
?>

<div class="row">
    <?php use Cake\Routing\Router; ?>
    <input type="hidden" value="<?php echo Router::url('/', true) ; ?>" id="id_baseUrl">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($devisTypeDoc,['type' => 'file']) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('nom',["label"=>"Nom *: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('prefix_num',["label"=>"libellé numérotation *: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('header',["label"=>"Text header: ","class"=>"form-control textarea_editor"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('footer',["label"=>"Text footer : ","class"=>"form-control textarea_editor"]) ?>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">					
                                    <?php echo $this -> Form -> control('fond', ['label' => 'Fond de page', 'type' => 'file', 'class' => 'form-control dropify', 'accept' => 'image/x-png,image/gif,image/jpeg', 'data-allowed-file-extensions' => 'jpg jpeg png gif', 'data-default-file' => $file_default]); ?>
                               <input type="hidden" value="<?= $id ?>" id="type_doc_id">
                               <?= $devisTypeDoc->image ? "<a href='$file_default'> Visualiser l'image </a>" : ''?>
                           </div>
                        </div>

                        <div class="form-actions m-t-20">
                            <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                            <?= $this->Html->link(__('Cancel'),['action' => 'index'],["class"=>"btn btn-rounded btn-inverse", "escape"=>false]) ?>
                       </div>
                    <?= $this->Form->end() ?>
                    </div>
            </div>
        </div>
    </div>
</div>



