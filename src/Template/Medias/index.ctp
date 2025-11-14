<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media[]|\Cake\Collection\CollectionInterface $medias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Media'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Actu Bornes Has Medias'), ['controller' => 'ActuBornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Actu Bornes Has Media'), ['controller' => 'ActuBornesHasMedias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes Has Medias'), ['controller' => 'BornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bornes Has Media'), ['controller' => 'BornesHasMedias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes Has Medias'), ['controller' => 'ModelBornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Bornes Has Media'), ['controller' => 'ModelBornesHasMedias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="medias index large-9 medium-8 columns content">
    <h3><?= __('Medias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('extension') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medias as $media): ?>
            <tr>
                <td><?= $this->Number->format($media->id) ?></td>
                <td><?= h($media->type) ?></td>
                <td><?= h($media->file_name) ?></td>
                <td><?= h($media->extension) ?></td>
                <td><?= h($media->created) ?></td>
                <td><?= h($media->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $media->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $media->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $media->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
