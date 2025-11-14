<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModeleDevisFacturesSousCategory $modeleDevisFacturesSousCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Modele DevisFactures Sous Category'), ['action' => 'edit', $modeleDevisFacturesSousCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Modele DevisFactures Sous Category'), ['action' => 'delete', $modeleDevisFacturesSousCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modeleDevisFacturesSousCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Sous Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Sous Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modele DevisFactures Categories'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Modele DevisFactures Category'), ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="modeleDevisFacturesSousCategories view large-9 medium-8 columns content">
    <h3><?= h($modeleDevisFacturesSousCategory->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Modele DevisFactures Category') ?></th>
            <td><?= $modeleDevisFacturesSousCategory->has('modele_devis_factures_category') ? $this->Html->link($modeleDevisFacturesSousCategory->modele_devis_factures_category->name, ['controller' => 'ModeleDevisFacturesCategories', 'action' => 'view', $modeleDevisFacturesSousCategory->modele_devis_factures_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($modeleDevisFacturesSousCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($modeleDevisFacturesSousCategory->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related DevisFactures') ?></h4>
        <?php if (!empty($modeleDevisFacturesSousCategory->devis_factures)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Indent') ?></th>
                <th scope="col"><?= __('Objet') ?></th>
                <th scope="col"><?= __('Adresse') ?></th>
                <th scope="col"><?= __('Cp') ?></th>
                <th scope="col"><?= __('Ville') ?></th>
                <th scope="col"><?= __('Pays') ?></th>
                <th scope="col"><?= __('Nom Societe') ?></th>
                <th scope="col"><?= __('Date Crea') ?></th>
                <th scope="col"><?= __('Date Sign Before') ?></th>
                <th scope="col"><?= __('Ref Commercial Id') ?></th>
                <th scope="col"><?= __('Note') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Date Validite') ?></th>
                <th scope="col"><?= __('Moyen Reglements') ?></th>
                <th scope="col"><?= __('Delai Reglements') ?></th>
                <th scope="col"><?= __('Echeance Date') ?></th>
                <th scope="col"><?= __('Echeance Value') ?></th>
                <th scope="col"><?= __('Text Loi') ?></th>
                <th scope="col"><?= __('Is Text Loi Displayed') ?></th>
                <th scope="col"><?= __('Remise Hide Line') ?></th>
                <th scope="col"><?= __('Remise Line') ?></th>
                <th scope="col"><?= __('Remise Global Value') ?></th>
                <th scope="col"><?= __('Remise Global Unity') ?></th>
                <th scope="col"><?= __('Accompte Value') ?></th>
                <th scope="col"><?= __('Accompte Unity') ?></th>
                <th scope="col"><?= __('Col Visibility Params') ?></th>
                <th scope="col"><?= __('Info Bancaire Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Position Type') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Total Ttc') ?></th>
                <th scope="col"><?= __('Total Ht') ?></th>
                <th scope="col"><?= __('Total Reduction') ?></th>
                <th scope="col"><?= __('Total Remise') ?></th>
                <th scope="col"><?= __('Total Tva') ?></th>
                <th scope="col"><?= __('Is Model') ?></th>
                <th scope="col"><?= __('Model Name') ?></th>
                <th scope="col"><?= __('Modele DevisFactures Category Id') ?></th>
                <th scope="col"><?= __('Modele DevisFactures Sous Category Id') ?></th>
                <th scope="col"><?= __('Categorie Tarifaire') ?></th>
                <th scope="col"><?= __('Client Nom') ?></th>
                <th scope="col"><?= __('Client Cp') ?></th>
                <th scope="col"><?= __('Client Ville') ?></th>
                <th scope="col"><?= __('Client Adresse') ?></th>
                <th scope="col"><?= __('Client Country') ?></th>
                <th scope="col"><?= __('Display Tva') ?></th>
                <th scope="col"><?= __('Uuid') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($modeleDevisFacturesSousCategory->devis_factures as $devis_factures): ?>
            <tr>
                <td><?= h($devis_factures->id) ?></td>
                <td><?= h($devis_factures->indent) ?></td>
                <td><?= h($devis_factures->objet) ?></td>
                <td><?= h($devis_factures->adresse) ?></td>
                <td><?= h($devis_factures->cp) ?></td>
                <td><?= h($devis_factures->ville) ?></td>
                <td><?= h($devis_factures->pays) ?></td>
                <td><?= h($devis_factures->nom_societe) ?></td>
                <td><?= h($devis_factures->date_crea) ?></td>
                <td><?= h($devis_factures->date_sign_before) ?></td>
                <td><?= h($devis_factures->ref_commercial_id) ?></td>
                <td><?= h($devis_factures->note) ?></td>
                <td><?= h($devis_factures->client_id) ?></td>
                <td><?= h($devis_factures->date_validite) ?></td>
                <td><?= h($devis_factures->moyen_reglements) ?></td>
                <td><?= h($devis_factures->delai_reglements) ?></td>
                <td><?= h($devis_factures->echeance_date) ?></td>
                <td><?= h($devis_factures->echeance_value) ?></td>
                <td><?= h($devis_factures->text_loi) ?></td>
                <td><?= h($devis_factures->is_text_loi_displayed) ?></td>
                <td><?= h($devis_factures->remise_hide_line) ?></td>
                <td><?= h($devis_factures->remise_line) ?></td>
                <td><?= h($devis_factures->remise_global_value) ?></td>
                <td><?= h($devis_factures->remise_global_unity) ?></td>
                <td><?= h($devis_factures->accompte_value) ?></td>
                <td><?= h($devis_factures->accompte_unity) ?></td>
                <td><?= h($devis_factures->col_visibility_params) ?></td>
                <td><?= h($devis_factures->info_bancaire_id) ?></td>
                <td><?= h($devis_factures->status) ?></td>
                <td><?= h($devis_factures->position_type) ?></td>
                <td><?= h($devis_factures->created) ?></td>
                <td><?= h($devis_factures->modified) ?></td>
                <td><?= h($devis_factures->total_ttc) ?></td>
                <td><?= h($devis_factures->total_ht) ?></td>
                <td><?= h($devis_factures->total_reduction) ?></td>
                <td><?= h($devis_factures->total_remise) ?></td>
                <td><?= h($devis_factures->total_tva) ?></td>
                <td><?= h($devis_factures->is_model) ?></td>
                <td><?= h($devis_factures->model_name) ?></td>
                <td><?= h($devis_factures->modele_devis_factures_category_id) ?></td>
                <td><?= h($devis_factures->modele_devis_factures_sous_category_id) ?></td>
                <td><?= h($devis_factures->categorie_tarifaire) ?></td>
                <td><?= h($devis_factures->client_nom) ?></td>
                <td><?= h($devis_factures->client_cp) ?></td>
                <td><?= h($devis_factures->client_ville) ?></td>
                <td><?= h($devis_factures->client_adresse) ?></td>
                <td><?= h($devis_factures->client_country) ?></td>
                <td><?= h($devis_factures->display_tva) ?></td>
                <td><?= h($devis_factures->uuid) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DevisFactures', 'action' => 'view', $devis_factures->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DevisFactures', 'action' => 'edit', $devis_factures->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DevisFactures', 'action' => 'delete', $devis_factures->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devis_factures->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
