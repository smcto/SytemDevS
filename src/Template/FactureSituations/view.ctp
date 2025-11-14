<?php use Cake\Routing\Router; ?>
<?php $this->Html->css('devisFactures/add.css?time='.time(), ['block' => 'css']); ?>
<?php $this->Html->css('facture-situations/add.css?time='.time(), ['block' => 'css']); ?>
<?php $this->Html->css('fontawesome5/css/all.min.css', ['block' => 'css']); ?>
<?php $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?php $this->Html->script('moment/moment.js', ['block' => 'script']); ?>
<?php $this->Html->script('facture-situations/add.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('calendar/dist/lib/jquery-ui.min.js', ['block' => 'script']); ?>

<?php $custum_title = 'Facture de situation'; ?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <?php if($factureSituationEntity->id) : ?>
            <a href="<?= $this->Url->build(['action' => 'add', 'devi_id' => $factureSituationEntity->devi_id]) ?>" target="_blank" class="btn btn-sm btn-rounded btn-primary">Ajouter une Situation</a>
        <?php endif ?>
        <a href="<?= $this->Url->build(['controller' => 'FactureSituations', 'action' => 'add', $factureSituationEntity->id]) ?>" class="btn btn-sm btn-rounded btn-primary">Modifier</a>
        <a href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $factureSituationEntity->devi_id]) ?>" class="btn btn-sm btn-rounded btn-inverse">Annuler</a>
    </div>
<?php $this->end() ?>

<?php $this->assign('custom_title', '<h1 class="m-0 top-title">' . $custum_title . '</h1>'); ?>
<?php $this->assign('title', $custum_title) ?>

<div class="checkbox d-none"> <label for="sn-checkbox-open-in-new-window"> <input type="checkbox" id="sn-checkbox-open-in-new-window" checked="">Ouvrir dans une nouvelle fenêtre</label></div>

<?= $this->Form->create($factureSituationEntity, ['class' => 'form-facture-situation']); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="row-fluid">
                        <?= $this->Form->hidden('nom_societe', ['placeholder' => '' ,'label' => 'Nom de la société', 'value' => 'KONITYS']); ?>
                        <div class="bloc-addr">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => 'Réf. commercial', 'class' => 'selectpicker']); ?>
                            KONITYS <br>
                            <b>Contact : </b> <span id="full_name"><?= $currentUser->get('full_name') ?></span>
                        </div>

                        <div class="infos row-fluid">
                            <span class="text-grey"> Tel : </span> <span id="telephone_fixe"><?= $currentUser->telephone_fixe ?></span> <br>
                            <span class="text-grey"> Email : </span><span id="email"><?= $currentUser->email ?></span>
                            <a class="mb-4 d-none" id="link-user" target="_blank" href="<?= $this->Url->build(['controller' => 'users', 'action' => 'edit', $currentUser->id]) ?>">Modifier les informations par défaut</a>
                        </div>
                    </div>
                </div>

                <div class="offset-xl-6 offset-md-3 col-xl-3 col-md-6 col-sm-6">
                    <div class="row-fluid no-spin">
                        <div class="form-group row">
                            <span class="col-md-12">Etat : <?= @$facture_situations_status[$factureSituationEntity->status] ?></span>
                        </div>
                        <div class="form-group row">
                            <span class="col-md-12">Facture de situation N° : <?= $factureSituationEntity->indent ?></span>
                        </div>
                        <div class="form-group row">
                            <span class="col-md-12">Situation n° <?= $factureSituationEntity->numero ?></span>
                        </div>
                        <div class="form-group row">
                            <span class="col-md-12">En date du : <?= $factureSituationEntity->date_crea->format('d-m-y') ?></span>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <span><b>Nom du client : <?= $factureSituationEntity->client->full_name ?></b></span>
                        <span class="client_contact">
                            <?php if ($factureSituationEntity->facture_client_contact) : ?>
                            À l'attention de <b><?= $factureSituationEntity->facture_client_contact->civilite ?> <?= $factureSituationEntity->facture_client_contact->full_name ?></b><br>
                            <?php endif; ?>
                        </span>
                        <span class="clinet_info">
                            <?= $factureSituationEntity->client_adresse ? $factureSituationEntity->client_adresse."<br>": "" ?>
                            <?= $factureSituationEntity->client_adresse_2? $factureSituationEntity->client_adresse_2."<br>":"" ?>
                            <?= $factureSituationEntity->client_cp .' '. $factureSituationEntity->client_ville ?> <br>
                            <?= $factureSituationEntity->client_country ?>
                        </span>
                        
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="container-objet">
                        <div class="row-fluid bloc-objet">
                            <b>Objet : </b><?= $factureSituationEntity->objet ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid ">
                <h3>Détails</h3>
                
                <div class="">
                    <table class="table table-uniforme table_bloc_devis_factures table-bordered  detail-form ">
                        <thead class="bg-light">
                            <tr>
                                <th width="10%">Référence</th>
                                <th class="th-descr" width="450px">Description</th>
                                <th>Remise</th>
                                <th>Coût unitaire HT</th>
                                <th>Facturé - Prévu</th>
                                <th>Avancement</th>
                                <th width="6%">TVA</th>
                                <th width="10%" class="text-right">Montant HT</th>
                                <th width="10%" class="text-right">Montant TTC</th>
                            </tr>
                        </thead>
                        
                        <!-- Recois les params -->
                        <?= $this->Form->hidden('col_visibility_params'); ?>

                        <tbody id="sortable" class="default-data">
                            <?php if($factureSituationEntity->facture_situations_produits) : ?>
                                <?php foreach ($factureSituationEntity->facture_situations_produits as $key => $ligne) : ?>
                            
                                    <?php if($ligne->type_ligne == 'produit' || $ligne->type_ligne == 'abonnement') : ?>
                                        <tr class="clone added-tr <?= $ligne->line_option?'ligne-option':'' ?>">
                                            <td class="d-none">
                                            </td>
                                            <td>
                                                <?= $ligne-> reference ?>
                                            </td> 
                                            <td><?= $ligne-> description_commercial ?></td>
                                            <td class="block-remise remise">
                                                <div class="col-12"><?= $ligne->remise_value . $ligne->remise_unity ?></div>
                                            </td>
                                            <td class="block-remise">
                                                <div class="col-12"><?= $this->Utilities->formatCurrency($ligne->prix_reference_ht) ?></div>
                                            </td>
                                            <td class="text-right">
                                                <div class="col-12">
                                                    <div class="facture_pourcent"><?= $ligne->facture_pourcentage? : 0 ?> %</div>
                                                    <div class="facture_euro m-t-30"><?= $this->Utilities->formatCurrency($ligne->facture_euro? : 0) ?> </div>
                                                    <div class="quantite_usuelle  m-t-30"><?= $ligne->quantite_usuelle ?></div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="col-12">
                                                    <div class="facture_pourcent"><?= $ligne->avancement_pourcentage ?>%</div>
                                                    <div class="facture_euro m-t-30"><?= $ligne->avancement_euro ?>E</div>
                                                    <div class="quantite_usuelle  m-t-30"><?= $ligne->avancement_quantite ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-12"><?= $ligne->tva ?>%</div>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <div class="col-12"><div class="montant_ht_value"><?= $this->Utilities->formatCurrency($ligne->montant_ht) ?></div></div>
                                            </td>
                                            <td class="montant_ttc text-right">
                                                <div class="col-12"><div class="montant_ttc_value"><?= $this->Utilities->formatCurrency($ligne->montant_ttc) ?></div></div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                    <?php if($ligne->type_ligne == 'sous_total') : ?>
                                        <tr class="clone-sous-total added-tr hide">
                                            <td class="d-none">
                                            </td>
                                            <td colspan="8" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Sous-total</h4></div>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.sous_total", ['input-name' => 'sous_total', 'label' => false, ]); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'sous_total']); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <div class="row">
                                                    <div class="col-12"><div class="montant_ht_value sous-total-value"><?= $ligne->sous_total ?></div></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'titre') : ?>
                                        <tr class="clone-titre added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("facture_situations_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("facture_situations_produits.$key.titre_ligne", ['input-name' => 'titre_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'titre']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'commentaire') : ?>
                                        <tr class="clone-commentaire added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("facture_situations_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("facture_situations_produits.$key.commentaire_ligne", ['input-name' => 'commentaire_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'commentaire']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_ligne') : ?>
                                        <tr class="clone-saut-ligne added-tr hide">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("facture_situations_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de ligne</h4></div>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_ligne']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevisFactures', 'action' => 'deleteLineDevisFacturesProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_page') : ?>
                                        <tr class="clone-saut-page added-tr">
                                            <td class="d-none">
                                                <?= $this->Form->hidden("facture_situations_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="9" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de page</h4></div>
                                                <?= $this->Form->hidden("facture_situations_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_page']); ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                <?php endforeach; ?>
                                        
                            <?php else : ?>
                                <tr><td colspan="9" class="text-center first-tr py-5 dynamic-colspan">Aucun ligne</td></tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="<?= $factureSituationEntity->pourcentage_global?:'hide' ?>">
                            <tr>
                                <td colspan="5"></td>
                                <td>
                                    <div class="row pourcentage_global_filed m-l-10 <?= $factureSituationEntity->pourcentage_global?:'hide' ?>"><?= $this->Form->control("pourcentage_global", ['input-name' => 'pourcentage_global', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control pourcentage_global']); ?><span class="suffix">%</span></div>
                                    <div class="row pourcentage_global_button m-l-10 <?= $factureSituationEntity->pourcentage_global?'hide':'' ?>"><button type="button" class="btn btn-rounded btn-primary pourcentage_global_button"> <span aria-hidden="true">%Global</span> </button></div>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row m-t-40">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            Nombre de produit(s) du document <br>
                            <b class="nombre_produit">0</b>
                        </div>
                    </div>
                    <?= $this->Form->control('note', ['class' => 'tinymce-note', 'data-height' => 120]); ?>
                </div>

                <div class="col-md-6">
                    <table class="table table-uniforme">
                        <thead class="">
                            <tr class="hide">
                                <th width="90%"></th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                            <tr class="total-avec-abonnement d-none">
                                <th colspan="3"><b>Total interne</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-montant-ht">Montant total HT</td>
                                <td class="text-right montant_general total_general_ht"><?= $factureSituationEntity->total_ht?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ht', ['id' => 'total_ht']); ?>
                            </tr>
                            <tr  class="total-remise-global hide">
                                <td>Réduction HT</td>
                                <td class="text-right montant_general remise-global-ht"><?= $factureSituationEntity->total_reduction?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_reduction'); ?>
                            </tr>
                            <tr class="total-remise-global hide">
                                <td>Total HT après réduction</td>
                                <td class="text-right montant_general total-after-remise"><?= $factureSituationEntity->total_remise?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_remise'); ?>
                            </tr>
                            <tr>
                                <td class="tva-label">TVA</td>
                                <td class="text-right montant_general total_general_tva"><?= $factureSituationEntity->total_tva?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_tva', ['id' => 'total_tva']); ?>
                            </tr>
                            <tr>
                                <td>Montant total TTC</td>
                                <td class="text-right montant_general total_general_ttc"><?= $factureSituationEntity->total_ttc?:0 ?></td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ttc',['id' => 'total_ttc']); ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?= $this->form->end() ?>
