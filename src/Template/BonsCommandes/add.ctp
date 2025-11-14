<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BonsCommande $bonsCommande
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Bons Commandes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bonsCommandes form large-9 medium-8 columns content">
    <?= $this->Form->create($bonsCommande) ?>
    <fieldset>
        <legend><?= __('Add Bons Commande') ?></legend>
        <?php
            echo $this->Form->control('devi_id', ['options' => $devis]);
            echo $this->Form->control('indent');
            echo $this->Form->control('type_date');
            echo $this->Form->control('date', ['empty' => true]);
            echo $this->Form->control('commentaire');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
