<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statut $statut
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Statut'), ['action' => 'edit', $statut->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Statut'), ['action' => 'delete', $statut->id], ['confirm' => __('Are you sure you want to delete # {0}?', $statut->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Statuts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Statut'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contacts'), ['controller' => 'Contacts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contact'), ['controller' => 'Contacts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="statuts view large-9 medium-8 columns content">
    <h3><?= h($statut->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titre') ?></th>
            <td><?= h($statut->titre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($statut->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Contacts') ?></h4>
        <?php if (!empty($statut->contacts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Statut Id') ?></th>
                <th scope="col"><?= __('Nom') ?></th>
                <th scope="col"><?= __('Prenom') ?></th>
                <th scope="col"><?= __('Telephone') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Date Naissance') ?></th>
                <th scope="col"><?= __('Info A Savoir') ?></th>
                <th scope="col"><?= __('Mode Renumeration') ?></th>
                <th scope="col"><?= __('Is Vehicule') ?></th>
                <th scope="col"><?= __('Modele Vehicule') ?></th>
                <th scope="col"><?= __('Nbr Borne Transportable Vehicule') ?></th>
                <th scope="col"><?= __('Commentaire Vehicule') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col"><?= __('Photo Nom') ?></th>
                <th scope="col"><?= __('Situation Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($statut->contacts as $contacts): ?>
            <tr>
                <td><?= h($contacts->id) ?></td>
                <td><?= h($contacts->statut_id) ?></td>
                <td><?= h($contacts->nom) ?></td>
                <td><?= h($contacts->prenom) ?></td>
                <td><?= h($contacts->telephone) ?></td>
                <td><?= h($contacts->email) ?></td>
                <td><?= h($contacts->date_naissance) ?></td>
                <td><?= h($contacts->info_a_savoir) ?></td>
                <td><?= h($contacts->mode_renumeration) ?></td>
                <td><?= h($contacts->is_vehicule) ?></td>
                <td><?= h($contacts->modele_vehicule) ?></td>
                <td><?= h($contacts->nbr_borne_transportable_vehicule) ?></td>
                <td><?= h($contacts->commentaire_vehicule) ?></td>
                <td><?= h($contacts->antenne_id) ?></td>
                <td><?= h($contacts->photo_nom) ?></td>
                <td><?= h($contacts->situation_id) ?></td>
                <td><?= h($contacts->created) ?></td>
                <td><?= h($contacts->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Contacts', 'action' => 'view', $contacts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Contacts', 'action' => 'edit', $contacts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Contacts', 'action' => 'delete', $contacts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contacts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
