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
$objPHPExcel = new PHPExcel();
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/work-code_summary.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
$fdate 			= $_REQUEST["fdate"];
$tdate 			= $_REQUEST["tdate"];	
$workcode       = $_REQUEST["_workcode"];

$rs_agent_name = $admin->work_code_summary($fdate,$tdate,$workcode);
$index = 9;
$inbound = 0;
$outbound = 0;
$gtotal = 0;
$objWorksheet->setCellValue('A3',date('M-d-Y',strtotime($fdate))."  To  ".date('M-d-Y',strtotime($tdate)));
while (!$rs_agent_name->EOF){
 $inbound += $rs_agent_name->fields['inbound'];
 $outbound+= $rs_agent_name->fields['outbound'];
 $gtotal+= ($rs_agent_name->fields['inbound']+$rs_agent_name->fields['outbound']);
$objWorksheet->setCellValue('A'.$index, $rs_agent_name->fields['workcodes'])
			->setCellValue('B'.$index, $rs_agent_name->fields['inbound'])
			->setCellValue('C'.$index, $rs_agent_name->fields['outbound'])
			->setCellValue('D'.$index, $rs_agent_name->fields['inbound']+$rs_agent_name->fields['outbound']);
					
	$rs_agent_name->MoveNext();
	$index++;
	$count++;
	$objWorksheet->insertNewRowBefore($index,1);
}
$index =$index+1;
$objWorksheet->setCellValue('A'.$index, 'Grand Total')
->setCellValue('B'.$index, $inbound)
->setCellValue('C'.$index, $outbound)
->setCellValue('D'.$index, $gtotal);

           
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="work_code_summary.xls"');
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

