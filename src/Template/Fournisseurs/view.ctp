<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fournisseur $fournisseur
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Fournisseur'), ['action' => 'edit', $fournisseur->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Fournisseur'), ['action' => 'delete', $fournisseur->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fournisseur->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fournisseurs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fournisseur'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Type Fournisseurs'), ['controller' => 'TypeFournisseurs', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Fournisseur'), ['controller' => 'TypeFournisseurs', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fournisseurs view large-9 medium-8 columns content">
    <h3><?= h($fournisseur->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($fournisseur->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Adresse') ?></th>
            <td><?= h($fournisseur->adresse) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ville') ?></th>
            <td><?= h($fournisseur->ville) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Antenne') ?></th>
            <td><?= $fournisseur->has('antenne') ? $this->Html->link($fournisseur->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $fournisseur->antenne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Fournisseur') ?></th>
            <td><?= $fournisseur->has('type_fournisseur') ? $this->Html->link($fournisseur->type_fournisseur->id, ['controller' => 'TypeFournisseurs', 'action' => 'view', $fournisseur->type_fournisseur->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fournisseur->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cp') ?></th>
            <td><?= $this->Number->format($fournisseur->cp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($fournisseur->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($fournisseur->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($fournisseur->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Commentaire') ?></h4>
        <?= $this->Text->autoParagraph(h($fournisseur->commentaire)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($fournisseur->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col"><?= __('Fournisseur Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($fournisseur->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->client_id) ?></td>
                <td><?= h($users->antenne_id) ?></td>
                <td><?= h($users->fournisseur_id) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
