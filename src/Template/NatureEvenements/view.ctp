<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NatureEvenement $natureEvenement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Nature Evenement'), ['action' => 'edit', $natureEvenement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Nature Evenement'), ['action' => 'delete', $natureEvenement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $natureEvenement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Nature Evenements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Nature Evenement'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="natureEvenements view large-9 medium-8 columns content">
    <h3><?= h($natureEvenement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($natureEvenement->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Options') ?></th>
            <td><?= h($natureEvenement->options) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($natureEvenement->id) ?></td>
        </tr>
    </table>
</div>
