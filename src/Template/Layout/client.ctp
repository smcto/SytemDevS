<?php $siteDescription ='CRM Selfizee'; ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $siteDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <!-- Bootstrap Core CSS -->
    <?= $this->Html->css('plugins/bootstrap.min.css') ?>
    <!-- Custom CSS -->
    <?= $this->Html->css('style.css?'.  time()) ?>
    <?= $this->Html->css('client.css') ?>

    
    <!-- You can change the theme colors from here -->
    <?= $this->Html->css('colors/green.css') ?>
    
    <?= $this->fetch('css') ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <?= $this->element('preloader'); ?>
	
	<header class="text-center">
		<?php echo $this->Html->image('logo.png', ['alt' => 'Logo selfizee']); ?>
	</header>
	
	<section class="sl-banniere text-center">
		<div class="sl-evenement">
		<?php
			if(isset($fin) && $fin){
				// Fin des étapes
				echo '<h2>Fin des étapes</h2>';
			}else{
				// Titre de l'évènement
				if(isset($evenement)){
					setlocale(LC_TIME, 'fr_FR.utf8','fra'); 
					$date_evenement = strftime("%A %d %B %Y", strtotime($evenement->date_debut_immobilisation));
					$lieu_exact = $evenement->lieu_exact;
					
					echo '<h2>'.$evenement->nom_event.'</h2>';
					echo '<h3>'.$date_evenement.' - '.$lieu_exact.'</h3>';
				}
			}
		?>
		</div>
	</section>
	
	<?php if(!isset($fin) || !$fin){ ?>
	<section class="sl-header">
		<div class="container">
			<?php if(isset($evenement)){ ?>
			<aside class="text-center sl-header-box">
				<p class="text-center" style="padding: 0 124px;">
					Afin de préparer au mieux votre évènement, merci de nous renseigner les informations suivantes, permettant à toute l'équipe de collaborer dans les meilleurs conditions.
				</p>
			</aside>
			<?php } ?>
			<aside class="text-center sl-footer-box">
				<div class="sl-separateur"></div>
				<p class="text-center">Pour toute question n'hesitez pas à nous contacter au 02 96 76 63 57 ou sur contact@konitys.fr</p>
			</aside>
		</div>
    </section>
	
	<?php } ?>
	
	<section class="sl-body">
		<div class="container">
			<aside class="sl-body-box">
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
			</aside>
		</div>
    </section>
	
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <?= $this->Html->script('jquery/jquery.min.js') ?>
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
