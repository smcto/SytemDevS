<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fournisseur[]|\Cake\Collection\CollectionInterface $fournisseurs
 */
?>

<?php
$titrePage = "Liste des fournisseurs" ;
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
echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
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
                                <?php echo $this->Form->control('type_fournisseur', ['label' => false ,'options'=>!empty($type_fournisseurs) ? $type_fournisseurs : [], 'value'=> $type_fournisseur, 'class'=>'form-control' ,'empty'=>'Type de fournisseur'] );?>
                            </div>

                            <div class="col-md-3 p-l-0">
                                <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'Fournisseurs', 'action' => 'index'],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
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
                                <th>Nom commercial</th>
                                <th>Type</th>
                                <!--<th>Ville</th>
                                <th>Antenne rattachée</th>-->
                                <th>Commentaire</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($fournisseurs as $fournisseur): ?>
                                <tr>

                                    <td><?= $this->Html->link($fournisseur->nom, ['action' => 'edit', $fournisseur->id]) ?></td>
                                    <td><?= $fournisseur->has('type_fournisseur') ? $this->Html->link($fournisseur->type_fournisseur->nom, ['controller' => 'TypeFournisseurs', 'action' => 'view', $fournisseur->type_fournisseur->id]) : '' ?></td>
                                    <!--<td><?= h($fournisseur->ville) ?></td>
                                    <td><?php if(!empty($fournisseur->antenne->ville_excate)) echo $fournisseur->antenne->ville_excate ; ?></td>-->
                                    <td><?= h($fournisseur->commentaire) ?></td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $fournisseur->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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



