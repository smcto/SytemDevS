<option>Sélectionner</option>
<?php if ($clientContacts->count() > 0): ?>
    <?php foreach ($clientContacts as $key => $clientContact): ?>
        <option value="<?= $clientContact->id ?>"><?= $clientContact->nom ?></option>
    <?php endforeach ?>
<?php endif ?>