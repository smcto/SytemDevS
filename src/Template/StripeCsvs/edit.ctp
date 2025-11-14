<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsv $stripeCsv
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stripeCsv->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stripeCsv->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stripe Excels'), ['controller' => 'StripeExcels', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stripe Excel'), ['controller' => 'StripeExcels', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stripeCsvs form large-9 medium-8 columns content">
    <?= $this->Form->create($stripeCsv) ?>
    <fieldset>
        <legend><?= __('Edit Stripe Csv') ?></legend>
        <?php
            echo $this->Form->control('id_stripe');
            echo $this->Form->control('date_import', ['empty' => true]);
            echo $this->Form->control('description');
            echo $this->Form->control('seller_message');
            echo $this->Form->control('amount');
            echo $this->Form->control('amount_refunded');
            echo $this->Form->control('currency');
            echo $this->Form->control('converted_amount');
            echo $this->Form->control('converted_amount_refunded');
            echo $this->Form->control('fee');
            echo $this->Form->control('tax');
            echo $this->Form->control('converted_currency');
            echo $this->Form->control('status');
            echo $this->Form->control('statement_descriptor');
            echo $this->Form->control('customerId');
            echo $this->Form->control('customer_description');
            echo $this->Form->control('customer_email');
            echo $this->Form->control('captured');
            echo $this->Form->control('cardId');
            echo $this->Form->control('invoiceId');
            echo $this->Form->control('transfert');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
