<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PipeEtape $pipeEtape
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pipe Etape'), ['action' => 'edit', $pipeEtape->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pipe Etape'), ['action' => 'delete', $pipeEtape->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pipeEtape->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pipe Etapes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pipe Etape'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pipes'), ['controller' => 'Pipes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pipe'), ['controller' => 'Pipes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Evenement Pipe Etapes'), ['controller' => 'EvenementPipeEtapes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement Pipe Etape'), ['controller' => 'EvenementPipeEtapes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pipeEtapes view large-9 medium-8 columns content">
    <h3><?= h($pipeEtape->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($pipeEtape->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pipe') ?></th>
            <td><?= $pipeEtape->has('pipe') ? $this->Html->link($pipeEtape->pipe->id, ['controller' => 'Pipes', 'action' => 'view', $pipeEtape->pipe->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pipeEtape->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ordre') ?></th>
            <td><?= $this->Number->format($pipeEtape->ordre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($pipeEtape->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($pipeEtape->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Evenement Pipe Etapes') ?></h4>
        <?php if (!empty($pipeEtape->evenement_pipe_etapes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Pipe Etape Id') ?></th>
                <th scope="col"><?= __('Evenement Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($pipeEtape->evenement_pipe_etapes as $evenementPipeEtapes): ?>
            <tr>
                <td><?= h($evenementPipeEtapes->id) ?></td>
                <td><?= h($evenementPipeEtapes->pipe_etape_id) ?></td>
                <td><?= h($evenementPipeEtapes->evenement_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EvenementPipeEtapes', 'action' => 'view', $evenementPipeEtapes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EvenementPipeEtapes', 'action' => 'edit', $evenementPipeEtapes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EvenementPipeEtapes', 'action' => 'delete', $evenementPipeEtapes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evenementPipeEtapes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
