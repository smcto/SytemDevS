<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SmsAuto $smsAuto
 */
?>

<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>

<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify.js?'.  time(), ['block' => true]); ?>

<?php
$titrePage = "Modifier les paramètres SMS";
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
    'Réglages',
    ['controller' => 'Dashboards', 'action' => 'reglages']
);
$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => 'Modifier les paramètres SMS']);
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
                <?= $this->Form->create($smsAuto,  ['type' => 'file']) ?>
                    <div class="form-body">
                        <div class="row hide">
                            <div class="col-sm-12">
                                <?= $this->Form->control('lien_pdf_classik'); ?>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="col-sm-12">
                                <?= $this->Form->control('lien_pdf_spherik'); ?>
                            </div>
                        </div>
                        
                        <div class="row">
                           <div class="col-md-12">
                                <?= $this->Form->control('contenu'); ?>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-md-12">					
                                <?= $this -> Form -> control('classik_file', ['label' => 'Manuel borne classik', 'type' => 'file', 'class' => 'form-control dropify', 'data-allowed-file-extensions' => 'jpg jpeg png gif pdf', 'data-default-file' => $file_default_classik]); ?>
                               <?= $file_default_classik ? "<a href='$file_default_classik'> Visualiser  le document </a>" : ''?>
                           </div>
                        </div>
                        
                        <div class="row">
                           <div class="col-md-12">					
                                <?= $this -> Form -> control('spherik_file', ['label' => 'Manuel borne spherik', 'type' => 'file', 'class' => 'form-control dropify', 'data-allowed-file-extensions' => 'jpg jpeg png gif pdf', 'data-default-file' => $file_default_spherik]); ?>
                                <?= $file_default_spherik ? "<a href='$file_default_spherik'> Visualiser le document </a>" : ''?>
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