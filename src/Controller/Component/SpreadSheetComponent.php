<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SpreadSheetComponent extends Component
{
    protected $_defaultConfig = [];

    public function initialize(array $config = [])
    {
        ini_set('memory_limit', '16G');
    	parent::initialize($config);
    }

    function read($filePath)
    {
    	$fullPath = $filePath;
    	$fileType = IOFactory::identify($fullPath);
    	$objReader = IOFactory::createReader($fileType);
        $objReader->setinputencoding('ISO-8859-1');
    	// $objReader->setinputencoding('UTF-8');
    	$objReader->setReadDataOnly(true);
    	$spreadsheet = $objReader->load($fullPath);

    	$results = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    	return $results;
    }
}