<?= $this->Html->script('reglements/dashboard-ca-annuel.js', ['block' => true]); ?>

<?php
$titrePage = "Chiffre d'affaires Annuel" ;

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

$this->start('actionTitle');

?>

<?php
$this->end();
?>

<div class="dashboard-content-wrapper chiffre-affaires-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    60 &euro;
                </h2>
                <h6 class="description">
                    total réel HT
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-file-text-o font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    40 &euro;
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
                    30 &euro;
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

        <div class="summary-block line-chart-block general-summary-block">

            <h4 class="block-title">
                Répartition générale
            </h4>

            <div class="top-legend-wrapper legend-wrapper"></div>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table small-line-custom-table">
                    <a href="#" target="_blank" class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA Total
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                    </a>
                    <a href="#" target="_blank" class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA Pro
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                    </a>
                    <a href="#" target="_blank" class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                25 000 &euro;
                            </div>
                        </div>
                    </a>

                </div>

            </div>

        </div>

        <div class="summary-block pie-chart-sum-block devis-summary-block">

            <h4 class="block-title">
                Répartition par Types de devis
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block horizontal-bar-chart-sum-block commercial-summary-block">

            <h4 class="block-title">
                Répartition par Commercial
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

        </div>

        <div class="summary-block turnover-table-summary-block">

            <h4 class="block-title">
                Chiffre d'affaires
            </h4>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table small-line-custom-table">
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Nombre de devis
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                120
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                120
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                120
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                120
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                120
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                600
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA HT chiffré
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                100 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA HT moyen / devis
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                100 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr tr-signed-contract">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                CA HT signé <span class="asterisk">*</span>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                100 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Nombre de contrats
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                100
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                100
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                100
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                100
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                100
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                500
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Taux de transformation
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Objetif CA HT
                                <div class="small-description">
                                    (hors installation et hors hôtesses)
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                10 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                10 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                10 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                10 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                10 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Taux de réalisation
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Particuliers</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Lucie</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Bertrand</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Alan</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Direction</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TOTAL</div>
                            <div class="td">
                                70%
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

