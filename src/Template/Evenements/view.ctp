<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evenement $evenement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Evenement'), ['action' => 'edit', $evenement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Evenement'), ['action' => 'delete', $evenement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $evenement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Evenements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Type Evenements'), ['controller' => 'TypeEvenements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Type Evenement'), ['controller' => 'TypeEvenements', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Date Evenements'), ['controller' => 'DateEvenements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Date Evenement'), ['controller' => 'DateEvenements', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="evenements view large-9 medium-8 columns content">
    <h3><?= h($evenement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom Event') ?></th>
            <td><?= h($evenement->nom_event) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lieu Exact') ?></th>
            <td><?= h($evenement->lieu_exact) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Installation') ?></th>
            <td><?= h($evenement->type_installation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $evenement->has('client') ? $this->Html->link($evenement->client->id, ['controller' => 'Clients', 'action' => 'view', $evenement->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type Evenement') ?></th>
            <td><?= $evenement->has('type_evenement') ? $this->Html->link($evenement->type_evenement->id, ['controller' => 'TypeEvenements', 'action' => 'view', $evenement->type_evenement->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Antenne') ?></th>
            <td><?= $evenement->has('antenne') ? $this->Html->link($evenement->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $evenement->antenne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($evenement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Debut Immobilisation') ?></th>
            <td><?= h($evenement->date_debut_immobilisation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Fin Immobilisation') ?></th>
            <td><?= h($evenement->date_fin_immobilisation) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Date Evenements') ?></h4>
        <?php if (!empty($evenement->date_evenements)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Date Debut') ?></th>
                <th scope="col"><?= __('Ddate Fin') ?></th>
                <th scope="col"><?= __('Evenement Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($evenement->date_evenements as $dateEvenements): ?>
            <tr>
                <td><?= h($dateEvenements->id) ?></td>
                <td><?= h($dateEvenements->date_debut) ?></td>
                <td><?= h($dateEvenements->ddate_fin) ?></td>
                <td><?= h($dateEvenements->evenement_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DateEvenements', 'action' => 'view', $dateEvenements->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DateEvenements', 'action' => 'edit', $dateEvenements->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DateEvenements', 'action' => 'delete', $dateEvenements->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dateEvenements->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
