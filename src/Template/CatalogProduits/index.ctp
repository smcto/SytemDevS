<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduit[]|\Cake\Collection\CollectionInterface $catalogProduits
 */
?>

<?= $this->Html->css('catalog-produits/catalog-produits.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->script('catalog-produits/index.js?'.  time(), ['block' => true]); ?>

<?php
$titrePage = "Liste des produits" ;

$this->assign('title', 'Produits');

$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
        'Regalges',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'filtre-produits','role'=>'form']); ?>
                        <div class="filter-list-wrapper catalogue-produit-wrapper">
                            <div class="filter-block">
                                <?= $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('code',['value'=>$code, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Code comptable']); ?>
                            </div>
                            <div class="filter-block hide">
                                <?= $this->Form->control('nom_commercial',['value'=>$nom_commercial, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Nom de produit']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('catalog_category_id', ['label' => false ,'options'=> $catalogCategories, 'value'=> $categorie, 'id' => 'categorie_id', 'class'=>'form-control' ,'empty'=> 'Catégorie'] );?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('catalog_sous_category_id',  ['label' => false , 'id' => 'sous_categorie', 'value'=> $sous_categorie, 'class'=>'form-control' ,'empty'=>'Sous catégorie'] );?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('sous_sous_category_id', ['id' => 'sous-sous-categorie', 'label' => false, 'value'=> $sous_sous_categorie, 'empty' => 'Toutes les sous sous catégories', 'class' => 'input-in-modal form-control']) ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('pro_part',  ['options' => $types, 'label' => false , 'id' => 'pro_part', 'value'=> $pro_part, 'class'=>'form-control' ,'empty'=>'Pro/Particulier'] );?>
                            </div>
                            <div class="filter-block">
                                <div class="form-group">
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('nom_commercial', 'Nom commercial') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('mots_cles', 'Mots clés') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('code_comptable', 'Code Compta') ?></th>
                            <th scope="col">Dans</th>
                            <th scope="col"><?= $this->Paginator->sort($pro_part ?? 'is_pro', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('prix_reference_ht', 'Prix HT') ?></th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($catalogProduits as $catalogProduit): ?>
                        <tr>
                            <td><?= $this->Html->link($catalogProduit->nom_commercial, ['action' => 'view', $catalogProduit->id]) ?></td>
                            <td><?= $catalogProduit->mots_cles ?></td>
                            <td><?= $catalogProduit->code_comptable ?></td>
                            <td><?= $this->Text->toList($catalogProduit->get('AllCategoriesList'), '<br>', '<br>'); ?></td>
                            <td><?= $catalogProduit->is_pro?"Pro <br>":"" ?><?= $catalogProduit->is_particulier?"Part":"" ?></td>
                            <td><?= $this->Utilities->formatCurrency($catalogProduit->prix_reference_ht) ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'add', $catalogProduit->id], ['escape'=>false]) ?>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $catalogProduit->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if (count($catalogProduits)) : ?>
                    <?= $this->element('tfoot_pagination') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var catalogSousCategories = <?php echo json_encode($catalogSousCategories); ?>;
    var sous_sous_categorie = <?php echo json_encode($catalogSousSousCategories); ?>;
    var sous_sous_cat_val = <?= $sous_sous_categorie? : 0; ?>;
</script>
