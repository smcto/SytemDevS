<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<?php
$titrePage = "Modification de la catégorie de documentation" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Liste des catégories',
    ['controller' => 'Categories', 'action' => 'index']
);

$this->Breadcrumbs->add('Modifier');

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row">
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Information générales</h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($category) ?>
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('nom',['label' => 'Nom *']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-12">
                           <?php echo $this->Form->control('parent_id',['label' => 'Parent', 'options'=>$parentCategories,'empty'=>'Séléctionner']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    

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
