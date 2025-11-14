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

    <!-- Custom CSS -->
    <?= $this->Html->css('style.css?'.  time()) ?>
    <?= $this->Html->css('custom.css?'.  time()) ?>
    
    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('colors/green.css') ?>
    
    <?= $this->Html->css('animate-css/version_4.1.1/animate.min.css'); ?>

    <?= $this->Html->css('header/header.css?'. time()); ?>

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
    <div id="main-wrapper">

        <header>
            <?= $this->element('menu'); ?>
        </header>
        
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <!-- Bread Crum -->
                    <div class="col-md-5 col-8 align-self-center">
                        <?= $this->fetch('breadcumb'); ?>
                    </div>
                    <!-- Page Tilte And Action -->
                    <div class="col-md-7 col-4 align-self-center header-button-wrapper">
                        <?= $this->fetch('actionTitle'); ?>
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


    <?= $this->Html->script('https://cdn.ckeditor.com/4.14.1/full/ckeditor.js') ?>
    <?= $this->Html->script('pipeline/pages/adapters/jquery.js') ?>


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

    <?= $this->Html->script('header/header.js'); ?>

    <?= $this->fetch('script') ?>
    <?= $this->Html->script('general') ?>

</body>
</html>
