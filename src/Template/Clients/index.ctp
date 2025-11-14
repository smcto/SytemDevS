<?= $this->Html->script('Clients/clients.js', ['block' => true]); ?>
<?= $this->Html->css('clients/client.css', ['block' => true]) ?>
<?php
$titrePage = "Liste des clients" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

    
$this->start('actionTitle');
?>

   <a href="#" id="id_syncrho" class="btn pull-right hidden-sm-down btn-success btn-rounded">Synchroniser</a>
    <div class="pull-right loadingClient">
        <svg class="kl_loadingclient" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
<?php 
$this->end();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                           <?php  echo $this->Form->create(null, ['type' => 'get' ,'role'=>'form']);   ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);  ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php $typeOptions = array('corporation'=>'Professionnel','person'=>'Particulier');
                                        echo $this->Form->control('type', ['label' => false ,'options'=>$typeOptions, 'value'=> $type, 'class'=>'form-control' ,'empty'=>'Sélectionnez le type '] );?>
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );?>
                                        <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                                    </div>
                                </div>

                            <?php echo $this->Form->end(); ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><?= h($client->nom) ?></td>
                                    
                                    <td>
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $client->id]) ?>
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
