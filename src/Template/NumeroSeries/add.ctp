<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NumeroSeries $numeroSeries
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Numero Series'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Lot Produits'), ['controller' => 'LotProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Lot Produit'), ['controller' => 'LotProduits', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="numeroSeries form large-9 medium-8 columns content">
    <?= $this->Form->create($numeroSeries) ?>
    <fieldset>
        <legend><?= __('Add Numero Series') ?></legend>
        <?php
            echo $this->Form->control('serial_nb');
            echo $this->Form->control('lot_produit_id', ['options' => $lotProduits, 'empty' => true]);
            echo $this->Form->control('borne_id', ['options' => $bornes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
