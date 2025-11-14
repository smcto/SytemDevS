<option>Sélectionner</option>
<?php if ($modelBornes->count() > 0): ?>
    <?php foreach ($modelBornes as $id => $nom): ?>
        <option value="<?= $id ?>"><?= $nom ?></option>
    <?php endforeach ?>
<?php endif ?>