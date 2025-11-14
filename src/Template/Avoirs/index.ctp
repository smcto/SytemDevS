<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>
<?= $this->Html->css('avoirs/index.css?' . time(), ['block' => 'script']); ?>

<?= $this->Html->script('Clients/add.js?' . time(), ['block' => 'script']); ?>
<?= $this->Html->script('avoirs/index.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('moment.fr', ['block' => 'script']); ?>
<?= $this->Html->script('moment-range', ['block' => 'script']); ?>
<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('devis/liste_devis_et_factures.js?time='.time(), ['block' => true]); ?>

<?php

$titrePage = "Liste avoirs" ;

$customCheckBoxMultiSelect = [
    'nestingLabel' => '{{hidden}}<label{{attrs}} class="custom-control ml-3 px-2 m-0 custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',        
];

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$customFinderOptions[] = 'csv';
?>


<?php $this->start('actionTitle'); ?>
    <a class="btn pull-right hidden-sm-down btn-rounded btn-success create-avoir" data-toggle="modal" href="#add_avoirs" data-title="Créer un avoir" data-submit="Créer un avoir" data-href="<?= $this->Url->build(['action' => 'index']) ?>">Créer un avoir</a> 
    <a href="<?= $this->Url->build(array_filter($customFinderOptions)) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Exporter en csv</a>
    <!--a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn pull-right hidden-sm-down btn-rounded btn-primary mr-2">Liste factures manager</a> -->
<?php $this->end(); ?>

<!-- BEGIN MODAL -->

<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($avoirsEntity, ['url' => ['action' => 'editClient'] ,'id' => 'edit_client_form']); ?>
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
                                <input type="hidden" name="avoir_id" id="avoir_id">
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

<div class="modal fade" id="edit_commercial" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($avoirsEntity, ['url' => ['action' => 'editCommercial'] ,'id' => 'edit_commercial_form']); ?>
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
                                <input type="hidden" name="avoir_id" id="avoir_id">
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
        
<div class="modal fade" id="add_avoirs" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($avoirsEntity); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Créer un avoir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                            </div>
                        </div>

                        <fieldset class="fieldset-devis-factures">
                            <legend class="legend-fieldset-devis-factures">Paramètres du document:</legend>
                            
                            <div class="row row-client m-t-10">
                                <div class="col-md-3 m-t-10">
                                    <label class=""> Catégorie tarifaire </label>
                                </div>
                                <div class="col-md-9">
                                    <?= $this->Form->control('categorie_tarifaire', ['options' => $categorie_tarifaire, 'label' => false, 'empty' => 'Catégorie tarifaire']); ?>
                                </div>
                            </div>
                            <div class="row row-client m-t-30">
                                <div class="col-md-3 m-t-10">
                                    <label class=""> Type de document </label>
                                </div>
                                <div class="col-md-9">
                                    <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'id' => 'type_doc_id', 'label' => false, 'empty' => 'Type de document', 'required']); ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Créer un avoir'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
            <!--input type="hidden" id="id_inSellsy" value="<?= $is_in_sellsy ?>"-->
        </div>
    </div>
</div>


<div class="modal fade" id="facture_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état de l'avoir <span class="num_facture"></span></h5>
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


<div class="row" id="body_borne">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'mt-4 form-filtre']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="filter-list-wrapper avoir-filter-wrapper ">
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

                        <div class="filter-block container-mois <?= $periode == 'list_month' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('mois_id', ['label' => false, 'default' => $mois_id, 'options' => $mois, 'class' => 'selectpicker']); ?>
                        </div>
                        
                        <div class="filter-block container_date_threshold <?= $periode == 'custom_threshold' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false,'default' => $date_threshold,  'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('status', ['options' => $devis_factures_status, 'label' => false, 'default' => $status, 'class' => 'selectpicker', 'empty' => 'Etat', 'id'=>'id_status']); ?>
                        </div>
                        
                        <div class="filter-block">
                            <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'Type de document', 'default' => $type_doc_id]); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <div class="all-total-info-wrap">
                    <div class="text-uppercase">Total HT : <strong>  <?= $this->Utilities->formatCurrency($sumAvoirs->sumOf('total_ht')) ?></strong></div>
                    <div class="text-uppercase">Total TTC : <strong> <?= $this->Utilities->formatCurrency($sumAvoirs->sumOf('total_ttc')) ?></strong></div>
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
                        <table class="table table-striped liste-items table-avoirs" id="div_table_bornes">
                            <thead>
                                <tr>
                                    <th class="col-checkbox d-none"><?= $this->Form->control(false, ['type' => 'checkbox', 'label' => '', 'id' => 'select-all', 'templates' => $customCheckBoxMultiSelect]); ?></th>
                                    <th class="th-numero">N°</th>
                                    <th class="th-client">Client</th>
                                    <th>Facture</th>
                                    <th>Date</th>
                                    <th>Date événement</th>
                                    <th>Type</th> <!-- Corporation (pro) ou person (particulier) -->
                                    <th>Contact</th>
                                    <th class="th-montant text-right">HT</th>
                                    <th class="th-montant text-right">TTC</th>
                                    <th>Règlements</th>
                                    <th class="th-montant">Restant dû</th>
                                    <th class="th-etat">Etat</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listeAvoirs as $key => $avoirs) : ?>
                                    <tr>
                                        <td class="col-checkbox d-none"><?= $this->Form->control("avoirs.$avoirs->id", ['type' => 'checkbox', 'label' => '', 'id' => "checkbox-row-$key", 'checkox-item', 'templates' => $customCheckBoxMultiSelect]); ?></td>
                                        <td>
                                            <?php if (!$avoirs->is_in_sellsy): ?>
                                                <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $avoirs->get('ObjetAsTitle') ?>" href="<?= $this->Url->build(['action' => 'view', $avoirs->id]) ?>"><?= $avoirs->indent ?></a>
                                            <?php else: ?>
                                                <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $avoirs->get('ObjetAsTitle') ?>" href="<?= $this->Url->build($avoirs->get('SellsyDocUrl')) ?>"><?= $avoirs->indent ?></a>
                                                <?php if ($this->request->getQuery('test')): ?>
                                                    <a  href="<?= $avoirs->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </td>
                        
                                        <td>
                                            <?php if ($avoirs->client): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $avoirs->client->id]) ?>"><?= $avoirs->client->nom?></a>
                                            <?php else: ?>
                                                <?= $avoirs->client_nom ?>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $avoirs->devis_facture? $this->Html->link($avoirs->devis_facture->indent, ['controller' => 'DevisFactures', 'action' => 'view', $avoirs->devis_facture->id]) : '-'  ?></td>
                                        <td><?= $avoirs->date_crea? $avoirs->date_crea->format('d/m/y') : '-' ?></td>
                                        <td><?= $avoirs->date_evenement ?></td>
                                        <td><?= @$genres_short[$avoirs->client->client_type] ?? '' ?></td>
                                        <td> 
                                            <?php if ($avoirs->commercial) : ?>
                                                <img alt="Image" src="<?= $avoirs->commercial->url_photo ?>" class="avatar" data-title="<?= $avoirs->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php else : ?>
                                                --
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-right"><?= $avoirs->get('TotalHtWithCurrency') ?></td>
                                        <td class="text-right"><?= $avoirs->get('TotalTtcWithCurrency') ?></td>
                                        <td><?= $avoirs->avoirs_reglements?count($avoirs->avoirs_reglements):"--" ?></td>
                                        <td><?= $avoirs->get('ResteImpayee') ?> €</td>
                                        <td><div class="table-status-wrap"><i class="fa fa-circle <?= $avoirs->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_factures_status[$avoirs->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_factures_status[$avoirs->status] ?></div></td>
                                        <td>
                                            <?php if (!$avoirs->is_in_sellsy): ?>
                                                <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $avoirs->id]) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $avoirs->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'historique', $avoirs->id]) ?>" >Voir l'historique</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $avoirs->id, 1]) ?>">Modifier le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $avoirs->id]) ?>" target="_blank">Imprimer le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $avoirs->id]).'?force-generate=1' ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $avoirs->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <!--a class="dropdown-item" href="<?= $this->Url->build($avoirs->get('EncryptedUrl')) ?>">Voir la version web</a-->
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $avoirs->id]) ?>" data-value='<?= $avoirs->status ?>' data-indent='<?= $avoirs->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $avoirs->indent ?>)" data-avoir="<?= $avoirs->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $avoirs->indent ?>)" data-avoir="<?= $avoirs->id ?>" >Changer le commercial</a>
                                                        <a href="javascript:void(0);" class="dropdown-item duplicate-facture" data-toggle="modal" data-target="#add_avoirs" data-title="Dupliquer l'avoir" data-submit="Dupliquer" data-href="<?= $this->Url->build(['action' => 'duplicatAvoir', $avoirs->id]) ?>">Dupliquer le document</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $avoirs->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="dropdown d-inline container-ventes-actions">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="<?= $this->Url->build($avoirs->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $avoirs->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $avoirs->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                        <!--a class="dropdown-item" href="<?= $this->Url->build($avoirs->get('EncryptedUrl')) ?>">Voir la version web</a-->
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['action' => 'EditEtat', $avoirs->id]) ?>" data-value='<?= $avoirs->status ?>' data-indent='<?= $avoirs->indent ?>'>Modifier l'état</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $avoirs->indent ?>)" data-avoir="<?= $avoirs->id ?>" >Affecter à un autre client</a>
                                                        <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_commercial" data-title="Changer de commercial (<?= $avoirs->indent ?>)" data-avoir="<?= $avoirs->id ?>" >Changer le commercial</a>
                                                        <?php if ($this->request->getQuery('test')): ?>
                                                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $avoirs->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?= $this->form->end() ?>            
                <div class="mt-4 clearfix"><?= $this->element('tfoot_pagination') ?></div>
            </div>
        </div>
    </div>
</div>
