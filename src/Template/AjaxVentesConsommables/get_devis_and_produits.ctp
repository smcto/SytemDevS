<?= $this->Html->script('devis/view.js?time='.time()); ?>

<?php if (isset($devisEntity->devis_produits) && count($devisEntity->devis_produits) > 0): ?>
    <table class="table table-uniforme table_bloc_devis table-bordered  detail-form ">
        <thead class="bg-light">
            <tr>
                <th width="2%" ></th>
                <th width="10%" class="<?= @$colVisibilityParams->ref ? 'hide' : '' ?>">Nom (référénce)</th>
                <th width="5%" class="<?= @$colVisibilityParams->qty ? 'hide' : '' ?>">Qté</th>
            </tr>
        </thead>
        <tbody id="sortable" class="default-data">
            <?php foreach ($devisEntity->devis_produits as $key => $devisProduit) : ?>

                <?php if($devisProduit->type_ligne == 'produit') : ?>
                    <tr class="clone added-tr <?= $devisProduit->line_option?'ligne-option':'' ?>">

                        <td>
                            <?php if (isset($id)): ?>
                                <?php $venteHasDevisProduit = collection($ventesConsommable->ventes_has_devis_produits)->firstMatch(['devis_produit_id' => $devisProduit->id]) ?>
                                <?= $this->Form->control('ventes_has_devis_produits.'.$devisProduit->id.'.id', ['value' => @$venteHasDevisProduit->id, 'type' => 'hidden' ,  'label' => '']); ?>
                            <?php endif ?>
                            <?= $this->Form->control('checked_produits.'.$devisProduit->id, ['type' => 'checkbox' ,'label' => '', 'id' => 'check-item ligne-'.$devisProduit->id]); ?>
                            <?= $this->Form->control('ventes_has_devis_produits.'.$devisProduit->id.'.devis_produit_id', ['type' => 'hidden' , 'value' => $devisProduit->id, 'label' => '', 'id' => 'check-item ligne-'.$devisProduit->id ]); ?>
                        </td>

                        <?php $qty = isset($id) ? @$venteHasDevisProduit->qty :$devisProduit->quantite_usuelle  ?>
                        
                        <td class="<?= @$colVisibilityParams->ref ? 'hide' : '' ?>"><?= $devisProduit->reference ?></td> 
                        <td class="<?= @$colVisibilityParams->qty ? 'hide' : '' ?>">
                            <?= $this->Form->control('ventes_has_devis_produits.'.$devisProduit->id.'.qty', ['default' => @$qty, 'label' => '']); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                    
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="mb-4">Aucun produit trouvé</p>
<?php endif ?>