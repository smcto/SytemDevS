<?php $this->extend('vente_layout') ?>

<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->script('Clients/add.js?'.  time(), ['block' => 'script']); ?>
<?php $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.fr-FR.js', ['block' => true]); ?>
<?php $this->Html->script('ventes/briefprojet.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('ventes/changment_contact.js?time='.time(), ['block' => 'script']); ?>

<?php $contact_crea_is_same_contact_as_client = $venteEntity->contact_crea_is_same_contact_as_client ?>
<?= $this->Form->create($venteEntity, ['class' => 'step-vente']); ?>
    <div class="card">
        <div class="card-body">

            <div class="row-fluid">
                <h2 class="">Config créa</h2>
                <div class="row mt-3">
                    <div class="col-md-6 ">
                        <div class="mt-1"><?= $this->Form->control("is_contact_crea_different_than_contact_client", ['type' => 'checkbox', 'neednote', 'hiddenField' => false, 'id' => 'is_contact_crea_different_than_contact_client', 'label' => 'Contact différent que le contact principal ?',  'escape' => false]); ?></div>
                    </div>
                </div>

                <div class="container-hidden hidden-precision clearfix <?= $venteEntity->is_contact_crea_different_than_contact_client == 1 ? '' : 'd-none' ?>">
                    <div class="row">
                        <div class="col-md-6 ">
                            <?= $this->Form->control('vente_crea_contact_client_id', ['value' => $venteEntity->vente_crea_contact_client_id, 'options' => $clientContacts, 'label' => 'Contact client', 'class' => 'form-control selectpicker client_contact_id', 'data-live-search' => true, 'empty' => 'Sélectionner']); ?>
                        </div>
                    </div>
                    <div class="row container-vente-contact">
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_fullname', ['class' => 'form-control form_fullname', 'label' => 'Nom du contact']); ?>
                        </div>
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_lastname', ['class' => 'form-control form_lastname', 'label' => 'Prénom du contact']); ?>
                        </div>
                    
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_fonction', ['class' => 'form-control form_fonction', 'label' => 'Fonction dans l’entreprise']); ?>
                        </div>
                    
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_email', ['class' => 'form-control form_email', 'label' => 'Email']); ?>
                        </div>
                    
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_telmobile', ['class' => 'form-control form_telmobile', 'label' => 'Tel portable']); ?>
                        </div>
                    
                        <div class="col-md-6 ">
                            <?= $this->Form->control('contact_crea_telfixe', ['class' => 'form-control form_telfixe', 'label' => 'Tel fixe']); ?>
                        </div>
                    </div>
                    
                    <?php $this->start('old_a_supprimer') ?>
                        <div class="container-contacts d-none" data-action="<?= $this->Url->build(['controller' => 'Ventes', 'action' => 'addContacts', $clientEntity->id]) ?>">
                            <?= $this->element('../Ventes/vente_clients_contact', ['clientEntity' => $clientEntity]) ?>
                            <div class="clearfix my-4">
                                <button type="button" class="btn btn-rounded btn-success float-right maj-contact">Mettre à jour les contacts</button>
                            </div>
                        </div>
                    <?php $this->end() ?>

                    <div class="clearfix contact-pre-rempli d-none">
                        <?php /*$lastKey = collection($clientEntity->client_contacts)->count();*/ ?>
                        <div class="row container-vente-contact">
                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.nom', ['id' => 'nom', 'label' => 'Nom du contact']); ?>
                            </div>
                        
                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.prenom', ['id' => 'prenom', 'label' => 'Prénom du contact']); ?>
                            </div>
                        
                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.position', ['id' => 'position', 'label' => 'Fonction']); ?>
                            </div>
                        
                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.email', ['id' => 'email', 'label' => 'Email']); ?>
                            </div>
                        
                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.tel', ['id' => 'tel', 'label' => 'Tel portable']); ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('client.client_contact.telephone_2', ['id' => 'telephone_2', 'label' => 'Téléphone Fixe']); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $this->Form->hidden('client.client_contact.is_from_crea', ['id' => 'is_from_crea', 'value' => 1]); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row-fluid">
                        <?= $this->Form->control('contact_crea_note', ['label' => 'Commentaire optionnel ']); ?>
                    </div>
                </div>

            </div>

            <div class="row-fluid  ">
                <?= $this->Form->control('config_crea_note',['label' => 'Note', "class" => "textarea_editor form-control", "rows" => 7]); ?>
            </div>
        </div>
    </div>
    
    <div class="clearfix mb-4">
        <?= $this->Form->submit('Suivant', ['class' => 'btn btn-primary float-right next']) ?>
        <a href="<?= $this->Url->build(['action' => 'OptionsConsommables']) ?>" class="btn btn-secondary float-left next">Précédent</a>
    </div>
<?= $this->form->end() ?>