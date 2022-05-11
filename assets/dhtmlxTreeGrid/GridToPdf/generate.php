<?php

require_once 'gridPdfGenerator.php';
require_once 'lib/class.ezpdf.php';
require_once 'gridPdfWrapper.php';

$fileName = 'grid.xml';

$xml = new SimpleXMLElement($_POST['mycoolxmlbody'], LIBXML_NOCDATA);
/*
if (!file_exists($fileName)) {
	die('File not found!');
} else {
	$xml = simplexml_load_file($fileName);
}
*/


$pdf = new gridPdfGenerator();
$pdf->printGrid($xml);

?>