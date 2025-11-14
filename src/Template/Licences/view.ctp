<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Licence $licence
 */
?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php //echo $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?php //echo $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>


<?php
$titrePage = "Détail licence" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();


?>

<div class="row">
    <div class="col-lg-6">
            <div class="card">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h2 class="m-b-0 text-white">INFORMATION GENERALES</h2>
                    </div>
                </div>
                <div class="card-body">
                <form class="form p-t-20">


                    <div class="form-group row">
                        <label class="control-label col-md-4">Type licence: </label>
                        <div class="col-md-8">
                            <p class="form-control-static"> <?= $licence->has('type_licence') ? $this->Html->link($licence->type_licence->nom, ['controller' => 'TypeLicences', 'action' => 'view', $licence->type_licence->id]) : '' ?> </p>
                        </div>
                        <label class="control-label col-md-4">Numero de série: </label>
                        <div class="col-md-8">
                            <p class="form-control-static"> <?= h($licence->numero_serie) ?> </p>
                        </div>
                        <label class="control-label col-md-4">Email: </label>
                        <div class="col-md-8">
                            <p class="form-control-static">
                            <?= h($licence->email) ?>
                            </p>
                        </div>
                        <label class="control-label col-md-4">Version: </label>
                        <div class="col-md-8">
                            <p class="form-control-static"> <?= h($licence->version) ?> </p>
                        </div>
                        <label class="control-label col-md-4">Nombre d'utilisation : </label>
                        <div class="col-md-8">
                            <p class="form-control-static"> <?= h($licence->nombre_utilisateur) ?> </p>
                        </div>
                        <label class="control-label col-md-4">Date achat: </label>
                        <div class="col-md-8">
                            <p class="form-control-static"> <?= h($licence->date_achat) ?> </p>
                        </div>
                        <label class="control-label col-md-4">Date renouvellement: </label>
                        <div class="col-md-8">
                            <p class="form-control-static">
                            <?= h($licence->date_renouvellement) ?>
                            </p>
                        </div>

                    </div>
                    <div class="form-actions">
                      <?php  echo $this->Html->link('Edit',['action' => 'edit', $licence->id],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?>
                    </div>
            </div>
            </div>
        </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h2 class="m-b-0 text-white">LISTE DES BORNES ASSOCIES</h2>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="card card-outline-info">

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Borne numéro </th>
                                                <th>Ville </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php foreach ($licence->bornes as $borne): ?>
                                                <tr>
                                                    <td><?= h($borne->numero) ?></td>
                                                    <td><?= h($borne->ville) ?></td>
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
            </div>
</div>

