<?php include_once("includes/config.php"); ?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include_once("classes/campaign.php");
        $campaign = new campaign();
		include_once("classes/agent.php");
        $agent = new agent();
?>

<?php
$question=$_REQUEST["q"];
$name=$_REQUEST["x"];
$campaign_id=$_REQUEST["y"];
$caller_id=$_REQUEST["z"];
//echo $caller_id.'asda';exit;
$result= $agent->campaign_answers_data2($campaign_id,$question,$name,$caller_id);
echo strip_tags($result->fields['answer']);

?>
