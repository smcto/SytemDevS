<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FactureDeduction $factureDeduction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Facture Deduction'), ['action' => 'edit', $factureDeduction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facture Deduction'), ['action' => 'delete', $factureDeduction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $factureDeduction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facture Deductions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facture Deduction'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="factureDeductions view large-9 medium-8 columns content">
    <h3><?= h($factureDeduction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($factureDeduction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ca Ht Deduire') ?></th>
            <td><?= $this->Number->format($factureDeduction->ca_ht_deduire) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Avoir Ht Deduire') ?></th>
            <td><?= $this->Number->format($factureDeduction->avoir_ht_deduire) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pca Part') ?></th>
            <td><?= $this->Number->format($factureDeduction->pca_part) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pca Pro') ?></th>
            <td><?= $this->Number->format($factureDeduction->pca_pro) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Annee') ?></th>
            <td><?= $this->Number->format($factureDeduction->annee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($factureDeduction->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($factureDeduction->modified) ?></td>
        </tr>
    </table>
</div>
