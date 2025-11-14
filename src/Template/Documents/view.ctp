<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documents view large-9 medium-8 columns content">
    <h3><?= h($document->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type Document') ?></th>
            <td><?= h($document->type_document) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $document->has('client') ? $this->Html->link($document->client->id, ['controller' => 'Clients', 'action' => 'view', $document->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Statut') ?></th>
            <td><?= h($document->statut) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Objet') ?></th>
            <td><?= h($document->objet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($document->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Montant Ht') ?></th>
            <td><?= h($document->montant_ht) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Montant Ttc') ?></th>
            <td><?= h($document->montant_ttc) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($document->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id In Sellsy') ?></th>
            <td><?= $this->Number->format($document->id_in_sellsy) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($document->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($document->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($document->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted In Sellsy') ?></th>
            <td><?= $document->deleted_in_sellsy ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Url Sellsy') ?></h4>
        <?= $this->Text->autoParagraph(h($document->url_sellsy)); ?>
    </div>
</div>
