<?php use Cake\Routing\Router; ?>
<?php $this->Html->css('devis/add.css?time='.time(), ['block' => 'css']); ?>
<?php $this->Html->css('fontawesome5/css/all.min.css', ['block' => 'css']); ?>
<?php $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('clients/autocomplet-addresse.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?php $this->Html->script('moment/moment.js', ['block' => 'script']); ?>
<?= $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php $this->Html->script('devis/add.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('devis/autre.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('devis/corps_devis.js?time='.time(), ['block' => 'script']); ?>
<?php $this->Html->script('calendar/dist/lib/jquery-ui.min.js', ['block' => 'script']); ?>
<?php $this->Html->script('Clients/autocomplet-addresse.js', ['block' => 'script']); ?>

<!-- A placer après add.js, corps_devis.js et autre.js peut dépendre des fonctions dedans -->
<?php $this->Html->script('devis/commun_devis_et_facture.js?time='.time(), ['block' => 'script']); ?>

<?php 
$custum_title = ($id || $model_id)?'Modification devis':'Création devis';
if($devisEntity->is_model) {
    $custum_title = ($id || $model_id)? 'Modèle devis - ' . $devisEntity->model_name : 'Création modèle de devis';
}
$this->assign('custom_title',  '<h1 class="m-0 top-title">' . $custum_title . '</h1>');
?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <?php if($id) : ?>
            <a href="<?= $this->Url->build($devisEntity->get('EncryptedUrl')) ?>" target="_blank" class="btn btn-rounded btn-primary">Version web</a>
            <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => 'pdfversion', $id]) ?>" target="_blank" class="btn btn-rounded btn-primary pdf_version">Version pdf</a>
        <?php endif ?>
        <a class="btn btn-rounded btn-primary save_model" data-toggle="modal" href='#model_devis'><?= $devisEntity->is_model?'Enregistrer le modèle':'Enregistrer en tant que modèle' ?></a>
        <a href="javascript:void(0);" class="btn btn-rounded btn-primary save_continuer_devis <?= $devisEntity->is_model?'hide':'' ?>">Enregistrer et continuer</a>
        <a href="javascript:void(0);" class="btn btn-rounded btn-primary save_devis <?= $devisEntity->is_model?'hide':'' ?>">Enregistrer et quitter</a>
        <a href="<?= $this->Url->build(['controller' => 'devis', 'action' => $devisEntity->is_model?'modelList':'index']) ?>" class="btn btn-rounded btn-inverse">Annuler</a>
    </div>
<?php $this->end() ?>


<?php $this->start('dropdownSubMenu') ?>
    <a class="dropdown-item ligne" href="javascript:void(0);">Nouvelle ligne simple</a>
    <a class="dropdown-item object" href="javascript:void(0);">Objet du catalogue</a>
    <a class="dropdown-item sous-total" href="javascript:void(0);">Sous-total</a>
    <a class="dropdown-item titre" href="javascript:void(0);">Nouveau titre</a>
    <a class="dropdown-item commentaire" href="javascript:void(0);">Nouveau commentaire</a>
    <a class="dropdown-item saut-page" href="javascript:void(0);">Nouveau saut de page</a>
    <a class="dropdown-item saut-ligne" href="javascript:void(0);">Nouveau saut de ligne</a>
    <a class="dropdown-item new-abonnement" href="javascript:void(0);">Abonnement</a>
<?php $this->end() ?>

<!-- Valeur à passer dans corpds_devis.js, add.js -->
    <?= $this->Form->hidden('devis_id', ['id' => 'devis_id', 'value' => $id]); ?>
    <?= $this->Form->hidden('tva', ['id' => 'default_tva', 'value' => $defaultTva->valeur]); ?>
    <?= $this->Form->hidden('tva_decimal', ['id' => 'default_tva_decimal', 'value' => round($defaultTva->valeur/100, 2)]); ?>
<!--  -->

<!-- Modal -->
<?= $this->element('devis_et_factures/proposition-save') ?>

<?php $this->start('td_options') ?>
    <div class="row w-75 mx-auto">
        <div class="col p-0 text-center order-ico">
            <a class=" fas fa-arrows-alt-v text-primary align-middle" href="javascript:void(0);"></a>
        </div>
        <div class="col p-0 text-center">
            <a class="bg-white tr-options" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-ellipsis-v text-primary"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li class="dropdown-submenu dropright ajout-dessus">
                    <a class="dropdown-item dropdown-toggle zaza" href="javascript:void(0);" id="dropdown-layouts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Nouvelle ligne en dessus </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                        <?= $this->fetch('dropdownSubMenu') ?>
                    </div>
                </li>
                <li class="dropdown-submenu dropright ajout-dessous">
                    <a class="dropdown-item dropdown-toggle zaza" href="javascript:void(0);" id="dropdown-layouts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Nouvelle ligne en dessous </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                        <?= $this->fetch('dropdownSubMenu') ?>
                    </div>
                </li>
                <li class="dropdown-submenu dropright option">
                    <a class="dropdown-item dropdown-toggle zaza" href="javascript:void(0);" id="dropdown-layouts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Ligne en option </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                        <a class="dropdown-item set-ligne-option" href="javascript:void(0);">Oui</a>
                        <a class="dropdown-item del-ligne-option" href="javascript:void(0);">Non</a>
                    </div>
                </li>
                <li class="dropdown-submenu dropright abonnement">
                    <a class="dropdown-item dropdown-toggle zaza" href="javascript:void(0);" id="dropdown-layouts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Abonnement </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-layouts">
                        <a class="dropdown-item set-ligne-abonnement" href="javascript:void(0);">Oui</a>
                        <a class="dropdown-item del-ligne-abonnement" href="javascript:void(0);">Non</a>
                    </div>
                </li>
                <li class="dropdown-submenu dropright clone-tr">
                    <a class="dropdown-item zaza float-right" href="javascript:void(0);"> Dupliquer cette ligne </a>
                </li>
            </ul>
        </div>
    </div>
<?php $this->end() ?>

<?php $this->assign('title', 'Création devis') ?>

<div class="checkbox d-none"> <label for="sn-checkbox-open-in-new-window"> <input type="checkbox" id="sn-checkbox-open-in-new-window" checked="">Ouvrir dans une nouvelle fenêtre</label></div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="devis_client_adress" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['url' => ['action' => 'editInfosClient'], 'class' => '']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modifier adresse client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->control('adresse', ['id' => 'adresse']); ?>
                    <?= $this->Form->control('cp', ['label' => 'Code postal', 'id' => 'cp']); ?>
                    <?= $this->Form->control('ville', ['id' => 'ville']); ?>
                    <?= $this->Form->control('country', ['label' => 'Pays', 'id' => 'country']); ?>
                    <?= $this->Form->control('adresse_2', ['type' => 'text', 'id' => 'edit_client_adress_2', 'label' => 'Adresse complémentaire']); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="edit_client_btn">Enregistrer</button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="devis_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($newContact, ['id' => 'add_contact_client']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Attribuer un contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row row-client">
                        <div class="col-md-5 mt-2 m-b-30">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input radios-existing-contact" id="group_radios_client_1" name="client_contact" value="1" checked>
                                <label class="custom-control-label" for="group_radios_client_1">Contact existant </label>
                            </div>
                        </div>
                        <div class="col-md-6 existing-contact">
                            <?= $this->Form->control('contact_id', ['empty' => 'Sélectionner', 'options' => $clientContacts, 'label' => false, 'id' => 'contact_id']) ?>
                        </div>
                    </div>

                    <div class="custom-control custom-radio mt-3">
                        <input type="radio" class="custom-control-input radios-new-contact" id="group_radios_client_2" value="2" name="client_contact">
                        <label class="custom-control-label" for="group_radios_client_2">Nouveau contact</label>
                    </div>

                    <div class="mt-4  nouveau-contact hide">

                        <h3 class="pb-2 mb-3 bordered">Informations contact</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Information générales:</legend>
                                    <div class="row">
                                        <label class="control-label col-md-4 m-t-10">Civilité</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('civilite', [
                                                        'options' => $civilite, 
                                                        'type' => 'radio', 
                                                        'label'=>false,
                                                        'hiddenField'=>false,
                                                        'legend'=>false,
                                                        'class' => 'row',
                                                        'templates' => [
                                                            'inputContainer' => '<div class="form-group row">{{content}}</div>',
                                                            'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}} class="label-civilite">{{text}}</label>',
                                                            'radioWrapper' => '<div class="radio radio-success radio-inline  m-l-15">{{label}}</div>'
                                                        ]
                                                ]) ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name">Prénom</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('prenom', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name">Nom</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('nom', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Fonction </label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('position', ['label' => false, 'id' => false]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Email</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('email', ['class' => 'form-control','label' => false, 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Tél</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('tel', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Mobile</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('telephone_2', ['type'=>'text', 'class' => 'form-control', 'label' => false , 'maxlength' => 255]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Fax</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('fax', ['class' => 'form-control','label' => false ]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-mail">Site web</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('site_web', ['class' => 'form-control','label' => false ]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5">Date de naissance</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->text('date_naiss', ['type' => 'date', 'class' => 'form-control pro','label' => false]); ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Social :</legend>
                                    <div class="row">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-twitter-square" aria-hidden="true"></i> Twitter</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('twitter', ['id' => 'client-type','label' => false]) ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5 client-name"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('facebook', ['label' => false]); ?>
                                        </div>
                                    </div>
                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-linkedin-square" aria-hidden="true"></i> LinkedIN </label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('linkedin', ['label' => false]); ?>
                                        </div>
                                    </div>

                                    <div class="row row-contact">
                                        <label class="control-label col-md-4 m-t-5"><i class="fa fa-viadeo-square" aria-hidden="true"></i> Viadeo</label>
                                        <div class="col-md-8">
                                            <?= $this->Form->control('viadeo', ['class' => 'form-control','label' => false]); ?>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset class="fieldset-contact">
                                    <legend class="legend-fieldset-contact">Note :</legend>
                                    <?= $this->Form->control('contact_note', ['type'=>'textarea', 'class' => 'tinymce-note', 'label' => false]); ?>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Ajouter le contact'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($devisEntity, ['id' => 'edit_client_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Changer le client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('edit_client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le client'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
<?= $this->element('../Devis/modal_catalog') ?>
<!-- END MODAL -->



<?= $this->Form->create($devisEntity, ['class' => 'form-devis']); ?>

    <!-- // si echeance 2x, 3x etc regénérées en mode édition, ca efface toutes les echeances en cours et réajoute les nouveaux -->
    <?= $this->Form->hidden('is_echeance_regenerated', ['class' => 'is_echeance_regenerated', 'value' => 0]); ?>
    <?= $this->Form->hidden('uuid'); ?>
    <?= $this->Form->hidden('client_adresse', ['id' => 'client_adresse']); ?>
    <?= $this->Form->hidden('client_adresse_2', ['id' => 'client_adresse_2']); ?>
    <?= $this->Form->hidden('client_cp', ['id' => 'client_cp']); ?>
    <?= $this->Form->hidden('client_ville', ['id' => 'client_ville']); ?>
    <?= $this->Form->hidden('client_country', ['id' => 'client_country']); ?>
    <?= $this->Form->hidden('client_id', ['id' => 'client_id']); ?>
    <?= $this->Form->hidden('client_contact_id', ['id' => 'client_contact_id']); ?>
    <?= $this->Form->hidden('is_from_model', ['value' => (bool) $this->request->getQuery('model_devis_id')]); ?>

    <div class="card">
        <div class="card-body">
            <input type="hidden" id="is_continue" value="0" name="is_continue">
            <div class="row <?= $devisEntity->is_model?"hide" :"" ?>">
                <div class="col-md-3">
                    <div class="row-fluid">
                        <?= $this->Form->hidden('nom_societe', ['placeholder' => '' ,'label' => 'Nom de la société', 'value' => 'KONITYS']); ?>
                        <div class="bloc-addr">
                            <?= $this->Form->control('ref_commercial_id', ['options' => $commercials, 'label' => 'Réf. commercial', 'class' => 'selectpicker','default'=> $user_connected['id'] ]); ?>
                            KONITYS <br>
                            <span id="c-adresse"><?= $devisPreferenceEntity->adress->adresse ?></span> <br>
                            <span id="c-cp"><?= $devisPreferenceEntity->adress->cp?></span> <span id="c-ville"><?= $devisPreferenceEntity->adress->ville ?></span> <br> <br>
                            <b>Votre contact : </b> <span id="full_name"><?= $currentUser->get('full_name') ?></span>
                        </div>

                        <div class="infos row-fluid">
                            <span class="text-grey"> Tel : </span> <span id="telephone_fixe"><?= $currentUser->telephone_portable ?></span> <br>
                            <span class="text-grey"> Email : </span><span id="email"><?= $currentUser->email ?></span>
                            <a class="mb-4 d-block" id="link-user" target="_blank" href="<?= $this->Url->build(['controller' => 'users', 'action' => 'edit', $currentUser->id]) ?>">Modifier les informations par défaut</a>
                        </div>
                    </div>
                </div>

                <div class="offset-xl-6 offset-md-3 col-xl-3 col-md-6 col-sm-6">
                    <div class="row-fluid no-spin">
                        <?php if (!is_null($id)): ?>
                            <?= $this->Form->control('status', ['options' => $devis_status, 'label' => 'Etat', 'templates' => 'app_form_inline']); ?>
                        <?php endif ?>
                        <?= $this->Form->control('indent', ['label' => 'Devis N°', 'templates' => 'app_form_inline']); ?>
                        <div class="form-group row">
                            <label class="col-md-5" for="date-crea">En date du</label><div class="col-md-7"><?= $this->Form->text('date_crea', ['type' => 'date', 'value' => $devisEntity->date_crea? $devisEntity->date_crea->format('Y-m-d') : ""]); ?></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5" for="date-sign-before">À signer avant le</label><div class="col-md-7"><?= $this->Form->text('date_sign_before', ['type' => 'date', 'id' => 'date_validite', 'value' => $devisEntity->date_sign_before? $devisEntity->date_sign_before->format('Y-m-d') : ""]); ?></div>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <?= $this->Form->control('client_nom', ['label' => 'Nom du client', 'value' => $devisEntity->client->nom ?? ""]); ?>
                        <span class="client_contact">
                            <?php if ($devisEntity->devis_client_contact) : ?>
                            À l'attention de <b><?= $devisEntity->devis_client_contact->civilite ?> <?= $devisEntity->devis_client_contact->full_name ?></b>
                            <?php endif; ?>
                        </span>
                        <br>
                        <span class="clinet_info">
                            <?= $devisEntity->client_adresse ?> <br>
                            <?= $devisEntity->client_adresse_2? $devisEntity->client_adresse_2."<br>":"" ?>
                            <?= $devisEntity->client_cp .' '. $devisEntity->client_ville ?> <br>
                            <?= $devisEntity->client_country ?>
                        </span>
                        <div class="row-fluid mt-3">
                            <a class="d-block add-contact" data-toggle="modal" href='#edit_client'>Changer le client</a>
                            <a class="d-block add-contact" data-toggle="modal" href='#devis_contact' data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'saveCurrentContact']) ?>">Attribuer un contact</a>
                            <a class="d-block delete-contact" href="javascript:void(0);">Supprimer le contact</a>
                            <a class="d-block" data-toggle="modal" href='#devis_client_adress' data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'saveCurrentClientAdress']) ?>">Modifier adresse</a>
                            <a class="d-block link_edit_client" target="_blank" href="<?= $this->Url->build(['controller' => 'clients', 'action' => 'add', $clientEntity->id]) ?>">Modifier adresse par défaut du client</a>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row m-t-40">
                <div class="col-md-6">
                    <div class="row-fluid mb-2">
                        <span>Objet du devis: </span>
                    </div>

                    <div class="container-objet">
                        <div class="row-fluid bloc-objet">
                            <?= $this->Form->control('objet', ['label' => false, 'class' => 'tinymce-note form-control', 'type' => 'textarea', 'required' => 'required']); ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 <?= $devisEntity->is_model ? "hide" :"" ?>">
                                <?= $this->Form->control('antennes._ids', ['class' => 'form-control select2','label' => 'Antenne(s) locale(s)', 'options' => $antennes, 'data-placeholder' => 'choisir des antennes', 'multiple'=> "multiple", 'style' => 'width:100%']); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('model_type', ['class' => 'form-control','label' => 'Type de la borne', 'options' => $type_bornes, 'empty' => 'Séléctionner']); ?>
                        </div>
                    </div>

                    <div class="<?= $devisEntity->is_model ? "hide" :"" ?>">
                        <div class="">
                            <div class="row-fluid bloc-objet">
                                <label>Date événement</label>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <?= $this->Form->control('periode', ['label' => false, 'options' => ['1' => 'Le jour du', '2' => 'Période du'], 'value' => $devisEntity->date_evenement_fin?2 : 1]); ?>
                                    </div>
                                    <div class="form-group debut_evenement <?= $devisEntity->date_evenement_fin?'col-md-4':'col-md-9' ?>">
                                        <?= $this->Form->text('date_evenement', ['type' => 'date', 'value' => $devisEntity->date_evenement? $devisEntity->date_evenement->format('Y-m-d') : ""]); ?>
                                    </div>
                                    <div class="m-l-15 m-r-15 m-t-10 fin_evenement <?= $devisEntity->date_evenement_fin?'':'hide' ?>">
                                         au 
                                    </div>
                                    <div class="form-group  col-md-4 fin_evenement <?= $devisEntity->date_evenement_fin?'':'hide' ?>">
                                        <?= $this->Form->text('date_evenement_fin', ['id' => 'date_evenement_fin', 'type' => 'date', 'value' => $devisEntity->date_evenement_fin? $devisEntity->date_evenement_fin->format('Y-m-d') : ""]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid ">
                <h3>Détails</h3>
                <div class="row-fluid mb-4">
                    <a href="javascript:void(0);" class="btn btn-sm btn-primary new_product_line">Nouvelle ligne</a>
                    <a class="btn btn-sm btn-primary new_product_from_catalog" data-toggle="modal" href='#devis_catalog' data-position="bottom" data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'saveCurrentClientAdress']) ?>">Choisir depuis le catalogue</a>
                </div>
                
                <div class="">
                    <table class="table table-uniforme table_bloc_devis table-bordered  detail-form ">
                        <thead class="bg-light">
                            <tr>
                                <th width="4%"></th>
                                <th width="10%"><a class="visibility-mark <?= $isInnactive = @$colVisibilityParams->ref ? 'isInnactive' : '' ?>" data="ref" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Référence</th>
                                <th class="th-descr" width="500px"><a class="visibility-mark <?= $isInnactive = @$colVisibilityParams->descr ? 'isInnactive' : '' ?>" data="descr" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Description</th>
                                <th class="remise <?= ($id || $model_id)? (!$devisEntity->remise_hide_line?:"hide"): "hide"?>"><a class="visibility-mark <?= $isInnactive = ($id || $model_id)? (@$colVisibilityParams->remise ? 'isInnactive' : ''):"isInnactive" ?>" data="remise" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Remise</th>
                                <th><a class="visibility-mark <?= $isInnactive = @$colVisibilityParams->prix_unit_ht ? 'isInnactive' : '' ?>" data="prix_unit_ht" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Coût unitaire HT</th>
                                <th width="6%"><a class="visibility-mark <?= $isInnactive = @$colVisibilityParams->tva ? 'isInnactive' : '' ?>" data="tva" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> TVA</th>
                                <th width="6%"><a class="visibility-mark <?= $isInnactive = @$colVisibilityParams->qty ? 'isInnactive' : '' ?>" data="qty" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Qté</th>
                                <th width="10%" class="text-right"><a class="visibility-mark" <?= $isInnactive = @$colVisibilityParams->montant_ht ? 'isInnactive' : '' ?> data="montant_ht" href="javascript:void(0);"><span class="fa <?= $isInnactive ? 'fa-eye-slash' : 'fa-eye' ?>"></span></a> Montant HT</th>
                                <th width="4%"></th>
                            </tr>
                        </thead>
                        
                        <!-- Recois les params -->
                        <?= $this->Form->hidden('col_visibility_params'); ?>

                        <tbody id="sortable" class="default-data">
                            <?php if($devisEntity->devis_produits) : ?>
                                <?php foreach ($devisEntity->devis_produits as $key => $ligne) : ?>
                            
                                    <?php if($ligne->type_ligne == 'produit') : ?>
                                        <tr class="clone added-tr <?= $ligne->line_option?'ligne-option':'' ?>">
                                            <td class=""><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.catalog_produits_id", ['input-name' => 'catalog_produits_id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.nom_commercial", ['input-name' => 'nom_commercial', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.is_consommable", ['input-name' => 'is_consommable', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.line_option", ['input-name' => 'line_option', 'label' => false, 'class' => '']); ?>
                                            </td>
                                            <td><?= $this->Form->control("devis_produits.$key.reference", ['input-name' => 'reference', 'label' => false, 'placeholder' => 'REF PRODUIT']); ?></td> 
                                            <td class="p-0"><?= $this->Form->control("devis_produits.$key.description_commercial", ['input-name' => 'description_commercial', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?> </td>
                                            <td class="block-remise remise <?= ($id || $model_id)? (!$devisEntity->remise_hide_line?:"hide"): "hide"?>">
                                                <div class="row">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.remise_value", ['input-name' => 'remise_value', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.remise_unity", ['input-name' => 'remise_unity', 'label' => false, 'class' => 'form-control', 'options' => ['%' => '%', '€' =>'€' ], 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                                </div>
                                            </td>
                                            <td class="block-remise">
                                                
                                                <label class="ligne-for-abonnement d-none">TARIF CLIENT</label>
                                                <div class="row  ligne-for-abonnement d-none">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.tarif_client", ['input-name' => 'tarif_client', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.unites_client_id", ['input-name' => 'unites_client_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité', 'options' => $catalogUnites]); ?></div>
                                                </div>
                                                
                                                <label class="m-t-10 ligne-for-abonnement d-none">TARIF INTERNE</label>
                                                <div class="row">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.prix_reference_ht", ['input-name' => 'prix_reference_ht', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.catalog_unites_id", ['input-name' => 'catalog_unites_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité']); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement d-none">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.tva_client", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva_client', 'label' => false, 'class'=>"form-control tva-value"]); ?></div>
                                                </div>
                                                <label class="m-t-10 ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.tva", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva', 'label' => false, 'class'=>"form-control tva-value"]); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement d-none">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.quantite_client", ['input-name' => 'quantite_client', 'label' => false, 'type' => 'number']); ?></div>
                                                </div>
                                                <label class="m-t-10 ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.quantite_usuelle", ['input-name' => 'quantite_usuelle', 'label' => false, 'type' => 'number']); ?></div>
                                                </div>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'produit']); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <label class="ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement d-none">
                                                    <div class="col-12"><div class="montant_ht_client"><?= $ligne->montant_client ?></div></div>
                                                    <?= $this->Form->hidden("devis_produits.$key.montant_client", ['input-name' => 'montant_client']); ?>
                                                </div>
                                                <label class="m-t-30 ligne-for-abonnement d-none label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><div class="montant_ht_value"></div></div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                    <?php if($ligne->type_ligne == 'abonnement') : ?>
                                        <tr class="clone-new-abonnement added-tr <?= $ligne->line_option?'ligne-option':'' ?>">
                                            <td class=""><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.catalog_produits_id", ['input-name' => 'catalog_produits_id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.is_consommable", ['input-name' => 'is_consommable', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.nom_commercial", ['input-name' => 'nom_commercial', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.line_option", ['input-name' => 'line_option', 'label' => false, 'class' => '']); ?>
                                            </td>
                                            <td><?= $this->Form->control("devis_produits.$key.reference", ['input-name' => 'reference', 'label' => false, 'placeholder' => 'REF PRODUIT']); ?></td> 
                                            <td class="p-0"><?= $this->Form->control("devis_produits.$key.description_commercial", ['input-name' => 'description_commercial', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?> </td>
                                            <td class="block-remise remise <?= ($id || $model_id)? (!$devisEntity->remise_hide_line?:"hide"): "hide"?>">
                                                <div class="row">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.remise_value", ['input-name' => 'remise_value', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.remise_unity", ['input-name' => 'remise_unity', 'label' => false, 'class' => 'form-control', 'options' => ['%' => '%', '€' =>'€' ], 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                                </div>
                                            </td>
                                            <td class="block-remise">
                                                
                                                <label class="ligne-for-abonnement">TARIF CLIENT</label>
                                                <div class="row ligne-for-abonnement">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.tarif_client", ['input-name' => 'tarif_client', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.unites_client_id", ['input-name' => 'unites_client_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité', 'options' => $catalogUnites]); ?></div>
                                                </div>
                                                
                                                <label class="m-t-10 ligne-for-abonnement">TARIF INTERNE</label>
                                                <div class="row">
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.prix_reference_ht", ['input-name' => 'prix_reference_ht', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                                    <div class="col-6"><?= $this->Form->control("devis_produits.$key.catalog_unites_id", ['input-name' => 'catalog_unites_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité']); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.tva_client", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva_client', 'label' => false, 'class'=>"form-control tva-value"]); ?></div>
                                                </div>
                                                <label class="m-t-10 ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.tva", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva', 'label' => false, 'class'=>"form-control tva-value"]); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.quantite_client", ['input-name' => 'quantite_client', 'label' => false, 'type' => 'number']); ?></div>
                                                </div>
                                                <label class="m-t-10 ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><?= $this->Form->control("devis_produits.$key.quantite_usuelle", ['input-name' => 'quantite_usuelle', 'label' => false, 'type' => 'number']); ?></div>
                                                </div>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'abonnement']); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <label class="ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row ligne-for-abonnement">
                                                    <div class="col-12"><div class="montant_ht_client"><?= $ligne->montant_client ?></div></div>
                                                    <?= $this->Form->hidden("devis_produits.$key.montant_client", ['input-name' => 'montant_client']); ?>
                                                </div>
                                                <label class="m-t-30 ligne-for-abonnement label-for-abonnement"> -</label>
                                                <div class="row">
                                                    <div class="col-12"><div class="montant_ht_value"></div></div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'sous_total') : ?>
                                        <tr class="clone-sous-total added-tr">
                                            <td class="text-center"><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="5" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Sous-total</h4></div>
                                                <?= $this->Form->hidden("devis_produits.$key.sous_total", ['input-name' => 'sous_total', 'label' => false, ]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'sous_total']); ?>
                                            </td>
                                            <td class="montant_ht text-right">
                                                <div class="row">
                                                    <div class="col-12"><div class="montant_ht_value sous-total-value"><?= $ligne->sous_total ?></div></div>
                                                </div>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'titre') : ?>
                                        <tr class="clone-titre added-tr">
                                            <td class="text-center"><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="6" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("devis_produits.$key.titre_ligne", ['input-name' => 'titre_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'titre']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'commentaire') : ?>
                                        <tr class="clone-commentaire added-tr">
                                            <td class="text-center"><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="6" class="p-0 dynamic-colspan">
                                                <?= $this->Form->control("devis_produits.$key.commentaire_ligne", ['input-name' => 'commentaire_ligne', 'label' => false, 'class' => 'tinymce-note', 'type' => 'textarea']); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'value' => 'commentaire']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_ligne') : ?>
                                        <tr class="clone-saut-ligne added-tr">
                                            <td class="text-center"><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="6" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de ligne</h4></div>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_ligne']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if($ligne->type_ligne == 'saut_page') : ?>
                                        <tr class="clone-saut-page added-tr">
                                            <td class="text-center"><?= $this->fetch('td_options') ?></td>
                                            <td class="d-none">
                                                <?= $this->Form->hidden("devis_produits.$key.id", ['input-name' => 'id', 'label' => false]); ?>
                                                <?= $this->Form->hidden("devis_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                            </td>
                                            <td colspan="6" class="bg-light dynamic-colspan">
                                                <div class="text-center"> <h4>Saut de page</h4></div>
                                                <?= $this->Form->hidden("devis_produits.$key.type_ligne", ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_page']); ?>
                                            </td>
                                            <td class="text-center"><a href="javascript:void(0);"  data-href="<?= $this->Url->build(['controller' => 'AjaxDevis', 'action' => 'deleteLineDevisProduit',$ligne->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endif; ?>
                                        
                                <?php endforeach; ?>
                                        
                            <?php else : ?>
                                <tr><td colspan="8" class="text-center first-tr py-5 dynamic-colspan">Ajouter une ligne</td></tr>
                            <?php endif; ?>
                        </tbody>

                        <tfoot>
                            <tr class="clone d-none added-tr">
                                <td class=""><?= $this->fetch('td_options') ?></td>
                                <td class="d-none">
                                    <?= $this->Form->hidden("devis_produits.catalog_produits_id", ['input-name' => 'catalog_produits_id', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.is_consommable", ['input-name' => 'is_consommable', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.nom_commercial", ['input-name' => 'nom_commercial', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                    <?= $this->Form->hidden("devis_produits.line_option", ['input-name' => 'line_option', 'label' => false, 'class' => '']); ?>
                                </td>
                                <td><?= $this->Form->control("devis_produits.reference", ['input-name' => 'reference', 'label' => false, 'placeholder' => 'REF PRODUIT']); ?></td> 
                                <td class="p-0"><?= $this->Form->control("devis_produits.description_commercial", ['input-name' => 'description_commercial', 'label' => false, 'class' => '', 'type' => 'textarea', 'id' => '']); ?> </td>
                                <td class="block-remise remise <?= ($id || $model_id)? (!$devisEntity->remise_hide_line?:"hide"): "hide"?>">
                                    <div class="row">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.remise_value", ['input-name' => 'remise_value', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.remise_unity", ['input-name' => 'remise_unity', 'label' => false, 'class' => 'form-control', 'options' => ['%' => '%', '€' =>'€' ], 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                    </div>
                                </td>
                                <td class="block-remise">

                                    <label class="ligne-for-abonnement d-none">TARIF CLIENT</label>
                                    <div class="row ligne-for-abonnement d-none">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.tarif_client", ['input-name' => 'tarif_client', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.unites_client_id", ['input-name' => 'unites_client_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité', 'options' => $catalogUnites]); ?></div>
                                    </div>

                                    <label class="m-t-10 ligne-for-abonnement d-none">TARIF INTERNE</label>
                                    <div class="row">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.prix_reference_ht", ['input-name' => 'prix_reference_ht', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.catalog_unites_id", ['input-name' => 'catalog_unites_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <label class="ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row ligne-for-abonnement d-none">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.tva_client", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva_client', 'label' => false, 'default' => $defaultTva->valeur, 'class'=>"form-control tva-value"]); ?></div>
                                    </div>
                                    <label class="m-t-10 ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.tva", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva', 'label' => false, 'default' => $defaultTva->valeur, 'class'=>"form-control tva-value"]); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <label class="ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row ligne-for-abonnement d-none">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.quantite_client", ['input-name' => 'quantite_client', 'label' => false, 'type' => 'number', 'default' => 1]); ?></div>
                                    </div>
                                    <label class="m-t-10 ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.quantite_usuelle", ['input-name' => 'quantite_usuelle', 'label' => false, 'type' => 'number', 'default' => 1]); ?></div>
                                    </div>
                                    <?= $this->Form->hidden("devis_produits.type_ligne", ['input-name' => 'type_ligne', 'value' => 'produit']); ?>
                                </td>
                                <td class="montant_ht text-right">
                                    <label class="ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row ligne-for-abonnement d-none">
                                        <div class="col-12"><div class="montant_ht_client"></div></div>
                                    </div>
                                    <label class="m-t-30 ligne-for-abonnement label-for-abonnement d-none"> -</label>
                                    <div class="row">
                                        <div class="col-12"><div class="montant_ht_value"></div></div>
                                    </div>
                                </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>

                            <tr class="clone-new-abonnement added-tr d-none">
                                <td class=""><?= $this->fetch('td_options') ?></td>
                                <td class="d-none">
                                    <?= $this->Form->hidden("devis_produits.catalog_produits_id", ['input-name' => 'catalog_produits_id', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.is_consommable", ['input-name' => 'is_consommable', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.nom_commercial", ['input-name' => 'nom_commercial', 'label' => false]); ?>
                                    <?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                    <?= $this->Form->hidden("devis_produits.line_option", ['input-name' => 'line_option', 'label' => false, 'class' => '']); ?>
                                </td>
                                <td><?= $this->Form->control("devis_produits.reference", ['input-name' => 'reference', 'label' => false, 'placeholder' => 'REF PRODUIT']); ?></td> 
                                <td class="p-0"><?= $this->Form->control("devis_produits.description_commercial", ['input-name' => 'description_commercial', 'label' => false, 'class' => '', 'type' => 'textarea', 'id' => '']); ?> </td>
                                <td class="block-remise remise <?= ($id || $model_id)? (!$devisEntity->remise_hide_line?:"hide"): "hide"?>">
                                    <div class="row">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.remise_value", ['input-name' => 'remise_value', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control', 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.remise_unity", ['input-name' => 'remise_unity', 'label' => false, 'class' => 'form-control', 'options' => ['%' => '%', '€' =>'€' ], 'disabled' => ($id || $model_id)? !$devisEntity->remise_line:true]); ?></div>
                                    </div>
                                </td>
                                <td class="block-remise">

                                    <label class="ligne-for-abonnement ">TARIF CLIENT</label>
                                    <div class="row ligne-for-abonnement ">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.tarif_client", ['input-name' => 'tarif_client', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.unites_client_id", ['input-name' => 'unites_client_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité', 'options' => $catalogUnites]); ?></div>
                                    </div>

                                    <label class="m-t-10 ligne-for-abonnement ">TARIF INTERNE</label>
                                    <div class="row">
                                        <div class="col-6"><?= $this->Form->control("devis_produits.prix_reference_ht", ['input-name' => 'prix_reference_ht', 'label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?></div>
                                        <div class="col-6"><?= $this->Form->control("devis_produits.catalog_unites_id", ['input-name' => 'catalog_unites_id', 'label' => false, 'class' => 'form-control', 'empty' => 'unité']); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <label class="ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row ligne-for-abonnement ">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.tva_client", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva_client', 'label' => false, 'default' => $defaultTva->valeur, 'class'=>"form-control tva-value"]); ?></div>
                                    </div>
                                    <label class="m-t-10 ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.tva", ['type' => 'select', 'options' => $tvas, 'input-name' => 'tva', 'label' => false, 'default' => $defaultTva->valeur, 'class'=>"form-control tva-value"]); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <label class="ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row ligne-for-abonnement ">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.quantite_client", ['input-name' => 'quantite_client', 'label' => false, 'type' => 'number', 'default' => 1]); ?></div>
                                    </div>
                                    <label class="m-t-10 ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row">
                                        <div class="col-12"><?= $this->Form->control("devis_produits.quantite_usuelle", ['input-name' => 'quantite_usuelle', 'label' => false, 'type' => 'number', 'default' => 1]); ?></div>
                                    </div>
                                    <?= $this->Form->hidden("devis_produits.type_ligne", ['input-name' => 'type_ligne', 'value' => 'abonnement']); ?>
                                </td>
                                <td class="montant_ht text-right">
                                    <label class="ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row ligne-for-abonnement ">
                                        <div class="col-12"><div class="montant_ht_client"></div></div>
                                    </div>
                                    <label class="m-t-30 ligne-for-abonnement label-for-abonnement "> -</label>
                                    <div class="row">
                                        <div class="col-12"><div class="montant_ht_value"></div></div>
                                    </div>
                                </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>


                            <tr class="clone-sous-total added-tr d-none">
                                <td><?= $this->fetch('td_options') ?></td>
                                <td class="d-none"><?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?></td>
                                <td colspan="5" class="bg-light dynamic-colspan">
                                    <div class="text-center"> <h4>Sous-total</h4></div>
                                    <?= $this->Form->hidden('devis_produits.sous_total', ['input-name' => 'sous_total', 'label' => false, ]); ?>
                                    <?= $this->Form->hidden('devis_produits.type_ligne', ['input-name' => 'type_ligne', 'value' => 'sous_total']); ?>
                                </td>
                                <td class="montant_ht text-right">
                                    <div class="row">
                                        <div class="col-12"><div class="montant_ht_value sous-total-value"></div></div>
                                    </div>
                                </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>

                            <tr class="clone-titre added-tr d-none">
                                <td><?= $this->fetch('td_options') ?></td>
                                <td class="d-none"><?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?></td>
                                <td colspan="6" class="p-0 dynamic-colspan">
                                    <?= $this->Form->control('devis_produits.titre_ligne', ['input-name' => 'titre_ligne', 'label' => false, 'type' => 'textarea','id' => '']); ?>
                                    <?= $this->Form->hidden('devis_produits.type_ligne', ['input-name' => 'type_ligne', 'value' => 'titre']); ?>
                                    </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>

                            <tr class="clone-commentaire added-tr d-none">
                                <td><?= $this->fetch('td_options') ?></td>
                                <td class="d-none"><?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?></td>
                                <td colspan="6" class="p-0 dynamic-colspan">
                                    <?= $this->Form->control('devis_produits.commentaire_ligne', ['input-name' => 'commentaire_ligne', 'label' => false, 'type' => 'textarea','id' => '']); ?>
                                    <?= $this->Form->hidden('devis_produits.type_ligne', ['input-name' => 'type_ligne', 'value' => 'commentaire']); ?>
                                    </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>

                            <tr class="clone-saut-ligne added-tr d-none">
                                <td><?= $this->fetch('td_options') ?></td>
                                <td class="d-none"><?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?></td>
                                <td colspan="6" class="bg-light dynamic-colspan">
                                    <div class="text-center"> <h4>Saut de ligne</h4></div>
                                    <?= $this->Form->hidden('devis_produits.type_ligne', ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_ligne']); ?>
                                </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>

                            <tr class="clone-saut-page added-tr d-none">
                                <td><?= $this->fetch('td_options') ?></td>
                                <td class="d-none"><?= $this->Form->hidden("devis_produits.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?></td>
                                <td colspan="6" class="bg-light dynamic-colspan">
                                    <div class="text-center"> <h4>Saut de page</h4></div>
                                    <?= $this->Form->hidden('devis_produits.type_ligne', ['input-name' => 'type_ligne', 'label' => false, 'value' => 'saut_page']); ?>
                                </td>
                                <td class="text-center"><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>

            <div class="row m-t-40">
                <div class="col-md-6">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            Nombre de produit(s) du document <br>
                            <b class="nombre_produit">0</b>
                        </div>
                    </div>
                    <?= $this->Form->control('note', ['class' => 'tinymce-note', 'data-height' => 120]); ?>
                </div>

                <div class="col-md-6">
                    <table class="table table-uniforme  total-avec-abonnement d-none">
                        <thead class="">
                            <tr class="hide">
                                <th width="90%"></th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                            <tr class="">
                                <th colspan="3"><b>Total pour les clients</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-montant-ht">Montant total HT</td>
                                <td class="text-right montant_general total_general_ht_client">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ht_client'); ?>
                            </tr>
                            <tr  class="total-remise-global <?= ($id || $model_id)? (!$devisEntity->remise_line?:"hide"): ""?>">
                                <td>Réduction HT</td>
                                <td class="text-right montant_general remise-global-ht-client">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_reduction_client'); ?>
                            </tr>
                            <tr class="total-remise-global <?= ($id || $model_id)? (!$devisEntity->remise_line?:"hide"): ""?>">
                                <td>Total HT après réduction</td>
                                <td class="text-right montant_general total-after-remise-client">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_remise_client'); ?>
                            </tr>
                            <tr>
                                <td class="tva-label">TVA</td>
                                <td class="text-right montant_general total_general_tva_client">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_tva_client'); ?>
                            </tr>
                            <tr>
                                <td>Montant total TTC</td>
                                <td class="text-right montant_general total_general_ttc_client">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ttc_client',['id' => 'total_ttc_value_client']); ?>
                            </tr>
                        </tbody>
                    </table>
                    
                    <br>
                    
                    <table class="table table-uniforme">
                        <thead class="">
                            <tr class="hide">
                                <th width="90%"></th>
                                <th width="5%"></th>
                                <th width="5%"></th>
                            </tr>
                            <tr class="total-avec-abonnement d-none">
                                <th colspan="3"><b>Total interne</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-montant-ht">Montant total HT</td>
                                <td class="text-right montant_general total_general_ht">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ht'); ?>
                            </tr>
                            <tr  class="total-remise-global <?= ($id || $model_id)? (!$devisEntity->remise_line?:"hide"): ""?>">
                                <td>Réduction HT</td>
                                <td class="text-right montant_general remise-global-ht">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_reduction'); ?>
                            </tr>
                            <tr class="total-remise-global <?= ($id || $model_id)? (!$devisEntity->remise_line?:"hide"): ""?>">
                                <td>Total HT après réduction</td>
                                <td class="text-right montant_general total-after-remise">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_remise'); ?>
                            </tr>
                            <tr>
                                <td class="tva-label">TVA</td>
                                <td class="text-right montant_general total_general_tva">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_tva'); ?>
                            </tr>
                            <tr>
                                <td>Montant total TTC</td>
                                <td class="text-right montant_general total_general_ttc">0</td>
                                <td>€</td>
                                <?= $this->Form->hidden('total_ttc',['id' => 'total_ttc_value']); ?>
                                <?= $this->Form->hidden('total_ttc_restant',['id' => 'total_ttc_restant', 'value' => $devisEntity->get('ResteEcheanceImpayee')]); ?>
                                <?= $this->Form->hidden('nb_echeance_paid',['id' => 'nb_echeance_paid', 'value' => $devisEntity->get('NbEcheancePaid')]); ?>
                                <?= $this->Form->hidden('devis_has_echeance',['id' => 'devis_has_echeance', 'value' => (bool) $devisEntity->devis_echeances && $devisEntity->delai_reglements == "echeances"]); ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <?= $this->Form->control('commentaire_client'); ?>
            <?= $this->Form->control('commentaire_commercial'); ?>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="col-lg-12">
                <div class="row">
                    <?php $isParamsOpen = false ?>
                    <div class="col-md-5 col-8 align-self-center">
                        <h3><a data-toggle="collapse"data-parent="#accordion" aria-expanded="<?= $isParamsOpen ? 'true' : 'false' ?>" href="#preferences" aria-controls="preferences">Préférences du document</a></h3>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <a data-toggle="collapse"data-parent="#accordion" aria-expanded="<?= $isParamsOpen ? 'true' : 'false' ?>" href="#preferences" aria-controls="preferences"class="btn-preference btn btn-primary pull-right <?= $isParamsOpen ? '' : 'collapsed' ?>"> <?= $isParamsOpen ? 'Fermer' : 'Ouvrir' ?> </a>
                    </div>
                </div>

                <div id="preferences" class="collapse <?= $this->request->getQuery('test') ? 'show' : '' ?> <?= $isParamsOpen ? 'show' : '' ?>">
                    <div class="pieds_de_page">
                        <ul class="nav nav-tabs mt-4" id="my-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="infospaiement-tab" data-toggle="tab" href="#infospaiement" role="tab" aria-controls="infospaiement" aria-selected="true">Informations de paiement</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="remise&accompte-tab" data-toggle="tab" href="#remise&accompte" role="tab" aria-controls="remise&accompte" aria-selected="false">Remises et acomptes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="affichage-tab" data-toggle="tab" href="#affichage" role="tab" aria-controls="affichage" aria-selected="false">Paramètres d’affichage</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-4" id="my-tab">
                            <div class="tab-pane fade show active" id="infospaiement" role="tabpanel" aria-labelledby="infospaiement-tab">
                                <div class="row">
                                    <?php foreach ($moyen_reglements as $key => $moyen_reglement): ?>
                                        <div class="col-md-3">
                                            <?= $this->Form->control("moyen_reglements[$key]", ['type' => 'checkbox', 'label' => $moyen_reglement, 'checked' => $devisEntity->moyen_reglements[$key] == 1 ? 'checked' : '']); ?>
                                        </div>
                                    <?php endforeach ?>
                                </div>

                                <?= $this->Form->control('info_bancaire_id', ['empty' => 'Sélectionner', 'options' => $infosBancaires, 'label' => 'Coordonnées bancaires ', 'class' => 'selectpicker coord_bq']); ?>
                                <?= $this->Form->control('delai_reglements', ['empty' => 'Sélectionner', 'options' => $delai_reglements, 'label' => 'Délai de paiement', 'class' => 'selectpicker']); ?>
                                <div class="row div-echeance <?= $devisEntity->delai_reglements == 'echeances'?'':'hide' ?>">
                                    <div  class="col-md-2">
                                        <b>Détails de paiement</b>
                                    </div>
                                    <div  class="col-md-5">
                                        Paiement en <a href="javascript:void(0);" onclick="echeanceAdd(2)">2x</a> ,  <a href="javascript:void(0);" onclick="echeanceAdd(3)">3x</a> , <a href="javascript:void(0);" onclick="echeanceAdd(4)">4x</a> , <a href="javascript:void(0);" onclick="echeanceAdd(6)">6x</a> , <a href="javascript:void(0);" onclick="echeanceAdd(12)">12x</a> , <a href="javascript:void(0);" onclick="echeanceAdd(24)">24x</a> - <a href="javascript:void(0);" onclick="echeanceAdd()">Ajouter une échéance</a> - <a href="javascript:void(0);" onclick="echeanceUpdate()">Mettre à jour les échéances</a>
                                        <table id="echeance" class="mb-0 table mt-4 table-bordered table-uniforme">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Date</th>
                                                    <th width="30%">Montant</th>
                                                    <th width="20%">Pourcentage</th>
                                                    <th width="20%"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="echeance">
                                                <?php if($devisEntity->devis_echeances) : ?>
                                                    <?php foreach ($devisEntity->devis_echeances as $key => $echeance) : ?>
                                                        <tr class="<?= $echeance->is_payed ? "is_payed" : "" ?>" date="<?= $echeance->date?$echeance->date->format('Y-m-d'):"" ?>" montant="<?= $echeance->montant ?>">
                                                            <td>
                                                                <?= $this->Form->hidden("devis_echeances.$key.id", ['input-name' => 'id', 'class' => '', 'label' => false, ]); ?>
                                                                <?= $this->Form->text("devis_echeances.$key.date", ['input-name' => 'date',  'class' => 'form-control echeance-date', 'label' => false, 'type' => 'date', 'value' => $echeance->date?$echeance->date->format('Y-m-d'):""]); ?>
                                                            </td>
                                                            <td>
                                                                <?= $this->Form->control("devis_echeances.$key.montant", ['input-name' => 'montant', 'type' => 'number', 'step' => '0.01', 'class' => 'form-control echeance-montant', 'label' => false]); ?>
                                                                <?= $this->Form->control("devis_echeances.$key.is_payed", ['input-name' => 'is_payed', 'class' => 'form-control', 'label' => false]); ?>
                                                            </td>
                                                            <td>
                                                                <?= $this->Form->control("devis_echeances.$key.percent_value", ['input-name' => 'percent_value', 'label' => false]); ?>
                                                            </td>
                                                            <td class="text-center action">
                                                                <?php if (!$echeance->is_payed): ?>
                                                                    <a href="javascript:void(0);" class="delete-echeance" onclick="deleteRow(this)">
                                                                        <i class="mdi mdi-delete text-inverse"></i>
                                                                        <!-- Ts aiko oe inona ny asan'ity -->
                                                                        <input type="hidden" class="num-to-delete" value="<?=$key?>">
                                                                    </a>
                                                                <?php else: ?>
                                                                    <b class="text-success">Payée</b>
                                                                <?php endif ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>

                                            <?php $init = isset($k) ? $k+1 : 0 ?>
                                            <tfoot class="echeance hide">
                                                <tr>
                                                    <td>
                                                        <?= $this->Form->text("default", ['input-name' => 'date', 'class' => 'form-control echeance-date', 'label' => false, 'type' => 'date']); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->control("default", ['input-name' => 'montant', 'type' => 'number', 'step' => '0.01', 'class' => 'form-control echeance-montant', 'label' => false]); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->control("default", ['input-name' => 'percent_value', 'type' => 'number', 'step' => '0.01', 'label' => false]); ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);" class="delete-echeance" onclick="deleteRow(this)">
                                                            <i class="mdi mdi-delete text-inverse"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <table class="table hide-table-empty table-uniforme">
                                            <thead>
                                                <tr>
                                                    <th width="23%"></th>
                                                    <th width="40%"></th>
                                                    <th width="20%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><b>Total échéances</b></td>
                                                    <td colspan="2"><div class="ml-3 total_echeances"> <?= $devisEntity->get('TotalEcheances') ?></div></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Reste</b></td>
                                                    <td colspan="2"> <div class="ml-3 rest_echeances"><?= $devisEntity->get('ResteEcheanceMontant') ?></div></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>

                                <?= $this->Form->control('display_virement', ['label' => 'afficher les informations bancaire pour le règlement par virement']); ?>
                                <div class="clearfix container-infos-bq <?= $devisEntity->display_virement ?: 'd-none' ?>">
                                    <div class="row">
                                        <div class="col-1">
                                            <b>Banque :</b>
                                        </div>
                                        <div class="col-10 p-0">
                                            <p class="mb-4 infos-bq-ajax">
                                                <?= @$devisEntity->infos_bancaire->adress ?> <br>
                                                BIC : <?= @$devisEntity->infos_bancaire->bic ?> <br>
                                                IBAN : <?= @$devisEntity->infos_bancaire->iban ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <?= $this->Form->control('display_cheque', ['label' => 'afficher le libellé si règlement par chèque activé']); ?>
                                <div class="container-libelle mb-4 <?= $devisEntity->display_cheque ?: 'd-none' ?>"><b>KONITYS</b></div>

                                <?= $this->Form->control('is_text_loi_displayed', ['label' => 'Afficher le texte de loi sur les intérêts de retard de paiement']); ?>
                                <?= $this->Form->control('text_loi', ['label' => false, 'class' => 'tinymce-note']); ?>
                            </div>

                            <div class="tab-pane fade" id="remise&accompte" role="tabpanel" aria-labelledby="remise&accompte-tab">

                                <h3 class="card-title">Paramétrage des remises</h3>
                                <hr>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <label class="control-label col-md-3">Remise globale : </label>
                                        <div class="col-md-2">
                                            <?= $this->Form->control('remise_global_value', ['label' => false, 'type' => 'number', 'class' => 'remise-global form-control']) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $this->Form->control('remise_global_unity', ['label' => false, 'options' => ['%' => '%', '€' =>'€' ], 'class' => 'remise-global form-control']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="control-label col-md-3">Demander un accompte de : </label>
                                        <div class="col-md-2">
                                            <?= $this->Form->control('accompte_value', ['label' => false, 'type' => 'number', 'class' => 'accompte form-control']) ?>
                                        </div>
                                        <div class="col-md-2">
                                            <?= $this->Form->control('accompte_unity', ['label' => false, 'options' => ['%' => '%', '€' =>'€' ], 'class' => 'accompte form-control']) ?>
                                        </div>
                                    </div>      
                                    <div class="col-md-5 align-self-center">
                                        <div class="mt-1"><?= $this->Form->control('remise_line', ['type' => 'checkbox', 'class' => 'selectpicker', 'label' => 'Remise par ligne', 'checked' => $devisEntity->remise_line?$devisEntity->remise_line:false]); ?></div>
                                    </div>
                                    <div class="col-md-5 align-self-center">
                                        <div class="mt-1"><?= $this->Form->control('remise_hide_line', ['type' => 'checkbox','label' => 'Masquer la colone "Remise"', 'class' => "remise-hide-line form-control", 'checked' => isset($devisEntity->remise_hide_line) ? $devisEntity->remise_hide_line:true]); ?></div>
                                    </div>
                                </div>

                                <h3 class="card-title">Code promotionnel</h3>
                                <hr>                      

                                <div class="row">
                                    <label class="control-label col-md-2">Code : </label>
                                    <div class="col-md-4">
                                        <?= $this->Form->control('code_promotionnel', ['label' => false, "placeholder" => "Rechercher"]) ?>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="affichage" role="tabpanel" aria-labelledby="affichage-tab">

                                <div class="row row-client m-t-12">
                                    <div class="col-md-2 m-t-10">
                                        <label class=""> Catégorie tarifaire </label>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->Form->control('categorie_tarifaire', ['options' => $categorie_tarifaires, 'label' => false, 'empty' => 'Catégorie tarifaire', 'default' => 'ht']); ?>
                                    </div>
                                </div>
                                <div class="row row-client m-t-12">
                                    <div class="col-md-2 m-t-10">
                                        <label class=""> Langue </label>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->Form->control('langue_id', ['options' => $langues, 'label' => false, 'empty' => 'Langue', 'class' => 'form-control selectpicker', 'style' => 'width:100%', 'data-placeholder' => 'langue']); ?>
                                    </div>
                                </div>
                                <?php if (! $devisEntity->is_model) : ?>
                                    <div class="row row-client m-t-12">
                                        <div class="col-md-2 m-t-10">
                                            <label class=""> Type du document </label>
                                        </div>
                                        <div class="col-md-6">
                                            <?= $this->Form->control('type_doc_id', ['options' => $devis_type_docs, 'label' => false, 'empty' => 'Type du document', 'default' => 1]); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row row-client m-t-12">
                                    <div class="col-md-6">
                                        <?= $this->Form->control('display_tva', ['label' => 'Désactiver la tva', 'type' => 'checkbox']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="model_devis" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Enregistrer en tant que modèle</h5>
                </div>
                <div class="modal-body">
                    <?= $this->Form->hidden('is_model',['id' => 'is_model']); ?>
                    <?= $this->Form->hidden('new_model',['id' => 'new_model', 'value' => $devisEntity->is_model && $id ? 0:1]); ?>
                    <?= $this->Form->control('model_name',['label' => 'Nom du modele']); ?>
                    <?= $this->Form->control('modele_devis_categories_id', ['label' => 'Catégorie','options' => $modelDevisCategorie]); ?>
                    <?= $this->Form->control('modele_devis_sous_categories_id', ['label' => 'Sous catégorie', 'options' => [], 'required' => false]); ?>
                    <?= $this->Form->hidden('modele_devis_sous_categories_id', ['id' => 'sCatId', 'name' => 'sCatId']); ?>
                           

                    <?php if ($devisEntity->is_model) : ?>
                        <?= $this->Form->control('type_doc_id', ['options' => $devis_type_docs, 'label' => 'Type du document', 'empty' => 'Type du document', 'default' => 1]); ?>
                    <?php endif; ?>
                    <div class="form-group <?= $devisEntity->is_model? "hide" : "" ?>">
                        <label>Paramètres de préférences du document </label>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="preference1" name="parametre_preference" value="1">
                            <label class="custom-control-label" for="preference1">Conserver les paramètres par défaut du document (préférences de paiement, acomptes...)</label>
                        </div>

                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="preference2" value="0" name="parametre_preference" checked>
                            <label class="custom-control-label" for="preference2">Conserver les paramètres généraux </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-rounded btn-inverse annuler_modele">Annuler</a>
                    <button type="submit" class="btn btn-primary model_submit">Enregistrer en modéle</button>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var modelDevisSousCategorie = <?php echo json_encode($modelDevisSousCategorie); ?>;
</script>

<?= $this->form->end() ?>
