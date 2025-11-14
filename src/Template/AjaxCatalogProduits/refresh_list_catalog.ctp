<div class="table-responsive mt-1">
    <table class="table">
        <thead class="bg-light">
            <tr>
                <th scope="col" class="d-none"></th>
                <th width="1%"></th>
                <th scope="col">Nom interne</th>
                <th scope="col">PU HT </th>
                <th scope="col">PU TTC </th>
                <th scope="col">Code Comptable</th>
            </tr>
        </thead>
        <tbody  class="table-catalog">
        <?php if(count($catalogProduits)) : ?>
            <?php foreach ($catalogProduits as $catalogProduit): ?>
                <tr product-id="<?= $catalogProduit->id ?>">
                    <td class="d-none selected-product">
                        <input type="checkbox" class="kl_valeur em-checkbox catalog-produit" value="<?= $catalogProduit->id ?>" name="valAdd[]"/>
                    </td>
                    <td><button type="button" class="btn btn-rounded btn-sm btn-dark add">Ajouter</button></td>
                    <td class="nom_interne"><?= $catalogProduit->nom_interne ?></td>
                    <td class="prix_reference_ht"><?= $this->Number->currency($catalogProduit->prix_reference_ht) ?></td>
                    <td class="prix_reference_ttc"><?= $this->Number->currency($catalogProduit->prix_reference_ht * 1.2) ?></td>
                    <td class="code_comptable"><?= $catalogProduit->code_comptable ?></td>
                    <!--td>
                        <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['controller' => 'CatalogProduits', 'action' => 'add', $catalogProduit->id], ['escape'=>false,'target'=> "_blank"]) ?>
                    </td-->
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="5" class="text-center first-tr py-5 dynamic-colspan">Aucun résultat</td></tr>
        <?php endif ?>
        </tbody>
    </table>
</div>