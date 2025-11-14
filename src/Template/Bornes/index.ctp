<?= $this->Html->script('bornes/refresh.js', ['block' => true]); ?>
<?= $this->Html->script('bornes/index.js?time='.time(), ['block' => true]); ?>

<?= $this->Html->css('borne.css?time='.time(), ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>


<?php
$titrePage = $parcEntity != null?"$parcEntity->ariane_titre":"Vue d'ensemble des bornes" ;

if($parcEntity != null && $parcEntity->ariane_titre) {
    $this->assign('title', $parcEntity->ariane_titre);
}

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
$customFinderOptions['action'] = 'map';
if($parc_type){
    $customFinderOptions[] = $parc_type;
}

$this->start('actionTitle');
    echo $this->Html->link('Ajouter',['action'=>'add'],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-rounded btn-success" ]);

    echo $this->Html->link('import',['action'=>'import'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ,'style'=>'margin: 0 10px 0 0']);

    if($parc_type != 3) {
            echo $this->Html->link('Vue map',$customFinderOptions,['escape'=>false,"class"=>"btn btn-rounded btn-primary pull-right menu-list-map" ,'style'=>'margin: 0 10px 0 0']);
    }
      
    echo $this->Html->link('Export Pdf',['action'=>'index',0, 'pdf'],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-rounded btn-success m-r-5" , 'target'=>"_blank"]);

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
                        <div class="filter-list-wrapper borne-filter-wrapper">
                            <div class="filter-block">
                                <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                            </div>
                            <div class="filter-block">
                                <?php echo $this->Form->control('gamme', ['label' => false ,'options'=> $gammeBornes, 'value'=> $gamme, 'id' => 'gamme_borne_id', 'class'=>'form-control' ,'empty'=> 'Gamme'] );?>
                            </div>
                            <div class="filter-block">
                                <?php echo $this->Form->control('model',  ['options' => $models, 'label' => false , 'id' => 'model_borne_id', 'value'=> $model, 'class'=>'form-control' ,'empty'=>'Modèle'] );?>
                            </div>


                            <?php if (in_array($parc_type, [1, 4, 9]) || $parc_type == null): ?>
                            <div class="filter-block">
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
                            <div class="filter-block <?= $parc_type==null?'optional-filter d-none':'';?>">
                                <?php echo $this->Form->control('antenne', [
                                    'label' => false ,
                                    'options'=>$antennes,
                                    'value'=> $antenne,
                                    'empty'=>'Antenne',
                                    'class' => 'selectpicker',
                                    'data-live-search' => true,
                                    'empty' => "Antenne"
                                ] );?>
                            </div>
                            <?php endif ?>
                            <div class="filter-block optional-filter d-none">
                                <?php echo $this->Form->control('couleur', ['label' => false ,'options'=>$couleurs, 'value'=> $couleur, 'class'=>'form-control' ,'empty'=>'Couleur'] );?>
                            </div>

                            <div class="filter-block optional-filter d-none">
                                <?php echo $this->Form->control('connexion', ['label' => false ,'options'=>$connexions, 'value'=> $connexion, 'class'=>'form-control' ,'empty'=>'Etat connexion'] );?>
                            </div>

                            <?php foreach($equipements as $typeEquipement =>  $equimentOptions): ?> <!-- On boucle chaque type equipemet filtrable -->
                                <div class="filter-block optional-filter d-none">
                                    <?php echo $this->Form->control('equipement[]', ['label' => false ,'options'=>$equimentOptions, 'value'=> $equipement, 'class'=>'form-control' ,'empty'=>$typeEquipement]);?>
                                </div>
                            <?php endforeach ?>

                            <div class="filter-block optional-filter d-none">
                                <?php echo $this->Form->control('contrat', ['label' => false ,'options'=>$contrats, 'value'=> $contrat, 'class'=>'form-control' ,'empty'=>'Type de contrat'] );?>
                            </div>

                            <?php
                                /*on va ajouter le filtre de recherche "Sous-location : oui / non" sur  :
                                - la page vue d'ensemble (tableau et map)
                                - la page des locations finacières (tableau et map)
                                - la page des ventes (tableau et map)*/
                            ?>
                            <?php if (in_array($parc_type, [1, 4,9]) || $parc_type == null): ?>
                                <div class="filter-block">
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

                            <div class="filter-block optional-filter d-none">
                                <?php echo $this->Form->control('user_id', ['label' => false ,'options'=>$users, 'value'=> $user_id, 'class'=>'form-control' ,'empty'=>'Commercial'] );?>
                            </div>

                            <div class="filter-block">
                                <div class="form-group">
                                    <?php echo $this->Form->hidden('more_filter', ['value' => $more_filter, 'class' => 'input_more_filter']);?>
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                    <?php echo $this->Html->link('<i class="fa fa-refresh"></i>',['controller' => 'Bornes', 'action' => 'index', $parc_type],["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
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
                    <div class="float-right my-auto "><?= $countBorneByGamme ?> Nombre de bornes : <?= $this->Paginator->counter('{{count}}') ?></div>
                </div>
                <div class="table-responsive" id="div_table_bornes">
                    <?php if ($parcEntity == null || ($parcEntity && $parcEntity->id == 11)) : ?>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('numero', 'Borne') ?></th>
                                    <th><?= $this->Paginator->sort('numero_serie', 'Num série') ?></th>
                                    <th><?= $this->Paginator->sort('Parcs.nom', 'Parc') ?></th>
                                    <th><?= $this->Paginator->sort('Clients.nom', 'Client') ?></th>
                                    <th><?= $this->Paginator->sort('GroupeClients.nom', 'Réseau') ?></th>
                                    <th><?= $this->Paginator->sort('Antennes.ville_principale', 'Ville') ?></th>
                                    <th><?= $this->Paginator->sort('GammesBornes.name', 'Gamme') ?></th>
                                    <th><?= $this->Paginator->sort('ModelBornes.nom', 'Modèle') ?></th>
                                    <th><?= $this->Paginator->sort('sortie_atelier', 'Sortie atelier') ?></th>
                                    <th><?= $this->Paginator->sort('Users.nom', 'Opérateur') ?></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bornes as $key => $borne): ?>
                                    <tr>
                                        <td>
                                            <?php
                                                $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                                                echo $this->Html->link(($text), ['action' => 'view', $borne->id])
                                            ?>
                                        </td>
                                        <td><?= $borne->numero_serie; ?></td>
                                        <td><?= $borne->parc->nom == 'Location'?'Parc locatif':$borne->parc->nom;?></td>
                                        <td><?= $borne->has('client') ? ($borne->client->enseigne ? $borne->client->nom . ' - ' . $borne->client->enseigne : $borne->client->nom) :($borne->has('antenne') ? 'Selfizee':'-');?></td>
                                        <td><?= $borne->has('client') ? ($borne->client->groupe_client?$borne->client->groupe_client->nom:'-') : '-' ?></td>
                                        <td><?= $borne->has('client') ? $borne->client->ville : ($borne->has('antenne') ? $borne->antenne->ville_principale:'') ?></td>
                                        <td><?= $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->name : '' ?></td>
                                        <td><?= $borne->has('model_borne') ? $borne->model_borne->nom : '' ?></td>
                                        <td><?= $borne->sortie_atelier?$borne->sortie_atelier->format('d/m/y'):"-" ?> </td>
                                        <td><?= $borne->has('operateur') ? $borne->operateur->full_name_short : '' ?></td>

                                        <td>
                                            <div class="dropdown d-inline container-bornes-actions inner-table-menu">
                                                <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                <div class="dropdown-menu customized-scrollbar" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'addActuborne', $borne->id, $borne->parc_id]) ?>">Ticket</a>
                                                    <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'edit', $borne->id]) ?>">Modifier fiche</a>
                                                    <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $borne->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <?= $this->element('tfoot_pagination') ?>


                    <?php elseif ($parcEntity->id == 1 /*Vente*/): ?>
                        <?= $this->element('../Bornes/bornes_ventes') ?>
                    <?php elseif($parcEntity->id == 4 && @$is_list_contrat == 1): ?>
                        <?= $this->element('../Bornes/contrat_locfi') ?>
                    <?php elseif($parcEntity->id == 4): ?>
                        <?= $this->element('../Bornes/bornes_locafi') ?>
                    <?php elseif($parcEntity->id == 2/*Parc locatif*/): ?>
                        <?= $this->element('../Bornes/bornes_locations') ?>
                    <?php elseif($parcEntity->id == 3/*ST*/): ?>
                        <?= $this->element('../Bornes/bornes_stocktampons') ?>
                    <?php elseif($parcEntity->id == 9/*Location longue durée*/): ?>
                        <?= $this->element('../Bornes/bornes_longuedurees') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


