<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Adress $adress
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Adress'), ['action' => 'edit', $adress->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Adress'), ['action' => 'delete', $adress->id], ['confirm' => __('Are you sure you want to delete # {0}?', $adress->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Adresses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Adress'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="adresses view large-9 medium-8 columns content">
    <h3><?= h($adress->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Adresse') ?></th>
            <td><?= h($adress->adresse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cp') ?></th>
            <td><?= h($adress->cp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ville') ?></th>
            <td><?= h($adress->ville) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pays') ?></th>
            <td><?= h($adress->pays) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($adress->id) ?></td>
        </tr>
    </table>
</div>
