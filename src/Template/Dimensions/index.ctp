<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dimension[]|\Cake\Collection\CollectionInterface $dimensions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Dimension'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dimensions index large-9 medium-8 columns content">
    <h3><?= __('Dimensions') ?></h3>
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
            <?php foreach ($dimensions as $dimension): ?>
            <tr>
                <td><?= $this->Number->format($dimension->id) ?></td>
                <td><?= h($dimension->dimension) ?></td>
                <td><?= h($dimension->poids) ?></td>
                <td><?= h($dimension->created) ?></td>
                <td><?= h($dimension->modified) ?></td>
                <td><?= $dimension->has('model_borne') ? $this->Html->link($dimension->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $dimension->model_borne->id]) : '' ?></td>
                <td><?= $dimension->has('party') ? $this->Html->link($dimension->party->id, ['controller' => 'Parties', 'action' => 'view', $dimension->party->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $dimension->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dimension->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dimension->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
