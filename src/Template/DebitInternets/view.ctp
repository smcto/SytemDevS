<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitInternet $debitInternet
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Debit Internet'), ['action' => 'edit', $debitInternet->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Debit Internet'), ['action' => 'delete', $debitInternet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $debitInternet->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Debit Internets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Debit Internet'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="debitInternets view large-9 medium-8 columns content">
    <h3><?= h($debitInternet->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Valeur') ?></th>
            <td><?= h($debitInternet->valeur) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Information') ?></th>
            <td><?= h($debitInternet->information) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($debitInternet->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($debitInternet->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($debitInternet->modified) ?></td>
        </tr>
    </table>
</div>
