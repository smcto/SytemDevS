<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DevisFacturesAntenne $devisFacturesAntenne
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $devisFacturesAntenne->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $devisFacturesAntenne->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List DevisFactures Antennes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List DevisFactures'), ['controller' => 'DevisFactures', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New DevisFacture'), ['controller' => 'DevisFactures', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Antennes'), ['controller' => 'Antennes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Antenne'), ['controller' => 'Antennes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="devisFacturesAntennes form large-9 medium-8 columns content">
    <?= $this->Form->create($devisFacturesAntenne) ?>
    <fieldset>
        <legend><?= __('Edit DevisFactures Antenne') ?></legend>
        <?php
            echo $this->Form->control('devisFacture_id', ['options' => $devisFactures]);
            echo $this->Form->control('antenne_id', ['options' => $antennes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
