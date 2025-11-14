<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\ModelBorne[]|\Cake\Collection\CollectionInterface $modelBornes
*/
?>

<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>
    
<?php
$titrePage = "Liste des modèles de borne" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
    echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);                           
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
                                <?php echo $this->Form->control('gamme', ['label' => false ,'options'=> $gammeBornes, 'value'=> $gamme, 'id' => 'gamme_borne_id', 'class'=>'form-control' ,'empty'=> 'Gamme'] );?>
                            </div>
                            
                            
                            <div class="col-md-3">
                                <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'ModelBornes', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('GammesBornes.name', 'Gamme') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Type') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('version') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('date_sortie','Date de sortie') ?></th>
                                <th>Nombre total</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($modelBornes as $modelBorne): ?>
                                <tr>
                                    <td><?= @h($modelBorne->gammes_borne->name) ?></td>
                                    <td><?= $this->Html->link($modelBorne->nom, ['action' => 'edit', $modelBorne->id]) ?></td>
                                    <td><?= h($modelBorne->version) ?></td>
                                    <td><?= h($modelBorne->date_sortie) ?></td>
                                    <td><?= count($modelBorne->bornes)?> </td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $modelBorne->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
