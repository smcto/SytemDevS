<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('ventes/index.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>    
<?= $this->Html->script('ventes/index.js?'.time(), ['block' => true]); ?>
<?= $this->Html->script('ventes/affectationbornes.js?'.time(), ['block' => true]); ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>

<?php 
    $titrePage = $vente_statut == null ? "Liste des ventes à traiter" : ($vente_statut == 'expedie' ? "Liste des ventes expédiées" : '') ;
    $titreList = $vente_statut == null ? "Ventes à traiter" : ($vente_statut == 'expedie' ? "Ventes expédiées" : 'Liste des ventes') ;
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titreList]);
    $this->end();   
?>

<?php $this->start('actionTitle'); ?>
    <?php $this->Html->link('Liste des ventes consommables', ['controller' => 'VentesConsommables', 'action'=> 'index'], ['escape'=>false, "class"=>"btn ml-2 btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php if ($vente_statut == null): ?>
        <?= $this->Html->link('Ventes expédiées', ['action' => 'index', 'expedie'], ['escape' => false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
        <?= $this->Html->link('Ajouter', ['action'=>'add', true], ['escape' => false, "class" => "btn btn-rounded pull-right hidden-sm-down btn-success mr-2" ]); ?>
    <?php else: ?>
        <?= $this->Html->link('Ventes à traiter', ['controller' => 'ventes'], ['escape' => false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-primary" ]); ?>
    <?php endif ?>
    <?php $this->Html->link('Créer vente consommable', ['controller' => 'VentesConsommables', 'action'=> 'add'], ['escape'=>false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-success mr-2" ]); ?>
<?php $this->end(); ?>

<?php $this->start('detailNbGamme') ?>
    <?php foreach ($groupedGammesBornes as $key => $gammeBorne): ?>
        <?= $gammeBorne->name ?> : <?= $gammeBorne->nb ?> ,
    <?php endforeach ?>
    Total : <?= $groupedGammesBornes->sumOf('nb') ?>
<?php $this->end() ?>


<div class="modal fade" id="change-state" role="dialog">
    <div class="modal-dialog modal-lg">

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
                        <?= $this->Form->select('vente_statut', $vente_statuts, ['required', 'empty' => 'Seléctionner', 'class' => 'selectpicker vente_statut']); ?>
                    </div>

                    <div class="form-group is_expedie d-none">
                        <label for="date_depart_atelier">Date de départ de l'atelier *</label>
                        <?= $this->Form->text('date_depart_atelier', ['type' => 'date', 'id' => 'date_depart_atelier']); ?>
                    </div>

                    <div class="form-group is_expedie d-none">
                        <label for="date_depart_atelier">Date de réception du client *</label>
                        <?= $this->Form->text('date_reception_client', ['type' => 'date', 'id' => 'date_reception_client']); ?>
                    </div>

                    <div class="form-group is_expedie d-none">
                        <div class="row-fluid ">
                            <?= $this->Form->control('bon_de_livraison', ['id' => 'bon_de_livraison', 'label'=> 'Bon de livraison (fichier au format PDF)', 'class'=>'dropify-fr', 'type' => 'file', 'data-allowed-file-extensions'=> 'pdf', 'data-default-file' => '']) ?>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save">Enregistrer</button>
                </div>
            </div>
        <?= $this->form->end() ?>

    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row-fluid d-block clearfix">
                    <div class="float-right my-auto ">
                        <?= $this->App->omitLastVirg($this->fetch('detailNbGamme')) ?>
                    </div>
                </div>
                <hr>
                
                <?= $this->Form->create(null, ['type' => 'GET', 'role'=>'form']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="filter-list-wrapper vente-filter-wrapper">
                        <div class="filter-block">
                            <?= $this->Form->control('numero', ['label' => false, 'default' => $numero, 'class' => 'form-control', 'placeholder' => 'Numéro borne']); ?>
                        </div>

                        <div class="filter-block">
                            <?= $this->Form->control('client', ['default' => $client_id, 'options' => $clientsCorporations, 'empty' => 'Client', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                        </div>
                        
                        <div class="filter-block">
                            <?= $this->Form->control('groupe_client', ['default' => $groupe_client_id, 'options' => $groupeClients, 'empty' => 'Réseau client', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                        </div>
                        
                        <div class="filter-block">
                            <?= $this->Form->control('user', ['default' => $user_id, 'options' => $users, 'empty' => 'Commercial', 'label' => false, 'data-live-search' => true, 'class' => 'form-control selectpicker']); ?>
                        </div>
                        
                        <?php if ($vente_statut == null) : ?>
                            <div class="filter-block">
                                <?= $this->Form->select('vente_statut', $vente_statuts_filtre, ['default' => $statut_vente ,'empty' => 'Etat', 'class' => 'selectpicker vente_statut']); ?>
                            </div>
                        <?php endif; ?>


                        <!--div class="filter-block">
                            <?= $this->Form->control('numero_devis', ['label' => false, 'default' => $ident, 'class' => 'form-control', 'placeholder' => 'Numéro devis']); ?>
                        </div-->

                        <div class="filter-block">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
                    
                <?php if($vente_statut == null) { ?>
                    
                    <div class="row m-t-5">
                        <?php foreach ($countVentes as $key => $nombre) : 
                            if($key != 'expedie') {
                                    $couleur = str_replace('text-', 'card-', $vente_statut_couleurs[$key]);
                                    $groupedNombre = "";
                                    ?>
                                    <!-- Column -->
                                    <div class="col-md-6 col-lg-4 col-xlg-4">
                                        <div class="card card-inverse <?= $couleur ?>">
                                            <div class="box text-center">
                                                    <?php if($nombre['total'] > 1) { ?>
                                                    <h1 class="font-light text-white"><?= $this->Number->format($nombre['total']) ?></h1><h6 class="text-white"><?=@$vente_statuts[$key]?></h6>
                                                    <?php } ?>
                                                    <?php if($nombre['total'] <= 1) {?>
                                                    <h1 class="font-light text-white"><?= $this->Number->format($nombre['total']) ?></h1><h6 class="text-white"><?=@$vente_statuts[$key]?></h6>
                                                    <?php } ?>
                                                    
                                                    <?php 
                                                            foreach ($nombre['parGamme'] as $key => $gammeBorne) {
                                                                $groupedNombre .= $gammeBorne->name .' : ' . $this->Number->format($gammeBorne->nb) . ' - ';
                                                            } 
                                                            $groupedNombre = substr($groupedNombre, 0,-2);
                                                    ?>
                                                    
                                                    <p class="text-white"><?= $groupedNombre ?></p>
                                            </div>
                                        </div>
                                    </div>
                        <?php } endforeach; ?>
                    </div>
                    
                <?php } ?>
                    

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">Vente</th>
                                <th width="5%">Gamme</th>
                                <th width="5%">Borne</th>
                                <th width="8%">Enseigne</th>
                                <th width="8%">Destination</th>
                                <th width="5%">Livraison</th>
                                <th width="5%">Com.</th>
                                <th width="8%" class="<?= $vente_statut != 'expedie' ? 'd-none' : '' ?>">Date départ atelier</th>
                                <th width="8%" class="<?= $vente_statut == 'expedie' ? 'd-none' : '' ?>">Règlement</th>
                                <th width="8%">Date ajout</th>
                                <th width="12%">Date souhaitée</th>
                                <th width="12%">Etat</th>
                                <th width="5%">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php  foreach ($ventes as $key => $vente): ?>
                                <tr>
                                    <td><a href="<?= $this->Url->build(['action' => 'view', $vente->id]) ?>"><?= $vente->id ?></a></td>
                                    <td><?= $vente->has('gammes_borne') ? $vente->gammes_borne->name : '' ?></td>
                                    <td><?= $vente->borne != null ? $this->Html->link($vente->borne->model_borne->gammes_borne->notation . $vente->borne->numero, ['controller' => 'Bornes', 'action'=> 'view', $vente->borne->id]) : '--' ?></td>
                                    <td>
                                        <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $vente->client->id]) ?>">
                                            <?= ($vente->client ? (!empty($vente->client->enseigne) ? $vente->client->enseigne : $vente->client->nom) : "")  ?>
                                        </a>
                                    </td>
                                    <td><?= $vente->has('parc') ? $vente->parc->nom2 : '' ?></td>
                                    <td><?= $vente->has('parc') ? $vente->get('lieu_livraison') : '' ?></td>
                                    <td>
                                        <?php if ($vente->user != null) : ?>
                                            <img alt="Image" src="<?= $vente->user->url_photo ?>" class="avatar" data-title="<?= $vente->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                        <?php else : ?>
                                        --
                                        <?php endif; ?>
                                    </td>
                                    <td class="<?= $vente_statut != 'expedie' ? 'd-none' : '' ?>"><?= $vente->date_depart_atelier ?></td>
                                    <td class="<?= $vente_statut == 'expedie' ? 'd-none' : '' ?>"><?= @$vente_etat_facturations[$vente->etat_facturation] ?></td>
                                    <td><?= $vente->created->format('d/m/Y') ?></td>
                                    <td><?= $vente->livraison_is_as_soon_as_possible == 1 ? 'Dès que possible' : ($vente->livraison_date ? $vente->livraison_date->format('d/m/Y') : '') ?></td>
                                    <td><div class="table-status-wrap"><i class="fa fa-circle <?= @$vente_statut_couleurs[$vente->vente_statut] ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$vente_statuts[$vente->vente_statut] ?>" data-original-title="Attente de traitement"></i> <?= @$vente_statuts[$vente->vente_statut] ?:"Attente de traitement"?></div></td>
                                    <td>
                                        <div class="dropdown d-inline container-ventes-actions inner-table-menu">
                                            <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                <a href="javascript:void(0);" class="dropdown-item btn-borne" data-parcname="<?=$vente->parc!=null?'Borne ' . $vente->parc->nom:'La vente ne coorespond pas à une parc'?>" data-parc="<?=$vente->parc_id?>" data-id="<?=$vente->id?>" data-value="<?=$vente->borne_id?>" data-valuename="<?=$vente->borne!=null?$vente->borne->model_borne->gammes_borne->notation.$vente->borne->numero:''?>" data-toggle="modal" data-target="#affectation-borne" data-gamme-name="<?= $vente->gammes_borne? ', Gamme ' . $vente->gammes_borne->name:''?>" data-gamme="<?= $vente->gamme_borne_id?>">Affecter borne</a>
                                                <a href="javascript:void(0);" class="dropdown-item change-state" data-vente-statut="<?= $vente->vente_statut ?>" data-departatelier="<?= $vente->date_depart_atelier ? $vente->date_depart_atelier->format('Y-m-d') : ''; ?>" data-id="<?= $vente->id ?>"  data-receptionclient="<?= $vente->date_reception_client ? $vente->date_reception_client->format('Y-m-d') : ''; ?>" data-id="<?= $vente->id ?>" data-action="<?= $this->Url->build(['action' => 'majState', $vente->id]) ?>" data-toggle="modal" data-target="#change-state" data-bondelivraison="<?= $this->Url->build($vente->get('bon_de_livraison_path')) ?>">Modifier état</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'edit', $vente->id]) ?>">Modifier fiche</a>
                                                <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $vente->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>


                <!-- Modal affectation borne -->
                <?= $this->element('vente/affectation_borne') ?>
  
            </div>
        </div>
    </div>
</div>
  
<script type="text/javascript">
    var bornes = <?php echo json_encode($bornes); ?>;
</script>
