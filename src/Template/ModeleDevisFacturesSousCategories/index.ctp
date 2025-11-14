<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModeleDevisFacturesSousCategory[]|\Cake\Collection\CollectionInterface $modeleDevisFacturesSousCategories
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Sous Category'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Categories'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Category'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modeleDevisFacturesSousCategories index large-9 medium-8 columns content">
    <h3><?= __('Modele DevisFactures Sous Categories') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modele_devis_factures_category_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modeleDevisFacturesSousCategories as $modeleDevisFacturesSousCategory): ?>
            <tr>
                <td><?= $this->Number->format($modeleDevisFacturesSousCategory->id) ?></td>
                <td><?= $modeleDevisFacturesSousCategory->has('modele_devis_factures_category') ? $this->Html->link($modeleDevisFacturesSousCategory->modele_devis_factures_category->name, ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'view', $modeleDevisFacturesSousCategory->modele_devis_factures_category->id]) : '' ?></td>
                <td><?= h($modeleDevisFacturesSousCategory->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $modeleDevisFacturesSousCategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $modeleDevisFacturesSousCategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $modeleDevisFacturesSousCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modeleDevisFacturesSousCategory->id)]) ?>
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
