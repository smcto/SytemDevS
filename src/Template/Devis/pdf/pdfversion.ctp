<?php use Cake\Routing\Router; ?>

<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'devis/pdf.css?' . time(), ], ['fullBase' => true]) ?>


<?php $this->start('header') ?>
    <div class="header-text"><?= $header ?></div>
<?php $this->end() ?>

<?php $this->start('footer') ?>
    <div class="footer-text"><?= $footer ?></div>
<?php $this->end() ?>
    
    
<div class="img-fond">
    <img id="image" src= "<?= Router::url('/', true) . $fond ?>" style="width: 100%;" />
</div>
<p class="num-devis"><b><?= $prefixNum . ' ' . $devisEntity->indent ?></b></p>

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
                                        <span id="c-adresse"><?= $devisPreferenceEntity->adress->adresse ?></span> <br>
                                        <span id="c-cp"><?= $devisPreferenceEntity->adress->cp?></span> <span id="c-ville"><?= $devisPreferenceEntity->adress->ville ?></span> <br> <br>
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
                            <b><span><?=  $prefixNum . ' ' . $devisEntity->indent ?></span></b><br>
                            <span>En date du: <?= $devisEntity->date_crea ? $devisEntity->date_crea->format('d/m/Y') : "" ?></span><br><br>
                            <b><span><?=  $devisEntity->client->name_to_pdf ?></span></b><br>
                            <span class="client_contact">
                                <?php if ($devisEntity->devis_client_contact) : ?>
                                À l'attention de <b><?= $devisEntity->devis_client_contact->civilite ?> <?= $devisEntity->devis_client_contact->full_name ?></b><br>
                                <?php endif; ?>
                            </span>
                            <span><?= $devisEntity->client->adresse ?> </span><br>
                            <span><?= $devisEntity->client->adresse_2? $devisEntity->client->adresse_2 . "<br>" : "" ?> </span>
                            <span><?= $devisEntity->client->cp .' '. $devisEntity->client->ville .' '. $devisEntity->client->country ?> </span><br>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        
        <div class="objet">Objet : <?= $devisEntity->get('ObjetToPdf') ?> </div>
        
        <br>
        
        <table class="pdf-table-0">
            <thead>
                <tr>
                    <th width="55%" class="<?= @$colVisibilityParams->descr ? 'hide' : '' ?>">Description</th>
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
                <?php if($devisEntity->devis_produits) : ?>
                    <?php foreach ($devisEntity->devis_produits as $key => $ligne) : ?>

                        <?php if($ligne->line_option) {$has_option = 1;} ?>
                        <?php if($ligne->type_ligne == 'produit') { ?>
                            <tr class="<?= $ligne->line_option?'ligne-option':'' ?>">
                                
                                <td class="p-l-5<?= @$colVisibilityParams->descr ? 'hide' : '' ?>"><div class="break-inside"><?= $ligne->description_commercial ?></div></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->qty ? 'hide' : '' ?>">
                                    <?= $this->Utilities->formatNumber($ligne->quantite_usuelle?:1) ?></td>
                                <td  class="p-l-5 remise text-right <?= @$colVisibilityParams->remise?'hide':'' ?>">
                                     <?php 
                                     $montant = $ligne->prix_reference_ht * $ligne->quantite_usuelle;
                                     $remiseValue = 0;
                                     if($ligne->remise_value) {
                                         if ($ligne->remise_unity != '%') {
                                             $remiseValue = $ligne->remise_value / $ligne->quantite_usuelle;   
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
                                    <?= $devisEntity->tva->valeur ?>%<br>
                                    <i>(<?= $this->Utilities->formatCurencyPdf($montant * $devisEntity->tva->get('decimal')) ?>)</i>
                                </td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">
                                    <?php 
                                    if($devisEntity->remise_line && $ligne->remise_value) {
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
                                    echo $this->Utilities->formatCurencyPdf($montant * $devisEntity->tva->get('indice'));
                                    if($ligne->line_option) { echo '<br>En option'; }
                                    ?></td>
                            </tr>
                        <?php } ?>
                            
                        <?php if($ligne->type_ligne == 'abonnement') : ?>
                            <tr class="<?= $ligne->line_option?'ligne-option':'' ?>">

                                <td class="p-l-5<?= @$colVisibilityParams->descr ? 'hide' : '' ?>"><div class="break-inside"><?= $ligne->description_commercial ?></div></td>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->qty ? 'hide' : '' ?>">
                                    <?= $this->Utilities->formatNumber($ligne->quantite_usuelle?:1) ?></td>
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
                                        <i><?= $ligne->catalog_unites_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php else : ?>
                                        <?= $this->Utilities->formatCurencyPdf($ligne->tarif_client?:0) ?><br>
                                        <i><?= $ligne->catalog_unites_id?$ligne->catalog_unite->nom:"" ?></i></td>
                                    <?php endif; ?>
                                <td class="p-l-5 text-right <?= @$colVisibilityParams->tva ? 'hide' : '' ?>">
                                    <?= $devisEntity->tva->valeur ?>%<br>
                                    <i>(<?= $this->Utilities->formatCurencyPdf($montant * $devisEntity->tva->get('decimal')) ?>)</i>
                                </td>
                                <td class="montant-ht text-right <?= @$colVisibilityParams->montant_ht ? 'hide' : '' ?>">
                                    <?php 
                                    if($devisEntity->remise_line && $ligne->remise_value) {
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
                                    echo $this->Utilities->formatCurencyPdf($montant * $devisEntity->tva->get('indice'));
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
                            <?php if($devisEntity->note) : ?>
                                <div class="note">
                                    <p>Note : </p> <?= $devisEntity->note ?>
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
                                            <?= $devisEntity->total_ht_client? $this->Utilities->formatCurencyPdf($devisEntity->total_ht_client?:0):$this->Utilities->formatCurencyPdf($devisEntity->total_ht?:0) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <?php if( $devisEntity->remise_global_value) : ?>
                                        <tr>
                                            <td>
                                                Réduction HT
                                            </td>
                                            <td class="text-right remise-global-ht">
                                                <?= $devisEntity->total_reduction_client? $this->Utilities->formatCurencyPdf($devisEntity->total_reduction_client) : $this->Utilities->formatCurencyPdf($devisEntity->total_reduction) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                        <tr>
                                            <td>Total HT après réduction</td>
                                            <td class="text-right total-after-remise">
                                                <?= $devisEntity->total_remise_client? $this->Utilities->formatCurencyPdf($devisEntity->total_remise_client): $this->Utilities->formatCurencyPdf($devisEntity->total_remise) ?>
                                            </td>
                                            <td>€</td>
                                        </tr>
                                    <?php endif ?>
                                    <tr class="<?= @$colVisibilityParams->tva ? "hide":"" ?>">
                                        <td>TVA <?= $devisEntity->tva?$devisEntity->tva->valeur . '%' : '' ?></td>
                                        <td class="text-right total_general_tva">
                                            <?= $devisEntity->total_tva_client ? $this->Utilities->formatCurencyPdf($devisEntity->total_tva_client): $this->Utilities->formatCurencyPdf($devisEntity->total_tva) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                    <tr>
                                        <td>Montant total TTC</td>
                                        <td class="text-right total_general_ttc">
                                            <?= $devisEntity->total_ttc_client? $this->Utilities->formatCurencyPdf($devisEntity->total_ttc_client): $this->Utilities->formatCurencyPdf($devisEntity->total_ttc) ?>
                                        </td>
                                        <td>€</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <!-- <p style="page-break-before: always;"></p> -->
         <b><div class="sign-cl auto-break">Signature du client précédée de la mention<br> 'Lu et approuvé, bon pour accord' :</div></b><br><br>
         <div class="auto-break">
            <table class="pdf-table-2 space-5">
                <thead>
                    <tr>
                        <th width="120px"></th>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="text-grey"> Date de validité  :</span></td>
                        <td><span id="date_val" class="innfo-regl"><?= $devisEntity->date_sign_before?$devisEntity->date_sign_before->format('d/m/Y'):"--" ?></span></td>
                    </tr>
                     <tr class="moyen-regl">
                        <td><span class="text-grey"> Moyen de réglement : </span></td>
                        <td>
                            <span id="moye_regl" class="innfo-regl">
                                <?php foreach ($devisEntity->get('MoyenReglementsAsArray') as $moyen) : ?>
                                    <?= @$moyen_reglements[$moyen] ?><br>
                                <?php endforeach; ?>
                            </span>
                        </td>
                    </tr>

                    <?php if($devisEntity->accompte_value != '') : ?>
                        <tr>
                           <td><span class="text-grey"> Acompte : </span></td>
                           <td> <span id="acompte" class="innfo-regl"><?= $devisEntity->accompte_value ?> <?= $devisEntity->accompte_unity ?></span>
                        </tr>
                        <?php 
                            $accompte = $devisEntity->accompte_value;
                            if($devisEntity->accompte_unity == '%') : $accompte = $devisEntity->total_ttc * $devisEntity->accompte_value / 100;
                        ?>
                        
                        <tr>
                           <td></td>
                           <td> <span id="acompte" class="innfo-regl"><?= $accompte ?> €</span>
                        </tr>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($devisEntity->delai_reglements != 'echeances') : ?>
                        <tr>
                            <td><span class="text-grey"> <span class="text-grey"> Délai de règlement : </span></td>
                            <td><span id="del_regl" class="innfo-regl"><?= @$delai_reglements[$devisEntity->delai_reglements] ?></span></td>
                        </tr>
                    <?php else : ?>
                        <tr class="moyen-regl">
                            <td><span class="text-grey"> <span class="text-grey"> Délai de règlement : </span></td>
                            <td>
                                <?php foreach ($devisEntity->devis_echeances as $key => $echeance) : ?>
                                    <?= $echeance->date ?> : <?= $this->Utilities->formatCurencyPdf($echeance->montant, ['after' => ' €']) ?> <br>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($devisEntity->display_virement && $devisEntity->infos_bancaire): ?>
                        <tr class="align-top">
                            <td><span class="text-grey"> <span class="text-grey"> Banque : </span></td>
                            <td>
                                <?= $devisEntity->infos_bancaire->adress ?> <br>
                                BIC : <?= $devisEntity->infos_bancaire->bic ?> <br>
                                IBAN : <?= $devisEntity->infos_bancaire->iban ?>
                            </td>
                        </tr>
                    <?php endif ?>

                    <?php if ($devisEntity->display_cheque): ?>
                        <tr class="align-top">
                            <td><span class="text-grey"> <span class="text-grey"> Libellé du chèque : </span></td>
                            <td>KONITYS </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
         </div>
        <br>
        
        <?php if($devisEntity->is_text_loi_displayed) : ?>
        <div class="auto-break">
            <div class="condition-paiem"><p><?= $devisEntity->text_loi ?></p></div> 
        </div>
        <?php endif ?>
    </div>
</div>
</main>
