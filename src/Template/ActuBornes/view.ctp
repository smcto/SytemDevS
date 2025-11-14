<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActuBorne $actuBorne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Actu Borne'), ['action' => 'edit', $actuBorne->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Actu Borne'), ['action' => 'delete', $actuBorne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $actuBorne->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Actu Bornes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Actu Borne'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Actu Bornes Has Medias'), ['controller' => 'ActuBornesHasMedias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Actu Bornes Has Media'), ['controller' => 'ActuBornesHasMedias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="actuBornes view large-9 medium-8 columns content">
    <h3><?= h($actuBorne->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titre') ?></th>
            <td><?= h($actuBorne->titre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photos') ?></th>
            <td><?= h($actuBorne->photos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Borne') ?></th>
            <td><?= $actuBorne->has('borne') ? $this->Html->link($actuBorne->borne->id, ['controller' => 'Bornes', 'action' => 'view', $actuBorne->borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($actuBorne->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($actuBorne->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($actuBorne->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Contenu') ?></h4>
        <?= $this->Text->autoParagraph(h($actuBorne->contenu)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Actu Bornes Has Medias') ?></h4>
        <?php if (!empty($actuBorne->actu_bornes_has_medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Actu Borne Id') ?></th>
                <th scope="col"><?= __('Media Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($actuBorne->actu_bornes_has_medias as $actuBornesHasMedias): ?>
            <tr>
                <td><?= h($actuBornesHasMedias->actu_borne_id) ?></td>
                <td><?= h($actuBornesHasMedias->media_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ActuBornesHasMedias', 'action' => 'view', $actuBornesHasMedias->actu_borne_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ActuBornesHasMedias', 'action' => 'edit', $actuBornesHasMedias->actu_borne_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ActuBornesHasMedias', 'action' => 'delete', $actuBornesHasMedias->actu_borne_id], ['confirm' => __('Are you sure you want to delete # {0}?', $actuBornesHasMedias->actu_borne_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
