<?php $this->extend('fiche_layout') ?>

<?= $this->Html->css('table-uniforme', ['block' => 'css']); ?>
<?= $this->Html->script('ventes_consommables/ventes_consommables.js', ['block' => true]); ?>


<?php $this->assign('custom_title', 'Commande consommable # '.$ventesConsommable->id) ?>
<?php $this->assign('consommable_statut', $ventesConsommable->consommable_statut ? 'Etat : '. @$vente_etat_consommables[$ventesConsommable->consommable_statut]:'') ?>


<!-- Modal -->
<div class="modal fade" id="change-state" role="dialog" >
    <div class="modal-dialog modal-xl">

        <?= $this->Form->create(false, ['type' => 'file']); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mettre à jour l'état de la commande</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
    
                    <div class="alert-modal alert d-none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="msg"></div>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Choisir parmi la liste</label>
                        <?= $this->Form->select('consommable_statut', $vente_etat_consommables, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker vente_statut']); ?>
                    </div>

                    <div class="form-group is_expedie d-none">
                        <label for="date_depart_atelier">Date de départ de l'atelier *</label>
                        <?= $this->Form->text('date_depart_atelier', ['type' => 'date', 'id' => 'date_depart_atelier']); ?>
                    </div>
                    
                    <div class="form-group is_partiel_expedie <?= $ventesConsommable->consommable_statut == 'expedie_partiel' ?: 'd-none'?>">
                        <!-- AJAX -->
                        <?php if ($ventesConsommable->consommable_statut == 'expedie_partiel'): ?>
                            <?= $this->element('../AjaxVentes/load_form_by_vente_consommable') ?>
                        <?php endif ?>
                    </div>
    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save">Enregistrer</button>
                </div>
            </div>
        <?= $this->form->end() ?>

    </div>
</div>
<!-- End modal -->


<div class="card mb-4">
    <div class="card-body">
        <h3 class="mb-4 border-bottom border-secondary">Vente</h3>

        <table class="table table-uniforme">
            <thead>
                <tr>
                    <th width="50%" class="p-0"></th>
                    <th width="50%" class="p-0"></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Client</td>
                    <td><?= $ventesConsommable->client->get('full_name') ?></td>
                </tr>
                <tr>
                    <td>Date de livraison souhaitée</td>
                    <td><?= $ventesConsommable->livraison_date->format('d/m/Y') ?></td>
                </tr>
                <tr>
                    <td>Parc</td>
                    <td><?= $ventesConsommable->parc->nom ?></td>
                </tr>
                <tr>
                    <td>Commercial</td>
                    <td><?= $ventesConsommable->user->get('full_name') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<?php if ($ventesConsommable->consommable_statut == 'expedie'): ?>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-4 border-bottom border-secondary">Accessoires</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Nom</td>
                                <td>Quantité</td>
                            </tr>
                            <?php foreach ($devisProduitsAccessoires as $key => $devisProduitsAccessoire): ?>
                                <tr>
                                    <td><?= $devisProduitsAccessoire->devis_produit->reference ?></td>
                                    <td><?= $devisProduitsAccessoire->qty ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3 class="mb-4 border-bottom border-secondary">Consommables</h3>

                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Nom</td>
                                <td>Quantité</td>
                            </tr>
                            
                            <?php foreach ($devisProduitsConsomables as $key => $devisProduitsConsommable): ?>
                                <tr>
                                    <td><?= $devisProduitsConsommable->devis_produit->reference ?></td>
                                    <td><?= $devisProduitsConsommable->qty ?></td>
                                </tr>
                            <?php endforeach ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php else: ?>

    <div class="card mb-4">
        <div class="card-body">
                <div class="row-fluid clearfix ">
                    <h3 class="mb-4 border-bottom border-secondary">Accessoires <?= $ventesConsommable->consommable_statut == 'expedie_partiel' ? 'partiellement expédiés' : '' ?></h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%">Nom</th>
                                <th width="20%">Quantité expédiée</th>
                                <th width="20%">Quantité restante</th>
                                <th width="20%">Détail quantité</th>
                                <th width="20%">Date de livraison</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventesConsommable->ventes_has_devis_produits as $key => $ventesHasDevisProduit): ?>
                                <?php if ($ventesHasDevisProduit->devis_produit->catalog_produit->_matchingData['CatalogProduitsHasCategories']['catalog_sous_category_id'] == 2): ?>
                                    <tr>
                                        <td><?= $ventesHasDevisProduit->devis_produit->reference ?></td>
                                        <td><?= $ventesHasDevisProduit->qty_sent ?></td>
                                        <td><?= $ventesHasDevisProduit->get('RemainingQty') ?></td>
                                        <td><?= $ventesHasDevisProduit->qty ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table> 
                </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">

                <div class="row-fluid clearfix ">
                    <h3 class="mb-4 border-bottom border-secondary">Consommables <?= $ventesConsommable->consommable_statut == 'expedie_partiel' ? 'partiellement expédiés' : '' ?></h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="20%">Nom</th>
                                <th width="20%">Quantité expédiée</th>
                                <th width="20%">Quantité restante</th>
                                <th width="20%">Détail quantité</th>
                                <th width="20%">Date de livraison</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventesConsommable->ventes_has_devis_produits as $key => $ventesHasDevisProduit): ?>
                                <?php if ($ventesHasDevisProduit->devis_produit->catalog_produit->_matchingData['CatalogProduitsHasCategories']['catalog_sous_category_id'] == 16): ?>
                                    <tr>
                                        <td><?= $ventesHasDevisProduit->devis_produit->reference ?></td>
                                        <td><?= $ventesHasDevisProduit->qty_sent ?></td>
                                        <td><?= $ventesHasDevisProduit->get('RemainingQty') ?></td>
                                        <td><?= $ventesHasDevisProduit->qty ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tbody>
                    </table> 
                </div>
        </div>
    </div>
<?php endif ?>
