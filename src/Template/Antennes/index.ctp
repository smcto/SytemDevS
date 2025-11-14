<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Antenne[]|\Cake\Collection\CollectionInterface $antennes
 */
?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php echo $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?php echo $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('antennes/antennes.js', ['block' => true]); ?>
<?= $this->Html->script('antennes/filtres.js', ['block' => true]); ?>

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

$customFinderOptions;
$mapFinderOptions = ['action' => 'map'];
$mapFinderOptions = array_merge($customFinderOptions, $mapFinderOptions);

$excelFinderOptions = ['action' => 'index', 'xlsx'];
$excelFinderOptions = array_merge($customFinderOptions, $excelFinderOptions);

$this->start('actionTitle');
    echo $this->Html->link('Ajouter',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-l-5"]);
    echo $this->Html->link('Export Excel',$excelFinderOptions,['escape'=>false,"class"=>"btn btn-rounded btn-primary pull-right menu-list-map m-l-5"]);
    echo $this->Html->link('Vue map',$mapFinderOptions,['escape'=>false,"class"=>"btn btn-rounded btn-primary pull-right menu-list-map"]);

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
                            <div class="filter-list-wrapper antenne-filter-wrapper">
                                <div class="filter-block">
                                    <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Recherche...']); ?>
                                </div>

                                <div class="filter-block">
                                    <?php echo $this->Form->control('etat',['label' => false, 'class'=>'form-control custom-select selectpicker ', 'value'=>$etat, 'options'=>$etats, 'empty'=>'Séléctionner un etat']);?>
                                </div>
                                <div class="filter-block">
                                    <?php echo $this->Form->control('ville_principale',['label' => false, 'class'=>'form-control custom-select selectpicker', 'data-live-search' => true, 'value'=>$ville_principale, 'options'=>$ville_principales, 'empty'=>'Ville principale']);?>
                                </div>
                                <div class="filter-block">
                                    <?php echo $this->Form->control('sous_antenne',['label' => false, 'class'=>'form-control custom-select selectpicker', 'data-live-search' => true, 'value'=>$sous_antenne, 'options'=>['2' => 'Antennes principales', '1' => 'Sous Antennes'], 'empty'=>'Antennes']);?>
                                </div>

                                <div class="filter-block hide">
                                    <?php echo $this->Form->control('fondvert',['type' => 'select', 'label' => false,'value'=>$fondvert, 'options'=>$fondVerts, 'required'=>false, 'empty'=>'Fond vert', 'class'=>'selectpicker', 'id'=>'fond_vert']);?>
                                </div>
                                <div class="filter-block">
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                </div>
                                <?php echo $this->Form->end();?>
                            </div>
                        </div>
                </div>
                <!--<div class="button-group">
                        <button  type="button" id="btn_list" class="btn btn-lg btn-success fa fa-list active" data-target="#div_table_antennes"> Vue liste</button>
                        <button  type="button" id="btn_map" class="btn btn-lg btn-success fa fa-link" data-target="#div_map_antennes"> Vue map</button>
                 <div><hr>-->

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
                                <h1 class="font-light text-white"><?= $nbrVillePrincipales ?></h1><h6 class="text-white">Villes principales</h6>
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

                </div>
                <div class="table-responsive" id="div_table_antennes">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Antenne</th>
                                <th>Ville réelle</th>
                                <th>Sous antenne</th>
                                <th>Total</th>
                                <?php  foreach ($gammes as $gamme) : ?>
                                <th> <?= $gamme->name ?> </th>
                                <?php endforeach;?>
                                <th>Contact(s)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php  foreach ($antennes as $antenne):?>
                                
                                <tr>
                                    <td><?= $this->Html->link($antenne->sous_antenne?$antenne->parent_antenne->ville_principale:$antenne->ville_principale, ['action' => 'view', $antenne->id]) ?></td>
                                    <td><?= $antenne->ville_excate ?></td>
                                    <td><?= $antenne->sous_antenne?'oui':'non'; ?></td>
                                    <td><?= count($antenne->bornes)?h(count($antenne->bornes)):"-" ?></td>
                                    <?php  foreach ($gammes as $gamme) : ?>
                                    <td> 
                                        <?php 
                                                    $count = count(array_filter($antenne->bornes,function($k,$v) use($gamme) {
                                                        return $k->model_borne->gamme_borne_id == $gamme->id;
                                                    },ARRAY_FILTER_USE_BOTH));
                                                    echo $count?$count:"-";
                                        ?> 
                                    </td>
                                    <?php endforeach;?>
                                    <td><?= $antenne->users? $this->Html->link(count($antenne->users), ['controller' => 'Users', 'actions' => 'index', 1, 'antenne'=> $antenne->id]) : "-" ?></td>
                                    <td >
                                        <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'edit', $antenne->id], ['escape'=>false]) ?>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $antenne->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
