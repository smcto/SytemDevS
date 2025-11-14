<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CouleurPossible $couleurPossible
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Couleur Possibles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="couleurPossibles form large-9 medium-8 columns content">
    <?= $this->Form->create($couleurPossible) ?>
    <fieldset>
        <legend><?= __('Add Couleur Possible') ?></legend>
        <?php
            echo $this->Form->control('couleur');
            echo $this->Form->control('model_borne_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
