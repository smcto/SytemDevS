<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesPreference $devisFacturesPreference
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $devisFacturesPreference->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesPreference->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List DevisFactures Preferences'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Adresses'), ['controller' => 'Adresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Adress'), ['controller' => 'Adresses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesPreferences form large-9 medium-8 columns content">
    <?= $this->Form->create($devisFacturesPreference) ?>
    <fieldset>
        <legend><?= __('Edit DevisFactures Preference') ?></legend>
        <?php
            echo $this->Form->control('moyen_reglements');
            echo $this->Form->control('delai_reglements');
            echo $this->Form->control('info_bancaire_id');
            echo $this->Form->control('accompte_value');
            echo $this->Form->control('accompte_unity');
            echo $this->Form->control('is_text_loi_displayed');
            echo $this->Form->control('text_loi');
            echo $this->Form->control('note');
            echo $this->Form->control('adress_id', ['options' => $adresses, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
