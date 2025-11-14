<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeEquipement $typeEquipement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Equipement'), ['action' => 'edit', $typeEquipement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Equipement'), ['action' => 'delete', $typeEquipement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeEquipement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Equipements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Equipement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Equipements'), ['controller' => 'Equipements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Equipement'), ['controller' => 'Equipements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeEquipements view large-9 medium-8 columns content">
    <h3><?= h($typeEquipement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($typeEquipement->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeEquipement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($typeEquipement->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($typeEquipement->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Equipements') ?></h4>
        <?php if (!empty($typeEquipement->equipements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Type Equipement Id') ?></th>
                <th scope="col"><?= __('Valeur') ?></th>
                <th scope="col"><?= __('Commentaire') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($typeEquipement->equipements as $equipements): ?>
            <tr>
                <td><?= h($equipements->id) ?></td>
                <td><?= h($equipements->type_equipement_id) ?></td>
                <td><?= h($equipements->valeur) ?></td>
                <td><?= h($equipements->commentaire) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Equipements', 'action' => 'view', $equipements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Equipements', 'action' => 'edit', $equipements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Equipements', 'action' => 'delete', $equipements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
