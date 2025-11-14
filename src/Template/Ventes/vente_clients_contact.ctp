
<div class="clearfix">
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
            <?php $clientContacts = $clientEntity->client_contacts ?? []; ?>
                <?php foreach ($clientContacts as $key => $client_contact): ?>
                    <?php /*debug($client_contact->prenom);*/ ?>
                    <?php if (!$client_contact->get('IsInfosEmpty')): ?>
                        <tr <?= $client_contact->prenom ?>>
                            <td class="d-none"><?= $this->Form->hidden("client.client_contacts.$key.id", ['default' => $client_contact->id, 'input-name' => 'id', 'label' => false,]); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.prenom", ['value' => $client_contact->prenom, 'required', 'input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.nom", ['value' => $client_contact->nom, 'required', 'input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.position", ['value' => $client_contact->position, 'input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.email", ['value' => $client_contact->email, 'input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.tel", ['value' => $client_contact->tel, 'input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.telephone_2", ['value' => $client_contact->telephone_2, 'input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                            <td><?= $this->Form->control("client.client_contacts.$key.contact_type_id", ['value' => $client_contact->contact_type_id, 'options' => $contactTypes ?? [], 'input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                            <td><?= $this->Form->hidden("client.client_contacts.$key.is_from_crea", ['value' => $client_contact->is_from_crea, 'input-name' => 'is_from_crea', 'label' => false, 'id' => 'is_from_crea']); ?></td>
                            <td><?= $this->Form->hidden("client.client_contacts.$key.is_from_livraison", ['value' => $client_contact->is_from_livraison, 'input-name' => 'is_from_livraison', 'label' => false, 'id' => 'is_from_crea']); ?></td>
                            <!-- CF. Brief Projet -->
                            <td class="d-none"><?= $this->Form->control("client.client_contacts.$key.is_selected", ['input-name' => 'is_selected', 'label' => false, 'id' => 'is_selected', 'type' => 'checkbox']); ?></td>
                            <td><a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxVentes', 'action' => 'deleteContact', (int) $client_contact->id, (int) $key]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>

            <?php $init = isset($key) ? $key+1 : 0 ?>

            <tr>
                <td><?= $this->Form->control("client.client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                <td><?= $this->Form->control("client.client_contacts.$init.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
            </tr>
        </tbody>

        <tfoot>
            <tr class="d-none clone added-tr">
                <td><?= $this->Form->control('client.client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                <td><?= $this->Form->control('client.client_contacts.contact_type_id', ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
            </tr>
        </tfoot>
        
    </table>

</div>