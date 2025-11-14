<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Antenne[]|\Cake\Collection\CollectionInterface $antennes
 */
?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php echo $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?php //echo $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('antennes/filtres.js?'.  time(), ['block' => true]); ?>

<?= $this->Html->script('antennes/listantennes.js?'. time(), ['block' => true]); ?>

<?php
$titrePage = "Liste des antennes" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
$customFinderOptions['action'] = 'index';

$this->start('actionTitle');
    echo $this->Html->link('Ajouter',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success", "style"=>"margin-left: 5px;" ]);
    echo $this->Html->link('Vue liste',$customFinderOptions,['escape'=>false,"class"=>"btn btn-rounded btn-primary pull-right menu-list-map" ]);
$this->end();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="row-fluid d-block clearfix mt-3">
                        <div class="form-body">
                                <?php   $fondVerts = ["1"=>"Non", "2"=>"Oui"];
                                echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Recherche...']); ?>
                                </div>

                                <div class="col-md-3">
                                    <?php echo $this->Form->control('etat',['label' => false, 'class'=>'form-control custom-select selectpicker ', 'value'=>$etat, 'options'=>$etats, 'empty'=>'Séléctionner un etat']);?>
                                </div>
                                <div class="col-md-3">
                                    <?php echo $this->Form->control('ville_principale',['type' => 'select', 'label' => false,'value'=>$ville_principale, 'options'=>$ville_principales, 'required'=>false, 'empty'=>'Ville principale', 'class'=>'form-control select2']);?>
                                </div>
                                <div class="col-md-2 hide">
                                    <?php echo $this->Form->control('fondvert',['type' => 'select', 'label' => false,'value'=>$fondvert, 'options'=>$fondVerts, 'required'=>false, 'empty'=>'Fond vert', 'class'=>'selectpicker', 'id'=>'fond_vert']);?>
                                </div>
                                <div class="col-md-2">
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                        </div>
                </div>

                <div class="row m-t-40">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-4 col-xlg-4">
                        <div class="card card-inverse card-info">
                            <div class="box bg-info text-center">
                                <?php if($nbrTotal > 1) { ?>
                                <h1 class="font-light text-white"><?= $nbrTotal ?></h1><h6 class="text-white">Antennes</h6>
                                <?php } ?>
                                <?php if($nbrTotal <= 1) {?>
                                <h1 class="font-light text-white"><?= $nbrTotal ?></h1><h6 class="text-white">Antenne</h6>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-4 col-xlg-4">
                        <div class="card card-primary card-inverse">
                            <div class="box text-center">
                                <?php if($nbrVillePrincipales > 1) {?>
                                <h1 class="font-light text-white"><?= $nbrVillePrincipales ?></h1><h6 class="text-white">Ville principales</h6>
                                <?php } ?>
                                <?php if($nbrVillePrincipales <= 1) {?>
                                <h1 class="font-light text-white"><?= $nbrVillePrincipales ?></h1><h6 class="text-white">Ville principale</h6>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-4 col-xlg-4">
                        <div class="card card-inverse card-dark">
                            <div class="box text-center">
                                <?php if($nbrSousAntenne > 1) {?>
                                 <h1 class="font-light text-white"><?= $nbrSousAntenne ?></h1><h6 class="text-white">Sous antennes</h6>
                                <?php } ?>
                                <?php if($nbrSousAntenne <= 1) {?>
                                 <h1 class="font-light text-white"><?= $nbrSousAntenne ?></h1><h6 class="text-white">Sous antenne</h6>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!--<div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-inverse card-success">
                            <div class="box text-center">
                                <h1 class="font-light text-white">1100</h1>
                                <h6 class="text-white">Resolve</h6>
                            </div>
                        </div>
                    </div>-->
                    <!-- Column -->

                </div>
                <div class="table-responsive" id="div_table_antennes">
                    <table class="hide table">
                        <thead>
                            <tr>
                                <th>Ville principale</th>
                                <th class="hide">Ville principale</th>
                                <th class="hide">Latitude</th>
                                <th class="hide">Longitude</th>
                                <th class="hide">Nba</th>
                                <th class="hide">Etat</th>
                                <th class="hide">Couleur</th>
                                <th class="hide">Id</th>

                                <th>Nombre de bornes</th>
                                <th>Responsable</th>
                                <th>Fond vert</th>
                                <th>Nombre événements</th>
                                <!--<th>Ville exacte</th>
                                <th>Adresse </th>
                                <th>Cp</th>
                                <th>Lieu type</th>
                                <th>Longitude</th>
                                <th>Latitude</th>
                                <th>Etat</th>
                                <th></th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <input type="text" class="hide"  id="nbantennes" value="<?= count($antennes)?>"/>
                             <?php
                             $i=-1;
                             foreach ($antennes as $antenne):
                             $i= $i+1;
                             ?>
                                <tr>
                                    <td><?= $this->Html->link($antenne->ville_principale, ['action' => 'edit', $antenne->id]) ?></td>
                                    <td class="hide"><input  id="nom_<?= $i ?>" value="<?= h($antenne->ville_principale)?>" /></td>
                                    <td class="hide"><input id="lat_<?= $i ?>" value="<?php if(!empty($antenne)) echo $antenne->latitude ?>"/></td>
                                    <td class="hide"><input id="lgt_<?= $i ?>" value="<?php if(!empty($antenne)) echo $antenne->longitude ?>"/></td>
                                    <td class="hide"><input id="nba_<?= $i ?>" value="<?php if(!empty($antenne->bornes)) echo count($antenne->bornes) ?>"/></td>
                                    <td class="hide"><input id="etat_<?= $i ?>" value="<?php if(!empty($antenne->etat->valeur)) echo $antenne->etat->valeur ?>"/></td>
                                    <td class="hide"><input id="color_<?= $i ?>" value="<?php if(!empty($antenne->etat->id == 1 && count($antenne->bornes)>1 )) echo ('FF0000');
                                     if(!empty($antenne->etat->id == 1 && count($antenne->bornes)<=1 )) echo ('FFD700');
                                     if(!empty($antenne->etat->id == 2)) echo ('0000FF');
                                     if(!empty($antenne->etat->id == 3)) echo ('00FF00');
                                    ?>"/></td>
                                    <td class="hide"><input id="id_<?= $i ?>" value="<?php if(!empty($antenne->id)) echo ($antenne->id) ?>"/></td>
                                    <td><?= h(count($antenne->bornes)) ?></td>
                                    <td><?php if(!empty($antenne->responsables)) echo $antenne->responsables[0]->full_name ;?></td>
                                    <td><?php $fondverts = ["0"=>"Non", ""=>"Non", "1"=>"Oui"]; echo $fondverts[$antenne->fond_vert] ?></td>
                                    <td><?= h(count($antenne->evenements)) ?></td>
                                    <!--<td><?= $this->Number->format($antenne->cp) ?></td>
                                    <td><?= $antenne->has('lieu_type') ? $this->Html->link($antenne->lieu_type->nom, ['controller' => 'LieuTypes', 'action' => 'view', $antenne->lieu_type->id]) : '' ?></td>
                                    <td><?= h($antenne->longitude) ?></td>
                                    <td><?= h($antenne->latitude) ?></td>
                                    <td><?= $antenne->has('etat') ? $this->Html->link($antenne->etat->valeur, ['controller' => 'Etats', 'action' => 'view', $antenne->etat->id]) : '' ?></td>
-->
                                    <td >
                                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $antenne->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
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

<div class="form-group row" id="div_map_antennes">
     <div class="col-md-12">
           <div id="mapCanvas" style="width:auto; height:450px;"></div>
             <div class="kl_infoForm"></div>
      </div>
</div>
