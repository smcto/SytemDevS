<?php $this->extend('vente_layout') ?>

<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('ventes/add.css', ['block' => true]) ?>

<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('ventes/add.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('ventes/devis_modal.js', ['block' => true]); ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>


<?= $this->Form->create($venteEntity, ['class' => 'form-client-facturation step-vente clearfix', 'type' => 'file']); ?>
    <!--  variables à passer dans js :D -->
    <div class="d-none">
        <input type="checkbox" name="is_step_client_filled" value="<?= (bool) @$dataClient; ?>">
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row-fluid">
                <h2 class="">Vente</h2>
                
                <div class="mt-4 row">
                    <div class="col-md-6">
                        <?= $this->Form->control('user_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Commercial *', 'default' => $currentUser['id']]); ?>
                    </div>
                
                    <div class="col-md-6">
                        <?= $this->Form->control('parc_id', ['default' => @$vente_mode == null ? 4 : '' , 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Type de vente *', 'required']); ?>
                    </div>
                    
                    <div class="col-md-6 nb_mois <?= $venteEntity->parc_id == 4 || $venteEntity->parc_id == 9 ? '' : 'd-none' ?>">
                        <?= $this->Form->control('parc_duree_id', ['value' => 1, 'default' => 1, 'options' => @$parc_durees, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Nombre de mois']); ?>
                    </div>
            
                    <div class="col-md-6 debut_fin <?= $venteEntity->parc_id == 4 || $venteEntity->parc_id == 9 ? '' : 'd-none' ?>">
                        <div class="row">
                            <div class="col-md-12">
                                    <label for="">Date début</label>
                                    <?= $this->Form->text('contrat_debut', ['type' => 'date', 'value' => $venteEntity->contrat_debut == null ?: $venteEntity->contrat_debut->format('Y-m-d'), 'id' => 'facturation-date-signature']); ?>
                                </div>
                            <div class="col-md-6 hide">
                                    <label for="">Date fin</label>
                                    <?= $this->Form->text('contrat_fin', ['type' => 'date', 'value' => $venteEntity->contrat_fin == null ?: $venteEntity->contrat_fin->format('Y-m-d'), 'id' => 'facturation-date-signature']); ?>
                                </div>                                
                        </div>
                    </div>
            
                    <div class="col-md-6">
                        <?= $this->Form->control('is_sous_location', ['label' => 'Convention de partenariat sous location']); ?>
                    </div>
                    
                    <div class="col-md-6">
                        <?= $this->Form->control('is_abonnement_bo', ['label' => 'Abonnement BO']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row-fluid mb-4 block-client">
                <h2 class="">Client</h2>

                <div class="clearfix">
                    <h4 class="my-4">Infos entreprise :</h4>
                    
                    <div class="mt-4 d-block">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row container-choix-client">
                                    <div class="col-md-6">
                                        <?= $this->Form->control('client_id', ['empty' => 'Rechercher', 'label' => 'Client *', 'class' => 'load-ajax-client form-control client_id']) ?>
                                    </div>
                                    <div class="col-md-6 align-self-center pt-1 ">
                                        <button type="button" class="btn btn btn-rounded btn-success is_new_client">Nouveau client</button>
                                        <div class="d-none"><?= $this->Form->control('is_client_not_in_sellsy', ['label' => 'Nouveau client', 'checked' => 'checked']); ?></div>
                                    </div>
                                </div>
                    
                                <div class="row container-checkgroupe-clients ">
                                    <div class="col-md-6">
                                        <?= $this->Form->control('is_client_belongs_to_group', ['label' => 'Appartient à un groupe de client']); ?>
                                    </div>
                                </div>
                                <div class="row container-groupe-clients <?= $venteEntity->is_client_belongs_to_group == 1 ? '' : 'd-none' ?>">
                                    <div class="col-md-6">
                                        <?= $this->Form->control('groupe_client_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker form-control', 'data-live-search' => true, 'label' => 'Choisir parmi groupe de clients']); ?>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="col-md-6 proprietaire <?= $venteEntity->is_agence != 0 ? '' : 'd-none' ?>">
                                <?= $this->Form->control('proprietaire', ['label' => 'Pour le compte de qui ? *']); ?>
                            </div>
                        </div>
                    
                    
                        
                        <div class="row">
                            <div class="col-md-6 d-none">
                                <?= $this->Form->control('client.id', ['label' => 'Nom', 'id' => 'client_id']); ?>
                            </div>
                        </div>

                        <div class="clearfix info-client <?= $venteEntity->is_client_not_in_sellsy == 0 ? '' : '' ?>">

                            <div class="row ">
                                <div class="col-md-6">
                                    <?= $this->Form->control('client.client_type', ['label' => 'Genre', 'options' => $genres, 'class' => 'selectpicker']) ?>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-6">
                                    <?= $this->Form->control('client.nom', ['label' => "Raison sociale (*)", 'class' => 'client-required form-control', 'id' => 'raison_sociale']); ?>
                                </div>

                                <div class="col-md-6 ">
                                    <?= $this->Form->control('client.enseigne', ['label' => "Enseigne", 'class' => 'form-control', 'id' => 'enseigne']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.adresse', ['label' => "Adresse", 'class' => 'form-control new-clients', 'id' => 'client_adresse']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.adresse_2', ['label' => "Adresse complémentaire", 'type' => 'text', 'class' => 'form-control new-clients', 'id' => 'client_adresse_2']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.cp', ['type' => 'number', 'label' => 'Code postal', 'id' => 'client_cp']); ?>
                                </div>

                                <div class="col-md-6">
                                    <div class="clearfix">
                                        <label for="">Ville</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="pt-2"><?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox', ]); ?></div>
                                        </div>

                                        <div class="col-md-8 bloc-ville">
                                            <div class="clearfix select <?= !$venteEntity->is_ville_manuel ? '' : 'd-none' ?>"><?= $this->Form->control('client.ville', ['options' => $villesFrances ?? [], 'empty' => 'Sélectionner par rapport au code postal', 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                            <div class="clearfix input <?= $venteEntity->is_ville_manuel ? '' : 'd-none' ?>"><?= $this->Form->control('client.ville', ['label' => false, $venteEntity->is_ville_manuel ? '' : 'disabled', 'class' => 'form-control client_text']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.pays_id', ['options' => $payss, 'default' => 5, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'data-live-search' => true, 'label' => 'Pays', 'id' => 'country']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.telephone', ['label' => "Tél entreprise", 'class' => 'form-control' ]); ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $this->Form->control('client.telephone_2', ['label' => "2ème Téléphone", 'class' => 'form-control' ]); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.email', ['label' => "Email général", 'class' => 'form-control' ]); ?>
                                </div>


                                <div class="col-md-6">
                                    <?= $this->Form->control('client.tva_intra_community', ['label' => "Tva Intracommunautaire", 'type' => 'text', 'class' => 'form-control new-clients']); ?>
                                </div>

                                <div class="col-md-6">
                                    <?= $this->Form->control('client.siren', ['label' => "Siren", 'type' => 'text', 'class' => 'form-control new-clients']); ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <?= $this->Form->control('client.siret', ['label' => "Siret", 'type' => 'text', 'class' => 'form-control new-clients']); ?>
                                </div>

                                <div class="col-md-6 client-pro">
                                    <?= $this->Form->control('client.secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites form-control', 'label' => "Secteur d'activité", 'required' => true, 'style' => 'width:100%']); ?>
                                </div>

                            </div>
                        </div>
                                    
                    </div>
                </div>

                <div class="clearfix added-contacts  <?php /*$venteEntity->contact_client_id != '' ? '' : 'd-none'*/ ?>">
                    <h4 class="">Infos contacts :</h4>

                    <div class="container-contacts"><?= $this->element('../Ventes/vente_clients_contact', ['clientEntity' => $venteEntity->client]) ?></div>

                    <div class="mt-4">
                        <div class="row-fluid">
                            <label for="">Localisation google map</label>

                            <div class="row-fluid">
                                <div id="mapCanvas" style="width:auto; height:250px;"></div>
                                <div class="kl_infoForm">Vous pouvez déplacer la position du curseur</div>
                                <div class="error error-message kl_erreurLongLat hide">Déplacer le cuseur pour prendre la position</div>
                            </div>

                            <div class="form-group row d-none">
                                <div class="col-sm-6">
                                    <label class="control-label">Latitude</label><?php echo $this->Form->control('client.addr_lat',["id" => "txtLatitude", 'type'=>'text', 'label' => false, 'class'=>'form-control ']);?>
                                 </div>
                                 <div class="col-sm-6">
                                    <label class="control-label">Longitude</label><?php echo $this->Form->control('client.addr_lng',["id" => "txtLongitude", 'type'=>'text', 'label' => false, 'class'=>'form-control ']);?>
                                 </div>
                                 <input id="lat_lng" type="text" size="50" value="" class="hide" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row-fluid mb-4">
                <h2 class="">DEVIS</h2>

                <div class="row-fluid mt-4">
                    <label for="documents">Documents <span class="loader-upload d-none text-muted">en cours de chargement ... <img src="<?= $this->Url->build('/img/pipeline/loader.svg') ?>" class="ml-2 " alt=""></span></label>
                    <div class="dropzone" id="documents" data-srcurl="<?= $this->Url->build('/', true) ?>">
                        <div class="fallback">
                            <?= $this->Form->control('file', ['multiple']); ?>
                        </div>
                        <?php if ($venteEntity->ventes_devis_uploads): ?>
                            <?php foreach ($venteEntity->ventes_devis_uploads as $key => $ventes_devis_uploads): ?>
                                <div class="container_devis_uploaded mb-4 d-none" data-filename="<?= $ventes_devis_uploads['filename'] ?>">
                                    <?= $ventes_devis_uploads['id'] ? $this->Form->text("ventes_devis_uploads[$key][id]", ['value' => $ventes_devis_uploads['id']]) : ''?>
                                    <?= $this->Form->text("ventes_devis_uploads[$key][filename]", ['value' => $ventes_devis_uploads['filename']]); ?>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                     </div>
                </div>
            </div>
        </div>
    </div>
            
    <div class="clearfix mb-4"><?= $this->Form->submit('Suivant', ['class' => 'btn btn-primary float-right next']) ?></div>

<?= $this->form->end() ?>