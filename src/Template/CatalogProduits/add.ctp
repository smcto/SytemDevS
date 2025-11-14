<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduit $catalogProduit
 */
?>
<?= $this->Html->css('bootstrap/bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>
<?= $this->Html->css('catalog-produits/catalog-produits.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->css('wickedpicker.css?'.  time(), ['block' => true]) ?>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('wickedpicker.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('catalog-produits/catalog-produits.js?'.  time(), ['block' => true]); ?>


<?php
$titrePage = "Ajout d'un nouveau produit" ;
$this->start('breadcumb');

$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
        'Regalges',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add(
    'Catalogue produit',
    ['controller' => 'CatalogProduits', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row">
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-body">
            <?= $this->Form->create($catalogProduit, ['type'=>'file']) ?>
                <input type="hidden" value="<?= $catalogProduit->id ?>" id="catalog_produit_id">

                <div class="form-body">
                    <h3 class="card-title">Informations</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label">Nom commercial (*)</label>
                                    <?php echo $this->Form->control('nom_commercial',['label' => false,'class'=>'form-control','required' => true]);?>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Nom Interne</label>
                                    <?php echo $this->Form->control('nom_interne',['label' => false,'class'=>'form-control']);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-block clearfix">
                        <button type="button" class="btn btn-primary add-data float-right mt-2 mb-4">Ajouter une catégorie</button>
                    </div>

                    <div class="categories-container">
                        <div class="row">
                            <div class="col-md-10 default-data">
                        
                                <?php if ($catalogProduit->catalog_produits_has_categories): ?>
                                    <?php foreach ($catalogProduit->catalog_produits_has_categories as $key => $catalog_produits_has_categories): ?>
                                        <?php $catalogSousCategoriesOptions = $catalogSousCategories->toArray()[$catalog_produits_has_categories->catalog_category_id]; ?>
                                        <?php $catalogSousSousCategoriesOptions = $catalogSousSousCategories->toArray()[$catalog_produits_has_categories->catalog_sous_category_id] ?? []; ?>
                                        <div class="row ligne">
                                            <div class="col-md-3">
                                                <?= $this->Form->hidden("catalog_produits_has_categories.$key.id", ['input-name' => 'id', 'label' => false, 'id' => 'email']); ?>
                                                <?php echo $this->Form->control("catalog_produits_has_categories.$key.catalog_category_id", ['input-name' => 'catalog_category_id', 'id' => 'catalog-category-id', 'label' => 'Catégorie *','type'=>'select','options' => $catalogCategories]); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php echo $this->Form->control("catalog_produits_has_categories.$key.catalog_sous_category_id", ['input-name' => 'catalog_sous_category_id', 'id' => 'catalog-sous-category-id', 'label' => 'Sous catégorie *', 'type' => 'select', 'options' => $catalogSousCategoriesOptions, 'empty' => 'Séléctionner','required' => true]); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <?php echo $this->Form->control("catalog_produits_has_categories.$key.catalog_sous_sous_category_id", ['input-name' => 'catalog_sous_sous_category_id', 'id' => 'catalog-sous-sous-category-id', 'label' => 'Sous sous catégorie', 'type' => 'select', 'options' => $catalogSousSousCategoriesOptions, 'empty' => 'Séléctionner','required' => false]); ?>
                                            </div>
                                            <div class="col-md-3 pt-3">
                                                <a href="#" class="pt-4 d-block" id="remove-prod" data-href="<?= $this->Url->build(['controller' => 'AjaxCatalogProduits', 'action' => 'deleteHasCategories', $catalog_produits_has_categories->id]) ?>"><i class="mdi mdi-delete text-inverse"></i></a>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>

                                <?php $init = isset($key) ? $key+1 : 0 ?>
                                <?php if (!$catalogProduit->id): ?>
                                    <div class="row ligne">
                                        <div class="col-md-3">
                                            <?php echo $this->Form->control("catalog_produits_has_categories.$init.catalog_category_id", ['input-name' => 'catalog_category_id', 'id' => 'catalog-category-id', 'label' => 'Catégorie *','type'=>'select', 'empty' => 'Séléctionner', 'options' => $catalogCategories]); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?php echo $this->Form->control("catalog_produits_has_categories.$init.catalog_sous_category_id", ['input-name' => 'catalog_sous_category_id', 'id' => 'catalog-sous-category-id', 'label' => 'Sous catégorie *','type'=>'select','options' =>[], 'empty' => 'Séléctionner','required' => true]); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?php echo $this->Form->control("catalog_produits_has_categories.$init.catalog_sous_sous_category_id", ['input-name' => 'catalog_sous_sous_category_id', 'id' => 'catalog-sous-sous-category-id', 'label' => 'Sous sous catégorie','type'=>'select','options' =>[], 'empty' => 'Séléctionner','required' => false]); ?>
                                        </div>
                                        <div class="col-md-3 pt-3">
                                            <a href="#" class="pt-4 d-block" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                        
                        <div class="row d-none clone added-tr">
                            <div class="col-md-3">
                                <?php echo $this->Form->control('catalog_category_id', ['input-name' => 'catalog_category_id', 'label' => 'Catégorie *','type'=>'select','options' => $catalogCategories, 'empty' => 'Séléctionner']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $this->Form->control('catalog_sous_category_id', ['input-name' => 'catalog_sous_category_id', 'label' => 'Sous catégorie *','type'=>'select','options' => [], 'empty' => 'Séléctionner']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo $this->Form->control('catalog_sous_sous_category_id', ['input-name' => 'catalog_sous_sous_category_id', 'label' => 'Sous sous catégorie','type'=>'select','options' => [], 'empty' => 'Séléctionner','required' => false]); ?>
                            </div>
                            <div class="col-md-3 pt-3">
                                <a href="#" class="pt-4 d-block" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a>
                            </div>
                        </div>
                    </div>


                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                           <?php echo $this->Form->control('description_commercial',['label' => 'Description commerciale (*) ',"class"=>"textarea_editor form-control", "rows"=>"7",'required' => false]); ?>
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           <?php echo $this->Form->control('description_bl',['label' => 'Description bon de commande ',"class"=>"textarea_editor form-control", "rows"=>"8",'required' => false]); ?>
                       </div>
                    </div>
                    <div class="form-group row">
                         <div class="col-sm-4">
                            <label class="control-label">Mots clés (séparer par une virgule)</label>                           
                            <?php echo $this->Form->control('mots_cles',['label' => false]); ?>
                         </div>
                        
                         <div class="col-sm-4">
                            <label class="control-label">Prix de référence HT (*)</label>                           
                            <?php echo $this->Form->control('prix_reference_ht',['label' => false, 'type' => 'number','required' => true]); ?>
                         </div>
                        
                         <div class="col-sm-4">
                            <label class="control-label">Unité</label>                           
                            <?php echo $this->Form->control('catalog_unites_id',['options' => $unites, 'label' => false]); ?>
                         </div>
                        
                         <div class="col-sm-4">
                            <label class="control-label">Quantité usuelle (*)</label>                           
                            <?php echo $this->Form->control('quantite_usuelle',['type' => 'number', 'label' => false,'required' => true]); ?>
                         </div>
                        
                         <div class="col-sm-4">
                            <label class="control-label">Code comptable (*)</label>                                   
                            <?php echo $this->Form->control('code_comptable',['label' => false,'class'=>'form-control onlyint' , 'maxlength' => 8]); ?>
                         </div>

                        <div class="col-sm-4">
                            <label class="control-label">Référence (*)</label>
                            <?php echo $this->Form->control('reference',['label' => false,'class'=>'form-control ','required' => true]);?>
                        </div>
                    </div>
                    
                    <div class="row">
                       <div class="col-md-12">
                            <label>Photo(s)</label>
                            <div class="dropzone" id="id_dropzone" data-owner="photo"> </div>
                        </div>
                    </div>
                </div>

                <h3 class="box-title m-t-40">Gestion documents </h3>
                <hr>

                <?php if (!empty($catalogProduit->catalog_produits_documents)){ ?>

                <?php foreach ($catalogProduit->catalog_produits_documents as $key => $document){ ?>

                <?php echo $this->Form->control('asuppr.'.($key),["type"=>"hidden","id"=>"asuppr-".$key]) ?>

                <div class="row p-t-20 gestionDocuments" id="gestionDocuments-<?= $key ?>">
                    
                    <?= $this->Form->control('documents.'.$key.'.id',["id"=>"documents-id-".$key,"type"=>"hidden"]) ?>
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

                <div class="form-actions mt-5">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn btn-rounded btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>