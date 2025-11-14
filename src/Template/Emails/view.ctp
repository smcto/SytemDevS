<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email'), ['action' => 'edit', $email->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email'), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Emails'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Emails Has Users'), ['controller' => 'EmailsHasUsers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Emails Has User'), ['controller' => 'EmailsHasUsers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emails view large-9 medium-8 columns content">
    <h3><?= h($email->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Objet') ?></th>
            <td><?= h($email->objet) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($email->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($email->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($email->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Sent') ?></th>
            <td><?= $email->is_sent ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Contenu') ?></h4>
        <?= $this->Text->autoParagraph(h($email->contenu)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Emails Has Users') ?></h4>
        <?php if (!empty($email->emails_has_users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Is Expediteur') ?></th>
                <th scope="col"><?= __('Is Destinateur') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($email->emails_has_users as $emailsHasUsers): ?>
            <tr>
                <td><?= h($emailsHasUsers->id) ?></td>
                <td><?= h($emailsHasUsers->email_id) ?></td>
                <td><?= h($emailsHasUsers->user_id) ?></td>
                <td><?= h($emailsHasUsers->is_expediteur) ?></td>
                <td><?= h($emailsHasUsers->is_destinateur) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmailsHasUsers', 'action' => 'view', $emailsHasUsers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailsHasUsers', 'action' => 'edit', $emailsHasUsers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailsHasUsers', 'action' => 'delete', $emailsHasUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailsHasUsers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
