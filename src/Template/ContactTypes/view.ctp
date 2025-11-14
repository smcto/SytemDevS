<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactType $contactType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contact Type'), ['action' => 'edit', $contactType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contact Type'), ['action' => 'delete', $contactType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contactType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contact Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contact Type'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contactTypes view large-9 medium-8 columns content">
    <h3><?= h($contactType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($contactType->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contactType->id) ?></td>
        </tr>
    </table>
</div>
