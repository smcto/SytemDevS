<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeConsommable $typeConsommable
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Consommable'), ['action' => 'edit', $typeConsommable->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Consommable'), ['action' => 'delete', $typeConsommable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeConsommable->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Consommables'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Consommable'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeConsommables view large-9 medium-8 columns content">
    <h3><?= h($typeConsommable->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($typeConsommable->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeConsommable->id) ?></td>
        </tr>
    </table>
</div>
