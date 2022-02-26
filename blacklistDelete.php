<?php include_once("includes/config.php"); 
?>

<?php
    $IndexNo = $_POST['id'];
	$sql = "DELETE FROM `cc_blacklist` WHERE `IndexNo` = $IndexNo;";
	$rs = $db_conn->Execute($sql);
    header('Location: ' . $_SERVER['HTTP_REFERER']);

?>