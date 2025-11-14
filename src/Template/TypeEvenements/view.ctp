<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TypeEvenement $typeEvenement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Type Evenement'), ['action' => 'edit', $typeEvenement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Type Evenement'), ['action' => 'delete', $typeEvenement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $typeEvenement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Type Evenements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Evenement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="typeEvenements view large-9 medium-8 columns content">
    <h3><?= h($typeEvenement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom') ?></th>
            <td><?= h($typeEvenement->nom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($typeEvenement->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($typeEvenement->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Evenements') ?></h4>
        <?php if (!empty($typeEvenement->evenements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Nom Event') ?></th>
                <th scope="col"><?= __('Lieu Exact') ?></th>
                <th scope="col"><?= __('Date Debut Immobilisation') ?></th>
                <th scope="col"><?= __('Date Fin Immobilisation') ?></th>
                <th scope="col"><?= __('Type Installation') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Type Evenement Id') ?></th>
                <th scope="col"><?= __('Antenne Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($typeEvenement->evenements as $evenements): ?>
            <tr>
                <td><?= h($evenements->id) ?></td>
                <td><?= h($evenements->nom_event) ?></td>
                <td><?= h($evenements->lieu_exact) ?></td>
                <td><?= h($evenements->date_debut_immobilisation) ?></td>
                <td><?= h($evenements->date_fin_immobilisation) ?></td>
                <td><?= h($evenements->type_installation) ?></td>
                <td><?= h($evenements->client_id) ?></td>
                <td><?= h($evenements->type_evenement_id) ?></td>
                <td><?= h($evenements->antenne_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Evenements', 'action' => 'view', $evenements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Evenements', 'action' => 'edit', $evenements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Evenements', 'action' => 'delete', $evenements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evenements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
