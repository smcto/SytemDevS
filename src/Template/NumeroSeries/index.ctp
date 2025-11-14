<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NumeroSeries[]|\Cake\Collection\CollectionInterface $numeroSeries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Numero Series'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Lot Produits'), ['controller' => 'LotProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot Produit'), ['controller' => 'LotProduits', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="numeroSeries index large-9 medium-8 columns content">
    <h3><?= __('Numero Series') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('serial_nb') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lot_produit_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('borne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($numeroSeries as $numeroSeries): ?>
            <tr>
                <td><?= $this->Number->format($numeroSeries->id) ?></td>
                <td><?= h($numeroSeries->serial_nb) ?></td>
                <td><?= $numeroSeries->has('lot_produit') ? $this->Html->link($numeroSeries->lot_produit->id, ['controller' => 'LotProduits', 'action' => 'view', $numeroSeries->lot_produit->id]) : '' ?></td>
                <td><?= $numeroSeries->has('borne') ? $this->Html->link($numeroSeries->borne->id, ['controller' => 'Bornes', 'action' => 'view', $numeroSeries->borne->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $numeroSeries->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $numeroSeries->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $numeroSeries->id], ['confirm' => __('Are you sure you want to delete # {0}?', $numeroSeries->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
