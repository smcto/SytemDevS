<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OptionEvenement $optionEvenement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Option Evenement'), ['action' => 'edit', $optionEvenement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Option Evenement'), ['action' => 'delete', $optionEvenement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $optionEvenement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Option Evenements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Option Evenement'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="optionEvenements view large-9 medium-8 columns content">
    <h3><?= h($optionEvenement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($optionEvenement->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($optionEvenement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($optionEvenement->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($optionEvenement->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($optionEvenement->description)); ?>
    </div>
</div>
