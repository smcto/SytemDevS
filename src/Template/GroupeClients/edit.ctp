<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GroupeClient $groupeClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $groupeClient->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $groupeClient->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Groupe Clients'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="groupeClients form large-9 medium-8 columns content">
    <?= $this->Form->create($groupeClient) ?>
    <fieldset>
        <legend><?= __('Edit Groupe Client') ?></legend>
        <?php
            echo $this->Form->control('nom');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
