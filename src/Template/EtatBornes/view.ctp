<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne $etatBorne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Etat Borne'), ['action' => 'edit', $etatBorne->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Etat Borne'), ['action' => 'delete', $etatBorne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $etatBorne->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Etat Bornes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Etat Borne'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="etatBornes view large-9 medium-8 columns content">
    <h3><?= h($etatBorne->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Etat General') ?></th>
            <td><?= h($etatBorne->etat_general) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($etatBorne->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($etatBorne->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($etatBorne->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Bornes') ?></h4>
        <?php if (!empty($etatBorne->bornes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Numero') ?></th>
                <th scope="col"><?= __('Couleur Possible Id') ?></th>
                <th scope="col"><?= __('Expiration Sb') ?></th>
                <th scope="col"><?= __('Commentaire') ?></th>
                <th scope="col"><?= __('Is Prette') ?></th>
                <th scope="col"><?= __('Parc Id') ?></th>
                <th scope="col"><?= __('Model Borne Id') ?></th>
                <th scope="col"><?= __('Date Arrive Estime') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Etat Borne Id') ?></th>
                <th scope="col"><?= __('Ville') ?></th>
                <th scope="col"><?= __('Long') ?></th>
                <th scope="col"><?= __('Lat') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Teamviewer Remotecontrol Id') ?></th>
                <th scope="col"><?= __('Teamviewer Password') ?></th>
                <th scope="col"><?= __('Teamviewer Device Id') ?></th>
                <th scope="col"><?= __('Teamviewer Group Id') ?></th>
                <th scope="col"><?= __('Teamviewer Alias') ?></th>
                <th scope="col"><?= __('Teamviewer Online State') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($etatBorne->bornes as $bornes): ?>
            <tr>
                <td><?= h($bornes->id) ?></td>
                <td><?= h($bornes->numero) ?></td>
                <td><?= h($bornes->couleur_possible_id) ?></td>
                <td><?= h($bornes->expiration_sb) ?></td>
                <td><?= h($bornes->commentaire) ?></td>
                <td><?= h($bornes->is_prette) ?></td>
                <td><?= h($bornes->parc_id) ?></td>
                <td><?= h($bornes->model_borne_id) ?></td>
                <td><?= h($bornes->date_arrive_estime) ?></td>
                <td><?= h($bornes->antenne_id) ?></td>
                <td><?= h($bornes->client_id) ?></td>
                <td><?= h($bornes->etat_borne_id) ?></td>
                <td><?= h($bornes->ville) ?></td>
                <td><?= h($bornes->long) ?></td>
                <td><?= h($bornes->lat) ?></td>
                <td><?= h($bornes->created) ?></td>
                <td><?= h($bornes->modified) ?></td>
                <td><?= h($bornes->teamviewer_remotecontrol_id) ?></td>
                <td><?= h($bornes->teamviewer_password) ?></td>
                <td><?= h($bornes->teamviewer_device_id) ?></td>
                <td><?= h($bornes->teamviewer_group_id) ?></td>
                <td><?= h($bornes->teamviewer_alias) ?></td>
                <td><?= h($bornes->teamviewer_online_state) ?></td>
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
</div>
