<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeInstallation $typeInstallation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Installation'), ['action' => 'edit', $typeInstallation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Installation'), ['action' => 'delete', $typeInstallation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeInstallation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Installations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Installation'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeInstallations view large-9 medium-8 columns content">
    <h3><?= h($typeInstallation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($typeInstallation->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeInstallation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $this->Number->format($typeInstallation->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($typeInstallation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($typeInstallation->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Commentaire') ?></h4>
        <?= $this->Text->autoParagraph(h($typeInstallation->commentaire)); ?>
    </div>
</div>
