<?= $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js', ['block' => true]); ?>


<?= $this->Html->css('evenements/pipeline.css', ['block' => true]) ?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php //echo $this->Html->script('moment/moment.js',['block'=>true]) ?>
<?= $this->Html->script('daterangepicker/daterangepicker.js',['block'=>true]) ?>

<?php echo $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?php echo $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->script('evenements/pipeline.js', ['block' => true]); ?>

<?php
$titrePage = "Vue pipeline - ".$pipe->nom ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();



?>


<?php //debug($etapes->toArray()); die; ?>

<div class="card">
<div class="card-body">
    <div class="row">
           <?php
            echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
            
            echo $this->Form->control('pipe', ['label' => false ,'options'=>$allPipes, 'value'=> $idPipe, 'class'=>'form-control' ,'empty'=>'Choisir une vue'] );
                   echo $this->Form->control('numero_borne',['type'=>'number', 'value'=>$numero_borne, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Numero borne']);

                   echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Séléctionnez une antenne'] );
                   echo $this->Form->control('type_evenement', ['label' => false ,'options'=>$type_evenements, 'value'=> $type_evenement, 'class'=>'form-control' ,'empty'=>'Type événement'] );
                   echo $this->Form->control('type_animation', ['label' => false ,'options'=>$type_animations, 'value'=> $type_animation, 'class'=>'form-control' ,'empty'=>'Type animation'] );
                   echo $this->Form->control('type_client', ['label' => false ,'options'=>$type_clients, 'value'=> $type_client, 'class'=>'form-control' ,'empty'=>'Type client'] );
                   $type = array('w_'.(date('W')-2)=>'Semaine dernière', 'm_'.(date('m') - 1) => 'Mois dernier ', 'w_'.(date('W')-1)=>'Cette semaine', 'm_'.date('m') => 'Ce mois-ci');
                   echo $this->Form->control('periodeType',['default'=>$periodeType, 'label' => false, 'options'=>$type,'empty'=>'Période','class'=>'form-control']);

                   echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );
                   echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'pipeline'], ["data-toggle"=>"tooltip", "class"=>"btn btn-outline-dark", "escape"=>false]);

                   echo $this->Form->end();
              ?>
    </div>
</div>
</div>
<div class="m_wrap">
    <div class="dx">
        <?php foreach($etapes as $etape){
                $type_clients = ['person'=>'Particulier', 'corporation'=>'Professionel'];?>
        <div class="xc">
            <div class="kl_titreEtape"><?= $etape->nom ?></div>
            <div class="kl_contentEtape">
                <ul class="kl_listeEtape" id="id_liste_<?= $etape->id ?>">
                    <?php foreach($etape->evenements as $evenement){ ?>
                    <li data-item="<?= $evenement->_joinData->id ?>">
                        <span style="font-size: 13px;">
                            <?php $dates = [];
                                    if(!empty($evenement->date_evenements)) {
                                        foreach($evenement->date_evenements as $date_event) {
                                            $dates [] = $date_event->date_debut->format('d/m/y')." - ".$date_event->date_fin->format('d/m/y');
                                        }
                                        echo '<b>'.implode('<br> ',  $dates).'</b>';
                                    }
                            ?><br>
                            <b>Nom :</b><?= $this->Html->link($evenement->nom_event, ['action' => 'edit', $evenement->id]);?><br>
                            <?php if(!empty($evenement->client)){ ?>
                                <b>Client :</b><?= $evenement->client->nom ?><br>
                                <?= $type_clients[$evenement->client->client_type] ?><br>
                            <?php } ?>
                            <?php if(!empty($evenement->type_animation)){ ?>
                                <b>Type Animation :</b><?= $evenement->type_animation->nom ?><br>
                            <?php } ?>
                            <?php if(!empty($evenement->lieu_exact)){ ?>
                                <b>Lieu :</b> <?= $evenement->lieu_exact ?><br>
                            <?php } ?>
                            <?php if(!empty($evenement->antenne)){ ?>
                                <b>Antenne :</b><?= $evenement->antenne->ville_principale ?><br>
                            <?php } ?>
                            <?php if(!empty($evenement->borne)){ ?>
                                <b>Borne :</b><?= $evenement->borne->numero ?>
                            <?php } ?>
                        </span>
                    </li>
                    <?php } ?>
                </ul>
                <!--<div class="kl_addEvenentInEtapePipe">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEvenement_<?= $etape->id ?>" data-whatever="@mdo"><i class="mdi mdi-near-me"></i> <?= __('Ajouter un événement') ?></button>
                </div>-->
            </div>
        </div>
        <?php echo $this->element('add_event_etape',['evenements'=>$evenements,'etape'=>$etape]) ?>
        <?php } ?>
        
       
    </div>
</div>
