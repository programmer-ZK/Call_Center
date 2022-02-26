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

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
if(isset($_REQUEST['export']))
{
date_default_timezone_set('Asia/Karachi');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
require_once dirname(__FILE__) . '/classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/abandoned_calls.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
$fdate 			= date('Y-m-d', strtotime($_REQUEST['fdate']));
$tdate 			= date('Y-m-d', strtotime($_REQUEST['tdate']));	
$start = $_REQUEST["start"];
$end = $_REQUEST["end"];	
$search_keyword = $_REQUEST["search"];
//print_r($_REQUEST);
//die;

$rs_agent_name = $admin->abandoned_call_report($search_keyword,$fdate,$tdate,"","");

$objWorksheet->setCellValue('B2',($search_keyword)? $rs_agent_name->fields['full_name']:"ALL")
			->setCellValue('B3', date('M-d-Y',strtotime($_REQUEST['fdate'])))
			->setCellValue('C3', 'To')
			->setCellValue('D3', date('M-d-Y',strtotime($_REQUEST['tdate'])));
$index = 8;
$count=1;
//$total = array('duration'=>'');
while (!$rs_agent_name->EOF){
	/*$str_time = $rs_agent_name->fields['duration'];
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['duration'] += $time_seconds ; */
	
	$objWorksheet->setCellValue('A'.$index, $count)
            ->setCellValue('B'.$index, $rs_agent_name->fields['full_name'])
			->setCellValue('C'.$index,  date('d-m-Y',strtotime($rs_agent_name->fields['call_date'])))
			->setCellValue('D'.$index, date('h:i:s A', strtotime($rs_agent_name->fields['call_date'].' '.$rs_agent_name->fields['TIME'])))
			->setCellValue('E'.$index, $rs_agent_name->fields['duration'])
			->setCellValue('F'.$index, $rs_agent_name->fields['caller_id'])
			->setCellValue('G'.$index, $rs_agent_name->fields['call_id']);			
			
	$rs_agent_name->MoveNext();
	$index++;
	$count++;
	$objWorksheet->insertNewRowBefore($index,1);
}
//$objWorksheet->setCellValue('E'.$index, date("H:i:s", strtotime("00:0:00 +".$total['duration']." seconds")));

           
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="abandoned_calls.xls"');
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

