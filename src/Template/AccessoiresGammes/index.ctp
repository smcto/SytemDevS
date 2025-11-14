<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccessoiresGamme[]|\Cake\Collection\CollectionInterface $accessoiresGammes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Accessoires Gamme'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accessoires'), ['controller' => 'Accessoires', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accessoire'), ['controller' => 'Accessoires', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accessoiresGammes index large-9 medium-8 columns content">
    <h3><?= __('Accessoires Gammes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('accessoire_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gamme_borne_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accessoiresGammes as $accessoiresGamme): ?>
            <tr>
                <td><?= $this->Number->format($accessoiresGamme->id) ?></td>
                <td><?= $accessoiresGamme->has('accessoire') ? $this->Html->link($accessoiresGamme->accessoire->id, ['controller' => 'Accessoires', 'action' => 'view', $accessoiresGamme->accessoire->id]) : '' ?></td>
                <td><?= $this->Number->format($accessoiresGamme->gamme_borne_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $accessoiresGamme->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accessoiresGamme->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accessoiresGamme->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessoiresGamme->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->element('tfoot_pagination') ?>
</div>
