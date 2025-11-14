<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Langue $langue
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $langue->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $langue->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Langues'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="langues form large-9 medium-8 columns content">
    <?= $this->Form->create($langue) ?>
    <fieldset>
        <legend><?= __('Edit Langue') ?></legend>
        <?php
            echo $this->Form->control('nom');
            echo $this->Form->control('code');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
