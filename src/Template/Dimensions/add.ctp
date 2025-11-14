<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dimension $dimension
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Dimensions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dimensions form large-9 medium-8 columns content">
    <?= $this->Form->create($dimension) ?>
    <fieldset>
        <legend><?= __('Add Dimension') ?></legend>
        <?php
            echo $this->Form->control('dimension');
            echo $this->Form->control('poids');
            echo $this->Form->control('model_borne_id', ['options' => $modelBornes]);
            echo $this->Form->control('partie_id', ['options' => $parties]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
