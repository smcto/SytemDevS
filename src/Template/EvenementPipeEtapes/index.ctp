<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EvenementPipeEtape[]|\Cake\Collection\CollectionInterface $evenementPipeEtapes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Evenement Pipe Etape'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pipe Etapes'), ['controller' => 'PipeEtapes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pipe Etape'), ['controller' => 'PipeEtapes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="evenementPipeEtapes index large-9 medium-8 columns content">
    <h3><?= __('Evenement Pipe Etapes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('pipe_etape_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('evenement_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($evenementPipeEtapes as $evenementPipeEtape): ?>
            <tr>
                <td><?= $this->Number->format($evenementPipeEtape->id) ?></td>
                <td><?= $evenementPipeEtape->has('pipe_etape') ? $this->Html->link($evenementPipeEtape->pipe_etape->id, ['controller' => 'PipeEtapes', 'action' => 'view', $evenementPipeEtape->pipe_etape->id]) : '' ?></td>
                <td><?= $evenementPipeEtape->has('evenement') ? $this->Html->link($evenementPipeEtape->evenement->id, ['controller' => 'Evenements', 'action' => 'view', $evenementPipeEtape->evenement->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $evenementPipeEtape->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $evenementPipeEtape->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $evenementPipeEtape->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evenementPipeEtape->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
