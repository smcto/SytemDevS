<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailsHasUser $emailsHasUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Emails Has User'), ['action' => 'edit', $emailsHasUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Emails Has User'), ['action' => 'delete', $emailsHasUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailsHasUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Emails Has Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Emails Has User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailsHasUsers view large-9 medium-8 columns content">
    <h3><?= h($emailsHasUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= $emailsHasUser->has('email') ? $this->Html->link($emailsHasUser->email->id, ['controller' => 'Emails', 'action' => 'view', $emailsHasUser->email->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $emailsHasUser->has('user') ? $this->Html->link($emailsHasUser->user->id, ['controller' => 'Users', 'action' => 'view', $emailsHasUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailsHasUser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Expediteur') ?></th>
            <td><?= $emailsHasUser->is_expediteur ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Destinateur') ?></th>
            <td><?= $emailsHasUser->is_destinateur ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
