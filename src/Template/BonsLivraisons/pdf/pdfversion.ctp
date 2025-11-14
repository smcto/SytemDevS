<?php use Cake\Routing\Router; ?>

<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'devis/pdf.css?' . time()], ['fullBase' => true]) ?>


<?php $this->start('header') ?>
    <div class="header-text"></div>
<?php $this->end() ?>

<?php $this->start('footer') ?>
    <div class="footer-text"></div>
<?php $this->end() ?>
    
<?php  
$total = 0;
$rest = 0;
?>
    
    
<div class="img-fond">
    <img id="image" src= "<?= Router::url('/', true) . 'img/bon-commande.jpg' ?>" style="width: 100%;" />
</div>
<p class="num-devis"><b>Bons de livraison <?= $blEntity->indent ?></b></p>

<main>
<div class="card">
    <div class="eclipse"></div>
    <div class="card-body">
        <table class="table-header">
            <tbody>
                <tr>
                    <td width="13cm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row-fluid">
                                    <div class="bloc-addr">
                                        Sas Konitys <br>
                                        <span id="c-adresse"><?= $preferenceEntity->adress->adresse ?></span> <br>
                                        <span id="c-cp"><?= $preferenceEntity->adress->cp?></span> <span id="c-ville"><?= $preferenceEntity->adress->ville ?></span> <br> <br>
                                        <b>Votre contact : <span id="full_name"><?= $currentUser->get('full_name') ?></span></b>
                                    </div>

                                    <div class="infos row-fluid">
                                        <?php if(empty($currentUser->telephone_portable)) : ?>
                                            <span class="text-grey"></span>
                                        <?php else : ?>
                                            <span class="text-grey"> Tel : </span> <span id="telephone_fixe"><?= $currentUser->telephone_portable ?></span> <br>
                                        <?php endif; ?>
                                        <?php if($currentUser->email == '') : ?>
                                            <span class="text-grey"></span>
                                        <?php else : ?>
                                            <span class="text-grey"> Email : </span><span id="email"><?= $currentUser->email ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: top;">
                        <div>
                            <b><span>Bons de livraisons <?= $blEntity->indent ?></span></b><br>
                            <span>En date du: <?= $blEntity->date_depart_atelier ? $blEntity->date_depart_atelier->format('d/m/Y') : "" ?></span><br><br>
                            <b><span><?=  $blEntity->client->full_name ?></span></b><br>
                            <!--span class="client_contact">
                                <?php if ($blEntity->devis_client_contact) : ?>
                                À l'attention de <b><?= $blEntity->devis_client_contact->civilite ?> <?= $blEntity->devis_client_contact->full_name ?></b><br>
                                <?php endif; ?>
                            </span>
                            <span><?= $blEntity->client->adresse ?> </span><br>
                            <span><?= $blEntity->client->adresse_2? $blEntity->client->adresse_2 . "<br>" : "" ?> </span>
                            <span><?= $blEntity->client->cp .' '. $blEntity->client->ville .' '. $blEntity->client->country ?> </span><br!-->
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        
        
        <br>
        
        <table class="pdf-table-0">
            <thead>
                <tr>
                    <th width="10%">Reference</th>
                    <th width="55%">Description</th>
                    <th width="15%">Qté commandé</th>
                    <th width="10%">Qté à livrer</th>
                    <th width="10%">Restant à expédier</th>
                </tr>
            </thead>

            <tbody id="sortable" class="default-data">
                <?php if($blEntity->bons_livraisons_produits) : ?>
                    <?php foreach ($blEntity->bons_livraisons_produits as $key => $ligne) : 
                                $total += $ligne->quantite;
                                $rest += $ligne->rest ? $ligne->rest : 0;
                    ?>
                        <tr>
                            <td>  <?= $ligne->reference ?></td>
                            <td> <div class="break-inside"> <?= $ligne->description_commercial ?></div></td>
                            <td class="text-center">  <?= $ligne->quantite ?></td>
                            <td class="text-center">  <?= $ligne->quantite_livree ?></td>
                            <td class="text-center">  <?= $ligne->rest ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr><td colspan="6" class="text-center first-tr py-5">Aucune ligne</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <!-- <p style="page-break-before: always;"></p> -->
        <div class="auto-break">
            <table class="table-note-total">
                <tbody>
                    <tr style="vertical-align: top">
                        <td width="10cm">
                            <table class="pdf-table-1 text-right space-5">
                                <thead>
                                    <tr>
                                        <th width="60%"></th>
                                        <th width="18%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Nombre de palette(s) :</td>
                                        <td class="text-right">
                                            <?= $blEntity->nombre_palettes ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre de carton(s) :</td>
                                        <td class="text-right">
                                            <?= $blEntity->nombre_cartons ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Poids :</td>
                                        <td class="text-right total-after-remise">
                                            <?= $blEntity->poids ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="pdf-table-1 text-right space-5">
                                <thead>
                                    <tr>
                                        <th width="60%"></th>
                                        <th width="18%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total commandé :</td>
                                        <td class="text-right">
                                            <?= $total ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total livré :</td>
                                        <td class="text-right">
                                            <?= $total - $rest  ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rest à livré :</td>
                                        <td class="text-right total-after-remise">
                                            <?= $rest ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
    </div>
</div>
</main>
