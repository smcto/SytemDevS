<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Logiciel $logiciel
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Logiciel'), ['action' => 'edit', $logiciel->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Logiciel'), ['action' => 'delete', $logiciel->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logiciel->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logiciels'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Logiciel'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Borne Logiciels'), ['controller' => 'BorneLogiciels', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Borne Logiciel'), ['controller' => 'BorneLogiciels', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="logiciels view large-9 medium-8 columns content">
    <h3><?= h($logiciel->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($logiciel->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($logiciel->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($logiciel->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($logiciel->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Borne Logiciels') ?></h4>
        <?php if (!empty($logiciel->borne_logiciels)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Borne Id') ?></th>
                <th scope="col"><?= __('Logiciel Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($logiciel->borne_logiciels as $borneLogiciels): ?>
            <tr>
                <td><?= h($borneLogiciels->borne_id) ?></td>
                <td><?= h($borneLogiciels->logiciel_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BorneLogiciels', 'action' => 'view', $borneLogiciels->borne_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BorneLogiciels', 'action' => 'edit', $borneLogiciels->borne_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BorneLogiciels', 'action' => 'delete', $borneLogiciels->borne_id], ['confirm' => __('Are you sure you want to delete # {0}?', $borneLogiciels->borne_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
