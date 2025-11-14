<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Accessoire $accessoire
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Accessoire'), ['action' => 'edit', $accessoire->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Accessoire'), ['action' => 'delete', $accessoire->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessoire->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accessoires'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accessoire'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accessoires Gammes'), ['controller' => 'AccessoiresGammes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Accessoires Gamme'), ['controller' => 'AccessoiresGammes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accessoires view large-9 medium-8 columns content">
    <h3><?= h($accessoire->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($accessoire->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($accessoire->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($accessoire->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Accessoires Gammes') ?></h4>
        <?php if (!empty($accessoire->accessoires_gammes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Accessoire Id') ?></th>
                <th scope="col"><?= __('Gamme Borne Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($accessoire->accessoires_gammes as $accessoiresGammes): ?>
            <tr>
                <td><?= h($accessoiresGammes->id) ?></td>
                <td><?= h($accessoiresGammes->accessoire_id) ?></td>
                <td><?= h($accessoiresGammes->gamme_borne_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AccessoiresGammes', 'action' => 'view', $accessoiresGammes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AccessoiresGammes', 'action' => 'edit', $accessoiresGammes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccessoiresGammes', 'action' => 'delete', $accessoiresGammes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accessoiresGammes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
