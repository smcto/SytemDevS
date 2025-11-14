<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesProduit[]|\Cake\Collection\CollectionInterface $devisFacturesProduits
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New DevisFactures Produit'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Unites'), ['controller' => 'CatalogUnites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Unite'), ['controller' => 'CatalogUnites', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devis Facture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Produits'), ['controller' => 'CatalogProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Produit'), ['controller' => 'CatalogProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesProduits index large-9 medium-8 columns content">
    <h3><?= __('DevisFactures Produits') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantite_usuelle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('prix_reference_ht') ?></th>
                <th scope="col"><?= $this->Paginator->sort('catalog_unites_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('remise_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('remise_unity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_interne') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_commercial') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titre_ligne') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sous_total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('catalog_produit_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type_ligne') ?></th>
                <th scope="col"><?= $this->Paginator->sort('i_position') ?></th>
                <th scope="col"><?= $this->Paginator->sort('line_option') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tva') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devisFacturesProduits as $devisFacturesProduit): ?>
            <tr>
                <td><?= $this->Number->format($devisFacturesProduit->id) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->titre) ?></td>
                <td><?= h($devisFacturesProduit->reference) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->quantite_usuelle) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->prix_reference_ht) ?></td>
                <td><?= $devisFacturesProduit->has('catalog_unite') ? $this->Html->link($devisFacturesProduit->catalog_unite->nom, ['controller' => 'CatalogUnites', 'action' => 'view', $devisFacturesProduit->catalog_unite->id]) : '' ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->remise_value) ?></td>
                <td><?= h($devisFacturesProduit->remise_unity) ?></td>
                <td><?= h($devisFacturesProduit->nom_interne) ?></td>
                <td><?= h($devisFacturesProduit->nom_commercial) ?></td>
                <td><?= h($devisFacturesProduit->titre_ligne) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->sous_total) ?></td>
                <td><?= $devisFacturesProduit->has('invoice') ? $this->Html->link($devisFacturesProduit->invoice->id, ['controller' => 'DevisFactures', 'action' => 'view', $devisFacturesProduit->invoice->id]) : '' ?></td>
                <td><?= $devisFacturesProduit->has('catalog_produit') ? $this->Html->link($devisFacturesProduit->catalog_produit->id, ['controller' => 'CatalogProduits', 'action' => 'view', $devisFacturesProduit->catalog_produit->id]) : '' ?></td>
                <td><?= h($devisFacturesProduit->type_ligne) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->i_position) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->line_option) ?></td>
                <td><?= $this->Number->format($devisFacturesProduit->tva) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $devisFacturesProduit->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $devisFacturesProduit->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $devisFacturesProduit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesProduit->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
