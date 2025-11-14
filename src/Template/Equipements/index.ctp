<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur[]|\Cake\Collection\CollectionInterface $equipements
 */
?>
<?php
$titrePage = "Liste des équipements" ;
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
    echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]), ' ';
    echo $this->Html->link('Type équipement',['controller' => 'TypeEquipements', 'action' => 'index'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary",'style'=>'margin: 0 10px 0 0' ]),' ';
    echo $this->Html->link('Marque équipement',['controller' => 'MarqueEquipements', 'action' => 'index'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary",'style'=>'margin: 0 10px 0 0' ]);


$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="form-body">
                        <?php  
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']);    
                       ?>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                            </div>

                            <div class="col-md-3 p-l-0"> 
                                <?php echo $this->Form->control('type_equipement', ['label' => false ,'options'=>!empty($type_equipements) ? $type_equipements : [], 'value'=> $type_equipement, 'class'=>'form-control' ,'empty'=>'Type d\'équipement', 'class' => 'selectpicker', 'data-live-search' => true] );?>
                            </div>

                            <div class="col-md-2 p-l-0"> 
                                <?php echo $this->Form->control('marque_equipement', ['label' => false ,'options'=>!empty($marque_equipements) ? $marque_equipements : [], 'value'=> $marque_equipement, 'class'=>'form-control' ,'empty'=>'Marque d\'équipement', 'class' => 'selectpicker', 'data-live-search' => true] );?>
                            </div>
                            
                            <div class="col-md-2 p-l-0"> 
                                <?php echo $this->Form->control('document', ['label' => false ,'options'=> [1 => 'Oui', 2 => 'Non'], 'value'=> $doc, 'class'=>'form-control' ,'empty'=>'Documents', 'class' => 'selectpicker'] );?>
                            </div>

                            <div class="col-md-2 p-l-0">
                                <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'Equipements', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                            </div>

                        </div>
                        
                        <?php 
                        echo $this->Form->end(); 
                        ?>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Valeur</th>
                                <th>Marque</th>
                                <th>Type</th>
                                <th>Doc</th>
                                <th>Stock</th>
                                <th>Borne</th>
                                <th>Total</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($equipements as $equipement): ?>
                                <tr>
                                   <td><?php echo $this->Html->link($equipement->valeur,['action' => 'edit', $equipement->id]) ?></td>
                                   <td><?php echo empty($equipement->marque_equipement) ? '-' : $equipement->marque_equipement->marque ?></td>
                                   <td><?php echo $equipement->type_equipement->nom ?></td>
                                   <td><?php echo count($equipement->equipements_documents) ? 'x' : '' ?></td>
                                   <td><?php echo count($equipement->stock) ?></td>
                                   <td><?php echo count($equipement->used) ?></td>
                                   <td><?php echo count($equipement->stock) + count($equipement->used)?></td>
                                   <td>
                                       <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $equipement->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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


