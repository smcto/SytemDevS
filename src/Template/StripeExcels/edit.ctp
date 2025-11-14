<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeExcel $stripeExcel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stripeExcel->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stripeExcel->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stripe Excels'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['controller' => 'StripeCsvs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['controller' => 'StripeCsvs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stripeExcels form large-9 medium-8 columns content">
    <?= $this->Form->create($stripeExcel) ?>
    <fieldset>
        <legend><?= __('Edit Stripe Excel') ?></legend>
        <?php
            echo $this->Form->control('date', ['empty' => true]);
            echo $this->Form->control('piece');
            echo $this->Form->control('compte');
            echo $this->Form->control('libelle');
            echo $this->Form->control('description');
            echo $this->Form->control('debit');
            echo $this->Form->control('credit');
            echo $this->Form->control('stripe_csv_id', ['options' => $stripeCsvs, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
