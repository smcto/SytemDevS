<?= $this->Html->css('bons/bons-prepa.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>

<?php
$total = 0;
$livre = 0;
$titrePage = "Information - Bons de commandes" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link(__('Modifier') ,['action'=>'edit', $bonsPrepa->id],['escape'=>false,"class"=>"btn pull-right btn-rounded hidden-sm-down btn-success" ]);
if ($bonsPrepa->statut != 'en_attente') {
    echo $this->Form->postLink(__('Générer le Bon de Livraison '), ['controller' => 'BonsLivraisons', 'action'=>'createBlFromBp', $bonsPrepa->id], 
        ['confirm' => $bonsPrepa->statut == 'en_prepa' ? __('Attention, la commande est incomplète, êtes-vous sur de vouloir générer le BL ?') : false,
            'escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-r-5"]);
}

$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                    <div class="row col-6">
                        <label for="" class="col-md-4">Numero BP : </label>
                        <div class="col-md-8"><?= $bonsPrepa->indent ?> </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Date de livraison souhaitée: </label>
                        <div class="col-md-8"><?= @$type_date[$bonsPrepa->type_date] ?> </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Client : </label>
                        <div class="col-md-8">
                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $bonsPrepa->client_id]) ?>"><?= $bonsPrepa->client?$bonsPrepa->client->full_name : '-' ?></a> 
                        </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Commentaire : </label>
                        <div class="col-md-8"><?= $bonsPrepa->commentaire ?> </div>
                    </div>

                    <br>
                    
                    <div class="row col-6">
                        <label for="" class="col-md-4">Date depart atelier : </label>
                        <div class="col-md-8"> <?= $bonsPrepa->date_depart_atelier?$bonsPrepa->date_depart_atelier->format('d-m-Y') : '' ?></div>
                    </div>
                    
                    <br>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Ref </th>
                                <th scope="col" width="40%">Libellé </th>
                                <th scope="col" width="10%">Qté commandé </th>
                                <th scope="col" class="<?= $bonsPrepa->bons_preparation_id ? : 'hide' ?>">Restant à expédier </th>
                                <th scope="col" width="7%">Qté livrée </th>
                                <th scope="col" width="7%" class="hide">Rest </th>
                                <th scope="col">Observation </th>
                                <th scope="col" width="10%">Etat </th>
                            </tr>
                            </thead>
                            <tbody class="default-data">
                            <?php foreach ($bonsPrepa->bons_preparations_produits as $key => $produit): 
                                $total += $produit->quantite;
                                $livre += $produit->quantite_livree + ($produit->quantite - $produit->rest_a_livrer);
                            ?>
                            <tr class="tr-<?=$produit->statut ?>">

                                <td>
                                    <?= $produit->reference ?>
                                </td>
                                <td>
                                    <?= $produit->description_commercial ?>
                                </td>
                                <td class="text-center">
                                    <?= $produit->quantite ?>
                                </td>
                                <td class="text-center <?= $bonsPrepa->bons_preparation_id ? : 'hide' ?>">
                                    <?= $produit->rest_a_livrer ?>
                                </td>
                                <td>
                                    <?= $produit->quantite_livree ?>
                                </td>
                                <td class="text-center hide">
                                    <div><?= is_numeric($produit->rest) ? $produit->rest : $produit->quantite ?></div>
                                </td>
                                <td>
                                    <?= $produit->observation ?>
                                </td>
                                <td>
                                    <div class="status-text <?=$produit->statut ?>"><?= @$statut_ligne[$produit->statut] ?></div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row m-t-40">
                        <div class="col-md-8">
                            
                            <div class="row col-6">
                                <label for="" class="col-md-6">Nombre de palette(s) : </label>
                                <div class="col-md-6"><?= $bonsPrepa->nombre_palettes ?> </div>
                            </div>
                            <div class="row col-6">
                                <label for="" class="col-md-6">Nombre de carton(s) : </label>
                                <div class="col-md-6"><?= $bonsPrepa->nombre_cartons ?> </div>
                            </div>
                            <div class="row col-6">
                                <label for="" class="col-md-6">Poids : </label>
                                <div class="col-md-6"><?= $bonsPrepa->poids ?> </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <table class="table table-uniforme">
                                <thead class="">
                                    <tr class="hide">
                                        <th width="90%"></th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right">Total commandé : </td>
                                        <td class="text-right"><?= $total ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Total livré : </td>
                                        <td class="text-right total_livre"><?= $livre ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Rest à livré : </td>
                                        <td class="text-right rest_livre"><?= $total - $livre ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
