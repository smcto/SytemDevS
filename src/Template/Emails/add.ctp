<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Emails'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Emails Has Users'), ['controller' => 'EmailsHasUsers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Emails Has User'), ['controller' => 'EmailsHasUsers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emails form large-9 medium-8 columns content">
    <?= $this->Form->create($email) ?>
    <fieldset>
        <legend><?= __('Add Email') ?></legend>
        <?php
            echo $this->Form->control('objet');
            echo $this->Form->control('contenu');
            echo $this->Form->control('is_sent');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
