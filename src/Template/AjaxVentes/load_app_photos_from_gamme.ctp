<option>Sélectionner</option>
<?php if ($typeEquipements->count() > 0): ?>
    <?php foreach ($typeEquipements as $id => $nom): ?>
        <option value="<?= $id ?>"><?= $nom ?></option>
    <?php endforeach ?>
<?php endif ?>