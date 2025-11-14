<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipement $equipement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Equipement'), ['action' => 'edit', $equipement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Equipement'), ['action' => 'delete', $equipement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Equipements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Type Equipements'), ['controller' => 'TypeEquipements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Equipement'), ['controller' => 'TypeEquipements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="equipements view large-9 medium-8 columns content">
    <h3><?= h($equipement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type Equipement') ?></th>
            <td><?= $equipement->has('type_equipement') ? $this->Html->link($equipement->type_equipement->id, ['controller' => 'TypeEquipements', 'action' => 'view', $equipement->type_equipement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Valeur') ?></th>
            <td><?= h($equipement->valeur) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($equipement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($equipement->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($equipement->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Filtrable') ?></th>
            <td><?= $equipement->is_filtrable ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Commentaire') ?></h4>
        <?= $this->Text->autoParagraph(h($equipement->commentaire)); ?>
    </div>
</div>
