<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModeleDevisFacturesSousCategory $modeleDevisFacturesSousCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Sous Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Categories'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Category'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modeleDevisFacturesSousCategories form large-9 medium-8 columns content">
    <?= $this->Form->create($modeleDevisFacturesSousCategory) ?>
    <fieldset>
        <legend><?= __('Add Modele DevisFactures Sous Category') ?></legend>
        <?php
            echo $this->Form->control('modele_devis_factures_category_id', ['options' => $modeleDevisFacturesCategories]);
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
