<?php if($fin){ ?>
	<p class="text-center s-bold">Nous vous remercions du temps que vous avez dédié au remplissage de toutes ces informations.</p>
	<p class="text-center s-bold">Elles permettent de faciliter notre collaboration.</p>
	<p class="text-center s-bold">L’équipe Selfizee.</p>
<?php }else{ ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('daterangepicker.css', ['block' => true]) ?>
<?= $this->Html->css('switchery.min.css', ['block' => true]) ?>


<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('daterangepicker/moment.min.js', ['block' => true]); ?>
<?= $this->Html->script('daterangepicker.js', ['block' => true]); ?>
<?= $this->Html->script('evenement-briefs/switchery.min.js', ['block' => true]); ?>
<?= $this->Html->script('evenement-briefs/briefs.js', ['block' => true]); ?>

<?php
	$nb_onglets = count($onglet);
	$percent = 100 / $nb_onglets;
	
	$bloc_prec = $parametre['etape'] == 0 ? 'hide' : '';
?>

<?php echo $this->Form->create('Evenements'); ?>
	<?php echo $this->Html->link('Prec',['controller'=>'evenement-briefs', 'action'=>'etape', $parametre_prec], ['escape'=>false,"class"=>"hide", 'id'=>'sl-prec']); ?>
	<?php echo $this->Html->link('Next',['controller'=>'evenement-briefs', 'action'=>'etape', $parametre_next], ['escape'=>false,"class"=>"hide", 'id'=>'sl-next']); ?>
	<?php echo $this->Form->control('evenement_id', ['type'=>'hidden', 'value'=>$parametre['id']]); ?>
	<ul class="sl-timeline">
		<li class="<?php echo ($etape == 'evt') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> Evènement</li>
		<?php if(in_array('retrait', $onglet)){ ?>
		<li class="<?php echo ($etape == 'retrait') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> 
			Installation / Désinstallation
		</li>
		<?php } ?>
		<?php if(in_array('mail', $onglet)){ ?>
		<li class="<?php echo ($etape == 'mail') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> Email</li>
		<?php } ?>
		<li class="<?php echo ($etape == 'form') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> Formulaire</li>
		<?php if(in_array('fb', $onglet)){ ?>
		<li class="<?php echo ($etape == 'fb') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> Facebook</li>
		<?php } ?>
		<?php if(in_array('animation', $onglet)){ ?>
		<li class="<?php echo ($etape == 'animation') ? 'active' : ''; ?>" style="width: calc(<?php echo $percent; ?>%);"> Animation</li>
		<?php } ?>
	</ul>
	
	<?php
	switch($etape){
		// Onglet évènement
		case 'evt':
	?>
	
	<fieldset class="sl-fields-box">Localisation</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('adresse_exact', ['class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->adresse_exact : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('batiment', ['class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->batiment : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('rue', ['class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->rue : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('num_voie', ['label' => ['text' => 'N° Voie'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->num_voie : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('code_postal', ['class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->code_postal : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('acces', ['label' => ['text' => 'Accès'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->acces : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('acces_modalite', ['label' => ['text' => 'Modalité d\'accès'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->acces_modalite : '')]); ?>
		</div>
	</div>
	
	
	<fieldset class="sl-fields-box">Détail de l'évènement</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('nb_personnes', ['label' => ['text' => 'Nombre de personne estimé'], 'class' => 'form-control form-control-lg fg_numeric_entier', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->nb_personnes : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('horaire_debut', ['label' => ['text' => 'Horaire début de l\'évènement'], 'class' => 'form-control form-control-lg sl-horaire', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->horaire_debut : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('horaire_fin', ['label' => ['text' => 'Horaire fin de l\'évènement'], 'class' => 'form-control form-control-lg sl-horaire', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->horaire_fin : '')]); ?>
		</div>
	</div>
	
	
	<fieldset class="sl-fields-box">Contact sur place</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('nom_sp', ['label' => ['text' => 'Nom'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->nom_sp) != '' ? trim($evenement->evenement_brief->nom_sp) : trim($evenement->client->nom))]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('prenom_sp', ['label' => ['text' => 'Prénoms'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->prenom_sp) != '' ? trim($evenement->evenement_brief->prenom_sp) : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('contact_sp', ['label' => ['text' => 'N° Téléphone'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->contact_sp) != '' ? trim($evenement->evenement_brief->contact_sp) : trim($evenement->client->telephone))]); ?>
		</div>
	</div>
	
	<?php 
		break;
		// Onglet retrait installation / désinstallation
		case 'retrait':
	?>
	
	<?php if(in_array($evenement->type_installation, array(12, 13, 14))){ ?>
	<fieldset class="sl-fields-box">Installation</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('disposition_borne', ['class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->disposition_borne : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('distance_borne_prise', ['label' => ['text' => 'Distance approximative borne-prise électrique (en m)'], 'class' => 'form-control form-control-lg fg_numeric_entier', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->distance_borne_prise : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('date_installation', ['label' => ['text' => 'Date et horaire'], 'class' => 'form-control form-control-lg sl-horaire-date', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->date_installation) != '' ? $evenement->evenement_brief->date_installation->format('Y-m-d H:i:s') : '')]); ?>
		</div>
	</div>
	<?php } ?>
	<?php if(in_array($evenement->desinstallation_id, array(6, 7))){ ?>
	<fieldset class="sl-fields-box">Désinstallation</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('date_desinstallation', ['label' => ['text' => 'Date et horaire'], 'class' => 'form-control form-control-lg sl-horaire-date', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->date_desinstallation ) != '' ? $evenement->evenement_brief->date_desinstallation ->format('Y-m-d H:i:s') : '')]); ?>
		</div>
	</div>
	<?php } ?>
	
	<?php 
		break;
		// Onglet Email
		case 'mail':
	?>
	
	<fieldset class="sl-fields-box">Configuration Email</fieldset>
	<small><em>L'email destinataire est le mail de celui que Selfizee envoye les photos.</em></small>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('mail_destinataire', ['label' => ['text' => 'Email destinataire'], 'class' => 'form-control form-control-lg', 'type' => 'email', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->mail_destinataire) != '' ? trim($evenement->evenement_brief->mail_destinataire) : trim($evenement->client->email))]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('mail_objet', ['label' => ['text' => 'Objet Mail'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_objet : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10">
			<?php echo $this->Form->control('mail_message', ['label' => ['text' => 'Message'], "class" => "form-control textarea_editor1", "rows" => "5",'type' => 'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_message : '')]); ?>
		</div>
	</div>
	<fieldset class="sl-fields-box">Configuration au niveau de la Borne</fieldset>
	<small><em>Les configurations Wifi sont réquis 72h avant l'évènement.</em></small>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('mail_nom_wifi', ['label' => ['text' => 'Nom wifi'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_nom_wifi : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('mail_code_wifi', ['label' => ['text' => 'Code wifi'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_code_wifi : '')]); ?>
		</div>
	</div>
	
	<?php 
		break;
		// Onglet Formulaire
		case 'form':
			$is_checked = ($evenement->evenement_brief && $evenement->evenement_brief->form_check) ? ' checked="checked" ' : '';
	?>
	
	<fieldset class="sl-fields-box">Formulaire personnalisée</fieldset>
	<div class="row">
		<div class="col-sm-12">
			<label for="form_check">Souhaitez-vous collecter des coordonnées? </label><br/>
			<input id="form_check" name="form_check" <?php echo $is_checked; ?> type="checkbox" class="js-switch" data-color="#009efb" value="1" />
			<input id="form_uncheck" type="hidden" value="0">
		</div>
	</div>
	<div class="row sl-form-container <?php echo $is_checked ? '' : 'hide'; ?>">
		<div class="col-sm-10">
			<?php echo $this->Form->control('form_text',['label'=>'Expliquez vos besoins en remplissant ce formulaire',"class"=>"textarea_editor1 form-control", "rows"=>"4",'type'=>'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->form_text : '')]); ?>
		</div>
	</div>
	
	<?php 
		break;
		// Onglet Facebook
		case 'fb':
	?>
	
	<fieldset class="sl-fields-box">Configuration facebook</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('fb_nom_page', ['label' => ['text' => 'Nom de votre page Facebook'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_nom_page : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('fb_admin', ['label' => ['text' => 'Ajouter en tant qu\'Admin temporairement ce compte à votre page'], 'class' => 'form-control form-control-lg', 'id'=>false, 'name'=>false, 'readonly', 'value' => (!empty($evenement->nom_fb) ? $evenement->nom_fb : (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_admin : 'selfizee_admin'))]); ?>
		</div>
	</div>
	<fieldset class="sl-fields-box">Description de l'Album</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('fb_titre_album', ['label' => ['text' => 'Titre album'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_titre_album : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('fb_description_album', ['label' => ['text' => 'Brève description'], "class" => "form-control", "rows" => "4",'type' => 'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_description_album : '')]); ?>
		</div>
	</div>
	
	<?php 
		break;
		// Onglet Animation
		case 'animation':
	?>
	
	<fieldset class="sl-fields-box">Informations animation</fieldset>
	<div class="row">
		<div class="col-sm-6">
			<?php echo $this->Form->control('animation_horaire', ['label' => ['text' => 'Horaire de l\'animation'], 'class' => 'form-control form-control-lg sl-horaire', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->animation_horaire : '')]); ?>
		</div>
		<div class="col-sm-6">
			<?php echo $this->Form->control('animation_tenue_souhaite', ['label' => ['text' => 'Tenue souhaitée'], 'class' => 'form-control form-control-lg', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->animation_tenue_souhaite : '')]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10">
			<?php echo $this->Form->control('animation_objectifs',['label'=>'Objectifs spécifiques',"class"=>"textarea_editor1 form-control", "rows"=>"4",'type'=>'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->animation_objectifs : '')]); ?>
		</div>
	</div>
	
	<?php 
		break;
		}
	?>
	
	<div class="row" style="margin-top: 50px;">
		<div class="col-sm-6 <?php echo $bloc_prec; ?>">
			<?= $this->Form->button('← Etape précedente',['class'=>"btn btn-primary btn-lg btn-block sl-action", 'data-action'=>'sl-prec', 'escape'=>false]) ?>
		</div>
		<div class="col-sm-6">
		<?php if($nb_onglets == ($parametre['etape'] + 1)){ ?>
			<?= $this->Form->button('Enregistrer',['class'=>"btn btn-danger btn-lg btn-block sl-action", 'data-action'=>'sl-fin', 'escape'=>false]) ?>
		<?php }else{ ?>
			<?= $this->Form->button('Etape suivante →',['class'=>"btn btn-danger btn-lg btn-block sl-action", 'data-action'=>'sl-next', 'escape'=>false]) ?>
		<?php } ?>
		</div>
	</div>
	
	
<?php echo $this->Form->end(); ?>
<?php } ?>