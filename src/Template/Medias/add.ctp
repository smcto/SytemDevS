<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Media $media
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Medias'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Actu Bornes Has Medias'), ['controller' => 'ActuBornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Actu Bornes Has Media'), ['controller' => 'ActuBornesHasMedias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Bornes Has Medias'), ['controller' => 'BornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bornes Has Media'), ['controller' => 'BornesHasMedias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Model Bornes Has Medias'), ['controller' => 'ModelBornesHasMedias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Model Bornes Has Media'), ['controller' => 'ModelBornesHasMedias', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="medias form large-9 medium-8 columns content">
    <?= $this->Form->create($media) ?>
    <fieldset>
        <legend><?= __('Add Media') ?></legend>
        <?php
            echo $this->Form->control('type');
            echo $this->Form->control('file_name');
            echo $this->Form->control('extension');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
