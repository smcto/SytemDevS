<?= $this->Html->script('Clients/dashboard.js', ['block' => true]); ?>

<?php
$titrePage = "Tableau de bord Clients" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Clients',
    ['controller' => 'Clients', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');

?>

<?php
$this->end();
?>


<div class="dashboard-content-wrapper client-dashboard-wrapper">

    <div class="summary-section top-main-summary-wrapper">
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    1 390
                </h2>
                <h6 class="description">
                    nb total de clients
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-file-text-o font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    840
                </h2>
                <h6 class="description">
                    nb de clients pro
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 28.055 28.055"><path d="M14.249 1.027c-.036 0-.07.009-.104.009-.106-.003-.211-.01-.318-.009h.422zm-.164 16.274c-.019 0-.036-.003-.055-.003-.014 0-.027.003-.041.003h.096zm-5.948-5.988c.015-.003.026-.019.042-.023.941 3.405 3.377 5.953 5.852 6.007 2.254-.104 5.022-2.606 5.944-5.994.424.026.848-.474.967-1.17.123-.726-.135-1.374-.572-1.449-.028-.005-.057.013-.084.014-.127-5.603-2.789-7.579-6.141-7.664-3.457.017-6.552 2.419-6.356 7.666-.033 0-.064-.021-.096-.015-.439.075-.695.723-.572 1.449.12.724.576 1.252 1.016 1.179zm10.551 6.957l-3.141 6.146-.496-3.997.775-.636H12.231l.776.636-.497 3.997-3.137-6.146C3.917 19.005 0 21.343 0 27.027h28.055c.002-5.685-3.914-8.021-9.367-8.757z"/></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    550
                </h2>
                <h6 class="description">
                    nb de clients part'
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 496 496"><path d="M388 436.824H108c-8.836 0-16-7.164-16-16v-47.37c0-22.566 13.314-43.093 33.92-52.293 59.93-26.76 56.645-25.855 61.315-25.855h19.017a16 16 0 0115.537 12.177c6.707 27.256 45.713 27.269 52.423 0a16.002 16.002 0 0115.537-12.177c20.466 0 21.517-.406 25.54 1.39l54.792 24.465c20.605 9.2 33.92 29.727 33.92 52.293v47.37c-.001 8.836-7.165 16-16.001 16zM248.391 59.176c-53.89 0-97.732 43.842-97.732 97.732s43.842 97.732 97.732 97.732 97.732-43.842 97.732-97.732-43.842-97.732-97.732-97.732zM94.218 163.712c-33.931 0-61.536 27.605-61.536 61.537 0 33.931 27.605 61.536 61.536 61.536 33.932 0 61.537-27.605 61.537-61.536-.001-33.932-27.606-61.537-61.537-61.537zm307.564 0c-33.932 0-61.537 27.605-61.537 61.537 0 33.931 27.605 61.536 61.537 61.536 33.931 0 61.536-27.605 61.536-61.536 0-33.932-27.605-61.537-61.536-61.537zM472.9 310.29c-33.292-14.868-32.495-15.02-37.05-15.02-23.833 0-39.424-.167-49.97-.219-10.482-.052-13.954 14.007-4.666 18.865 7.605 3.978 12.222 7.371 17.706 13.355 16.003 17.381 17.494 35.776 17.491 51.027-.001 5.523 4.474 9.993 9.997 9.993H480c8.84 0 16-7.17 16-16V345.9c0-15.37-9.07-29.34-23.1-35.61zM60.15 295.27c-4.534 0-3.642.1-37.05 15.02C9.07 316.56 0 330.53 0 345.9v26.39c0 8.83 7.16 16 16 16h53.588c5.526 0 10.004-4.476 9.997-10.001-.018-15.305 1.429-33.569 17.495-51.019 5.457-5.955 10.113-9.378 17.55-13.285 9.269-4.869 5.844-18.887-4.626-18.869-10.609.018-26.198.154-49.854.154z"></path></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    310
                </h2>
                <h6 class="description">
                    nb total de prospects
                </h6>
            </div>
            <div class="right-section">
                <i class="fa fa-file-text-o font-20 mr-2"></i>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    98
                </h2>
                <h6 class="description">
                    nb de prospects pro
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 25.916 25.916"><g><path d="M7.938 8.13c.09.414.228.682.389.849.383 2.666 2.776 4.938 4.698 4.843 2.445-.12 4.178-2.755 4.567-4.843.161-.166.316-.521.409-.938.104-.479.216-1.201-.072-1.583a3.786 3.786 0 00-.146-.138c.275-.992.879-2.762-.625-4.353-.815-.862-1.947-1.295-2.97-1.637-3.02-1.009-5.152.406-6.136 2.759-.071.167-.53 1.224.026 3.231a.57.57 0 00-.144.138c-.289.381-.101 1.193.004 1.672z"></path><path d="M23.557 22.792c-.084-1.835-.188-4.743-1.791-7.122 0 0-.457-.623-1.541-1.037 0 0-2.354-.717-3.438-1.492l-.495.339.055 3.218-2.972 7.934a.444.444 0 01-.832 0l-2.971-7.934s.055-3.208.054-3.218c.007.027-.496-.339-.496-.339-1.082.775-3.437 1.492-3.437 1.492-1.084.414-1.541 1.037-1.541 1.037-1.602 2.379-1.708 5.287-1.792 7.122-.058 1.268.208 1.741.542 1.876 4.146 1.664 15.965 1.664 20.112 0 .336-.134.6-.608.543-1.876z"></path><path d="M13.065 14.847l-.134.003c-.432 0-.868-.084-1.296-.232l1.178 1.803-1.057 1.02 1.088 6.607a.118.118 0 00.232 0l1.088-6.607-1.058-1.02 1.161-1.776c-.379.111-.78.185-1.202.202z"></path></g></svg>
            </div>
        </div>
        <div class="summary-block">
            <div class="left-section">
                <h2 class="number">
                    212
                </h2>
                <h6 class="description">
                    nb de prospects part'
                </h6>
            </div>
            <div class="right-section">
                <svg viewBox="0 0 17.924 17.924"><g><path d="M12.475 8.868l.006-.009-.001-.001z"/><path d="M17.211 10.107s-.183-.249-.616-.415l-.092-.029a6.934 6.934 0 00-.752-.297 4.024 4.024 0 01-.21-.083c-.261-.13-.45-.279-.45-.279l-.203-.203c.361-.374.626-.882.709-1.368a.62.62 0 00.157-.341c.052-.188.117-.517.002-.67l-.02-.022c.108-.396.246-1.214-.244-1.772-.044-.056-.318-.384-.906-.558l-.28-.097c-.463-.143-.754-.174-.766-.176a.19.19 0 00-.063.005.305.305 0 01-.113.013.765.765 0 00-.307.053c-.038.015-.934.374-1.205 1.208-.025.067-.134.422.01 1.292a.266.266 0 00-.058.054c-.116.153-.051.48.002.669a.623.623 0 00.155.339c.072.48.302.942.605 1.296 0 0 .23.398.259.435.729 1.08.821 3.162.83 3.396l.001.015-.001.016c-.012.728-.374.981-.568 1.065-.094.042-.192.079-.291.117.049-.072.097-.197.1-.418 0 0-.071-3.059-.688-3.972 0 0-.176-.24-.593-.399l-.089-.028c-.37-.174-.722-.285-.722-.285a2.843 2.843 0 01-.202-.08c-.25-.125-.433-.268-.433-.268l-.195-.196a2.6 2.6 0 00.681-1.314.587.587 0 00.152-.328c.049-.181.112-.497.001-.644l-.018-.021c.104-.381.236-1.167-.235-1.704-.043-.053-.307-.369-.871-.536l-.27-.092a4.244 4.244 0 00-.736-.169.159.159 0 00-.061.006c-.016.004-.068.018-.109.013a.73.73 0 00-.294.05c-.036.014-.897.359-1.158 1.161-.024.065-.128.406.01 1.242a.226.226 0 00-.055.052c-.111.146-.048.462.001.643a.597.597 0 00.15.326c.069.461.29.906.582 1.246l-.083.127-.002-.008-.003.017a.08.08 0 01.004-.009v.001l-.005.008c-.117.365-1.518.791-1.518.791-.416.159-.592.399-.592.399-.616.913-.688 3.971-.688 3.971.003.219.05.342.097.414a5.038 5.038 0 01-.283-.111c-.194-.084-.557-.339-.568-1.066v-.032c.009-.234.102-2.314.817-3.376a1.73 1.73 0 01.403-.379l-.001-.001c.361-.374.626-.882.709-1.368a.627.627 0 00.158-.341c.052-.188.117-.517.001-.67L6.171 6.4c.108-.396.246-1.214-.244-1.772-.041-.056-.316-.384-.904-.558l-.28-.097c-.463-.143-.754-.174-.766-.176a.19.19 0 00-.063.005.284.284 0 01-.114.014.763.763 0 00-.306.053c-.038.014-.933.373-1.205 1.208-.025.067-.133.422.01 1.292a.245.245 0 00-.058.054c-.116.153-.05.48.001.669a.623.623 0 00.155.339c.072.48.302.942.606 1.296l-.086.132-.002-.009-.004.018.005-.01v.001l-.005.009c-.121.38-1.579.823-1.579.823-.433.166-.616.415-.616.415-.641.95-.716 3.065-.716 3.065.008.482.217.533.217.533 1.473.657 3.785.773 3.785.773.125.004.24-.003.356-.01l.003.012s.87-.045 1.881-.23c1.219.295 2.46.358 2.46.358.119.003.231-.004.342-.011l.003.012s1.295-.066 2.538-.379c1.053.201 1.979.248 1.979.248.124.004.24-.003.356-.01l.003.012s2.312-.117 3.785-.773c0 0 .208-.051.216-.534.003.001-.072-2.114-.713-3.065z"/></g></svg>
            </div>
        </div>
    </div>

    <div class="summary-section all-chart-wrapper">

        <div class="summary-block pie-chart-block contract-summary-block">

            <h4 class="block-title">
                Répartition par Types de contrats pro
            </h4>

            <div class="inner-chart-wrap">
                <canvas></canvas>
            </div>

            <div class="bottom-legend-wrapper legend-wrapper"></div>

        </div>

        <div class="summary-block client-pro-summary-block">

            <h4 class="block-title">
                10 meilleurs clients pro
            </h4>

            <div class="table-wrapper">

                <div class="customized-table rubik-customized-table">
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="column name-column">
                            <div class="th">Enseigne</div>
                            <div class="td">
                                <a href="#">Nom de société</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Date ajout</div>
                            <div class="td">
                                10/06/20
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">Commercial</div>
                            <div class="td">
                                <?php echo $this->Html->image('reglements-en-retard/avatar-3.jpg', ["alt" => "Avatar", "class" => "table-data-avatar"]); ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="th">CA</div>
                            <div class="td">
                                60 000 &euro;
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
