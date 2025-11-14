<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('bornes/listbornes.js?'.time(), ['block' => true]); ?>
<?= $this->Html->css('borne.css?' . time(), ['block' => true]); ?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>

<?php
$titrePage = $parcEntity != null?"$parcEntity->ariane_titre":"Vue d'ensemble des bornes" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
$customFinderOptions['action'] = 'index';
if($parc_type){
    $customFinderOptions[] = $parc_type;
}

$this->start('actionTitle');
    echo $this->Html->link('Create',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);                           
    
    echo $this->Html->link('Import',['action'=>'import'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ,'style'=>'margin: 0 10px 0 0']);
                        
    echo $this->Html->link('Vue liste',$customFinderOptions,['escape'=>false,"class"=>"btn btn-rounded pull-right btn-primary menu-list-map"  ,'style'=>'margin: 0 10px 0 0']); 

$this->end();
?>


<?php if(count($miniDashboard)) { ?>
        <div class="row">
                <?php  foreach ($miniDashboard as $keyGamme => $valueGamme) { ?>
                        <div class="col-lg-4">
                                <div class="card" style="min-height: 200px;">
                                        <div class="card-body" style="padding-bottom: 0px">
                                                <div class="form-group row">
                                                    <label class="control-label col-md-9"><h4><b><?= $keyGamme ?></b></h4></label>
                                                    <div class="col-md-3"><h4><b><?=$miniDashboard[$keyGamme]['total'];?></b></h4></div>
                                                    <?php foreach ($valueGamme as $modelName => $modelValue) {
                                                                        if($modelName != 'total') { ?>
                                                                            <div class="col-md-10"></div>
                                                                            <label class="control-label col-md-9">
                                                                                <a href="<?= $this->Url->build('/', true).'fr'.$modelValue['link'] ?>" class="mini-dash"><?=$modelName?></a>
                                                                            </label>
                                                                            <div class="col-md-3"><?=$modelValue['value']?></div>
                                                    <?php } } ?>
                                                </div>
                                        </div>
                                </div>
                        </div>
                <?php } ?>
        </div>
<?php } ?>


<div class="row" id="body_borne">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                        <div class="row">
                            <div class="col-md-2 filter-2 <?=$more_filter == 1 ?'col-md-3':'' ?>">
                                <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                            </div>
                            <div class="col-md-2 filter-2 <?=$more_filter == 1 ?'col-md-3':'' ?>">
                                <?php echo $this->Form->control('gamme', ['label' => false ,'options'=> $gammeBornes, 'value'=> $gamme, 'id' => 'gamme_borne_id', 'class'=>'form-control' ,'empty'=> 'Gamme'] );?>
                            </div>
                            <div class="col-md-2 filter-2 <?=$more_filter == 1 ?'col-md-3':'' ?>">
                                <?php echo $this->Form->control('model',  ['options' => $models, 'label' => false , 'id' => 'model_borne_id', 'value'=> $model, 'class'=>'form-control' ,'empty'=>'Modèle'] );?>
                            </div>
                            
                            <?php if (in_array($parc_type, [1, 4, 9]) || $parc_type == null): ?>
                            <div class="col-md-2 filter-2 <?=$more_filter == 1 ?'col-md-3':'' ?>">
                                <?php echo $this->Form->control('groupe_clients', [
                                    'label' => false ,
                                    'options'=>$groupeClients, 
                                    'value'=> $groupe_clients, 
                                    'empty'=>'Réseau',
                                    'class' => 'form-control',
                                    'style' => 'width:100%'
                                ] );?>
                            </div>
                            <?php endif;?>
                            
                            <?php if ($parc_type == 2 || $parc_type == null):  ?>
                            <div class="col-md-3 <?= $parc_type==null?'optional-filter d-none':'';?>">
                                <?php echo $this->Form->control('antenne', [
                                    'label' => false ,
                                    'options'=>$antennes, 
                                    'value'=> $antenne, 
                                    'empty'=>'Antenne',
                                    'class' => 'form-control select2',
                                    'data-placeholder' => "Antenne",
                                    'style' => 'width:100%'
                                ] );?>
                            </div>
                            <?php endif ?>
                            <div class="col-md-3 optional-filter d-none">
                                <?php echo $this->Form->control('couleur', ['label' => false ,'options'=>$couleurs, 'value'=> $couleur, 'class'=>'form-control' ,'empty'=>'Couleur'] );?>
                            </div>
                            
                            <div class="col-md-3 optional-filter d-none">
                                <?php echo $this->Form->control('connexion', ['label' => false ,'options'=>$connexions, 'value'=> $connexion, 'class'=>'form-control' ,'empty'=>'Etat connexion'] );?>
                            </div>
                            
                            <?php foreach($equipements as $typeEquipement =>  $equimentOptions){ ?> <!-- On boucle chaque type equipemet filtrable -->
                            <div class="col-md-3 optional-filter d-none">
                                <?php echo $this->Form->control('equipement[]', ['label' => false ,'options'=>$equimentOptions, 'value'=> $equipement, 'class'=>'form-control' ,'empty'=>$typeEquipement]);?>
                            </div>
                            <?php }?>
                            
                            <div class="col-md-3 optional-filter d-none">
                                <?php echo $this->Form->control('contrat', ['label' => false ,'options'=>$contrats, 'value'=> $contrat, 'class'=>'form-control' ,'empty'=>'Type de contrat'] );?>
                            </div>
                            
                            <?php
                                        /*on va ajouter le filtre de recherche "Sous-location : oui / non" sur  : 
                                        - la page vue d'ensemble (tableau et map)
                                        - la page des locations finacières (tableau et map)
                                        - la page des ventes (tableau et map)*/
                            ?>
                            <?php if (in_array($parc_type, [1, 4,9]) || $parc_type == null): ?>
                            <div class="col-md-2 filter-2 <?=$more_filter == 1 ?'col-md-3':'' ?>">
                                <?php echo $this->Form->control('is_sous_louee', [
                                    'label' => false ,
                                    'options'=>['0'=>'Non', '1'=> 'Oui'], 
                                    'value'=> $is_sous_louee, 
                                    'empty'=>'Sous location',
                                    'class' => 'form-control',
                                    'style' => 'width:100%'
                                ] );?>
                            </div>
                            <?php endif;?>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <?php echo $this->Form->hidden('more_filter', ['value' => $more_filter, 'class' => 'input_more_filter']);?>
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'Bornes', 'action' => 'map', $parc_type],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                </div>
                            </div>
                            <!--div class="col-md-2">
                                <?php echo $this->Form->button($more_filter == 1 ? '- de filtres' : '+ de filtres', ['type' => 'button', 'label' => false ,'class' => 'btn show-filter expand-filters',] );?>
                            </div-->
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                                    
                <hr>
                <div class="float-left my-auto "><p class="expand-filters show-filter"> <u><?=$more_filter == 1 ? '- de filtres' : '+ de filtres' ?></u> </p></div>
                <div class="row-fluid d-block clearfix">
                    <div class="float-right my-auto "><?= $countBorneByGamme ?> Nombre de bornes : <?= $totalBorne ?></div>
                </div>
                <div class="table-responsive hide" id="div_table_bornes">
                    <table class="table hide">
                        <thead>
                            <tr>
                                <th>Numéro borne</th>
                                <th>Modèle (version)</th>
                                <th>Antenne actuelle</th>
                                <th>Nom</th>
                                <th>head info</th>
                                <th>adresse</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = -1;
                        foreach ($bornes as $borne) {
                            if($borne->client == null && $borne->antenne == null) continue;
                            $i++;
                            ?>
                            <tr >
                                <td><input type="text" value="<?= $borne->has('model_borne') ? $borne->model_borne->gamme_borne_id : ""?>"  id="gamme_<?= $i ?>"></td>

                                <?php if ($borne->client) { ?>
                                            <td><input id="name_<?= $i ?>" value="<?php echo $borne->client->nom ?>"/></td>
                                            <td><input id="head_<?= $i ?>" value="#<?= $borne->has('model_borne') ? $borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : $borne->numero?>"/></td>
                                            <td><input id="adresse_<?= $i ?>" value="<?php echo $borne->client->cp. ' ' . $borne->client->ville;?>"/></td>
                                            <td><input id="link_<?= $i ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>                        
                                            <td><input id="type_<?= $i ?>" value="<?= $borne->parc->nom?>"/></td>
                                            <td><input id="loc_<?= $i ?>" value="<?= $borne->is_sous_louee? 'Sous location : Oui' : 'Sous location : Non'?>"/></td>
                                            <td><input id="nombre_<?= $i ?>"/></td>

                                            <td><input id="lat_<?= $i ?>" value="<?php
                                                if (!empty($borne->client->addr_lat))
                                                    echo $borne->client->addr_lat;
                                                if (!empty($borne->latitude))
                                                    echo $borne->latitude;
                                                ?>"/></td>
                                            <td><input id="lgt_<?= $i ?>" value="<?php
                                                if (!empty($borne->client->addr_lng)){
                                                    echo $borne->client->addr_lng;
                                                }elseif (!empty($borne->longitude)){
                                                    echo $borne->longitude;
                                                }
                                                ?>"/></td>
                                            <td><input id="adr_<?= $i ?>" value="<?php
                                                if (!empty($borne->client->adresse)){
                                                    echo $borne->client->adresse.', '.$borne->client->nom . ' ' . $borne->client->prenom .', '. $borne->client->cp.', '.$borne->client->ville;
                                                }elseif (!empty($borne->adresse) && trim($borne->adresse)){
                                                    echo $borne->adresse;
                                                }
                                                ?>"/>
                                            </td>
                                <?php } elseif ($borne->antenne) { ?>

                                            <td><input id="name_<?= $i ?>" value="Selfizee"/></td>
                                            <td><input id="head_<?= $i ?>" value="#<?= $borne->has('model_borne') ? $borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : $borne->numero?>"/></td>
                                            <td><input id="adresse_<?= $i ?>" value="<?php echo $borne->antenne->cp ." ". $borne->antenne->ville_principale?>"/></td>
                                            <td><input id="link_<?= $i ?>" value="<?= $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) ?>"/></td>
                                            <td><input id="type_<?= $i ?>" value=""/></td>
                                            <td><input id="loc_<?= $i ?>" value=""/></td>
                                            <td><input id="nombre_<?= $i ?>"/></td>

                                            <td><input id="lat_<?= $i ?>" value="<?php
                                                if (!empty($borne->antenne)){
                                                    echo $borne->antenne->latitude;
                                                }elseif (!empty($borne->latitude)){
                                                    echo $borne->latitude;
                                                } ?>"/>
                                            </td>
                                            <td><input id="lgt_<?= $i ?>" value="<?php
                                                if (!empty($borne->antenne)){
                                                    echo $borne->antenne->longitude;
                                                }elseif (!empty($borne->longitude)){
                                                    echo $borne->longitude;
                                                }?>"/>
                                            </td>
                                            <td><input id="adr_<?= $i ?>" value="<?php
                                                if (!empty($borne->antenne->adresse)){
                                                    echo $borne->antenne->adresse;
                                                }elseif (!empty($borne->adresse)){
                                                    echo $borne->adresse;
                                                }
                                                ?>"/>
                                            </td>

                                <?php }else{ ?>
                                            <td></td>
                                            <td><input id="name_<?= $i ?>" /></td>
                                            <td><input id="head_<?= $i ?>" /></td>
                                            <td><input id="adresse_<?= $i ?>" /></td>
                                            <td><input id="link_<?= $i ?>" /></td>
                                            <td><input id="type_<?= $i ?>" value=""/></td>
                                            <td><input id="nombre_<?= $i ?>"/></td>
                                            <td><input id="loc_<?= $i ?>"/></td>
                                            <td><input id="lat_<?= $i ?>"/></td>
                                            <td><input id="lgt_<?= $i ?>"/></td>
                                            <td><input id="adr_<?= $i ?>"/></td>
                                   <?php } ?>
                            </tr>
                        <?php } ?>
                        <?php foreach ($borne_antennes as $antenne) { 
                            if(count($antenne->bornes)) { $borne = $antenne->bornes[0]; $i++; ?>
                                    
                                    <tr>
                                    <td><input type="text" value="A"  id="gamme_<?= $i ?>"></td>
                                    <td><input id="name_<?= $i ?>" value="Selfizee"/></td>
                                    <td><input id="head_<?= $i ?>" value="<?= count($antenne->bornes) == 1?$borne->has('model_borne') ? "#".$borne->numero .' - ' . $borne->model_borne->gammes_borne->name . ' ' . $borne->model_borne->nom : "#".$borne->numero:$antenne->ville_principale ?>"/></td>
                                    <td><input id="adresse_<?= $i ?>" value="<?php echo $antenne->cp ." ". $antenne->ville_principale ?>"/></td>
                                    <td><input id="link_<?= $i ?>" value="<?= count($antenne->bornes) == 1 ? $this->Url->build(['controller' => 'Bornes','action' => 'view',$borne->id]) : $this->Url->build(['controller' => 'Bornes','action' => 'index/2?antenne='.$antenne->ville_principale])?>"/></td>
                                    <td><input id="type_<?= $i ?>" value=""/></td>
                                    <td><input id="loc_<?= $i ?>" value=""/></td>

                                    <td><input id="lat_<?= $i ?>" value="<?= $antenne->latitude;?>"/></td>
                                    <td><input id="lgt_<?= $i ?>" value="<?= $antenne->longitude;?>"/></td>
                                    <td><input id="adr_<?= $i ?>" value="<?= $antenne->adresse;?>"/></td>
                                    <td>
                                        <input id="nombre_<?= $i ?>" value=" 
                                            Nombre de bornes au total : <?= count($antenne->bornes) ?> 
                                            <br> 
                                            <?php foreach ($gammeBornes as $gameId => $name){ ?>
                                                            <?php $n = count(array_filter($antenne->bornes,function($k,$v) use($gameId) {
                                                                return $k->model_borne->gamme_borne_id == $gameId;
                                                            },ARRAY_FILTER_USE_BOTH));
                                                            if($n > 0){ ?>
                                                                    <?= $name ?> :  <?= $n ?> ;
                                            <?php } } ?>
                                            "/>
                                    </td>
                                    </tr>
                            <?php } ?>
                        <?php } ?>

                        <input type="text" class="hide"  id="nbornes" value="<?= ++$i ?>"/>
                        </tbody>
                    </table>
                </div>
                
                <div class="form-group row" id="div_map_bornes" style="width: 99%;">
                    <div class="col-md-12">
                        <div id="mapCanvas" style="width:auto; height:600px;"></div>
                        <div class="kl_infoForm"></div>
                        <div class="legende" style="margin: 10px;">
                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker_yellow.png", ["alt" => "Brownies"]);?> Antenne</div>
                            <?php foreach ($gammeBornes as $g => $name){
                                        if($g == 2){ ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker.png", ["alt" => "Brownies"]);?> <?= $name ;?></div>
                                        <?php } elseif($g == 3) { ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker_green.png", ["alt" => "Brownies"]);?>  <?= $name ;?></div>
                                        <?php } elseif($g == 5) { ?>
                                            <div class="legende-items"><?= $this->Html->image("http://maps.google.com/mapfiles/marker_purple.png", ["alt" => "Brownies"]);?>  <?= $name ;?> </div>
                                        <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

