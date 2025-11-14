<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NatureEvenement[]|\Cake\Collection\CollectionInterface $natureEvenements
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Nature Evenement'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="natureEvenements index large-9 medium-8 columns content">
    <h3><?= __('Nature Evenements') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('options') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($natureEvenements as $natureEvenement): ?>
            <tr>
                <td><?= $this->Number->format($natureEvenement->id) ?></td>
                <td><?= h($natureEvenement->type) ?></td>
                <td><?= h($natureEvenement->options) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $natureEvenement->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $natureEvenement->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $natureEvenement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $natureEvenement->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
