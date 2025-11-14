<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InfosBancaire $infosBancaire
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Infos Bancaire'), ['action' => 'edit', $infosBancaire->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Infos Bancaire'), ['action' => 'delete', $infosBancaire->id], ['confirm' => __('Are you sure you want to delete # {0}?', $infosBancaire->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Infos Bancaires'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Infos Bancaire'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="infosBancaires view large-9 medium-8 columns content">
    <h3><?= h($infosBancaire->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($infosBancaire->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Adress') ?></th>
            <td><?= h($infosBancaire->adress) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bic') ?></th>
            <td><?= h($infosBancaire->bic) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iban') ?></th>
            <td><?= h($infosBancaire->iban) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($infosBancaire->id) ?></td>
        </tr>
    </table>
</div>
