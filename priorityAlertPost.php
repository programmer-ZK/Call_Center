<?php include_once("includes/config.php"); 
session_start();
?>

<?php
    $_SESSION['priorityAlertError'] = '';
    $number=$_POST['number'];
    if($number != null || $number != ''){
        if(preg_match('/^[0-9]{3,11}+$/', $number)){
	$sql = "INSERT INTO `cc_priorityalerts`( `Number`,`Alert`)VALUES ('$number','0')";
	$rs = $db_conn->Execute($sql);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        $_SESSION['priorityAlertError'] = 'Please Enter Valid Number';
        header('Location: ' . $_SERVER['HTTP_REFERER']);

    }
    }else{
        $_SESSION['priorityAlertError'] = 'Please Enter Number First';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

?>
