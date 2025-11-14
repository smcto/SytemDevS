<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evenement[]|\Cake\Collection\CollectionInterface $evenements
 */
?>
<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>


<?php
$titrePage = "Liste des événements" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
echo $this->Html->link('Vue map',['action'=>'map'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary",'style'=>'margin: 0 10px 0 0' ]); 
echo $this->Html->link('Vue pipeline',['action'=>'pipeline'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary" ,'style'=>'margin: 0 10px 0 0' ]);
                        
$this->end();

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="button-group">
                </div>
                
                <hr>
                <div class="row-fluid d-block clearfix mt-3">
                    <div class="form-body">
                       <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                      <div class="filter-list-wrapper evenement-filter-wrapper">
                            <div class="filter-block">
                                    <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->control('numero_borne',['type'=>'number', 'value'=>$numero_borne, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Numero borne']);?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Séléctionnez une antenne'] );?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->control('type_evenement', ['label' => false ,'options'=>$type_evenements, 'value'=> $type_evenement, 'class'=>'form-control' ,'empty'=>'Type événement'] );?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->control('type_animation', ['label' => false ,'options'=>$type_animations, 'value'=> $type_animation, 'class'=>'form-control' ,'empty'=>'Type animation'] );?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->control('type_client', ['label' => false ,'options'=>$type_clients, 'value'=> $type_client, 'class'=>'form-control' ,'empty'=>'Type client'] );?>
                            </div>
                            <div class="filter-block">
                                    <?php $type = array('w_'.(date('W')-2)=>'Semaine dernière', 'm_'.(date('m') - 1) => 'Mois dernier ', 'w_'.(date('W')-1)=>'Cette semaine', 'm_'.date('m') => 'Ce mois-ci');
                                    echo $this->Form->control('periodeType',['default'=>$periodeType, 'label' => false, 'options'=>$type,'empty'=>'Période','class'=>'form-control']);?>
                            </div>
                            <div class="filter-block">
                                    <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] ) . ' ';
                                    echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);?>
                            </div>
                      </div>

                        <?php echo $this->Form->end();?>
                        </div>
                </div>
                <div class="table-responsive" id="div_table_evenements">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"  style="width: 16.5%;"><?= $this->Paginator->sort('Date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type_evenement_id', 'Type event') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type_animation_id', 'Type animation') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('antenne_id','Antenne') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('client_id','Client') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('nom_event', 'Nom event') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('lieu_exact','Lieu') ?></th>
                            <th class></th>
                            <th class></th>
                            <th scope="col" class="hide">Latitude</th>
                            <th scope="col" class="hide">Longitude</th>
                        </tr>
                        </thead>
                        <tbody>
                        <input type="text" class="hide"  id="nbevenemnts" value="<?= count($evenements)?>"/>
                        <?php $options = ['1'=>'Nos soins', '2'=>'Retraits', '3'=>'Envoi transporteur'];
                                $clientType = ['corporation'=>'Pro' , 'person'=>'Part' ];
                        $i=-1;
						foreach ($evenements as $evenement):
                        $i= $i+1;
                        ?>
                        <tr>
                            <td><?php $dates = [];
                                if(!empty($evenement->date_evenements)) {
                                    foreach($evenement->date_evenements as $date_event) {
                                        $dates [] = $date_event->date_debut->format('d/m/y')." - ".$date_event->date_fin->format('d/m/y');
                                    }
                                    //echo implode(', ',  $dates);
                                    echo $this->Html->link(implode(', ',  $dates), ['action' => 'edit', $evenement->id]);
                                }?>
                            </td>
                            <td><?php if(!empty($evenement->type_evenement)) echo $evenement->type_evenement->nom ?></td>
                            <td><?php if(!empty($evenement->type_animation)) echo $evenement->type_animation->nom[0] ?></td>
                            <td><?= h($evenement->antenne->ville_principale) ?></td>
                            <td><?= $clientType[$evenement->client->client_type]." : ".$evenement->client->nom ?></td>
                            <td><?= $evenement->nom_event ?></td>
                            <td><?= h($evenement->lieu_exact) ?></td>
                            <td>
								<?php echo ($evenement->evenement_brief ? $this->Html->link('<i class="fa fa-cog text-info"></i>', ['action' => 'briefs', $evenement->id], ['escape'=>false, 'target'=>'_blank']) : ''); ?>
							</td>
                            <td>
								<?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $evenement->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
							</td>
                            <td class="hide"><input  id="nom_<?= $i ?>" value="<?= h($evenement->nom_event)?>" /></td>
                            <td class="hide"><input id="lat_<?= $i ?>" value="<?= $evenement->antenne->latitude ?>"/></td>
                            <td class="hide"><input id="lgt_<?= $i ?>" value="<?= $evenement->antenne->longitude ?>"/></td>
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
