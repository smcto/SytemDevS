<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesAntenne $devisFacturesAntenne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit DevisFactures Antenne'), ['action' => 'edit', $devisFacturesAntenne->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete DevisFactures Antenne'), ['action' => 'delete', $devisFacturesAntenne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesAntenne->id)]) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures Antennes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New DevisFactures Antenne'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="devisFacturesAntennes view large-9 medium-8 columns content">
    <h3><?= h($devisFacturesAntenne->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('DevisFacture') ?></th>
            <td><?= $devisFacturesAntenne->has('devis_facture') ? $this->Html->link($devisFacturesAntenne->devis_facture->id, ['controller' => 'DevisFactures', 'action' => 'view', $devisFacturesAntenne->devis_facture->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Antenne') ?></th>
            <td><?= $devisFacturesAntenne->has('antenne') ? $this->Html->link($devisFacturesAntenne->antenne->ville_principale, ['controller' => 'Antennes', 'action' => 'view', $devisFacturesAntenne->antenne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($devisFacturesAntenne->id) ?></td>
        </tr>
    </table>
</div>
