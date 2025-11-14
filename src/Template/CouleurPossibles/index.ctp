<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CouleurPossible[]|\Cake\Collection\CollectionInterface $couleurPossibles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Couleur Possible'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="couleurPossibles index large-9 medium-8 columns content">
    <h3><?= __('Couleur Possibles') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('couleur') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model_borne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($couleurPossibles as $couleurPossible): ?>
            <tr>
                <td><?= $this->Number->format($couleurPossible->id) ?></td>
                <td><?= h($couleurPossible->couleur) ?></td>
                <td><?= $this->Number->format($couleurPossible->model_borne_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $couleurPossible->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $couleurPossible->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $couleurPossible->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
