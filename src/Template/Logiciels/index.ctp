<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Logiciel[]|\Cake\Collection\CollectionInterface $logiciels
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Logiciel'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Borne Logiciels'), ['controller' => 'BorneLogiciels', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne Logiciel'), ['controller' => 'BorneLogiciels', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="logiciels index large-9 medium-8 columns content">
    <h3><?= __('Logiciels') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logiciels as $logiciel): ?>
            <tr>
                <td><?= $this->Number->format($logiciel->id) ?></td>
                <td><?= h($logiciel->nom) ?></td>
                <td><?= h($logiciel->created) ?></td>
                <td><?= h($logiciel->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $logiciel->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $logiciel->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $logiciel->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
