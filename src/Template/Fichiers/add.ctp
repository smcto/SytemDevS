<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fichier $fichier
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Fichiers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Posts'), ['controller' => 'Posts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Post'), ['controller' => 'Posts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Actu Bornes'), ['controller' => 'ActuBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Actu Borne'), ['controller' => 'ActuBornes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes'), ['controller' => 'ModelBornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Borne'), ['controller' => 'ModelBornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fichiers form large-9 medium-8 columns content">
    <?= $this->Form->create($fichier) ?>
    <fieldset>
        <legend><?= __('Add Fichier') ?></legend>
        <?php
            echo $this->Form->control('nom_fichier');
            echo $this->Form->control('chemin');
            echo $this->Form->control('nom_origine');
            echo $this->Form->control('antenne_id', ['options' => $antennes, 'empty' => true]);
            echo $this->Form->control('post_id', ['options' => $posts, 'empty' => true]);
            echo $this->Form->control('actu_borne_id', ['options' => $actuBornes, 'empty' => true]);
            echo $this->Form->control('model_borne_id', ['options' => $modelBornes, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
