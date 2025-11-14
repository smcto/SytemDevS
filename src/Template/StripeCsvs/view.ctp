<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsv $stripeCsv
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stripe Csv'), ['action' => 'edit', $stripeCsv->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stripe Csv'), ['action' => 'delete', $stripeCsv->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeCsv->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Excels'), ['controller' => 'StripeExcels', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Excel'), ['controller' => 'StripeExcels', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stripeCsvs view large-9 medium-8 columns content">
    <h3><?= h($stripeCsv->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id Stripe') ?></th>
            <td><?= h($stripeCsv->id_stripe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller Message') ?></th>
            <td><?= h($stripeCsv->seller_message) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Currency') ?></th>
            <td><?= h($stripeCsv->currency) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Converted Currency') ?></th>
            <td><?= h($stripeCsv->converted_currency) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($stripeCsv->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Statement Descriptor') ?></th>
            <td><?= h($stripeCsv->statement_descriptor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Description') ?></th>
            <td><?= h($stripeCsv->customer_description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer Email') ?></th>
            <td><?= h($stripeCsv->customer_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Captured') ?></th>
            <td><?= h($stripeCsv->captured) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CardId') ?></th>
            <td><?= h($stripeCsv->cardId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('InvoiceId') ?></th>
            <td><?= h($stripeCsv->invoiceId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transfert') ?></th>
            <td><?= h($stripeCsv->transfert) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stripeCsv->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= $this->Number->format($stripeCsv->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($stripeCsv->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Refunded') ?></th>
            <td><?= $this->Number->format($stripeCsv->amount_refunded) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Converted Amount') ?></th>
            <td><?= $this->Number->format($stripeCsv->converted_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Converted Amount Refunded') ?></th>
            <td><?= $this->Number->format($stripeCsv->converted_amount_refunded) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fee') ?></th>
            <td><?= $this->Number->format($stripeCsv->fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax') ?></th>
            <td><?= $this->Number->format($stripeCsv->tax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CustomerId') ?></th>
            <td><?= $this->Number->format($stripeCsv->customerId) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Import') ?></th>
            <td><?= h($stripeCsv->date_import) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($stripeCsv->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Stripe Excels') ?></h4>
        <?php if (!empty($stripeCsv->stripe_excels)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Piece') ?></th>
                <th scope="col"><?= __('Compte') ?></th>
                <th scope="col"><?= __('Libelle') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Debit') ?></th>
                <th scope="col"><?= __('Credit') ?></th>
                <th scope="col"><?= __('Stripe Csv Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($stripeCsv->stripe_excels as $stripeExcels): ?>
            <tr>
                <td><?= h($stripeExcels->id) ?></td>
                <td><?= h($stripeExcels->date) ?></td>
                <td><?= h($stripeExcels->piece) ?></td>
                <td><?= h($stripeExcels->compte) ?></td>
                <td><?= h($stripeExcels->libelle) ?></td>
                <td><?= h($stripeExcels->description) ?></td>
                <td><?= h($stripeExcels->debit) ?></td>
                <td><?= h($stripeExcels->credit) ?></td>
                <td><?= h($stripeExcels->stripe_csv_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'StripeExcels', 'action' => 'view', $stripeExcels->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'StripeExcels', 'action' => 'edit', $stripeExcels->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StripeExcels', 'action' => 'delete', $stripeExcels->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeExcels->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
