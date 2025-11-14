<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Licence[]|\Cake\Collection\CollectionInterface $licences
 */
?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>



<?php
$titrePage = "Liste des licences" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);
$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
    echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success", "style"=>"margin-left: 5px;" ]);
$this->end();

?>


<div class="row hide">
    <div class="col-lg-12 col-md-12">
        <div class="">
            <div class="card-body">
                <div class="form-body filtre">
                    <div class="row">
                        <?php
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);

                        echo $this->Form->control('type',['type' => 'select', 'label' => false, 'value'=>$type, 'options'=>$types, 'required'=>false, 'empty'=>'Types', 'class'=>'selectpicker']);
                        echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Numero série...']);
                        echo $this->Form->control('email',['value'=>$email, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Email...']);
                        echo $this->Form->control('version',['value'=>$version, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Version...','style'=>'margin: 0 10px 0 0']);
                        echo $this->Form->control('dispo',['type' => 'select', 'label' => false, 'options'=> ['0' => 'Non disponible', '1' => 'Disponible'], 'required'=>false, 'empty'=>'Disponibilité', 'class'=>'selectpicker']);

                        echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary','style'=>'margin: 0 10px 0 0'] );
                        echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false,'style'=>'margin: 0 10px 0 0']);
                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                        <div class="filter-list-wrapper licence-filter-wrapper">
                            <div class="filter-block">
                                <?= $this->Form->control('type',['type' => 'select', 'label' => false, 'value'=>$type, 'options'=>$types, 'required'=>false, 'empty'=>'Types', 'class'=>'selectpicker']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Numero série...']);?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('email',['value'=>$email, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Email...']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('version',['value'=>$version, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Version...','style'=>'margin: 0 10px 0 0']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->control('dispo',['type' => 'select', 'label' => false, 'value' => $dispo, 'options'=> ['0' => 'Non disponible', '1' => 'Disponible'], 'required'=>false, 'empty'=>'Disponibilité', 'class'=>'selectpicker']); ?>
                            </div>
                            <div class="filter-block">
                                <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary','style'=>'margin: 0 10px 0 0'] ); ?>
                                <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false,'style'=>'margin: 0 10px 0 0']); ?>                        
                            </div>

                             <?= $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" >
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Numéro série</th>
                                <th>Type </th>
                                <th>Date achat</th>
                                <th>Date renouvellement</th>
                                <th>Borne(s)</th>
                                <th>Email</th>
                                <th>Version</th>
                                <th>Disponible</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php  foreach ($licences as $licence):?>
                                <tr>
                                    <td><?= $this->Html->link($licence->numero_serie, ['action' => 'view', $licence->id]) ?></td>
                                    <td><?= h($licence->type_licence->nom)  ?></td>
                                    <td><?= h($licence->date_achat)  ?></td>
                                    <td><?= h($licence->date_renouvellement)  ?></td>
                                    <td>
                                        <?php
                                        if(!empty($licence->bornes)){
                                             $all = array();
                                             foreach($licence->bornes as $borne){
                                                array_push($all, $this->Html->link($borne->format_numero, ['controller' => 'Bornes', 'action' => 'view', $borne->id]));
                                             }
                                             echo $this->Text->toList($all, ', ', ', ');
                                        }
                                        ?>
                                        </td>
                                    <td><?= h($licence->email)  ?></td>
                                    <td><?= h($licence->version)  ?></td>
                                    <td><i class="fa fa-circle <?= $licence->dispo?'paid':'expired' ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= $licence->dispo?'Disponible':'Non disponible' ?>" data-original-title="Brouillon"></i> <?= @$devis_status[$devis->status] ?></td>
                                    <td >
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $licence->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
