<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeExcel[]|\Cake\Collection\CollectionInterface $stripeExcels
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stripe Excel'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['controller' => 'StripeCsvs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['controller' => 'StripeCsvs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stripeExcels index large-9 medium-8 columns content">
    <h3><?= __('Stripe Excels') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('piece') ?></th>
                <th scope="col"><?= $this->Paginator->sort('compte') ?></th>
                <th scope="col"><?= $this->Paginator->sort('libelle') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('debit') ?></th>
                <th scope="col"><?= $this->Paginator->sort('credit') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stripe_csv_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stripeExcels as $stripeExcel): ?>
            <tr>
                <td><?= $this->Number->format($stripeExcel->id) ?></td>
                <td><?= h($stripeExcel->date) ?></td>
                <td><?= h($stripeExcel->piece) ?></td>
                <td><?= h($stripeExcel->compte) ?></td>
                <td><?= h($stripeExcel->libelle) ?></td>
                <td><?= h($stripeExcel->description) ?></td>
                <td><?= $this->Number->format($stripeExcel->debit) ?></td>
                <td><?= $this->Number->format($stripeExcel->credit) ?></td>
                <td><?= $stripeExcel->has('stripe_csv') ? $this->Html->link($stripeExcel->stripe_csv->id, ['controller' => 'StripeCsvs', 'action' => 'view', $stripeExcel->stripe_csv->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $stripeExcel->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stripeExcel->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stripeExcel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeExcel->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
