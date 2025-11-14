<div class="row-fluid clearfix">

    <?php if ($accessoires->isEmpty() == true): ?>
        <p class="mb-4">Aucun accessoire attribué à la gamme choisie</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="30%">Nom</th>
                    <th width="30%">Déclinaison</th>
                    <th width="30%">Quantité</th>
                </tr>
            </thead>
            <tbody>

                <?php $i = 0 ?>
                <?php foreach ($accessoires as $kAccessory => $accessoire): ?>
                    <tr class="bg-light tr-container-checkbox">
                        <td> <?= $this->Form->control('checked_accessories.'.$accessoire->id, ['type' => 'checkbox' ,'label' => $accessoire->nom, 'data-target' => 'accessory-'.$kAccessory]); ?> </td>
                        <td colspan="2"></td>
                    </tr>
                    
                        <?php foreach ($accessoire->sous_accessoires as $key => $sous_accessoires): ?>
                            
                            <tr class="bg-white accessory-inner d-none" id="<?= 'accessory-'.$kAccessory ?>">
                                <td></td>
                                <td><?= $sous_accessoires->name ?></td>
                                <td>
                                    <?php $borneAccessoire = $bornesAccessoires->firstMatch(['sous_accessoire_id' => $sous_accessoires->id, 'accessoire_id' => $sous_accessoires->accessoire_id]); ?>
                                    <?= $this->Form->control('bornes_accessoires.'.$i.'.id', ['type' => 'hidden', 'value' => @$borneAccessoire->id, 'label' => false]); ?>
                                    <?= $this->Form->control('bornes_accessoires.'.$i.'.sous_accessoire_id', ['type' => 'hidden', 'value' => $sous_accessoires->id, 'label' => false]); ?>
                                    <?= $this->Form->control('bornes_accessoires.'.$i.'.accessoire_id', ['type' => 'hidden', 'value' => $sous_accessoires->accessoire_id, 'label' => false]); ?>
                                    <?= $this->Form->control('bornes_accessoires.'.$i.'.qty', ['label' => false, 'value' => @$borneAccessoire->qty]); ?>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php endforeach ?>

                        
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif ?>

</div>

