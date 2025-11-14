<?php if (!$typeEquipementsAccessoires->isEmpty()): ?>
    <table class="table">
        <thead>
            <tr>
                <th width="1%" class="text-center"></th>
                <th width="40%">Nom</th>
                <th class="d-none">Modèle</th>
                <th class="d-none">Qté</th>
            </tr>
        </thead>
        <tbody class="table-equipm">
            <?php foreach ($typeEquipementsAccessoires as $key => $typeEquipement): ?>
                <tr equip-id="<?= $typeEquipement->id ?>">
                    <td>
                        <button type="button" class="btn btn-rounded btn-sm btn-dark add">Ajouter</button>
                    </td>
                    <td class="nom">
                        <span class="selected-product d-none"><input type="checkbox" class="kl_valeur em-checkbox equip-accessoire" value="<?= $typeEquipement->id ?>" name="valAdd[]"/></span>
                        <?= $typeEquipement->nom ?>
                    </td>
                    <td class="select-equipm d-none">
                        <?= $this->Form->control('equipements_accessoires_ventes.'.$typeEquipement->id.'.equipement_id', ['input-name' => 'equipement_id', 'label' => false, 'options' => collection($typeEquipement->equipements)->combine('id', 'valeur'), 'empty' => 'Sélectionner']); ?>
                    </td>
                    <td class="qty-equipm d-none">
                        <?= $this->Form->control('equipements_accessoires_ventes.'.$typeEquipement->id.'.qty', ['input-name' => 'qty', 'label' => false, 'placeholder' => 'quantité', 'type' => 'number', 'default' => 1]); ?>
                    </td>
                    <td class="type-equipm-id d-none">
                        <?= $this->Form->control('equipements_accessoires_ventes.'.$typeEquipement->id.'.type_equipement_id', ['input-name' => 'type_equipement_id', 'label' => false, 'type' => 'number', 'default' => $typeEquipement->id]); ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else: ?>
    Aucun type d'équipement accessoire trouvé
<?php endif ?>