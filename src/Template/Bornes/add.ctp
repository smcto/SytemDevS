<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>

<?= $this->Html->css('borne.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

    
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('bornes/add.js?'.time(), ['block' => true]); ?>
<?= $this->Html->script('bornes/protections.js?'.time(), ['block' => true]); ?>

<?php
$titrePage = "Ajout d'une nouvelle borne" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Bornes',
    ['controller' => 'Bornes', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->assign('title', 'Ajout borne');

?>

<!-- Modal -->
<div class="modal fade modal-equipement-protection" id="modal-protection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajout protection(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-type-equipements form-filtre','role'=>'form', 'url' => ['controller' => 'AjaxVentes', 'action' => 'findTypeEquipementsProtections']]); ?>
                    <div class="row">

                        <div class="col-md-2">
                            <?= $this->Form->control('keyword', ['empty' => 'Gamme', 'label' => false, 'placeholder' => 'Rechercher par nom']); ?>
                        </div>

                        <div class="col-md-2">
                            <?= $this->Form->control('parc_id', ['label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner type borne']); ?>
                        </div>

                        <div class="col-md-2 container-bornes d-none">
                            <?= $this->Form->control('borne_id', ['label' => false, 'class' => 'selectpicker','data-live-search' => true, 'empty' => 'Borne']); ?>
                        </div>

                        <div class="col-md-3 p-l-0">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark reset", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-liste-equipements','role'=>'form']); ?>
                    <div class="clearfix container-type-equipements">
                        <!-- JS / AJAX -->
                        <?= $this->element('../AjaxVentes/find_type_equipements_protections') ?>
                        <p class="all-equips-selected d-none">Tous les types d'équipements ont été sélectionnés</p>
                    </div>

                    <!-- insérer notion de choix mulitples  -->
                    <div class="clearfix bloc-selected-products d-none w-100 mt-3">
                        <p class="m-0">Protections(s) sélectionné(s)</p>
                        <table class="table div_table_selected_produits">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th scope="col" class="d-none">Modèles</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody class="selected-produits">
                                <!-- JS -->
                            </tbody>

                            <tfoot class="d-none">
                                <tr>
                                    <td class="d-none selected-product">
                                        <!-- JS -->
                                    </td>
                                    <td class="nom"></td>
                                    <td class="select-equipm d-none"></td>
                                    <td class="qty-equipm d-none"></td>
                                    <td class="type-equipm-id d-none"></td>
                                    <td colspan="3"><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?= $this->Form->end(); ?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary btn-rounded submit">Valider</button>
            </div>
        </div>
    </div>
</div>

<?= $this->Form->create($borne) ?>
    <div class="card card-outline-info">
        <div class="card-header d-none">
            <h4 class="m-b-0 text-white">Informations générales</h4>
        </div>
        <div class="card-body">
            <h2 >Descriptif borne</h2>

            <div class="row p-t-20">
                <div class="col-md-6">
                    <?php echo $this->Form->control('numero',['label' => 'Numéro *','type'=>'number','required' => 'required']); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->control('parc_id',['id'=>'id_parc','label' => 'Parc destination * ','options'=>$parcs,'empty'=>'Séléctionner','required' => 'required']); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3" id="id_couleurs_possible">
                    <?php echo $this->Form->control('couleur_id', [
                    'id'=>'couleurs_possible_id',
                    'options'=>$couleurPossible,
                    'label'=>__('Couleur *'),
                    'empty'=>'Séléctionner',
                    'required'=>true]); ?>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="gamme">Gamme</label>
                        <select class="custom-select" name="gamme" id="gamme">
                            <option value="0">Séléctionner</option>
                            <?php foreach ($gammeBornes as $id => $nom) : ?>
                            <option value="<?= $id; ?>"> <?= $nom; ?> </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div id="id_loader" class="loader-borne"></div>
                <div class="col-md-3">
                    <?php echo $this->Form->control('model_borne_id',['id'=>'model_borne_id','label' => 'Modèle *', 'options'=>[],'empty'=>'Séléctionner', 'required' => 'required']); ?>
                </div>
                <div class="col-md-3">
                    <?php echo $this->Form->control('statut',[
                    'label' => 'Statut *',
                    'options'=>$statuts,
                    'empty'=>'Séléctionner',
                    'required'=>true]); ?>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-3">
                    <?php echo $this->Form->control('etat_borne_id', ['id' => 'etat_borne_id', 'label' => 'Etat général', 'options' => $etat_bornes, 'empty' => 'Séléctionner']); ?>
                </div>
                <div class="col-md-3">
                    <?php echo $this->Form->control('marque',['label' => 'Marque','empty'=>'Séléctionner', 'options'=>$marques ]); ?>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Date de sortie atelier</label>
                        <input type="date" id="sortie_atelier" name="sortie_atelier" class="form-control" placeholder="dd/mm/yyyy">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Opérateur</label>
                        <?= $this->Form->control('user_id',['label' => false,'empty'=>'Séléctionner', 'options'=> $users, 'class' => 'form-control select2']); ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Gravure </label>
                        <?= $this->Form->control('gravure',['label' => false,'empty'=>'Séléctionner', 'options'=> ['Non', 'Oui']]); ?>
                    </div>
                </div>
            </div>
                
            <div class="row">
                <div class="col-md-6 sous-loc hide">
                    <?php
                        $is_sous_louee = array('0' => 'Non', '1' => 'Oui');
                        echo $this->Form->control('is_sous_louee', [
                        'id' => 'is_sous_louee',
                        'label' => 'Sous location',
                        'options' => $is_sous_louee,]);
                    ?>
                </div>
                <div class="col-md-6  hide antenne-loc">
                    <?php
                        echo $this->Form->control('antenne_loc', [
                        'label' => 'Antenne',
                        'empty' => 'Séléctionner',
                        'options' => $antennes,
                        'value' => $borne->antenne_id,
                        "class" => "form-control select2",
                        "data-placeholder" => "Choisir",
                        'style' => 'width:100%'
                        ]);
                    ?>
                </div>
            </div>

            <h2  class="client-id hide">Client</h2>
            <div class="row p-t-20 client-id hide">
                <div class="col-md-6">
                    <?php echo $this->Form->control('client_id',[
                        'label' => 'Client',
                        'options' => $clients,
                        "empty"=>"Séléctionner",
                        "class"=>"form-control select2",
                        "data-placeholder"=>"Choisir",
                        'style' => 'width:100%'
                    ]); ?>
                </div>
                
                <div class="col-md-6 hide">
                    <?php echo $this->Form->control('groupe_client',[
                        'label' => 'Groupe',
                        'options' => $groupeClients,
                        "empty"=>"Séléctionner",
                        "class"=>"form-control",
                        'style' => 'width:100%'
                    ]); ?>
                </div>
                
            </div>

            <h2  class="antenne-id hide">Parc</h2>
            <div class="row p-t-20 antenne-id hide">
                <div class="col-md-12">
                    <?php echo $this->Form->control('antenne_id',[
                        'label' => 'Antenne',
                        'options' => $antennes,
                        "empty"=>"Séléctionner",
                        "class"=>"form-control select2",
                        "data-placeholder"=>"Choisir",
                        'style' => 'width:100%'
                    ]); ?>
                </div>
            </div>
            
            <h2 >Equipements</h2>
            
            <div id="dev-equipement">
                Aucun gamme selectionner
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="clearfix">
                <h2 class="">Protection(s)</h2>
                
                <div class="block-protections">
                    <div class="row">
                        <div class="col-md-6 my-auto"><p class="aucun_equip_sup <?= !empty($borne->equipements_protections_bornes) ? 'd-none' : '' ?>">Aucune protection supplémentaire</p></div>
                        <div class="col-md-6 my-auto"><button type="button" class="btn btn-success float-right btn-rounded" data-toggle="modal" data-target="#modal-protection"> Ajouter </button></div>
                    </div>

                    <div class="container-protections-sup container-equips d-none mt-4">
                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="15%">Type équipement</th>
                                    <th width="25%">Modèle</th>
                                    <th width="25%">Qté</th>
                                    <th width="35%"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <!-- JS -->
                            </tbody>
                            <tfoot>
                                <tr class="clone d-none added-tr">
                                    <td class="nom-equip-accessoire"></td>
                                    <td class="select-equip-accessoire"></td>
                                    <td class="qty-equip-accessoire"></td>
                                    <td class="type-equip-accessoire-id d-none"></td>
                                    <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h2 >Licences</h2>
            <div class="row p-t-20">
                <?php  foreach ($typeLicences as $key => $typeLicence) : ?>
                    <div class="col-md-6">
                        <?= $this->Form->control("licences_bornes._ids.$key", [
                                'id' => 'numero-series-win-licence',
                                'label' => 'Numero de serie licence' . $typeLicence->nom,
                                'empty' => 'Numero licence',
                                'options' => isset($numeroSeriesLicences[$typeLicence->id])?$numeroSeriesLicences[$typeLicence->id]:[],
                                "class" => "form-control select2",
                                "data-placeholder" => "Choisir",
                                'style' => 'width:100%'
                            ]);
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">

            <h2 >Prise en main à distance</h2>
            <h3>Teamviewer :</h3>
            <div class="row p-t-20">
                <div class="col-md-6">
                    <?php echo $this->Form->control('teamviewer_remotecontrol_id',['label' => 'ID TeamViewer', 'required'=>false, 'type'=>'number']); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->control('teamviewer_password',['type' => 'text', 'label' => 'Pass TeamViewer', 'id'=>'password_visible', 'required'=>false]); ?>
                </div>
            </div>
            <h3>Anydesk :</h3>
            <div class="row p-t-20">
                <div class="col-md-6">
                    <?php echo $this->Form->control('anydesk_id',['type' => 'text', 'label' => 'ID Anydesk', 'id'=>'']); ?>
                </div>
            </div>
            <div class="form-actions">
                <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn btn-rounded btn-inverse",'escape'=>false]) ?>
            </div>
        </div>
    </div>
<?= $this->Form->end() ?>


<script type="text/javascript">
    var modelBornes = <?php echo json_encode($modelBornes); ?>;
    var equipements = <?php echo json_encode($equipements); ?>;
    var numeroSeriesEquip = <?php echo json_encode($numeroSeriesEquip); ?>;
</script>
