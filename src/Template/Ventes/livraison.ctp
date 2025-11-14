<?php $this->extend('vente_layout') ?>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>
<?= $this->Html->script('ventes/livraison.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('ventes/changment_contact.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>


<?= $this->Form->create($venteEntity, ['class' => 'step-vente']); ?>
    <div class="card">
        <div class="card-body">
        <div class="row-fluid">
            <h2 class="">LIVRAISON</h2>
            <div class="row mt-4">
                <div class="col-md-6 ">
                    <div class="mt-1"><?= $this->Form->control("is_livraison_different_than_contact_client", ['id' => 'is_livraison_different_than_contact_client', 'label' => 'Livraison pour un contact différent',  'escape' => false]); ?></div>
                </div>
            </div>

            <div class="container-infoslivraison clearfix <?= $venteEntity->is_livraison_different_than_contact_client == 1 ? '' : 'd-none' ?>">
                <div class="row">
                    <div class="col-md-6 ">
                        <?= $this->Form->control('vente_livraison_contact_client_id', ['value' => $venteEntity->vente_livraison_contact_client_id, 'options' => $clientContacts, 'label' => 'Contact client', 'class' => 'form-control selectpicker client_contact_id', 'data-live-search' => true, 'empty' => 'Sélectionner']); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 ">
                        <div class=""><?= $this->Form->control('livraison_crea_fullname', ['class' => 'form-control form_fullname', 'id' => 'livraison_crea_fullname', 'default' => $clientEntity->get('full_name'), 'data-default' => $clientEntity->get('full_name'), 'label' => 'Nom contact']); ?></div>
                    </div>

                    <div class="col-md-6 ">
                        <?= $this->Form->control('livraison_crea_lastname', ['class' => 'form-control form_lastname', 'id' => 'livraison_crea_lastname', 'label' => 'Prénom du contact']); ?>
                    </div>

                    <div class="col-md-6 ">
                        <?= $this->Form->control('livraison_crea_fonction', ['class' => 'form-control form_fonction', 'id' => 'livraison_crea_fonction', 'label' => 'Fonction dans l’entreprise']); ?>
                    </div>
                
                    <div class="col-md-6 ">
                        <?= $this->Form->control('livraison_crea_email', ['class' => 'form-control form_email',  'id' => 'livraison_crea_email', 'default' => $clientEntity->email, 'data-default' => $clientEntity->email, 'label' => 'Email']); ?>
                    </div>
                
                    <div class="col-md-6 ">
                        <?= $this->Form->control('livraison_crea_telmobile', ['class' => 'form-control form_telmobile',  'id' => 'livraison_crea_telmobile', 'default' => $clientEntity->mobile, 'data-default' => $clientEntity->mobile, 'label' => 'Tel portable']); ?>
                    </div>
                
                    <div class="col-md-6 ">
                        <?= $this->Form->control('livraison_crea_telfixe', ['class' => 'form-control form_telfixe',  'id' => 'livraison_crea_telfixe', 'default' => $clientEntity->telephone, 'data-default' => $clientEntity->telephone, 'label' => 'Tel fixe']); ?>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6 align-self-center">
                    <div class="row">
                        <div class="col-md-6"><?= $this->Form->control("is_livraison_adresse_diff_than_client_addr", ['id' => 'is_livraison_adresse_diff_than_client_addr', 'label' => 'Livraison dans un lieu différent']); ?></div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>

            <div class="container-adress <?= $venteEntity->is_livraison_adresse_diff_than_client_addr == 1 ? '' : 'd-none' ?>">
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('livraison_client_adresse', ['id' => 'livraison_client_adresse', 'class' => 'form-control adresse',  'label' => 'Adresse',]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('livraison_client_cp', ['id' => 'livraison_client_cp', 'class' => 'form-control cp',  'label' => 'Code postal',]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('livraison_client_ville', ['id' => 'livraison_client_ville', 'class' => 'form-control ville', 'label' => 'Ville',]); ?>
                    </div>
                    <div class="col-md-3">
                        <?= $this->Form->control('livraison_pays_id', ['id' => 'pays_id', 'default' => 5,  'label' => 'Pays', 'options' => $payss, 'class' => 'form-control selectpicker country', 'data-live-search' => true, 'empty' => 'Sélectionner']); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $this->Form->control('livraison_contact_note', ['id' => 'livraison_contact_note', 'default' => $clientEntity->get('livraison_contact_note'), 'label' => 'Commentaire']); ?>
                </div>
            </div>

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
                        <?= $this->Form->hidden('client.client_contact.is_from_livraison', ['id' => 'is_from_livraison', 'value' => 1]); ?>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="">Informations livraison</h2>
            <div class="row mt-4">

                <div class="col-md-6">
                    <label class="control-label" for="livraison-date">Date de livraison souhaitée *</label> 
                    <?= $this->Form->control('livraison_type_date', ['type' => 'select', 'options' => $livraison_type_dates, 'empty' => 'Sélectionner', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Sélectionner",'required', 'class' => 'selectpicker']) ?>
                    <div class="clearfix livr_date_text <?= $venteEntity->livraison_type_date == 'precis' ?: 'd-none' ?>">
                        <label for="livraison_date">Date précise</label>
                        <?= $this->Form->text('livraison_date', ['type' => 'date', 'id' => 'livraison_date', 'value' => $venteEntity->livraison_date == null ?: $venteEntity->livraison_date->format('Y-m-d')]); ?>
                    </div>
                </div>

                <div class="col-md-6 ">
                    <label class="control-label" for="date_first_usage">Date de 1ère utilisation de la borne (1er event) :</label>
                    <?= $this->Form->text('livraison_date_first_usage', ['type' => 'date', 'id' => 'date_first_usage', 'value' => $venteEntity->livraison_date_first_usage == null ?: $venteEntity->livraison_date_first_usage->format('Y-m-d'), 'placeholder' => 'dd/mm/yyyy']); ?>
                </div>

                <div class="col-md-6 mt-4">
                    <?= $this->Form->control('livraison_infos_sup', ['label' => 'Informations supplémentaires ']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix mb-4">
        <?= $this->Form->submit('Suivant', ['class' => 'btn btn-primary float-right next']) ?>
        <a href="<?= $this->Url->build(['action' => 'briefProjet']) ?>" class="btn btn-secondary float-left next">Précédent</a>
    </div>
<?= $this->form->end() ?>