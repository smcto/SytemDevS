<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesAntenne[]|\Cake\Collection\CollectionInterface $devisFacturesAntennes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New DevisFactures Antenne'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesAntennes index large-9 medium-8 columns content">
    <h3><?= __('DevisFactures Antennes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('invoice_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('antenne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($devisFacturesAntennes as $devisFacturesAntenne): ?>
            <tr>
                <td><?= $this->Number->format($devisFacturesAntenne->id) ?></td>
                <td><?= $devisFacturesAntenne->has('invoice') ? $this->Html->link($devisFacturesAntenne->invoice->id, ['controller' => 'DevisFactures', 'action' => 'view', $devisFacturesAntenne->invoice->id]) : '' ?></td>
                <td><?= $devisFacturesAntenne->has('antenne') ? $this->Html->link($devisFacturesAntenne->antenne->ville_principale, ['controller' => 'Antennes', 'action' => 'view', $devisFacturesAntenne->antenne->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $devisFacturesAntenne->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $devisFacturesAntenne->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $devisFacturesAntenne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesAntenne->id)]) ?>
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
