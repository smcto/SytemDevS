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

    <!-- Font Awesome section -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- End of Font Awesome section -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1" rel="stylesheet">

    <?= $this->Html->css('pipeline/pages/datepicker.css') ?>

    <?= $this->Html->css('customized-elements/popup-container.css') ?>

    <?= $this->Html->css('pipeline/pages/theme.css') ?>
    <?= $this->Html->css('pipeline/pages/custom_pipe.css') ?>
</head>
<body class="">
    <?php use Cake\Routing\Router; ?>
    <input type="hidden" id="id_baseUrl" value="<?php echo Router::url('/', true) ; ?>"/>
    <div id="main-wrapper">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>


    <?= $this->Html->script('pipeline/pages/jquery.min.js') ?>
    <?= $this->Html->script('pipeline/pages/popper.min.js') ?>
    <?= $this->Html->script('pipeline/pages/bootstrap.js') ?>

    <?= $this->Html->script('pipeline/pages/autosize.min.js') ?>
    <?= $this->Html->script('pipeline/pages/flatpickr.min.js') ?>
    <?= $this->Html->script('pipeline/pages/prism.js') ?>
    <?= $this->Html->script('pipeline/pages/draggable.bundle.legacy.js') ?>
    <?php //$this->Html->script('https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/droppable.js') ?>


    <?= $this->Html->script('pipeline/pages/swap-animation.js') ?>
    <?= $this->Html->script('pipeline/pages/dropzone.min.js') ?>
    <?= $this->Html->script('pipeline/pages/list.min.js') ?>
    <?= $this->Html->script('pipeline/pages/theme.js') ?>

    <!--<?= $this->Html->script('pipeline/pages/ckeditor.js') ?>-->

    <!--<script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>-->

    <?= $this->Html->script('https://cdn.ckeditor.com/4.14.1/full/ckeditor.js') ?>

    <?= $this->Html->script('pipeline/pages/adapters/jquery.js') ?>

    <?= $this->Html->script('pipeline/pages/datepicker.js') ?>
    <?= $this->Html->script('pipeline/pages/datepicker.fr-FR.js') ?>


    <?= $this->Html->script('customized-elements/popup-container.js') ?>

    <?= $this->Html->script('pipeline/pages/theme-custom.js') ?>

    <?= $this->Html->script('pipeline/global.js') ?>

    <?= $this->fetch('script') ?>

</body>
</html>
