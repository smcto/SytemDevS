<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StripeCsvFile $stripeCsvFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stripeCsvFile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stripeCsvFile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stripe Csv Files'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Stripe Csvs'), ['controller' => 'StripeCsvs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stripe Csv'), ['controller' => 'StripeCsvs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stripeCsvFiles form large-9 medium-8 columns content">
    <?= $this->Form->create($stripeCsvFile) ?>
    <fieldset>
        <legend><?= __('Edit Stripe Csv File') ?></legend>
        <?php
            echo $this->Form->control('date_import', ['empty' => true]);
            echo $this->Form->control('filename');
            echo $this->Form->control('filename_origin');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
