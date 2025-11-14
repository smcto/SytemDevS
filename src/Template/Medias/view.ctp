<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media $media
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Media'), ['action' => 'edit', $media->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Media'), ['action' => 'delete', $media->id], ['confirm' => __('Are you sure you want to delete # {0}?', $media->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Medias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Media'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Actu Bornes Has Medias'), ['controller' => 'ActuBornesHasMedias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Actu Bornes Has Media'), ['controller' => 'ActuBornesHasMedias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bornes Has Medias'), ['controller' => 'BornesHasMedias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bornes Has Media'), ['controller' => 'BornesHasMedias', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes Has Medias'), ['controller' => 'ModelBornesHasMedias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Bornes Has Media'), ['controller' => 'ModelBornesHasMedias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="medias view large-9 medium-8 columns content">
    <h3><?= h($media->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($media->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Name') ?></th>
            <td><?= h($media->file_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Extension') ?></th>
            <td><?= h($media->extension) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($media->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($media->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($media->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Actu Bornes Has Medias') ?></h4>
        <?php if (!empty($media->actu_bornes_has_medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Actu Borne Id') ?></th>
                <th scope="col"><?= __('Media Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($media->actu_bornes_has_medias as $actuBornesHasMedias): ?>
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
    <div class="related">
        <h4><?= __('Related Bornes Has Medias') ?></h4>
        <?php if (!empty($media->bornes_has_medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Borne Id') ?></th>
                <th scope="col"><?= __('Media Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($media->bornes_has_medias as $bornesHasMedias): ?>
            <tr>
                <td><?= h($bornesHasMedias->borne_id) ?></td>
                <td><?= h($bornesHasMedias->media_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BornesHasMedias', 'action' => 'view', $bornesHasMedias->borne_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BornesHasMedias', 'action' => 'edit', $bornesHasMedias->borne_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BornesHasMedias', 'action' => 'delete', $bornesHasMedias->borne_id], ['confirm' => __('Are you sure you want to delete # {0}?', $bornesHasMedias->borne_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Model Bornes Has Medias') ?></h4>
        <?php if (!empty($media->model_bornes_has_medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Model Borne Id') ?></th>
                <th scope="col"><?= __('Media Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($media->model_bornes_has_medias as $modelBornesHasMedias): ?>
            <tr>
                <td><?= h($modelBornesHasMedias->model_borne_id) ?></td>
                <td><?= h($modelBornesHasMedias->media_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ModelBornesHasMedias', 'action' => 'view', $modelBornesHasMedias->model_borne_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ModelBornesHasMedias', 'action' => 'edit', $modelBornesHasMedias->model_borne_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ModelBornesHasMedias', 'action' => 'delete', $modelBornesHasMedias->model_borne_id], ['confirm' => __('Are you sure you want to delete # {0}?', $modelBornesHasMedias->model_borne_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
