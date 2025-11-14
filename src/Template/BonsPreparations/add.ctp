<?php
/**
 * @var \App\View\AppView $this
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
echo $this->Html->link(__('Voir le pdf') ,['action'=>'pdfversion', $bonsPrepa->id],['escape'=>false,"class"=>"btn pull-right btn-rounded hidden-sm-down btn-success" ]);
echo $this->Html->link(__('Préparer la commande') ,['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-r-5" ]);
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
                
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">REFERENCE </th>
                            <th scope="col">NOM </th>
                            <th scope="col">QUANTITE </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bonsPrepa->bons_commandes_produits as $produit): ?>
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
