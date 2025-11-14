<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DimensionParty[]|\Cake\Collection\CollectionInterface $dimensionParties
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Dimension Party'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dimensionParties index large-9 medium-8 columns content">
    <h3><?= __('Dimension Parties') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dimension') ?></th>
                <th scope="col"><?= $this->Paginator->sort('poids') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model_borne_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('partie_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dimensionParties as $dimensionParty): ?>
            <tr>
                <td><?= $this->Number->format($dimensionParty->id) ?></td>
                <td><?= h($dimensionParty->dimension) ?></td>
                <td><?= h($dimensionParty->poids) ?></td>
                <td><?= h($dimensionParty->created) ?></td>
                <td><?= h($dimensionParty->modified) ?></td>
                <td><?= $this->Number->format($dimensionParty->model_borne_id) ?></td>
                <td><?= $this->Number->format($dimensionParty->partie_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $dimensionParty->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dimensionParty->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dimensionParty->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
