<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Langue $langue
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Langue'), ['action' => 'edit', $langue->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Langue'), ['action' => 'delete', $langue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $langue->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Langues'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Langue'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="langues view large-9 medium-8 columns content">
    <h3><?= h($langue->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($langue->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Code') ?></th>
            <td><?= h($langue->code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($langue->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($langue->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($langue->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Devis') ?></h4>
        <?php if (!empty($langue->devis)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Indent') ?></th>
                <th scope="col"><?= __('Objet') ?></th>
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
                <th scope="col"><?= __('Display Virement') ?></th>
                <th scope="col"><?= __('Display Cheque') ?></th>
                <th scope="col"><?= __('Sellsy Client Id') ?></th>
                <th scope="col"><?= __('Sellsy Document Id') ?></th>
                <th scope="col"><?= __('Is In Sellsy') ?></th>
                <th scope="col"><?= __('Client Tel') ?></th>
                <th scope="col"><?= __('Client Email') ?></th>
                <th scope="col"><?= __('Sellsy Public Url') ?></th>
                <th scope="col"><?= __('Sellsy Doc Id') ?></th>
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
                <th scope="col"><?= __('Model Type') ?></th>
                <th scope="col"><?= __('Model Name') ?></th>
                <th scope="col"><?= __('Modele Devis Categories Id') ?></th>
                <th scope="col"><?= __('Modele Devis Sous Categories Id') ?></th>
                <th scope="col"><?= __('Categorie Tarifaire') ?></th>
                <th scope="col"><?= __('Client Nom') ?></th>
                <th scope="col"><?= __('Client Cp') ?></th>
                <th scope="col"><?= __('Client Ville') ?></th>
                <th scope="col"><?= __('Client Adresse') ?></th>
                <th scope="col"><?= __('Client Adresse 2') ?></th>
                <th scope="col"><?= __('Client Country') ?></th>
                <th scope="col"><?= __('Display Tva') ?></th>
                <th scope="col"><?= __('Uuid') ?></th>
                <th scope="col"><?= __('Tva Id') ?></th>
                <th scope="col"><?= __('Commentaire Client') ?></th>
                <th scope="col"><?= __('Commentaire Commercial') ?></th>
                <th scope="col"><?= __('Sellsy Echeances') ?></th>
                <th scope="col"><?= __('Lieu Retrait') ?></th>
                <th scope="col"><?= __('Type Doc Id') ?></th>
                <th scope="col"><?= __('Date Evenement') ?></th>
                <th scope="col"><?= __('Date Evenement Fin') ?></th>
                <th scope="col"><?= __('Client Contact Id') ?></th>
                <th scope="col"><?= __('Id In Wp') ?></th>
                <th scope="col"><?= __('Date Total Paiement') ?></th>
                <th scope="col"><?= __('Montant Total Paid') ?></th>
                <th scope="col"><?= __('Type Prelevement') ?></th>
                <th scope="col"><?= __('Lieu Evenement') ?></th>
                <th scope="col"><?= __('Message Id In Mailjet') ?></th>
                <th scope="col"><?= __('Is Consommable') ?></th>
                <th scope="col"><?= __('Langue Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($langue->devis as $devis): ?>
            <tr>
                <td><?= h($devis->id) ?></td>
                <td><?= h($devis->indent) ?></td>
                <td><?= h($devis->objet) ?></td>
                <td><?= h($devis->nom_societe) ?></td>
                <td><?= h($devis->date_crea) ?></td>
                <td><?= h($devis->date_sign_before) ?></td>
                <td><?= h($devis->ref_commercial_id) ?></td>
                <td><?= h($devis->note) ?></td>
                <td><?= h($devis->client_id) ?></td>
                <td><?= h($devis->date_validite) ?></td>
                <td><?= h($devis->moyen_reglements) ?></td>
                <td><?= h($devis->delai_reglements) ?></td>
                <td><?= h($devis->echeance_date) ?></td>
                <td><?= h($devis->echeance_value) ?></td>
                <td><?= h($devis->text_loi) ?></td>
                <td><?= h($devis->is_text_loi_displayed) ?></td>
                <td><?= h($devis->remise_hide_line) ?></td>
                <td><?= h($devis->remise_line) ?></td>
                <td><?= h($devis->remise_global_value) ?></td>
                <td><?= h($devis->remise_global_unity) ?></td>
                <td><?= h($devis->accompte_value) ?></td>
                <td><?= h($devis->accompte_unity) ?></td>
                <td><?= h($devis->col_visibility_params) ?></td>
                <td><?= h($devis->info_bancaire_id) ?></td>
                <td><?= h($devis->display_virement) ?></td>
                <td><?= h($devis->display_cheque) ?></td>
                <td><?= h($devis->sellsy_client_id) ?></td>
                <td><?= h($devis->sellsy_document_id) ?></td>
                <td><?= h($devis->is_in_sellsy) ?></td>
                <td><?= h($devis->client_tel) ?></td>
                <td><?= h($devis->client_email) ?></td>
                <td><?= h($devis->sellsy_public_url) ?></td>
                <td><?= h($devis->sellsy_doc_id) ?></td>
                <td><?= h($devis->status) ?></td>
                <td><?= h($devis->position_type) ?></td>
                <td><?= h($devis->created) ?></td>
                <td><?= h($devis->modified) ?></td>
                <td><?= h($devis->total_ttc) ?></td>
                <td><?= h($devis->total_ht) ?></td>
                <td><?= h($devis->total_reduction) ?></td>
                <td><?= h($devis->total_remise) ?></td>
                <td><?= h($devis->total_tva) ?></td>
                <td><?= h($devis->is_model) ?></td>
                <td><?= h($devis->model_type) ?></td>
                <td><?= h($devis->model_name) ?></td>
                <td><?= h($devis->modele_devis_categories_id) ?></td>
                <td><?= h($devis->modele_devis_sous_categories_id) ?></td>
                <td><?= h($devis->categorie_tarifaire) ?></td>
                <td><?= h($devis->client_nom) ?></td>
                <td><?= h($devis->client_cp) ?></td>
                <td><?= h($devis->client_ville) ?></td>
                <td><?= h($devis->client_adresse) ?></td>
                <td><?= h($devis->client_adresse_2) ?></td>
                <td><?= h($devis->client_country) ?></td>
                <td><?= h($devis->display_tva) ?></td>
                <td><?= h($devis->uuid) ?></td>
                <td><?= h($devis->tva_id) ?></td>
                <td><?= h($devis->commentaire_client) ?></td>
                <td><?= h($devis->commentaire_commercial) ?></td>
                <td><?= h($devis->sellsy_echeances) ?></td>
                <td><?= h($devis->lieu_retrait) ?></td>
                <td><?= h($devis->type_doc_id) ?></td>
                <td><?= h($devis->date_evenement) ?></td>
                <td><?= h($devis->date_evenement_fin) ?></td>
                <td><?= h($devis->client_contact_id) ?></td>
                <td><?= h($devis->id_in_wp) ?></td>
                <td><?= h($devis->date_total_paiement) ?></td>
                <td><?= h($devis->montant_total_paid) ?></td>
                <td><?= h($devis->type_prelevement) ?></td>
                <td><?= h($devis->lieu_evenement) ?></td>
                <td><?= h($devis->message_id_in_mailjet) ?></td>
                <td><?= h($devis->is_consommable) ?></td>
                <td><?= h($devis->langue_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Devis', 'action' => 'edit', $devis->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Devis', 'action' => 'delete', $devis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devis->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
