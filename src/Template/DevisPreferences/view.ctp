<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisPreference $devisPreference
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Devis Preference'), ['action' => 'edit', $devisPreference->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Devis Preference'), ['action' => 'delete', $devisPreference->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisPreference->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Devis Preferences'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Devis Preference'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Infos Bancaires'), ['controller' => 'InfosBancaires', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Infos Bancaire'), ['controller' => 'InfosBancaires', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="devisPreferences view large-9 medium-8 columns content">
    <h3><?= h($devisPreference->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Delai Reglements') ?></th>
            <td><?= h($devisPreference->delai_reglements) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Infos Bancaire') ?></th>
            <td><?= $devisPreference->has('infos_bancaire') ? $this->Html->link($devisPreference->infos_bancaire->name, ['controller' => 'InfosBancaires', 'action' => 'view', $devisPreference->infos_bancaire->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accompte Unity') ?></th>
            <td><?= h($devisPreference->accompte_unity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($devisPreference->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Accompte Value') ?></th>
            <td><?= $this->Number->format($devisPreference->accompte_value) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Moyen Reglements') ?></h4>
        <?= $this->Text->autoParagraph(h($devisPreference->moyen_reglements)); ?>
    </div>
</div>
