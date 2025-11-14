<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesProduit $devisFactureProduit
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $devisFactureProduit->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $devisFactureProduit->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List DevisFactures Produits'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Unites'), ['controller' => 'CatalogUnites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Unite'), ['controller' => 'CatalogUnites', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devis Facture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Produits'), ['controller' => 'CatalogProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Produit'), ['controller' => 'CatalogProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFactureProduits form large-9 medium-8 columns content">
    <?= $this->Form->create($devisFactureProduit) ?>
    <fieldset>
        <legend><?= __('Edit DevisFactures Produit') ?></legend>
        <?php
            echo $this->Form->control('titre');
            echo $this->Form->control('reference');
            echo $this->Form->control('quantite_usuelle');
            echo $this->Form->control('prix_reference_ht');
            echo $this->Form->control('catalog_unites_id', ['options' => $catalogUnites, 'empty' => true]);
            echo $this->Form->control('remise_value');
            echo $this->Form->control('remise_unity');
            echo $this->Form->control('nom_interne');
            echo $this->Form->control('nom_commercial');
            echo $this->Form->control('description_commercial');
            echo $this->Form->control('commentaire_ligne');
            echo $this->Form->control('titre_ligne');
            echo $this->Form->control('sous_total');
            echo $this->Form->control('devis_facture_id', ['options' => $devisFacture, 'empty' => true]);
            echo $this->Form->control('catalog_produit_id', ['options' => $catalogProduits, 'empty' => true]);
            echo $this->Form->control('type_ligne');
            echo $this->Form->control('i_position');
            echo $this->Form->control('line_option');
            echo $this->Form->control('tva');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
