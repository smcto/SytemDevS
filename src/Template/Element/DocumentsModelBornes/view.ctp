<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentsModelBorne $documentsModelBorne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Documents Model Borne'), ['action' => 'edit', $documentsModelBorne->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Documents Model Borne'), ['action' => 'delete', $documentsModelBorne->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentsModelBorne->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents Model Bornes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Documents Model Borne'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documentsModelBornes view large-9 medium-8 columns content">
    <h3><?= h($documentsModelBorne->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nom Fichier') ?></th>
            <td><?= h($documentsModelBorne->nom_fichier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Titre') ?></th>
            <td><?= h($documentsModelBorne->titre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Chemin') ?></th>
            <td><?= h($documentsModelBorne->chemin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nom Origine') ?></th>
            <td><?= h($documentsModelBorne->nom_origine) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Model Borne') ?></th>
            <td><?= $documentsModelBorne->has('model_borne') ? $this->Html->link($documentsModelBorne->model_borne->id, ['controller' => 'ModelBornes', 'action' => 'view', $documentsModelBorne->model_borne->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($documentsModelBorne->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($documentsModelBorne->description)); ?>
    </div>
</div>
