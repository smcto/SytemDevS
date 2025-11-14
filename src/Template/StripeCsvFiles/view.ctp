<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsvFile $stripeCsvFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stripe Csv File'), ['action' => 'edit', $stripeCsvFile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stripe Csv File'), ['action' => 'delete', $stripeCsvFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeCsvFile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Csv Files'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Csv File'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['controller' => 'StripeCsvs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['controller' => 'StripeCsvs', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stripeCsvFiles view large-9 medium-8 columns content">
    <h3><?= h($stripeCsvFile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($stripeCsvFile->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename Origin') ?></th>
            <td><?= h($stripeCsvFile->filename_origin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stripeCsvFile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Import') ?></th>
            <td><?= h($stripeCsvFile->date_import) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Stripe Csvs') ?></h4>
        <?php if (!empty($stripeCsvFile->stripe_csvs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Id Stripe') ?></th>
                <th scope="col"><?= __('Stripe Csv File Id') ?></th>
                <th scope="col"><?= __('Date Import') ?></th>
                <th scope="col"><?= __('Filename Origin') ?></th>
                <th scope="col"><?= __('Filename') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Seller Message') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Amount Refunded') ?></th>
                <th scope="col"><?= __('Currency') ?></th>
                <th scope="col"><?= __('Converted Amount') ?></th>
                <th scope="col"><?= __('Converted Amount Refunded') ?></th>
                <th scope="col"><?= __('Fee') ?></th>
                <th scope="col"><?= __('Tax') ?></th>
                <th scope="col"><?= __('Converted Currency') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Statement Descriptor') ?></th>
                <th scope="col"><?= __('CustomerId') ?></th>
                <th scope="col"><?= __('Customer Description') ?></th>
                <th scope="col"><?= __('Customer Email') ?></th>
                <th scope="col"><?= __('Captured') ?></th>
                <th scope="col"><?= __('CardId') ?></th>
                <th scope="col"><?= __('InvoiceId') ?></th>
                <th scope="col"><?= __('Transfert') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($stripeCsvFile->stripe_csvs as $stripeCsvs): ?>
            <tr>
                <td><?= h($stripeCsvs->id) ?></td>
                <td><?= h($stripeCsvs->id_stripe) ?></td>
                <td><?= h($stripeCsvs->stripe_csv_file_id) ?></td>
                <td><?= h($stripeCsvs->date_import) ?></td>
                <td><?= h($stripeCsvs->filename_origin) ?></td>
                <td><?= h($stripeCsvs->filename) ?></td>
                <td><?= h($stripeCsvs->description) ?></td>
                <td><?= h($stripeCsvs->seller_message) ?></td>
                <td><?= h($stripeCsvs->created) ?></td>
                <td><?= h($stripeCsvs->amount) ?></td>
                <td><?= h($stripeCsvs->amount_refunded) ?></td>
                <td><?= h($stripeCsvs->currency) ?></td>
                <td><?= h($stripeCsvs->converted_amount) ?></td>
                <td><?= h($stripeCsvs->converted_amount_refunded) ?></td>
                <td><?= h($stripeCsvs->fee) ?></td>
                <td><?= h($stripeCsvs->tax) ?></td>
                <td><?= h($stripeCsvs->converted_currency) ?></td>
                <td><?= h($stripeCsvs->status) ?></td>
                <td><?= h($stripeCsvs->statement_descriptor) ?></td>
                <td><?= h($stripeCsvs->customerId) ?></td>
                <td><?= h($stripeCsvs->customer_description) ?></td>
                <td><?= h($stripeCsvs->customer_email) ?></td>
                <td><?= h($stripeCsvs->captured) ?></td>
                <td><?= h($stripeCsvs->cardId) ?></td>
                <td><?= h($stripeCsvs->invoiceId) ?></td>
                <td><?= h($stripeCsvs->transfert) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'StripeCsvs', 'action' => 'view', $stripeCsvs->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'StripeCsvs', 'action' => 'edit', $stripeCsvs->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StripeCsvs', 'action' => 'delete', $stripeCsvs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stripeCsvs->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
