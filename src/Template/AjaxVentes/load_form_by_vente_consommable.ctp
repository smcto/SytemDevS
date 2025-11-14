<?php $devisProduitsAccessoires = collection($ventesConsommable->ventes_has_devis_produits)->match(['devis_produit.catalog_produit.catalog_sous_categories_id' => 2 /*Accessoires*/]) ?>
<h3 class="mb-4 border-bottom border-secondary">Accessoires</h3>
<table class="table">
    <thead>
        <tr>
            <th width="20%">Nom</th>
            <th width="40%">Quantité</th>
            <th width="40%">Quantité expédiée</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($ventesConsommable->ventes_has_devis_produits as $key => $ventesHasDevisProduit): ?>
            <?php if ($ventesHasDevisProduit->devis_produit->catalog_produit->_matchingData['CatalogProduitsHasCategories']['catalog_sous_category_id'] == 2): ?>

                <tr>
                    <td><?= $ventesHasDevisProduit->devis_produit->reference ?></td>
                    <td><?= $ventesHasDevisProduit->qty ?></td>
                    <td><?= $this->Form->control('ventes_has_devis_produits.'.$ventesHasDevisProduit->id.'.qty_sent', ['default' => $ventesHasDevisProduit->qty_sent, 'max' => $ventesHasDevisProduit->qty, 'type' => 'number', 'label' => false]); ?></td>
                    <td><?= $this->Form->hidden('ventes_has_devis_produits.'.$ventesHasDevisProduit->id.'.id', ['value' => $ventesHasDevisProduit->id, 'label' => false]); ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>                        


<h3 class="mb-4 border-bottom border-secondary">Consommables</h3>

<table class="table">
    <thead>
        <tr>
            <th width="20%">Nom</th>
            <th width="40%">Quantité</th>
            <th width="40%">Quantité expédiée</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($ventesConsommable->ventes_has_devis_produits as $key => $ventesHasDevisProduit): ?>
            <?php if ($ventesHasDevisProduit->devis_produit->catalog_produit->_matchingData['CatalogProduitsHasCategories']['catalog_sous_category_id'] == 16): ?>
                <tr>
                    <td><?= $ventesHasDevisProduit->devis_produit->reference ?></td>
                    <td><?= $ventesHasDevisProduit->qty ?></td>
                    <td><?= $this->Form->control('ventes_has_devis_produits.'.$ventesHasDevisProduit->id.'.qty_sent', ['default' => $ventesHasDevisProduit->qty_sent, 'max' => $ventesHasDevisProduit->qty, 'type' => 'number', 'label' => false]); ?></td>
                    <td><?= $this->Form->hidden('ventes_has_devis_produits.'.$ventesHasDevisProduit->id.'.id', ['value' => $ventesHasDevisProduit->id, 'label' => false]); ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>
