<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evenement $evenement
 */
?>

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
$titrePage = "Briefing évent" ;
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
                <div class="form-body">
                    <h3 class="box-title m-t-40">Client</h3><hr>
					
                    <div class="row p-t-20">
                        <div class="col-md-6 bloc-type-client">
                            <?php $clientType = ['1'=>'Professionel' , '2'=>'Particulier' ]; echo $this->Form->control('client_type',['label' => 'Type Client', 'options'=>$clientType, 'value' => $evenement->client->type_client, 'disabled']); ?>
                        </div>

                        <div class="col-md-6 bloc-client">
                            <label class="control-label">Client</label><br>
                            <?php echo $this->Form->control('nom',['label' =>false, 'class'=>'form-control', 'value' => $evenement->client->prenom.' '.$evenement->client->nom]); ?>
                        </div>
                    </div>
					<?php // Détail de l'évènement ?>
                    <h3 class="box-title m-t-40">Détail événement </h3><hr>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('nb_personnes', ['label' => ['text' => 'Nombre de personne estimé'], 'class' => 'form-control fg_numeric_entier', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->nb_personnes : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('date_debut_immobilisation', ['label' => ['text' => 'Date début de l\'évènement'], 'class' => 'form-control', 'value' => (!empty($evenement->date_debut_immobilisation) ? $evenement->date_debut_immobilisation : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('horaire_debut', ['label' => ['text' => 'Horaire début de l\'évènement'], 'class' => 'form-control sl-horaire', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->horaire_debut : '')]); ?>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('date_fin_immobilisation', ['label' => ['text' => 'Date fin de l\'évènement'], 'class' => 'form-control', 'value' => (!empty($evenement->date_fin_immobilisation) ? $evenement->date_fin_immobilisation : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('horaire_fin', ['label' => ['text' => 'Horaire fin de l\'évènement'], 'class' => 'form-control sl-horaire', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->horaire_fin : '')]); ?>
						</div>
					</div>
					<?php // Localisation évènement ?>
                    <h3 class="box-title m-t-40">Localisation événement </h3><hr>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('adresse_exact', ['class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->adresse_exact : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('batiment', ['class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->batiment : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('rue', ['class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->rue : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('num_voie', ['label' => ['text' => 'N° Voie'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->num_voie : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('code_postal', ['class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->code_postal : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('acces', ['label' => ['text' => 'Accès'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->acces : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('acces_modalite', ['label' => ['text' => 'Modalité d\'accès'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->acces_modalite : '')]); ?>
						</div>
					</div>
					<?php // A propos de l'installation et désinstallation ?>
					<?php
					if(in_array($evenement->type_installation, array(12, 13, 14)) || in_array($evenement->desinstallation_id, array(6, 7))){
					?>
					<h3 class="box-title m-t-40">Installation et désinstallation </h3><hr>
					<?php if(in_array($evenement->type_installation, array(12, 13, 14))){ ?>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('disposition_borne', ['class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->disposition_borne : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('distance_borne_prise', ['label' => ['text' => 'Distance approximative borne-prise électrique (en m)'], 'class' => 'form-control fg_numeric_entier', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->distance_borne_prise : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('date_installation', ['label' => ['text' => 'Date et horaire installation'], 'class' => 'form-control sl-horaire-date', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->date_installation) != '' ? $evenement->evenement_brief->date_installation->format('Y-m-d H:i:s') : '')]); ?>
						</div>
					<?php } ?>
					<?php if(in_array($evenement->desinstallation_id, array(6, 7))){ ?>
						<div class="col-sm-6">
							<?php echo $this->Form->control('date_desinstallation', ['label' => ['text' => 'Date et horaire désinstallation'], 'class' => 'form-control sl-horaire-date', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->date_desinstallation ) != '' ? $evenement->evenement_brief->date_desinstallation ->format('Y-m-d H:i:s') : '')]); ?>
						</div>
					<?php } ?>
					</div>
					
					<?php
					}
					?>
					<?php // Configuration mail ?>
					<?php if($evenement->envoyer_recap && $evenement->client->client_type == 'corporation'){ ?>
					<h3 class="box-title m-t-40">Configuration mail et WIFI</h3><hr>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('mail_destinataire', ['label' => ['text' => 'Email destinataire'], 'class' => 'form-control', 'type' => 'email', 'value' => (!empty($evenement->evenement_brief) && trim($evenement->evenement_brief->mail_destinataire) != '' ? trim($evenement->evenement_brief->mail_destinataire) : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('mail_objet', ['label' => ['text' => 'Objet Mail'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_objet : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-10">
							<?php echo $this->Form->control('mail_message', ['label' => ['text' => 'Message'], "class" => "form-control textarea_editor1", "rows" => "5",'type' => 'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_message : '')]); ?>
						</div>
					</div>
					<fieldset class="sl-fields-box">Configuration au niveau de la Borne</fieldset>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('mail_nom_wifi', ['label' => ['text' => 'Nom wifi'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_nom_wifi : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('mail_code_wifi', ['label' => ['text' => 'Code wifi'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->mail_code_wifi : '')]); ?>
						</div>
					</div>
					
					<?php } ?>
					
					<?php 
						// Personnalisation formulaire 
						$is_checked = ($evenement->evenement_brief && $evenement->evenement_brief->form_check) ? ' checked="checked" ' : '';
					?>
					<h3 class="box-title m-t-40">Formulaire personnalisé</h3><hr>
					<div class="row">
						<div class="col-sm-12">
							<label for="form_check">Collection des coordonnées? </label><br/>
							<input id="form_check" name="form_check" <?php echo $is_checked; ?> type="checkbox" class="js-switch" data-color="#009efb" value="1" />
							<input id="form_uncheck" type="hidden" value="0">
						</div>
					</div>
					<div class="row sl-form-container <?php echo $is_checked ? '' : 'hide'; ?>">
						<div class="col-sm-10">
							<?php echo $this->Form->control('form_text',['label'=>'Explication du besoin',"class"=>"form-control textarea_editor1", "rows"=>"4",'type'=>'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->form_text : '')]); ?>
						</div>
					</div>
					<?php // Configuration facebook ?>
					<?php if($evenement->publication_fb){ ?>
					<h3 class="box-title m-t-40">Configuration facebook</h3><hr>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('fb_nom_page', ['label' => ['text' => 'Nom de la page Facebook'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_nom_page : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('fb_admin', ['label' => ['text' => 'Ajouter en tant qu\'Admin temporairement ce compte à votre page'], 'class' => 'form-control', 'id'=>false, 'name'=>false, 'readonly', 'value' => (!empty($evenement->nom_fb) ? $evenement->nom_fb : '')]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<?php echo $this->Form->control('fb_titre_album', ['label' => ['text' => 'Titre album'], 'class' => 'form-control', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_titre_album : '')]); ?>
						</div>
						<div class="col-sm-6">
							<?php echo $this->Form->control('fb_description_album', ['label' => ['text' => 'Brève description'], "class" => "textarea_editor1 form-control", "rows" => "4",'type' => 'textarea', 'value' => (!empty($evenement->evenement_brief) ? $evenement->evenement_brief->fb_description_album : '')]); ?>
						</div>
					</div>
					<?php } ?>
					<?php if($evenement->animation_hotesse){ ?>
					<h3 class="box-title m-t-40">Informations animation</h3><hr>
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
					<?php } ?>
                </div> 
            </div>
        </div>
    </div>
</div>




