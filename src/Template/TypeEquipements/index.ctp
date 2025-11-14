<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeFournisseur[]|\Cake\Collection\CollectionInterface $typeEquipements
 */
?>
<?php
$titrePage = "Liste des types d'équipement" ;

$this->assign('title', 'Types équipement');

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
    echo $this->Html->link('Voir les équipements',['controller' => 'Equipements', 'action' => 'index'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary",'style'=>'margin: 0 10px 0 0' ]),' ';
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                 <?= $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                     <div class="row">
                         <div class="col-md-2">
                             <?= $this->Form->control('gamme_borne_id', ['options' => $gammesBornes, 'default' => $gamme_borne_id, 'empty' => 'Gamme', 'label' => false, 'class' => 'form-control selectpicker']); ?>
                         </div>
                         <div class="col-md-2">
                             <?= $this->Form->control('is_vente', ['options' => $yes_or_no, 'default' => @$is_vente, 'empty' => 'Formulaire vente', 'label' => false, 'class' => 'form-control selectpicker']); ?>
                         </div>
                         <div class="col-md-2">
                             <?= $this->Form->control('type', ['options' => ['is_structurel' => 'équipement structurel', 'is_accessoire' => 'équipement accessoire', 'is_protection' => 'équipement protection'], 'default' => @$type, 'empty' => 'Type', 'label' => false, 'class' => 'form-control selectpicker']); ?>
                         </div>

                         <div class="col-md-3 p-l-0">
                             <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                             <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                         </div>
                     </div>
                 <?= $this->Form->end(); ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Nombre équipement</th> 
                                <th>Gamme</th> 
                                <th>Type</th> 
                                <th>Formulaire vente</th> 
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($typeEquipements as $typeEquipement): ?>
                                <tr>
                                    <td><?= $this->Html->link($typeEquipement->nom, ['action' => 'add', $typeEquipement->id]) ?></td>
                                    <td><?= $this->Html->link(count($typeEquipement->equipements), ['controller' => 'Equipements', 'action' => 'index', 'type_equipement' => $typeEquipement->id]) ?></td>
                                    <td><?= $this->Text->toList($typeEquipement->get('GammesBornesList'), '<br>', '<br>') ?></td>
                                    <td><?= $this->Text->toList($typeEquipement->get('TypeList'), '<br>', '<br>') ?></td>
                                    <td><?= $typeEquipement->is_vente ? 'Oui' : 'Non' ?></td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $typeEquipement->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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


