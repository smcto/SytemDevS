<!-- MODAL CONTACT -->
<div class="modal fade" id="modifier_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($client, ['url' => ['controller' => 'Ventes', 'action' => 'addContacts', $client->id]]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Contacts associés</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="row-fluid">
                        <button type="button" class="btn btn-primary add-data float-right mt-2 mb-4">Ajouter un contact</button>

                        <table class="table mt-2 block-client-contacts">
                            <thead>
                                <tr>
                                    <th>Prénom (*)</th>
                                    <th>Nom (*)</th>
                                    <th>Fonction </th>
                                    <th>Email (*)</th>
                                    <th>Téléphone Portable </th>
                                    <th>Téléphone Fixe</th>
                                    <th>Type</th>
                                </tr>
                            </thead>

                            <tbody class="default-data">
                                <?php if ($client->client_contacts): ?>
                                    <?php foreach ($client->client_contacts as $key => $client_contact): ?>
                                        <?php if (!$client_contact->get('IsInfosEmpty')):?>
                                            <tr>
                                                <td class="hide"><?= $this->Form->hidden("client_contacts.$key.id", ['input-name' => 'id', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.prenom", ['required', 'input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.nom", ['required', 'input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                                <td><a href="javascript:void(0);" data-key="<?= $key ?>" data-href="<?= $this->Url->build(['controller' => 'AjaxClients', 'action' => 'deleteContact', $client_contact->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
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
                                    <td><?= $this->Form->control("client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
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
                                    <td><?= $this->Form->control("client_contacts.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>