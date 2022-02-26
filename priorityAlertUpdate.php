<?php include_once("includes/config.php"); 
session_start();
?>

<?php
    $_SESSION['priorityAlertErrorUpdate'] = '';
    $number=$_POST['numberUpdate'];
    $IndexNo=$_POST['numberUpdateID'];
    if($number != null || $number != ''){
        if(preg_match('/^[0-9]{3,11}+$/', $number)){
	$sql = "UPDATE `cc_priorityalerts` SET `Number` = '$number' WHERE `IndexNo` = $IndexNo;";
	$rs = $db_conn->Execute($sql);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        $_SESSION['priorityAlertErrorUpdate'] = 'Please Enter Valid Number For Update Number';
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }
    }else{
        return 'Error';
    }

?>