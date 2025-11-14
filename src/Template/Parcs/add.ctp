<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Parc $parc
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Parcs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="parcs form large-9 medium-8 columns content">
    <?= $this->Form->create($parc) ?>
    <fieldset>
        <legend><?= __('Add Parc') ?></legend>
        <?php
            echo $this->Form->control('nom');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
