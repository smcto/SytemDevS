<?= $this->Html->script('reglements/dashboard-commercial.js', ['block' => true]); ?>

<?php
$titrePage = "Lucie l'Hotelier" ;

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

<div class="dashboard-content-wrapper commercial-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block" id="test-summary-block">
            <div class="left-section">
                <h6 class="description">
                    total CA
                </h6>
                <h2 class="number">
                    60 000 &euro;
                </h2>
            </div>
            <!--<div class="right-section">
                <i class="fa  fa-eur font-20 mr-2"></i>
            </div>-->
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    40 &euro;
                </h2>
                <h6 class="description">
                    total devis
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 365 365"><path d="M234.5 15zM234.5 15v69.2c.1 2.8 2.5 4.9 5.3 4.8h69.1l-74.4-74z"/><path d="M239.8 109h-.4c-13.8-.1-25-11.4-24.9-25.3V0H62.4c-11.6.1-21 9.6-20.9 21.2v323.2c0 11.7 9.4 20.6 21.1 20.6h239.8c11.7 0 21.1-8.9 21.1-20.6V109h-83.7zm-18 184.5c-25.3 9.6-53.9 3.5-73-15.7-5.3-5.1-9.6-11.2-12.7-17.8H120c-5.5 0-10-4.5-10-10s4.5-10 10-10h9.7c-.6-3.6-.9-7.3-.9-11H120c-5.5 0-10-4.5-10-10s4.5-10 10-10h11.9c3.2-11 9-19.9 16.9-27.8 19.2-19.1 47.8-25.1 73-15.4 5.1 2 7.6 7.7 5.7 12.8-2 5.2-7.7 7.8-12.9 5.9-23.7-9.2-50.5 1.5-61.4 24.6h60.5c5.5 0 10 4.5 10 10s-4.5 10-10 10h-65c-.1 3.7.4 7.4 1.2 11h53.4c5.5 0 10 4.5 10 10s-4.5 10-10 10h-43.5c1 1 2 2.5 3.1 3.6 13.5 13.6 33.8 18 51.7 11.2 5.1-2 10.9.6 12.9 5.7 2 5.1-.6 10.9-5.7 12.9z"/></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    12
                </h2>
                <h6 class="description">
                    nombre de devis
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-file-text-o font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    35
                </h2>
                <h6 class="description">
                    panier moyen / devis
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

                <div class="customized-table rubik-customized-table">
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Janv.
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Févr.
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Mars
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Avril
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Mai
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Juin
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Juil.
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Août
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Sept.
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                Oct.
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                334
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                595 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                10 302 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                23
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                20 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column label-column">
                            <div class="th"></div>
                            <div class="td">
                                TOTAL
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de devis</div>
                            <div class="td">
                                3 340
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT chiffré</div>
                            <div class="td">
                                300 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT moyen / devis</div>
                            <div class="td">
                                5 950 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA HT signé</div>
                            <div class="td">
                                103 020 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Nb de contrats</div>
                            <div class="td">
                                230
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de transfo.</div>
                            <div class="td">
                                11%
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Objectif CA HT</div>
                            <div class="td">
                                200 000 &euro;
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Taux de réalisation</div>
                            <div class="td">
                                50%
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="summary-block horizontal-bar-chart-block devis-summary-block">

            <h4 class="block-title">
                Répartition par Type de devis
            </h4>

            <div class="inner-chart-wrap inner-horizontal-chart-wrap">
                <div class="top-legend-wrapper legend-wrapper"></div>
                <canvas></canvas>
            </div>

            <div class="inner-chart-wrap inner-pie-chart-wrap">
                <canvas></canvas>
                <div class="bottom-legend-wrapper legend-wrapper"></div>
            </div>

            <div class="table-wrapper">

                <div class="tab-wrapper">
                    <div class="tab-block tab-last-quote current">Derniers devis</div>
                    <div class="tab-block tab-last-signed-quote">Derniers devis validés</div>
                </div>

                <div class="inner-table-wrapper last-quote-wrapper display">

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

                <div class="inner-table-wrapper last-signed-quote-wrapper">

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

        </div>

        <div class="summary-block">

            <h4 class="block-title">
                10 plus gros clients
            </h4>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table">
                    <div class="tr">
                        <div class="column">
                            <div class="th">Client</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Genre</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Contrat(s)</div>
                            <div class="td">
                                Selfizee Pro
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                50 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column">
                            <div class="th">Client</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Genre</div>
                            <div class="td">
                                Particulier
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Contrat(s)</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                35 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column">
                            <div class="th">Client</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Genre</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Contrat(s)</div>
                            <div class="td">
                                Selfizee Pro
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                30 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column">
                            <div class="th">Client</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Genre</div>
                            <div class="td">
                                Professionnel
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Contrat(s)</div>
                            <div class="td">
                                Selfizee Pro
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                27 680 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column">
                            <div class="th">Client</div>
                            <div class="td">
                                <a href="#">Nom & Prénom</a>
                            </div>
                        </div>
                        <div class="column client-column">
                            <div class="th">Genre</div>
                            <div class="td">
                                Particulier
                            </div>
                        </div>
                        <div class="column antenne-column">
                            <div class="th">Contrat(s)</div>
                            <div class="td">
                                Selfizee Part
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                25 840 &euro;
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

