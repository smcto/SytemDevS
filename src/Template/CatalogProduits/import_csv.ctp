<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php
$titrePage = "Import des données via CSV";
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
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($catalogProduits, ['type' => 'file']) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('csv',["label"=>"fichier (csv)*: ", 'type' => 'file',"class"=>"form-control","required" => true, "accept"=>".csv"]) ?>
                            </div>
                        </div>

                       <div class="form-actions">
                            <?= $this->Form->button('Impoter',["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                            <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>



