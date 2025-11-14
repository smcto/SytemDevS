<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LieuType $lieuType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Lieu Type'), ['action' => 'edit', $lieuType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Lieu Type'), ['action' => 'delete', $lieuType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lieuType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Lieu Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Lieu Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="lieuTypes view large-9 medium-8 columns content">
    <h3><?= h($lieuType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($lieuType->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($lieuType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($lieuType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($lieuType->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Antennes') ?></h4>
        <?php if (!empty($lieuType->antennes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Lieu Type Id') ?></th>
                <th scope="col"><?= __('Ville Principale') ?></th>
                <th scope="col"><?= __('Ville Excate') ?></th>
                <th scope="col"><?= __('Adresse') ?></th>
                <th scope="col"><?= __('Cp') ?></th>
                <th scope="col"><?= __('Long') ?></th>
                <th scope="col"><?= __('Lat') ?></th>
                <th scope="col"><?= __('Precision Lieu') ?></th>
                <th scope="col"><?= __('Commentaire') ?></th>
                <th scope="col"><?= __('Etat Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($lieuType->antennes as $antennes): ?>
            <tr>
                <td><?= h($antennes->id) ?></td>
                <td><?= h($antennes->lieu_type_id) ?></td>
                <td><?= h($antennes->ville_principale) ?></td>
                <td><?= h($antennes->ville_excate) ?></td>
                <td><?= h($antennes->adresse) ?></td>
                <td><?= h($antennes->cp) ?></td>
                <td><?= h($antennes->long) ?></td>
                <td><?= h($antennes->lat) ?></td>
                <td><?= h($antennes->precision_lieu) ?></td>
                <td><?= h($antennes->commentaire) ?></td>
                <td><?= h($antennes->etat_id) ?></td>
                <td><?= h($antennes->created) ?></td>
                <td><?= h($antennes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Antennes', 'action' => 'view', $antennes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Antennes', 'action' => 'edit', $antennes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Antennes', 'action' => 'delete', $antennes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $antennes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
