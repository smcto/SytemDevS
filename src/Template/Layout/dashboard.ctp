<?php $siteDescirption ='CRM Selfizee'; ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->meta('favicon.png',["rel"=>"icon", "type"=>"image/png", "sizes"=>"16x16"]) ?>
    <title>
        <?= $this->fetch('title') ? $this->fetch('title') . ' - Manager Konitys' : 'Manager Konitys' ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <?= $this->fetch('css') ?>

    <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('plugins/bootstrap.min.css') ?>
    <?= $this->Html->css('bootstrap-select/bootstrap-select.min') ?>
    <?= $this->Html->css('select2/select2.min.css') ?>
    <?= $this->Html->css('bootstrap-daterangepicker/daterangepicker.css') ?>

    <!-- Custom CSS -->
    <?= $this->Html->css('style.css?'.  time()) ?>
    <?= $this->Html->css('custom.css?'.  time()) ?>

    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('colors/green.css') ?>

    <?= $this->Html->css('animate-css/version_4.1.1/animate.min.css'); ?>

    <?= $this->Html->css('header/header.css'); ?>

    <?= $this->Html->css('customized-elements/customized-scrollbar.css'); ?>
    <?= $this->Html->css('customized-elements/customized-input-search.css'); ?>
    <?= $this->Html->css('customized-elements/customized-select.css'); ?>
    <?= $this->Html->css('customized-elements/customized-table.css'); ?>
    <?= $this->Html->css('dashboard/dashboard.css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body class="fix-header fix-sidebar card-no-border">
    <?php use Cake\Routing\Router; ?>
    <input type="hidden" id="id_baseUrl" value="<?php echo Router::url('/', true) ; ?>"/>
    <?php //$this->element('preloader'); ?>
    <div id="main-wrapper" class="dashboard-main-wrapper">

        <header>

            <?php 
                // -------------- Ancien role / Menu à supprimer si aucune réclammation ----------------
                /*if(!empty($user_connected['typeprofils']) ) { ?>
                <?php if(in_array('admin', $user_connected['typeprofils'])) { ?>
                    <?= $this->element('menu'); ?>
                <?php } else { ?>
                    <?= $this->element('menu_contact'); ?>
                <?php }  ?>
            <?php } else { ?>
                <?= $this->element('menu'); ?>
            <?php }*/ ?>

            <!-- Nouveau -->
            <?= $this->element('menu'); ?>
        </header>

        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <!-- Bread Crum -->
                    <!--<div class="col-md-5 col-5 align-self-center">-->
                    <div class="left-section">
                        <?= $this->fetch('breadcumb'); ?>
                    </div>
                    <div class="right-section">
                        <!--<div class="col-md-5 col-5 align-self-center dashboard-header-period-wrapper">-->
                        <div class="dashboard-header-period-wrapper">
                            <div class="inner-header-wrap">
                                <div class="dropdown label-text">
                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" selected-data-value="2">
                                        <?php if (isset($typeFiltre)): ?>
                                            <?php if ($typeFiltre == 'annee'): ?>
                                                Année
                                            <?php elseif($typeFiltre == 'annee_mois'): ?>
                                                Mois
                                            <?php elseif($typeFiltre == 'custom_range'): ?>
                                                Période personnalisée
                                            <?php endif ?>
                                        <?php endif ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-item <?= @$typeFiltre == "annee" ? "selected" : "" ?>" data-value="2"><a href="<?= $this->Url->build(['annee' => date('Y')]) ?>">Année</a></div>
                                        <div class="dropdown-item <?= @$typeFiltre == "annee_mois" ? "selected" : "" ?>" data-value="1"><a href="<?= $this->Url->build(['annee_mois' => date('Y-m')]) ?>">Mois</a></div>
                                        <div class="dropdown-item <?= @$typeFiltre == "custom_range" ? "selected" : "" ?>" data-value="3"><a href="javascript:void(0);">Période personnalisée</a></div>
                                    </div>
                                </div>
                                <div class="dashboard-header-value dashboard-header-previous-month <?= @$typeFiltre == "annee_mois" ? "display" : "" ?>">
                                    <div class="arrow-wrap prev-wrap">
                                        <svg viewBox="0 0 512 512"><path d="M256 0C114.844 0 0 114.844 0 256s114.844 256 256 256 256-114.844 256-256S397.156 0 256 0zm149.333 266.667a10.66 10.66 0 01-10.667 10.667H175.083l45.792 45.792c2 2 3.125 4.708 3.125 7.542V352c0 4.313-2.594 8.208-6.583 9.854-4 1.667-8.573.74-11.625-2.313l-96-96c-4.167-4.167-4.167-10.917 0-15.083l96-96a10.664 10.664 0 0111.625-2.312A10.655 10.655 0 01224 160v21.333a10.66 10.66 0 01-3.125 7.542l-45.792 45.792h219.583a10.66 10.66 0 0110.667 10.667v21.333z"/></svg>
                                    </div>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" data-toggle="dropdown" selected-data-value="10/2020">
                                            <?= $moisCourant->nom ?? '' ?>. 
                                            <?php if ($this->request->getQuery('annee')): ?>
                                                <?= $annee ?? ''; ?>
                                            <?php elseif(@$extractedYear !== false) : ?>
                                                <?= $extractedYear ?? '' ?>
                                            <?php endif ?>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php if (isset($listeMois)): ?>
                                                <?php foreach ($listeMois as $key => $mois): ?>
                                                    <div class="dropdown-item <?= @$mois['Ym'] == $annee_mois ? 'selected' : '' ?>" data-value="<?= $key ?>"><a class="text-secondary" href="<?= $this->Url->build(['annee_mois' => @$mois['Ym']]) ?>"><?= @$mois['My'] ?></a></div>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="arrow-wrap next-wrap">
                                        <svg viewBox="0 0 512 512"><path d="M256 0C114.844 0 0 114.844 0 256s114.844 256 256 256 256-114.844 256-256S397.156 0 256 0zm149.333 266.667a10.66 10.66 0 01-10.667 10.667H175.083l45.792 45.792c2 2 3.125 4.708 3.125 7.542V352c0 4.313-2.594 8.208-6.583 9.854-4 1.667-8.573.74-11.625-2.313l-96-96c-4.167-4.167-4.167-10.917 0-15.083l96-96a10.664 10.664 0 0111.625-2.312A10.655 10.655 0 01224 160v21.333a10.66 10.66 0 01-3.125 7.542l-45.792 45.792h219.583a10.66 10.66 0 0110.667 10.667v21.333z"/></svg>
                                    </div>

                                </div>
                                <?php if (isset($annee)): ?>
                                    <div class="dashboard-header-value dashboard-header-year <?= @$typeFiltre == "annee" ? "display" : "" ?>">

                                        <div class="arrow-wrap prev-wrap">
                                            <svg viewBox="0 0 512 512"><path d="M256 0C114.844 0 0 114.844 0 256s114.844 256 256 256 256-114.844 256-256S397.156 0 256 0zm149.333 266.667a10.66 10.66 0 01-10.667 10.667H175.083l45.792 45.792c2 2 3.125 4.708 3.125 7.542V352c0 4.313-2.594 8.208-6.583 9.854-4 1.667-8.573.74-11.625-2.313l-96-96c-4.167-4.167-4.167-10.917 0-15.083l96-96a10.664 10.664 0 0111.625-2.312A10.655 10.655 0 01224 160v21.333a10.66 10.66 0 01-3.125 7.542l-45.792 45.792h219.583a10.66 10.66 0 0110.667 10.667v21.333z"/></svg>
                                        </div>
                                        <div class="dropdown">
                                            <button class="dropdown-toggle" data-toggle="dropdown" selected-data-value="2020">
                                                <?= $annee ?>
                                            </button>
                                            <div class="dropdown-menu">
                                                <?php for ($i = date('Y'); $i >= 2017; $i--): ?>
                                                    <div class="dropdown-item <?= $annee == $i ? 'selected' : '' ?>" data-value="<?= $i ?>"><a class="text-secondary" href="<?= $this->Url->build(['annee' => $i]) ?>"><?= $i ?></a></div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <div class="arrow-wrap next-wrap">
                                            <svg viewBox="0 0 512 512"><path d="M256 0C114.844 0 0 114.844 0 256s114.844 256 256 256 256-114.844 256-256S397.156 0 256 0zm149.333 266.667a10.66 10.66 0 01-10.667 10.667H175.083l45.792 45.792c2 2 3.125 4.708 3.125 7.542V352c0 4.313-2.594 8.208-6.583 9.854-4 1.667-8.573.74-11.625-2.313l-96-96c-4.167-4.167-4.167-10.917 0-15.083l96-96a10.664 10.664 0 0111.625-2.312A10.655 10.655 0 01224 160v21.333a10.66 10.66 0 01-3.125 7.542l-45.792 45.792h219.583a10.66 10.66 0 0110.667 10.667v21.333z"/></svg>
                                        </div>

                                    </div>
                                    <?php $fromFormated = isset($from) && $from != null ? date('d/m/Y', strtotime($from)) : date('d/m/Y'); ?>
                                    <?php $toFormated = isset($to) && $to != null ? date('d/m/Y', strtotime($to)) : date('d/m/Y'); ?>
                                    <input class="dashboard-header-value dashboard-header-date-input <?= @$typeFiltre == "custom_range" ? "display" : "" ?>" value="<?= $fromFormated." - ".$toFormated ?>" />
                                <?php endif ?>
                            </div>
                        </div>
                        <!-- Page Tilte And Action -->
                        <!--<div class="col-md-2 col-2 align-self-center header-button-wrapper">-->
                        <div class="header-button-wrapper">
                            <?= $this->fetch('actionTitle'); ?>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <!-- Content Page -->
                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?= $this->Html->script('jquery/jquery.min.js') ?>
    <!-- Bootstrap tether Core JavaScript -->
    <?= $this->Html->script('bootstrap/popper.min.js') ?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js') ?>
    <?= $this->Html->script('bootstrap-select/bootstrap-select.min.js'); ?>
    <?= $this->Html->script('select2/select2.full.min.js'); ?>

    <?= $this->Html->script('daterangepicker/moment.min.js'); ?>
    <?= $this->Html->script('moment/momentjs-with-locales/moment-with-locales.min.js'); ?>
    <?= $this->Html->script('bootstrap-daterangepicker/daterangepicker.js'); ?>

    <!-- slimscrollbar scrollbar JavaScript -->
    <?= $this->Html->script('jquery.slimscroll.js') ?>
    <!--Wave Effects -->
    <?= $this->Html->script('waves.js') ?>
    <!--Menu sidebar -->
    <?= $this->Html->script('sidebarmenu.js') ?>
    <!--stickey kit -->
    <?= $this->Html->script('sticky-kit-master/sticky-kit.min.js') ?>
    <!--Custom JavaScript -->
    <?= $this->Html->script('custom.min.js') ?>
    <?= $this->Html->script('general') ?>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <?= $this->Html->script('styleswitcher/jQuery.style.switcher.js') ?>

    <?= $this->Html->script('header/header.js'); ?>

    <?= $this->Html->script('chart/chartjs_version_2.9.3/chart.min.js'); ?>
    <?= $this->Html->script('customized-elements/customized-input-search.js'); ?>
    <?= $this->Html->script('customized-elements/customized-select.js'); ?>
    <?= $this->Html->script('customized-elements/customized-table.js'); ?>
    <?= $this->Html->script('dashboard/dashboard.js'); ?>

    <?= $this->fetch('script') ?>

</body>
</html>
