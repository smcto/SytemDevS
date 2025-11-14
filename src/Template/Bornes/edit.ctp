<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Borne $borne
 */
?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css?' . time(), ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('borne.css?' . time(), ['block' => true]); ?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('bornes/edit.js?' . time(), ['block' => true]); ?>
<?= $this->Html->script('bornes/protections.js?'.time(), ['block' => true]); ?>


<?php
$titrePage = "Modifier une borne";
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
        'Bornes', ['controller' => 'Bornes', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb', ['titrePage' => $titrePage]);
$this->end();
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

<div class="row">
    <?php use Cake\Routing\Router; ?>
    <input type="hidden" id="id_baseUrl" value="<?php echo Router::url('/', true) ; ?>"/>
    <input type="hidden" id="borne_id" value="<?= $borne->id ?>">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <!--div class="card-header">
                <h4 class="m-b-0 text-white">Informations générales</h4>
            </div-->
            <div class="card-body">
                
                <h3><b> Détail borne #<?= ($borne->has('model_borne') ? $borne->model_borne->gammes_borne->notation:'') . $borne->numero ?> - <?= $borne->parc->nom == 'Location'?'Parc locatif': ($borne->parc->nom != 'Stock tampon'?'Parc ' . $borne->parc->nom: $borne->parc->nom);?></b></h3>

                <?= $this->Form->create($borne, ['id' => 'borne-formulaire']) ?>
                <nav class="nav nav-tabs">
                    <a class="nav-item nav-link active" id="t1" href="#p1" data-toggle="tab" style="color:#000">Borne</a>
                    <a class="<?= ($borne->parc_id != 2 && $borne->parc_id != 3) ? 'nav-item nav-link client-id' : 'nav-item nav-link client-id hide'?> " id="t2" href="#p2" data-toggle="tab" style="color:#000">Client</a>
                    <a class="<?= ($borne->parc_id == 2 || ($borne->parc_id == 11 && !$borne->client_id))? 'nav-item nav-link antenne-id' : 'nav-item nav-link antenne-id hide' ?>"  id="t3" href="#p3" data-toggle="tab" style="color:#000">Parc</a>
                    <a class="nav-item nav-link"  id="t4" href="#p4" data-toggle="tab" style="color:#000">Equipements</a>
                    <a class="nav-item nav-link"  id="t7" href="#p7" data-toggle="tab" style="color:#000">Protections</a>
                    <a class="nav-item nav-link"  id="t5" href="#p5" data-toggle="tab" style="color:#000">Licences</a>
                    <a class="nav-item nav-link"  id="t6" href="#p6" data-toggle="tab" style="color:#000">Prise en main à distance</a>
                </nav>
                <div class="tab-content">
                    <div class="tab-pane active" id="p1">
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('numero', ['label' => 'Numéro *', 'type' => 'number','required'=>true]); ?>
                            </div>
                            
                            <div class="col-md-6">
                                <?php echo $this->Form->control('parc_id', ['id' => 'id_parc', 'label' => 'Parc destination * ', 'options' => $parcs, 'empty' => 'Séléctionner']); ?>
                            </div>
                            
                            <div class="col-md-3" id="id_couleurs_possible">
                                <?php
                                echo $this->Form->control('couleur_id', [
                                    'id' => 'couleurs_possible_id',
                                    'required' => 'required',
                                    'options' => $couleurPossible,
                                    'label' => __('Couleur *'),
                                    'empty' => 'Séléctionner',]);
                                ?>
                            </div>
                            
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gamme">Gamme</label>
                                        <select class="custom-select" name="gamme" id="gamme">
                                                <option value="0">Séléctionner</option>
                                            <?php foreach ($gammeBornes as $id => $nom) { ?>     
                                                    <?php if(!empty($borne->model_borne->gamme_borne_id) && $borne->model_borne->gamme_borne_id==$id) { ?>
                                                                    <option value="<?= $id; ?>" selected="selected"> <?= $nom; ?> </option>
                                                    <?php }else {?>
                                                                    <option value="<?= $id; ?>"> <?= $nom; ?> </option>
                                                    <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <?php echo $this->Form->control('model_borne_id', ['id' => 'model_borne_id', 'label' => 'Modèle *', 'options' => [], 'empty' => 'Séléctionner', 'onchange' => 'selectColor()','required'=>true]); ?>
                            </div>
                            <input type="hidden" value=<?= $borne->model_borne_id ?> id="value_model_borne_id">

                            <div class="col-md-3">
                                <?php
                                $statuts = array('Dispo', 'SAV', 'HS');
                                echo $this->Form->control('statut', [
                                    'label' => 'Statut *',
                                    'required' => 'required',
                                    'options' => $statuts,
                                    'empty' => 'Séléctionner',]);
                                ?>
                            </div>
                            
                        </div>

                            <!--div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date expiration SB</label>
                                    <input type="date" name="expiration_sb" class="form-control" placeholder="dd/mm/yyyy" value="<?php if (!empty($borne->expiration_sb)) echo $borne->expiration_sb->format('Y-m-d') ?>">
                                </div>
                            </div-->


                        <div class="row">
                            <div class="col-md-3">
                                <?php echo $this->Form->control('etat_borne_id', ['id' => 'etat_borne_id', 'label' => 'Etat général *', 'options' => $etat_bornes, 'empty' => 'Séléctionner']); ?>
                            </div>
                            <div class="col-md-3">
                                <?php if($borne->marque =='SELFIZEE'){
                                    $borne->marque = 0;
                                } ?>
                                <?= $this->Form->control('marque',['label' => 'Marque','empty'=>'Séléctionner', 'options'=>$marques, 'value'=>$borne->marque ]); ?>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Date de sortie atelier</label>
                                    <input type="date" id="sortie_atelier" name="sortie_atelier" class="form-control" placeholder="dd/mm/yyyy" value="<?= $borne->sortie_atelier?$borne->sortie_atelier->format('Y-m-d'):'';?>">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Opérateur</label>
                                    <?= $this->Form->control('operateur_id',['label' => false,'empty'=>'Séléctionner', 'options'=> $users, 'class' => 'form-control select2']); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Gravure </label>
                                    <?= $this->Form->control('gravure',['label' => false,'empty'=>'Séléctionner', 'options'=> ['Non', 'Oui']]); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-3 hide">
                                <?php echo $this->Form->control('numero_bl', ['label' => 'Numéro de bon de livraison', 'type' => 'text']); ?>
                            </div>
                            
                            <div class="col-md-3 sous-loc <?= in_array($borne->parc_id, [1,4])?:'hide'?>">
                                <?php
                                $is_sous_louee = array('0' => 'Non', '1' => 'Oui');
                                echo $this->Form->control('is_sous_louee', [
                                    'label' => 'Sous location',
                                    'options' => $is_sous_louee,]);
                                ?>
                            </div>
                            <div class="col-md-3 sous-loc <?= $borne->is_sous_louee?:'hide'?> antenne-loc">
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
                            <div class="col-md-3 sous-loc <?= $borne->is_sous_louee?:'hide'?> antenne-loc m-t-40">
                                
                                <div class="form-group">
                                    <label class="control-label">Nouvelle Antenne</label>
                                    <?php  echo $this->Html->link('Créer une fiche antenne',['controller' => 'Antennes','action' => 'add?borne='. $borne->id . '&client='.$borne->client_id],['escape'=>false,"class"=>"btn btn btn-rounded hidden-sm-down btn-success form-control"]); ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6 m-t-40">
                                <?php
                                echo $this->Form->control('not_in_cart', ['label' => 'Ne pas afficher sur la carte location CRM','type' => 'checkbox', 'value' => 1]);
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="hide">
                        <div class="hide">
                            <label class="control-label">Adresse *</label>
                            <div id="infoPanel">
                                <?php
                                $valueSearchTextField = '';
                                if (!empty($borne->client->adresse)) {
                                    $valueSearchTextField = $borne->client->adresse . ', ' . $borne->client->nom . ' ' . $borne->client->prenom . ', ' . $borne->client->cp . ', ' . $borne->client->ville;
                                } elseif (!empty($borne->antenne->adresse)) {
                                    $valueSearchTextField = $borne->antenne->adresse;
                                } elseif (!empty($borne->adresse) && trim($borne->adresse) != ' ') {
                                    $valueSearchTextField = $borne->adresse;
                                }
                                echo $this->Form->control('adresse', ['label' => false, 'class' => 'form-control controls', 'id' => 'searchTextField', 'value' => $valueSearchTextField]);
                                ?>
                            </div>
                            <input id="info" type="text" size="50" value="" class="hide" />
                        </div>

                        <div class="col-sm-4">
                            <label class="control-label">Latitude</label>
                            <?php
                            $valueTxtLatitude = '';

                            if ($borne->client_id != null && !empty($borne->client->addr_lat)) {
                                $valueTxtLatitude = $borne->client->addr_lat;
                            } elseif ($borne->antenne_id != null && !empty($borne->antenne->latitude)) {
                                $valueTxtLatitude = $borne->antenne->latitude;
                            } elseif (!empty($borne->latitude)) {
                                $valueTxtLatitude = $borne->latitude;
                            }
                            echo $this->Form->control('latitude', ["id" => "txtLatitude", 'type' => 'text', 'label' => false, 'class' => 'form-control ', "readonly" => "true", "value" => $valueTxtLatitude]);
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Longitude</label>
                            <?php
                            $valueTxtLongitude = '';
                            if ($borne->client_id != null && !empty($borne->client->addr_lng)) {
                                $valueTxtLongitude = $borne->client->addr_lng;
                            } elseif ($borne->antenne_id != null && !empty($borne->antenne->longitude)) {
                                $valueTxtLongitude = $borne->antenne->longitude;
                            } elseif (!empty($borne->longitude)) {
                                $valueTxtLongitude = $borne->longitude;
                            } echo $this->Form->control('longitude', ["id" => "txtLongitude", 'type' => 'text', 'label' => false, 'class' => 'form-control ', "readonly" => "true", "value" => $valueTxtLongitude]);
                            ?>
                        </div>
                    </div>

                    <div  class="<?= ($borne->parc_id != 2 && $borne->parc_id != 3)? 'tab-pane client-id' : 'tab-pane client-id hide' ?>" id="p2">
                        <div  class="<?= ($borne->parc_id != 2 && $borne->parc_id != 3) ? 'row p-t-20 client-id' : 'row p-t-20 client-id hide' ?>">
                               <div class="col-md-6">
                                <?= $this->Form->control('client_id', [
                                    'label' => 'Client',
                                    'empty' => 'Séléctionner',
                                    "class" => "js-data-client-ajax form-control",
                                    "data-placeholder" => "Choisir",
                                    'style' => 'width:100%'
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" id="adresse_client" readonly="readonly" value="<?= $borne->client!=null?$borne->client->adresse:'';?>" name="adresse" class="form-control"/>
                                </div>
                            </div>

                            <?php if(count($borne->ventes)): $vente = $borne->ventes[0] ?>
                                <h4 class="control-label col-md-10"> <b><?=$borne->parc->nom?></b></h4>
                                <div class="col-md-6 <?= $vente->parc_duree!=null? '' : 'hide' ;?>">
                                    <div class="form-group">
                                        <label for="duree">Durée</label>
                                        <input type="text" id="duree" readonly="readonly" value="<?= !$borne->is_contrat_modified ? @$vente->parc_duree->valeur : @$borne->parc_duree->valeur; ?>" name="duree" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Début contrat</label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="<?= !$borne->is_contrat_modified ? ($vente->contrat_debut!=null? date_format($vente->contrat_debut,"d - m - Y") : '') : $borne->contrat_debut ?>" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Fin contrat </label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="<?= !$borne->is_contrat_modified ? ($vente->contrat_fin!=null?date_format($vente->contrat_fin,"d - m - Y") : '') : $borne->contrat_fin?>" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Commercial</label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="<?=  !$borne->is_contrat_modified ? ($vente->user != null ? $vente->user->prenom . ' ' . $vente->user->nom : '') : ($borne->user ? $borne->user->get('FullName') : ''); ?>" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>

                                <div style="height: 2px; background: #f2f7f8; width: 100%;margin: 12px 0px 15px 0px;"> </div>
                                
                            <?php elseif($borne->parc_id != 1 && $borne->parc_id != 3) : ?>
                                    
                                <h4 class="control-label col-md-10"> <b><?=$borne->parc->nom?></b></h4>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="duree">Durée</label>
                                        <input type="text" id="duree" readonly="readonly" value="--" name="duree" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Début contrat</label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="--" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Fin contrat </label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="--" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debut_contrat">Commercial</label>
                                        <input type="text" id="debut_contrat" readonly="readonly" value="--" name="debut_contrat" class="form-control"/>
                                    </div>
                                </div>

                                <div style="height: 2px; background: #f2f7f8; width: 100%;margin: 12px 0px 15px 0px;"> </div>
                            <?php endif; ?>
                        </div>


                        <div <?= ($borne->client_id != null ? 'class="form-group row client-id"' : 'class="form-group row client-id hide"') ?>>
                            <div class="col-md-12">
                                <div id="mapCanvas" style="width:auto; height:280px;"></div>
                                <div class="form-actions" id="link_edit_client">
                                        <?= $borne->client_id!=null? $this->Html->link('Edit client',['controller' => 'Clients', 'action' => 'edit', $borne->client_id],['style'=>'color: #000']):'';?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="<?= ($borne->parc_id == 2 || ($borne->parc_id == 11 && !$borne->client_id)) ? 'tab-pane antenne-id' : 'tab-pane antenne-id hide' ?>" id="p3">
                        <div class="<?= ($borne->parc_id == 2 || ($borne->parc_id == 11 && !$borne->client_id)) ?  'row p-t-20 antenne-id' : 'row p-t-20 antenne-id hide' ?>">
                            <div class="col-md-6">
                                <?php
                                echo $this->Form->control('antenne_id', [
                                    'label' => 'Antenne',
                                    'empty' => 'Séléctionner',
                                    'options' => $antennes,
                                    "class" => "form-control select2",
                                    "data-placeholder" => "Choisir",
                                    'style' => 'width:100%'
                                ]);
                                ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" id="adresse_antenne" readonly="readonly" value="<?= $borne->antenne != null?$borne->antenne->adresse:''?>" name="adresse" class="form-control"/>
                                </div>
                            </div>
                        </div>

                        <div <?= ($borne->antenne_id != null ? 'class="form-group row antenne-id"' : 'class="form-group row antenne-id hide"') ?>>
                            <div class="col-md-12">
                                <div id="mapCanvas2" style="width:auto; height:280px;"></div>
                                <div class="form-actions" id="link_edit_antenne">
                                        <?= $borne->antenne_id!=null?$this->Html->link('Edit antenne',['controller' => 'Antennes', 'action' => 'edit', $borne->antenne_id],['style'=>'color: #000']):'';?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="p4">
                        
                        <div id="div-equipement">
                            Aucun gamme selectionner
                        </div>
                        
                        <div class="container-form-accessories">
                            <h3 style="border-bottom: 1px solid grey;">Accessoires :</h3>
                            <?= $this->element('../AjaxBornes/accessoires_by_gamme') ?>
                        </div>

                    </div>

                    <div class="tab-pane" id="p5">
                        <?php  foreach ($typeLicences as $key => $typeLicence) : $value = null?>
                        
                            <?php foreach ($borne->licences_bornes as $licencesBorne) : ?>
                                    <?php if($licencesBorne->type_licence_id == $typeLicence->id) :
                                        $value = $licencesBorne->id;
                                        break;
                                    endif; ?>
                            <?php endforeach; ?>

                            <h3 style="border-bottom: 1px solid grey;">Licence <?= $typeLicence->nom ?> :</h3>
                            <div class="row p-t-20">

                                <div class="col-md-6">
                                    <?= $this->Form->control("licences_bornes._ids.$key", [
                                        'id' => 'numero-series-win-licence',
                                        'label' => 'Numero de serie licence',
                                        'value' => $value,
                                        'empty' => 'Numero licence',
                                        'options' => isset($numeroSeriesLicences[$typeLicence->id])?$numeroSeriesLicences[$typeLicence->id]:[],
                                        "class" => "form-control select2",
                                        "data-placeholder" => "Choisir",
                                        'style' => 'width:100%'
                                    ]);
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="tab-pane" id="p7">
                        
                        <div class="clearfix">
                            <h3 style="border-bottom: 1px solid grey;">Protection(s) :</h3>
                            <!-- <h2 class="">Protection(s)</h2> -->
                            
                            <div class="block-protections">
                                <div class="row">
                                    <div class="col-md-6 my-auto"><p class="aucun_equip_sup <?= !empty($borne->equipements_protections_bornes) ? 'd-none' : '' ?>">Aucune protection supplémentaire</p></div>
                                    <div class="col-md-6 my-auto"><button type="button" class="btn btn-success float-right btn-rounded" data-toggle="modal" data-target="#modal-protection"> Ajouter </button></div>
                                </div>

                                <div class="container-protections-sup container-equips <?= !empty($borne->equipements_protections_bornes) ? '' : 'd-none' ?> mt-4">

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
                                            <?php if (!empty($borne->equipements_protections_bornes)): ?>
                                                <?php foreach ($borne->equipements_protections_bornes as $key => $equipementsAccessoiresBorne): ?>
                                                    <?php /*debug($equipementsAccessoiresBorne);*/ ?>
                                                    <?php $type_equipement_id = $equipementsAccessoiresBorne->type_equipement_id ?>
                                                    <tr>
                                                        <td class="nom-equip-accessoire"><?= $equipementsAccessoiresBorne->type_equipement['nom'] ?></td>
                                                        <td class="select-equip-accessoire">
                                                            <?= $this->Form->control('equipements_protections_bornes.'.$key.'.equipement_id', ['label' => false, 'options' => collection($equipementsAccessoiresBorne->type_equipement['equipements'])->combine('id', 'valeur'), 'empty' => 'Sélectionner']); ?>
                                                        </td>
                                                        <td class="qty-equip-accessoire">
                                                            <?= $this->Form->control('equipements_protections_bornes.'.$key.'.qty', ['label' => false, 'placeholder' => 'quantité', 'type' => 'number']); ?>
                                                        </td>
                                                        <td class="type-equip-accessoire-id d-none">
                                                            <?= $this->Form->control('equipements_protections_bornes.'.$key.'.type_equipement_id', ['label' => false, 'type' => 'number', 'default' => $type_equipement_id]); ?>
                                                            <?php if ($equipements_protections_vente_id = $equipementsAccessoiresBorne->id): ?>
                                                                <?php echo $this->Form->hidden('equipements_protections_bornes.'.$key.'.id', ['value' => $equipements_protections_vente_id]); ?>
                                                            <?php endif ?>
                                                        </td>
                                                        <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
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

                    <div class="tab-pane" id="p6">
                        <h3 style="border-bottom: 1px solid grey;">Teamviewer :</h3>
                        <div class="row p-t-20">
                            <div class="col-md-4">
                                <?php
                                $remotecontrol_id = "";
                                if (!empty($borne->teamviewer_remotecontrol_id)) {
                                    $remotecontrol_id = substr($borne->teamviewer_remotecontrol_id, 1);
                                }
                                echo $this->Form->control('teamviewer_remotecontrol_id', ['label' => 'ID TeamViewer', 'required' => false, 'type' => 'number', 'value' => $remotecontrol_id]);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $this->Form->control('teamviewer_password', ['type' => 'text', 'label' => 'Pass TeamViewer', 'id' => 'password_visible', 'required' => false]); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $this->Form->control('teamviewer_alias', ['type' => 'text', 'label' => 'Alias ']); ?>
                            </div>
                        </div>
                        <h3 style="border-bottom: 1px solid grey;">Anydesk :</h3>
                        <div class="row p-t-20">
                            <div class="col-md-4">
                                <?php echo $this->Form->control('anydesk_id', ['type' => 'text', 'label' => 'ID Anydesk']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'), ["class" => "btn btn btn-rounded btn-success", 'id' => 'save-submit', 'escape' => false]) ?>
                    <?= $this->Form->button('Cancel', ["type" => "reset", "class" => "btn btn btn-rounded btn-inverse", 'escape' => false]) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>         
        </div>
    </div>
</div>



<script type="text/javascript">
    var modelBornes = <?php echo json_encode($modelBornes); ?>;
    var equipements = <?php echo json_encode($equipements); ?>;
    var numeroSeriesEquip = <?php echo json_encode($numeroSeriesEquip); ?>;
</script>

<?php
echo $this->Html->link('Création', ['action' => 'addActuborne', $borne->id, 1], ['escape' => false, "class" => "btn btn btn-rounded pull-right hidden-sm-down btn-success"]);
?>

<div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Liste des tickets de la borne</h4>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('Créer') ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actuBornes as $actuBorne): ?>
                                    <tr>
                                        <td><?= h($actuBorne->titre) ?></td>
                                        <td><?= h($actuBorne->created) ?></td>
                                        <td>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'editActuborne', $actuBorne->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['action' => 'deleteActuborne', $actuBorne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $actuBorne->id)]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>