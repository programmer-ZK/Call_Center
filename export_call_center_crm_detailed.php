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
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/call_center_crm_summary_report.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
//print_r($_REQUEST);
//die;
// Add some data
$frdate =($_REQUEST['frdate'])?date('Y-m-d', strtotime($_REQUEST['frdate'])):'';
$trdate =($_REQUEST['trdate'])?date('Y-m-d', strtotime($_REQUEST['trdate'])):'';
/*$rs = $admin->callcenter_crm_detailed_report($_REQUEST['start'],$_REQUEST['end'],date('Y-m-d', strtotime($_REQUEST['fdate'])),
date('Y-m-d', strtotime($_REQUEST['tdate'])),$_REQUEST['tproduct'],$_REQUEST['tpriority'],$_REQUEST['tstatus'],
$_REQUEST['agent_id'],$_REQUEST['location'],$_REQUEST['e_natures'],$_REQUEST['intime'],$_REQUEST['depart_id'],$_REQUEST['sec'],$frdate,$trdate,$_REQUEST['cmp_id']);*/
$rs = $admin->callcenter_crm_detailed_report("","",date('Y-m-d', strtotime($_REQUEST['fdate'])),
date('Y-m-d', strtotime($_REQUEST['tdate'])),$_REQUEST['tproduct'],$_REQUEST['tpriority'],$_REQUEST['tstatus'],
$_REQUEST['agent_id'],$_REQUEST['location'],$_REQUEST['e_natures'],$_REQUEST['intime'],$_REQUEST['depart_id'],$_REQUEST['sec'],$frdate,$trdate,$_REQUEST['cmp_id']);
//$rs = $admin->getAgentsTickets($agent_id,$_REQUEST['fdate']);
$index = 18;
$tpriority = "";
$tstatus = "";
$actions =array('A'=>'Assigned','E'=>'Edit','R'=>'Reply','SA'=>'Self Assigned','SC'=>'Status Changed','RA'=>'Re Assigned');
 $status =array(1=>'Open',2=>'Resolved',3=>'Closed',7=>'Irrelevant');
 $i=0;
while (!$rs->EOF){
	
	if($rs->fields['name']=="Closed"){
		 $age = $admin->dateDiff($rs->fields['created'],$rs->fields['close_date']);
		}else{
		$age=  $admin->dateDiff($rs->fields['created'],date('Y-m-d H:i:s'));	
		}
	if($rs->fields['nature']=="Others" || $rs->fields['nature']==""){ 
		$nature =  $rs->fields['nature'].' '.$rs->fields['others'];
	   }else{
	       $nature =  $rs->fields['nature'];
		}
$depart =""; //$depart_sec="";  
	if($rs->fields['dept_name']){
	 $depart = explode(" ",$rs->fields['dept_name']);  }
	 else{
	 $depart = explode(" ",$rs->fields['tdepart_name']);
	 }
$res_duration ="";
//if($rs->fields['dept_name']){ 
              if($rs->fields['last_agent_response']){
						$res_duration =  $admin->dateDiff($rs->fields['last_agent_response'],$rs->fields['response_time']); 
					  }else{
						$res_duration =   $admin->dateDiff($rs->fields['created'],$rs->fields['response_time']); 
					  }   // else{ $res_duration = "--";}
	/*				  
	$res_duration =  ($rs->fields['last_agent_response'])? $admin->dateDiff($rs->fields['last_agent_response'],$rs->fields['response_time']):($rs->fields['action_type']!="E")?$admin->dateDiff($rs->fields['created'],$rs->fields['response_time']):"--";
	*/
	//}else{
	//$res_duration =  "--";
    //}	 
$tpriority =	$rs->fields['priority_desc'];
$tstatus = 	$rs->fields['name'];
$intime_over_due = "All";
if($i==0){
	if($_REQUEST['intime']=="0"){
			$intime_over_due = "In-Time";
			}elseif($_REQUEST['intime']=="1"){
			 $intime_over_due = "Over Due";
			}
	$objWorksheet->setCellValue('A1','CALL CENTER CRM DETAILED REPORT')->setCellValue('D3',date('M-d-Y',strtotime($_REQUEST['fdate'])))
			 ->setCellValue('F3', date('M-d-Y',strtotime($_REQUEST['tdate'])))
			 ->setCellValue('D4',($_REQUEST['frdate'])?date('M-d-Y',strtotime($_REQUEST['frdate'])):"")
			 ->setCellValue('F4', ($_REQUEST['trdate'])?date('M-d-Y',strtotime($_REQUEST['trdate'])):"")
			 ->setCellValue('C5',($_REQUEST['cmp_id'])?$rs->fields['number']:"ALL")
			 ->setCellValue('C6',($_REQUEST['tproduct'])?$_REQUEST['tproduct']:"ALL")
			 ->setCellValue('C7',($_REQUEST['tpriority'])?$tpriority: "ALL")
			 ->setCellValue('C8',($_REQUEST['tstatus'])?$tstatus: "ALL")
			 ->setCellValue('C9',($_REQUEST['depart_id'])?$depart[0].' '.$depart[1]: "ALL")
			 ->setCellValue('C10',($_REQUEST['sec'])?$depart[1]: "ALL")
			 ->setCellValue('C11',($_REQUEST['e_natures'])?$rs->fields['nature']: "ALL")
			 ->setCellValue('C12',($_REQUEST['agent_id'])?$rs->fields['creater']: "ALL")
			 ->setCellValue('C13',($_REQUEST['location'])?$rs->fields['location']: "ALL")
			 ->setCellValue('C14',$intime_over_due)
			 
			 ->setCellValue('O3',"User")
			 ->setCellValue('O4',"Time")
			 ->setCellValue('P3',$_SESSION[$db_prefix.'_UserName'])
			 ->setCellValue('P4',date('d-m-Y h:i:s a'));

	
}
$i++;
	$objWorksheet->setCellValue('A'.$index, $rs->fields['number'])
            ->setCellValue('B'.$index, $rs->fields['date_time'])
			->setCellValue('C'.$index,$age)
			->setCellValue('D'.$index, $rs->fields['time_assigned'])
			->setCellValue('E'.$index, $rs->fields['product'])
			->setCellValue('F'.$index, $nature)
			->setCellValue('G'.$index,$rs->fields['full_name'])
			->setCellValue('H'.$index,$rs->fields['creater'])
			->setCellValue('I'.$index, $rs->fields['location'])
			->setCellValue('J'.$index, ($rs->fields['dept_name'])? $rs->fields['firstname']:"--")
			->setCellValue('K'.$index, ($depart[0])? $depart[0]:"--")
			->setCellValue('L'.$index, ($depart[1])? $depart[1]:"--")
			//->setCellValue('J'.$index, ($rse->fields['dept_name'])? $rs->fields['dept_name']:$rs->fields['tdepart_name'])
			//->setCellValue('K'.$index, ($rse->fields['section'])? $rs->fields['section']:"--")
			//->setCellValue('M'.$index, ($admin->dateDiff($rs->fields['created'],$rs->fields['response_time']))?$rs->fields['response_datetime']:"--")
			->setCellValue('M'.$index, ($rs->fields['created']!= $rs->fields['response_time'])?$rs->fields['response_datetime']:"--")
			->setCellValue('N'.$index, $res_duration)
			->setCellValue('O'.$index, ($rs->fields['action_type'])? $actions[$rs->fields['action_type']] : "Assign")
			->setCellValue('P'.$index, $status[$rs->fields['status_id']])
			->setCellValue('Q'.$index, $rs->fields['priority_desc'])
			->setCellValue('R'.$index, ($rs->fields['isoverdue'])?"Over Due":"In-Time");
	
    $rs->MoveNext();
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);
}

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="call_center_crm_detailed_report.xls"');
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

