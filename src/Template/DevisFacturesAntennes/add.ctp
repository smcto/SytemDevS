<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFactureAntenne $devisFacturesAntenne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List DevisFacture Antennes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List DevisFacture'), ['controller' => 'DevisFacture', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFacture', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesAntennes form large-9 medium-8 columns content">
    <?= $this->Form->create($devisFacturesAntenne) ?>
    <fieldset>
        <legend><?= __('Add DevisFacture Antenne') ?></legend>
        <?php
            echo $this->Form->control('devis_facture_id', ['options' => $devisFactures]);
            echo $this->Form->control('antenne_id', ['options' => $antennes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
