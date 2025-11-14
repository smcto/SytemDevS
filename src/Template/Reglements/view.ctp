<?= $this->Html->css(["https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css", ], ['block' => 'css'] ); ?>
<?= $this->Html->css('reglements/reglements.css?time='.time(), ['block' => 'css']); ?>

<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('reglements/reglements.js?'.  time(), ['block' => 'script']); ?>

<?php
$titrePage = "Réglement" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>
<div class="hide">
    <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false,'value' => '', 'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                    <div class="form-body">
                        <input type="hidden" id="position" value="bottom">
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Type de réglement</label>
                            <div class="col-md-8">
                                <?= @$type_reglement[$reglement->type] ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Client</label>
                            <div class="col-md-8">
                                <?php if ($reglement->client): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $reglement->client->id]) ?>"><?= $reglement->client->full_name ?></a>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Date de réglement</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?= @$reglement->date->format('d/m/Y') ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Date d'enregistrement du document</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <?= @$reglement->created->format('d/m/Y') ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Nom de la banque</label>
                            <div class="col-md-8">
                                <?= @$reglement->infos_bancaire->name?? '-' ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Moyen de paiement</label>
                            <div class="col-md-8">
                                <?= @$moyen_reglements[$reglement->moyen_reglement_id] ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Montant de réglement</label>
                            <div class="col-md-8">
                                <?= $reglement->montant ?> €
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Référence</label>
                            <div class="col-md-8">
                                <?php
                                    $link = $reglement->reference;
                                    if(!empty($reglement->devis_factures)){
                                        foreach ($reglement->devis_factures as $facture) {
                                            if($reglement->reference == $facture->indent) {
                                                $link = $this->Html->link($reglement->reference,['controller'=>'DevisFactures','action'=>'view', $facture->id]).'<br>';
                                            }
                                        }
                                    }

                                    if($link == $reglement->reference) {
                                        if(!empty($reglement->devis)){
                                            foreach ($reglement->devis as $devis) {
                                                if($reglement->reference == $devis->indent) {
                                                    $link = $this->Html->link($reglement->reference,['controller'=>'Devis','action'=>'view', $devis->id]).'<br>';
                                                }
                                            }
                                        }
                                    }

                                    echo $link;
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-4 m-t-5">Note</label>
                            <div class="col-md-8">
                                <?= $reglement->note ?>
                            </div>
                        </div>
                    </div>
                <a href="javascript:void(0);" class="btn pull-right btn-rounded btn-success" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client" data-reglement="<?= $reglement->id ?>" >Affecter à un autre client</a>
                <a href="<?= $this->Url->build(['action' => 'edit', $reglement->id]) ?>" class="btn pull-right btn-rounded btn-success m-r-5" >Modifier</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">

                <div class="row-fluid">
                    <h3 class="mb-4">Factures</h3>

                    <?php if (!empty($reglement->devis_factures)): ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Antenne</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th class="text-right">Montant HT</th>
                                    <th class="text-right">Montant TTC</th>
                                    <th class="text-right">Restant dû</th>
                                    <th>Etat</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($reglement->devis_factures as $key => $facture): ?>
                                <?php if( ! $facture->is_model) : ?>
                                    <tr>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $facture->get('ObjetAsTitle') ?>' href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>"><?= $facture->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $facture->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $facture->get('ListeAntennes'); ?></td>
                                        <td>
                                            <?php if ($facture->commercial) : ?>
                                                <img alt="Image" src="<?= $facture->commercial->url_photo ?>" class="avatar" data-title="<?= $facture->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>                                        
                                        </td>
                                        <td><?= $facture->created->format('d/m/Y') ?></td>
                                        <td class="text-right"><?= $facture->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $facture->get('TotalTtcWithCurrency') ?></td>
                                        <td class="text-right"><?= $facture->get('ResteEcheanceImpayee') ?></td>
                                        <td><i class="fa fa-circle <?= $facture->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$facture_status[$facture->status] ?>" data-original-title="Brouillon"></i> <?= @$facture_status[$facture->status] ?></td>
                                        <td class="<?= !$facture->is_in_sellsy?:'hide' ?>">
                                            <div class="dropdown d-inline container-ventes-actions">
                                                <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>" >Voir le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures','action' => 'view', $facture->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures','action' => 'add', $facture->id]) ?>">Modifier le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures','action' => 'pdfversion', $facture->id]) ?>" >Imprimer le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures','action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Reglements','action' => 'delieDocument', $reglement->id, 'factures',$facture->id]) ?>">dé-lier" le document</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php endforeach ?>
                            </thead>
                        </table>
                    <?php else: ?>
                        Aucune facture liée.
                    <?php endif ?>

                    <a class="btn pull-right btn-rounded btn-success <?= $reglement->type_court == 'C' ?: 'hide' ?>" data-toggle='modal' href='#solder_facture' data-client='<?= $reglement->client_id ?>' data-href="<?= $this->Url->build(['action' => 'solderFacture', $reglement->id]) ?>" data-reglement='<?= $reglement->get('ReglementAsJson') ?>'>Lier à des factures</a>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">

                <div class="row-fluid">
                    <h3 class="mb-4">Devis</h3>

                    <?php if (!empty($reglement->devis)): ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Antenne</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th class="text-right">Montant HT</th>
                                    <th class="text-right">Montant TTC</th>
                                    <th class="text-right">Restant dû</th>
                                    <th>Etat</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($reglement->devis as $key => $devis): ?>
                                <?php if( ! $devis->is_model) : ?>
                                    <tr>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $devis->get('ObjetAsTitle') ?>' href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>"><?= $devis->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $devis->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $devis->get('ListeAntennes'); ?></td>
                                        <td>
                                            <?php if ($devis->commercial) : ?>
                                                <img alt="Image" src="<?= $devis->commercial->url_photo ?>" class="avatar" data-title="<?= $devis->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>                                        
                                        </td>
                                        <td><?= $devis->created->format('d/m/Y') ?></td>
                                        <td class="text-right"><?= $devis->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $devis->get('TotalTtcWithCurrency') ?></td>
                                        <td class="text-right"><?= $devis->get('ResteEcheanceImpayee') ?></td>
                                        <td><i class="fa fa-circle <?= $devis->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devis->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_status[$devis->status] ?></td>
                                        <td class="<?= !$devis->is_in_sellsy?:'hide' ?>">
                                            <div class="dropdown d-inline container-ventes-actions">
                                                <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>" >Voir le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis','action' => 'view', $devis->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis','action' => 'add', $devis->id]) ?>">Modifier le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis','action' => 'pdfversion', $devis->id]) ?>" >Imprimer le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis','action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Reglements','action' => 'delieDocument', $reglement->id, 'devis',$facture->id]) ?>">dé-lier" le document</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php endforeach ?>
                            </thead>
                        </table>
                    <?php else: ?>
                        Aucun devis lié.
                    <?php endif ?>

                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">

                <div class="row-fluid">
                    <h3 class="mb-4">Avoirs</h3>

                    <?php if (!empty($reglement->avoirs)): ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Contact</th>
                                    <th>Date</th>
                                    <th class="text-right">Montant HT</th>
                                    <th class="text-right">Montant TTC</th>
                                    <th class="text-right">Restant dû</th>
                                    <th>Etat</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($reglement->avoirs as $key => $avoir): ?>
                                <?php if( ! $avoir->is_model) : ?>
                                    <tr>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $avoir->get('ObjetAsTitle') ?>' href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'view', $avoir->id]) ?>"><?= $avoir->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $avoir->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($avoir->commercial) : ?>
                                                <img alt="Image" src="<?= $avoir->commercial->url_photo ?>" class="avatar" data-title="<?= $avoir->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>                                        
                                        </td>
                                        <td><?= $avoir->created->format('d/m/Y') ?></td>
                                        <td class="text-right"><?= $avoir->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $avoir->get('TotalTtcWithCurrency') ?></td>
                                        <td class="text-right"><?= $avoir->get('ResteEcheanceImpayee') ?></td>
                                        <td><i class="fa fa-circle <?= $avoir->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_avoirs_status[$avoir->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_avoirs_status[$avoir->status] ?></td>
                                        <td class="<?= !$avoir->is_in_sellsy?:'hide' ?>">
                                            <div class="dropdown d-inline container-ventes-actions">
                                                <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'view', $avoir->id]) ?>" >Voir le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'view', $avoir->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'add', $avoir->id]) ?>">Modifier le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoir->id]) ?>" >Imprimer le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoir->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Reglements','action' => 'delieDocument', $reglement->id, 'devis',$facture->id]) ?>">dé-lier" le document</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php endforeach ?>
                            </thead>
                        </table>
                    <?php else: ?>
                        Aucun avoirs lié.
                    <?php endif ?>

                    <a class="btn pull-right btn-rounded btn-success <?= $reglement->type_court == 'C' ? 'hide' : '' ?>" data-toggle='modal' href='#solder_avoirs' data-client='<?= $reglement->client_id ?>' data-href="<?= $this->Url->build(['action' => 'solderAvoirs', $reglement->id]) ?>" data-reglement='<?= $reglement->get('ReglementAsJson') ?>'>Lier à des avoirs</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN MODAL -->
<div class="modal font-14" id="solder_facture" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
            <input type="hidden" id="position" value="bottom">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Lier à des factures</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <fieldset class="fieldset-info">
                                <input type="hidden" id="facture_client_id">
                                <legend class="legend-fieldset-info">Info paiement</legend>
                                <div class="row">
                                    <label class="col-md-4">Client :</label>
                                    <div class="col-md-8 client-nom">
                                        <?= $reglement->client->full_name ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Date</label>
                                    <div class="col-md-8 date-reglement">
                                        <?= @$reglement->date->format('d/m/Y') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Moyen de paiement</label>
                                    <div class="col-md-8 moyen-paiement">
                                        <?= @$moyen_reglements[$reglement->moyen_reglement_id] ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Montant</label>
                                    <input type="hidden" class="value-montant" value="0">
                                    <div class="col-md-8 montant">
                                        <?= $reglement->montant ?>
                                    </div>
                                </div>
                                <input type="hidden" class="hide rm_rglmt_solde_disponible" name="solde_disponible">
                            </fieldset>
                        </div>
                        <div class="col-md-7">
                            <fieldset class="fieldset-facture">
                                <legend class="legend-fieldset-facture">Facture(s) liée(s)</legend>
                                <table class="table table-striped facture-liee" id="div_table_facture">
                                    <thead>
                                        <tr>
                                            <th class="col_montantLie crm_mtlie hide">Montant lié</th>
                                            <th>N°</th>
                                            <th class="text-right">HT</th>
                                            <th class="text-left"></th>
                                            <th class="text-right">TTC</th>
                                            <th class="text-left"></th>
                                            <th class="text-right">Restant dû</th>
                                            <th class="text-left"></th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="default-data" id="id_listeFact">
                                    </tbody>
                                    <tfoot class="hide">
                                        <tr class="container-objet">
                                            <input type="hidden" required="true" class="facture_id">
                                            <td class="col_montantLie montant_lie crm_mtlie hide"><input type="text" name="montant_lie" class="crm_montantLie"></td>
                                            <td class="num"></td>
                                            <td class="ht text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td class="ttc text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td class="restant_du text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td><a href="#" class="removed"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="row col-md-6">
                                        <label class="col-md-6"><b>Total factures : </b></label>
                                        <div class="col-md-3 total-facture">
                                            0.00 €
                                        </div>
                                    </div>
                                    <div class="row col-md-6">
                                        <label class="col-md-3"><b>Reste : </b></label>
                                        <div class="col-md-4 rest-facture">
                                            0.00 €
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <input type="hidden" class="hide" name="resteRegelement" id="crm_resteRegelement">
                    <br><br>
                    <h3>Sélection de facture(s) </h3>
                    <hr>
                    
                    <div class="row custom-col-width">
                        <div class="col-md-3">
                            <?= $this->Form->control('indent', ['label' => false, 'placeholder' => 'Num facture']); ?>
                        </div>
                        <div class="col-md-4">
                            <input type="button" class="btn btn-primary" id="search-factures" value="Rechercher">
                            <div id="id_loader"></div>
                            <input type="reset" class="btn btn-dark" id="cancel-search" value="Annuler ma recherche">
                        </div>
                    </div>
                              
                    <div class="table-responsive clearfix" id="table-list">
                        <table class="table table-striped" id="div_table_bornes">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Etat</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th class="text-right">HT</th>
                                    <th class="text-right">TTC</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center">Rechercher pour afficher la liste</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
            <?= $this->form->end() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal font-14" id="solder_avoirs" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
            <input type="hidden" id="position" value="bottom">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Lier à des avoirs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <fieldset class="fieldset-info">
                                <input type="hidden" id="avoir_client_id">
                                <legend class="legend-fieldset-info">Info paiement</legend>
                                <div class="row">
                                    <label class="col-md-4">Client :</label>
                                    <div class="col-md-8 client-nom">
                                        <?= $reglement->client->full_name ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Date</label>
                                    <div class="col-md-8 date-reglement">
                                        <?= @$reglement->date->format('d/m/Y') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Moyen de paiement</label>
                                    <div class="col-md-8 moyen-paiement">
                                        <?= @$moyen_reglements[$reglement->moyen_reglement_id] ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Montant</label>
                                    <input type="hidden" class="value-montant" value="0">
                                    <div class="col-md-8 montant">
                                        <?= $reglement->montant ?>
                                    </div>
                                </div>
                                <input type="hidden" class="hide rm_rglmt_solde_disponible" name="solde_disponible">
                            </fieldset>
                        </div>
                        <div class="col-md-7">
                            <fieldset class="fieldset-facture">
                                <legend class="legend-fieldset-facture">Avoir(s) liée(s)</legend>
                                <table class="table table-striped avoir-liee" id="div_table_facture">
                                    <thead>
                                        <tr>
                                            <th class="col_montantLie crm_mtlie hide">Montant lié</th>
                                            <th>N°</th>
                                            <th class="text-right">HT</th>
                                            <th class="text-left"></th>
                                            <th class="text-right">TTC</th>
                                            <th class="text-left"></th>
                                            <th class="text-right">Restant dû</th>
                                            <th class="text-left"></th>
                                            <th width="10%"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="default-data-avoir" id="id_listeFact">
                                    </tbody>
                                    <tfoot class="hide">
                                        <tr class="container-objet">
                                            <input type="hidden" required="true" class="avoir_id">
                                            <td class="col_montantLie montant_lie crm_mtlie hide"><input type="text" name="montant_lie" class="crm_montantLie"></td>
                                            <td class="num"></td>
                                            <td class="ht text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td class="ttc text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td class="restant_du text-right"></td>
                                            <td class="unity text-left"></td>
                                            <td><a href="#" class="removed"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="row">
                                    <div class="row col-md-6">
                                        <label class="col-md-6"><b>Total avoirs : </b></label>
                                        <div class="col-md-3 total-avoir">
                                            0.00 €
                                        </div>
                                    </div>
                                    <div class="row col-md-6">
                                        <label class="col-md-3"><b>Reste : </b></label>
                                        <div class="col-md-4 rest-avoir">
                                            0.00 €
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <input type="hidden" class="hide" name="resteRegelement" id="crm_resteRegelement">
                    <br><br>
                    <h3>Sélection des avoirs </h3>
                    <hr>
                    
                    <div class="row custom-col-width">
                        <div class="col-md-3">
                            <?= $this->Form->control('indent', ['label' => false, 'placeholder' => 'Num avoir', 'id' => 'num_avoir']); ?>
                        </div>
                        <div class="col-md-4">
                            <input type="button" class="btn btn-primary" id="search-avoir" value="Rechercher">
                            <div class="loader"></div>
                            <input type="reset" class="btn btn-dark" id="cancel-search-avoir" value="Annuler ma recherche">
                        </div>
                    </div>
                              
                    <div class="table-responsive clearfix" id="table-list-avoir">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Etat</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th class="text-right">HT</th>
                                    <th class="text-right">TTC</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center">Rechercher pour afficher la liste</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
            <?= $this->form->end() ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['url' => ['action' => 'editClient'] ,'id' => 'edit_client_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Affecter à un autre client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%', "data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" name="reglement_id" id="reglement_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le client'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

