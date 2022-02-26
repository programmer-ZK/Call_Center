<?php
include_once("includes/config.php");
include_once("includes/ticket_sys/config.php");
include_once("classes/admin.php");
	$admin = new admin();	
include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();	
include_once("classes/reports.php");
	$reports = new reports();
include_once("classes/all_agent.php");
$all_agent = new all_agent();	

if(isset($_REQUEST['export']))
{
date_default_timezone_set('Asia/Karachi');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
require_once dirname(__FILE__) . '/classes/PHPExcel.php';
// Create new PHPExcel object
//$objPHPExcel = new PHPExcel();
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/mytickets.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
$agent_id = $_SESSION[$db_prefix.'_UserId']; 
$agent_name = $_SESSION[$db_prefix.'_UserName']; 
$tickets = ClientInfo::getAgentTickets($agent_id,$_REQUEST['fdate']);

$index = 9;
if(mysql_num_rows($tickets) > 0){
while($ticket = mysql_fetch_object($tickets)){
	print_r($ticket);
	die;
	 $p_desc = getPriorityById($ticket->priority_id);
	$objWorksheet->setCellValue('A'.$index, $ticket->ticket_id)
            ->setCellValue('B'.$index, $ticket->created)
			->setCellValue('C'.$index, $ticket->subject)
			->setCellValue('D'.$index, $ticket->team)
			->setCellValue('E'.$index, $ticket->status)
			->setCellValue('F'.$index, $ticket->duedate)
			->setCellValue('G'.$index, $p_desc->priority_desc)
			->setCellValue('H'.$index, $ticket->name)
			->setCellValue('I'.$index, $agent_name);			
			
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);
}
}

//die('here'.$index);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="mytickets.xls"');
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

