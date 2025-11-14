<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModelBorne $modelBorne
 */
?>

<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('jquery-asColorPicker-master/asColorPicker.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>

<!-- Plugin for this page -->
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>


<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('model_bornes/model_bornes.js', ['block' => true]); ?>


<?php
$titrePage = "Création d'un nouveau modèle de borne" ;
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
            <h4 class="m-b-0 text-white"><?= __("Model information") ?></h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($modelBorne, ['type' => 'file',"id"=>"myDrop"]) ?>
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('nom',['label' => 'Nom du modèle *']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                           <?php echo $this->Form->control('version',['label' => 'Version *']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Date sortie *</label>
                                <input type="date" name="date_sortie" class="form-control" placeholder="dd/mm/yyyy" required="">
                            </div>
                        </div>
                        
                        <!--<div class="col-md-4">
                            <h5 class="box-title">Couleur possible</h5>
                            <div id="id_listeColor">
                                    <div class="row kl_oneColor">
                                        <div class="col-md-10 p-r-0"><?php echo $this->Form->control('couleur_possibles.0.couleur',['label'=>false]); ?></div>
                                        <div class="col-md-2 p-l-0">
                                            <button type="button" class="btn btn-info" id="id_addColor" ><i class="ti-plus text" ></i></button>
                                        </div>
                                    </div>
                            </div>
                        </div>-->
                        
                        <div class="col-md-6">
                           <?php 
                            echo $this->Form->control('couleurs._ids', [
                                'type' => 'select',
                                'multiple' => true,
                                'options' => $couleurs,
                                "class"=>"select2 form-control select2-multiple",
                                "data-placeholder"=>"Choisir",
                                'label' => 'Couleur possible'
                            ]);
                            ?>
                        </div>

                        
                        <div class="col-md-6">
                           <?= $this->Form->control('gamme_borne_id', ['options' => $gammesBornes, "class"   => "form-control", "empty"   => "Choisir", 'label'   => 'Gamme *']); ?>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('description',['type'=>'textarea']); ?>
                        </div>
                        <div class="col-md-6">
                            <label>Photo(s) d'illustration </label>
                            <div class="dropzone" id="id_dropzone"> </div>
                        </div>
                    </div>
                    <!--/row-->
                    
                    <h3 class="box-title m-t-40">Dimensions </h3>
                    <hr>
                    <div class="">
                           <?php echo $this->Form->control('dimension',['label'=>false,"class"=>"textarea_editor form-control",'type'=>'textarea']); ?>
                     </div>
                    <!--
                        <?php /*
                        $paList = $parties->toArray();
                        $i = 0;
                        foreach($paList as $key => $value){ 
                            $labelPartie = "Partie";
                            $labelDimension = "Dimension";
                            $labelPoids = "Poids";
                            if($i > 0){
                                $labelPartie = "";
                                $labelDimension = "";
                                $labelPoids = "";
                            }
                            */
                            ?>
                            <div class="row kl_row_<?= $key ?>">
                                <div class="col-md-4 ">
                                   <?php // echo $this->Form->control('dimensions.'.$key.'.partie_id', ['label'=>$labelPartie, 'type'=>'select', 'options'=>$parties, 'value'=>$key]); ?>
                                </div>
                                <div class="col-md-4 ">
                                    <?php // echo $this->Form->control('dimensions.'.$key.'.dimension',['label' => $labelDimension]); ?>
                                </div>
                                <div class="col-md-4 ">
                                    <?php //echo $this->Form->control('dimensions.'.$key.'.poids',['label' => $labelPoids]); ?>
                                </div>
                            </div>
                        <?php //$i++; } ?>

                        -->


                    <!--/row-->
                    <h3 class="box-title m-t-40">Configuration </h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('couleur_id',['label' => 'Couleur ' , 'empty' => 'Séléctionner']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('pied_id',['label' => 'Pied ' , 'empty' => 'Séléctionner', 'class' => 'selectpicker', 'options' => $type_equipement_pied]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 hide">
                            <?php echo $this->Form->control('modele_imprimante',['label' => 'Modèle imprimante']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_imprimante_id',['label' => 'Modèle imprimante', 'options' => $type_imprimante, 'empty' => 'Séléctionner']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-6 hide">
                            <?php echo $this->Form->control('model_appareil_photo',['label' => 'Modèle appareil photo']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_appareil_photo_id',['label' => 'Modèle appareil photo', 'options' => $type_appareil_photo, 'empty' => 'Séléctionner']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    
                    <h3 class="box-title m-t-40">Remarque </h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('note_complementaire',['type'=>'textarea','label' =>'Notes complémentaires']); ?>
                        </div>
                    </div>
                    <h3 class="box-title m-t-40">Gestion documents internes </h3>
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
                    <hr class="separateur_doc">
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
                