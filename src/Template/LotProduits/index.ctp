<?php  $this->Html->script('lot_produits/index.js?time='.time(), ['block' => 'script']); ?>

<?php

$titrePage = $is_event ? "Stock event : vue synthétique" : "Stock composants : vue synthétique";
if ($is_destock) {
    $titrePage = $is_event? "Stock event destocké" : "Stock composants destocké" ;
}

$this->assign('title', $titrePage);

$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');

$csvLink = ['controller' => 'LotProduits', 'action' => 'index', $is_event? 'stock-event' : 'stock-composants', 'export'=> 'csv'];
$csvLink = array_merge($csvLink, $customFinderOptions);
        
echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-l-5" ]);
echo $this->Html->link('Export csv',$csvLink,['escape'=>false,"class"=>"btn btn-rounded btn-success pull-right m-l-5"]);
echo $this->Html->link('Vue détail',['controller' => 'LotProduits', 'action' => 'detail', $is_event?"stock-event":"stock-composants", $is_destock ? 'destock' : ''],['escape'=>false,"class"=>"btn btn-rounded btn-secondary pull-right"]);
echo $this->Html->link('Voir les produits destockés',[$is_event?"stock-event":"stock-composants", 'destock'],['escape'=>false,"class"=> $is_destock ? "hide" : "btn btn-rounded btn-secondary pull-right m-r-5"]);
echo $this->Html->link('Voir stock',[$is_event?"stock-event":"stock-composants"],['escape'=>false,"class"=> $is_destock ? "btn btn-rounded btn-secondary pull-right m-r-5" : "hide"]);

$this->end();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix">
                    <div class="float-right my-auto "> <?= $is_event?"Valeur du stock à neuf (hors décote) : " : "Valeur du stock :" ?> <?= $this->Number->format($totalHt->sum) ?> €</div>
                </div>
                <hr>
                <div class="form-body">
                    <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>

                        <?= $this->Form->hidden('is_event', ['value' => $is_event]); ?>
                        <?= $this->Form->hidden('is_hs', ['value' => $is_destock]); ?>
                        <div class="filter-list-wrapper lot-produit-filter-wrapper clearfix">
                            <div class="filter-block container-filter d-none">
                                <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                            </div>

                            <div class="filter-block container-filter d-none">
                                <?php echo $this->Form->control('type_equipement', ['label' => false ,'options'=>!empty($type_equipements) ? $type_equipements : [], 'value'=> $type_equipement, 'class'=>'form-control selectpicker', 'data-live-search' => true ,'empty'=>'Type d\'équipement'] );?>
                            </div>

                            <div class="filter-block container-filter d-none">
                                <?php echo $this->Form->control('marque_equipement', ['label' => false ,'options'=>!empty($marque_equipements) ? $marque_equipements : [], 'value'=> $marque_equipement,  'class'=>'form-control selectpicker', 'data-live-search' => true ,'empty'=>'Marque'] );?>
                            </div>
                            
                            <div class="filter-block container-filter d-none">
                                <?php echo $this->Form->control('etat', ['label' => false ,'options'=>!empty($etatHsRebus) ? $etatHsRebus : [], 'value'=> $etat, 'class'=>'form-control selectpicker', 'data-live-search' => true ,'empty'=>'Etat'] );?>
                            </div>

                            <div class="filter-block container-filter d-none">
                                <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'LotProduits', 'action' => 'index', $is_event?"stock-event":"stock-composants"],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                            </div>

                            <div class="col">
                                <button type="button" class="btn-show-filter btn btn-default float-right bg-white"><span class="fa fa-ellipsis-v"></span></button>
                            </div>

                        </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('equipement_nom', 'Equipement') ?></th>
                                <th><?= $this->Paginator->sort('type_equipement_nom', 'Type équipement') ?></th>
                                <th><?= $this->Paginator->sort('marque', 'Marque') ?></th>
                                <th><?= $this->Paginator->sort('quantite', 'Quantité') ?></th>
                                <th><?= $this->Paginator->sort('tarif_ht', 'Total HT') ?></th>
                                <th><?= $this->Paginator->sort('date_stock', 'Dernière entrée') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($lotProduits as $lotProduit): ?>
                        <tr>
                            <td>
                            <?php
                                $key = $lotProduit->equipement_nom;

                                echo $this->Html->link($lotProduit->equipement_nom, ['action' => 'detail' , 'key' => $key, $is_event?"stock-event":"stock-composants", $is_destock?'destock':''], ["escape"=>true]) 
                            ?>
                            </td>
                            <td><?= $lotProduit->type_equipement_nom ?></td>
                            <td><?= $lotProduit->marque ?></td>
                            <td><?= $lotProduit->quantite ?></td>
                            <td><?= $lotProduit->tarif_ht ? $this->Number->format($lotProduit->tarif_ht,['after' => ' €']) : "-"  ?></td>
                            <td><?= $lotProduit->date_stock ?></td>
                            
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
