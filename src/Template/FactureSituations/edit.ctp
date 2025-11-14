<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FactureSituation $factureSituation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $factureSituation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $factureSituation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Facture Situations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Facture Situations Produits'), ['controller' => 'FactureSituationsProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facture Situations Produit'), ['controller' => 'FactureSituationsProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="factureSituations form large-9 medium-8 columns content">
    <?= $this->Form->create($factureSituation) ?>
    <fieldset>
        <legend><?= __('Edit Facture Situation') ?></legend>
        <?php
            echo $this->Form->control('indent');
            echo $this->Form->control('numero');
            echo $this->Form->control('devi_id', ['options' => $devis]);
            echo $this->Form->control('objet');
            echo $this->Form->control('date_crea');
            echo $this->Form->control('ref_commercial_id');
            echo $this->Form->control('note');
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('total_ht');
            echo $this->Form->control('total_ttc');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
