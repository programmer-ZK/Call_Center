<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "get_caller.php";
	$page_title = "Get Caller";
?>
<?php
        include_once("classes/tools.php");
        $tools = new tools();
	global $tools;
?>
<?php
	include_once("classes/astman.php");
	$astman = new astman();
	global $astman;
?>
<?php include($site_root."includes/header.php"); ?>
<h1><?php echo($page_title); ?></h1>

<?php
$output = $astman->Login($host="localhost", $username="admin", $password="admin786");

if($output == true)
{
	$output = $astman->Query("ListCommands");
	echo $output;
	$astman->Logout();
}
else{
	echo $output.'yahya';
}
?>


<?php include($site_root."includes/footer.php"); ?>
