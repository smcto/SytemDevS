<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentsModelBorne $documentsModelBorne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $documentsModelBorne->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $documentsModelBorne->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Documents Model Bornes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentsModelBornes form large-9 medium-8 columns content">
    <?= $this->Form->create($documentsModelBorne) ?>
    <fieldset>
        <legend><?= __('Edit Documents Model Borne') ?></legend>
        <?php
            echo $this->Form->control('nom_fichier');
            echo $this->Form->control('titre');
            echo $this->Form->control('description');
            echo $this->Form->control('chemin');
            echo $this->Form->control('nom_origine');
            echo $this->Form->control('model_borne_id', ['options' => $modelBornes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
