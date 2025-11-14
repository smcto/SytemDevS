<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'devisFactures/pdf.css?' . time(), ], ['fullBase' => true]) ?>

<?php $this->start('header') ?>
    <div class="header-text-facture"> Konitys - Avoir <?=  $avoirsEntity->indent ?></div>
<?php $this->end() ?>
    
<div class="img-fond-facture">
    <img id="image" src= "<?= $this->Url->build('/img/factures/facture-konitys-fond.jpg', true) ?>" alt="img/devis/devis-selfizee-fond.jpg" style="width: 93%;" />
</div> 
    
    
<main>
<div class="card">
    <div class="indent">
        <b><span>AVOIR <?=  $avoirsEntity->indent ?></span></b><br>
        <span>En date du: <?= $avoirsEntity->date_crea ? $avoirsEntity->date_crea->format('d/m/Y') : "" ?></span><br><br>
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
                                        <span id="c-adresse"><?= $avoirsPreferenceEntity->adress->adresse ?></span> <br>
                                        <span id="c-cp"><?= $avoirsPreferenceEntity->adress->cp?></span> <span id="c-ville"><?= $avoirsPreferenceEntity->adress->ville ?></span> <br> <br>
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
                            <b><span><?=  $avoirsEntity->client_nom ?></span></b><br>
                            <span class="client_contact">
                                <?php if ($avoirsEntity->avoir_client_contact) : ?>
                                À l'attention de <b><?= $avoirsEntity->avoir_client_contact->civilite ?> <?= $avoirsEntity->avoir_client_contact->full_name ?></b><br>
                                <?php endif; ?>
                            </span>
                            <span><?= $avoirsEntity->client_adresse ?> </span><br>
                            <span><?= $avoirsEntity->client_adresse_2? $avoirsEntity->client_adresse_2 . "<br>" : "" ?> </span>
                            <span><?= $avoirsEntity->client_cp .' '. $avoirsEntity->client_ville .' '. $avoirsEntity->client_country ?> </span><br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        
        <div class="objet"><?= @$avoirsEntity->get('ObjetToPdf') ?> </div>
        
        <br>
        
        <table class="pdf-table-0">
            <thead>
                <tr>
                    <th width="60%" class="<?= @$colVisibilityParams->descr ? 'hide' : '' ?>">Description</th>
                    <th width="5%" class="<?= @$colVisibilityParams->qty ? 'hide' : '' ?>">Qté</th>
                    <th width="10%" class="<?= @$colVisibilityParams->remise ? 'hide' : '' ?>">Remise</th>
                    <th width="10%" class="<?= @$colVisibilityParams->prix_unit_ht ? 'hide' : '' ?>">PU HT</th>
                    <th width="10%" class="<?= @$colVisibilityParams->tva ? 'hide' : '' ?>">TVA</th>
                    <th width="10%"  class="text-right <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">Total HT</th>
                    <th width="10%"  class="text-right <?= @$colVisibilityParams->montant_ttc ? 'hide' : '' ?>">Total TTC</th>
                </tr>
            </thead>

            <?php $has_option = 0 ?>
            <tbody id="sortable" class="default-data">
                <?php if($avoirsEntity->avoirs_produits) : ?>
                    <?php foreach ($avoirsEntity->avoirs_produits as $key => $ligne) : ?>

                        <?php if($ligne->line_option) {$has_option = 1;} ?>
                        <?php if($ligne->type_ligne == 'produit') : ?>
                            <tr class="<?= $ligne->line_option?'ligne-option':'' ?>">

                                <td class="p-l-5<?= @$colVisibilityParams->descr ? 'hide' : '' ?>"><?= $ligne->description_commercial ?></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->qty ? 'hide' : '' ?>">
                                    <?= $this->Utilities->formatNumber($ligne->quantite_usuelle?:1) ?></td>
                                <td  class="p-l-5 remise text-right <?= @$colVisibilityParams->remise?'hide':'' ?>">
                                     <?php 
                                     $montant = $ligne->prix_reference_ht * $ligne->quantite_usuelle;
                                     $remiseValue = 0;
                                     if($ligne->remise_value) {
                                         if ($ligne->remise_unity != '%') {
                                             $remiseValue = $ligne->remise_value;   
                                             echo $this->Utilities->formatCurencyPdf($remiseValue, ['after' => $ligne->remise_unity]);
                                         } else {
                                             $remiseValue = $ligne->prix_reference_ht * $ligne->remise_value / 100;
                                             echo $this->Utilities->formatCurencyPdf($remiseValue);
                                             echo '<br><i>' . $this->Utilities->formatCurencyPdf($ligne->remise_value, ['after' => $ligne->remise_unity]);
                                         } 
                                     } 
                                    ?></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->prix_unit_ht ? 'hide' : '' ?>">
                                    <?php if($remiseValue) : ?>
                                        <del><?= $this->Utilities->formatCurencyPdf($ligne->prix_reference_ht?:0) ?></del><br>
                                        <?= $this->Utilities->formatCurencyPdf($ligne->prix_reference_ht - $remiseValue) ?><br>
                                        <i><?= $ligne->catalog_unites_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php else : ?>
                                        <?= $this->Utilities->formatCurencyPdf($ligne->prix_reference_ht?:0) ?><br>
                                        <i><?= $ligne->catalog_unites_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php endif; ?>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->tva ? 'hide' : '' ?>">
                                    20%<br>
                                    <i>(<?= $this->Utilities->formatCurencyPdf($montant * 0.2) ?>)</i>
                                </td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">
                                    <?php 
                                    if($avoirsEntity->remise_line && $ligne->remise_value) {
                                        if($ligne->remise_unity == '%') {
                                            $montant -= $montant * $ligne->remise_value / 100;
                                        } else {
                                            $montant-= $ligne->remise_value;
                                        }
                                    } 
                                    
                                    echo $this->Utilities->formatCurencyPdf($montant);
                                    if($ligne->line_option) { echo '<br>En option'; }
                                    ?></td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ttc ? 'hide' : '' ?>">
                                    <?php 
                                    if($avoirsEntity->remise_line && $ligne->remise_value) {
                                        if($ligne->remise_unity == '%') {
                                            $montant -= $montant * $ligne->remise_value / 100;
                                        } else {
                                            $montant-= $ligne->remise_value;
                                        }
                                    }
                                    
                                    echo $this->Utilities->formatCurencyPdf($montant * 1.2);
                                    if($ligne->line_option) { echo '<br>En option'; }
                                    ?></td>
                            </tr>
                        <?php endif; ?>
                            
                            
                        <?php if($ligne->type_ligne == 'abonnement') : ?>
                            <tr class="<?= $ligne->line_option?'ligne-option':'' ?>">

                                <td class="p-l-5<?= @$colVisibilityParams->descr ? 'hide' : '' ?>"><?= $ligne->description_commercial ?></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->qty ? 'hide' : '' ?>">
                                    <?= $this->Utilities->formatNumber($ligne->quantite_client?:1) ?></td>
                                <td  class="p-l-5 remise text-right <?= @$colVisibilityParams->remise?'hide':'' ?>">
                                     <?php 
                                     $montant = $ligne->tarif_client * $ligne->quantite_client;
                                     $remiseValue = 0;
                                     if($ligne->remise_value) {
                                         if ($ligne->remise_unity != '%') {
                                             $remiseValue = $ligne->remise_value;   
                                             echo $this->Utilities->formatCurencyPdf($remiseValue, ['after' => $ligne->remise_unity]);
                                         } else {
                                             $remiseValue = $ligne->tarif_client * $ligne->remise_value / 100;
                                             echo $this->Utilities->formatCurencyPdf($remiseValue);
                                             echo '<br><i>' . $this->Utilities->formatCurencyPdf($ligne->remise_value, ['after' => $ligne->remise_unity]);
                                         } 
                                     } 
                                    ?></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->prix_unit_ht ? 'hide' : '' ?>">
                                    <?php if($remiseValue) : ?>
                                        <del><?= $this->Utilities->formatCurencyPdf($ligne->tarif_client?:0) ?></del><br>
                                        <?= $this->Utilities->formatCurencyPdf($ligne->tarif_client - $remiseValue) ?><br>
                                        <i><?= $ligne->unites_client_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php else : ?>
                                        <?= $this->Utilities->formatCurencyPdf($ligne->tarif_client?:0) ?><br>
                                        <i><?= $ligne->unites_client_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php endif; ?>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->tva ? 'hide' : '' ?>">
                                    20%<br>
                                    <i>(<?= $this->Utilities->formatCurencyPdf($montant * 0.2) ?>)</i>
                                </td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">
                                    <?php 
                                    if($avoirsEntity->remise_line && $ligne->remise_value) {
                                        if($ligne->remise_unity == '%') {
                                            $montant -= $montant * $ligne->remise_value / 100;
                                        } else {
                                            $montant-= $ligne->remise_value;
                                        }
                                    } 
                                    
                                    echo $this->Utilities->formatCurencyPdf($montant);
                                    if($ligne->line_option) { echo '<br>En option'; }
                                    ?></td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ttc ? 'hide' : '' ?>">
                                    <?php 
                                    if($avoirsEntity->remise_line && $ligne->remise_value) {
                                        if($ligne->remise_unity == '%') {
                                            $montant -= $montant * $ligne->remise_value / 100;
                                        } else {
                                            $montant-= $ligne->remise_value;
                                        }
                                    }
                                    
                                    echo $this->Utilities->formatCurencyPdf($montant * 1.2);
                                    if($ligne->line_option) { echo '<br>En option'; }
                                    ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'sous_total') : ?>
                            <tr>
                                <td colspan="<?= 6 - $thHidev ?>">
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
                                <td colspan="<?= 7 - $thHidev ?>" class="titre">
                                    <?= $ligne->titre_ligne ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'commentaire') : ?>
                            <tr class="clone-commentaire added-tr">
                                <td colspan="<?= 7 - $thHidev ?>" class="p-0 p-l-5">
                                    <?= $ligne->commentaire_ligne ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'saut_ligne') : ?>
                            <tr>
                                <td colspan="<?= 7 - $thHidev ?>" class="bg-light saut-ligne">
                                    
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php if($ligne->type_ligne == 'saut_page') : ?>
                            <tr>
                                <td colspan="<?= 7 - $thHidev ?>" class="bg-light saut-page">
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
                            <?php if($avoirsEntity->note) : ?>
                                <div class="note">
                                    <p>Note : </p> <?= $avoirsEntity->note ?>
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
                                            <?= $avoirsEntity->total_ht_client? $this->Utilities->formatCurencyPdf($avoirsEntity->total_ht_client) : $this->Utilities->formatCurencyPdf($avoirsEntity->total_ht?:0) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <?php if($avoirsEntity->total_reduction) : ?>
                                        <tr>
                                            <td>
                                                Réduction HT
                                            </td>
                                            <td class="text-right remise-global-ht">
                                                <?= $avoirsEntity->total_reduction_client? $this->Utilities->formatCurencyPdf($avoirsEntity->total_reduction_client): $this->Utilities->formatCurencyPdf($avoirsEntity->total_reduction) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>Total HT après réduction</td>
                                            <td class="text-right total-after-remise">
                                                <?= $avoirsEntity->total_remise_client? $this->Utilities->formatCurencyPdf($avoirsEntity->total_remise_client) :$this->Utilities->formatCurencyPdf($avoirsEntity->total_remise) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                    <?php endif ?>
                                    <tr class="<?= @$colVisibilityParams->tva ? "hide":"" ?>">
                                        <td>TVA 20%</td>
                                        <td class="text-right total_general_tva">
                                            <?= $avoirsEntity->total_tva_client? $this->Utilities->formatCurencyPdf($avoirsEntity->total_tva_client): $this->Utilities->formatCurencyPdf($avoirsEntity->total_tva) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td>Montant total TTC</td>
                                        <td class="text-right total_general_ttc">
                                            <?= $avoirsEntity->total_ttc_client? $this->Utilities->formatCurencyPdf($avoirsEntity->total_ttc_client): $this->Utilities->formatCurencyPdf($avoirsEntity->total_ttc) ?>
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

            <?php if($avoirsEntity->devis_facture) : $total_facture = 0;?>
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

                                <?php $total_facture += $avoirsEntity->devis_facture->total_ttc ?>
                                <tr  class="text-right noborder">
                                    <td  width="70%">
                                        Montant déduit sur facture du <br>
                                        <?= $avoirsEntity->devis_facture->date_crea?$avoirsEntity->devis_facture->date_crea->format('d/m/Y'):"--" ?><br>
                                        <?= $avoirsEntity->devis_facture->indent ?>
                                    </td>
                                    <td><?= $avoirsEntity->devis_facture->total_ttc ?> €</td>
                                    <td width="5%"> </td>
                                </tr>
                                <tr class="text-right">
                                    <td> <b>Total à solder</b></td>
                                    <td> <b>
                                    <?php 
                                    $rest = $avoirsEntity->total_ttc - $total_facture;
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
        <!-- <p style="page-break-before: always;"></p> -->
         <br><br>
         <div class="auto-break">
            <table class="pdf-table-2 space-5">
                <thead>
                    <tr>
                        <th width="120px"></th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                     <tr class="moyen-regl">
                        <td><span class="text-grey"> Moyen de réglement : </span></td>
                        <td>
                            <span id="moye_regl" class="innfo-regl">
                                <?php foreach ($avoirsEntity->get('MoyenReglementsAsArray') as $moyen) : ?>
                                    <?= @$moyen_reglements[$moyen] ?><br>
                                <?php endforeach; ?>
                            </span>
                        </td>
                    </tr>

                    <?php if($avoirsEntity->accompte_value != '') : ?>
                        <tr>
                           <td><span class="text-grey"> Acompte : </span></td>
                           <td> <span id="acompte" class="innfo-regl"><?= $avoirsEntity->accompte_value ?> <?= $avoirsEntity->accompte_unity ?></span>
                        </tr>
                        <?php 
                            $accompte = $avoirsEntity->accompte_value;
                            if($avoirsEntity->accompte_unity == '%') : $accompte = $avoirsEntity->total_ttc * $avoirsEntity->accompte_value / 100;
                        ?>
                        
                        <tr>
                           <td></td>
                           <td> <span id="acompte" class="innfo-regl"><?= $accompte ?> €</span>
                        </tr>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($avoirsEntity->delai_reglements != 'echeances') : ?>
                        <tr>
                            <td><span class="text-grey"> <span class="text-grey"> Délai de règlement : </span></td>
                            <td><span id="del_regl" class="innfo-regl"><?= @$delai_reglements[$avoirsEntity->delai_reglements] ?></span></td>
                        </tr>
                    <?php else : ?>
                        <tr class="moyen-regl hide">
                            <td><span class="text-grey"> <span class="text-grey"> Délai de règlement : </span></td>
                            <td>
                                <?php if($avoirsEntity->echeance_date) : ?>
                                    <?php foreach ($avoirsEntity->echeance_date as $key => $echeance_date) : ?>
                                        <?php $date = new DateTime($echeance_date); ?>
                                        <?= $date->format('d/m/Y') ?> : <?= $this->Utilities->formatCurencyPdf($avoirsEntity->echeance_value[$key], ['after' => ' €']) ?> <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($avoirsEntity->display_virement && $avoirsEntity->infos_bancaire): ?>
                        <tr class="align-top">
                            <td><span class="text-grey"> <span class="text-grey"> Banque : </span></td>
                            <td>
                                <?= $avoirsEntity->infos_bancaire->adress ?> <br>
                                BIC : <?= $avoirsEntity->infos_bancaire->bic ?> <br>
                                IBAN : <?= $avoirsEntity->infos_bancaire->iban ?>
                            </td>
                        </tr>
                    <?php endif ?>

                    <?php if ($avoirsEntity->display_cheque): ?>
                        <tr class="align-top">
                            <td><span class="text-grey"> <span class="text-grey"> Libellé du chèque : </span></td>
                            <td>KONITYS </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
         </div>
        <br>
        
        <?php if($avoirsEntity->is_text_loi_displayed) : ?>
        <div class="auto-break">
            <div class="condition-paiem"><p><?= $avoirsEntity->text_loi ?></p></div> 
        </div>
        <?php endif ?>
    </div>
</div>
</main>
    
    
<?php $this->start('footer') ?>
    <div class="footer-text-facture"><?=  $footer ?></div>
<?php $this->end() ?>
