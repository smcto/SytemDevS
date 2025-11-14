<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur $typeFournisseur
 */
?>

<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>

<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('equipements/add.js?'.  time(), ['block' => true]); ?>

<?php
$titrePage = "Modification de l'équipement" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Equipements',
    ['controller' => 'Equipements', 'action' => 'index']
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
            <?= $this->Form->create($equipement, ['type'=>'file']) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_equipement_id', ['options' => $typeEquipements,'empty'=>'Séléctionnez','class' => 'selectpicker','data-live-search' => true, 'label'=>'Type * :','required'=>true]); ?>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('valeur', ['label'=>'Valeur *']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('marque_equipement_id', ['options' => $marqueEquipements,'empty'=>'Séléctionnez','label'=>'Marque :','class' => 'selectpicker', 'data-live-search' => true]); ?>
                        </div>
                    </div>
                    
                     <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('commentaire', ['label'=>'Caractéristiques']); ?>
                        </div>
                    </div>
                    
                    
                    
                <h3 class="box-title m-t-40">Gestion documents </h3>
                <hr>

                <?php if (!empty($equipement->equipements_documents)){ ?>

                <?php foreach ($equipement->equipements_documents as $key => $document){ ?>

                <?php echo $this->Form->control('asuppr.'.($key),["type"=>"hidden","id"=>"asuppr-".$key]) ?>

                <div class="row p-t-20 gestionDocuments" id="gestionDocuments-<?= $key ?>">
                    
                    <?= $this->Form->control('documents.'.$key.'.id',["id"=>"documents-id-".$key,"type"=>"hidden", 'value' => $document->id]) ?>
                    <div class="col-md-3 bloc_dropify">
                        <?= $this->Form->control('documents.'.$key.'.file',["id"=>"documents-file-".$key, "label"=>"Fichier : ","class"=>"dropify", "type"=>"file", "data-height"=>"100", 'data-default-file'=>$document->url]) ?>
                        <?= $document->url ? $this->Html->link('Visualiser', $document->url,['escape' => false,"class"=>"", 'target'=>'_blank']) : '' ?>
                    </div>
                    <div class="col-md-3 bloc_titre">
                        <?= $this->Form->control('documents.'.$key.'.titre',["id"=>"documents-titre-".$key, 'label' => 'Titre : ', 'type' => 'text', "default" => $document->titre]); ?>
                    </div>
                    <div class="col-md-4">
                        <?= $this->Form->control('documents.'.$key.'.description',["id"=>"documents-description-".$key, 'label' => 'Description : ', "class"=>"form-control", 'type' => 'textarea', "default" => $document->description]); ?>
                    </div>
                    <span class="btn kl_suppr_doc_edit" id="btnSupprDoc-<?= $key.'-'.$document->id ;?>">✘</span>
                    <?php if($key == 0) { ?>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-info" id="id_add_doc" >Ajouter document</button>
                    </div>
                    <?php } ?>
                </div>
                <?php } } else { ?>
                    <div class="row p-t-20 gestionDocuments" id="gestionDocuments-0">
                        <div class="col-md-3 bloc_dropify">
                            <?php echo $this->Form->control('documents.0.file',["id"=>"documents-file-0", "label"=>"Fichier : ","class"=>"dropify", "type"=>"file", "data-height"=>"100"]) ?>
                        </div>
                        <div class="col-md-3 bloc_titre">
                            <?php echo $this->Form->control('documents.0.titre',["id"=>"documents-titre-0", 'label' => 'Titre : ', 'type' => 'text']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('documents.0.description',["id"=>"documents-description-0", 'label' => 'Description : ', "class"=>"form-control", 'type' => 'textarea']); ?>
                        </div>
                        <span class="btn kl_suppr_doc" id="btnSupprDoc-0">✘</span>
                        <div class="col-md-2 text-right">
                            <button type="button" class="btn btn-info" id="id_add_doc" >Ajouter document</button>
                        </div>
                    </div>
                <?php } ?>
                   
                </div>
                <br>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?php //echo $this->Html->link('<i class="fa fa-refresh"></i> Calcel',['controller' => 'Equipements', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Annuler", "class"=>"btn btn-inverse", "escape"=>false]);?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>



