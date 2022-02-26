<?php include_once("includes/config.php"); ?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include_once("classes/new_campaign.php");
        $new_campaign = new new_campaign();
?>

<?php 

$status=$_REQUEST["q"];
$campaign_id=$_REQUEST["x"];

$new_campaign->change_campaign_statuses($status,$campaign_id);

?>
