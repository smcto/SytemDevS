<?= $this->Html->script('Clients/add.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?php
    $this->assign('title', 'Client');
    $titrePage = "Ajouter un nouveau client" ;
    if ($id) {
        $titrePage = "Modification client #$id";
    }
    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );
    
    $this->Breadcrumbs->add(
        'Clients', ['controller' => 'Clients', 'action' => 'liste']
    );

    $this->Breadcrumbs->add($titrePage);

    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
    // http://127.0.0.1/crm-selfizee/fr/factures/add
?>

<?= $this->Form->create($clientEntity) ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h3 class="pb-2 mb-3">Informations client</h3>

                <div class="row">
                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Genre</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false]) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5 client-name">Raison sociale (*)</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('nom', ['label' => false, 'required' => true]); ?>
                        </div>
                    </div>
                    <div class="col-md-6 client-lastname hide row">
                        <label class="control-label col-md-4 m-t-5">Prénom (*)</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('prenom', ['label' => false]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5 ">Enseigne</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('enseigne', ['label' => false, 'class' => 'form-control']); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Adresse</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('adresse', ['class' => 'form-control new-clients','label' => false]); ?>
                        </div>
                    </div>


                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Adresse complémentaire</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('adresse_2', ['type' => 'text', 'class' => 'form-control new-clients','label' => false]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Code postal</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('cp', ['class' => 'form-control cp', 'label' =>false, 'type' => 'number']); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row bloc-ville">
                        <label class="control-label col-md-4 m-t-5">Ville</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'type' => 'checkbox']); ?>
                            <?php if (!$clientEntity->id): ?>
                                <div class="clearfix select"><?= $this->Form->control('ville', ['default' => $clientEntity->ville ?? '', 'empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances ?? [], 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'select-ville']); ?></div>
                                <div class="clearfix input d-none"><?= $this->Form->control('ville', ['label' => false, 'disabled']); ?></div>
                            <?php else: ?>
                                <div class="clearfix select <?= $isVilleClientInVilleFrances ? '' : 'd-none' ?>"><?= $this->Form->control('ville', ['default' => $clientEntity->ville ?? '', 'empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances ?? [], 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select', 'id' => 'select-ville']); ?></div>
                                <div class="clearfix input <?= $isVilleClientInVilleFrances ? 'd-none' : '' ?>"><?= $this->Form->control('ville', ['empty' => 'Sélectionner par rapport au code postal','class' => 'selectpicker', 'label' => false,  'options' => [$clientEntity->ville => $clientEntity->ville], 'default' => $clientEntity->ville]); ?></div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Pays</label>
                        <div class="col-md-8">
                            <div class="clearfix select"><?= $this->Form->control('new_client.pays_id', ['options' => $payss, 'default' => 5, 'empty' => 'Sélectionner', 'class' => 'form-control selectpicker', 'id' => 'country', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5 client-tel">Tél entreprise</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('telephone', ['class' => 'form-control','label' => false ]); ?>
                        </div>
                    </div>
                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5 ">2ème Téléphone</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('telephone_2', ['class' => 'form-control','label' => false ]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5 client-mail">Email général</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('email', ['class' => 'form-control','label' => false ]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5">Tva Intracommunautaire</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('tva_intra_community', ['class' => 'form-control pro','label' => false]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5">Siren</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('siren', ['class' => 'form-control pro','label' => false]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5">Siret</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('siret', ['class' => 'form-control pro','label' => false]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h3 class="pb-2 mb-3">Qualification client</h3>

                <div class="row">
                    <div class="col-md-6 row">
                        <label class="control-label col-md-4 m-t-5">Type commercial *</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('type_commercial', ['options' => $type_commercials, 'class' => 'selectpicker', 'required' => true, 'empty' => 'Sélectionner', 'label' => false]) ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5">Groupes de clients</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('groupe_client_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker form-control client_id', 'data-live-search' => true, 'label' => false]); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row client-pro">
                        <label class="control-label col-md-4 m-t-5">Secteur d'activité</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites form-control', 'label' => false, 'required' => true, 'style' => 'width:100%']); ?>
                        </div>
                    </div>

                    <div class="col-md-6 row">
                        <label class="control-label col-md-4">Comment a-t-il connu Selfizee ?</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Séléctionner']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                    <h3 class="pb-2 mb-3" id="contacts">Contacts associés</h3>

                    <div class="row-fluid">
                        <button type="button" class="btn btn-primary add-data float-right mt-2 mb-4">Ajouter un contact</button>

                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th>Prénom (*)</th>
                                    <th>Nom (*)</th>
                                    <th>Fonction </th>
                                    <th>Email (*)</th>
                                    <th>Téléphone Portable</th>
                                    <th>Téléphone Fixe</th>
                                    <th>Type</th>
                                </tr>
                            </thead>

                            <tbody class="default-data">
                                <?php if ($clientEntity->client_contacts): ?>
                                    <?php foreach ($clientEntity->client_contacts as $key => $client_contact): ?>
                                        <?php if (!$client_contact->get('IsInfosEmpty')): ?>
                                            <tr>
                                                <td class="d-none"><?= $this->Form->hidden("client_contacts.$key.id", ['input-name' => 'id', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.prenom", ['required', 'input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.nom", ['required', 'input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                                <td><a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxClients', 'action' => 'deleteContact', $client_contact->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>

                                <?php $init = isset($key) ? $key+1 : 0 ?>

                                <tr>
                                    <td><?= $this->Form->control("client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.contact_type_id', ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="d-none clone added-tr">
                                    <td><?= $this->Form->control('client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.contact_type_id', ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                            
                        </table>

                    </div>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?= $this->Form->button(__('Save'), ['class' => 'btn btn-rounded btn-success','escape' => false]) ?>
    <?= $this->Html->link(__('Cancel'), ['action' => 'liste'], ['class' => 'btn btn-rounded btn-inverse']) ?>
</div>

<?= $this->Form->end() ?>
