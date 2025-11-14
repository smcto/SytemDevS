<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>
<?= $this->Html->css('devisFactures/add-client-in-devis.css?time='.time(), ['block' => true]); ?>
<?= $this->Html->css('devisFactures/index.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('contacts/contact_form.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('customized-elements/popup-container.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('devisFactures/popup-late-payment.css?' . time(), ['block' => 'script']); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('devisFactures/index.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('moment-range', ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('customized-elements/popup-container.js?time='.time(), ['block' => true]); ?>

<?= $this->Html->script('devisFactures/popup-late-payment.js?time='.time(), ['block' => true]); ?>


<?php

$titrePage = "Factures en retard" ;

$this->assign('title', 'Factures en retard');

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$customCheckBoxMultiSelect = [
    'nestingLabel' => '{{hidden}}<label{{attrs}} class="custom-control ml-3 px-2 m-0 custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',
]
?>


<?php $this->start('actionTitle'); ?>

    <!--a class="btn pull-right hidden-sm-down btn-rounded btn-success create-facture" data-toggle="modal" href="#add_devis_factures" data-title="Créer une factures" data-submit="Créer une facture" data-href="<?= $this->Url->build(['action' => 'index']) ?>">Créer une facture</a> -->
    <!-- <a href="<?= $this->Url->build([1]) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste factures</a>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste factures manager</a> -->
<?php $this->end(); ?>

<!-- BEGIN MODAL -->
<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'editClient'] ,'id' => 'edit_client_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Affecter à un autre client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id">
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

<div class="modal fade" id="form_client_2" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'lierClient2'] ,'id' => 'client_2_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Lier à un 2ème client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id_2', ['options' => [], 'empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id_2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Lier '), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<div class="modal fade" id="edit_commercial" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['action' => 'editCommercial'] ,'id' => 'edit_commercial_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Changer de commercial </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Commercial : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'empty' => 'Sélectionner', 'class' => 'selectpicker form-control', 'data-live-search' => true, 'label' => false,'style' => 'width:100%', 'id' => 'edit_commercial_id']) ?>
                                <input type="hidden" name="facture_id" id="facture_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le commercial'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<div class="modal fade" id="facture_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état de la factures <span class="num_facture"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mt-2 m-b-30">
                            <label>Etat : </label>
                        </div>
                        <div class="col-md-8 existing-client">
                            <?= $this->Form->control('status', ['id' => 'modif_status', 'options' => $devis_factures_status, 'empty' => 'Sélectionner', 'label' => false,'required']) ?>
                        </div>
                        <input type="hidden" value='<?= json_encode($customFinderOptions) ?>' name="paramsurl">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<?= $this->element('devis_et_factures/popup_edit_type_doc') ?>

<div class="row" id="body_borne">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'mt-4 form-filtre']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="filter-list-wrapper facture-filter-wrapper">
                        <div class="filter-block">
                            <?= $this->Form->control('keyword', ['label' => false, 'default' => $keyword, 'class' => 'form-control', 'placeholder' => 'Rechercher','id'=>'id_keyword']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => false, 'default' => $ref_commercial_id, 'class' => 'selectpicker', 'empty' => 'Contact','id'=>'id_ref_commercial_id']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('client_type', ['label' => false, 'options' => $genres, 'default' => $client_type, 'class' => 'selectpicker', 'empty' => 'Type','id'=>'id_client_type']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('antenne_id', ['label' => false, 'default' => $antenne_id, 'class' => 'selectpicker', 'data-live-search' => true, 'empty' => 'Antennes','id'=>'id_antenne_id']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('periode', ['label' => false, 'default' => $periode, 'options' => $periodes, 'class' => 'selectpicker periode', 'empty' => 'Période','id'=>'id_periode']); ?>
                        </div>

                        <div class="filter-block container_date_threshold <?= $periode == 'custom_threshold' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false, 'default' => $date_threshold, 'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
                        </div>

                        <div class="filter-block container-mois <?= $periode == 'list_month' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('mois_id', ['label' => false, 'default' => $mois_id, 'options' => $mois, 'class' => 'selectpicker']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'Type de document', 'default' => $type_doc_id]); ?>
                        </div>
                        
                        <div class="filter-block">
                            <?= $this->Form->control('progression', ['options' => $progressions, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'État de la relance ', 'default' => $progression]); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>

                <?= $this->Form->end(); ?>

                <div class="all-total-info-wrap">
                    <div class="text-uppercase">Nombre de factures : <strong> <?= $this->Paginator->counter('{{count}}');?></strong></div>
                    <div class="text-uppercase">Total : <strong> <?= $this->Utilities->formatCurrency($sumFactures->sumOf('total_ht')) ?> HT / <?= $this->Utilities->formatCurrency($sumFactures->sumOf('total_ttc')) ?> TTC </strong></div>
                </div>
                <div class="clearfix"></div>
        
                <?= $this->Form->create(false, ['url' => ['action' => 'multipleAction'], 'class' => '']); ?>
                    <div class="row bloc-actions selection-table-action d-none">
                        <div class="action-block">
                            <?= $this->Form->control('action', ['options' => ['zip' => 'Télécharger au format ZIP'], 'type' => 'select', 'label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner une action']); ?>
                        </div>
                        <div class="action-block">
                            <?= $this->Form->submit('Valider', ['class' => 'btn btn-primary']); ?>
                        </div>
                    </div>

                    <div class="btn-tbl-select-element clearfix">
                        <a href="javascript:void(0);" class="active-col-checkbox float-right">Sélectionner des éléments</a>
                    </div>

                    <div class="table-responsive clearfix">
                        <table class="table table-striped liste-items table-factures" id="div_table_bornes">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th class="th-numero"><?= $this->Paginator->sort('DevisFactures.indent', 'N°') ?></th>
                                    <th class="th-client"><?= $this->Paginator->sort('Clients.nom', 'Client') ?></th>
                                    <th><?= $this->Paginator->sort('DevisFactures.created', 'Date') ?></th>
                                    <th class="th-antenne">Doit régler</th>
                                    <th><?= $this->Paginator->sort('Commercial.nom', 'Com') ?></th>
                                    <th class="th-montant text-right"><?= $this->Paginator->sort('total_ht', 'HT') ?></th>
                                    <th class="th-montant text-right"><?= $this->Paginator->sort('total_ttc', 'TTC') ?></th>
                                    <th class="th-montant">Restant dû</th>
                                    <th class="th-etat"><?= $this->Paginator->sort('status', 'Etat') ?></th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($listeDevisFactures as $key => $facture){
                                ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><?= $this->Form->control("devis_factures.$facture->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                        <td>
                                            <a data-toggle="tooltip" data-html="true" data-placement="top" href="javascript:void(0);" class="popup-detail" data-facture="<?= $facture->id ?>" ><?= $facture->indent ?></a>
                                            <?php if ($this->request->getQuery('test')): ?>
                                                <a  href="<?= $facture->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?php if ($facture->client): ?>
                                            
                                                <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client->id]) ?>"><?= $facture->client->full_name?></a>
                                                <?php if ($facture->client2): ?>
                                                
                                                    <br>Lié à <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client2->id]) ?>"><?= $facture->client2->full_name ?></a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                    
                                                <?= $facture->client_nom ?>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $facture->date_crea? $facture->date_crea->format('d/m/y') : "-" ?></td>
                                        <td><?= $facture->date_prevu_echeance ? $facture->date_prevu_echeance->format('d M Y') : "-" ?></td>
                                        <td>
                                            <?php if ($facture->commercial) : ?>
                                                <img alt="Image" src="<?= $facture->commercial->url_photo ?>" class="avatar" data-title="<?= $facture->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right"><?= $facture->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $facture->get('TotalTtcWithCurrency') ?></td>
                                        <td><?= $facture->reste_echeance_impayee ?> €</td>
                                        <td><div class="table-status-wrap"><i class="fa fa-circle <?= $facture->progression ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$progressions[$facture->progression] ?>" data-original-title="En retard"></i> <?= @$progressions[$facture->progression] ? : 'En retard' ?></div></td>
                                        <td>
                                            <?php if (!$facture->is_in_sellsy): ?>
                                                <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $facture->id]) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'historique', $facture->id]) ?>" >Voir l'historique</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $facture->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $facture->id, 1]) ?>">Modifier le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]) ?>" target="_blank">Imprimer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]).'?forceGenerate=1' ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $facture->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#form_client_2" data-title="Lier à un 2ème client (<?= $facture->indent ?>)" data-devi="<?= $facture->id ?>" >Lier à un 2ème client </a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Changer le commercial</a>
                                                        <a href="javascript:void(0);" class="dropdown-item duplicate-facture" data-toggle="modal" data-target="#add_devis_factures" data-title="Dupliquer la facture" data-submit="Dupliquer" data-href="<?= $this->Url->build(['action' => 'duplicatFacture', $facture->id]) ?>">Dupliquer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'toAvoir', $facture->id]) ?>">Convertir en avoir</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $facture->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#form_client_2" data-title="Lier à un 2ème client (<?= $facture->indent ?>)" data-devi="<?= $facture->id ?>" >Lier à un 2ème client </a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $facture->indent ?>)" data-facture="<?= $facture->id ?>" >Changer le commercial</a>

                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?= $this->form->end() ?>

                <div class="mt-4 clearfix"><?= $this->element('tfoot_pagination') ?></div>
            </div>
        </div>
    </div>
</div>



<!-- === Pipeline Loader Container === -->
<div class="pipeline-large-loader-container">
    <div class="loading-spinner"></div>
</div>
<!-- === End of Pipeline Loader Container === -->


<!-- === Late Popup Container === -->

<div class="popup-container late-payment-popup-container">

    <div class="outer-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

        <div class="inner-popup-container customized-scrollbar white-background-scrollbar details-facture-client">
            
        </div>

    </div>

</div>

<!-- === End of Late Popup Container === -->


<!-- === Client Contact Popup Container === -->

<div class="popup-container small-popup-container client-contact-popup-container">


</div>

<!-- === End of Client Contact Popup Container === -->



<!-- === Add Comment Popup Container === -->

<div class="popup-container add-comment-popup-container">

    <div class="outer-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

        <div class="inner-popup-container customized-scrollbar white-background-scrollbar">

            <div class="title">
                Ajouter un commentaire
            </div>
                        
            <div class="outer-attach-file-wrapper hide">
                
                <div class="form-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Titre" id="titre_commentaire">
                    <input type="text" name="id" class="form-control" placeholder="id" id="id_commentaire">
                </div>
            </div>

            <div class="comment-content-container">

                <textarea class="comment-editor" id="content_commentaire"></textarea>

            </div>

            <div class="bottom-submit-btn-wrap">
                <div class="btn-validate" id="btn-add-comment">
                    Ajouter
                </div>
                <div class="btn-validate" id="btn-update-comment">
                    Modifier
                </div>
            </div>

        </div>

    </div>

</div>

<!-- === End of Add Comment Popup Container === -->




<script type="text/javascript">
    var modelDevisFactures = <?php echo json_encode($modelDevisFactures); ?>;
    var modelSousCategories = <?php echo json_encode($modelSousCategories); ?>;
</script>
