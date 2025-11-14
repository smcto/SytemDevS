<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne $etatBorne
 */
?>
<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('modeles-mails/add.js?'.  time(), ['block' => true]); ?>

<?php
$titrePage = $id? "Modifier un modèle d'email" : "Ajouter un modèle d'email" ;
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
    'Modèles de mails',
    ['controller' => 'ModelesMails', 'action' => 'index']
);
$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $id?'Modifier un modèle':'Ajouter un modèle']);
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
                <?= $this->Form->create($modelesMail) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('nom_interne',["label"=>"Nom interne *: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('objet',["label"=>"Objet de l'email*: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('contenu',["label"=>"Message de l'email *: ","class"=>"textarea_editor form-control", 'rows' => 25]) ?>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                               <label>Pièce(s) jointe(s)</label>
                               <div class="dropzone" id="id_dropzone_pj" data-owner="mail_pj"> </div>
                               <input type="hidden" value="<?= $modelesMail->id ?>" id="modeles_mails_id">
                           </div>
                        </div>

                        <div class="form-actions m-t-20">
                            <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                            <?= $id ? $this->Html->link(__('Dupliquer'),['action' => 'duplicateModeleMail',$id],["class"=>"btn btn-rounded btn-primary", "escape"=>false]) : ""?>
                            <?= $this->Html->link(__('Cancel'),['action' => 'index'],["class"=>"btn btn-rounded btn-inverse", "escape"=>false]) ?>
                       </div>
                    <?= $this->Form->end() ?>
                    </div>
            </div>
        </div>
    </div>
</div>



