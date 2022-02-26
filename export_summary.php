<?php
include_once("includes/config.php");
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
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
$objPHPExcel2 = PHPExcel_IOFactory::load("templates/summary.xlsx");
$objWorksheet = $objPHPExcel2->setActiveSheetIndex();
// Add some data
//print_r($_REQUEST);
//die;
  $rs_agent_name = $admin->get_agent_summary($_REQUEST['search'],date('Y-m-d', strtotime($_REQUEST['fdate'])),date('Y-m-d', strtotime($_REQUEST['tdate'])),"","");
//  print_r($_REQUEST);
 // die; 
  //$rs_agent_name = $admin->get_agent_summary($search_keyword,$fdate,$tdate);
if(empty($_REQUEST['search'])){
	$objWorksheet->setCellValue('B2',"All")
			->setCellValue('B3', date('M-d-Y',strtotime($_REQUEST['fdate']))." To ".date('M-d-Y',strtotime($_REQUEST['tdate'])))
			->setCellValue('B4', "ALL");
}
$index = 9;
$total = array('inbound_call_no'=>'','inbound_call_duration'=>'','outbound_call_no'=>'','outbound_call_duration'=>'',
               'abandon_calls'=>'','droped_calls'=>'','break_time'=>'','assignment_time'=>'','busy_duration'=>'','login_duration'=>'');

while (!$rs_agent_name->EOF){
if(!empty($_REQUEST['search'])){
	$objWorksheet->setCellValue('B2',$rs_agent_name->fields['full_name'])
			->setCellValue('B3', date('M-d-Y',strtotime($_REQUEST['fdate'])))
			->setCellValue('B4', $rs_agent_name->fields['department']);
}	
$rs_in_bound = $admin->get_agent_in_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);
$rs_out_bound = $admin->get_agent_ob_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);
$rs_login = $admin->get_agent_login_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);
$rs_break_assign = $admin->get_agent_break_assign_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);
$rs_drop_name = $admin->get_agent_drop_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);
$rs_abandoned = $admin->get_agent_abandoned_summary($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['update_datetime']);

    $total['outbound_call_no'] += $rs_out_bound->fields['outbound_call_no'];
	if(!empty($rs_out_bound->fields['outbound_call_duration'])){
    	$str_time = $rs_out_bound->fields['outbound_call_duration'];
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds2 = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	    $total['outbound_call_duration'] += $time_seconds2; 
	
	}
	/*$str_time = $rs_out_bound->fields['outbound_call_duration'];
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds2 = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['outbound_call_duration'] += $time_seconds2; */
	$total['inbound_call_no'] += $rs_in_bound->fields['inbound_call_no'];
    if($rs_in_bound->fields['inbound_call_duration']){
	$str_time = $rs_in_bound->fields['inbound_call_duration'];
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['inbound_call_duration'] += $time_seconds ; 
    }
	
	$total['abandon_calls'] += $rs_abandoned->fields['abandon_calls'] ; 
	$total['droped_calls'] += $rs_out_bound->fields['droped_calls'] ; 
	
	if($rs_break_assign->fields['break_time']){
	$str_time =($rs_break_assign->fields['break_time'])?$rs_break_assign->fields['break_time']:'00:00:00';
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['break_time'] += $time_seconds ; 
	}
	if($rs_break_assign->fields['assignment_time']){
	$str_time = $rs_break_assign->fields['assignment_time'];
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['assignment_time'] += $time_seconds ; 
	}
	//if($rs_agent_name->fields['inbound_busy_duration']){
	$bd = $tools_admin->sum_the_time($rs_in_bound->fields['inbound_busy_duration'],$rs_out_bound->fields['outbound_busy_duration']);
	$str_time = $bd;
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	$total['busy_duration'] += $time_seconds ; 
	$bd = $time_seconds;  // mad change time format 12-03-2016
	//}
	
	 $duration = $rs_login->fields['login_duration'];
	        if($rs_agent_name->fields['update_datetime']==date('Y-m-d') && $rs_drop_name->fields['is_crm_login']==1){
				$duration =  '00:00:00';
			 }else{
			
				 if($rs_login->fields['login_duration']){
					$str_time = $rs_login->fields['login_duration'];
					sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
					$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
					$total['login_duration'] += $time_seconds ; 
				}      
			 
			}
   		   $logout = $rs_login->fields['logout_time'];
   		   if($rs_agent_name->fields['update_datetime']==date('Y-m-d') && $rs_drop_name->fields['is_crm_login']==1){
	       		$logout = 'Logged In'; 
		   }
	$objWorksheet->setCellValue('A'.$index, date('d-m-Y',strtotime($rs_agent_name->fields['update_datetime'])))
	        ->setCellValue('B'.$index, $rs_drop_name->fields['full_name'])
            ->setCellValue('C'.$index, $rs_in_bound->fields['inbound_call_no'])
			->setCellValue('D'.$index, $rs_in_bound->fields['inbound_call_duration'])
			->setCellValue('E'.$index, $rs_out_bound->fields['outbound_call_no'])
			->setCellValue('F'.$index, $rs_out_bound->fields['outbound_call_duration'])
			->setCellValue('G'.$index, $rs_abandoned->fields['abandon_calls'])
			->setCellValue('H'.$index, $rs_drop_name->fields['droped_calls'])
			->setCellValue('I'.$index, ($rs_break_assign->fields['break_time'])?$rs_break_assign->fields['break_time']:'00:00:00')
			->setCellValue('j'.$index, $rs_break_assign->fields['assignment_time'])
			->setCellValue('K'.$index, $rs_login->fields['login_time'] )
			->setCellValue('L'.$index, ($bd)?date("H:i:s", strtotime("00:0:00 +".$bd." seconds")):'00:00:00' )
			->setCellValue('M'.$index, $duration)
			->setCellValue('N'.$index, $logout)
			->setCellValue('O'.$index, $rs_drop_name->fields['department']);			
			// $rs_login->fields['logout_time'];
	$rs_agent_name->MoveNext();
	$index++;
	$objWorksheet->insertNewRowBefore($index,1);
}
$index += 1;
//echo $total['outbound_call_duration'];
$objWorksheet->setCellValue('C'.$index, $total['inbound_call_no'])
->setCellValue('D'.$index, ($total['inbound_call_duration'])?date("H:i:s", strtotime("00:0:00 +".$total['inbound_call_duration']." seconds")):'00:00:00')
->setCellValue('E'.$index, $total['outbound_call_no'])
->setCellValue('F'.$index, ($total['outbound_call_duration']) ? date("H:i:s", strtotime("00:0:00 +".$total['outbound_call_duration']." seconds")):'00:00:00')
->setCellValue('G'.$index, $total['abandon_calls'])
->setCellValue('H'.$index, $total['droped_calls'])
->setCellValue('I'.$index, ($total['break_time'])? date("H:i:s", strtotime("00:0:00 +".$total['break_time']." seconds")):'00:00:00')
->setCellValue('J'.$index, ($total['assignment_time'])? date("H:i:s", strtotime("00:0:00 +".$total['assignment_time']." seconds")):'00:00:00')
->setCellValue('L'.$index, ($total['busy_duration'])? date("H:i:s", strtotime("00:0:00 +".$total['busy_duration']." seconds")):'00:00:00')
->setCellValue('M'.$index, ($total['login_duration'])?date("H:i:s", strtotime("00:0:00 +".$total['login_duration']." seconds")):'00:00:00');
//die('here'.$index);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="summary.xls"');
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

