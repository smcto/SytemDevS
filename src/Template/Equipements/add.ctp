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
$titrePage = "Ajout d'un nouveau équipement" ;
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
            <?= $this->Form->create($equipement, ['type' => 'file']) ?>
                <div class="form-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('valeur', ['label'=>'Valeur *']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_equipement_id', [
                                'options' => $typeEquipements,
                                'empty'=>'Séléctionnez',
                                'label'=>'Type * :',
                                'required'=>true,
                                'class'=>'form-control select2', 
                                'style' => 'width:100%']); ?>
                        </div>
                    </div>

                    <div class="row">
                        
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('marque_equipement_id', [
                                'options' => $marqueEquipements,
                                'empty'=>'Séléctionnez',
                                'label'=>'Marque *',
                                'class'=>'form-control select2', 
                                'style' => 'width:100%']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('commentaire', ['label'=>'Caractéristiques']); ?>
                        </div>
                    </div>
                    
                    
                <h3 class="box-title m-t-40">Gestion documents </h3>
                <hr>

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

                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?php //echo $this->Html->link('<i class="fa fa-refresh"></i> Calcel',['controller' => 'Equipements', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Annuler", "class"=>"btn btn-inverse", "escape"=>false]);?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>



