<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MoyenReglement $moyenReglement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Moyen Reglements'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Reglements'), ['controller' => 'Reglements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reglement'), ['controller' => 'Reglements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="moyenReglements form large-9 medium-8 columns content">
    <?= $this->Form->create($moyenReglement) ?>
    <fieldset>
        <legend><?= __('Add Moyen Reglement') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
