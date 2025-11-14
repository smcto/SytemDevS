<?php
	// inclusion de la librairie TCPDF
    //require_once ROOT . DS . 'vendor' . DS . 'tecnickcom' . DS . 'tcpdf' . DS . 'tcpdf.php';
    require  ROOT . DS .'vendor/autoload.php';
    // include autoloader
	require_once ROOT . DS . 'vendor' . DS .'dompdf1/dompdf/autoload.inc.php';// autoload.inc.php
	//require_once ROOT . DS . 'vendor' . DS .'dompdf/lib/html5lib/Parser.php';
	//require_once ROOT . DS . 'vendor' . DS .'dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
	//require_once ROOT . DS . 'vendor' . DS .'dompdf/lib/php-svg-lib/src/autoload.php';
	//require_once ROOT . DS . 'vendor' . DS .'dompdf/src/Autoloader.php';
	use Dompdf\Dompdf;
    use Cake\Routing\Router;
    mb_internal_encoding('UTF-8');

    // instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->loadHtml('<h3><span>TESITA </span></h3>');

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');

	ob_clean();
	// Render the HTML as PDF
	$dompdf->render();
	//debug($dompdf);die;

	// Output the generated PDF to Browser
	$dompdf->stream();