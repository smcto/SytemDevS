<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fichier $fichier
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Fichier'), ['action' => 'edit', $fichier->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Fichier'), ['action' => 'delete', $fichier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fichier->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fichiers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fichier'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Actu Bornes'), ['controller' => 'ActuBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Actu Borne'), ['controller' => 'ActuBornes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fichiers view large-9 medium-8 columns content">
    <h3><?= h($fichier->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom Fichier') ?></th>
            <td><?= h($fichier->nom_fichier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chemin') ?></th>
            <td><?= h($fichier->chemin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom Origine') ?></th>
            <td><?= h($fichier->nom_origine) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Antenne') ?></th>
            <td><?= $fichier->has('antenne') ? $this->Html->link($fichier->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $fichier->antenne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Post') ?></th>
            <td><?= $fichier->has('post') ? $this->Html->link($fichier->post->id, ['controller' => 'Posts', 'action' => 'view', $fichier->post->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Actu Borne') ?></th>
            <td><?= $fichier->has('actu_borne') ? $this->Html->link($fichier->actu_borne->id, ['controller' => 'ActuBornes', 'action' => 'view', $fichier->actu_borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Borne') ?></th>
            <td><?= $fichier->has('model_borne') ? $this->Html->link($fichier->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $fichier->model_borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fichier->id) ?></td>
        </tr>
    </table>
</div>
