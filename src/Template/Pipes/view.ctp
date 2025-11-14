<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pipe $pipe
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pipe'), ['action' => 'edit', $pipe->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pipe'), ['action' => 'delete', $pipe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pipe->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pipes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pipe'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Pipe Etapes'), ['controller' => 'PipeEtapes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pipe Etape'), ['controller' => 'PipeEtapes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pipes view large-9 medium-8 columns content">
    <h3><?= h($pipe->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($pipe->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pipe->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($pipe->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($pipe->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Pipe Etapes') ?></h4>
        <?php if (!empty($pipe->pipe_etapes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nom') ?></th>
                <th scope="col"><?= __('Ordre') ?></th>
                <th scope="col"><?= __('Pipe Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($pipe->pipe_etapes as $pipeEtapes): ?>
            <tr>
                <td><?= h($pipeEtapes->id) ?></td>
                <td><?= h($pipeEtapes->nom) ?></td>
                <td><?= h($pipeEtapes->ordre) ?></td>
                <td><?= h($pipeEtapes->pipe_id) ?></td>
                <td><?= h($pipeEtapes->created) ?></td>
                <td><?= h($pipeEtapes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'PipeEtapes', 'action' => 'view', $pipeEtapes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'PipeEtapes', 'action' => 'edit', $pipeEtapes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'PipeEtapes', 'action' => 'delete', $pipeEtapes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pipeEtapes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
