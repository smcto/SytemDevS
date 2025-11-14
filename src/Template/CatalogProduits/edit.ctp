<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduit $catalogProduit
 */
?>

<?= $this->Html->css('bootstrap/bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
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

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('wickedpicker.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
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
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="control-label">Nom commercial</label>
                            <?php echo $this->Form->control('nom_commercial',['label' => false,'class'=>'form-control']);?>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Nom Interne</label>
                            <?php echo $this->Form->control('nom_interne',['label' => false,'class'=>'form-control']);?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('catalog_categories',['label' => 'Catégorie *','type'=>'select','options' => $catalogCategories, 'value' => $catalogProduit->catalog_sous_category->catalog_categories_id]); ?>
                        </div>
                        <div class="col-md-3">
                            <?php echo $this->Form->control('catalog_sous_categories_id',['label' => 'Sous catégorie *','type'=>'select','options' =>[], 'empty' => 'Séléctionner']); ?>
                            <input type="hidden" value="<?= $catalogProduit->catalog_sous_categories_id ?>" id="catalog_sous_categories_id_value">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                           <?php echo $this->Form->control('description_commercial',['label' => 'Description commercial ',"class"=>"textarea_editor form-control", "rows"=>"7"]); ?>
                       </div>
                    </div>
                    <div class="form-group row">
                         <div class="col-sm-3">
                            <label class="control-label">Prix de référence HT</label>                           
                            <?php echo $this->Form->control('prix_reference_ht',['type' => 'number', 'label' => false]); ?>
                         </div>
                        
                         <div class="col-sm-3">
                            <label class="control-label">Unité</label>                           
                            <?php echo $this->Form->control('catalog_unites_id',['options' => $unites, 'label' => false]); ?>
                         </div>
                        
                         <div class="col-sm-3">
                            <label class="control-label">Quantité usuelle</label>                           
                            <?php echo $this->Form->control('quantite_usuelle',['type' => 'number', 'label' => false]); ?>
                         </div>
                        
                         <div class="col-sm-3">
                            <label class="control-label">Code comptable </label>                                   
                            <?php echo $this->Form->control('code_comptable',['label' => false,'class'=>'form-control ']); ?>
                         </div>
                        
                    </div>
                        
                    <div class="form-group row">

                        <div class="col-sm-4">
                            <label class="control-label">Référence</label>
                            <?php echo $this->Form->control('reference',['label' => false,'class'=>'form-control ']);?>
                        </div>
                        
                        <div class="col-sm-4 m-t-30">
                            <?php echo $this->Form->control('is_particulier',['label' => "Produit pour les particuliers",'class'=>'form-control' ,'type' => 'checkbox', 'value' => 1]);?>
                        </div>
                        
                        <div class="col-sm-4 m-t-30">
                            <?php echo $this->Form->control('is_pro',['label' => "Produit pour les professionnels",'class'=>'form-control' ,'type' => 'checkbox', 'value' => 1]);?>
                        </div>
                    </div>
                    
                    <div class="row">
                       <div class="col-md-12">
                            <label>Photo(s)</label>
                            <div class="dropzone" id="id_dropzone" data-owner="photo"> </div>
                        </div>
                    </div>
                </div>
                    

                <div class="form-actions mt-5">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Html->link(__('Cancel'),['action' => 'index',],["class"=>"btn btn-rounded btn-inverse", "escape"=>false]);?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    var catalogSousCategories = <?php echo json_encode($catalogSousCategories); ?>;
</script>