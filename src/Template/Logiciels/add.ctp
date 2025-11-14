<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Logiciel $logiciel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Logiciels'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Borne Logiciels'), ['controller' => 'BorneLogiciels', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne Logiciel'), ['controller' => 'BorneLogiciels', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="logiciels form large-9 medium-8 columns content">
    <?= $this->Form->create($logiciel) ?>
    <fieldset>
        <legend><?= __('Add Logiciel') ?></legend>
        <?php
            echo $this->Form->control('nom');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
