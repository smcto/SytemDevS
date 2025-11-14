<?php use Cake\Routing\Router; ?>

<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'devis/pdf.css?' . time(), ], ['fullBase' => true]) ?>


<?php $this->start('header') ?>
    <div class="header-text">LOCATION ET VENTE DE BORNE PHOTO EN FRANCE ET INTERNATIONAL. </div>
<?php $this->end() ?>
    
<div class="img-fond">
    <img id="image" src= "<?= Router::url('/', true) . 'img/bon-commande.jpg' ?>" style="width: 100%;" />
</div>
<p class="num-devis hide"><b>Bons de commande <?= $bonsCommande->indent ?></b></p>

<main>
<div class="card">
    <div class="eclipse"></div>
    <div class="card-body">
        <table class="table-header">
            <tbody>
                <tr>
                    <td width="13cm"  style="vertical-align: top;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row-fluid">
                                    <div class="bloc-addr">
                                        Sas Konitys <br>
                                        <span id="c-adresse"><?= $preferenceEntity->adress->adresse ?></span> <br>
                                        <span id="c-cp"><?= $preferenceEntity->adress->cp?></span> <span id="c-ville"><?= $preferenceEntity->adress->ville ?></span> <br> <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: top;">
                        <div>
                            <b><span>Bons de commande <?= $bonsCommande->indent ?></span></b><br>
                            <span>En date du: <?= $bonsCommande->created->format('d/m/Y') ?></span><br><br>
                            <span>Date de livraison souhaitée : <?= $bonsCommande->type_date != 3 ? @$type_date[$bonsCommande->type_date] : $bonsCommande->date->format('d/m/Y') ?></span><br><br>
                            <b><span><?=  $bonsCommande->client->full_name ?></span></b><br>
                            <span><?= $bonsCommande->client->client_adresse ?> </span><br>
                            <span><?= $bonsCommande->client->client_adresse_2? $bonsCommande->client->client_adresse_2 . "<br>" : "" ?> </span>
                            <span><?= $bonsCommande->client->client_cp .' '. $bonsCommande->client->client_ville .' '. $bonsCommande->client->client_country ?> </span><br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
                
        <br>
        
        <?php if ($bonsCommande->is_prepa) { $rest = 0; $total = 0 ?>
        
            <table class="pdf-table-0">
                <thead>
                    <tr>
                        <th width="10%">Reference</th>
                        <th width="40%">Description</th>
                        <th width="15%">Qté commandé</th>
                        <th width="10%">Qté à livrer</th>
                        <th width="10%">Rest</th>
                        <th width="25%">Observation</th>
                    </tr>
                </thead>

                <tbody id="sortable" class="default-data">
                    <?php if($bonsCommande->bons_commandes_produits) : ?>
                        <?php foreach ($bonsCommande->bons_commandes_produits as $key => $ligne) : 
                                    $total += $ligne->quantite;
                                    $rest += $ligne->rest ? $ligne->rest : 0;
                        ?>
                            <tr>
                                <td>  <?= $ligne->reference ?></td>
                                <td> <div class="break-inside"> <?= $ligne->description_commercial ?></div></td>
                                <td class="text-center">  <?= $ligne->quantite ?></td>
                                <td class="text-center">  <?= $ligne->quantite_livree ?></td>
                                <td class="text-center">  <?= $ligne->rest ?></td>
                                <td class="text-center">  <?= $ligne->observation ?></td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else : ?>
                        <tr><td colspan="6" class="text-center first-tr py-5">Aucune ligne</td></tr>
                    <?php endif; ?>
                </tbody>
            </table> 
        
        <?php } else { ?>
        
            <table class="pdf-table-0">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Nom</th>
                        <th>Qté</th>
                    </tr>
                </thead>

                <tbody id="sortable" class="default-data">
                    <?php if($bonsCommande->bons_commandes_produits) : ?>
                        <?php foreach ($bonsCommande->bons_commandes_produits as $key => $ligne) : ?>

                                <tr>
                                    <td><?= $ligne->reference ?></td>
                                    <td><?= $ligne->nom ?></td>
                                    <td><?= $ligne->quantite ?></td>
                                </tr>

                        <?php endforeach; ?>

                    <?php else : ?>
                        <tr><td colspan="3" class="text-center first-tr py-5">Aucune ligne</td></tr>
                    <?php endif; ?>
                </tbody>
            </table> 
        <?php } ?>
    </div>
</div>
</main>
