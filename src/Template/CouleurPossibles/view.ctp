<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CouleurPossible $couleurPossible
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Couleur Possible'), ['action' => 'edit', $couleurPossible->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Couleur Possible'), ['action' => 'delete', $couleurPossible->id], ['confirm' => __('Are you sure you want to delete # {0}?', $couleurPossible->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Couleur Possibles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Couleur Possible'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="couleurPossibles view large-9 medium-8 columns content">
    <h3><?= h($couleurPossible->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Couleur') ?></th>
            <td><?= h($couleurPossible->couleur) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($couleurPossible->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Borne Id') ?></th>
            <td><?= $this->Number->format($couleurPossible->model_borne_id) ?></td>
        </tr>
    </table>
</div>
