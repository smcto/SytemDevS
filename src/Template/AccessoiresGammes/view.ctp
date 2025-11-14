<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccessoiresGamme $accessoiresGamme
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Accessoires Gamme'), ['action' => 'edit', $accessoiresGamme->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accessoires Gamme'), ['action' => 'delete', $accessoiresGamme->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessoiresGamme->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accessoires Gammes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accessoires Gamme'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accessoires'), ['controller' => 'Accessoires', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accessoire'), ['controller' => 'Accessoires', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accessoiresGammes view large-9 medium-8 columns content">
    <h3><?= h($accessoiresGamme->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Accessoire') ?></th>
            <td><?= $accessoiresGamme->has('accessoire') ? $this->Html->link($accessoiresGamme->accessoire->id, ['controller' => 'Accessoires', 'action' => 'view', $accessoiresGamme->accessoire->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($accessoiresGamme->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gamme Borne Id') ?></th>
            <td><?= $this->Number->format($accessoiresGamme->gamme_borne_id) ?></td>
        </tr>
    </table>
</div>
