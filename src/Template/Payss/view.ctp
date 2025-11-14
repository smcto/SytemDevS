<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pays $pays
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pays'), ['action' => 'edit', $pays->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pays'), ['action' => 'delete', $pays->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pays->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payss'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pays'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payss view large-9 medium-8 columns content">
    <h3><?= h($pays->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Iso') ?></th>
            <td><?= h($pays->iso) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($pays->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nicename') ?></th>
            <td><?= h($pays->nicename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Iso3') ?></th>
            <td><?= h($pays->iso3) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name Fr') ?></th>
            <td><?= h($pays->name_fr) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pays->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numcode') ?></th>
            <td><?= $this->Number->format($pays->numcode) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phonecode') ?></th>
            <td><?= $this->Number->format($pays->phonecode) ?></td>
        </tr>
    </table>
</div>
