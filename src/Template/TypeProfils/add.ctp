<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeProfil $typeProfil
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Type Profils'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List User Type Profils'), ['controller' => 'UserTypeProfils', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Type Profil'), ['controller' => 'UserTypeProfils', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="typeProfils form large-9 medium-8 columns content">
    <?= $this->Form->create($typeProfil) ?>
    <fieldset>
        <legend><?= __('Add Type Profil') ?></legend>
        <?php
            echo $this->Form->control('nom');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
