<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NatureEvenement $natureEvenement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Nature Evenements'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="natureEvenements form large-9 medium-8 columns content">
    <?= $this->Form->create($natureEvenement) ?>
    <fieldset>
        <legend><?= __('Add Nature Evenement') ?></legend>
        <?php
            echo $this->Form->control('type');
            echo $this->Form->control('options');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
