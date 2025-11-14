<?= $this->Html->script('devisFactures/dashboard-reglements-retard.js?time='.time(), ['block' => true]); ?>

<?php
$titrePage = "Factures en attente de règlement" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Factures',
    ['controller' => 'DevisFactures', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');

?>

<a href="<?= $this->Url->build(['controller' => 'devisFactures', 'action' => 'index', 'status' => 'en_attente']) ?>" class="btn btn-success btn-round, 'status' => 'delay'ed hidden-sm-down">Voir les factures en attente</a>

<?php
$this->end();
?>

<!--<div class="clearfix mb-4">
    <a href="<?= $this->Url->build(['with_decimal' => @$with_decimal == 1 ? 0 : 1]) ?>" class="float-right btn btn <?= @$with_decimal ? 'active' : '' ?> btn-outline-dark btn-rounded hidden-sm-down btn-default-color"><?= @$with_decimal ? 'Valeurs arrondies' : 'Valeurs précises' ?></a>
</div>-->

<!--<div class="toggle-btn-amount-wrapper">
    <div class="inner-toggle-amount-wrap <?= @$with_decimal ? 'active' : '' ?>">
        <div class="text-label">
            Valeurs arrondies :
        </div>
        <a href="<?= $this->Url->build(['with_decimal' => @$with_decimal == 1 ? 0 : 1]) ?>" class="toggle-tdb-amount-button" id="header-btn-toggle-amount">
            <div class="btn-toggle-circle"></div>
        </a>
    </div>
</div>-->

<div class="top-btn-amount-wrapper">
    <div class="dropdown label-text">
        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" selected-data-value="<?= $with_decimal?1:2 ?>">
            <?= $with_decimal?'Valeurs précises':'Valeurs arrondies' ?>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item <?= $with_decimal?:'selected' ?>" data-value="2">
                <a href="<?= $this->Url->build(['with_decimal' => 0]) ?>">Valeurs arrondies</a>
            </div>
            <div class="dropdown-item <?= $with_decimal?'selected':'' ?>" data-value="1">
                <a href="<?= $this->Url->build(['with_decimal' => 1]) ?>">Valeurs précises</a>
            </div>
        </div>
    </div>
</div>

<!---- Vars vers JS ------>
<?= $this->Form->hidden('totalFactures', ['value' => $totalFactures]); ?>
<?= $this->Form->hidden('nbDecimal', ['value' => $with_decimal ? 2 : 0]); ?>
<!-- End / Vars vers JS -->


<div class="dashboard-content-wrapper retard-reglement-dashboard-wrapper">

    <div class="summary-section all-chart-wrapper">

        <div class="summary-block total-summary-block">

            <div class="inner-total-block en-attente-block">

                <div class="description">Total factures en attente de règlement</div>
                <?= $this->Form->hidden('totalFacturesNonReglees', ['value' => number_format($totalFacturesNonReglees, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="outer-chart-wrapper">

                    <div class="inner-chart-wrap">
                        <canvas></canvas>
                    </div>

                    <div class="legend-wrapper"></div>

                </div>

            </div>

            <div class="inner-total-block en-retard-block">

                <div class="description">Total factures en retard</div>
                <?= $this->Form->hidden('totalFacturesEnRetard', ['value' => number_format($totalFacturesEnRetard, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="outer-chart-wrapper">

                    <div class="inner-chart-wrap">
                        <canvas></canvas>
                    </div>

                    <div class="legend-wrapper"></div>

                </div>

            </div>

        </div>

        <div class="summary-block somme-due-summary-block">

            <h4 class="block-title">
                Détails des sommes dûes
            </h4>

            <?php echo $this->Form->hidden('totalFacturesDelai', ['value' => number_format($totalFacturesDelai, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('totalFacturesEnRetardInferieure30js', ['value' => number_format($totalFacturesEnRetardInferieure30js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('totalFacturesEnRetardEntre30j60js', ['value' => number_format($totalFacturesEnRetardEntre30j60js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('totalFacturesEnRetardEntre60j90js', ['value' => number_format($totalFacturesEnRetardEntre60j90js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('totalFacturesEnRetardSuperieure90js', ['value' => number_format($totalFacturesEnRetardSuperieure90js, $with_decimal ? 2 : 0, '.', '')]); ?>

            <?php echo $this->Form->hidden('nbFacturesEnDelai', ['value' => number_format($nbFacturesEnDelai, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('nbFacturesEnRetardInferieure30js', ['value' => number_format($nbFacturesEnRetardInferieure30js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('nbFacturesEnRetardEntre30j60js', ['value' => number_format($nbFacturesEnRetardEntre30j60js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('nbFacturesEnRetardEntre60j90js', ['value' => number_format($nbFacturesEnRetardEntre60j90js, $with_decimal ? 2 : 0, '.', '')]); ?>
            <?php echo $this->Form->hidden('nbFacturesEnRetardSuperieure90js', ['value' => number_format($nbFacturesEnRetardSuperieure90js, $with_decimal ? 2 : 0, '.', '')]); ?>


            <div class="outer-chart-wrapper">

                <div class="pie-legend-wrapper legend-wrapper"></div>

                <div class="inner-chart-wrap">
                    <canvas></canvas>
                </div>

            </div>

        </div>

        <div class="summary-block left-section-sum-block">

            <div class="inner-summary-block pie-chart-sum-block attente-reglement-summary-block">

                <h4 class="block-title">
                    Types de factures en attente de règlement
                </h4>

                <?php echo $this->Form->hidden('facturesEnAttentedEvent', ['value' => number_format($facturesEnAttentedEvent, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttentedLocFi', ['value' => number_format($facturesEnAttentedLocFi, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttentedVente', ['value' => number_format($facturesEnAttentedVente, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttentedPart', ['value' => number_format($facturesEnAttentedPart, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="inner-chart-wrap">
                    <canvas></canvas>
                </div>

                <div class="bottom-legend-wrapper legend-wrapper"></div>

            </div>

            <div class="inner-summary-block pie-chart-sum-block invoice-type-summary-block">

                <h4 class="block-title">
                    Types de factures en retard
                </h4>

                <?php echo $this->Form->hidden('facturesRetardEvent', ['value' => number_format($facturesRetardEvent, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardLocFi', ['value' => number_format($facturesRetardLocFi, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardVente', ['value' => number_format($facturesRetardVente, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardPart', ['value' => number_format($facturesRetardPart, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="inner-chart-wrap">
                    <canvas></canvas>
                </div>

                <div class="bottom-legend-wrapper legend-wrapper"></div>

            </div>

        </div>

        <div class="summary-block invoice-type-sum-block retard-facture-sum-block">

            <h4 class="block-title">
                Détail par type de facture
            </h4>

            <div class="invoice-type-list-wrapper">

                <div class="invoice-block">
                    <div class="name">
                        Loc'event pro <span class="float-right"><?= number_format($totalLocEvent, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($totalFacturesEventDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesEventDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardEventInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesRetardEventInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardEventEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesRetardEventEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardEventEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesRetardEventEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardEventSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesRetardEventSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'type_doc_id' => 4, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Loc'fi <span class="float-right"><?= number_format($totalRetardLocFi, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($totalFacturesLocFiDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesLocFiDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardLocFiInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardLocFiInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardLocFiEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardLocFiEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardLocFiEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardLocFiEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardLocFiSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardLocFiSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'type_doc_id' => 6, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Achat <span class="float-right"><?= number_format($totalRetardVente, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($totalFacturesVenteDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbtacturesVenteDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardVenteInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardVenteInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardVenteEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardVenteEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardVenteEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardVenteEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardVenteSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardVenteSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'type_doc_id' => 5, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Particuliers <span class="float-right"><?= number_format($totalFacturesRetardPart, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($totalFacturesPartDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbFacturesPartDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardPartInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardPartInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardPartEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardPartEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardPartEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardPartEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesRetardPartSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbRetardPartSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'type_doc_id' => 1, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

            </div>

        </div>

        <div class="summary-block left-section-sum-block">

            <div class="inner-summary-block horizontal-bar-chart-sum-block commercial-summary-block">

                <h4 class="block-title">
                    Factures en attente de règlement par commercial
                </h4>
                
                <?php echo $this->Form->hidden('facturesEnAttenteReglementLucie', ['value' => number_format($facturesEnAttenteReglementLucie, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttenteReglementBertrant', ['value' => number_format($facturesEnAttenteReglementBertrant, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttenteReglementGregory', ['value' => number_format($facturesEnAttenteReglementGregory, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesEnAttenteReglementBenjamin', ['value' => number_format($facturesEnAttenteReglementBenjamin, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="inner-chart-wrap">
                    <canvas></canvas>
                </div>

            </div>

            <div class="inner-summary-block horizontal-bar-chart-sum-block commercial-retard-sum-block">

                <h4 class="block-title">
                    Factures en retard par commercial
                </h4>

                <?php echo $this->Form->hidden('facturesRetardLucie', ['value' => number_format($facturesRetardLucie, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardBertrant', ['value' => number_format($facturesRetardBertrant, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardGregory', ['value' => number_format($facturesRetardGregory, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('facturesRetardBenjamin', ['value' => number_format($facturesRetardBenjamin, $with_decimal ? 2 : 0, '.', '')]); ?>

                <div class="inner-chart-wrap">
                    <canvas></canvas>
                </div>

            </div>

        </div>

        <div class="summary-block invoice-type-sum-block retard-commercial-sum-block">

            <h4 class="block-title">
                Détail par commercial
            </h4>

            <div class="invoice-type-list-wrapper">

                <div class="invoice-block">
                    <div class="name">
                        Lucie <span class="float-right"><?= number_format($totalFacturesLucieEnRetart, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesLucieEnDelai, $with_decimal ? 2 : 0, ',', '&nbsp') ?> &euro;
                            <div class="pastille-count"><?= $nbfacturesLucieEnDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesLucieEnRetardInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp') ?> &euro;
                            <div class="pastille-count"><?= $nbLucieEnRetardInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesLucieEnRetardEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp') ?> &euro;
                            <div class="pastille-count"><?= $nbLucieEnRetardEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesLucieEnRetardEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp') ?> &euro;
                            <div class="pastille-count"><?= $nbLucieEnRetardEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesLucieEnRetardSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp') ?> &euro;
                            <div class="pastille-count"><?= $nbLucieEnRetardSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'ref_commercial_id' => 85, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Bertrand <span class="float-right"><?= number_format($totalFacturesBertrantEnRetard, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBertrantEnDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbfacturesBertrantEnDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBertrantEnRetardInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBertrantEnRetardInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBertrantEnRetardEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBertrantEnRetardEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBertrantEnRetardEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBertrantEnRetardEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBertrantEnRetardSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBertrantEnRetardSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'ref_commercial_id' => 86, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Gregory <span class="float-right"><?= number_format($totalfacturesGregoryEnRetard, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesGregoryEnDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbfacturesGregoryEnDelai ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesGregoryEnRetardInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbGregoryEnRetardInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesGregoryEnRetardEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbGregoryEnRetardEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesGregoryEnRetardEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbGregoryEnRetardEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesGregoryEnRetardSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbGregoryEnRetardSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'ref_commercial_id' => 34, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

                <div class="invoice-block">
                    <div class="name">
                        Benjamin <span class="float-right"><?= number_format($totalFacturesBenjaminEnRetard, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;</span>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type en-delai-type">
                            <div class="color"></div>
                            <div class="text">
                                En délai
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBenjaminEnDelai, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbfacturesBenjaminEnDelai ?></div>
                        </div>
                    </div>  
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-30-type">
                            <div class="color"></div>
                            <div class="text">
                                <?php echo '< 30 jrs de retard'; ?>
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBenjaminEnRetardInferieure30js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBenjaminEnRetardInferieure30js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-30-60-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 30 et 60 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBenjaminEnRetardEntre30j60js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBenjaminEnRetardEntre30j60js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type entre-60-90-type">
                            <div class="color"></div>
                            <div class="text">
                                Entre 60 et 90 jrs de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBenjaminEnRetardEntre60j90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBenjaminEnRetardEntre60j90js ?></div>
                        </div>
                    </div>
                    <div class="inner-detail-wrap">
                        <div class="remaining-type moins-90-type">
                            <div class="color"></div>
                            <div class="text">
                                > 90 jours de retard
                            </div>
                        </div>
                        <div class="amount">
                            <?= number_format($facturesBenjaminEnRetardSuperieure90js, $with_decimal ? 2 : 0, ',', '&nbsp;') ?> &euro;
                            <div class="pastille-count"><?= $nbBenjaminEnRetardSuperieure90js ?></div>
                        </div>
                    </div>

                    <div class="invoice-link-wrap">
                        <a href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'index', 'ref_commercial_id' => 33, 'status' => 'delay']) ?>" target="_blank">Voir les factures</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>















