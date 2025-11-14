<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dimension $dimension
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Dimension'), ['action' => 'edit', $dimension->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dimension'), ['action' => 'delete', $dimension->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dimension->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dimensions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dimension'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dimensions view large-9 medium-8 columns content">
    <h3><?= h($dimension->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Dimension') ?></th>
            <td><?= h($dimension->dimension) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Poids') ?></th>
            <td><?= h($dimension->poids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Borne') ?></th>
            <td><?= $dimension->has('model_borne') ? $this->Html->link($dimension->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $dimension->model_borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party') ?></th>
            <td><?= $dimension->has('party') ? $this->Html->link($dimension->party->id, ['controller' => 'Parties', 'action' => 'view', $dimension->party->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($dimension->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($dimension->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($dimension->modified) ?></td>
        </tr>
    </table>
</div>
