<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailsHasUser $emailsHasUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $emailsHasUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $emailsHasUser->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Emails Has Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['controller' => 'Emails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Email'), ['controller' => 'Emails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailsHasUsers form large-9 medium-8 columns content">
    <?= $this->Form->create($emailsHasUser) ?>
    <fieldset>
        <legend><?= __('Edit Emails Has User') ?></legend>
        <?php
            echo $this->Form->control('email_id', ['options' => $emails, 'empty' => true]);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->control('is_expediteur');
            echo $this->Form->control('is_destinateur');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
