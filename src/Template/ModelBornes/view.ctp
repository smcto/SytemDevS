<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ModelBorne $modelBorne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Model Borne'), ['action' => 'edit', $modelBorne->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Model Borne'), ['action' => 'delete', $modelBorne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modelBorne->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes Has Medias'), ['controller' => 'ModelBornesHasMedias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Bornes Has Media'), ['controller' => 'ModelBornesHasMedias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="modelBornes view large-9 medium-8 columns content">
    <h3><?= h($modelBorne->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($modelBorne->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Version') ?></th>
            <td><?= h($modelBorne->version) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($modelBorne->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Ecran') ?></th>
            <td><?= h($modelBorne->taille_ecran) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modele Imprimante') ?></th>
            <td><?= h($modelBorne->modele_imprimante) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Appareil Photo') ?></th>
            <td><?= h($modelBorne->model_appareil_photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note Complementaire') ?></th>
            <td><?= h($modelBorne->note_complementaire) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($modelBorne->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Sortie') ?></th>
            <td><?= h($modelBorne->date_sortie) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Bornes') ?></h4>
        <?php if (!empty($modelBorne->bornes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Numero') ?></th>
                <th scope="col"><?= __('Couleur') ?></th>
                <th scope="col"><?= __('Expiration Sb') ?></th>
                <th scope="col"><?= __('Commentaire') ?></th>
                <th scope="col"><?= __('Is Prette') ?></th>
                <th scope="col"><?= __('Parc Id') ?></th>
                <th scope="col"><?= __('Model Borne Id') ?></th>
                <th scope="col"><?= __('Date Arrive Estime') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Ville') ?></th>
                <th scope="col"><?= __('Long') ?></th>
                <th scope="col"><?= __('Lat') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($modelBorne->bornes as $bornes): ?>
            <tr>
                <td><?= h($bornes->id) ?></td>
                <td><?= h($bornes->numero) ?></td>
                <td><?= h($bornes->couleur) ?></td>
                <td><?= h($bornes->expiration_sb) ?></td>
                <td><?= h($bornes->commentaire) ?></td>
                <td><?= h($bornes->is_prette) ?></td>
                <td><?= h($bornes->parc_id) ?></td>
                <td><?= h($bornes->model_borne_id) ?></td>
                <td><?= h($bornes->date_arrive_estime) ?></td>
                <td><?= h($bornes->antenne_id) ?></td>
                <td><?= h($bornes->client_id) ?></td>
                <td><?= h($bornes->ville) ?></td>
                <td><?= h($bornes->long) ?></td>
                <td><?= h($bornes->lat) ?></td>
                <td><?= h($bornes->created) ?></td>
                <td><?= h($bornes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Bornes', 'action' => 'view', $bornes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Bornes', 'action' => 'edit', $bornes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Bornes', 'action' => 'delete', $bornes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bornes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Model Bornes Has Medias') ?></h4>
        <?php if (!empty($modelBorne->model_bornes_has_medias)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Model Borne Id') ?></th>
                <th scope="col"><?= __('Media Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($modelBorne->model_bornes_has_medias as $modelBornesHasMedias): ?>
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
