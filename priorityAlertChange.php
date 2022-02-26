<?php include_once("includes/config.php"); 
session_start();
?>

<?php
    $changeNumber=$_POST['rdio'];
    if($changeNumber){
	$sql = "UPDATE `cc_priorityalerts` SET `Alert` = '0'";
    $rs = $db_conn->Execute($sql);
	$sql1 = "UPDATE `cc_priorityalerts` SET `Alert` = '1' WHERE `IndexNo` = $changeNumber;";
	$rs = $db_conn->Execute($sql1);
    return 1;
    }else{
        $dd = $_POST['dd'];
        $sql = "UPDATE `cc_priorityalerts` SET `Alert` = '0'";
        $rs = $db_conn->Execute($sql);
    return 1;

    }
?>