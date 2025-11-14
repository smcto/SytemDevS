<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModeleDevisFacturesCategory $modeleDevisFacturesCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $modeleDevisFacturesCategory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $modeleDevisFacturesCategory->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Sous Categories'), ['controller' => 'ModeleDevisFacturesSousCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Sous Category'), ['controller' => 'ModeleDevisFacturesSousCategories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modeleDevisFacturesCategories form large-9 medium-8 columns content">
    <?= $this->Form->create($modeleDevisFacturesCategory) ?>
    <fieldset>
        <legend><?= __('Edit Modele DevisFactures Category') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
