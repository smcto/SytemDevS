<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Materiel $materiel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Materiel'), ['action' => 'edit', $materiel->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Materiel'), ['action' => 'delete', $materiel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $materiel->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Materiels'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Materiel'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="materiels view large-9 medium-8 columns content">
    <h3><?= h($materiel->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Materiel') ?></th>
            <td><?= h($materiel->materiel) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descriptif') ?></th>
            <td><?= h($materiel->descriptif) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photos') ?></th>
            <td><?= h($materiel->photos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notice Tuto') ?></th>
            <td><?= h($materiel->notice_tuto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Consignes') ?></th>
            <td><?= h($materiel->consignes) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($materiel->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dimension') ?></th>
            <td><?= $this->Number->format($materiel->dimension) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Poids') ?></th>
            <td><?= $this->Number->format($materiel->poids) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Variation Stok') ?></th>
            <td><?= $this->Number->format($materiel->variation_stok) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($materiel->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($materiel->modified) ?></td>
        </tr>
    </table>
</div>
