<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeLicence $typeLicence
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Licence'), ['action' => 'edit', $typeLicence->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Licence'), ['action' => 'delete', $typeLicence->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeLicence->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Licences'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Licence'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeLicences view large-9 medium-8 columns content">
    <h3><?= h($typeLicence->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($typeLicence->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeLicence->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($typeLicence->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($typeLicence->modified) ?></td>
        </tr>
    </table>
</div>
