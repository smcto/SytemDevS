<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogSousSousCategory $catalogSousSousCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Catalog Sous Sous Category'), ['action' => 'edit', $catalogSousSousCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Catalog Sous Sous Category'), ['action' => 'delete', $catalogSousSousCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $catalogSousSousCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Catalog Sous Sous Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Catalog Sous Sous Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Catalog Sous Categories'), ['controller' => 'CatalogSousCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Catalog Sous Category'), ['controller' => 'CatalogSousCategories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="catalogSousSousCategories view large-9 medium-8 columns content">
    <h3><?= h($catalogSousSousCategory->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Catalog Sous Category') ?></th>
            <td><?= $catalogSousSousCategory->has('catalog_sous_category') ? $this->Html->link($catalogSousSousCategory->catalog_sous_category->nom, ['controller' => 'CatalogSousCategories', 'action' => 'view', $catalogSousSousCategory->catalog_sous_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($catalogSousSousCategory->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($catalogSousSousCategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($catalogSousSousCategory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($catalogSousSousCategory->modified) ?></td>
        </tr>
    </table>
</div>
