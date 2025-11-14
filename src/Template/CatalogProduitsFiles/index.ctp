<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CatalogProduitsFile[]|\Cake\Collection\CollectionInterface $catalogProduitsFiles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Catalog Produits File'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Catalog Produits'), ['controller' => 'CatalogProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Catalog Produit'), ['controller' => 'CatalogProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="catalogProduitsFiles index large-9 medium-8 columns content">
    <h3><?= __('Catalog Produits Files') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('catalog_produits_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_fichier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('chemin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_origine') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($catalogProduitsFiles as $catalogProduitsFile): ?>
            <tr>
                <td><?= $this->Number->format($catalogProduitsFile->id) ?></td>
                <td><?= $catalogProduitsFile->has('catalog_produit') ? $this->Html->link($catalogProduitsFile->catalog_produit->id, ['controller' => 'CatalogProduits', 'action' => 'view', $catalogProduitsFile->catalog_produit->id]) : '' ?></td>
                <td><?= h($catalogProduitsFile->nom_fichier) ?></td>
                <td><?= h($catalogProduitsFile->chemin) ?></td>
                <td><?= h($catalogProduitsFile->nom_origine) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $catalogProduitsFile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $catalogProduitsFile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $catalogProduitsFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $catalogProduitsFile->id)]) ?>
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
