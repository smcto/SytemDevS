<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tva $tva
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tva'), ['action' => 'edit', $tva->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tva'), ['action' => 'delete', $tva->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tva->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tvas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tva'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tvas view large-9 medium-8 columns content">
    <h3><?= h($tva->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tva->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Valeur') ?></th>
            <td><?= $this->Number->format($tva->valeur) ?></td>
        </tr>
    </table>
</div>
