<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacture $invoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures Produits'), ['controller' => 'DevisFacturesProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFactures Produit'), ['controller' => 'DevisFacturesProduits', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="invoices form large-9 medium-8 columns content">
    <?= $this->Form->create($invoice) ?>
    <fieldset>
        <legend><?= __('Edit DevisFacture') ?></legend>
        <?php
            echo $this->Form->control('indent');
            echo $this->Form->control('objet');
            echo $this->Form->control('adresse');
            echo $this->Form->control('cp');
            echo $this->Form->control('ville');
            echo $this->Form->control('pays');
            echo $this->Form->control('nom_societe');
            echo $this->Form->control('date_crea', ['empty' => true]);
            echo $this->Form->control('date_sign_before', ['empty' => true]);
            echo $this->Form->control('ref_commercial_id');
            echo $this->Form->control('note');
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('date_validite', ['empty' => true]);
            echo $this->Form->control('moyen_reglements');
            echo $this->Form->control('delai_reglements');
            echo $this->Form->control('echeance_date');
            echo $this->Form->control('echeance_value');
            echo $this->Form->control('text_loi');
            echo $this->Form->control('is_text_loi_displayed');
            echo $this->Form->control('remise_hide_line');
            echo $this->Form->control('remise_line');
            echo $this->Form->control('remise_global_value');
            echo $this->Form->control('remise_global_unity');
            echo $this->Form->control('accompte_value');
            echo $this->Form->control('accompte_unity');
            echo $this->Form->control('col_visibility_params');
            echo $this->Form->control('info_bancaire_id');
            echo $this->Form->control('status');
            echo $this->Form->control('position_type');
            echo $this->Form->control('total_ttc');
            echo $this->Form->control('total_ht');
            echo $this->Form->control('total_reduction');
            echo $this->Form->control('total_remise');
            echo $this->Form->control('total_tva');
            echo $this->Form->control('is_model');
            echo $this->Form->control('model_name');
            echo $this->Form->control('modele_invoices_category_id');
            echo $this->Form->control('modele_invoices_sous_category_id');
            echo $this->Form->control('categorie_tarifaire');
            echo $this->Form->control('client_nom');
            echo $this->Form->control('client_cp');
            echo $this->Form->control('client_ville');
            echo $this->Form->control('client_adresse');
            echo $this->Form->control('client_country');
            echo $this->Form->control('display_tva');
            echo $this->Form->control('uuid');
            echo $this->Form->control('antennes._ids', ['options' => $antennes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
