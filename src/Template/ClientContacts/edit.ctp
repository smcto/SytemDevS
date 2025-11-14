<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientContact $clientContact
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientContact->contaid],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientContact->contaid)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Contacts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientContacts form large-9 medium-8 columns content">
    <?= $this->Form->create($clientContact) ?>
    <fieldset>
        <legend><?= __('Edit Client Contact') ?></legend>
        <?php
            echo $this->Form->control('id');
            echo $this->Form->control('nom');
            echo $this->Form->control('prenom');
            echo $this->Form->control('position');
            echo $this->Form->control('email');
            echo $this->Form->control('tel');
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('id_in_sellsy');
            echo $this->Form->control('deleted_in_sellsy');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
