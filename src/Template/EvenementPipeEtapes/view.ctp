<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EvenementPipeEtape $evenementPipeEtape
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Evenement Pipe Etape'), ['action' => 'edit', $evenementPipeEtape->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Evenement Pipe Etape'), ['action' => 'delete', $evenementPipeEtape->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evenementPipeEtape->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Evenement Pipe Etapes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement Pipe Etape'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pipe Etapes'), ['controller' => 'PipeEtapes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pipe Etape'), ['controller' => 'PipeEtapes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="evenementPipeEtapes view large-9 medium-8 columns content">
    <h3><?= h($evenementPipeEtape->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Pipe Etape') ?></th>
            <td><?= $evenementPipeEtape->has('pipe_etape') ? $this->Html->link($evenementPipeEtape->pipe_etape->id, ['controller' => 'PipeEtapes', 'action' => 'view', $evenementPipeEtape->pipe_etape->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Evenement') ?></th>
            <td><?= $evenementPipeEtape->has('evenement') ? $this->Html->link($evenementPipeEtape->evenement->id, ['controller' => 'Evenements', 'action' => 'view', $evenementPipeEtape->evenement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($evenementPipeEtape->id) ?></td>
        </tr>
    </table>
</div>
