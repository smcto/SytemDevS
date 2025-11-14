<?= $this->Html->css(["https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css", ], ['block' => 'css'] ); ?>
<?= $this->Html->css('reglements/reglements.css?time='.time(), ['block' => 'css']); ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css', ['block' => 'css']); ?>


<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js', ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script(["summernote/js/summernote-lite.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script(["summernote/js/summernote-fr-FR.min.js", ], ['block' => 'script'] ); ?>
<?= $this->Html->script('reglements/reglements.js?time='.time(), ['block' => 'script']); ?>

<?php
$titrePage = "Règlements" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo "<a class='btn btn-rounded pull-right hidden-sm-down btn-success' data-toggle='modal' href='#add_reglement'>Créer</a>";
$this->end();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'form-filtre mt-4']); ?>
                    <div class="filter-list-wrapper reglement-filter-wrapper">
                        <div class="filter-block">
                            <?= $this->Form->control('key', ['label' => false, 'default' => $key, 'placeholder' => 'Rechercher']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('moyen_reglement_id', ['options' => $moyen_reglements, 'label' => false, 'default' => $moyen_reglement_id, 'class' => 'selectpicker', 'empty' => 'Paiement']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('user_id', ['options' => $commercials, 'label' => false, 'default' => $user_id, 'class' => 'selectpicker', 'empty' => 'Propriétaire']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('periode', ['label' => false, 'default' => $periode, 'options' => $periodes, 'class' => 'selectpicker periode', 'empty' => 'Période','id'=>'id_periode']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('info_bancaire_id', ['label' => false, 'default' => $info_bancaire_id, 'options' => $infosBancaires, 'class' => 'selectpicker', 'empty' => 'Banque']); ?>
                        </div>
                        
                        <div class="filter-block container_date_threshold col-md-3 <?= $periode == 'custom_threshold' ? '' : 'd-none' ?>">
                            <?= $this->Form->control('date_threshold', ['type' => 'text', 'label' => false,'value' => $date_threshold, 'class' => 'form-control date_threshold','id'=>'id_date_threshold']); ?>
                        </div>

                        <div class="filter-block col-md-3">
                            <?= $this->Form->control('has_facture', ['type' => 'select', 'label' => false,'value' => $has_facture, 'class' => 'form-control selectpicker', 'options' => [1 => 'Oui', 2 => 'Non'] , 'empty' => 'Avoir de(s) Facture(s)']); ?>
                        </div>
                        
                        <div class="filter-block col-md-3">
                            <?= $this->Form->control('type_doc_id', ['type' => 'select', 'label' => false,'value' => $type_doc_id, 'class' => 'form-control selectpicker', 'options' => $type_docs , 'empty' => 'Type documents']); ?>
                        </div>
                        
                        <div class="filter-block col-md-3">
                            <?= $this->Form->control('genre', ['type' => 'select', 'label' => false,'value' => $genre, 'class' => 'form-control selectpicker', 'options' => $genres , 'empty' => 'Type client']); ?>
                        </div>
                        
                        <div class="filter-block col-filter">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
                    
                <div class="table-responsive">
                    <table class="table table-reglements">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('type', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('date', 'Date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('contact_nom', 'Contact lié') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('InfosBancaires.nom', 'Banque') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('MoyenReglements.name_court', 'Paiement') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Users.prenom', 'Propriétaire') ?></th>
                            <th scope="col">Réference</th>
                            <th class="th-montant" scope="col"><?= $this->Paginator->sort('montant', 'Montant') ?></th>
                            <th class="th-montant" scope="col">Restant</th>
                            <th scope="col">Docs</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reglements as $reglement): ?>
                                <tr>
                                    <td><a href="<?= $this->Url->build(['action' => 'view', $reglement->id]) ?>"><i class="fa mr-3 <?= $reglement->type_court == 'C' ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger'?>"></i></a></td>
                                    <td><span data-toggle="tooltip" data-placement="top" title="<?= $reglement->date ? $reglement->date->format('H\h:i') : '-' ?>" ><?= $reglement->date ? $reglement->date->format('d/m/y') : '-' ?></span></td>
                                    <td><a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $reglement->client_id]) ?>"><?= $reglement->client? $reglement->client->full_name : ""?></a></td>
                                    <td><?= @$reglement->infos_bancaire->name?? '-' ?></td>
                                    <td><?= @$reglement->moyen_reglement->name_court ?></td>

                                    <td>
                                        <?php if ($reglement->user) : ?>
                                            <img alt="Image" src="<?= $reglement->user->url_photo ?>" class="avatar" data-title="<?= $reglement->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                        <?php else : ?>
                                            <img alt="Image" src="<?= $commercial->url_photo ?>" class="avatar" data-title="Automatique" data-toggle="tooltip" />
                                        <?php endif; ?>
                                    </td>
                                    <td>
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
                                            
                                            if($link == $reglement->reference) {
                                                if(!empty($reglement->avoirs)){
                                                    foreach ($reglement->avoirs as $avoir) {
                                                        if($reglement->reference == $avoir->indent) {
                                                            $link = $this->Html->link($reglement->reference,['controller'=>'Avoirs','action'=>'view', $avoir->id]).'<br>';
                                                        }
                                                    }
                                                }
                                            }
                                            
                                            echo $link;
                                        ?>
                                    </td>
                                    <td><?= $this->Utilities->formatCurrency($reglement->montant) ?></td>
                                    <!-- <td><?= $reglement->solde_disponible ?? 0; ?></td> -->
                                    <td>
                                        <?php
                                            if(!empty($reglement->devis_factures)){
                                                //debug($reglement->devis_factures);
                                                foreach ($reglement->devis_factures as $facture) {
                                                    //debug($facture->get('ResteEcheanceImpayee'));
                                                    echo $this->Html->link($this->Utilities->formatCurrency($facture->get('ResteEcheanceImpayee')),['controller'=>'DevisFactures','action'=>'view', $facture->id]).'<br>';
                                                }
                                            }else{
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $reglement->get('CountLinkedDocs') ?></td>
                                    <td>
                                        <div class="dropdown d-inline container-actions inner-table-menu">
                                            <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $reglement->id, $reglement->parc_id]) ?>">Voir</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'edit', $reglement->id]) ?>">Modifier</a>
                                                <a class="dropdown-item <?= $reglement->type_court == 'C' ?: 'hide' ?>" data-toggle='modal' href='#solder_facture' data-client='<?= $reglement->client_id ?>' data-href="<?= $this->Url->build(['action' => 'solderFacture', $reglement->id]) ?>" data-reglement='<?= $reglement->get('ReglementAsJson') ?>'>Lier à des factures</a>
                                                <a class="dropdown-item <?= $reglement->type_court == 'C' ? 'hide' : '' ?>" data-toggle='modal' href='#solder_avoirs' data-client='<?= $reglement->client_id ?>' data-href="<?= $this->Url->build(['action' => 'solderAvoirs', $reglement->id]) ?>" data-reglement='<?= $reglement->get('ReglementAsJson') ?>'>Lier à des avoirs</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client" data-reglement="<?= $reglement->id ?>" >Affecter à un autre client</a>
                                                <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $reglement->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
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
                                        Nom client
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Date</label>
                                    <div class="col-md-8 date-reglement">
                                        Date
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Moyen de paiement</label>
                                    <div class="col-md-8 moyen-paiement">
                                        Moyen
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Montant</label>
                                    <input type="hidden" class="value-montant" value="0">
                                    <div class="col-md-8 montant">
                                        Montant
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <label class="col-md-4">Reste à solder</label>
                                    <input type="hidden" class="value-rest" name="montant_restant" value="0">
                                    <div class="col-md-8 rest">
                                        0.00
                                    </div>
                                </div> -->
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
                                        Nom client
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Date</label>
                                    <div class="col-md-8 date-reglement">
                                        Date
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Moyen de paiement</label>
                                    <div class="col-md-8 moyen-paiement">
                                        Moyen
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-md-4">Montant</label>
                                    <input type="hidden" class="value-montant" value="0">
                                    <div class="col-md-8 montant">
                                        Montant
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

<?= $this->element('Reglement/add') ?>
