<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailsHasUser[]|\Cake\Collection\CollectionInterface $emailsHasUsers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Emails Has User'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailsHasUsers index large-9 medium-8 columns content">
    <h3><?= __('Emails Has Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_expediteur') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_destinateur') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailsHasUsers as $emailsHasUser): ?>
            <tr>
                <td><?= $this->Number->format($emailsHasUser->id) ?></td>
                <td><?= $emailsHasUser->has('email') ? $this->Html->link($emailsHasUser->email->id, ['controller' => 'Emails', 'action' => 'view', $emailsHasUser->email->id]) : '' ?></td>
                <td><?= $emailsHasUser->has('user') ? $this->Html->link($emailsHasUser->user->id, ['controller' => 'Users', 'action' => 'view', $emailsHasUser->user->id]) : '' ?></td>
                <td><?= h($emailsHasUser->is_expediteur) ?></td>
                <td><?= h($emailsHasUser->is_destinateur) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailsHasUser->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailsHasUser->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailsHasUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailsHasUser->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
