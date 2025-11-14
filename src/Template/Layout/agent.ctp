<?php $siteDescirption ='CRM Selfizee'; ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->Html->meta('favicon.png',["rel"=>"icon", "type"=>"image/png", "sizes"=>"16x16"]) ?>
    <title>
        <?= $siteDescirption ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    
    <?= $this->fetch('css') ?>

    <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('plugins/bootstrap.min.css') ?>
    <!-- Custom CSS -->
    <?= $this->Html->css('style.css?'.  time()) ?>
    <?= $this->Html->css('custom.css?'.  time()) ?>
    
    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('colors/green.css') ?>
    
    
    
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
        <?= $this->element('preloader'); ?>
        <div id="main-wrapper">
            <?= $this->element('header'); ?>
            <?= $this->element('menu_agent'); ?>
            <div class="page-wrapper">
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->
                    <div class="row page-titles">
                        <!-- Bread Crum -->
                        <div class="col-md-6 col-8 align-self-center">
                            <?= $this->fetch('breadcumb'); ?>
                        </div>
                        <!-- Page Tilte And Action -->
                        <div class="col-md-6 col-4 align-self-center">
                            <?= $this->fetch('actionTitle'); ?>
                            <!--<button class="right-side-toggle waves-effect waves-light btn-info btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            <button class="btn pull-right hidden-sm-down btn-success"><i class="mdi mdi-plus-circle"></i> Create</button>
                            <div class="dropdown pull-right m-r-10 hidden-sm-down">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    January 2017
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">February 2017</a>
                                    <a class="dropdown-item" href="#">March 2017</a>
                                    <a class="dropdown-item" href="#">April 2017</a>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Bread crumb and right sidebar toggle -->
                    <!-- ============================================================== -->

                    <!-- Content Page -->
                    <?= $this->Flash->render() ?>
                    
                    <?= $this->fetch('content') ?>
                    

                </div>

                <?= $this->element('footer'); ?>
        </div>

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?= $this->Html->script('jquery/jquery.min.js') ?>
    <!-- Bootstrap tether Core JavaScript -->
    <?= $this->Html->script('bootstrap/popper.min.js') ?>
    <?= $this->Html->script('bootstrap/bootstrap.min.js') ?>
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
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <?= $this->Html->script('styleswitcher/jQuery.style.switcher.js') ?>

    <?= $this->fetch('script') ?>

</body>
</html>