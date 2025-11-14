<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduitsFile $catalogProduitsFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Catalog Produits Files'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Produits'), ['controller' => 'CatalogProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Produit'), ['controller' => 'CatalogProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="catalogProduitsFiles form large-9 medium-8 columns content">
    <?= $this->Form->create($catalogProduitsFile) ?>
    <fieldset>
        <legend><?= __('Add Catalog Produits File') ?></legend>
        <?php
            echo $this->Form->control('catalog_produits_id', ['options' => $catalogProduits]);
            echo $this->Form->control('nom_fichier');
            echo $this->Form->control('chemin');
            echo $this->Form->control('nom_origine');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
