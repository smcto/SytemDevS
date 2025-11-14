<?= $this->Html->script('reglements/dashboard-encaissements.js?time='.time(), ['block' => true]); ?>

<?php
$titrePage = "Encaissements" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Règlements',
    ['controller' => 'Reglements', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>
<!---- Vars vers JS ------>
<?= $this->Form->hidden('nbDecimal', ['value' => $with_decimal ? 2 : 0]); ?>
<?= $this->Form->hidden('currentYear', ['value' => $annee ?? '']); ?>
<!-- End / Vars vers JS -->


<?php $this->start('actionTitle'); ?>

    <a href="<?= $this->Url->build(['controller' => 'reglements', 'action' => 'index']) ?>" class="btn btn-success btn-rounded hidden-sm-down">Voir les règlements</a>
    <a href="#" class="btn btn-success btn-rounded hidden-sm-down">Ajouter un règlement</a>
    
<?php $this->end(); ?>

<!--<div class="clearfix mb-4">
    <a href="<?= $this->Url->build(['annee' => $annee ?? '', 'with_decimal' => $with_decimal == 1 ? 0 : 1]) ?>" class="float-right btn btn <?= $with_decimal ? 'active' : '' ?> btn-outline-dark btn-rounded hidden-sm-down btn-default-color"><?= $with_decimal ? 'Valeurs arrondies' : 'Valeurs précises' ?></a>
</div>-->

<!--<div class="toggle-btn-amount-wrapper">
    <div class="inner-toggle-amount-wrap <?= @$with_decimal ? 'active' : '' ?>">
        <div class="text-label">
            Valeurs arrondies :
        </div>
        <a href="<?= $this->Url->build(['annee' => $annee ?? '', 'with_decimal' => $with_decimal == 1 ? 0 : 1]) ?>" class="toggle-tdb-amount-button" id="header-btn-toggle-amount">
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
                <a href="<?= $this->Url->build(['annee' => $annee ?? '', 'with_decimal' => 0]) ?>">Valeurs arrondies</a>
            </div>
            <div class="dropdown-item <?= $with_decimal?'selected':'' ?>" data-value="1">
                <a href="<?= $this->Url->build(['annee' => $annee ?? '', 'with_decimal' => 1]) ?>">Valeurs précises</a>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-content-wrapper encaissement-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    <?= number_format($totalReglements, $with_decimal ? 2 : 0, ',', '&nbsp;&nbsp;')?> &euro;
                </h2>
                <h6 class="description">
                    total règlements
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-file-text-o font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    <?= number_format($totalProfessionnels, $with_decimal ? 2 : 0, ',', '&nbsp;&nbsp;')?> &euro;
                </h2>
                <h6 class="description">
                    total professionnels
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 25.916 25.916"><g><path d="M7.938 8.13c.09.414.228.682.389.849.383 2.666 2.776 4.938 4.698 4.843 2.445-.12 4.178-2.755 4.567-4.843.161-.166.316-.521.409-.938.104-.479.216-1.201-.072-1.583a3.786 3.786 0 00-.146-.138c.275-.992.879-2.762-.625-4.353-.815-.862-1.947-1.295-2.97-1.637-3.02-1.009-5.152.406-6.136 2.759-.071.167-.53 1.224.026 3.231a.57.57 0 00-.144.138c-.289.381-.101 1.193.004 1.672z"/><path d="M23.557 22.792c-.084-1.835-.188-4.743-1.791-7.122 0 0-.457-.623-1.541-1.037 0 0-2.354-.717-3.438-1.492l-.495.339.055 3.218-2.972 7.934a.444.444 0 01-.832 0l-2.971-7.934s.055-3.208.054-3.218c.007.027-.496-.339-.496-.339-1.082.775-3.437 1.492-3.437 1.492-1.084.414-1.541 1.037-1.541 1.037-1.602 2.379-1.708 5.287-1.792 7.122-.058 1.268.208 1.741.542 1.876 4.146 1.664 15.965 1.664 20.112 0 .336-.134.6-.608.543-1.876z"/><path d="M13.065 14.847l-.134.003c-.432 0-.868-.084-1.296-.232l1.178 1.803-1.057 1.02 1.088 6.607a.118.118 0 00.232 0l1.088-6.607-1.058-1.02 1.161-1.776c-.379.111-.78.185-1.202.202z"/></g></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    <?= number_format($totalParticuliers, $with_decimal ? 2 : 0, ',', '&nbsp;&nbsp;')?> &euro;
                </h2>
                <h6 class="description">
                    total particuliers
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 496 496"><path d="M388 436.824H108c-8.836 0-16-7.164-16-16v-47.37c0-22.566 13.314-43.093 33.92-52.293 59.93-26.76 56.645-25.855 61.315-25.855h19.017a16 16 0 0115.537 12.177c6.707 27.256 45.713 27.269 52.423 0a16.002 16.002 0 0115.537-12.177c20.466 0 21.517-.406 25.54 1.39l54.792 24.465c20.605 9.2 33.92 29.727 33.92 52.293v47.37c-.001 8.836-7.165 16-16.001 16zM248.391 59.176c-53.89 0-97.732 43.842-97.732 97.732s43.842 97.732 97.732 97.732 97.732-43.842 97.732-97.732-43.842-97.732-97.732-97.732zM94.218 163.712c-33.931 0-61.536 27.605-61.536 61.537 0 33.931 27.605 61.536 61.536 61.536 33.932 0 61.537-27.605 61.537-61.536-.001-33.932-27.606-61.537-61.537-61.537zm307.564 0c-33.932 0-61.537 27.605-61.537 61.537 0 33.931 27.605 61.536 61.537 61.536 33.931 0 61.536-27.605 61.536-61.536 0-33.932-27.605-61.537-61.536-61.537zM472.9 310.29c-33.292-14.868-32.495-15.02-37.05-15.02-23.833 0-39.424-.167-49.97-.219-10.482-.052-13.954 14.007-4.666 18.865 7.605 3.978 12.222 7.371 17.706 13.355 16.003 17.381 17.494 35.776 17.491 51.027-.001 5.523 4.474 9.993 9.997 9.993H480c8.84 0 16-7.17 16-16V345.9c0-15.37-9.07-29.34-23.1-35.61zM60.15 295.27c-4.534 0-3.642.1-37.05 15.02C9.07 316.56 0 330.53 0 345.9v26.39c0 8.83 7.16 16 16 16h53.588c5.526 0 10.004-4.476 9.997-10.001-.018-15.305 1.429-33.569 17.495-51.019 5.457-5.955 10.113-9.378 17.55-13.285 9.269-4.869 5.844-18.887-4.626-18.869-10.609.018-26.198.154-49.854.154z"/></svg>
            </div>
        </div>
    </div>

    <div class="summary-section all-chart-wrapper">

        <div class="summary-block line-chart-block evolution-summary-block <?= $typeFiltre == "annee_mois" ? 'd-none' : '' ?>">

            <?php echo $this->Form->hidden('courbeTotal', ['value' => $courbeTotal]); ?>
            <?php echo $this->Form->hidden('courbePro', ['value' => $courbePro]); ?>
            <?php echo $this->Form->hidden('courbePart', ['value' => $courbePart]); ?>
            <h4 class="block-title">
                Évolution par période
            </h4>

            <div class="top-legend-wrapper legend-wrapper"></div>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="monthly-amount-wrapper hide">
                <?php foreach ($reglementsTotal as $key => $montant): ?>
                    <div class="amount-block">
                        <span class="month"><?= $montant->nom ?>.</span><?= $this->Number->format($montant->total_par_mois); ?> &euro;
                    </div>
                <?php endforeach ?>
            </div>

        </div>

        <div class="summary-block left-chart-sum-block invoice-type-summary-block pie-chart-sum-block">
            <h4 class="block-title">
                <?php echo $this->Form->hidden('montantFacturesPart', ['value' => number_format($montantFacturesPart, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesPart', ['value' => number_format($nbFacturesPart, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('montantFacturesEvent', ['value' => number_format($montantFacturesEvent, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesEvent', ['value' => number_format($nbFacturesEvent, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('montantFacturesLocFi', ['value' => number_format($montantFacturesLocFi, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesLocFi', ['value' => number_format($nbFacturesLocFi, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('montantFacturesVente', ['value' => number_format($montantFacturesVente, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesVente', ['value' => number_format($nbFacturesVente, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('montantFacturesBrandeet', ['value' => number_format($montantFacturesBrandeet, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesBrandeet', ['value' => number_format($nbFacturesBrandeet, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('montantFacturesDigitea', ['value' => number_format($montantFacturesDigitea, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?php echo $this->Form->hidden('nbFacturesDigitea', ['value' => number_format($nbFacturesDigitea, $with_decimal ? 2 : 0, '.', '')]); ?>
                
                Répartition par type de facture
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block right-chart-sum-block invoice-type-summary-block bar-chart-sum-block <?= $typeFiltre == "annee_mois" ? 'd-none' : '' ?>">
            
            <?php echo $this->Form->hidden('batonRepartitionFactureSelfizeePro', ['value' => $batonRepartitionFactureSelfizeePro]); ?>
            <?php echo $this->Form->hidden('batonRepartitionFactureSelfizeePart', ['value' => $batonRepartitionFactureSelfizeePart]); ?>
            <?php echo $this->Form->hidden('batonRepartitionFactureLocFi', ['value' => $batonRepartitionFactureLocFi]); ?>
            <?php echo $this->Form->hidden('batonRepartitionFactureVente', ['value' => $batonRepartitionFactureVente]); ?>
            <?php echo $this->Form->hidden('batonRepartitionFactureBrandeet', ['value' => $batonRepartitionFactureBrandeet]); ?>
            <?php echo $this->Form->hidden('batonRepartitionFactureDigitea', ['value' => $batonRepartitionFactureDigitea]); ?>
            <h4 class="block-title">
                Évolution par type de facture
            </h4>

            <div class="top-legend-wrapper legend-wrapper"></div>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="monthly-amount-wrapper"></div>

        </div>

        <div class="summary-block left-chart-sum-block payment-type-summary-block pie-chart-sum-block">
            <h4 class="block-title">
                <?= $this->Form->hidden('montantCB', ['value' => number_format($montantCB, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('nbCB', ['value' => number_format($nbCB, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('montantVirBanc', ['value' => number_format($montantVirBanc, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('nbVirBanc', ['value' => number_format($nbVirBanc, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('montantCheque', ['value' => number_format($montantCheque, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('nbCheque', ['value' => number_format($nbCheque, $with_decimal ? 2 : 0, '.', '')]); ?>
                Répartition par type de paiement
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block right-chart-sum-block payment-type-summary-block line-chart-sum-block <?= $typeFiltre == "annee_mois" ? 'd-none' : '' ?>">

            <h4 class="block-title">
                <?= $this->Form->hidden('courbeCB', ['value' => $courbeCB]); ?>
                <?= $this->Form->hidden('courbeVir', ['value' => $courbeVir]); ?>
                <?= $this->Form->hidden('courbeCheque', ['value' => $courbeCheque]); ?>
                
                Évolution par type de paiement
            </h4>

            <div class="top-legend-wrapper legend-wrapper"></div>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

        </div>

        <div class="summary-block left-chart-sum-block bank-summary-block pie-chart-sum-block">
            <h4 class="block-title">
                <?= $this->Form->hidden('montantBPO', ['value' => number_format($montantBPO, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('montantCIC', ['value' => number_format($montantCIC, $with_decimal ? 2 : 0, '.', '')]); ?>
                <?= $this->Form->hidden('montantCA', ['value' => number_format($montantCA, $with_decimal ? 2 : 0, '.', '')]); ?>
                Répartition par banque
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block right-chart-sum-block bank-summary-block line-chart-sum-block <?= $typeFiltre == "annee_mois" ? 'd-none' : '' ?>">

            <h4 class="block-title">
                <?= $this->Form->hidden('courbeBPO', ['value' => $courbeBPO]); ?>
                <?= $this->Form->hidden('courbeCIC', ['value' => $courbeCIC]); ?>
                <?= $this->Form->hidden('courbeCA', ['value' => $courbeCA]); ?>
                Évolution par banque
            </h4>

            <div class="top-legend-wrapper legend-wrapper"></div>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

        </div>

    </div>

</div>















