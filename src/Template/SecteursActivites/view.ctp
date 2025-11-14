<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SecteursActivite $secteursActivite
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Secteurs Activite'), ['action' => 'edit', $secteursActivite->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Secteurs Activite'), ['action' => 'delete', $secteursActivite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $secteursActivite->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Secteurs Activites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Secteurs Activite'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="secteursActivites view large-9 medium-8 columns content">
    <h3><?= h($secteursActivite->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($secteursActivite->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($secteursActivite->id) ?></td>
        </tr>
    </table>
</div>
