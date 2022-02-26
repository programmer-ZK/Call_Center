<?php
include_once("includes/config.php");
include_once("classes/admin.php");
	$admin = new admin();	
include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();	
include_once("classes/reports.php");
	$reports = new reports();
include_once("classes/all_agent.php");
$all_agent = new all_agent();	

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
if(isset($_REQUEST['export']))
{
date_default_timezone_set('Asia/Karachi');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
require_once dirname(__FILE__) . '/classes/PHPExcel.php';
// Create new PHPExcel object
//$objPHPExcel = new PHPExcel();
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/offtime_call_summary.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
$rs = $admin->getofftimecalls($_REQUEST['_fdate'],$_REQUEST['_tdate']);
if(!empty($_REQUEST['_fdate'])){
	$objWorksheet->setCellValue('A3', date('M-d-Y',strtotime($_REQUEST['_fdate'])).' TO '.date('M-d-Y',strtotime($_REQUEST['_tdate'])));
}
$index = 9;
$total=0;
while (!$rs->EOF){
	$total++;
	$objWorksheet->setCellValue('A'.$index, $rs->fields['caller_id'])
            ->setCellValue('B'.$index, $rs->fields['call_status'])
			->setCellValue('C'.$index, $rs->fields['call_date']);		
			
	$rs->MoveNext();
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);
}
$index =$index+1;
$objWorksheet->setCellValue('A'.$index, 'Grand Total')
->setCellValue('B'.$index, $total);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="offtime_call_summary.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel2, 'Excel5');
$objWriter->save('php://output');
exit;	
}
?>

