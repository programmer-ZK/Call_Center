<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php 
$arr = array();
if($_REQUEST['ticket_id'] && $_REQUEST['file_id']){
 $arr['msg'] = DeleteFile($_REQUEST['ticket_id'],$_REQUEST['file_id']);
 echo json_encode($arr);	
}
//

?>
