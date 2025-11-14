<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeAnimation[]|\Cake\Collection\CollectionInterface $typeAnimations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Type Animation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="typeAnimations index large-9 medium-8 columns content">
    <h3><?= __('Type Animations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($typeAnimations as $typeAnimation): ?>
            <tr>
                <td><?= $this->Number->format($typeAnimation->id) ?></td>
                <td><?= h($typeAnimation->nom) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $typeAnimation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $typeAnimation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $typeAnimation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeAnimation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
