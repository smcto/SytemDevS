<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeExcel $stripeExcel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stripe Excel'), ['action' => 'edit', $stripeExcel->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stripe Excel'), ['action' => 'delete', $stripeExcel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeExcel->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Excels'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Excel'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['controller' => 'StripeCsvs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['controller' => 'StripeCsvs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stripeExcels view large-9 medium-8 columns content">
    <h3><?= h($stripeExcel->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Piece') ?></th>
            <td><?= h($stripeExcel->piece) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Compte') ?></th>
            <td><?= h($stripeExcel->compte) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Libelle') ?></th>
            <td><?= h($stripeExcel->libelle) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($stripeExcel->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stripe Csv') ?></th>
            <td><?= $stripeExcel->has('stripe_csv') ? $this->Html->link($stripeExcel->stripe_csv->id, ['controller' => 'StripeCsvs', 'action' => 'view', $stripeExcel->stripe_csv->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stripeExcel->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Debit') ?></th>
            <td><?= $this->Number->format($stripeExcel->debit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Credit') ?></th>
            <td><?= $this->Number->format($stripeExcel->credit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($stripeExcel->date) ?></td>
        </tr>
    </table>
</div>
