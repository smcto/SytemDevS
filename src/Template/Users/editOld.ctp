<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>

<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>

<?= $this->Html->script('users/users.js', ['block' => true]); ?>

<?php
$titrePage = "Modifier un utilisateur";
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Dashboards',
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
                <h4 class="m-b-0 text-white">Information générales</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($user, ['type' => 'file']) ?>
                <div class="form-body">
                    <h3 class="box-title m-t-40">Contact</h3>
                    <?php echo $this->Form->control('contacts.0.id',['type' => 'hidden']); ?>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.nom',['label' => 'Nom * : ', 'required'=>true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.prenom',['label' => 'Prenoms * : ', 'required'=>true]); ?>
                        </div>
                        <!--<div class="col-md-4">
                            <?php // echo $this->Form->control('contacts.0.civilite',['label' => 'Civilité *']); ?>
                        </div>-->
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <label for="contacts-civilite-0">Civilité * : </label>
                            <?= $this->Form->control('contacts.0.civilite',[
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

                    <h3 class="box-title m-t-40">Profil</h3>
                    <?php
                        $typeprofils =[];
                        $typeprofils2 =[];
                        if(!empty($user->profils)) {
                            foreach($user->profils as $typeprofil) {
                                $typeprofils [] = $typeprofil->id;
                                $typeprofils2 [$typeprofil->id] = $typeprofil->nom;
                            }
                            //debug($typeprofils);
                        }?>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('profils._ids',[
                            'label' => 'Type(s) de profil(s) * : ',
                            'options'=>$typeProfils,
                            'type' => 'select',
                            'multiple' => true,
                            'required'=>true,
                            "class"=>"select2 form-control select2-multiple",
                            'data-placeholder'=>'Séléctionner',
                            'id'=>'type_profil']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(4, $typeprofils) && !in_array(5, $typeprofils) && !in_array(7, $typeprofils)) echo 'hide' ;?> installateur animateur antenne">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.antenne_id',['label' => 'Antenne * : ', 'options'=>$antennes,'empty'=>'Séléctionner']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(6, $typeprofils)) echo 'hide' ;?> livreur">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.vehicule',['label' => 'vehicule : ']); ?>
                        </div>

                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.capacite_chargement_borne',['label' => 'Capacité de chargement de borne : ']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(6, $typeprofils)) echo 'hide' ;?> livreur">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.creneaux_disponibilite',['label' => 'Crenaux de disponibilité : ']); ?>
                        </div>

                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.zone_intervention',['label' => 'Zone d\'intervention : ']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(9, $typeprofils)) echo 'hide' ;?> client">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.client_id',['label' => 'Client * : ', 'options'=>$clients,'empty'=>'Séléctionner']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(2, $typeprofils) && !in_array(3, $typeprofils)) echo 'hide' ;?> konitys">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.fonction',['label' => 'Fonction * : ']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20 <?php if(!in_array(8, $typeprofils)) echo 'hide' ;?> fournisseur">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.fournisseur_id',['label' => 'Fournisseur * : ', 'options'=>$fournisseurs,'empty'=>'Séléctionner']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    <h3 class="box-title m-t-40">Adresse </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.adresse',['label' => 'Adresse * : ']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.cp',['label' => 'Cp * : ']); ?>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.ville',['label' => 'Ville * : ']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.pays',['label' => 'Pays * : ']); ?>
                        </div>
                    </div>


                    <h3 class="box-title m-t-40">Informations</h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-sm-3">
                            <?php //echo $this->Form->control('contacts.0.date_naissance',['label' => 'Date de naissance * : ']); ?>
                            <label class="control-label">Date de naissance : </label>
                            <input type="date" name="contacts[0][date_naissance]" class="form-control" placeholder="dd/mm/yyyy" value="<?php if(!empty($user->contacts[0]->date_naissance)) echo $user->contacts[0]->date_naissance->format('Y-m-d'); ?>">
                        </div>
                        <div class="col-sm-3">
                            <?php
                                   if(!empty($user->contacts[0]->telephone_portable)) {
                                    $user->contacts[0]->telephone_portable = substr($user->contacts[0]->telephone_portable, strlen($user->contacts[0]->country->phonecode)+1);
                                 }
                            ?>
                            <?php echo $this->Form->control('contacts.0.country_id',['id'=>'country_id', 'label' => "Pays * :", 'options'=>$countries,'empty'=>'Séléctionner', 'required'=>true]);?>
                            <input type="hidden" name="contacts[0][phonecode]" id="phonecode" >
                        </div>
                        <div class="col-sm-3">
                            <?php echo $this->Form->control('contacts.0.telephone_portable',['label' => 'Téléphone portable * : ']); ?>
                        </div>
                        <div class="col-sm-3">
                            <?php echo $this->Form->control('contacts.0.email',['label' => 'E-mail * : ', 'required'=>true, 'id'=>'id_email']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.situation_id',['options'=>$situationProfesionnelles, 'label' => 'Situation professionnelle * : ','empty'=>'Séléctionner']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('contacts.0.description_rapide',['label' => 'Description rapide : ', "class"=>"form-control", 'type' => 'textarea']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('photo_file',["id"=>"photo_id","label"=>"Photo : ","class"=>"dropify", "type"=>"file", "accept"=>"image/*", "data-default-file"=>$user->contacts[0]->url_photo]) ?>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('contacts.0.commentaire_interne',['label' => 'Commentaire interne : ', "class"=>"textarea_editor form-control", 'type' => 'textarea']); ?>
                        </div>
                    </div>

                    <h3 class="box-title m-t-40">Accés </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('email',['label' => 'Login * :', 'required'=>true, 'id'=>'id_login']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('password_visible',['type' => 'text', 'label' => 'Password * :', 'id'=>'password_visible', 'required'=>true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('password',['type' => 'hidden', 'label' => 'Confirmation Password * :', 'id'=>'password']); ?>
                        </div>
                    </div>

                    <br>
                    <div class="form-actions">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Form->button(__('Cancel'),["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>