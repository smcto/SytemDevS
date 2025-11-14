<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModeleDevisFacturesCategory[]|\Cake\Collection\CollectionInterface $modeleDevisFacturesCategories
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Category'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Sous Categories'), ['controller' => 'ModeleDevisFacturesSousCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Sous Category'), ['controller' => 'ModeleDevisFacturesSousCategories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modeleDevisFacturesCategories index large-9 medium-8 columns content">
    <h3><?= __('Modele DevisFactures Categories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modeleDevisFacturesCategories as $modeleDevisFacturesCategory): ?>
            <tr>
                <td><?= $this->Number->format($modeleDevisFacturesCategory->id) ?></td>
                <td><?= h($modeleDevisFacturesCategory->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $modeleDevisFacturesCategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $modeleDevisFacturesCategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $modeleDevisFacturesCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modeleDevisFacturesCategory->id)]) ?>
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
