<?php $this->Html->css('ventes/recap.css', ['block' => true]); ?>
<?php $this->Html->script('ventes/recap.js', ['block' => true]); ?>
<?php $this->extend('fiche_layout') ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?php $this->assign('info_sup', '#'.$venteEntity->id . ' - ' . ($clientEntity ? ($clientEntity->enseigne ?? $clientEntity->nom) : "") . ' (' . @$parcs[$venteEntity->parc_id] . ')') ?>
<?php $this->assign('etat_vente', $venteEntity->vente_statut? 'Etat : '. @$vente_statuts[$venteEntity->vente_statut]:'') ?>

<!-- Par défaut si tr ne contient aucune info, le recap.js cache le tr cf. ticket, mettre .show sur un tr pour forcer la visibilité -->

<!-- Modal -->
<div class="modal fade" id="modal-devis" tabindex="-1" role="dialog" aria-labelledby="id-modal-devis" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="id-modal-devis">Aperçu du document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-iframe-devis"><!-- JS IFRAME --></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary btn" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change-state" role="dialog">
    <div class="modal-dialog modal-lg">

        <?= $this->Form->create(false, ['type' => 'file']); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Mettre à jour l'état de la facturation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
    
                    <div class="alert-modal alert d-none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div class="msg"></div>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Choisir parmi la liste *</label>
                        <?= $this->Form->select('etat_facturation', $vente_etat_facturations, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker etat_facturation']); ?>
                    </div>

                    <div class="form-group">
                        <label for="vente-statut">Date *</label>
                        <?= $this->Form->text('date_facturation', ['type' => 'date', 'required', 'empty' => 'Seléctionner', 'class' => 'form-control date_facturation']); ?>
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

<?php $this->start('vente_header_left') ?>
    Fiche récap vente borne - #<?= $venteEntity->id ?>
<?php $this->end() ?>

<div class="card mb-4">
    <div class="card-body hide-table-empty">

        <div class="row">
            <div class="col-md-6 my-auto"><h2>CLIENT ET FACTURATION</h2></div>
            <div class="col-md-6 my-auto"><span class="float-right"></span></div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="row-fluid mb-4">
                    <h3 class="mb-4">Client</h3>
                    
                    <?php if ($venteEntity->client): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($venteEntity->is_agence == 1 && $venteEntity->proprietaire): ?>
                                    <tr>
                                        <td>Propiétaire</td>
                                        <td><?= $venteEntity->proprietaire ?></td>
                                    </tr>
                                <?php endif ?>
                                
                                <tr>
                                    <td>Genre</td>
                                    <td><?= $genres[$venteEntity->client->client_type] ?? '' ?></td>
                                </tr>
                                <?php if($venteEntity->client->client_type == 'corporation') : ?>
                                    <tr>
                                        <td>Enseigne</td>
                                        <td><?= $venteEntity->client->enseigne ?></td>
                                    </tr>
                                    <tr>
                                        <td>Raison sociale</td>
                                        <td><?= $venteEntity->client->nom ?></td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td>Nom</td>
                                        <td><?= $venteEntity->client->nom ?></td>
                                    </tr>
                                    <tr>
                                        <td>Prénom</td>
                                        <td><?= $venteEntity->client->prenom ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>Adresse</td>
                                    <td>
                                        <span class="br"><?= $venteEntity->client->adresse ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Code postal</td>
                                    <td><?= $venteEntity->client->cp ?></td>
                                </tr>
                                <tr>
                                    <td>Ville</td>
                                    <td><?= $venteEntity->client->ville ?></td>
                                </tr>
                                <tr>
                                    <td>Adresse complémentaire</td>
                                    <td>
                                        <?= $venteEntity->client->adresse_2 ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Téléphone entreprise</td>
                                    <td><?= $venteEntity->client->telephone ?></td>
                                </tr>
                                <tr>
                                    <td>2 ème téléphone entreprise</td>
                                    <td><?= $venteEntity->client->telephone_2 ?></td>
                                </tr>
                                <tr>
                                    <td>Email général</td>
                                    <td><?= $venteEntity->client->email ?></td>
                                </tr>
                                
                                <tr>
                                    <td>Tva Intracommunautaire</td>
                                    <td><?= $venteEntity->client->tva_intra_community ?></td>
                                </tr>
                                <tr>
                                    <td>Siren</td>
                                    <td><?= $venteEntity->client->siren ?></td>
                                </tr>
                                <tr>
                                    <td>Siret</td>
                                    <td><?= $venteEntity->client->siret ?></td>
                                </tr>
                                <tr>
                                    <td>Secteur(s) d'activité(s)</td>
                                    <td>
                                        <?php foreach ($venteEntity->client->secteurs_activites as $key => $secteursActivites): ?>
                                            <?= $secteursActivites->name ?> <br>
                                        <?php endforeach ?>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    <?php else: ?>
                        Aucun client associé
                    <?php endif ?>


                </div>

                <?php if ($venteEntity->client): ?>
                    <div class="clearfix mb-4">
                        <a class="btn btn-rounded btn-success float-right" href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $venteEntity->client_id]) ?>">Fiche client</a>
                    </div>
                <?php endif ?>
                
            </div>

            <div class="col-md-6">
                <div class="row-fluid mb-4">
                    <h3 class="mb-4">Contrat</h3>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Type de vente</td>
                                <td><?= @$parcs[$venteEntity->parc_id] ?></td>
                            </tr>
                            <tr>
                                <td>Nombre de mois</td>
                                <td><?= @$parc_durees[$venteEntity->parc_duree_id] ?></td>
                            </tr>
                            <tr>
                                <td>Convention de partenariat sous location</td>
                                <td><?= @$yes_or_no[$venteEntity->is_sous_location] ?></td>
                            </tr>
                            <tr>
                                <td>Abonnement BO</td>
                                <td><?= @$yes_or_no[$venteEntity->is_abonnement_bo] ?></td>
                            </tr>

                            <?php if (in_array($venteEntity->parc_id, [4, 9])): ?>
                                <tr>
                                    <td>Date début</td>
                                    <td><?= $venteEntity->contrat_debut != null ? $venteEntity->contrat_debut->format('d/m/Y') : '' ?></td>
                                </tr>
                                <tr>
                                    <td>Date fin</td>
                                    <td><?= $venteEntity->contrat_fin != null ? $venteEntity->contrat_fin->format('d/m/Y') : '' ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <td>Commercial</td>
                                <td><?= $userEntity->get('full_name') ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <i>Fiche renseignée le <?= $venteEntity->modified->format('d/m/Y') ?></i>
                </div>
            </div>
        </div>
        
        <div class="clearfix">
            <h3 class="mb-4">Contact(s) associé(s)</h3>

            <?php if (!empty($venteEntity->client->client_contacts)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prénom (*)</th>
                            <th>Nom (*)</th>
                            <th>Fonction </th>
                            <th>Email (*)</th>
                            <th>Téléphone Portable</th>
                            <th>Téléphone Fixe</th>
                            <th>Type</th>
                        </tr>

                        <?php foreach ($venteEntity->client->client_contacts as $key => $clientContact): ?>
                            <?php /*debug($clientContact);*/ ?>
                            <tr>
                                <td><?= $clientContact->prenom ?></td>
                                <td><?= $clientContact->nom ?></td>
                                <td><?= $clientContact->position ?></td>
                                <td><?= $clientContact->email ?></td>
                                <td><?= $clientContact->tel ?></td>
                                <td><?= $clientContact->telephone_2 ?></td>
                                <td><?= $contactTypes[$clientContact->contact_type_id] ?? '' ?></td>
                            </tr>
                        <?php endforeach ?>
                    </thead>
                </table>
            <?php else: ?>
                Aucun contact associé
            <?php endif ?>
        </div>
            
        <div class="row">
            
            
            <div class="col-md-6 <?= empty($venteEntity->documents['_ids']) && !$venteEntity->ventes_devis_uploads ? 'd-none' : '' ?>">
                <div class="row-fluid mb-4">
                    <h3 class="mb-4">Devis</h3>

                    <?php if ($venteEntity->documents): ?>
                        <table class="table table-bordered m-0 table-hover">
                            <tbody>
                                <tr>
                                    <td><b>Numéro devis</b></td>
                                    <td><b>Montant HT</b></td>
                                    <td><b>Date</b></td>
                                </tr>
                                <?php foreach ($venteEntity->documents as $key => $documents): ?>
                                    <?php $data_href = $this->Url->build(['controller' => 'ventes', 'action' => 'convertSellsyPdfToDsiplayable', 'url' => $documents->url_sellsy], true) ?>
                                    <tr>
                                        <td><a href="#modal-devis" data-href="<?= $data_href ?>" data-toggle="modal" data-target="#modal-devis"><?= $documents->ident ?></a></td>
                                        <td><?= $this->Number->precision($documents->montant_ht, 2); ?> EUR</td>
                                        <td><?= $documents->date ? $documents->date->format('d/m/Y') : '' ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>

                    <?php if ($venteEntity->ventes_devis_uploads): ?>
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><b>Devis importé(s) :</b></td>
                                </tr>
                                <?php foreach ($venteEntity->ventes_devis_uploads as $key => $ventes_devis_uploads): ?>
                                    <tr>
                                        <td>- <a href="#modal-devis" data-href="<?= $this->Url->build('/'.$ventes_devis_uploads->get('file_path')) ?>"  data-toggle="modal" data-target="#modal-devis"><?= $ventes_devis_uploads->filename ?></a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php endif ?>

                    <?php if (!$venteEntity->documents && !$venteEntity->ventes_devis_uploads): ?>
                        Aucun devis choisi ni importé
                    <?php endif ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4  step-vente">
    <div class="card-body">
        <h2>MATERIEL</h2>
        <div class="row-fluid mb-4">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-4">Descriptif borne</h3>
                    
                    <table class="table table-bordered table-hover hide-table-empty">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($venteEntity->gamme_borne_id) : ?>
                                <tr>
                                    <td>Gamme</td>
                                    <td><?= @$gammesBornes[$venteEntity->gamme_borne_id]  ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($venteEntity->model_borne_id != null) : ?>
                                <tr>
                                    <td>Type</td>
                                    <td><?= @$modelBornes[$venteEntity->model_borne_id]  ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($venteEntity->couleur_borne_id != null) : ?>
                                <tr>
                                    <td>Couleur</td>
                                    <td><?= @$couleurBornes[$venteEntity->couleur_borne_id]  ?></td>
                                </tr>
                            <?php endif; ?>

                            
                            <?php if ($venteEntity->equipement_ventes): ?>
                                <?php foreach ($venteEntity->equipement_ventes as $equipement_ventes) : ?>
                                    
                                    <?php if (!$equipement_ventes->is_rien_rempli): ?>
                                        <tr>
                                            <td><?= @$typesEquipements[$equipement_ventes->type_equipement_id] ?> :</td>
                                            <td>

                                                <?php if ($equipement_ventes->aucun): ?>
                                                    Sans
                                                <?php else : ?>
                                                    <?php if (@$equipements[$equipement_ventes->equipement_id]): ?>
                                                        <?= @$equipements[$equipement_ventes->equipement_id] ?> <br>
                                                    <?php elseif ($equipement_ventes->valeur_definir): ?>
                                                        Oui <br>
                                                    <?php endif ?>
                                                    <?php if ($equipement_ventes->materiel_occasion): ?>
                                                        Matériel occasion
                                                    <?php endif ?>
                                                <?php endif ; ?>

                                            </td>
                                        </tr>
                                    <?php endif ?>

                                <?php endforeach; ?>
                            <?php else: ?>
                                Aucun
                            <?php endif ?>

                            
                            <tr>
                                <td>Valise de transport</td>
                                <td><?= @$yes_or_no_template[$venteEntity->is_valise_transport] ?></td>
                            </tr>

                            <?php if ($venteEntity->is_valise_transport == 1): ?>
                                <tr>
                                    <td> - Avec tête</td>
                                    <td><?= $yes_or_no[$venteEntity->is_valise_with_tete] ?></td>
                                </tr>
                                <tr>
                                    <td> - Avec pied</td>
                                    <td><?= $yes_or_no[$venteEntity->is_valise_with_pied] ?></td>
                                </tr>
                                <tr>
                                    <td> - Avec socle</td>
                                    <td><?= $yes_or_no[$venteEntity->is_valise_with_socle] ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <td>Housse de protection</td>
                                <td><?= @$yes_or_no_template[$venteEntity->is_housse_protection] ?></td>
                            </tr>
                            <?php if ($venteEntity->is_housse_protection == 1): ?>
                                <tr>
                                    <td> - Avec tête</td>
                                    <td><?= $venteEntity->is_house_with_tete == 1 ? 'Oui' : '' ?></td>
                                </tr>
                                <tr>
                                    <td> - Avec pied</td>
                                    <td><?= $venteEntity->is_house_with_pied == 1 ? 'Oui' : '' ?></td>
                                </tr>
                                <tr>
                                    <td> - Avec socle</td>
                                    <td><?= $venteEntity->is_house_with_socle == 1 ? 'Oui' : '' ?></td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3 class="mb-4">Options borne</h3>

                    <table class="table table-bordered table-hover hide-table-empty">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Marque blanche</td>
                                <td><?= @$yes_or_no_template[$venteEntity->is_marque_blanche] ?></td>
                            </tr>
                            <tr>
                                <td>Gravure personnalisée</td>
                                <td><?= @$yes_or_no_template[$venteEntity->is_custom_gravure] ?></td>
                            </tr>
                            <tr>
                                <td>Note sur la gravure</td>
                                <td><?= $venteEntity->gravure_note ?></td>
                            </tr>
                            <tr>
                                <td>Avec accessoires</td>
                                <td><?= @$yes_or_no_template[$venteEntity->is_accessoires] ?></td>
                            </tr>

                            <?php if (!empty($venteEntity->ventes_accessoires)): ?>
                                <?php foreach ($venteEntity->ventes_accessoires as $key => $ventes_accessoires): ?>
                                    <tr>
                                        <td><?= @$sousAccessoires[$ventes_accessoires->sous_accessoire_id]->name ?></td>
                                        <td><?= $ventes_accessoires->qty ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                            <tr>
                                <td>Information supplémentaire</td>
                                <td><?=$venteEntity->materiel_note ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php if (!empty($venteEntity->equipements_protections_ventes)): ?>
                    <div class="col-md-6">
                        <h3 class="mb-4">Protections(s) supplémentaire(s)</h3>
                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="15%" class="p-0"></th>
                                    <th width="25%" class="p-0"></th>
                                    <th width="25%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <tr>
                                    <td><b>Type équipement</b></td>
                                    <td><b>Modèle</b></td>
                                    <td><b>Qté</b></td>
                                </tr>
                                <!-- JS -->
                                    <?php foreach ($venteEntity->equipements_protections_ventes as $key => $equipementsProtectionVente): ?>
                                        <?php $type_equipement_id = $equipementsProtectionVente->type_equipement_id ?>
                                        <tr class="show">
                                            <td class="nom-equip-accessoire"><?= $equipementsProtectionVente->type_equipement->nom ?? ''?></td>
                                            <td class="select-equip-accessoire">
                                                <?= $equipementsProtectionVente->equipement->valeur ?? '   ' ?>
                                            </td>
                                            <td class="qty-equip-accessoire">
                                                <?= $equipementsProtectionVente->qty ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
                
                <?php if (!empty($venteEntity->equipements_accessoires_ventes)): ?>
                    <div class="col-md-6">
                        <h3 class="mb-4">Accessoire(s) supplémentaire(s)</h3>
                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="15%" class="p-0"></th>
                                    <th width="25%" class="p-0"></th>
                                    <th width="25%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <tr>
                                    <td><b>Type équipement</b></td>
                                    <td><b>Modèle</b></td>
                                    <td><b>Qté</b></td>
                                </tr>
                                <?php foreach ($venteEntity->equipements_accessoires_ventes as $key => $equipementsAccessoiresVente): ?>
                                    <?php $type_equipement_id = $equipementsAccessoiresVente->type_equipement_id ?>
                                    <tr class="show">
                                        <td class="nom-equip-accessoire"><?= $equipementsAccessoiresVente->type_equipement->nom ?></td>
                                        <td class="select-equip-accessoire">
                                            <?= $equipementsAccessoiresVente->equipement->valeur ?? '' ?>
                                        </td>
                                        <td class="qty-equip-accessoire">
                                            <?= $equipementsAccessoiresVente->qty ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4 <?= $venteEntity->is_carton_bobine != 0 || !empty($venteEntity->materiel_other_note) ?: 'd-none' ?>">
    <div class="card-body">
        <h2>OPTIONS / CONSOMMABLES</h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <!-- <h3 class="mb-4">Options achat à la livraison</h3> -->
                <table class="table table-bordered hide-table-empty">
                    <thead>
                        <tr>
                            <th width="50%" class="p-0"></th>
                            <th width="50%" class="p-0"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="<?= $venteEntity->is_carton_bobine != null ? '' : 'd-none'; ?>">
                            <td>Inclure des consommables à la commande</td>
                            <td><?= @$yes_or_no_template[$venteEntity->is_carton_bobine] ?></td>
                        </tr>

                        <?php if ($venteEntity->is_carton_bobine == 1): ?>
                            <?php foreach ($venteEntity->ventes_sous_consommables as $key => $ventes_sous_consommables): ?>
                                <tr>
                                    <td><?= @$sousTypesConsommables[$ventes_sous_consommables->sous_types_consommable_id]->name ?></td>
                                    <td><?= $ventes_sous_consommables->qty ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        
                        <tr class="<?= $venteEntity->materiel_other_note != null ? '' : 'd-none'; ?>">
                            <td>Autres</td>
                            <td><?= $venteEntity->materiel_other_note  ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h2>CREA / CONFIG</h2>
        <div class="row-fluid mb-4">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered hide-table-empty">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($venteEntity->is_contact_crea_different_than_contact_client) : ?>
                                <tr  class="<?= $venteEntity->contact_crea_fullname!=null ? '' : 'd-none'; ?>">
                                    <td>Nom et prénom du contact</td>
                                    <td><?= $venteEntity->contact_crea_fullname ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->contact_crea_fonction!=null ? '' : 'd-none'; ?>">
                                    <td>Fonction dans l’entreprise</td>
                                    <td><?= $venteEntity->contact_crea_fonction ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->contact_crea_email!=null ? '' : 'd-none'; ?>">
                                    <td>Email</td>
                                    <td><?= $venteEntity->contact_crea_email ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->contact_crea_telmobile!=null ? '' : 'd-none'; ?>">
                                    <td>Tel portable</td>
                                    <td><?= $venteEntity->contact_crea_telmobile ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->contact_crea_telfixe!=null ? '' : 'd-none'; ?>">
                                    <td>Tel fixe</td>
                                    <td><?= $venteEntity->contact_crea_telfixe ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->contact_crea_note!=null ? '' : 'd-none'; ?>">
                                    <td>Commentaire optionnel</td>
                                    <td><?= $venteEntity->contact_crea_note ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td>Contact</td>
                                    <td>Identique au contact principal</td>
                                </tr>
                            <?php endif; ?>
                            <tr class="<?= $venteEntity->config_crea_note!=null ? '' : 'd-none'; ?>">
                                <td>Note</td>
                                <td><?= $venteEntity->config_crea_note ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
    
<div class="card mb-4 hide-table-empty">
    <div class="card-body">
        <h2>LIVRAISON</h2>
        <div class="row-fluid mb-4">
            <div class="row">

                <div class="col-md-6">
                   <h3 class="mb-4">Contact livraison</h3>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($venteEntity->is_livraison_different_than_contact_client): ?>
                                <tr>
                                    <td>Nom et prénom du contact</td>
                                    <td><?= $venteEntity->livraison_crea_fullname ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_crea_email!= null?'':'d-none'; ?>">
                                    <td>Email</td>
                                    <td><?= $venteEntity->livraison_crea_email ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_crea_telmobile!=null? '' : 'd-none'; ?>">
                                    <td>Tel portable</td>
                                    <td><?= $venteEntity->livraison_crea_telmobile ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_crea_telfixe!=null ? '' : 'd-none'; ?>">
                                    <td>Tel fixe</td>
                                    <td><?= $venteEntity->livraison_crea_telfixe ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td>Contact</td>
                                    <td>Identique au contact principal</td>
                                </tr>
                            <?php endif ?>
                            <?php if ($venteEntity->is_livraison_adresse_diff_than_client_addr == 1): ?>
                                
                                <tr>
                                    <td>Livraison dans un lieu différent</td>
                                    <td><?= @$yes_or_no_template[$venteEntity->is_livraison_adresse_diff_than_client_addr] ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_client_adresse != null ? '' : 'd-none'; ?>">
                                    <td>Adresse</td>
                                    <td><?= $venteEntity->livraison_client_adresse ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_client_cp != null ? '' : 'd-none'; ?>">
                                    <td>Code postal</td>
                                    <td><?= $venteEntity->livraison_client_cp ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_client_ville != null ? '' : 'd-none'; ?>">
                                    <td>Ville</td>
                                    <td><?= $venteEntity->livraison_client_ville ?></td>
                                </tr>
                                <tr>
                                    <td>Pays</td>
                                    <td><?= $venteEntity->livraison_pays->name ?></td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <td>Commentaire</td>
                                <td><?= $venteEntity->livraison_contact_note ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <?php if($venteEntity->livraison_date_first_usage != null || !empty($venteEntity->livraison_infos_sup) || $venteEntity->livraison_date != null || $venteEntity->livraison_is_as_soon_as_possible != 0 || $venteEntity->livraison_is_client_livr_adress != 0) : ?>
                        <h3 class="mb-4">Informations livraison</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="<?= $venteEntity->livraison_date_first_usage != null ? '':'d-none' ?>">
                                    <td>Date de 1ère utilisation de la borne (1er event)</td>
                                    <td><?= $venteEntity->livraison_date_first_usage != null ? $venteEntity->livraison_date_first_usage->format('d/m/Y') : '' ?></td>
                                </tr>
                                <tr class="<?= $venteEntity->livraison_infos_sup != null ? '':'d-none' ?>">
                                    <td>Informations supplémentaires</td>
                                    <td><?= $venteEntity->livraison_infos_sup ?></td>
                                </tr>
                                <tr>
                                    <td>Date de livraison souhaitée</td>
                                    <td>
                                        <?php if ($venteEntity->livraison_type_date == 'precis'): ?>
                                            <?= $venteEntity->livraison_date->format('d/m/Y') ?>
                                        <?php else: ?>
                                            <?= $livraison_type_dates[$venteEntity->livraison_type_date] ?? '' ?>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>
    </div>
</div>
