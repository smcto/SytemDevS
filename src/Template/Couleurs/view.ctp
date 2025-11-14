<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Couleur $couleur
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Couleur'), ['action' => 'edit', $couleur->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Couleur'), ['action' => 'delete', $couleur->id], ['confirm' => __('Are you sure you want to delete # {0}?', $couleur->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Couleurs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Couleur'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="couleurs view large-9 medium-8 columns content">
    <h3><?= h($couleur->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Couleur') ?></th>
            <td><?= h($couleur->couleur) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($couleur->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($couleur->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($couleur->modified) ?></td>
        </tr>
    </table>
</div>
