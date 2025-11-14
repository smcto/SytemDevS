<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne[]|\Cake\Collection\CollectionInterface $etatBornes
 */
?>

<?php
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
echo $this->Html->link(__('Voir le pdf') ,['action'=>'pdfversion', $bonsCommande->id],['escape'=>false,"class"=>"btn pull-right btn-rounded hidden-sm-down btn-success" ]);
echo $this->Html->link(__('Préparer la commande') , ['action' => 'prepareCommande', $bonsCommande->id], ['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-r-5" ]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row col-6">
                    <label for="" class="col-md-4">Numero BL : </label>
                    <div class="col-md-8"><?= $bonsCommande->indent ?> </div>
                </div>
                
                <div class="row col-6">
                    <label for="" class="col-md-4">Date de livraison souhaitée: </label>
                    <div class="col-md-8"><?= @$type_date[$bonsCommande->type_date] ?> </div>
                </div>
                
                <div class="row col-6">
                    <label for="" class="col-md-4">Client : </label>
                    <div class="col-md-8">
                        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $bonsCommande->client_id]) ?>"><?= $bonsCommande->client?$bonsCommande->client->full_name : '-' ?></a> 
                    </div>
                </div>
                
                <div class="row col-6">
                    <label for="" class="col-md-4">Devis : </label>
                    <div class="col-md-8">
                        <a href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $bonsCommande->devi_id]) ?>"><?= $bonsCommande->devi?$bonsCommande->devi->indent : '-' ?></a> 
                    </div>
                </div>
                
                <div class="row col-6">
                    <label for="" class="col-md-4">Commentaire : </label>
                    <div class="col-md-8"><?= $bonsCommande->commentaire ?> </div>
                </div>
                
                <br>
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Ref </th>
                            <th scope="col">Nom </th>
                            <th scope="col">Quantité </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bonsCommande->bons_commandes_produits as $produit): ?>
                        <tr>

                            <td><?= $produit->reference ?></td>
                            <td><?= $produit->nom ?></td>
                            <td><?= $produit->quantite ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
