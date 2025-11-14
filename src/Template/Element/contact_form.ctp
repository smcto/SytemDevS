<div class="bloc_form contactForm" id="contactForm-<?= $key; ?>" type="file">
    <h3 class="card-title">Contact <?= $key+1; ?></h3>
    <?php echo $this->Form->hidden('contacts.'.$key.'.id', ["id"=>"contacts-id-".$key]); ?>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.statut_id', ["id"=>"contacts-statut_id-".$key, "label" => "Statut :","options"=>$statuts, "empty"=>"Séléctionner"]) ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.situation_id', ["id"=>"contacts-situation_id-".$key,'label' => 'Situation Professionnel :','options'=>$situations, 'empty'=>'Séléctionner']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.nom',["id"=>"contacts-nom-".$key,"label"=>"Nom : ","class"=>"form-control"]) ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.prenom',["id"=>"contacts-prenom-".$key,"label"=>"Prénom : ","class"=>"form-control"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.telephone',["id"=>"contacts-telephone-".$key,"label"=>"Téléphone : ","class"=>"form-control"]) ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->control('contacts.'.$key.'.email',["id"=>"contacts-email-".$key,"label"=>"E-mail : ","class"=>"form-control"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Date de naissance :</label>
                <input type="date" name="contacts[<?= $key; ?>][date_naissance]" id="contacts-date_naissance-<?= $key; ?>" class="form-control" placeholder="dd/mm/yyyy" require="true" >
            </div>
        </div>
        <!--<div class="col-md-3">
            <label class="control-label">Photo </label>
            <div class="card-body">
                <input type="file" name="contacts[0][Tphoto_nom]" id="contacts-Tphoto_nom-0"  class="dropify" />
            </div>
        </div>-->
    </div>
    <div class="row ">
        <div class="col-sm-4">
            <label class="control-label">Civilité * : </label>
            <?= $this->Form->control('contacts.'.$key.'.civilite',[
            'type'=>'radio',
            'options'=>[
            ['value' => 0, 'text' => ' Homme ', 'id'=>'contacts-civilite-'.($key).'-0'],
            ['value' => 1, 'text' => ' Femme ', 'id'=>'contacts-civilite-'.($key).'-1']
            ],
            'label'=>false,
            'required'=>true,
            'hiddenField'=>false,
            'legend'=>false,
            'templates' => ['inputContainer' => '{{content}}']
            ]); ?>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-1">
            <label class="control-label">Vehiculé</label>
                <input  type="checkbox" name="contacts[<?= $key; ?>][is_vehicule]"
                        class="checkbox" id="contacts-is_vehicule-<?= $key; ?>"
                        value="<?php if(empty($contact)) { echo '0' ;} else{ echo $contact->is_vehicule;} ?>"
                        <?php if(!empty($contact) && ($contact->is_vehicule == 1)) { echo 'checked';} ?>
                />
                <?php // $this->Form->control('contacts.'.$key.'.is_vehicule',["id"=>"contacts-is_vehicule-".$key,"label"=>false, 'class'=>'checkbox']) ?>
        </div>
        <div class="col-md-3  <?php if(empty($contact)) { echo 'hide' ;} else if(!$contact->is_vehicule) { echo 'hide' ;} ?>" id="choix_modele_vehicule-<?= $key; ?>">
            <?= $this->Form->control('contacts.'.$key.'.modele_vehicule',["id"=>"contacts-modele_vehicule-".$key,"label"=>"Modèle véhicule : ","class"=>"form-control"]) ?>
        </div>
        <div class="col-md-3 <?php if(empty($contact)) { echo 'hide' ;} else if(!$contact->is_vehicule) { echo 'hide' ;} ?>" id="choix_nbr_transportable_vehicule-<?= $key; ?>">
            <?= $this->Form->control('contacts.'.$key.'.nbr_borne_transportable_vehicule',["id"=>"contacts-nbr_borne_transportable_vehicule-".$key,"label"=>"Nombre bornes transportable : ","class"=>"form-control"]) ?>
        </div>
        <div class="col-md-5 <?php if(empty($contact)) { echo 'hide' ;} else if(!$contact->is_vehicule) { echo 'hide' ;} ?>" id="choix_comnt_vehicule-<?= $key; ?>">
            <?= $this->Form->control('contacts.'.$key.'.commentaire_vehicule',["id"=>"contacts-commentaire_vehicule-".$key,"label"=>"Commentaire véhicule : ","rows"=>"2" ,"class"=>"form-control"]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->Form->control('contacts.'.$key.'.info_a_savoir',["id"=>"contacts-info_a_savoir-".$key,'label' => 'Info à savoir :',"class"=>"textarea_editor form-control", "rows"=>"5",'type'=>'textarea']); ?>
        </div>
        <div class="col-md-6">
            <?php echo $this->Form->control('contacts.'.$key.'.mode_renumeration',["id"=>"contacts-mode_renumeration-".$key,'label' => 'Modèle de rémunération :',"class"=>"textarea_editor form-control", "rows"=>"5",'type'=>'textarea']); ?>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <!--<a href="contactForm1" class="btn kl_trash" name="btnSuppr"></a>-->
            <?= $this->Form->button("Supprimer contact",["type"=>"button", "class"=>"btn kl_trash btn_suppr", 'id'=>$id_btn_suppr]) ?>
        </div>
    </div>
</div>