<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesPreference $devisFacturessPreference
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit DevisFactures Preference'), ['action' => 'edit', $devisFacturessPreference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete DevisFactures Preference'), ['action' => 'delete', $devisFacturessPreference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturessPreference->id)]) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures Preferences'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New DevisFactures Preference'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Adresses'), ['controller' => 'Adresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Adress'), ['controller' => 'Adresses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="devisFacturessPreferences view large-9 medium-8 columns content">
    <h3><?= h($devisFacturessPreference->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Delai Reglements') ?></th>
            <td><?= h($devisFacturessPreference->delai_reglements) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accompte Unity') ?></th>
            <td><?= h($devisFacturessPreference->accompte_unity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Adress') ?></th>
            <td><?= $devisFacturessPreference->has('adress') ? $this->Html->link($devisFacturessPreference->adress->adresse, ['controller' => 'Adresses', 'action' => 'view', $devisFacturessPreference->adress->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($devisFacturessPreference->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Info Bancaire Id') ?></th>
            <td><?= $this->Number->format($devisFacturessPreference->info_bancaire_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accompte Value') ?></th>
            <td><?= $this->Number->format($devisFacturessPreference->accompte_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Text Loi Displayed') ?></th>
            <td><?= $devisFacturessPreference->is_text_loi_displayed ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Moyen Reglements') ?></h4>
        <?= $this->Text->autoParagraph(h($devisFacturessPreference->moyen_reglements)); ?>
    </div>
    <div class="row">
        <h4><?= __('Text Loi') ?></h4>
        <?= $this->Text->autoParagraph(h($devisFacturessPreference->text_loi)); ?>
    </div>
    <div class="row">
        <h4><?= __('Note') ?></h4>
        <?= $this->Text->autoParagraph(h($devisFacturessPreference->note)); ?>
    </div>
</div>
