<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evenement $evenement
 */
?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('daterangepicker.css',['block'=>true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>


<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('daterangepicker.js',['block'=>true]) ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>

<?= $this->Html->script('evenements/evenements.js', ['block' => true]); ?>
<?php
$titrePage = "Modifier un événement" ;
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
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Informations générales</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($evenement) ?>
                <div class="form-body">
                    <h3 class="box-title m-t-40">Client <?= $this->Html->link('Brief lié à cet évènement',['controller'=>'evenement-briefs', 'action'=>'etape', $parametre], ['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-secondary", "style"=>"margin-left: 5px;", 'target' => '_blank']); ?></h3><hr>
					
                    <div class="row p-t-20">
                        <div class="col-md-4 bloc-type-client">
                            <?php $clientType = ['1'=>'Professionel' , '2'=>'Particulier' ]; echo $this->Form->control('client_type',['label' => 'Type Client *', 'options'=>$clientType,'empty'=>'Séléctionner', 'id'=>'type_client_id', 'required'=>true]); ?>
                        </div>

                        <div class="col-md-4 bloc-client">
                            <label class="control-label">Client *</label><br>
                            <?php echo $this->Form->control('client_id',['label' =>false,'options'=>$clients, 'class'=>'form-control select2', 'empty'=>'Séléctionner ', 'id'=>'clients_id', 'required'=>true]); ?>
                        </div>

                        <div class="col-md-4 envoyer_recap"><br>
							<?php echo $this->Form->control('publication_fb',['id'=>'publication_fb', 'class'=>'hide', 'label' => 'Autorisation publication FB']); ?>
							<?php echo '<div class="hide">'.$this->Form->control('nom_fb',['id'=>'nom_fb', 'class'=>'form-control', 'placeholder' => 'Facebook de celui qui partage l\'album', 'label' => false]).'</div>'; ?>
                            <?php echo $this->Form->control('envoyer_recap',['id'=>'envoyer_recap', 'class'=>'hide', 'label' => 'Envoi e-mail récap']); ?>
                        </div>
                        
                    </div>
                    <h3 class="box-title m-t-40">Informations événement </h3><hr>
                    <div class="row">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('animation_hotesse',['id'=>'animation_hotesse','label' => 'Animation hotesse', 'type'=>'checkbox']); ?>
                            </div>
                    </div>
                    <div class="row p-t-20">
                        <!--/span-->
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_evenement_id',['id'=>'type_event', 'label' => 'Type événement *', 'options'=>$typeEvenements,'empty'=>'Séléctionner', 'required'=>true]); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('nature_evenement_id',['id'=>'natureEvenement_id', 'label' => 'Nature de l\'événement *','empty'=>'Séléctionner', 'required'=>true]); ?>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_animation_id',['id'=>'type_animation','label' => 'Type animation *', 'options'=>$typeAnimations,'empty'=>'Séléctionner', 'required'=>true]); ?>
                        </div>

                        <div class="col-md-6">
                            <?php
                            // Select multiple pour belongsToMany
                            echo $this->Form->control('documents._ids', [
                            'type' => 'select',
                            'multiple' => true,
                            'label' => 'Sélectionner un ou plusieurs devis',
                            'class' => 'select2 form-control',
                            'options' => $devis,
                            'id' => 'devisSelect'
                            ]);
                            ?>
                            <?php
                                if($evenement->documents){
                            $partialinvoiced = 0;
                            $invoiced = 0;
                            foreach($evenement->documents as $document){
                            if($document->step == "partialinvoiced"){
                            $partialinvoiced = 1;
                            break;
                            }else if($document->step == "invoiced" ){
                            $invoiced ++;
                            }
                            }

                            if($invoiced == count($evenement->documents)){
                            $invoiced = 1;
                            }else{
                            $invoiced = 0;
                            }
                            ?>

                            <div class="kl_infoDevis">
                                <?php if($partialinvoiced){ ?>
                                <span class="label label-warning">Partiellement facturé</span>
                                <?php } else if($invoiced){ ?>
                                <span class="label label label-success">Facturé</span>
                                <?php }else{ ?>
                                <span class="label label-warning">Aucun payement reçu</span>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-3">
                            <?php echo $this->Form->control('nom_event',['id'=>'nom_event', 'label' => 'Nom de l\'événement','type'=>'text']); ?>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Antenne *</label>
                            <?php echo $this->Form->control('antenne_id',['label' =>false, 'class'=>'form-control select2', 'data-live-search'=>'true', 'options'=>$antennes,'empty'=>'Séléctionner', 'id'=>'antenne_id']); ?>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Borne affectée </label>
                            <?php echo $this->Form->control('borne_id',['label' =>false, 'class'=>'form-control select2', 'data-live-search'=>'true', 'options'=>$bornes,'empty'=>'Séléctionner', 'id'=>'borne_id']); ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                            <?php echo $this->Form->control('lieu_exact',['label' => 'Lieu','type'=>'text']); ?>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-12">
                                <?php echo $this->Form->control('description',['label'=>'Description événement ',"class"=>"textarea_editor form-control", "rows"=>"3",'type'=>'textarea']); ?>
                            </div>
                    </div>
                    <h3 class="box-title m-t-40">Dates événement </h3>
                    <hr>
                    <div class="row">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('location_week',['id'=>'location_week','label' => 'Location weekend']); ?>
                            </div>
                    </div>

                    <!--<div class="row p-t-20">
                        <?php echo $this->Form->control('date_evenements.0.id',['label' => 'Lieu','type'=>'hidden']); ?>
                        <div class="col-md-6">
                            <label class="control-label">Date debut</label>
                            <input type="date" name="date_evenements[0][date_debut]" class="form-control" placeholder="dd/mm/yyyy" required="false" value="<?php if(!empty($evenement->date_evenements[0]->date_debut)) echo $evenement->date_evenements[0]->date_debut->format('Y-m-d'); ?>" >
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Date fin</label>
                            <input type="date" name="date_evenements[0][date_fin]" class="form-control" placeholder="dd/mm/yyyy" required="false" value="<?php if(!empty($evenement->date_evenements[0]->date_fin)) echo $evenement->date_evenements[0]->date_fin->format('Y-m-d'); ?>" >
                        </div>
                        &lt;!&ndash;/span&ndash;&gt;
                    </div>-->
                    <!--/row-->
                    <?php if(!empty($evenement->date_evenements)) {?>
                    <?php foreach($evenement->date_evenements as $key => $date_evenement) {?>
                    <?php echo $this->Form->control('asuppr.'.($key),["type"=>"hidden","id"=>"asuppr-".$key]) ?>
                        <div class="row p-t-20 blocDateEvenement" id="blocDateEvenement-<?= $key ?>">
                            <?php echo $this->Form->control('date_evenements.'.($key).'.id',['id' => 'dateevenement_id-'.($key),'type'=>'hidden']); ?>
                            <div class="col-md-5">
                                <label class="control-label">Date debut *</label>
                                <input type="date" name="date_evenements[<?= $key ?>][date_debut]" class="form-control" placeholder="dd/mm/yyyy" required="true" id="date_debut-<?= $key ?>" value="<?php if(!empty($date_evenement->date_debut)) echo $date_evenement->date_debut->format('Y-m-d'); ?>" >
                            </div>
                            <div class="col-md-5">
                                <label class="control-label">Date fin *</label>
                                <input type="date" name="date_evenements[<?= $key ?>][date_fin]" class="form-control" placeholder="dd/mm/yyyy" required="true" id="date_fin-<?= $key ?>" value="<?php if(!empty($date_evenement->date_fin)) echo $date_evenement->date_fin->format('Y-m-d'); ?>" >
                            </div>
                            <span class="btn kl_suppr_date_edit" id="btnSupprDate-<?= $key.'-'.$date_evenement->id ;?>">✘</span>
                            <!--/span-->
                            <?php if($key == 0) { ?>
                            <div class="col-md-2" style="float: right;">
                                <button type="button" class="btn btn-info" id="id_add_periode" >Ajouter date</button>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php } else { ?>
                    <div class="row p-t-20 blocDateEvenement" id="blocDateEvenement-0">
                        <div class="col-md-5">
                            <label class="control-label">Date debut * </label>
                            <input type="date" name="date_evenements[0][date_debut]" class="form-control" placeholder="dd/mm/yyyy" required="true" id="date_debut-0">
                            <!--<input class="form-control input-daterange-datepicker" type="text" name="daterange" value="01/01/2015 - 01/31/2015">-->
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Date fin * </label>
                            <input type="date" name="date_evenements[0][date_fin]" class="form-control" placeholder="dd/mm/yyyy" required="true" id="date_fin-0">
                        </div>
                        <span class="btn kl_suppr_date" id="btnSupprDate-0">✘</span>
                        <!--/span-->
                        <div class="col-md-2" style="float: right;">
                            <button type="button" class="btn btn-info" id="id_add_periode" >Ajouter date</button>
                        </div>
                    </div>
                    <?php } ?>

                    <h3 class="box-title m-t-40">Dates immobilisation </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <label class="control-label">Date debut</label>
                            <input type="date" name="date_debut_immobilisation" id="date_debut_immobilisation" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($evenement->date_debut_immobilisation)) echo  $evenement->date_debut_immobilisation->format('Y-m-d'); ?>" >
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Date fin</label>
                            <input type="date" name="date_fin_immobilisation" id="date_fin_immobilisation" class="form-control" placeholder="dd/mm/yyyy"  value="<?php if(!empty($evenement->date_fin_immobilisation)) echo $evenement->date_fin_immobilisation->format('Y-m-d'); ?>">
                        </div>
                        <!--/span-->
                    </div>
                    <hr>

                    <h3 class="box-title m-t-40">Horaires événement </h3>
                    <hr>
                    <div class="row">
                            <div class="col-md-12">
                                <?php echo $this->Form->control('horaires',['label'=>'Horaires de l\'événement ',"class"=>"textarea_editor1 form-control", "rows"=>"3",'type'=>'textarea']); ?>
                            </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php // $options = ['1'=>'Nos soins', '2'=>'Retrait', '3'=>'Envoi transporteur'];
                            //echo $this->Form->control('type_installation',['id'=>'id_type_installation', 'label' => 'Type installation *', 'options'=>$options,'empty'=>'Séléctionner']); ?>
                            <?php 
                            echo $this->Form->control('type_installation',['id'=>'id_type_installation', 'label' => 'Installation *', 'options'=>$installations,'empty'=>'Séléctionner']); ?>
                        </div>
                        <div class="col-md-6 <?php if(!in_array($evenement->type_installation, [1, 12])) echo 'hide' ;?>" id="id_personne_affecte">
                            <?php
                            echo $this->Form->control('user_id',['label' => 'Personne affecté *', 'options'=>$contactsList,'empty'=>'Séléctionner']); ?>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php 
                            echo $this->Form->control('desinstallation_id',['id'=>'desinstallation_id', 'label' => 'Désinstallation *', 'options'=>$desinstallations,'empty'=>'Séléctionner']); ?>
                        </div>
                        <div class="col-md-6 <?php if(!in_array($evenement->desinstallation_id, [6])) echo 'hide' ;?>" id="id_personne_affecte_desinstallation">
                            <?php
                            echo $this->Form->control('desinstallation_user_id',['label' => 'Personne affecté *', 'options'=>$contactsList,'empty'=>'Séléctionner']); ?>
                        </div>
                    </div>
                    <h3 class="box-title m-t-40">Suivi interne </h3><hr>
                    <div class="row p-t-20">
                        <div class="col-md-4 bloc-type-client">
                            <?php $responsable = null; if(!empty($evenement->responsables)) { $responsable = $evenement->responsables[0]->id;} ?>
                            <?php echo $this->Form->control('responsable_id',['label' => 'Responsable de projet ', 'class'=>'form-control select2', 'options'=>$responsablesList, 'value'=>$responsable, 'empty'=>'Séléctionner']); ?>
                        </div>
                        <div class="col-md-4 bloc-client">
                            <?php echo $this->Form->control('contacts._ids',['multiple'=>true, 'label' =>'Contacts associés', 'options'=>$contactsList, 'class'=>'form-control select2', 'empty'=>'Séléctionner']); ?>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <!--<?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>-->
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>




