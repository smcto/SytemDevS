<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeProfil $typeProfil
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Profil'), ['action' => 'edit', $typeProfil->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Profil'), ['action' => 'delete', $typeProfil->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeProfil->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Profils'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Profil'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Type Profils'), ['controller' => 'UserTypeProfils', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Type Profil'), ['controller' => 'UserTypeProfils', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeProfils view large-9 medium-8 columns content">
    <h3><?= h($typeProfil->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($typeProfil->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeProfil->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($typeProfil->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($typeProfil->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related User Type Profils') ?></h4>
        <?php if (!empty($typeProfil->user_type_profils)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Type Profil Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($typeProfil->user_type_profils as $userTypeProfils): ?>
            <tr>
                <td><?= h($userTypeProfils->id) ?></td>
                <td><?= h($userTypeProfils->user_id) ?></td>
                <td><?= h($userTypeProfils->type_profil_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserTypeProfils', 'action' => 'view', $userTypeProfils->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserTypeProfils', 'action' => 'edit', $userTypeProfils->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserTypeProfils', 'action' => 'delete', $userTypeProfils->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userTypeProfils->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
