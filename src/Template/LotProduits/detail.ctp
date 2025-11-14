<?php
use Cake\Routing\Router;
?>

<?= $this->Html->script('lot_produits/index.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>

<?php

$titrePage = $is_event? "Stock event : vue détail" : "Stock composants : vue détail" ;
if ($is_destock) {
    $titrePage = $is_event? "Stock event destocké" : "Stock composants destocké" ;
}

$customCheckBoxMultiSelect = [
    'nestingLabel' => '{{hidden}}<label{{attrs}} class="custom-control ml-3 px-2 m-0 custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',        
];

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

$csvLink = ['controller' => 'LotProduits', 'action' => 'detail',$is_event? 'stock-event' : 'stock-composants', 'export' => 'csv'];
$csvLink = array_merge($csvLink, $customFinderOptions);
        
echo $this->Html->link('Ajouter',['action'=>'add'],['escape'=>false,"class"=>"btn pull-right btn-rounded hidden-sm-down btn-success m-l-5" ]);
echo $this->Html->link('Export csv', $csvLink, ['escape'=>false,"class"=>"btn btn-rounded btn-success pull-right m-l-5"]);
echo $this->Html->link('Vue synthétique',['controller' => 'LotProduits', 'action' => 'index', $is_event?"stock-event":"stock-composants", $is_destock?'destock':''],['escape'=>false,"class"=>"btn btn-rounded btn-secondary pull-right"]);
echo $this->Html->link('Voir les produits destockés',['controller' => 'LotProduits', 'action' => 'detail', $is_event?"stock-event":"stock-composants", 'destock'],['escape'=>false,"class"=> $is_destock?"hide":"btn btn-rounded btn-secondary pull-right m-r-5"]);
echo $this->Html->link('Voir stock',['controller' => 'LotProduits', 'action' => 'detail', $is_event?"stock-event":"stock-composants"],['escape'=>false,"class"=> $is_destock?"btn btn-rounded btn-secondary pull-right m-r-5":"hide"]);

$this->end();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix">
                    <?php if(count($isFilter)) : ?>
                        <div class="float-right my-auto m-l-5"> Total : <?= $this->Paginator->counter('{{count}}') ?></div>
                    <?php endif; ?>
                    <div class="float-right my-auto "> <?= $is_event?"Valeur du stock à neuf (hors décote) : " : "Valeur du stock :" ?> <?= $this->Number->format($totalHt->sum) ?> € </div>
                </div>
                <hr>
                <div class="form-body">
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                            <div class="row clearfix">
                                <?= $this->Form->hidden('is_event', ['value' => $is_event]); ?>
                                <?= $this->Form->hidden('is_hs', ['value' => $is_destock]); ?>
                                <div class="container-filter d-none col-md-2">
                                    <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                                </div>

                                <div class="container-filter d-none col-md-2">
                                    <?php echo $this->Form->control('type_equipement', ['label' => false ,'options'=>!empty($type_equipements) ? $type_equipements : [], 'value'=> $type_equipement, 'class'=>'form-control selectpicker', 'data-live-search' => true ,'empty'=>'Type d\'équipement'] );?>
                                </div>

                                <div class="container-filter d-none col-md-2">
                                    <?php echo $this->Form->control('marque_equipement', ['label' => false ,'options'=>!empty($marque_equipements) ? $marque_equipements : [], 'value'=> $marque_equipement, 'class'=>'form-control selectpicker', 'data-live-search' => true ,'empty'=>'Marque'] );?>
                                </div>

                                <div class="container-filter d-none col-md-2">
                                    <?php if ($is_destock): ?>
                                        <?php $etat_options = ['Hs' => 'Hs', 'rebus' => 'Rebus'] ?>
                                    <?php else: ?>
                                        <?php $etat_options = ['A réparer' => 'A réparer','Neuf' => 'Neuf','Occasion' => 'Occasion'];?>
                                    <?php endif ?>
                                    <?php echo $this->Form->control('etat', ['label' => false ,'options' => $etat_options, 'value' => $etat,'empty' => 'Etat', 'class'=>'form-control selectpicker', 'data-live-search' => true]); 
                                    ?>
                                </div>

                                <?php if ($is_event) : ?>
                                    <div class="container-filter d-none col-md-2">
                                        <?php echo $this->Form->control('antenne_id', ['label' => false, 'options' => $antennes, 'class'=>'form-control select2', 'empty' => 'Emplacement', 'data-placeholder' => 'Emplacement','style' => 'width:100%', 'value' => $antenne_id]); ?>
                                    </div>   
                                
                                    <div class="container-filter d-none col-md-2">
                                        <?php echo $this->Form->control('type_docs._ids', ['label' => false, 'options' => $univers, 'class'=>'form-control select2', 'data-placeholder' => 'Univers','style' => 'width:100%', 'value' => $univers_ids]); ?>
                                    </div>   
                                <?php endif; ?>

                                <div class="container-filter d-none col-md-2">
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>

                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'LotProduits', 'action' => 'detail', 'is_event' => $is_event],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                </div>

                                <div class="col">
                                    <button type="button" class="btn-show-filter btn btn-default float-right bg-white"><span class="fa fa-ellipsis-v"></span></button>
                                </div>

                            </div>
                        <?php echo $this->Form->end(); ?>
                </div>
                
                <?= $this->Form->create(false, ['url' => ['action' => 'multipleAction'], 'class' => 'multi-actions']); ?>
                    <div class="row bloc-actions d-none">
                        <div class="col-md-3">
                            <?=
                                $this->Form->control('action', [
                                    'options' => [
                                        'type_stock' => "Affecter à un autre stock", 
                                        'date_stock' => "Modifier la date d'entrée au stock",
                                        'type_produit' => "Modifier le type de produit", 
                                        'fournisseur' => "Modifier le fournisseur",
                                        'tarif_achat' => "Modifier le tarif achat", 
                                    ], 
                                    'type' => 'select', 
                                    'label' => false, 
                                    'class' => 'selectpicker', 
                                    'empty' => 'Sélectionner une action'
                                ]); 
                            ?>
                        </div>
                        
                        <div class="col-md-3 type-stock hide">
                            <?= $this->Form->control('is_event', [
                                'label' =>false, 
                                'class'=>'form-control selectpicker', 
                                'options' => ['Composants', 'Event'], 
                                'data-placeholder' => 'Destination',
                                'empty' => 'Destination'
                            ]); 
                            ?>
                        </div>
                        
                        <div class="col-md-3 hide date_stock">
                            <input type="date" name="date_stock" class="form-control" placeholder="dd/mm/yyyy" id="date_stock">
                        </div>
                        
                        <div class="col-md-3 hide fournisseur">
                            <?= $this->Form->control('fournisseur_id', [
                                'label' => false, 
                                'options' => $fournisseurs, 
                                'class'=>'form-control select2', 
                                'empty' => 'Fournisseur', 
                                'data-placeholder' => 'Fournisseur',
                                'style' => 'width:100%'
                            ]); 
                            ?>
                        </div>
                        
                        <div class="col-md-3 hide tarif_achat">
                            <?= $this->Form->control('tarif_achat_ht', ['label' => false, 'class' => 'vertical-spin form-control', 'placeholder' => 'Achat HT', 'type' => 'number']); ?>
                        </div>
                        
                        <div class="modal fade" id="type_produit" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="title">Modifier le type de produit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row-fluid">
                                                <div class="col-md-12">
                                                    <?= $this->Form->control('type_equipement_id', [
                                                        'label' => 'Type Equipement *', 
                                                        'class'=>'form-control select2', 
                                                        'options' => $type_equipements, 
                                                        "empty"=>"Choisir",
                                                        'style' => 'width:100%'
                                                    ]); 
                                                    ?>
                                                </div>
                        
                                                <div class="col-md-12">
                                                    <?= $this->Form->control('equipement_id', 
                                                            ['label' => 'Equipement *', 
                                                            'options' => [],
                                                            'empty'=>'Séléctionner',
                                                            'data-placeholder'=>'Equipement', 
                                                            'class'=>'form-control select2', 
                                                            'style' => 'width:100%'
                                                        ]); 
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                                            <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit-type-produit','escape' => false]) ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <?= $this->Form->submit('Valider', ['class' => 'btn btn-primary submit-pultiple']); ?>
                        </div>
                    </div>
                    <div class="clearfix pb-2">
                        <a href="javascript:void(0);" class="active-col-checkbox float-right">Sélectionner des éléments</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table liste-items">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Equipements.valeur', 'Equipement') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('MarqueEquipements.marque', 'Marque') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('TypeEquipements.nom', 'Type équipement') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Fournisseurs.nom', 'Fournisseur') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Users.nom', 'Ajouté par') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('serial_nb', 'Numéros de série') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('tarif_achat_ht', 'Achat HT') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('date_stock', 'Entrée stock') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('etat', 'Etat') ?></th>
                                    <th scope="col" class="<?= $is_event?:'hide' ?>"> Antenne </th>
                                    <th scope="col" class="<?= $is_event?:'hide' ?>"> Univers </th>
                                    <!--th scope="col">Commentaire</th-->
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lotProduits as $key => $lotProduit): ?>
                            <tr>
                                <td class="col-checkbox d-none"><?= $this->Form->control("lot_produit.$lotProduit->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                <td><?= $lotProduit->equipement->valeur ?></td>
                                <td><?= $lotProduit->equipement->marque_equipement? $lotProduit->equipement->marque_equipement->marque :'-' ?></td>
                                <td><?= $lotProduit->equipement->type_equipement->nom ?></td>
                                <td><?= $lotProduit->fournisseur?$lotProduit->fournisseur->nom:'--' ?></td>
                                <td>
                                    <?php if ($lotProduit->user) : ?>
                                        <img alt="Image" src="<?= $lotProduit->user->url_photo ?>" class="avatar" data-title="<?= $lotProduit->user->full_name ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </td>
                                <td><?php 
                                    $sn_aff = str_replace(",",", ",$lotProduit->serial_nb);
                                    echo $sn_aff; 
                                    ?>
                                </td>
                                <td><?= $lotProduit->tarif_achat_ht?($this->Number->format($lotProduit->tarif_achat_ht, ['after' => ' €'])) : "-" ?></td>
                                <td>
                                    <?php 
                                            $files = '';
                                            if(trim($lotProduit->facture_file_name)){
                                                    $fichiers = explode(',', $lotProduit->facture_file_name);
                                                    foreach ($fichiers as $key => $fichier_item) {
                                                        $path = substr($lotProduit->dossier, 1);
                                                        if(file_exists(WWW_ROOT.$path.'/'.$fichier_item)){
                                                            $files .= '<a target="_blank" href="'. Router::url('/', true). $path.'/'.$fichier_item . '"><i class="mdi mdi-file-document"></i></a>';
                                                        }
                                                    }
                                            }
                                            echo $lotProduit->date_stock . ' ' . $files
                                    ?>
                                </td>

                                <td><?= $lotProduit->etat ?></td>

                                <td class="<?= $is_event?:'hide' ?>"><?= @$lotProduit->antenne->ville_principale ?></td>

                                <td class="<?= $is_event?:'hide' ?>"><?= $lotProduit->get('ListeUnivers') ?></td>

                                <td class="actions">
                                    <?php  echo $this->Html->link('<i class="fa fa-eye text-inverse" style="margin-right:15px"></i>', ['action' => 'view', $lotProduit->id], ["escape"=>false]) ?>
                                    <a href="javascript:void(0);"><i class="mdi mdi-delete text-inverse delete-produit"></i></a>
                                    <input type="hidden" value="<?= $lotProduit->id ?>" id="delete-produit-id">
                                </td>


                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= $this->element('tfoot_pagination') ?>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var equipements = <?= json_encode($equipements); ?>;
</script>