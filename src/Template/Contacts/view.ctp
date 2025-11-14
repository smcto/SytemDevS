<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Contact'), ['action' => 'edit', $contact->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Contact'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Contacts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contact'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Statuts'), ['controller' => 'Statuts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Statut'), ['controller' => 'Statuts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Situations'), ['controller' => 'Situations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Situation'), ['controller' => 'Situations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="contacts view large-9 medium-8 columns content">
    <h3><?= h($contact->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Statut') ?></th>
            <td><?= $contact->has('statut') ? $this->Html->link($contact->statut->id, ['controller' => 'Statuts', 'action' => 'view', $contact->statut->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($contact->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Prenom') ?></th>
            <td><?= h($contact->prenom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telephone') ?></th>
            <td><?= h($contact->telephone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($contact->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modele Vehicule') ?></th>
            <td><?= h($contact->modele_vehicule) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Antenne') ?></th>
            <td><?= $contact->has('antenne') ? $this->Html->link($contact->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $contact->antenne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo Nom') ?></th>
            <td><?= h($contact->photo_nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Situation') ?></th>
            <td><?= $contact->has('situation') ? $this->Html->link($contact->situation->id, ['controller' => 'Situations', 'action' => 'view', $contact->situation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contact->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nbr Borne Transportable Vehicule') ?></th>
            <td><?= $this->Number->format($contact->nbr_borne_transportable_vehicule) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Naissance') ?></th>
            <td><?= h($contact->date_naissance) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contact->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contact->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Vehicule') ?></th>
            <td><?= $contact->is_vehicule ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Info A Savoir') ?></h4>
        <?= $this->Text->autoParagraph(h($contact->info_a_savoir)); ?>
    </div>
    <div class="row">
        <h4><?= __('Mode Renumeration') ?></h4>
        <?= $this->Text->autoParagraph(h($contact->mode_renumeration)); ?>
    </div>
    <div class="row">
        <h4><?= __('Commentaire Vehicule') ?></h4>
        <?= $this->Text->autoParagraph(h($contact->commentaire_vehicule)); ?>
    </div>
</div>
