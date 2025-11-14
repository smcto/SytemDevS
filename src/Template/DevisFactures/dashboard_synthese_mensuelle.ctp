<?= $this->Html->script('devisFactures/dashboard-synthese-mensuelle.js', ['block' => true]); ?>

<?php
$titrePage = "Synthèse mensuelle" ;

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


<div class="dashboard-content-wrapper synthese-mensuelle-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    165 &euro;
                </h2>
                <h6 class="description">
                    total CA
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-eur font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    91 &euro;
                </h2>
                <h6 class="description">
                    total professionnels
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 25.916 25.916"><g><path d="M7.938 8.13c.09.414.228.682.389.849.383 2.666 2.776 4.938 4.698 4.843 2.445-.12 4.178-2.755 4.567-4.843.161-.166.316-.521.409-.938.104-.479.216-1.201-.072-1.583a3.786 3.786 0 00-.146-.138c.275-.992.879-2.762-.625-4.353-.815-.862-1.947-1.295-2.97-1.637-3.02-1.009-5.152.406-6.136 2.759-.071.167-.53 1.224.026 3.231a.57.57 0 00-.144.138c-.289.381-.101 1.193.004 1.672z"></path><path d="M23.557 22.792c-.084-1.835-.188-4.743-1.791-7.122 0 0-.457-.623-1.541-1.037 0 0-2.354-.717-3.438-1.492l-.495.339.055 3.218-2.972 7.934a.444.444 0 01-.832 0l-2.971-7.934s.055-3.208.054-3.218c.007.027-.496-.339-.496-.339-1.082.775-3.437 1.492-3.437 1.492-1.084.414-1.541 1.037-1.541 1.037-1.602 2.379-1.708 5.287-1.792 7.122-.058 1.268.208 1.741.542 1.876 4.146 1.664 15.965 1.664 20.112 0 .336-.134.6-.608.543-1.876z"></path><path d="M13.065 14.847l-.134.003c-.432 0-.868-.084-1.296-.232l1.178 1.803-1.057 1.02 1.088 6.607a.118.118 0 00.232 0l1.088-6.607-1.058-1.02 1.161-1.776c-.379.111-.78.185-1.202.202z"></path></g></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    74 &euro;
                </h2>
                <h6 class="description">
                    total particuliers
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 496 496"><path d="M388 436.824H108c-8.836 0-16-7.164-16-16v-47.37c0-22.566 13.314-43.093 33.92-52.293 59.93-26.76 56.645-25.855 61.315-25.855h19.017a16 16 0 0115.537 12.177c6.707 27.256 45.713 27.269 52.423 0a16.002 16.002 0 0115.537-12.177c20.466 0 21.517-.406 25.54 1.39l54.792 24.465c20.605 9.2 33.92 29.727 33.92 52.293v47.37c-.001 8.836-7.165 16-16.001 16zM248.391 59.176c-53.89 0-97.732 43.842-97.732 97.732s43.842 97.732 97.732 97.732 97.732-43.842 97.732-97.732-43.842-97.732-97.732-97.732zM94.218 163.712c-33.931 0-61.536 27.605-61.536 61.537 0 33.931 27.605 61.536 61.536 61.536 33.932 0 61.537-27.605 61.537-61.536-.001-33.932-27.606-61.537-61.537-61.537zm307.564 0c-33.932 0-61.537 27.605-61.537 61.537 0 33.931 27.605 61.536 61.537 61.536 33.931 0 61.536-27.605 61.536-61.536 0-33.932-27.605-61.537-61.536-61.537zM472.9 310.29c-33.292-14.868-32.495-15.02-37.05-15.02-23.833 0-39.424-.167-49.97-.219-10.482-.052-13.954 14.007-4.666 18.865 7.605 3.978 12.222 7.371 17.706 13.355 16.003 17.381 17.494 35.776 17.491 51.027-.001 5.523 4.474 9.993 9.997 9.993H480c8.84 0 16-7.17 16-16V345.9c0-15.37-9.07-29.34-23.1-35.61zM60.15 295.27c-4.534 0-3.642.1-37.05 15.02C9.07 316.56 0 330.53 0 345.9v26.39c0 8.83 7.16 16 16 16h53.588c5.526 0 10.004-4.476 9.997-10.001-.018-15.305 1.429-33.569 17.495-51.019 5.457-5.955 10.113-9.378 17.55-13.285 9.269-4.869 5.844-18.887-4.626-18.869-10.609.018-26.198.154-49.854.154z"></path></svg>
            </div>
        </div>
    </div>

    <div class="summary-section all-chart-wrapper">

        <div class="summary-block pie-chart-block facture-summary-block">

            <h4 class="block-title">
                Répartition par Type de facture
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block creances-summary-block">

            <h4 class="block-title">
                Créances clients
            </h4>

            <div class="inner-amount-summary-wrapper">
                <div class="amount-block">
                    <svg viewBox="-155 -21 682 682.665"><path d="M358.055 115.809L284.566 12.406A29.507 29.507 0 00260.523 0H94.403a29.507 29.507 0 00-24.044 12.406L-3.129 115.81a29.529 29.529 0 00-5.457 17.09V610.5c0 16.297 13.211 29.5 29.5 29.5h313.098c16.289 0 29.5-13.203 29.5-29.5V132.898a29.5 29.5 0 00-5.457-17.09zM177.46 65.489c22.195 0 40.191 17.991 40.191 40.183 0 22.2-17.996 40.187-40.191 40.187-22.191 0-40.188-17.992-40.188-40.187 0-22.192 17.997-40.184 40.188-40.184zm43.855 264.452c10.637 0 19.258 8.622 19.258 19.258 0 10.64-8.62 19.262-19.258 19.262h-89.03a96.213 96.213 0 00-2.263 20.684c0 5.48.485 10.84 1.368 16.074h89.925c10.637 0 19.258 8.625 19.258 19.258 0 10.64-8.62 19.257-19.258 19.257h-74.25c17.383 25.141 46.395 41.657 79.204 41.657h29.105c10.64 0 19.262 8.629 19.262 19.261 0 10.633-8.625 19.258-19.262 19.258H226.27c-54.887 0-102.208-32.988-123.204-80.176h-30.21c-10.641 0-19.262-8.62-19.262-19.257 0-10.633 8.62-19.258 19.261-19.258h19.61c-.63-5.274-.961-10.64-.961-16.074 0-7.032.543-13.942 1.582-20.684h-20.23c-10.641 0-19.262-8.621-19.262-19.262 0-10.637 8.62-19.258 19.261-19.258h32.364c21.957-44.71 67.965-75.566 121.05-75.566h29.106c10.637 0 19.258 8.621 19.258 19.258 0 10.64-8.621 19.262-19.258 19.262H226.27c-30.758 0-58.176 14.523-75.805 37.046zm0 0"/></svg>
                    <div class="number">
                        340 &euro;
                    </div>
                    <div class="text">
                        Total dû (mois précédent)
                    </div>
                </div>
                <div class="amount-block">
                    <svg viewBox="0 0 492.097 492.097"><path d="M195.313 135.991c.542.935 1.981 3.415 11.21 5.154 2.157.408 4.412.614 6.699.614h.003c7.598 0 14.741-2.218 21.647-4.363 6.545-2.031 12.727-3.951 18.936-3.951l.264.002c9.247.082 17.892 2.941 27.042 5.97 3.952 1.308 8.024 2.71 12.19 3.775 1.76.45 2.897-.024 3.621-.406 20.539-10.836 38.354-25.248 50.16-40.578 5.874-7.625 10.861-17.876 15.247-31.34 2.021-6.217 4.257-15.493.314-24.243-5.075-11.271-18.512-12.575-28.178-12.575-2.92 0-20.617.676-25.289.676-11.814 0-25.637-.892-38.562-7.506-5.618-2.875-10.891-6.597-16.471-10.537-8.458-5.974-17.203-12.15-27.497-15.35C223.806.448 220.949 0 218.161 0c-19.494 0-31.228 21.691-35.083 28.818-5.563 10.281-11.954 24.152-12.01 40.299-.054 14.711 5.107 28.522 9.61 38.911 4.334 9.994 9.395 18.93 14.635 27.963z"/><path d="M404.995 273.639c-19.341-35.351-46.661-64.076-75.798-91.633a560.535 560.535 0 00-23.485-21.011c-7.088-2.542-21.558-2.571-30.146-5.419-7.978-2.646-16.339-5.539-24.87-5.005-7.813.49-15.129 3.287-22.688 5.08-8.488 2.013-16.675 2.582-25.279.959 0 0-11.689-1.687-39.319-22.164-11.218-8.314-23.21-15.755-37.039-18.745-13.144-2.843-18.731 17.309-5.557 20.158 12.597 2.725 22.935 9.975 33.182 17.469l.065.048c-14.398 1.893-27.813 7.633-41.751 11.451-12.986 3.558-7.466 23.726 5.558 20.158 14.106-3.865 28.101-10.595 42.866-11.317 2.346-.114 4.597.149 6.819.566-32.937 27.116-63.351 57.013-85.055 94.276-18.781 32.243-27.15 69.75-15.907 106.066 6.578 21.255 19.204 40.11 33.923 56.573 12.858 14.383 27.273 27.338 44.387 36.374 30.861 16.298 66.854 22.868 101.429 24.31 37.057 1.544 75.262-3.567 109.423-18.458 31.121-13.563 57.553-37.167 68.595-69.9 14.562-43.19 1.773-91.231-19.353-129.836zm-137.518 18.907c7.175 0 12.99 5.815 12.99 12.991 0 7.175-5.815 12.99-12.99 12.99h-72.426c-.113 1.603-.174 3.219-.174 4.849s.061 3.246.174 4.848h72.426c7.175 0 12.99 5.816 12.99 12.99 0 7.175-5.815 12.991-12.99 12.991h-65.285c11.32 22.455 34.594 37.896 61.41 37.896 11.354 0 22.164-2.678 32.129-7.96 6.341-3.361 14.201-.945 17.562 5.395 3.36 6.339.945 14.203-5.395 17.562-13.56 7.188-28.876 10.985-44.297 10.985-41.432 0-76.729-26.746-89.551-63.878h-23.486c-7.176 0-12.99-5.816-12.99-12.991 0-7.174 5.814-12.99 12.99-12.99h18.454c-.081-1.604-.124-3.222-.124-4.848s.043-3.242.124-4.849h-18.454c-7.176 0-12.99-5.815-12.99-12.99 0-7.176 5.814-12.991 12.99-12.991h23.486c12.82-37.132 48.119-63.878 89.551-63.878 15.421 0 30.737 3.799 44.297 10.986 6.34 3.36 8.755 11.223 5.395 17.562s-11.221 8.754-17.562 5.394c-9.965-5.281-20.774-7.959-32.129-7.959-26.816 0-50.09 15.439-61.41 37.896h65.285v-.001z"/></svg>
                    <div class="number">
                        100 &euro;
                    </div>
                    <div class="text">
                        Total encaissement reçu
                    </div>
                </div>
                <div class="amount-block">
                    <svg viewBox="0 0 511.98 511.98"><path d="M511.858 334.015l-32-256c-1.504-11.948-15.165-18.002-25.01-11.16-86.89 60.42-200.79 82.58-281.04 90.53-87.83 8.7-155.7 2.74-156.38 2.68C7.65 159.172-1.23 167.351.14 178.317l31.957 255.657c1 8.01 7.81 14.02 15.88 14.02 85.98 0 165.022-6.707 235.964-19.98 10.547-1.973 19.553-10.713 20.131-24.498 2.359-55.75 49.036-100.008 104.834-99.518 34.356.302 64.777 17.339 83.513 43.339 6.739 9.351 21.029-.469 19.439-13.322zm-183.76-2.317c-29.449 70.544-102.274 61.988-135.117 6.934-7.471 1.317-8.033 1.496-9.889 1.496-7.619 0-14.37-5.461-15.738-13.224-1.535-8.702 4.276-17.001 12.979-18.535.66-.116.107.608-1.389-7.878-1.496-8.484-.732-7.994-1.389-7.878-8.703 1.534-17.001-4.276-18.535-12.979-1.535-8.702 4.276-17.001 12.979-18.535l7.092-1.25c11.998-62.784 77.366-96.102 129.341-39.698 5.987 6.499 5.574 16.621-.925 22.608-6.496 5.989-16.62 5.575-22.608-.924-9.045-9.817-23.026-20.957-38.283-18.264-12.734 2.246-25.451 11.826-32.606 30.12l21.017-3.706c8.704-1.534 17.001 4.277 18.535 12.979 1.535 8.702-4.276 17.001-12.979 18.535l-31.133 5.49a82.96 82.96 0 002.778 15.757l31.133-5.49c8.707-1.531 17.001 4.277 18.535 12.979s-4.276 17.001-12.979 18.535l-21.017 3.706c12.976 14.738 28.2 19.399 40.941 17.151 15.253-2.69 24.585-17.938 29.728-30.256 3.403-8.154 12.773-12.004 20.929-8.601 8.153 3.403 12.004 12.773 8.6 20.928z"/><path d="M407.978 479.995c-39.701 0-72-32.299-72-72s32.299-72 72-72 72 32.299 72 72-32.299 72-72 72zM205.934 50.388c-5.224 3.16-5.041 10.811.289 13.79a129.018 129.018 0 0144.641 41.463c2.749 4.161 7.74 6.241 12.611 5.17 30.956-6.81 63.533-15.992 95.98-28.363 5.381-2.052 6.904-9.017 2.825-13.082-42.125-41.984-106.672-49.025-156.346-18.978zM67.881 117.541c-4.015 5.217-.22 12.785 6.363 12.808 43.454.154 88.654-2.826 132.455-9.213 6.584-.96 9.18-9.021 4.427-13.678-41.295-40.467-108.191-35.468-143.245 10.083z"/></svg>
                    <div class="number">
                        240 &euro;
                    </div>
                    <div class="text">
                        Total restant dû
                    </div>
                </div>
            </div>

        </div>

        <div class="summary-block commercial-summary-block">

            <h4 class="block-title">
                Performance commerciale
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

        <div class="summary-block acquisition-summary-block">

            <h4 class="block-title">
                Détail pôle "Acquisition"
            </h4>

            <div class="table-wrapper">

                <div class="tab-wrapper">
                    <div class="tab-block tab-vente current">Ventes</div>
                    <div class="tab-block tab-loc-fi">Loc'fi</div>
                </div>

                <div class="inner-table-wrapper vente-table-wrapper display">

                    <div class="inner-detail-wrapper">
                        <div class="sub-title">
                            Ventes :
                        </div>
                        <div class="detail-block">
                            <div class="label-text">Nombre de ventes :</div>
                            <div class="value">5 dont 3 Spherik et 2 Classik</div>
                        </div>
                        <div class="detail-block">
                            <div class="label-text">Total CA Ventes :</div>
                            <div class="value">30 000 &euro; HT</div>
                        </div>
                    </div>

                    <div class="customized-table rubik-customized-table">
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Classik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Classik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

                <div class="inner-table-wrapper loc-fi-table-wrapper">

                    <div class="inner-detail-wrapper">
                        <div class="sub-title">
                            Loc'fi :
                        </div>
                        <div class="detail-block">
                            <div class="label-text">Nombre de loc'fi :</div>
                            <div class="value">8 dont 5 Spherik et 3 Classik</div>
                        </div>
                        <div class="detail-block">
                            <div class="label-text">Total CA Ventes :</div>
                            <div class="value">80 000 &euro; HT</div>
                        </div>
                    </div>

                    <div class="customized-table rubik-customized-table">
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Classik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Durée de contrat</div>
                                <div class="td">
                                    2 jours
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Durée de contrat</div>
                                <div class="td">
                                    2 jours
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Classik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Durée de contrat</div>
                                <div class="td">
                                    2 jours
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Durée de contrat</div>
                                <div class="td">
                                    2 jours
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>
                        <div class="tr">
                            <div class="column">
                                <div class="th">Gamme</div>
                                <div class="td">
                                    Spherik
                                </div>
                            </div>
                            <div class="column client-column">
                                <div class="th">Enseigne</div>
                                <div class="td">
                                    <a href="#" target="_blank">Nom du client</a>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Date ajout</div>
                                <div class="td">
                                    10/01/20
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Durée de contrat</div>
                                <div class="td">
                                    2 jours
                                </div>
                            </div>
                            <div class="column">
                                <div class="th">Commercial</div>
                                <div class="td">
                                    <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                                </div>
                            </div>
                            <div class="column">
                                <div class="th"></div>
                                <div class="td">
                                    <a class="btn-table-link" href="#" target="_blank">Voir détails</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="summary-block event-summary-block">

            <h4 class="block-title">
                Détail pôle "Event"
            </h4>

            <div class="inner-detail-wrapper">
                <div class="detail-block">
                    <div class="label-text">Nombre de devis signés :</div>
                    <div class="value">50</div>
                </div>
                <div class="detail-block">
                    <div class="label-text">Total signés :</div>
                    <div class="value">120</div>
                </div>
                <div class="detail-block">
                    <div class="label-text">Date events :</div>
                    <div class="value-list-wrap">
                        <div class="value">8 events pour 2020</div>
                        <div class="value">14 events pour 2021</div>
                    </div>
                </div>
            </div>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table devis-table">
                    <div class="tr">
                        <div class="column devis-num-column">
                            <div class="th">N&deg;</div>
                            <div class="td">
                                <a href="#">DK-202000-00000</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Client / prospect</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Antenne(s)</div>
                            <div class="td">
                                Saint-Brieuc
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Type</div>
                            <div class="td">
                                Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Borne</div>
                            <div class="td">
                                Spherik
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Event</div>
                            <div class="td">
                                27/11/20
                            </div>
                        </div>
                        <div class="column document-column">
                            <div class="th">Document</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Contact</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Devis date</div>
                            <div class="td">
                                13/10/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">HT</div>
                            <div class="td">
                                320 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TTC</div>
                            <div class="td">
                                256 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Expire</div>
                            <div class="td">
                                13/11/20
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column devis-num-column">
                            <div class="th">N&deg;</div>
                            <div class="td">
                                <a href="#">DK-202000-00000</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Client / prospect</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Antenne(s)</div>
                            <div class="td">
                                Saint-Brieuc
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Type</div>
                            <div class="td">
                                Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Borne</div>
                            <div class="td">
                                Spherik
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Event</div>
                            <div class="td">
                                27/11/20
                            </div>
                        </div>
                        <div class="column document-column">
                            <div class="th">Document</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Contact</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Devis date</div>
                            <div class="td">
                                13/10/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">HT</div>
                            <div class="td">
                                320 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TTC</div>
                            <div class="td">
                                256 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Expire</div>
                            <div class="td">
                                13/11/20
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column devis-num-column">
                            <div class="th">N&deg;</div>
                            <div class="td">
                                <a href="#">DK-202000-00000</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Client / prospect</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Antenne(s)</div>
                            <div class="td">
                                Saint-Brieuc
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Type</div>
                            <div class="td">
                                Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Borne</div>
                            <div class="td">
                                Spherik
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Event</div>
                            <div class="td">
                                27/11/20
                            </div>
                        </div>
                        <div class="column document-column">
                            <div class="th">Document</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Contact</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Devis date</div>
                            <div class="td">
                                13/10/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">HT</div>
                            <div class="td">
                                320 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TTC</div>
                            <div class="td">
                                256 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Expire</div>
                            <div class="td">
                                13/11/20
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column devis-num-column">
                            <div class="th">N&deg;</div>
                            <div class="td">
                                <a href="#">DK-202000-00000</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Client / prospect</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Antenne(s)</div>
                            <div class="td">
                                Saint-Brieuc
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Type</div>
                            <div class="td">
                                Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Borne</div>
                            <div class="td">
                                Spherik
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Event</div>
                            <div class="td">
                                27/11/20
                            </div>
                        </div>
                        <div class="column document-column">
                            <div class="th">Document</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Contact</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Devis date</div>
                            <div class="td">
                                13/10/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">HT</div>
                            <div class="td">
                                320 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TTC</div>
                            <div class="td">
                                256 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Expire</div>
                            <div class="td">
                                13/11/20
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column devis-num-column">
                            <div class="th">N&deg;</div>
                            <div class="td">
                                <a href="#">DK-202000-00000</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Client / prospect</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Antenne(s)</div>
                            <div class="td">
                                Saint-Brieuc
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Type</div>
                            <div class="td">
                                Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Borne</div>
                            <div class="td">
                                Spherik
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Event</div>
                            <div class="td">
                                27/11/20
                            </div>
                        </div>
                        <div class="column document-column">
                            <div class="th">Document</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Contact</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Devis date</div>
                            <div class="td">
                                13/10/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">HT</div>
                            <div class="td">
                                320 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">TTC</div>
                            <div class="td">
                                256 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Expire</div>
                            <div class="td">
                                13/11/20
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="summary-block particulier-summary-block">

            <h4 class="block-title">
                Détail pôle "Particuliers"
            </h4>

            <div class="inner-detail-wrapper">
                <div class="detail-block">
                    <div class="label-text">Nombre de devis signés :</div>
                    <div class="value">30</div>
                </div>
                <div class="detail-block">
                    <div class="label-text">Total signés :</div>
                    <div class="value">57</div>
                </div>
                <div class="detail-block">
                    <div class="label-text">Date events :</div>
                    <div class="value-list-wrap">
                        <div class="value">8 events pour 2020</div>
                        <div class="value">14 events pour 2021</div>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>
