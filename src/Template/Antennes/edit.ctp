<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Antenne $antenne
 */
?>
<?= $this->Html->css('bootstrap/bootstrap.min.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?php // $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?php // $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>

<?php // $this->Html->css('dropify/style.css', ['block' => true]) ?>
<?php // $this->Html->css('dropify/green.css', ['block' => true]) ?>

<?= $this->Html->css('antennes/antenne.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->css('table-uniforme.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->css('wickedpicker.css?'.  time(), ['block' => true]) ?>


<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?php // $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php // $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?php // $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('wickedpicker.js', ['block' => true]) ?>

<?= $this->Html->script('antennes/antennes.js?'.  time(), ['block' => true]); ?>

<?php
$titrePage = "Modifier une antenne" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<?php

$horaire_accueil = json_decode($antenne->horaire_accueil,true);
$horaire = !empty($horaire_accueil)?$horaire_accueil['heurs']:null;

?>
    <div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
        <?php use Cake\Routing\Router; ?>
            <input type="hidden" value="<?php echo Router::url('/', true) ; ?>" id="id_baseUrl">
            <div class="card-body">
                <?= $this->Form->create($antenne, ['type'=>'file']) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                         <div class="form-group row">
                            <div class="col-md-3">
                                <?php echo $this->Form->control('ville_principale',['label' => 'Ville Principale *','type'=>'text']); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Adresse *</label>
                                 <div id="infoPanel"><?php echo $this->Form->control('adresse',['label' => false,'class'=>'form-control controls','id'=>'searchTextField']);?></div>
                                 <input id="info" type="text" size="50" value="" class="hide" />
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label">CP</label>
                                <?php echo $this->Form->control('cp',['type'=>'text','label' => false,'class'=>'form-control kl_theCP']);?>
                                <div class="error-message kl_errorCP hide">La valeur fournie n'est pas correcte</div>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Ville exacte</label>
                                <?php echo $this->Form->control('ville_excate',['label' => false,'class'=>'form-control']);?>
                            </div>
                        </div>
                        <div class="form-group row">

                             <div class="col-sm-3">
                                <label class="control-label">Pays</label>                           
                                <?php echo $this->Form->control('pays_id',['label' => false,'options'=>$pays,'empty'=>'Séléctionner']); ?>
                             </div>

                             <div class="col-sm-3">
                                <label class="control-label">Secteur Geographique</label>                                   
                                <?php echo $this->Form->control('secteur_geographique_id',['label' => false,'options'=>$secteur_geos,'empty'=>'Séléctionner']); ?>
                             </div>

                            <div class="col-sm-3">
                                <label class="control-label">E-mail commercial</label><?php echo $this->Form->control('email_commercial',['type'=>'email', 'label' => false,'class'=>'form-control ']);?>
                             </div>
                             <div class="col-sm-3">
                                <label class="control-label">Contact</label><?php echo $this->Form->control('telephone',['type'=>'text', 'label' => false,'class'=>'form-control ']);?>
                             </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <?= $this->Form->control('id_wp', ['type' => 'number', 'label' => 'Identifiant page worpdress','min'=>"0"]); ?>
                            </div>
                            <div class="col-md-3 align-self-center pt-4">
                                <div class="mt-1"><?= $this->Form->control('sous_antenne', ['type' => 'checkbox', 'label' => 'Sous antenne','id' => 'sous_antenne']); ?></div>
                            </div>
                            <div class="col-md-3 principal <?= $antenne->sous_antenne?'':'hide'?>">
                                    <label class="control-label">Antenne principale</label>   
                                    <?php echo $this->Form->control('antenne_id', [
                                            'label' => false ,
                                            'options'=>$antennes, 
                                            'empty'=>'Antenne principale',
                                            'class' => 'form-control select2',
                                            'data-placeholder' => "Séléctionner",
                                            'style' => 'width:100%'
                                    ] );?>
                            </div>
                        </div>

                        <h3 class="card-title">Localisation Google Maps</h3>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label class="control-label">Latitude</label><?php echo $this->Form->control('latitude',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true"]);?>
                             </div>
                             <div class="col-sm-6">
                                <label class="control-label">Longitude</label><?php echo $this->Form->control('longitude',["id"=>"txtLongitude", 'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true"]);?>
                             </div>
                        </div>
                         <div class="form-group row">
                             <div class="col-md-12">
                                   <div id="mapCanvas" style="width:auto; height:250px;"></div>
                                     <div class="kl_infoForm">Vous pouvez déplacer la position du curseur s'il est mal positionné</div>
                                   <div class="error error-message kl_erreurLongLat hide">Déplacer le cuseur pour prendre la position</div>
                              </div>
                         </div>
                        <div class="row">
                            <div class="col-md-12">
                               <?php echo $this->Form->control('precision_lieu',['label' => 'Précision Lieu ',"class"=>"textarea_editor form-control", "rows"=>"7",'type'=>'textarea']); ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                               <label>Photo(s) du lieu</label>
                               <div class="dropzone" id="id_dropzone" data-owner="photo_lieu"> </div>
                               <input type="hidden" value="<?= $antenne->id ?>" id="antenne_id">
                           </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                 <?php echo $this->Form->control('lieu_type_id',['label' => 'Lieu Type * ','options'=>$lieuTypes,'empty'=>'Séléctionner']); ?>
                             </div>
                            <div class="col-md-6">
                                <?php echo $this->Form->control('etat_id',['label' => 'Etat * ','options'=>$etats,'empty'=>'Séléctionner']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"   id="retour">
                                <?php echo $this->Form->control('commentaire',['label' => 'Commentaire antenne',"class"=>"textarea_editor1 form-control", "rows"=>"4"]); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-3 hide">
                                <label class="control-label">Fond vert * : </label>
                                <?= $this->Form->control('fond_vert',[
                                        'type'=>'radio',
                                        'options'=>[
                                                ['value' => 1, 'text' => ' Oui'],
                                                ['value' => 0, 'text' => ' Non']
                                        ],
                                        'label'=>false,
                                        'hiddenField'=>false,
                                        'legend'=>false,
                                        'templates' => [
                                        'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                                        'radioWrapper' => '<div class="radio radio-success radio-inline">{{label}}</div>'
                                ]
                                ]); ?>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Statut: </label>
                                <?= $this->Form->control('statut',[
                                        'type'=>'radio',
                                        'options'=>[
                                                ['value' => 1, 'text' => ' Actif'],
                                                ['value' => 0, 'text' => ' Inactif']
                                        ],
                                        'label'=>false,
                                        'required'=>true,
                                        'hiddenField'=>false,
                                        'legend'=>false,
                                        'templates' => [
                                        'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                                        'radioWrapper' => '<div class="radio radio-success radio-inline">{{label}}</div>'
                                ]
                                ]); ?>
                            </div>
                           <!--div class="col-sm-3">
                                <?php echo $this->Form->control('horaire_accueil',['label' => 'Horaires accueil / ouverture',"class"=>"textarea_editor form-control", "rows"=>"1"]); ?>

                           </div-->
                           <div class="col-sm-4 hide">
                               <?php echo $this->Form->control('horaire_dispos',['label' => 'Horaires dispos retrait / retour ',"class"=>"textarea_editor form-control", "rows"=>"1"]); ?>
                           </div>

                            <div class="col-sm-4">
                                <?php echo $this->Form->control('debit_internet_id',['label' => 'Débit internet','options'=>$debit_internets,'empty'=>'Séléctionner']); ?>
                            </div>
                            <div class="col-sm-4">
                                 <?php echo $this->Form->control('info_debit',["label" => "Pour plus d'info","class"=>"form-control"]); ?>
                            </div>
                         </div>

                        <h3 class="card-title">Horaires accueil / ouverture</h3>
                         <hr>          
                         <div id ="heurs">
                            <?php if($horaire_accueil!=null && $horaire_accueil['jours']=='tous_jours') : ?>
                                <div class="row"> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Tous les jours</label>
                                        </div> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Horaire début :  <?=!empty($horaire['debut'])?$horaire['debut']:'';?></label>
                                        </div> 
                                        <div class="col-md-4 align-self-center">
                                             <label class="control-label">Horaire fin :  <?=!empty($horaire['fin'])?$horaire['fin']:'';?></label>
                                        </div> 
                                </div>
                            <?php else : ?>
                                    <div class="form-group row" style="padding: 0px 20px 0px 20px; width: 90%;" >
                                            <table class="table table-uniforme table-bordered min-t">
                                                <thead>
                                                    <tr>
                                                        <th width="25%" class="p-0">Jour</th>
                                                        <th width="30%" class="p-0">Horaire début</th>
                                                        <th width="35%" class="p-0">Horaire fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $jours = ['lun' => 'Lundi','mar' => 'Mardi', 'mer' => 'Mercredi', 'jeu' => 'Jeudi', 'ven' => 'Vendredi', 'sam' => 'Samedi','dim' => 'Dimanche']; 
                                                    foreach ($jours as $key => $value) :
                                                    ?>
                                                    <tr>
                                                        <td><div class="mt-1 <?= !empty($horaire[$key])?'':'hide'; ?>"> <?= $value?></div></td>
                                                        <td><?= !empty($horaire[$key]['debut-1-'.$key])?$horaire[$key]['debut-1-'.$key]:''?></td>
                                                        <td><?= !empty($horaire[$key]['fin-1-'.$key])?$horaire[$key]['fin-1-'.$key]:''?></td>
                                                    </tr>
                                                    <tr class="<?=(empty($horaire[$key]['debut-2-'.$key])?'hide':'')?>">
                                                        <td></td>
                                                        <td><?= !empty($horaire[$key]['debut-2-'.$key])?$horaire[$key]['debut-2-'.$key]:''?></td>
                                                        <td><?= !empty($horaire[$key]['fin-2-'.$key])?$horaire[$key]['fin-2-'.$key]:''?></td>
                                                    </tr>
                                                    <?php  endforeach; ?>
                                                </tbody>
                                            </table>
                                    </div>
                        <?php  endif; ?>
                         </div>

                        <div class="row-fluid d-block clearfix"> 
                                <div class="float-right my-auto">
                                    <button type="button" class="btn btn-outline-success btn-sm change-state" data-toggle="modal" data-target="#change-state">Modifier</button>
                                </div>
                        </div>

                        <h3 class="card-title hide">Stock</h3>
                        <div class="form-group row hide"> 
                            <div class="col-sm-4">
                                <label class="control-label">Bobine DNP</label>
                                <?php echo $this->Form->control('stock_antennes.0.bobine_dnp',['label' => false,'class'=>'form-control']);?>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Bobine Mitsu</label>
                                <?php echo $this->Form->control('stock_antennes.0.bobine_mitsu',['label' => false,'class'=>'form-control']);?>
                            </div>
                        </div>
                        <div class="form-group row hide">
                            <div class="col-sm-4">
                                <label class="control-label">Imprimante DNP</label>
                                <?php echo $this->Form->control('stock_antennes.0.imprimante_dnp',['label' => false,'class'=>'form-control']);?>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Imprimante Mitsu</label>
                                <?php echo $this->Form->control('stock_antennes.0.imprimante_mitsu',['label' => false,'class'=>'form-control']);?>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Date recensement </label>
                                <input type="date" name="stock_antennes[0][date_recensement]" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($antenne->stock_antennes[0]->date_recensement)) echo $antenne->stock_antennes[0]->date_recensement->format('Y-m-d'); ?>">
                            </div>
                        </div>
                         <h3 class="card-title">Convention</h3>
                         <hr>
                        <div class="row">
                           <div class="col-md-12">
                                <label>Documents</label>
                                <div class="dropzone" id="id_dropzone_document" data-owner="document"> </div>
                            </div>
                        </div>
                        <br>
                         <div class="row">
                                 <div class="col-md-6">
                                     <?php echo $this->Form->control('convention_signe',['id'=>'convention_signe','label' => 'Convention signée']); ?>
                                 </div>
                         </div>
                        <br>
                    </div>

                    <div class="form-actions">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn btn-rounded btn-inverse",'escape'=>false]) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>


    <div class="modal fade" id="change-state" role="dialog">
        <div class="modal-dialog modal-lg">
            <form name="form_edit" id="form-edit" method="post" accept-charset="utf-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Horaires d'ouverture</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                    </div>
                    <div class="modal-body">

                            <div class="row" style="margin-right: 0px;">
                                <div class="col-md-5 align-self-center">
                                    <div class="mt-1"><?= $this->Form->control('tous_jours', ['type' => 'checkbox', 'class' => 'selectpicker', 'label' => 'Tous les jours' , 'checked' => ($horaire_accueil!=null && $horaire_accueil['jours']=='tous_jours')?'checked':'',]); ?></div>
                                </div>           
                                <div class="col-md-5 align-self-center">
                                    <div class="mt-1"><?= $this->Form->control('jours_specifique', ['type' => 'checkbox', 'class' => 'selectpicker', 'label' => 'Jour(s) spécifique(s)', 'checked' => ($horaire_accueil!=null && $horaire_accueil['jours']=='jours_specifique')?'checked':'',]); ?></div>
                                </div>
                            </div>
                            <div class="body-popup tous-jours <?=($horaire_accueil!=null && $horaire_accueil['jours']=='tous_jours')?'':'hide'?>" style="padding: 20px;">

                                    <div class="form-group row">
                                        <label class="control-label col-md-6">Horaire début </label>
                                        <div class="col-md-5">
                                            <input type="text" id="debut" name="debut" value="<?=!empty($horaire['debut'])?$horaire['debut']:'';?>">
                                        </div>
                                        <div class="col-md-10"></div>
                                        <label class="control-label col-md-6">Horaire fin </label>
                                        <div class="col-md-5">
                                            <input type="text" id="fin" name="fin" value="<?=!empty($horaire['fin'])?$horaire['fin']:'';?>">
                                        </div>
                                    </div>
                            </div>
                            <div class="body-popup jours-specifique <?= ($horaire_accueil!=null && $horaire_accueil['jours']=='jours_specifique')?'':'hide'?>" >

                                    <div class="form-group row" style="padding: 0px 20px 0px 20px; width: 100%;" >
                                            <table class="table table-bordered min-t">
                                                <thead>
                                                    <tr>
                                                        <th class="p-0">Jour</th>
                                                        <th class="p-0">Horaire début</th>
                                                        <th class="p-0">Horaire fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $jours = ['lun' => 'Lundi','mar' => 'Mardi', 'mer' => 'Mercredi', 'jeu' => 'Jeudi', 'ven' => 'Vendredi', 'sam' => 'Samedi','dim' => 'Dimanche']; 
                                                    foreach ($jours as $key => $value) :
                                                    ?>
                                                    <tr>
                                                        <td><div class="mt-1"><?= $this->Form->control($key, ['type' => 'checkbox', 'class' => '', 'label' => $value, 'checked' => !empty($horaire[$key])?'checked':'']); ?></div></td>
                                                        <td><input type="text" id="debut-1-<?=$key?>" class="timepicker" value="<?= !empty($horaire[$key]['debut-1-'.$key])?$horaire[$key]['debut-1-'.$key]:''?>"></td>
                                                        <td><input type="text" id="fin-1-<?=$key?>"  value="<?= !empty($horaire[$key]['fin-1-'.$key])?$horaire[$key]['fin-1-'.$key]:''?>"> <input type="button" value="+" onclick="hideShowClass('<?=$key?>',1)" class="b-<?= $key . ' ' . (!empty($horaire[$key]['debut-2-'.$key])?'hide':'')?>"></td>
                                                    </tr>
                                                    <tr class="<?= $key ?> <?=(empty($horaire[$key]['debut-2-'.$key])?'hide':'')?>">
                                                        <td></td>
                                                        <td><input type="text" id="debut-2-<?=$key?>" value="<?= !empty($horaire[$key]['debut-2-'.$key])?$horaire[$key]['debut-2-'.$key]:''?>"></td>
                                                        <td><input type="text" id="fin-2-<?=$key?>"  value="<?= !empty($horaire[$key]['fin-2-'.$key])?$horaire[$key]['fin-2-'.$key]:''?>"> <input type="button" value="-" onclick="hideShowClass('<?=$key?>',0)"></td>
                                                    </tr>
                                                    <?php  endforeach; ?>
                                                </tbody>
                                            </table>
                                    </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success save" id="save_heurs">Enregistrer</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    </div>
</div>


