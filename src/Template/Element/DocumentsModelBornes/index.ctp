<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentsModelBorne[]|\Cake\Collection\CollectionInterface $documentsModelBornes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Documents Model Borne'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentsModelBornes index large-9 medium-8 columns content">
    <h3><?= __('Documents Model Bornes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_fichier') ?></th>
                <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('chemin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom_origine') ?></th>
                <th scope="col"><?= $this->Paginator->sort('model_borne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentsModelBornes as $documentsModelBorne): ?>
            <tr>
                <td><?= $this->Number->format($documentsModelBorne->id) ?></td>
                <td><?= h($documentsModelBorne->nom_fichier) ?></td>
                <td><?= h($documentsModelBorne->titre) ?></td>
                <td><?= h($documentsModelBorne->chemin) ?></td>
                <td><?= h($documentsModelBorne->nom_origine) ?></td>
                <td><?= $documentsModelBorne->has('model_borne') ? $this->Html->link($documentsModelBorne->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $documentsModelBorne->model_borne->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $documentsModelBorne->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $documentsModelBorne->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $documentsModelBorne->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
