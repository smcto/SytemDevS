<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EvenementPipeEtape $evenementPipeEtape
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $evenementPipeEtape->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $evenementPipeEtape->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Evenement Pipe Etapes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Pipe Etapes'), ['controller' => 'PipeEtapes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pipe Etape'), ['controller' => 'PipeEtapes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="evenementPipeEtapes form large-9 medium-8 columns content">
    <?= $this->Form->create($evenementPipeEtape) ?>
    <fieldset>
        <legend><?= __('Edit Evenement Pipe Etape') ?></legend>
        <?php
            echo $this->Form->control('pipe_etape_id', ['options' => $pipeEtapes]);
            echo $this->Form->control('evenement_id', ['options' => $evenements]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
