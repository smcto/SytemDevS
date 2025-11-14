<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeProfil[]|\Cake\Collection\CollectionInterface $typeProfils
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Type Profil'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List User Type Profils'), ['controller' => 'UserTypeProfils', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User Type Profil'), ['controller' => 'UserTypeProfils', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="typeProfils index large-9 medium-8 columns content">
    <h3><?= __('Type Profils') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($typeProfils as $typeProfil): ?>
            <tr>
                <td><?= $this->Number->format($typeProfil->id) ?></td>
                <td><?= h($typeProfil->nom) ?></td>
                <td><?= h($typeProfil->created) ?></td>
                <td><?= h($typeProfil->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $typeProfil->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $typeProfil->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $typeProfil->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
