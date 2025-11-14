<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BonsLivraison $bonsLivraison
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bonsLivraison->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bonsLivraison->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Bons Livraisons'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bons Preparations'), ['controller' => 'BonsPreparations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bons Preparation'), ['controller' => 'BonsPreparations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bons Livraisons Produits'), ['controller' => 'BonsLivraisonsProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bons Livraisons Produit'), ['controller' => 'BonsLivraisonsProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bonsLivraisons form large-9 medium-8 columns content">
    <?= $this->Form->create($bonsLivraison) ?>
    <fieldset>
        <legend><?= __('Edit Bons Livraison') ?></legend>
        <?php
            echo $this->Form->control('devi_id', ['options' => $devis]);
            echo $this->Form->control('bons_preparation_id', ['options' => $bonsPreparations]);
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('date_depart_atelier', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
