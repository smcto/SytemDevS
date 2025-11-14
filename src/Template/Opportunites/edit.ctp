<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Opportunite $opportunite
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $opportunite->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $opportunite->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Opportunites'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Opportunite Statuts'), ['controller' => 'OpportuniteStatuts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Opportunite Statut'), ['controller' => 'OpportuniteStatuts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pipelines'), ['controller' => 'Pipelines', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pipeline'), ['controller' => 'Pipelines', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Pipeline Etapes'), ['controller' => 'PipelineEtapes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Pipeline Etape'), ['controller' => 'PipelineEtapes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Type Clients'), ['controller' => 'TypeClients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Type Client'), ['controller' => 'TypeClients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Source Leads'), ['controller' => 'SourceLeads', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source Lead'), ['controller' => 'SourceLeads', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contact Raisons'), ['controller' => 'ContactRaisons', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contact Raison'), ['controller' => 'ContactRaisons', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Type Evenements'), ['controller' => 'TypeEvenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Type Evenement'), ['controller' => 'TypeEvenements', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Opportunite Clients'), ['controller' => 'OpportuniteClients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Opportunite Client'), ['controller' => 'OpportuniteClients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="opportunites form large-9 medium-8 columns content">
    <?= $this->Form->create($opportunite) ?>
    <fieldset>
        <legend><?= __('Edit Opportunite') ?></legend>
        <?php
            echo $this->Form->control('id_in_sellsy');
            echo $this->Form->control('numero');
            echo $this->Form->control('nom');
            echo $this->Form->control('opportunite_statut_id', ['options' => $opportuniteStatuts, 'empty' => true]);
            echo $this->Form->control('montant_potentiel');
            echo $this->Form->control('date_echeance', ['empty' => true]);
            echo $this->Form->control('pipeline_id', ['options' => $pipelines, 'empty' => true]);
            echo $this->Form->control('pipeline_etape_id', ['options' => $pipelineEtapes, 'empty' => true]);
            echo $this->Form->control('probabilite');
            echo $this->Form->control('note');
            echo $this->Form->control('brief');
            echo $this->Form->control('type_client_id', ['options' => $typeClients, 'empty' => true]);
            echo $this->Form->control('source_lead_id', ['options' => $sourceLeads, 'empty' => true]);
            echo $this->Form->control('contact_raison_id', ['options' => $contactRaisons, 'empty' => true]);
            echo $this->Form->control('type_evenement_id', ['options' => $typeEvenements, 'empty' => true]);
            echo $this->Form->control('type_demande');
            echo $this->Form->control('antenne_retrait');
            echo $this->Form->control('antenne_retrait_secondaire');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
