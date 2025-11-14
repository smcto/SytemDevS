<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogSousCategory[]|\Cake\Collection\CollectionInterface $catalogSousCategories
 */
?>

<?php
$titrePage = "Liste des sous categories des catalogues" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
    'Reglages',
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
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $this->Form->control('catalog_categories_id', ['label' => false ,'options'=> $catalogCategories, 'value'=> $categorie, 'id' => 'categorie_id', 'class'=>'form-control' ,'empty'=> 'Catégorie'] );?>
                            </div>
                            <div class="col-md-2">
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
                            <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('catalog_categories_id') ?></th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($catalogSousCategories as $catalogSousCategorie): ?>
                        <tr>

                            <td><?= $this->Html->link($catalogSousCategorie->nom, ['action' => 'add', $catalogSousCategorie->id]) ?></td>
                            <td><?= $catalogSousCategorie->catalog_category->nom ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $catalogSousCategorie->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>
</div>
