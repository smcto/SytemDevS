<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parc[]|\Cake\Collection\CollectionInterface $parcs
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Parc'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="parcs index large-9 medium-8 columns content">
    <h3><?= __('Parcs') ?></h3>
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
            <?php foreach ($parcs as $parc): ?>
            <tr>
                <td><?= $this->Number->format($parc->id) ?></td>
                <td><?= h($parc->nom) ?></td>
                <td><?= h($parc->created) ?></td>
                <td><?= h($parc->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $parc->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $parc->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $parc->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
