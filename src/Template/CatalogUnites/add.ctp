<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogCategory $catalogUnite
 */
?>
<?php
    $this->assign('title', 'Categorie');
    $titrePage = "Ajouter une nouvelle unité" ;
    if ($id) {
        $titrePage = "Modification d'une unité" ;
    }
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );
    $this->Breadcrumbs->add(
        'Reglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
    );
    $this->Breadcrumbs->add(
        'Unités',
        ['controller' => 'CatalogUnites', 'action' => 'index']
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
                <?= $this->Form->create($catalogUnite) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('nom', ["label" => __('Name').' * :', "class" =>" form-control", 'required' => 'required']) ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded  btn-success",'escape'=>false]) ?>
                            <?= $this->Html->link(__('Cancel'),['action' => 'index',],["class"=>"btn btn-rounded btn-inverse", "escape"=>false]);?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>