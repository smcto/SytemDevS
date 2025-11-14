<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fichier[]|\Cake\Collection\CollectionInterface $fichiers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Fichier'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Actu Bornes'), ['controller' => 'ActuBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Actu Borne'), ['controller' => 'ActuBornes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fichiers index large-9 medium-8 columns content">
    <h3><?= __('Fichiers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_fichier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('chemin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_origine') ?></th>
                <th scope="col"><?= $this->Paginator->sort('antenne_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('post_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('actu_borne_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model_borne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fichiers as $fichier): ?>
            <tr>
                <td><?= $this->Number->format($fichier->id) ?></td>
                <td><?= h($fichier->nom_fichier) ?></td>
                <td><?= h($fichier->chemin) ?></td>
                <td><?= h($fichier->nom_origine) ?></td>
                <td><?= $fichier->has('antenne') ? $this->Html->link($fichier->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $fichier->antenne->id]) : '' ?></td>
                <td><?= $fichier->has('post') ? $this->Html->link($fichier->post->id, ['controller' => 'Posts', 'action' => 'view', $fichier->post->id]) : '' ?></td>
                <td><?= $fichier->has('actu_borne') ? $this->Html->link($fichier->actu_borne->id, ['controller' => 'ActuBornes', 'action' => 'view', $fichier->actu_borne->id]) : '' ?></td>
                <td><?= $fichier->has('model_borne') ? $this->Html->link($fichier->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $fichier->model_borne->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fichier->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fichier->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fichier->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
