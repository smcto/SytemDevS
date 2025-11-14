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
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('evenements/listevenements.js', ['block' => true]); ?>

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
echo $this->Html->link('Vue liste',['action'=>'index'],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-rounded btn-secondary"  ,'style'=>'margin: 0 10px 0 0']);  
$this->end();

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="button-group">
                        <div class="button-group">
                        <div><hr>
                <div class="form-body">
                      <div class="row">
                       <?php
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
                        echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);
                               echo $this->Form->control('numero_borne',['type'=>'number', 'value'=>$numero_borne, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Numero borne']);
                        echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Séléctionnez une antenne'] );

                                echo $this->Form->control('type_evenement', ['label' => false ,'options'=>$type_evenements, 'value'=> $type_evenement, 'class'=>'form-control' ,'empty'=>'Type événement'] );
                                echo $this->Form->control('type_animation', ['label' => false ,'options'=>$type_animations, 'value'=> $type_animation, 'class'=>'form-control' ,'empty'=>'Type animation'] );
                                echo $this->Form->control('type_client', ['label' => false ,'options'=>$type_clients, 'value'=> $type_client, 'class'=>'form-control' ,'empty'=>'Type client'] );
                                $type = array('w_'.(date('W')-2)=>'Semaine dernière', 'm_'.(date('m') - 1) => 'Mois dernier ', 'w_'.(date('W')-1)=>'Cette semaine', 'm_'.date('m') => 'Ce mois-ci');
                                echo $this->Form->control('periodeType',['default'=>$periodeType, 'label' => false, 'options'=>$type,'empty'=>'Période','class'=>'form-control']);

                                echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );
                                echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'map'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);

                        echo $this->Form->end();
                          ?>
                        </div>
                </div>
                <div class="table-responsive" id="div_table_evenements">
                    <table class="hide table">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('nom_event', 'Nom') ?></th>
                            <th class="hide"></th>
                            <th scope="col"><?= $this->Paginator->sort('type_evenement_id', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('client_id','Client') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('antenne_id','Antenne') ?></th>
                            <th scope="col" class="hide">Latitude</th>
                            <th scope="col" class="hide">Longitude</th>
                            <th scope="col"><?= $this->Paginator->sort('lieu_exact','Lieu') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type_installation','Type installation') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <input type="text" class="hide"  id="nbevenemnts" value="<?= count($evenements)?>"/>
                        <?php $options = ['1'=>'Nos soins', '2'=>'Retraits', '3'=>'Envoi transporteur']; $i=-1;
						foreach ($evenements as $evenement):
                        $i= $i+1;
                        ?>
                        <tr>
                            <td><?= $this->Html->link($evenement->nom_event, ['action' => 'edit', $evenement->id]) ?></td>
                            <td class="hide"><input  id="nom_<?= $i ?>" value="<?= h($evenement->nom_event)?>" /><input  id="evenement_<?= $i ?>" value="<?= h($evenement)?>" /></td>
                            <td><?= h($evenement->type_evenement->nom) ?></td>
                            <td><?= h($evenement->client->nom) ?></td>
                            <td><?= h($evenement->antenne->ville_principale) ?></td>
                            <td class="hide"><input id="lat_<?= $i ?>" value="<?= $evenement->antenne->latitude ?>"/></td>
                            <td class="hide"><input id="lgt_<?= $i ?>" value="<?= $evenement->antenne->longitude ?>"/></td>
                            <td><?= h($evenement->lieu_exact) ?></td>
                            <td><?= h($options[$evenement->type_installation]) ?></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $evenement->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="text-right">
                                    <ul class="pagination">
                                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                        <?= $this->Paginator->numbers() ?>
                                        <?= $this->Paginator->next(__('next') . ' >') ?>
                                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                   <hr>
                <div class="form-group row" id="div_map_evenements">
                     <div class="col-md-12">
                           <div id="mapCanvas" style="width:auto; height:400px;"></div>
                             <div class="kl_infoForm"></div>
                           <div class="error error-message kl_erreurLongLat hide">Déplacer le curseur pour prendre la position</div>
                      </div>
                </div>


            </div>
        </div>
    </div>
</div>
</div>
