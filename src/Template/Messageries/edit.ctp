<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Messagery $messagery
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $messagery->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $messagery->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Messageries'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="messageries form large-9 medium-8 columns content">
    <?= $this->Form->create($messagery) ?>
    <fieldset>
        <legend><?= __('Edit Messagery') ?></legend>
        <?php
            echo $this->Form->control('expediteur');
            echo $this->Form->control('message');
            echo $this->Form->control('is_test');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
