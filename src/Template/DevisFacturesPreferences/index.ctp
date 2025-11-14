<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesPreference[]|\Cake\Collection\CollectionInterface $devisFacturesPreferences
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New DevisFactures Preference'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Adresses'), ['controller' => 'Adresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Adress'), ['controller' => 'Adresses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesPreferences index large-9 medium-8 columns content">
    <h3><?= __('DevisFactures Preferences') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('delai_reglements') ?></th>
                <th scope="col"><?= $this->Paginator->sort('info_bancaire_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accompte_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accompte_unity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_text_loi_displayed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('adress_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devisFacturesPreferences as $devisFacturesPreference): ?>
            <tr>
                <td><?= $this->Number->format($devisFacturesPreference->id) ?></td>
                <td><?= h($devisFacturesPreference->delai_reglements) ?></td>
                <td><?= $this->Number->format($devisFacturesPreference->info_bancaire_id) ?></td>
                <td><?= $this->Number->format($devisFacturesPreference->accompte_value) ?></td>
                <td><?= h($devisFacturesPreference->accompte_unity) ?></td>
                <td><?= h($devisFacturesPreference->is_text_loi_displayed) ?></td>
                <td><?= $devisFacturesPreference->has('adress') ? $this->Html->link($devisFacturesPreference->adress->adresse, ['controller' => 'Adresses', 'action' => 'view', $devisFacturesPreference->adress->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $devisFacturesPreference->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $devisFacturesPreference->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $devisFacturesPreference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesPreference->id)]) ?>
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
