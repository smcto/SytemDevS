<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
    <head>
        <?php if(!Configure::read('debug')){ ?>
            <!-- Global site tag (gtag.js) - Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-63833362-10"></script>
            <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-63833362-10');
            </script>
        <?php } ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->fetch('meta') ?>

        <?= $this->fetch('css') ?>

        <!-- Bootstrap Core CSS -->
        <?= $this->Html->css('plugins/bootstrap.min.css') ?>
        <!-- Custom CSS -->
        <?= $this->Html->css('style.css?' . time()) ?>
        <?= $this->Html->css('custom.css?' . time()) ?>

        <!-- You can change the theme colors from here -->
        <?= $this->Html->css('colors/green.css') ?>
        <?= $this->fetch('head') ?>
        <style><?= $this->fetch('style') ?></style>
        <?= $this->Html->meta(array('charset' => 'utf-8')) ?>
    </head>
    <body class="fix-header fix-sidebar card-no-border">
        <input type="hidden" value="<?= $stripeApiKeyPublic ?>" id="apiKeyPublic"
        <div id="main-wrapper">
            <div class="container-fluid">
                <!-- Content Page -->
                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <?= $this->Html->script('jquery/jquery.min.js') ?>
        <?= $this->Html->script('bootstrap/popper.min.js') ?>
        <?= $this->Html->script('bootstrap/bootstrap.min.js') ?>
        <?= $this->fetch('script') ?>
    </body>
</html>
