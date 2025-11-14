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
if($group_user == 1){
$titrePage = "Modifier un contact";
}
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
                <?= $this->Form->create($user, ['type' => 'file']) ?>
                <?php
                if($group_user == 1){
                    echo $this->Form->control('type_contact',['type' => 'hidden', 'value'=>"1"]);
                } else {
                    echo $this->Form->control('type_contact',['type' => 'hidden', 'value'=>"2"]);
                }?>
                <div class="form-body">
                    <h3 class="box-title m-t-40">Contact</h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('toujours_present',['label' => 'Toujours présent ? ']); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('prenom',['label' => 'Prénom * : ', 'required'=>true]); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('nom',['label' => 'Nom * : ', 'required'=>true]); ?>
                        </div>
                        <div class="col-md-3">
                            <label for="contacts-civilite-0">Civilité * : </label>
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
                        <div class="col-sm-4">
                            <?php //echo $this->Form->control('date_naissance',['label' => 'Date de naissance * :']); ?>
                            <label class="control-label">Date de naissance : </label>
                            <input type="date" name="date_naissance" class="form-control" placeholder="dd/mm/yyyy">
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('info_a_savoir',["id"=>"info_a_savoir",'label' => 'Info à savoir :',"class"=>"form-control",'type'=>'textarea']); ?>
                        </div>
                        <?php if($group_user == 1){ ?>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('mode_renumeration',["id"=>"mode_renumeration",'label' => 'Modèle de rémunération :',"class"=>"form-control",'type'=>'textarea']); ?>
                        </div>
                        <?php } ?>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <?= $this->Form->control('is_vehicule',["id"=>"is_vehicule","label"=>"Véhiculé : ","class"=>"form-control"]) ?>
                        </div>
                        <div class="col-sm-3" id="choix_modele_vehicule">
                            <?= $this->Form->control('modele_vehicule',["id"=>"modele_vehicule","label"=>"Modèle véhicule : ","class"=>"form-control"]) ?>
                        </div>

                        <div class="col-sm-3" id="choix_nbr_transportable_vehicule">
                            <?= $this->Form->control('nbr_borne_transportable_vehicule',["id"=>"nbr_borne_transportable_vehicule","label"=>"Nombre bornes transportable : ","class"=>"form-control"]) ?>
                        </div>
                        <div class="col-sm-4" id="choix_comnt_vehicule">
                            <?= $this->Form->control('commentaire_vehicule',["id"=>"commentaire_vehicule","label"=>"Commentaire : ","class"=>"form-control"]) ?>
                        </div>
                    </div>
                    <?php //if($group_user == 1){ ?>
                    <h3 class="box-title m-t-40">Adresse </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('adresse',['label' => 'Adresse * :']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('cp',['label' => 'Cp * :']); ?>
                        </div>
                    </div>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('ville',['label' => 'Ville * :']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php //echo $this->Form->control('pays',['label' => 'Pays * :']); ?>
                            <?php //echo $this->Form->control('pays_id',['id'=>'pays_id', 'label' => "Pays * :", 'options'=>$countries, 'empty'=>'Séléctionner', 'required'=>true]);?>

                            <label for="pays_id" class="control-label">Pays * :</label>
                            <select name="pays_id" id="pays_id" required="required" class="custom-select">
                                <option value="">Séléctionner</option>
                                <?php
                                    foreach($countries2 as $country) {
                                        $selected = "";
                                        if($user->pays_id == $country->id ) {
                                            $selected = "selected";
                                        } ?>
                                    <option value="<?= $country->id ?>" data-id="<?= $country->phonecode ?>" <?= $selected ?>><?= $country->name_fr ?></option>
                                <?php } ?>
                            </select>

                            <input type="hidden" name="phonecode" id="phonecode" >
                        </div>
                    </div>
                    <?php //} ?>
                    <h3 class="box-title m-t-40">Informations</h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-sm-4">
                            <?php
                                    /*if(!empty($user->telephone_portable)) {
                                        $user->telephone_portable = substr($user->telephone_portable, strlen($user->pays->phonecode)+1);
                                    }
                                    if(!empty($user->telephone_fixe)) {
                                        $user->telephone_fixe = substr($user->telephone_fixe, strlen($user->pays->phonecode)+1);
                                    }*/
                            ?>
                            <?php echo $this->Form->control('telephone_portable',['id'=>'telephone_portable_id', 'label' => 'Téléphone portable * : ']); ?>
                            <!--<small>Le numero de commencer par +33</small>-->
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('telephone_fixe',['id'=>'telephone_fixe_id','label' => 'Téléphone fixe : ', 'required'=>false]); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $this->Form->control('email',['label' => 'E-mail * : ', 'required'=>true, 'id'=>'id_email']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20">
                      <?php if($group_user == 1){ ?>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('situation_id',['options'=>$situationProfesionnelles, 'label' => 'Situation professionnelle * : ','empty'=>'Séléctionner']); ?>
                        </div>
                     <?php } ?>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('description_rapide',['label' => 'Description rapide : ', "class"=>"form-control", 'type' => 'textarea']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('photo_file',["id"=>"photo_id","label"=>"Photo : ","class"=>"dropify", "type"=>"file", "accept"=>"image/*", "data-default-file"=>$user->url_viewer_photo]) ?>
                            <?php  if(!empty($user->url_viewer_photo)) {
                                        echo $this->Html->link('<i class="mdi mdi-eye text-inverse"></i>', $user->url_photo,['escape' => false,"class"=>"", 'target'=>'_blank', 'title'=>'Voir photo']);
                                        //echo $this->Html->link('<i class="mdi mdi-delete text-inverse"></i>','#',['escape' => false,"id"=>"suppr_photo_user", 'title'=>'Voir photo']);
                                        //echo $this->Form->button('<i class="mdi mdi-delete text-inverse"></i>',['type' => 'button', 'escape' => false,"id"=>"suppr_photo_user", 'title'=>'Voir photo']);
                                        }
                            ?>

                        </div>
                    </div>
                    <?php if($group_user == 1){ ?>
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php $sources = ['ami'=>'Ami','famille'=>'Famille','reseaux_pro'=>'Réseaux pro', 'reseaux_sociaux'=>'Réseaux sociaux','prospection'=>'Prospection','autre'=>'Autres'];
                            echo $this->Form->control('source',['options'=>$sources, 'label' => 'Source : ','empty'=>'Séléctionner']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('description_source',['label' => 'Description du source : ', "class"=>"form-control", 'type' => 'textarea']); ?>
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('commentaire_interne',['label' => 'Commentaire interne : ', "class"=>"textarea_editor form-control", 'type' => 'textarea']); ?>
                        </div>
                    </div>
                    <?php } ?>

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
                        <?php if($group_user == 2){ ?>
                         <div class="col-md-4">
                            <?php echo $this->Form->control('poste',['type' => 'text', 'label' => 'Poste :', 'id'=>'poste']); ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php // debug($typeprofils); ?>
                    <div class="<?php if(!in_array(4, $typeprofils) && !in_array(5, $typeprofils) && !in_array(7, $typeprofils)) echo 'hide' ;?> infos_antenne">
                        <h5 class="box-title m-t-40 info">Infos antenne/ installateur / animateur</h5><hr>
                        <div class="row p-t-20 <?php if(!in_array(4, $typeprofils) && !in_array(5, $typeprofils) && !in_array(7, $typeprofils)) echo 'hide' ;?> installateur animateur antenne">
                            <!--<div class="col-md-4">
                                <?php //echo $this->Form->control('antenne_id',['label' => 'Antenne * : ', 'options'=>$antennes,'empty'=>'Séléctionner']); ?>
                            </div>-->
                            <div class="col-md-4">
                                <?php echo $this->Form->control('antennes_rattachees._ids',[
                                'type' => 'select',
                                'label' => 'Antenne(s) *: ',
                                'options'=>$antennes,
                                'multiple' => true,
                                'required'=>false,
                                'data-placeholder'=>'Séléctionner',
                                "class"=>"select2 form-control select2-multiple",
                                'id'=>'antenne_ids']); ?>
                            </div>
                            <div class="col-md-4 <?php if(!in_array(4, $typeprofils) && !in_array(5, $typeprofils) ) echo 'hide' ;?> niveau_tech_info">
                                <?php $niveaux = ['expert'=>'Expert', 'bonnes_connaissances'=>'Bonnes connaissances', 'moyen'=>'Moyen', 'debutant'=>'Débutant'];
                                echo $this->Form->control('niveau_tech_info',['options'=>$niveaux, 'label' => 'Niveau technique informatique : ','empty'=>'Séléctionner']); ?>
                            </div>
                            <div class="col-md-4 <?php if(!in_array(4, $typeprofils) && !in_array(5, $typeprofils) ) echo 'hide' ;?>  description_niveau_tech_info">
                                <?php echo $this->Form->control('description_niveau_tech_info',['label' => 'Description : ', "class"=>"form-control", 'type' => 'textarea']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="<?php if(!in_array(6, $typeprofils) || !in_array(5, $typeprofils)) echo 'hide' ;?> infos_livreur">
                        <h5 class="box-title m-t-40 info">Infos livreur/Installateur</h5><hr>
                        <div class="row p-t-20 <?php if(!in_array(6, $typeprofils)) echo 'hide' ;?> livreur">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('vehicule',['label' => 'vehicule : ']); ?>
                            </div>

                            <div class="col-md-6">
                                <?php echo $this->Form->control('capacite_chargement_borne',['label' => 'Capacité de chargement de borne : ']); ?>
                            </div>
                        </div>

                        <div class="row p-t-20 <?php if(!in_array(6, $typeprofils) || !in_array(5, $typeprofils)) echo 'hide' ;?> livreur">
                            <div class="col-md-4">
                                <?php echo $this->Form->control('creneaux_disponibilite',['label' => 'Créneaux de disponibilité : ']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $this->Form->control('creneaux_indisponibilite',['label' => 'Créneaux d\'indisponibilité : ']); ?>
                            </div>
                            <div class="col-md-4">
                                <?php echo $this->Form->control('zone_intervention',['label' => 'Zone d\'intervention : ']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="<?php if(!in_array(9, $typeprofils) || !in_array(5, $typeprofils)) echo 'hide' ;?> infos_client">
                        <h5 class="box-title m-t-40 info">Infos client</h5><hr>
                        <div class="row p-t-20 <?php if(!in_array(9, $typeprofils)) echo 'hide' ;?> client">
                            <div class="col-md-4">
                                <?php echo $this->Form->control('client_id',['id'=>'client_id', 'label' => 'Client * : ', 'options'=>$clients,'empty'=>'Séléctionner']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="<?php if(!in_array(2, $typeprofils) && !in_array(3, $typeprofils)) echo 'hide' ;?> infos_konitys">
                        <h5 class="box-title m-t-40 info">Infos konitys</h5><hr>
                        <div class="row p-t-20 <?php if(!in_array(2, $typeprofils) && !in_array(3, $typeprofils)) echo 'hide' ;?> konitys">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('fonction',['label' => 'Fonction : ']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="<?php if(!in_array(8, $typeprofils)) echo 'hide' ;?> infos_fournisseur">
                        <h5 class="box-title m-t-40 info">Infos fournisseur</h5><hr>
                        <div class="row p-t-20 <?php if(!in_array(8, $typeprofils)) echo 'hide' ;?> fournisseur">
                            <div class="col-md-4">
                                <?php echo $this->Form->control('fournisseur_id',['id'=>'fournisseur_id', 'label' => 'Fournisseur * : ', 'options'=>$fournisseurs,'empty'=>'Séléctionner']); ?>
                            </div>
                            <!--/span-->
                        </div>
                    </div>

                    <h3 class="box-title m-t-40">Accès </h3>
                    <hr>
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('email',['label' => 'Login * :', 'required'=>true, 'id'=>'id_login', 'disabled'=>true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('password_visible',['type' => 'password', 'label' => 'Password * :', 'id'=>'password_visible', 'required'=>true]); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('password',['value' => $user->password_visible, 'type' => 'hidden', 'label' => 'Confirmation Password * :', 'id'=>'password']); ?>
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