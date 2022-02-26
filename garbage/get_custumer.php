<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "list";
        $page_title = "List";
        $page_menu_title = "List";
?>
<?php if($_SESSION['admin_login'] <> "true"){ header ("Location: login.php");}?>

<?php
        include_once("classes/customers.php");
        $customers = new customers();
        global $customers;
	//echo 'uajua'; exit;
?>
<?php

	$caller_id = $_GET['caller_id'];
	
	$rs  = $customers->get_customer(0,$caller_id);

//	$output = $rs->fields["caller_id"]."|".$rs->fields["last_name"]."|".$rs->fields["father_name"]."|".$rs->fields["mother_name"]."|". $rs->fields["cnic"]."|". $rs->fields["email"]."|". $rs->fields["pass"]."|". $rs->fields["company_name"]."|". $rs->fields["city"]."|".$rs->fields["country"]."|".$rs->fields["type"]."|". $rs->fields["gender"]."|". $rs->fields["description"]."|". $rs->fields["cell_no"]."|". $rs->fields["query"]."|". $rs->fields["status"]."|". $rs->fields["staff_id"];	 

	    $output = $rs->fields["caller_id"]."|".$rs->fields["first_name"]."|".$rs->fields["last_name"]."|".$rs->fields["gender"]."|".$rs->fields["city"]."|".$rs->fields["email"]."|".$rs->fields["cell_no"]."|".$rs->fields["company_name"]."|".$rs->fields["query"]."|".$rs->fields["description"];

	echo $output;
?>
