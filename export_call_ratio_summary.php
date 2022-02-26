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
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/call_summary_ratio.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
$fdate 			= $_REQUEST["_fdate"];
$tdate 			= $_REQUEST["_tdate"];	
//$rs_agent_name = $admin->hourly_ratio_summary($fdate,$tdate);

//print_r($_REQUEST);
//print_r($rs_agent_name->fields);
//die;

$index = 9;
$inbound = 0;
$outbound = 0;
$total = 0;
$in =0;
$out =0;

$objWorksheet->setCellValue('A3', 'FROM : '.date('M-d-Y',strtotime($fdate)))
->setCellValue('A4', 'To  :'.date('M-d-Y',strtotime($tdate)));
$total =0;
 for ($i=0; $i < 24; $i++) {
	 $start_h = $i.":00:00";
	 $endh =  $i.":59:00";
	 $in += $rs->fields['inbound'];
	 $out += $rs->fields['outbound'];
	 $rs = $admin->hourly_summarm_hbm($fdate,$tdate,$start_h,$endh);
	 $total+= $rs->fields['calls_count'];
	 $objWorksheet->setCellValue('A'.$index, ($rs->fields['time_slots'])? $rs->fields['time_slots']: $i.':00 -'.$i.':59')
			->setCellValue('B'.$index,  $rs->fields['inbound'])
			->setCellValue('C'.$index,  $rs->fields['outbound'])
			->setCellValue('D'.$index, ($rs->fields['calls_count'])? $rs->fields['calls_count'] : "0");
					
     $index++;
	$count++;
	$objWorksheet->insertNewRowBefore($index,1);
	}

$index =$index+1;
$objWorksheet->setCellValue('A'.$index, 'Grand Total')
->setCellValue('B'.$index, $total)
->setCellValue('C'.$index, $in)
->setCellValue('D'.$index, $out);
           
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="call_summary_ratio.xls"');
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

