<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Party $party
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Party'), ['action' => 'edit', $party->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Party'), ['action' => 'delete', $party->id], ['confirm' => __('Are you sure you want to delete # {0}?', $party->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Parties'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="parties view large-9 medium-8 columns content">
    <h3><?= h($party->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($party->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($party->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($party->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($party->modified) ?></td>
        </tr>
    </table>
</div>
