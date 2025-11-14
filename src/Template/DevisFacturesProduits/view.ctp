<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesProduit $devisFacturesProduit
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit DevisFactures Produit'), ['action' => 'edit', $devisFacturesProduit->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete DevisFactures Produit'), ['action' => 'delete', $devisFacturesProduit->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesProduit->id)]) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures Produits'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New DevisFactures Produit'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Catalog Unites'), ['controller' => 'CatalogUnites', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Catalog Unite'), ['controller' => 'CatalogUnites', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Factures'), ['controller' => 'DevisFactures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Catalog Produits'), ['controller' => 'CatalogProduits', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Catalog Produit'), ['controller' => 'CatalogProduits', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="devisFacturesProduits view large-9 medium-8 columns content">
    <h3><?= h($devisFacturesProduit->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Reference') ?></th>
            <td><?= h($devisFacturesProduit->reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Catalog Unite') ?></th>
            <td><?= $devisFacturesProduit->has('catalog_unite') ? $this->Html->link($devisFacturesProduit->catalog_unite->nom, ['controller' => 'CatalogUnites', 'action' => 'view', $devisFacturesProduit->catalog_unite->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remise Unity') ?></th>
            <td><?= h($devisFacturesProduit->remise_unity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom Interne') ?></th>
            <td><?= h($devisFacturesProduit->nom_interne) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom Commercial') ?></th>
            <td><?= h($devisFacturesProduit->nom_commercial) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Titre Ligne') ?></th>
            <td><?= h($devisFacturesProduit->titre_ligne) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Factures') ?></th>
            <td><?= $devisFacturesProduit->has('devisFacture') ? $this->Html->link($devisFacturesProduit->devisFacture->id, ['controller' => 'DevisFactures', 'action' => 'view', $devisFacturesProduit->devisFacture->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Catalog Produit') ?></th>
            <td><?= $devisFacturesProduit->has('catalog_produit') ? $this->Html->link($devisFacturesProduit->catalog_produit->id, ['controller' => 'CatalogProduits', 'action' => 'view', $devisFacturesProduit->catalog_produit->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Ligne') ?></th>
            <td><?= h($devisFacturesProduit->type_ligne) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Titre') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->titre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantite Usuelle') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->quantite_usuelle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Prix Reference Ht') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->prix_reference_ht) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Remise Value') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->remise_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sous Total') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->sous_total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('I Position') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->i_position) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Line Option') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->line_option) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tva') ?></th>
            <td><?= $this->Number->format($devisFacturesProduit->tva) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description Commercial') ?></h4>
        <?= $this->Text->autoParagraph(h($devisFacturesProduit->description_commercial)); ?>
    </div>
    <div class="row">
        <h4><?= __('Commentaire Ligne') ?></h4>
        <?= $this->Text->autoParagraph(h($devisFacturesProduit->commentaire_ligne)); ?>
    </div>
</div>
