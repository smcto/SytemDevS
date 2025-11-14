<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'devisFactures/pdf.css?' . time(), ], ['fullBase' => true]) ?>

<?php $this->start('header') ?>
    <div class="header-text-facture"> Konitys - Facture <?=  $devisFacturesEntity->indent ?></div>
<?php $this->end() ?>
    
<div class="img-fond-facture">
    <img id="image" src= "img/factures/facture-konitys-fond.jpg" alt="img/devis/devis-selfizee-fond.jpg" style="width: 93%;" />
</div> 
    
    
<main>
<div class="card">
    <div class="indent">
        <b><span>FACTURE <?=  $devisFacturesEntity->indent ?></span></b><br>
        <span>Situation n° <?= $devisFacturesEntity->numero ?></span><br><br>
        <span>En date du: <?= $devisFacturesEntity->date_crea ? $devisFacturesEntity->date_crea->format('d/m/Y') : "" ?></span><br><br>
    </div>
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
                                        <span id="c-adresse"><?= $devisFacturesPreferenceEntity->adress->adresse ?></span> <br>
                                        <span id="c-cp"><?= $devisFacturesPreferenceEntity->adress->cp?></span> <span id="c-ville"><?= $devisFacturesPreferenceEntity->adress->ville ?></span> <br> <br>
                                        <b>Votre contact : <span id="full_name"><?= $currentUser->get('full_name') ?></span></b>
                                    </div>

                                    <div class="infos row-fluid">
                                        <?php if($currentUser->telephone_fixe == '') : ?>
                                            <span class="text-grey"></span>
                                        <?php else : ?>
                                            <span class="text-grey"> Tel : </span> <span id="telephone_fixe"><?= $currentUser->telephone_fixe ?></span> <br>
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
                            <b><span><?=  $devisFacturesEntity->client_nom ?></span></b><br>
                            <span class="client_contact">
                                <?php if ($devisFacturesEntity->facture_client_contact) : ?>
                                À l'attention de <b><?= $devisFacturesEntity->facture_client_contact->civilite ?> <?= $devisFacturesEntity->facture_client_contact->full_name ?></b><br>
                                <?php endif; ?>
                            </span>
                            <span><?= $devisFacturesEntity->client_adresse ?> </span><br>
                            <span><?= $devisFacturesEntity->client_adresse_2? $devisFacturesEntity->client_adresse_2 . "<br>" : "" ?> </span>
                            <span><?= $devisFacturesEntity->client_cp .' '. $devisFacturesEntity->client_ville .' '. $devisFacturesEntity->client_country ?> </span><br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        
        <div class="objet"><?= @$devisFacturesEntity->get('ObjetToPdf') ?> </div>
        
        <br>
        
        <table class="pdf-table-0">
            <thead>
                <tr>
                    <th width="50%" class="<?= @$colVisibilityParams->descr ? 'hide' : '' ?>">Description</th>
                    <th width="10%" class="<?= @$colVisibilityParams->remise ? 'hide' : '' ?>">Remise</th>
                    <th width="10%" class="<?= @$colVisibilityParams->prix_unit_ht ? 'hide' : '' ?>">PU HT</th>
                    <th width="10%">Facturé <br>Prévu</th>
                    <th width="10%">Avancement</th>
                    <th width="10%" class="text-right">TVA</th>
                    <th width="10%"  class="text-right">Total HT</th>
                    <th width="10%"  class="text-right">Total TTC</th>
                </tr>
            </thead>

            <?php $has_option = 0 ?>
            <tbody id="sortable" class="default-data">
                <?php if($devisFacturesEntity->devis_factures_produits) : ?>
                    <?php foreach ($devisFacturesEntity->devis_factures_produits as $key => $ligne) : ?>

                        <?php if($ligne->line_option) {$has_option = 1;} ?>
                        <?php if($ligne->type_ligne == 'produit' || $ligne->type_ligne == 'abonnement') : ?>
                            <tr class="<?= $ligne->line_option?'ligne-option':'' ?>">

                                <td class="p-l-5<?= @$colVisibilityParams->descr ? 'hide' : '' ?>"><?= $ligne->description_commercial ?></td>
                                <td  class="p-l-5 remise text-right <?= @$colVisibilityParams->remise?'hide':'' ?>">
                                     <?php 
                                     $remiseValue = 0;
                                     if($ligne->remise_value) {
                                         if ($ligne->remise_unity != '%') {
                                             $remiseValue = $ligne->remise_value;   
                                             echo $this->Utilities->formatCurencyPdf($remiseValue, ['after' => $ligne->remise_unity]);
                                         } else {
                                             $remiseValue = $ligne->prix_reference_ht * $ligne->remise_value / 100;
                                             echo $this->Utilities->formatCurrency($remiseValue);
                                             echo '<br><i>' . $this->Utilities->formatCurrency($ligne->remise_value, ['after' => $ligne->remise_unity]);
                                         } 
                                     } 
                                    ?></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->prix_unit_ht ? 'hide' : '' ?>">
                                        <?= $this->Utilities->formatCurrency($ligne->prix_reference_ht?:0) ?>
                                </td>
                                
                                <td class="text-right">
                                        <?= $ligne->facture_pourcentage? : 0 ?> % <br>
                                        <?= $this->Utilities->formatCurrency($ligne->facture_euro? : 0) ?> <br>
                                        <?php
                                            $montant = $ligne->prix_reference_ht * $ligne->quantite_usuelle;
                                            if($devisFacturesEntity->remise_line && $ligne->remise_value) {
                                                if($ligne->remise_unity == '%') {
                                                    $montant -= $montant * $ligne->remise_value / 100;
                                                } else {
                                                    $montant-= $ligne->remise_value;
                                                }
                                            } 
                                            ?>
                                        <?= $this->Utilities->formatCurencyPdf($montant) ?> €
                                </td>
                                
                                <td class="text-right">
                                    <?= $ligne->avancement_pourcentage? : 0 ?> % <br>
                                    <?= $ligne->avancement_euro? : 0 ?> € <br>
                                    <?= $ligne->avancement_quantite ?> <?= $ligne->catalog_unite?$ligne->catalog_unite->nom:'Unité(s)' ?> 
                                </td>

                                <td class="text-right"><?= $ligne->tva ?>% </td>
                                            
                                <td class="text-right"><?= $this->Utilities->formatCurrency($ligne->montant_ht ? :0) ?> </td>
                                <td class="text-right"><?= $this->Utilities->formatCurrency($ligne->montant_ttc ? :0) ?> </td>
                            </tr>
                        <?php endif; ?>
                            
                        <?php if($ligne->type_ligne == 'sous_total') : ?>
                            <tr>
                                <td colspan="<?= 8 - $thHidev ?>">
                                    <div class="text-left">Sous-total</div>
                                </td>
                                <td class="bg-light <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">
                                    <div class="text-right"><?= $this->Utilities->formatCurencyPdf($ligne->sous_total) ?></div>
                                </td>
                                <td class="bg-light <?= @$colVisibilityParams->montant_ttc ? 'hide' : '' ?>">
                                    <div class="text-right"><?= $this->Utilities->formatCurencyPdf($ligne->sous_total * 1.2) ?></div>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'titre') : ?>
                            <tr>
                                <td colspan="<?= 9 - $thHidev ?>" class="titre">
                                    <?= $ligne->titre_ligne ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'commentaire') : ?>
                            <tr class="clone-commentaire added-tr">
                                <td colspan="<?= 9 - $thHidev ?>" class="p-0 p-l-5">
                                    <?= $ligne->commentaire_ligne ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'saut_ligne') : ?>
                            <tr>
                                <td colspan="<?= 9 - $thHidev ?>" class="bg-light saut-ligne">
                                    
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'saut_page') : ?>
                            <tr>
                                <td colspan="<?= 9 - $thHidev ?>" class="bg-light saut-page">
                                    <div class="break-after"></div>
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php else : ?>
                    <tr><td colspan="<?= 8 - $thHidev ?>" class="text-center first-tr py-5">Aucune ligne</td></tr>
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
                            <?php if($devisFacturesEntity->note) : ?>
                                <div class="note">
                                    <p>Note : </p> <?= $devisFacturesEntity->note ?>
                                </div>
                            <?php endif ?>
                        </td>
                        <td>
                            <table class="pdf-table-1 text-right space-5">
                                <thead>
                                    <tr>
                                        <th width="60%"></th>
                                        <th width="18%"></th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $has_option? 'Montant total HT (hors options)' :'Montant total HT' ?></td>
                                        <td class="text-right">
                                            <?= $devisFacturesEntity->total_ht_client? $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_ht_client) : $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_ht?:0) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <?php if($devisFacturesEntity->total_reduction) : ?>
                                        <tr>
                                            <td>
                                                Réduction HT
                                            </td>
                                            <td class="text-right remise-global-ht">
                                                <?= $devisFacturesEntity->total_reduction_client? $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_reduction_client): $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_reduction) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>Total HT après réduction</td>
                                            <td class="text-right total-after-remise">
                                                <?= $devisFacturesEntity->total_remise_client? $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_remise_client) :$this->Utilities->formatCurencyPdf($devisFacturesEntity->total_remise) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                    <?php endif ?>
                                    <tr class="<?= @$colVisibilityParams->tva ? "hide":"" ?>">
                                        <td>TVA 20%</td>
                                        <td class="text-right total_general_tva">
                                            <?= $devisFacturesEntity->total_tva_client? $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_tva_client): $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_tva) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td>Montant total TTC</td>
                                        <td class="text-right total_general_ttc">
                                            <?= $devisFacturesEntity->total_ttc_client? $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_ttc_client): $this->Utilities->formatCurencyPdf($devisFacturesEntity->total_ttc) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <br><br>

            <?php if($devisFacturesEntity->facture_reglements || $devisFacturesEntity->avoirs) : $total_reglement = $total_avoir = 0;?>
            <table class="table-note-total">
                <tbody>
                    <tr style="vertical-align: top">
                        <td width="12cm">
                        </td>
                        <td>
                            <table class="table table-uniforme table-reglement">
                                <thead class="hide">
                                    <tr>
                                        <th width="80%"></th>
                                        <th></th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($devisFacturesEntity->facture_reglements as $reglement) : 
                                    $total_reglement += $reglement->montant;
                                    ?>
                                    <tr  class="text-right noborder">
                                        <td  width="70%">
                                            Paiement par <?= $reglement->is_in_sellsy?$reglement->sellsy_moyen_reglement:($reglement->moyen_reglement?$reglement->moyen_reglement->name:"--") ?><br>
                                            du <?= $reglement->date?$reglement->date->format('d/m/Y'):"--" ?><br>
                                            <?= $reglement->reference ?>
                                        </td>
                                        <td><?= $reglement->montant ?> €</td>
                                        <td width="5%"> </td>
                                    </tr>
                                <?php endforeach; ?>
                                    
                                <?php foreach ($devisFacturesEntity->avoirs as $avoir) : 
                                    $total_avoir += $avoir->total_ttc;
                                    ?>
                                    <tr  class="text-right noborder">
                                        <td  width="70%">Avoir du <?= $avoir->date_crea?$avoir->date_crea->format('d/m/Y'):"--" ?><br><?= $avoir->indent ?></td>
                                        <td><?= $avoir->total_ttc ?> €</td>
                                        <td width="5%"> </td>
                                    </tr>
                                <?php endforeach; ?>
                                    
                                <tr class="text-right">
                                    <td> <b>Total à régler</b></td>
                                    <td> <b>
                                    <?php 
                                    $rest = $devisFacturesEntity->total_ttc - $total_reglement - $total_avoir;
                                    $rest = $rest < 0? 0 : $rest;
                                    echo $rest . ' €';
                                    ?> </b>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr><td colspan="3"></td></tr>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
                        
            <?php endif; ?>
        </div>
        <br>        
    </div>
</div>
</main>
    
    
<?php $this->start('footer') ?>
    <div class="footer-text-facture"><?=  $footer ?></div>
<?php $this->end() ?>
