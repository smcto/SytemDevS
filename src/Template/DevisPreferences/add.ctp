<?php echo $this->Html->script('devis_preferences/add.js', ['block' => 'script']); ?>
<?php
    $this->assign('title', 'devis preference');
    $titrePage = "Paramètrage de préférences de devis par défaut" ;

    if ($id) {
        $titrePage = "Paramètrage de préférences de devis par défaut" ;
    }

    $this->start('breadcumb');
    $this->Breadcrumbs->add('Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );

    $this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
    );
    $this->Breadcrumbs->add($titrePage);
    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<div class="card card-outline-info">

    <div class="card-header">
        <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
    </div>

    <div class="card-body">
        <?= $this->Form->create($devisPreferenceEntity) ?>
            <ul class="nav nav-tabs" id="my-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="infospaiement-tab" data-toggle="tab" href="#infospaiement" role="tab" aria-controls="infospaiement" aria-selected="true">Informations de paiement</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="remise&accompte-tab" data-toggle="tab" href="#remise&accompte" role="tab" aria-controls="remise&accompte" aria-selected="false">Remises et acomptes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="affichage-tab" data-toggle="tab" href="#affichage" role="tab" aria-controls="affichage" aria-selected="false">Paramètres d’affichage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="adress-tab" data-toggle="tab" href="#adress" role="tab" aria-controls="adress" aria-selected="false">Adresse société</a>
                </li>
            </ul>

            <div class="tab-content pt-4" id="my-tab">
                <div class="tab-pane fade show active" id="infospaiement" role="tabpanel" aria-labelledby="infospaiement-tab">
                    <label for="">Moyens de règlements</label>
                    <div class="row">
                        <?php foreach ($moyen_reglements as $key => $moyen_reglement): ?>
                            <div class="col-md-3">
                                <?= $this->Form->control("moyen_reglements[$key]", ['type' => 'checkbox', 'label' => $moyen_reglement, 'checked' => $devisPreferenceEntity->moyen_reglements[$key] == 1 ? 'checked' : '']); ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <?= $this->Form->control('info_bancaire_id', ['empty' => 'Sélectionner', 'options' => $infosBancaires, 'label' => 'Coordonnées bancaires ', 'class' => 'selectpicker coord_bq']); ?>
                    <?= $this->Form->control('delai_reglements', ['empty' => 'Sélectionner', 'options' => $delai_reglements, 'label' => 'Délai de paiement', 'class' => 'selectpicker']); ?>
                    <?= $this->Form->control('display_virement', ['label' => 'afficher les informations bancaire pour le règlement par virement']); ?>
                    <div class="clearfix container-infos-bq <?= $devisPreferenceEntity->display_virement ?: 'd-none' ?>">
                        <div class="row">
                            <div class="col-1">
                                <b>Banque :</b>
                            </div>
                            <div class="col-10 p-0">
                                <p class="mb-4 infos-bq-ajax">
                                    <?= $devisPreferenceEntity->infos_bancaire->adress ?> <br>
                                    BIC : <?= $devisPreferenceEntity->infos_bancaire->bic ?> <br>
                                    IBAN : <?= $devisPreferenceEntity->infos_bancaire->iban ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->control('display_cheque', ['label' => 'afficher le libellé si règlement par chèque activé']); ?>
                    <div class="container-libelle mb-4 <?= $devisPreferenceEntity->display_cheque ?: 'd-none' ?>"><b>KONITYS</b></div>
                    <?= $this->Form->control('is_text_loi_displayed', ['label' => 'Afficher le texte de loi sur les intérêts de retard de paiement']); ?>
                    <?= $this->Form->control('text_loi', ['label' => false]); ?>
                    <?= $this->Form->control('note'); ?>
                </div>

                <div class="tab-pane fade" id="remise&accompte" role="tabpanel" aria-labelledby="remise&accompte-tab">
                    <div class="row">
                        <div class="col-md-2">
                            <?= $this->Form->control('accompte_value', ['label' => 'Accompte', 'type' => 'number', 'class' => 'accompte form-control']) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $this->Form->control('accompte_unity', ['label' => '&nbsp;', 'escape' => false, 'options' => $accompte_unities, 'class' => 'accompte selectpicker']) ?>
                        </div>
                    </div>  
                </div>

                <div class="tab-pane fade" id="affichage" role="tabpanel" aria-labelledby="affichage-tab">

                </div>

                <div class="tab-pane fade" id="adress" role="tabpanel" aria-labelledby="adress-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->control('adress_id', ['options' => $adresses, 'label' => 'Adresse', 'class' => 'selectpicker', 'empty' => 'Sélectionner']) ?>
                        </div>
                    </div> 
                </div>
            </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'), ['class' => 'btn btn-rounded btn-success']) ?>
                    <?= $this->Form->button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-rounded btn-inverse']) ?>
                </div>
            </div>
        <?= $this->Form->end() ?>

</div>

