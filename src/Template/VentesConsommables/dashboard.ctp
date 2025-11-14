<?= $this->Html->script('ventes_consommables/dashboard.js', ['block' => true]); ?>

<?php
$titrePage = "Ventes Consommables" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Ventes Consommables',
    ['controller' => 'VentesConsommalbes', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');

?>

<?php
$this->end();
?>


<div class="dashboard-content-wrapper vente-consommable-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    147 &euro;
                </h2>
                <h6 class="description">
                    total ventes HT
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-eur font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    80 &euro;
                </h2>
                <h6 class="description">
                    total ventes loc'fi
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 365 365"><path d="M234.5 15zM234.5 15v69.2c.1 2.8 2.5 4.9 5.3 4.8h69.1l-74.4-74z"/><path d="M239.8 109h-.4c-13.8-.1-25-11.4-24.9-25.3V0H62.4c-11.6.1-21 9.6-20.9 21.2v323.2c0 11.7 9.4 20.6 21.1 20.6h239.8c11.7 0 21.1-8.9 21.1-20.6V109h-83.7zm-18 184.5c-25.3 9.6-53.9 3.5-73-15.7-5.3-5.1-9.6-11.2-12.7-17.8H120c-5.5 0-10-4.5-10-10s4.5-10 10-10h9.7c-.6-3.6-.9-7.3-.9-11H120c-5.5 0-10-4.5-10-10s4.5-10 10-10h11.9c3.2-11 9-19.9 16.9-27.8 19.2-19.1 47.8-25.1 73-15.4 5.1 2 7.6 7.7 5.7 12.8-2 5.2-7.7 7.8-12.9 5.9-23.7-9.2-50.5 1.5-61.4 24.6h60.5c5.5 0 10 4.5 10 10s-4.5 10-10 10h-65c-.1 3.7.4 7.4 1.2 11h53.4c5.5 0 10 4.5 10 10s-4.5 10-10 10h-43.5c1 1 2 2.5 3.1 3.6 13.5 13.6 33.8 18 51.7 11.2 5.1-2 10.9.6 12.9 5.7 2 5.1-.6 10.9-5.7 12.9z"/></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    67 &euro;
                </h2>
                <h6 class="description">
                    total ventes achats
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-shopping-cart  font-20 mr-2"></i>
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
                                Total
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                6 500 &euro;
                            </div>
                        </div>
                    </a>
                    <a href="#" target="_blank" class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Loc'fi
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                    </a>
                    <a href="#" target="_blank" class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Ventes
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Janv.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Févr.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mars</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Avr.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Mai</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juin</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Juil.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Août</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sept.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Oct.</div>
                            <div class="td">
                                3 250 &euro;
                            </div>
                        </div>
                    </a>

                </div>

            </div>

        </div>

        <div class="summary-block pie-chart-sum-block loc-fi-vente-summary-block">

            <h4 class="block-title">
                Répartition des Loc'fi & Ventes
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

        <div class="summary-block product-summary-block">

            <h4 class="block-title">
                Liste des produits
            </h4>

            <div class="button-create-wrapper">
                <a href="#">Créer</a>
            </div>

            <div class="filter-wrapper">
                <div class="filter-block customized-input-search rubik-input-search">
                    <svg viewBox="0 0 515.558 515.558"><path d="M378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333C418.889 93.963 324.928.002 209.444.002S0 93.963 0 209.447s93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564L378.344 332.78zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    <input type="text" placeholder="Rechercher ...">
                </div>
                <div class="filter-block">
                    <select class="form-control">
                        <option value="">Catégorie</option>
                    </select>
                </div>
                <div class="filter-block">
                    <select class="form-control">
                        <option value="">Sous catégorie</option>
                    </select>
                </div>
                <div class="filter-block">
                    <select class="form-control">
                        <option value="">Toutes les sous-catégories</option>
                    </select>
                </div>
                <div class="filter-block">
                    <select class="form-control">
                        <option value="">Pro/Particulier</option>
                    </select>
                </div>
                <div class="filter-block button-filter-block apply-filter-block">
                    <a href="#" class="btn-apply-filter">
                        <i class="fa fa-search"></i>
                        <div class="text">Filtrer</div>
                    </a>
                </div>
                <div class="filter-block button-filter-block reset-filter-block">
                    <a href="#" class="btn-reset-filter">
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table">
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Magnets Spherik pour personnalisation FAC + DOS
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70660000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                250 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 bobine papier pour DNP-DS620 - Frais d'envoi compris
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70610000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                70 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pré-decoupé pour DNP-DS620 - Hors frais d'envoi
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                180 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pour DNP-DS620 - Frais d'envoi compris
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                120 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pour DNP-DS620 - Hors frais d'envoi
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                100 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pré-decoupé pour DNP-DS620 - Frais d'envoi compris
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                200 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pour DNP-QW410 - Frais d'envoi compris
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                68 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column commercial-name-column">
                            <div class="th">Nom commercial</div>
                            <div class="td">
                                <a href="#" target="_blank">
                                    Consommable - 1 carton papier pour DNP-QW40 - Fors frais d'envoi
                                </a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Code comptable</div>
                            <div class="td">
                                70711000
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Catégorie</div>
                            <div class="td">
                                Selfizee
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Sous-catégorie</div>
                            <div class="td">
                                Consommables
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Pro/Particulier</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Prix référence HT</div>
                            <div class="td">
                                48 &euro;
                            </div>
                        </div>
                        <div class="column edit-column">
                            <div class="th"></div>
                            <div class="td">
                                <div class="edit-wrapper">
                                    <a href="#"><i class="fa fa-pencil text-inverse"></i></a>
                                    <a href="#"><i class="mdi mdi-delete text-inverse"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
