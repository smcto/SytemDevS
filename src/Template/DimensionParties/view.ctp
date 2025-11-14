<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DimensionParty $dimensionParty
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Dimension Party'), ['action' => 'edit', $dimensionParty->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dimension Party'), ['action' => 'delete', $dimensionParty->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dimensionParty->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dimension Parties'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dimension Party'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dimensionParties view large-9 medium-8 columns content">
    <h3><?= h($dimensionParty->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Dimension') ?></th>
            <td><?= h($dimensionParty->dimension) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Poids') ?></th>
            <td><?= h($dimensionParty->poids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($dimensionParty->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Borne Id') ?></th>
            <td><?= $this->Number->format($dimensionParty->model_borne_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Partie Id') ?></th>
            <td><?= $this->Number->format($dimensionParty->partie_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($dimensionParty->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($dimensionParty->modified) ?></td>
        </tr>
    </table>
</div>
