<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategorieActus $categorieActus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Categorie Actus'), ['action' => 'edit', $categorieActus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Categorie Actus'), ['action' => 'delete', $categorieActus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categorieActus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Categorie Actus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Categorie Actus'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="categorieActus view large-9 medium-8 columns content">
    <h3><?= h($categorieActus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titre') ?></th>
            <td><?= h($categorieActus->titre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($categorieActus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($categorieActus->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($categorieActus->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($categorieActus->description)); ?>
    </div>
</div>
