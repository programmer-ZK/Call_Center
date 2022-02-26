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

if(isset($_REQUEST['export']))
{
date_default_timezone_set('Asia/Karachi');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
require_once dirname(__FILE__) . '/classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/mytickets.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data

$agent_id = $_SESSION[$db_prefix.'_UserId']; 
$agent_name = $_SESSION[$db_prefix.'_UserName']; 
//print_r($_REQUEST);
//include_once("includes/ticket_sys/config.php");
//$tickets = ClientInfo::getAgentTickets('9039',$_REQUEST['fdate']);
$objWorksheet->setCellValue('B3',date('M-d-Y',strtotime($_REQUEST['fdate'])))
			 ->setCellValue('D3', date('M-d-Y',strtotime($_REQUEST['tdate'])));
if(!empty($_REQUEST['frdate'])){
	
	$objWorksheet->setCellValue('A4', "Reponse Date")
			 ->setCellValue('B4', date('M-d-Y',strtotime($_REQUEST['frdate'])))
			 ->setCellValue('C4', "To")
			 ->setCellValue('D4', date('M-d-Y',strtotime($_REQUEST['trdate'])));

	}			 
$fdate = date('Y-m-d', strtotime($_REQUEST['fdate']));
$tdate = date('Y-m-d', strtotime($_REQUEST['tdate']));
$frdate = date('Y-m-d', strtotime($_REQUEST['frdate']));
$trdate = date('Y-m-d', strtotime($_REQUEST['trdate']));	
if($_REQUEST['is_agent']==0){
  $rs = $admin->getAgentsTickets(0,$fdate,$tdate,$_REQUEST['status'],$frdate,$trdate);
}else{
  $rs = $admin->getAgentsTickets($agent_id,$fdate,$tdate,$_REQUEST['status'],$frdate,$trdate);
}		 
//die;

//print_r($_REQUEST);
//die;

$index = 9;
$priority = array(1=>'Low',2=>'Medium',3=>'High',4=>'Urgent');
while (!$rs->EOF){
	$objWorksheet->setCellValue('A'.$index, $rs->fields['number'])
            ->setCellValue('B'.$index, $rs->fields['created'])
			->setCellValue('C'.$index, $rs->fields['subject'])
			->setCellValue('D'.$index, $rs->fields['team'])
			->setCellValue('E'.$index, $rs->fields['STATUS'])
			->setCellValue('F'.$index, $rs->fields['duedate'])
			->setCellValue('G'.$index,$priority[$rs->fields['priority_id']])
			->setCellValue('H'.$index, $rs->fields['name'])
			->setCellValue('I'.$index, $rs->fields['full_name']);
	
    $rs->MoveNext();
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);
}
/*while($ticket = mysql_fetch_object($tickets)){
	
	 $p_desc = getPriorityById($ticket->priority_id);
	$objWorksheet->setCellValue('A'.$index, $ticket->ticket_id)
            ->setCellValue('B'.$index, $ticket->created)
			->setCellValue('C'.$index, $ticket->subject)
			->setCellValue('D'.$index, $ticket->team)
			->setCellValue('E'.$index, $ticket->status)
			->setCellValue('F'.$index, $ticket->duedate)
			->setCellValue('G'.$index, $p_desc->priority_desc)
			->setCellValue('H'.$index, $ticket->name)
			->setCellValue('I'.$index, 'dsadsd');			
			
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);

}*/			
	

//die('here'.$index);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Tickets.xls"');
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

