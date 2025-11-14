<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MessageTypeFacture $messageTypeFacture
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message Type Facture'), ['action' => 'edit', $messageTypeFacture->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message Type Facture'), ['action' => 'delete', $messageTypeFacture->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messageTypeFacture->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Message Type Factures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message Type Facture'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Etat Factures'), ['controller' => 'EtatFactures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Etat Facture'), ['controller' => 'EtatFactures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Factures'), ['controller' => 'Factures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facture'), ['controller' => 'Factures', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messageTypeFactures view large-9 medium-8 columns content">
    <h3><?= h($messageTypeFacture->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Etat Facture') ?></th>
            <td><?= $messageTypeFacture->has('etat_facture') ? $this->Html->link($messageTypeFacture->etat_facture->id, ['controller' => 'EtatFactures', 'action' => 'view', $messageTypeFacture->etat_facture->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($messageTypeFacture->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($messageTypeFacture->message)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Factures') ?></h4>
        <?php if (!empty($messageTypeFacture->factures)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Titre') ?></th>
                <th scope="col"><?= __('Montant') ?></th>
                <th scope="col"><?= __('Nom Fichier') ?></th>
                <th scope="col"><?= __('Nom Origine') ?></th>
                <th scope="col"><?= __('Etat') ?></th>
                <th scope="col"><?= __('Commentaire') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Etat Fatcure Id') ?></th>
                <th scope="col"><?= __('Message Type Facture Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($messageTypeFacture->factures as $factures): ?>
            <tr>
                <td><?= h($factures->id) ?></td>
                <td><?= h($factures->titre) ?></td>
                <td><?= h($factures->montant) ?></td>
                <td><?= h($factures->nom_fichier) ?></td>
                <td><?= h($factures->nom_origine) ?></td>
                <td><?= h($factures->etat) ?></td>
                <td><?= h($factures->commentaire) ?></td>
                <td><?= h($factures->created) ?></td>
                <td><?= h($factures->modified) ?></td>
                <td><?= h($factures->antenne_id) ?></td>
                <td><?= h($factures->user_id) ?></td>
                <td><?= h($factures->etat_fatcure_id) ?></td>
                <td><?= h($factures->message_type_facture_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Factures', 'action' => 'view', $factures->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Factures', 'action' => 'edit', $factures->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Factures', 'action' => 'delete', $factures->id], ['confirm' => __('Are you sure you want to delete # {0}?', $factures->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
