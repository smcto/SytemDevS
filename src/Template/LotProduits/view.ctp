<?php
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LotProduit $lotProduit
 */
?>


<?= $this->Html->css('table-uniforme.css?'.  time(), ['block' => true]) ?>

<?php

$this->assign('title', 'Fiche stock ' . $lotProduit->equipement->type_equipement->nom . ' ' . $lotProduit->equipement->valeur) ;

$titrePage = "Informations produit" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Stock',
    ['controller' => 'LotProduits', 'action' => 'detail']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);

$this->end();

$serial_nb_aff = str_replace(",",", ",$lotProduit->serial_nb);


?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
                <div class="card-header hide">
                    <h4 class="m-b-0 text-white">INFORMATIONS</h4>
                </div>
        <div class="card-body">
                <h4 class="control-label col-md-10"> <b>Détail produit</b></h4>
                <div class="col-md-10"></div>
                <div class="form-group row" style="margin: 15px;">
                    <table class="table table-uniforme table-bordered">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Stock pour</td>
                                    <td><?= $lotProduit->is_event ? 'Event' : 'Composant' ?></td>
                                </tr>
                                <tr>
                                    <td>Date d'achat</td>
                                    <td><?= h($lotProduit->date_facture) ?></td>
                                </tr>
                                <tr>
                                    <td>Date d'entrée en stock </td>
                                    <td><?= h($lotProduit->date_stock) ?></td>
                                </tr>
                                <tr>
                                    <td>Ajouté par </td>
                                    <td><?= $lotProduit->has('user') ? $lotProduit->user->full_name : '' ?></td>
                                </tr>
                                <tr>
                                    <td>Type de produit </td>
                                    <td><?= $lotProduit->equipement->type_equipement->nom ?> </td>
                                </tr>
                                <tr>
                                    <td>Produit </td>
                                    <td><?= $lotProduit->has('equipement') ? $lotProduit->equipement->valeur: '' ?> </td>
                                </tr>
                                <tr>
                                    <td>Fournisseur </td>
                                    <td><?= $lotProduit->has('fournisseur') ? $lotProduit->fournisseur->nom : '' ?> </td>
                                </tr>
                                <tr>
                                    <td>Numéros de série </td>
                                    <td><?php
                                            foreach ($serialquery as $sn) {
                                                if(!empty($sn->borne_id)){
                                                    $borne_sbject = TableRegistry::getTableLocator()->get('Bornes');
                                                    $borne_query = $borne_sbject
                                                        ->find()
                                                        ->select(['id','numero'])
                                                        ->where(['id' => $sn->borne_id]);
                                                    $affect = '';
                                                    foreach ($borne_query as $borne) {
                                                        $affect .= $borne->numero;
                                                    }
                                                    echo $sn->serial_nb.' > '.$this->Html->link(' Affecté à la borne N° '.$affect,['controller' => 'Bornes', 'action' => 'view',$sn->borne_id],['escape'=>false]).'<br/>';
                                                }else{
                                                    echo $sn->serial_nb.'<br/> ';
                                                }
                                            }
                                        ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>Achat HT </td>
                                    <td><?= $lotProduit->tarif_achat_ht?$this->Number->format($lotProduit->tarif_achat_ht,['after' => ' €']) : "-" ?> <?= $lotProduit->tarif_approximatif? "(tarif approximatif)":"" ?></td>
                                </tr>
                                <tr>
                                    <td>Etat </td>
                                    <td> <?= h($lotProduit->etat) ?> </td>
                                </tr>
                                <tr class="<?= $lotProduit->is_event?:'hide' ?>">
                                    <td>Antenne </td>
                                    <td> <?= @$lotProduit->antenne->ville_principale ?> </td>
                                </tr>
                                <tr  class="<?= $lotProduit->is_event?:'hide' ?>">
                                    <td>Univers </td>
                                    <td> <?= $lotProduit->get('ListeUnivers') ?> </td>
                                </tr>
                                
                            </tbody>
                        </table>
                </div>
                
                <?= $this->Html->link('Modifier',['controller' => 'LotProduits', 'action' => 'edit',$lotProduit->id],['escape'=>false,"class"=>"btn btn-rounded btn-success pull-right" ,"style" => "margin-right: 15px;"]),' '; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                
                <?php if(trim($lotProduit->facture_file_name)) : ?>
                    <h4 class="control-label col-md-10"> <b>Facture</b></h4>
                    <div class="col-md-10"></div>

                    <div class="form-group row" style="margin: 15px;">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Numéro de facture </td>
                                        <td><?= h($lotProduit->numero_facture) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Facture(s) liée(s) </td>
                                        <td>
                                            <?php
                                                $facture_buffer = '';
                                                if(trim($lotProduit->facture_file_name)){
                                                    $fichiers = explode(',', $lotProduit->facture_file_name);
                                                    $i = 0;
                                                    foreach ($fichiers as $key => $fichier_item) {
                                                        $i += 1;
                                                        $path = substr($lotProduit->dossier, 1);
                                                        if(file_exists(WWW_ROOT.$path.'/'.$fichier_item)){
                                                            $facture_buffer .= '> <a target="_blank" href="'.Router::url('/', true).$lotProduit->dossier.'/'.$fichier_item.'">Facture'.$i.'</a><br>';
                                                        }
                                                    }
                                                    echo $facture_buffer;
                                                }
                                            ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">Produits liées à la facture </td>
                                        <td><?php
                                                    if($facture_buffer) {
                                                        foreach ($query as $produit) {
                                                            if($produit->id != $lotProduit->id){
                                                                $nomEquipement = TableRegistry::getTableLocator()->get('Equipements')
                                                                    ->find()
                                                                    ->select(['id', 'valeur'])
                                                                    ->where(['id' => $produit->equipement_id]);
                                                                foreach ($nomEquipement as $equipm) {    
                                                                    echo '> '.$this->Html->link($equipm->valeur.' (NS: '.$produit->serial_nb.')',['controller' => 'LotProduits', 'action' => 'view',$produit->id],['escape'=>false]).'<br>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?> 
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                    </div>
                <?php elseif(!empty($query->toArray()) && count($query->toArray()) > 1) : ?>
                    
                    <h4 class="control-label col-md-10"> <b>Lot de produit : </b></h4>
                    <div class="col-md-10"></div>

                    <div class="form-group" style="margin: 15px;">

                        <?php
                            foreach ($query as $produit) {
                                if($produit->id != $lotProduit->id){
                                    $nomEquipement = TableRegistry::getTableLocator()->get('Equipements')
                                        ->find()
                                        ->select(['id', 'valeur'])
                                        ->where(['id' => $produit->equipement_id]);
                                    foreach ($nomEquipement as $equipm) {    
                                        echo '> '.$this->Html->link($equipm->valeur.' (NS: '.$produit->serial_nb.')',['controller' => 'LotProduits', 'action' => 'view',$produit->id],['escape'=>false]). '<br>';
                                    }
                                }
                            }
                        ?> 
                    </div>
                <?php else : ?>
                    <h4 class="control-label col-md-10"> <b>Facture</b></h4>
                    <div class="col-md-10"></div>

                    <div class="form-group row" style="margin: 15px;">
                    Aucune facture liée
                    </div>
                <?php endif; ?>
            
            </div>
        </div>
    
    <?php if (!empty($lotProduit->equipement->equipements_documents)){ ?>
    
        <div class="card">
            <div class="card-body">
                <h4 class="control-label col-md-10"> <b>Document </b></h4>
                                    
                <div class="form-group row" style="margin: 15px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="25%" class="p-0"> Titre </th>
                                <th width="25%" class="p-0"> Description </th>
                                <th width="50%" class="p-0">Ficher </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($lotProduit->equipement->equipements_documents as $key => $document){ ?>
                                <tr>
                                    <td> <?= $document->titre ?></td>
                                    <td> <?= $document->description ?> </td>
                                    <td>
                                        <img src="<?= $document->url ?>" width="150px">
                                        <br>
                                        <?= $this->Html->link('Visualiser', $document->url,['escape' => false,"class"=>"", 'target'=>'_blank']) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
