<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MoyenReglement[]|\Cake\Collection\CollectionInterface $moyenReglements
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Moyen Reglement'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reglements'), ['controller' => 'Reglements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reglement'), ['controller' => 'Reglements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="moyenReglements index large-9 medium-8 columns content">
    <h3><?= __('Moyen Reglements') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($moyenReglements as $moyenReglement): ?>
            <tr>
                <td><?= $this->Number->format($moyenReglement->id) ?></td>
                <td><?= h($moyenReglement->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $moyenReglement->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $moyenReglement->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $moyenReglement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $moyenReglement->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
