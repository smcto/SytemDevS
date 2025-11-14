<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FactureSituation[]|\Cake\Collection\CollectionInterface $factureSituations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Facture Situation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Devis'), ['controller' => 'Devis', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Devi'), ['controller' => 'Devis', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Facture Situations Produits'), ['controller' => 'FactureSituationsProduits', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Facture Situations Produit'), ['controller' => 'FactureSituationsProduits', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="factureSituations index large-9 medium-8 columns content">
    <h3><?= __('Facture Situations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('indent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numero') ?></th>
                <th scope="col"><?= $this->Paginator->sort('devi_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_crea') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ref_commercial_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_ht') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_ttc') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factureSituations as $factureSituation): ?>
            <tr>
                <td><?= $this->Number->format($factureSituation->id) ?></td>
                <td><?= h($factureSituation->indent) ?></td>
                <td><?= $this->Number->format($factureSituation->numero) ?></td>
                <td><?= $factureSituation->has('devi') ? $this->Html->link($factureSituation->devi->nom_societe, ['controller' => 'Devis', 'action' => 'view', $factureSituation->devi->id]) : '' ?></td>
                <td><?= h($factureSituation->date_crea) ?></td>
                <td><?= $this->Number->format($factureSituation->ref_commercial_id) ?></td>
                <td><?= $factureSituation->has('client') ? $this->Html->link($factureSituation->client->nom, ['controller' => 'Clients', 'action' => 'view', $factureSituation->client->id]) : '' ?></td>
                <td><?= $this->Number->format($factureSituation->total_ht) ?></td>
                <td><?= $this->Number->format($factureSituation->total_ttc) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $factureSituation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $factureSituation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $factureSituation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $factureSituation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
