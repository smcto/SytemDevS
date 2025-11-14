<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GroupeClient $groupeClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Groupe Client'), ['action' => 'edit', $groupeClient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Groupe Client'), ['action' => 'delete', $groupeClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupeClient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Groupe Clients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Groupe Client'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="groupeClients view large-9 medium-8 columns content">
    <h3><?= h($groupeClient->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($groupeClient->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($groupeClient->id) ?></td>
        </tr>
    </table>
</div>
