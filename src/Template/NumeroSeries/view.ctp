<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NumeroSeries $numeroSeries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Numero Series'), ['action' => 'edit', $numeroSeries->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Numero Series'), ['action' => 'delete', $numeroSeries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $numeroSeries->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Numero Series'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Numero Series'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Lot Produits'), ['controller' => 'LotProduits', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lot Produit'), ['controller' => 'LotProduits', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="numeroSeries view large-9 medium-8 columns content">
    <h3><?= h($numeroSeries->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Serial Nb') ?></th>
            <td><?= h($numeroSeries->serial_nb) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lot Produit') ?></th>
            <td><?= $numeroSeries->has('lot_produit') ? $this->Html->link($numeroSeries->lot_produit->id, ['controller' => 'LotProduits', 'action' => 'view', $numeroSeries->lot_produit->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Borne') ?></th>
            <td><?= $numeroSeries->has('borne') ? $this->Html->link($numeroSeries->borne->id, ['controller' => 'Bornes', 'action' => 'view', $numeroSeries->borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($numeroSeries->id) ?></td>
        </tr>
    </table>
</div>
