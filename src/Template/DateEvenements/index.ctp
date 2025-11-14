<?= $this->Html->css('calendar/fullcalendar.css', ['block' => true]) ?>

<?= $this->Html->script('calendar/jquery-ui.min.js',['block'=>true]) ?>
<?= $this->Html->script('moment/moment.js',['block'=>true]) ?>
<?= $this->Html->script('calendar/dist/fullcalendar.min.js',['block'=>true]) ?>
<?= $this->Html->script('calendar/dist/locale-all.js',['block'=>true]) ?>
<?php $langue = $lang ; if($lang == "en") $langue = "en-gb"; ?>
<?php echo $this->Html->script('calendar/dist/locale/'.$langue.'.js',['block'=>true]) ?>
<?php echo $this->Html->script('evenements/agenda.js',['block'=>true]) ?>

<?php
$titrePage = "Agenda";
    
$this->assign('title', $titrePage);

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
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="form-body">
                    <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']); ?>
                    <div class="filter-list-wrapper date-evenement-filter-wrapper">
                        <div class="filter-block">
                            <?php echo $this->Form->control('key',['id'=>'key','value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                        </div>
                        <div class="filter-block">
                            <?php echo $this->Form->control('type_evenement', ['id'=>'type_evenement', 'label' => false ,'options'=>$typeEvenements, 'value'=> $type_evenement, 'class'=>'form-control' ,'empty'=>'Type événements'] ); ?>
                        </div>
                        <div class="filter-block">
                            <?php echo $this->Form->control('type_animation', ['id'=>'type_animation', 'label' => false ,'options'=>$typeAnimations, 'value'=> $type_animation, 'class'=>'form-control' ,'empty'=>'Type animation'] ); ?>
                        </div>
                        <div class="filter-block">
                            <?php echo $this->Form->control('antenne', ['id'=>'antenne', 'label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Antenne'] ); ?>
                        </div>
                        <div class="filter-block">
                            <?php echo $this->Form->control('type_client', ['id'=>'type_client', 'label' => false ,'options'=>$clientTypes, 'value'=> $type_client, 'class'=>'form-control' ,'empty'=>'Type client'] ); ?>
                        </div>
                        <div class="filter-block filter-btn-wrapper">
                            <?php
                            echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );
                            echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]); ?>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!--<div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Drag and Drop Your Event</h4>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="calendar-events" class="m-t-20">
                            <div class="calendar-events" data-class="bg-info"><i class="fa fa-circle text-info"></i> My Event One</div>
                            <div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>
                            <div class="calendar-events" data-class="bg-danger"><i class="fa fa-circle text-danger"></i> My Event Three</div>
                            <div class="calendar-events" data-class="bg-warning"><i class="fa fa-circle text-warning"></i> My Event Four</div>
                        </div>
                        &lt;!&ndash; checkbox &ndash;&gt;
                        <div class="checkbox">
                            <input id="drop-remove" type="checkbox">
                            <label for="drop-remove">
                                Remove after drop
                            </label>
                        </div>
                        <a href="#" data-toggle="modal" data-target="#add-new-event" class="btn btn-lg m-t-40 btn-danger btn-block waves-effect waves-light">
                            <i class="ti-plus"></i> Add New Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN MODAL -->
<div class="modal none-border" id="my-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Edition</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div id="edit_infos"></div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create event</button>
                <button type="button" class="btn btn-danger delete-event waves-effect waves-light" data-dismiss="modal">Delete</button>
            </div>-->
        </div>
    </div>
</div>
