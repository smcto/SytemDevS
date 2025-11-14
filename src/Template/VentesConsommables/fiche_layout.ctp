<?php $this->Html->css('/scss/icons/flaticon/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('/scss/icons/flaticon2/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?php $this->Html->css('ventes/fiche', ['block' => 'css']); ?>

<?php $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?php $this->Html->script('ventes/fiche', ['block' => 'script']); ?>

<?= $this->fetch('content') ?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <?= $this->fetch('consommable_statut') ?> &nbsp;
        <button type="button" class="btn btn-primary btn-rounded change-state" data-consommable-statut="<?= $ventesConsommable->consommable_statut ?>" data-id="<?= $ventesConsommable->id ?>" data-action="<?= $this->Url->build(['action' => 'majState', $ventesConsommable->id]) ?>" data-toggle="modal" data-target="#change-state" data-bondelivraison="<?= $this->Url->build($ventesConsommable->get('bon_de_livraison_path')) ?>">Etat facturation</button>
        <a href="<?= $this->Url->build(['action' => 'add', $ventesConsommable->id]) ?>" class="btn btn-rounded btn-primary">Modifier commande</a>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-rounded btn-inverse">Quitter</a>
    </div>
<?php $this->end() ?>