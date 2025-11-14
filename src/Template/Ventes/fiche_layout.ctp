<?php $this->Html->css('/scss/icons/flaticon/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('/scss/icons/flaticon2/flaticon.css', ['block' => 'css']); ?>
<?php $this->Html->css('ventes/fiche', ['block' => 'css']); ?>
<?php $this->Html->script('ventes/affectationbornes.js?'.time(), ['block' => true]); ?>


<?php $this->Html->script('ventes/fiche', ['block' => 'script']); ?>

<?= $this->element('vente/affectation_borne') ?>

<?= $this->fetch('content') ?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">

        <?= $this->fetch('etat_vente') ?>
        <button type="button" class="btn btn-primary btn-rounded change-state" data-etat-facturation="<?= $venteEntity->etat_facturation ?>" data-date-facturation="<?= $venteEntity->date_facturation ? $venteEntity->date_facturation->format('Y-m-d') : ''; ?>" data-id="<?= $venteEntity->id ?>"  data-receptionclient="<?= $venteEntity->date_reception_client ? $venteEntity->date_reception_client->format('Y-m-d') : ''; ?>" data-id="<?= $venteEntity->id ?>" data-action="<?= $this->Url->build(['action' => 'majStateBilling', $venteEntity->id]) ?>" data-toggle="modal" data-target="#change-state" data-bondelivraison="<?= $this->Url->build($venteEntity->get('bon_de_livraison_path')) ?>">Etat facturation</button>
        <a href="javascript:void(0);" class="btn-borne btn btn-primary btn-rounded" data-parcname="<?=$venteEntity->parc!=null?'Borne ' . $venteEntity->parc->nom:'La vente ne coorespond pas à une parc'?>" data-parc="<?=$venteEntity->parc_id?>" data-id="<?=$venteEntity->id?>" data-value="<?=$venteEntity->borne_id?>" data-valuename="<?=$venteEntity->borne!=null?$venteEntity->borne->model_borne->gammes_borne->notation.$venteEntity->borne->numero:''?>" data-toggle="modal" data-target="#affectation-borne" data-gamme-name="<?= $venteEntity->gammes_borne? ', Gamme ' . $venteEntity->gammes_borne->name:''?>" data-gamme="<?= $venteEntity->gamme_borne_id?>">Affecter borne</a>

        <a href="<?= $this->Url->build(['controller' => 'ventes', 'action' => 'edit', $venteEntity->id]) ?>" class="btn btn-rounded btn-primary">Editer</a>
        
        <a href="<?= $this->Url->build(['controller' => 'ventes', 'action' => 'index']) ?>" class="btn btn-rounded btn-inverse">Quitter</a>
    </div>
<?php $this->end() ?>