<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MoyenReglement $moyenReglement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Moyen Reglement'), ['action' => 'edit', $moyenReglement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Moyen Reglement'), ['action' => 'delete', $moyenReglement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $moyenReglement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Moyen Reglements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Moyen Reglement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reglements'), ['controller' => 'Reglements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reglement'), ['controller' => 'Reglements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="moyenReglements view large-9 medium-8 columns content">
    <h3><?= h($moyenReglement->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($moyenReglement->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($moyenReglement->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Reglements') ?></h4>
        <?php if (!empty($moyenReglement->reglements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Moyen Reglement Id') ?></th>
                <th scope="col"><?= __('Montant') ?></th>
                <th scope="col"><?= __('Reference') ?></th>
                <th scope="col"><?= __('Note') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($moyenReglement->reglements as $reglements): ?>
            <tr>
                <td><?= h($reglements->id) ?></td>
                <td><?= h($reglements->type) ?></td>
                <td><?= h($reglements->client_id) ?></td>
                <td><?= h($reglements->date) ?></td>
                <td><?= h($reglements->moyen_reglement_id) ?></td>
                <td><?= h($reglements->montant) ?></td>
                <td><?= h($reglements->reference) ?></td>
                <td><?= h($reglements->note) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Reglements', 'action' => 'view', $reglements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Reglements', 'action' => 'edit', $reglements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reglements', 'action' => 'delete', $reglements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reglements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
