<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccessoiresGamme $accessoiresGamme
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $accessoiresGamme->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $accessoiresGamme->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Accessoires Gammes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Accessoires'), ['controller' => 'Accessoires', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Accessoire'), ['controller' => 'Accessoires', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accessoiresGammes form large-9 medium-8 columns content">
    <?= $this->Form->create($accessoiresGamme) ?>
    <fieldset>
        <legend><?= __('Edit Accessoires Gamme') ?></legend>
        <?php
            echo $this->Form->control('accessoire_id', ['options' => $accessoires]);
            echo $this->Form->control('gamme_borne_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
