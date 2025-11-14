<?= $this->Html->script('ventes/dashboard.js?' . time(), ['block' => true]); ?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('chart/chart.min.js', ['block' => true]); ?>
<?= $this->Html->script('chart/utils.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>

<?= $this->Html->css('ventes/dashboard.css?' . time(), ['block' => true]) ?>


<?php
$titrePage = "Tableau de bord vente" ;

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


$this->start('actionTitle');

?>

<b class="font-medium"><?= $periodeString ?></b>
<a href="javascript:void(0)" class="btn btn-success btn-rounded pull-right hidden-sm-down" id="show_period">Edit periode</a>

<?php
$this->end();
?>


<div class="row filter d-none">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-body">
                    <?php echo $this->Form->create(null, ['type' => 'post' ,'class'=>'','role'=>'form']); ?>

                        <div class="row clearfix">
                            <div class="container-filter col-md-2">
                                <?php 
                                    echo $this->Form->control('type',[
                                        'label'=>false, 
                                        'id' => 'type',
                                        'class'=>'form-control search',
                                        'options'=>['mensuel' => 'Mois','annuel' => 'Année','periode' => 'Periode'],
                                        'empty'=>'Type',
                                        'value' => $typePeriode,
                                        'style' => 'width:100%'
                                    ]);
                                ?>
                            </div>

                            <div class="mois col-md-2 p-l-0 <?= $typePeriode=="mensuel"?'':'d-none' ?>" >
                                <?php 
                                echo $this->Form->control('mensuel', [
                                    'label' => false ,
                                    'id' => 'mois',
                                    'class'=>'form-control select2' ,
                                    'empty'=>'Mois',
                                    'data-placeholder' => 'Mois',
                                    'options' => $mois,
                                    'value' => $mensuel,
                                    'style' => 'width:100%'
                                ] );?>
                            </div>

                            <div class="annees col-md-2 p-l-0 <?= ($typePeriode=="mensuel" || $typePeriode=="annuel")?'':'d-none' ?>">
                                <?php 
                                echo $this->Form->control('annuel', [
                                    'label' => false ,
                                    'id' => 'annees',
                                    'class'=>'form-control select2',
                                    'empty'=>'Année',
                                    'data-placeholder' => 'Année',
                                    'options' => $annees,
                                    'value' => $annuel,
                                    'style' => 'width:100%'
                                ] );?>
                            </div>

                            <div class="periode col-md-2 p-l-0 <?= $typePeriode=="periode"?'':'d-none' ?>">
                                <input type="date" name="date_debut" class="form-control" id="periode" value="<?= $dateDebut ?>">
                            </div>
                            
                            <div class="periode col-md-2 p-l-0 <?= $typePeriode=="periode"?'':'d-none' ?>">
                                <input type="date" name="date_fin" class="form-control"  id="periode" value="<?= $dateFin ?>">
                            </div>

                            <div class="container-filter col-md-2 p-l-0">
                                <?php echo $this->Form->button(__('Save'), ['label' => false ,'class' => 'btn btn-primary btn-rounded'] );?>
                            </div>

                        </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="card-group">
        <div class="card">
                <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-medium"><?= $this->Number->format($totalVente) ?></h2>
                                    </div>
                                    <h6 class="text-muted font-normal mb-0 w-100 text-truncate">Nombre Ventes</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fa fa-file-text-o font-20 mr-2"></i>
                                    </span>
                                </div>
                            </div>
                </div>
        </div>
        <div class="card">
                <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-medium"><?= $this->Number->currency($totalCa) ?></h2>
                                    </div>
                                    <h6 class="text-muted font-normal mb-0 w-100 text-truncate">CA Ventes</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fa  fa-eur font-20 mr-2"></i>
                                    </span>
                                </div>
                            </div>
                </div>
        </div>
        <div class="card">
                <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-medium"><?= $totalCons ?></h2>
                                    </div>
                                    <h6 class="text-muted font-normal mb-0 w-100 text-truncate">Nombre Ventes Consommable</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fa fa-shopping-cart  font-20 mr-2"></i>
                                    </span>
                                </div>
                            </div>
                </div>
        </div>
        <div class="card">
                <div class="card-body">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-medium">0 </h2>
                                    </div>
                                    <h6 class="text-muted font-normal mb-0 w-100 text-truncate">CA Ventes Consommable</h6>
                                </div>
                                <div class="ml-auto mt-md-3 mt-lg-0">
                                    <span class="opacity-7 text-muted">
                                        <i class="fa fa-eur  font-20 mr-2"></i>
                                    </span>
                                </div>
                            </div>
                </div>
        </div>
</div>

<div class="row">
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Répartition ventes</h4>
                        <div class="box" id="box_vente_parc">
                            <div id="chart_vente" class="text-center chart-doughnut">
                                <canvas id="canvas_chart_vente"></canvas>
                            </div>
                            <ul class="list-style-none mb-0"  id="legende_vente">
                                <?php foreach ($legendeVenteParc as $vente) : ?>
                                <li class="mt-2"><i class="fa fa-circle font-14 mr-2" style="color: <?= $vente['color'] ?>"></i><span class="text-muted font-light mx-2"><?= $vente['name'] ?></span> <span class="text-dark float-right font-medium"><?= $vente['y'] ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Evolutions par mois ventes</h4>
                        <div class="box text-center">
                            <div id="chart_vente_month" class="chart-month">
                                <canvas id="canvas_chart_vente_month"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>


<div class="row">
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Répartition ventes par gamme</h4>
                        <div class="box" id="box_vente_gamme">
                            <div id="chart_vente_gamme" class="chart-doughnut">
                                <canvas id="canvas_chart_vente_gamme"></canvas>
                            </div>
                            <ul class="list-style-none mb-0" id="legende_vente_gamme">
                                <?php foreach ($legendeVenteGamme as $vente) : ?>
                                <li class="mt-2"><i class="fa fa-circle font-14 mr-2"  style="color: <?= $vente['color'] ?>"></i><span class="text-muted font-light mx-2"><?= $vente['name'] ?></span> <span class="text-dark float-right font-medium"><?= $vente['y'] ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Evolutions par mois ventes par gamme</h4>
                        <div class="box text-center text-muted">
                            <div id="chart_vente_gamme_month" class="chart-month">
                                <canvas id="canvas_chart_vente_gamme_month"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
</div>


<div class="row">
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Répartition des ventes consommables par type</h4>
                        <div class="box" id="box_vente_cons">
                            <div id="chart_vente_cons" class="chart-doughnut">
                                <canvas id="canvas_chart_vente_cons"></canvas>
                            </div>
                            <ul class="list-style-none mb-0" id="legende_vente_cons">
                                <?php foreach ($legendeVenteTypeCons as $vente) : ?>
                                <li class="mt-2"><i class="fa fa-circle font-14 mr-2"  style="color: <?= $vente['color'] ?>"></i><span class="text-muted font-light mx-2"><?= $vente['name'] ?></span> <span class="text-dark float-right font-medium"><?= $vente['y'] ?></span></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Evolutions par mois ventes par type de client</h4>
                        <div class="box text-center">
                            <div id="chart_vente_client_month" class="chart-month">
                                <canvas id="canvas_chart_vente_client_month"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Activité récente</h4>
                        <div class="mt-4 activity">
                            <?php foreach ($activities as $activity) : ?>
                                    <div class="d-flex align-items-start border-left-line pb-3">
                                        <div>
                                            <a href="javascript:void(0)" class="btn btn-circle mb-2 btn-item <?= $activity['color'] ?>">
                                                <i class="fa fa-shopping-cart  font-20 mr-2 white-box"></i>
                                            </a>
                                        </div>
                                        <div class="ml-3 mt-2">
                                            <h5 class="text-dark font-weight-medium mb-2"><?= $activity['byDate']?'':'Nouvelle' ?> <?= $activity['title'] ?></h5>
                                            <p class="font-14 mb-2 text-muted">
                                                User : <?= $activity['user'] ?> <br> 
                                                Client : <?= $activity['client'] ?>
                                            </p>
                                            <span class="font-weight-light font-14 text-muted"><?= $activity['byDate']?$activity['date']->format('d-M-Y H:i'):$activity['time'] ?></span>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
        </div>
</div>


<div class="row">
    <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top vendeurs</h4>
                    
                    <div class="table-responsive">
                        <table class="table contact-list text-muted">
                            <thead>
                                <tr>
                                    <th width="20%">Nom et prénom</th>
                                    <th width="15%">Total ventes</th>
                                    <?php foreach ($parcs as $parc_name => $parc_id) : ?>
                                        <th><?= $parc_name ?></th>
                                    <?php endforeach; ?>
                                    <th width="15%">Total cumulé</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php  foreach ($userVentes as $vente): ?>
                                    <tr>
                                        <td><?= $this->Html->link($this->Html->image($vente['user']->url_photo,['class'=>'img-circle']).'  '.$vente['user']->full_name,
                                            ['action' => 'view', $vente['user']->id], ['escape'=>false]) ?>
                                        </td>
                                        <td><?= $this->Number->currency($vente['total']['sum']) ?><br> <?= $vente['total']['nb'] ?> contrats</td>
                                        <?php foreach ($parcs as $parc_name => $parc_id) : ?>
                                            <td><?= $this->Number->currency($vente[$parc_name]['sum']) ?><br> <?= $vente[$parc_name]['nb'] ?> contrats</td>
                                        <?php endforeach; ?>
                                        <td><?= $this->Number->currency($vente['cumule']['sum']) ?></td>
                                        <td><?= $this->Html->link(__('Ventes'),['action' => 'index', 'user' => $vente['user']->id], ['escape'=>false]) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script type="text/javascript">
    var dataParcs = <?php echo json_encode($dataParcs) ?>;
    var dataParcByMonth = <?php echo json_encode($dataParcByMonth) ?>;
    var dataGammes = <?php echo json_encode($dataGammes) ?>;
    var dataGammeByMonth = <?php echo json_encode($dataGammeByMonth) ?>;
    var dataTypeCons = <?php echo json_encode($dataTypeCons) ?>;
    var dataClientByMonth = <?php echo json_encode($dataClientByMonth) ?>;
</script>
