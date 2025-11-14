<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduit $catalogProduit
 */
?>

<!-- Plugin for this page -->
<?= $this->Html->css('jquery-asColorPicker-master/asColorPicker.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('catalog-produits/catalog-produits.css?'.  time(), ['block' => true]) ?>
<!-- Plugin for this page -->

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>

<?= $this->Html->script('catalog-produits/view.js?' . time(), ['block' => true]); ?>

<?php

$titrePage = "Information Catalogue produit" ;
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= $catalogProduit->nom_commercial ?></h3>
                <hr>
                <div class="form-group row">
                    <label class="control-label col-md-4">Nom interne : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->nom_interne ?>
                    </div>
                    <label class="control-label col-md-4">Prix de référence HT : </label>
                    <div class="col-md-8">
                        <?= @$this->Number->format($catalogProduit->prix_reference_ht) ?> €
                    </div>
                    <label class="control-label col-md-4">Tarif TTC : </label>
                    <div class="col-md-8">
                        <?= @$this->Number->format($catalogProduit->prix_reference_ht * 1.20) ?> €
                    </div>
                    <label class="control-label col-md-4">Code comptable : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->code_comptable ?>
                    </div>
                    <label class="control-label col-md-4">Référence : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->reference ?>
                    </div>
                    <label class="control-label col-md-4">Mots clés : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->mots_cles ?>
                    </div>
                    <label class="control-label col-md-4">Quantité usuelle : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->quantite_usuelle ?>
                    </div>
                    <label class="control-label col-md-4">Unité : </label>
                    <div class="col-md-8">
                        <?= $catalogProduit->catalog_unite? $catalogProduit->catalog_unite->nom : '-'?>
                    </div>
                    <label class="control-label col-md-4">Dans : </label>
                    <div class="col-md-8">
                        <?= $this->Text->toList($catalogProduit->get('AllCategoriesList'), '<br>', '<br>'); ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?= $this->Html->link(__('Edit produit'),['controller' => 'CatalogProduits', 'action' => 'add', $catalogProduit->id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Description commerciale </h3>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <?= $catalogProduit->description_commercial; ?>
                     </div>
                </div>
                
                <h3 class="card-title">Description bon de commande </h3>
                <hr>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <?= $catalogProduit->description_bl; ?>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php if($catalogProduit->devis_produits) : ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Stats du produit</h3>
                    <hr>
                    <div class="form-group row">
                        <label class="control-label col-md-6">Nombre de fois utilisé dans les devis  : </label>
                        <div class="col-md-6">
                            <?= count($catalogProduit->devis_produits) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php $i = 1?>
                <h3 class="card-title">Document(s)</h3>
                <hr>
                <div class="container">

                    <?php if($catalogProduit->catalog_produits_documents) : ?>
                            <?php  foreach ($catalogProduit->catalog_produits_documents as $document) : ?>

                                <div class="form-group row">
                                    <label class="control-label col-md-4">Titre : </label>
                                    <div class="col-md-8">
                                        <?= $document->titre ?>
                                    </div>
                                    <label class="control-label col-md-4">Description : </label>
                                    <div class="col-md-8">
                                        <?= $document->description ?>
                                    </div>
                                    <label class="control-label col-md-4">Url : </label>
                                    <div class="col-md-8">
                                        <?= $document->url ? $this->Html->link('Visualiser', $document->url,['escape' => false,"class"=>"", 'target'=>'_blank']) : '' ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <?php $i = 1?>
                <h3 class="card-title">Photo(s)</h3>
                <hr>
                <div class="container">

                    <?php if($catalogProduit->catalog_produits_photos) : ?>
                        <?php  foreach ($catalogProduit->catalog_produits_photos as $image) : ?>
                            <div class="mySlides">
                                <div class="numbertext"><?= $i .'/'. count($catalogProduit->catalog_produits_photos) ?></div>
                                <img src="../../../webroot/uploads/catalogue_produits/<?= $image->nom_fichier ?>" class="img-produit">
                            </div>
                        <?php endforeach; ?>

                        <?php if(count($catalogProduit->catalog_produits_photos) > 1) : ?>
                            <a class="prev" onclick="plusSlides(-1)"><</a>
                            <a class="next" onclick="plusSlides(1)">></a>
                        <?php endif; ?>
                    <?php endif; ?>
                            
                </div>
            </div>
        </div>
    </div>

</div>