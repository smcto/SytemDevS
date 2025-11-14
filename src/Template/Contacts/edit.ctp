<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>

<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>

<!-- Plugin for this page -->
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('contacts/contact.js', ['block' => true]); ?>

<?php
$titrePage = "Modifier contact" ;
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
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($contact, ['type'=>'file']) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <?php echo $this->Form->control('statut_id',['label' => "Type contact * :", 'options'=>$statuts,'empty'=>'Séléctionner', 'required'=>true]);?>
                            </div>
                            <div class="col-sm-4">
                                <?= $this->Form->control('nom',["id"=>"nom","label"=>"Nom : ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $this->Form->control('prenom',["id"=>"prenom","label"=>"Prénom : ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php echo $this->Form->control('country_id',['id'=>'country_id', 'label' => "Pays * :", 'options'=>$countries,'empty'=>'Séléctionner', 'required'=>true]);?>
                                <input type="hidden" name="phonecode" id="phonecode" >
                            </div>
                            <div class="col-sm-4">
                                <?php
                                    if(!empty($contact->telephone_portable)) {
                                        $contact->telephone_portable = substr($contact->telephone_portable, strlen($contact->country->phonecode)+1);
                                    }
                                    if(!empty($contact->telephone_fixe)) {
                                        $contact->telephone_fixe = substr($contact->telephone_fixe, strlen($contact->country->phonecode)+1);
                                    }
                                ?>
                                <?= $this->Form->control('telephone_portable',["id"=>"telephone_portable","label"=>"Téléphone portable: ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $this->Form->control('telephone_fixe',["id"=>"telephone_fixe","label"=>"Téléphone fixe: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('email',["id"=>"email","label"=>"Email : ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date naissance :</label>
                                    <input type="date" name="date_naissance" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($contact->date_naissance)) echo $contact->date_naissance->format('Y-m-d') ?>" >
                                </div>
                            </div>
                            <!--<div class="col-sm-6">
                                <?= $this->Form->control('date_naissance',["id"=>"nom","label"=>"Date naissance : ","class"=>"form-control"]) ?>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Civilité * : </label>
                                <?= $this->Form->control('civilite',[
                                'type'=>'radio',
                                'options'=>[
                                ['value' => 0, 'text' => ' Homme'],
                                ['value' => 1, 'text' => ' Femme']
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
                        </div>

                     <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('info_a_savoir',["id"=>"info_a_savoir",'label' => 'Info à savoir :',"class"=>"textarea_editor form-control", "rows"=>"8",'type'=>'textarea']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('mode_renumeration',["id"=>"mode_renumeration",'label' => 'Modèle de rémunération :',"class"=>"textarea_editor form-control", "rows"=>"8",'type'=>'textarea']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                           <?= $this->Form->control('is_vehicule',["id"=>"is_vehicule","label"=>"Véhiculé : ","class"=>"form-control"]) ?>
                        </div>
                        <div class="col-sm-6" id="choix_modele_vehicule">
                            <?= $this->Form->control('modele_vehicule',["id"=>"modele_vehicule","label"=>"Modèle véhicule : ","class"=>"form-control"]) ?>
                        </div>
                    </div>
                  <div class="row">
                        <div class="col-sm-6" id="choix_nbr_transportable_vehicule">
                           <?= $this->Form->control('nbr_borne_transportable_vehicule',["id"=>"nbr_borne_transportable_vehicule","label"=>"Nombre bornes transportable : ","class"=>"form-control"]) ?>
                        </div>
                        <div class="col-sm-6" id="choix_comnt_vehicule">
                            <?= $this->Form->control('commentaire_vehicule',["id"=>"commentaire_vehicule","label"=>"Commentaire : ","class"=>"form-control"]) ?>
                        </div>
                  </div>
                  <div class="row">
                     <div class="card-body">
                         <?php echo $this->Form->input('antenne_id',['label' => "Antenne :", 'options'=>$antennes,'empty'=>'Séléctionner']);?>
                     </div>
                     <div class="col-sm-6">
                         <?= $this->Form->control('photo_nom',["id"=>"photo_nom","label"=>"Photo : ","class"=>"dropify", "type"=>"file"]) ?>
                         <?= $this->Html->image('/uploads/contact/'.$contact->photo_nom) ?>
                     </div>
                 </div>
                 <div class="row">
                      <div class="col-sm-6">
                          <?php echo $this->Form->input('situation_id',['label' => "Situation :", 'options'=>$situations,'empty'=>'Séléctionner']);?>
                      </div>

                </div>

               <div class="form-actions">
                       <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                       <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                   </div>
               <?= $this->Form->end() ?>
                    </div>
            </div>
        </div>
    </div>
</div>



