<?php include_once("includes/config.php"); ?>
<?php
$page_name = "call_detail";
$page_title = "Call Detail";
$page_level = "2";
$page_group_id = "1";
$page_menu_title = "Call Detail";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
include_once('lib/nusoap.php');

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/user_tools.php");
$user_tools = new user_tools();

?>
<?php include($site_root . "includes/header.php"); ?>
<?php
$unique_id    = $_REQUEST['unique_id'];
$uid    = $_REQUEST['id'];
$rs             = $user_tools->iget_cdr_details($unique_id, $uid);
//print_r($rs); exit;
$call_date              = date('d-m-Y', strtotime($rs->fields["call_date"]));
$call_time              = date("h:i s A", strtotime($rs->fields["call_time"]));
$call_status            = $rs->fields["call_status"];
$userfield              = $rs->fields["userfield"];
$lang                   = $rs->fields["lang"];
$ivr_selection          = $rs->fields["ivr_selection"];
$unique_id              = $rs->fields["unique_id"];
$caller_id              = $rs->fields["caller_id"];
$customer_id            = $rs->fields["customer_id"];
$account_no             = $rs->fields["account_no"];
$enqueue_datetime       = date('d-m-Y  h:i s A', strtotime($rs->fields["enqueue_datetime"]));
$dequeue_datetime       = date('d-m-Y  h:i s A', strtotime($rs->fields["dequeue_datetime"]));
$staff_id               = $rs->fields["staff_id"];
$staff_start_datetime   = date('d-m-Y  h:i s A', strtotime($rs->fields["staff_start_datetime"]));
$staff_end_datetime     = date('d-m-Y  h:i s A', strtotime($rs->fields["staff_end_datetime"]));
$status                 = $rs->fields["status"];
$update_datetime        = $rs->fields["update_datetime"];
$call_type              = $rs->fields["call_type"];
$call_duration          = $rs->fields["call_duration"];
$enqueue_duration       = $rs->fields["enqueue_duration"];
$talk_time              = $rs->fields["talk_time"];
$full_name              = $rs->fields["full_name"];

$url    = 'http://crm:8080/index.php?action=DetailView&module=HelpDesk&parenttab=Support&record=[TicketNumber]';
$replace_pattern    = '[TicketNumenqueue_durationber]';

//$rscdr = $user_tools->get_cdr_details($unique_id);
//$userfield = $rscdr->fields["userfield"];
//print_r($userfield);
//exit;

$workcodes      = $user_tools->iget_call_workcodes($unique_id);
$pin_generate   = $user_tools->iget_call_pin_generate($unique_id);
$pin_generate   = empty($pin_generate) ? "No" : "Yes";
$pin_verify     = $user_tools->iget_call_pin_verify($unique_id);
$pin_verify     = empty($pin_verify) ? "No" : "Yes";
$pin_reset      = $user_tools->iget_call_pin_reset($unique_id);
$pin_reset      = empty($pin_reset) ? "No" : "Yes";
$pin_change     = $user_tools->iget_call_pin_change($unique_id);
$pin_change     = empty($pin_change) ? "No" : "Yes";
$total_holdtime = $user_tools->iget_holdtime($unique_id);
$abandon        = $user_tools->iget_call_abandon($unique_id);

$conversion_trans        = $user_tools->iget_conversion($unique_id);
$redemption_trans        = $user_tools->iget_redemption($unique_id);

//$total_holdtime = empty($total_holdtime)?"00:00:00":$total_holdtime;
/*while(!$rsw->EOF){
                $wcodes.= $rsw->fields["workcodes"].';'.$user_tools->make_url($rsw->fields["detail"],$url,$replace_pattern).'<br>';
                $rsw->MoveNext();
        }*/
?>

<div class="box">
    <h4 class="white">Call Details <?php echo $rs->fields["staff_start_datetime"]; ?></h4>
    <div class="box-container">
        <form action="" method="post" class="middle-forms">
            <fieldset>
                <legend>Fieldset Title </legend>
                <ol>
                    <li>
                        <label class="field-title">Unique ID/Call LogID :</label>
                        <label><?php echo $unique_id; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Call Type</label>
                        <label><?php echo $call_type; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Caller ID :</label>
                        <label><?php echo $caller_id; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Call Date :</label>
                        <label><?php echo $call_date; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Call Time :</label>
                        <label><?php echo $call_time; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Call Status :</label>
                        <label><?php echo $call_status; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Audio / Recording :</label>
                        <!--                        <label><a title="click here to download" target="_blank" href="recording/<?php echo  date('Ymd', strtotime($rs->fields["call_date"])) . "/" . $rs->fields["userfield"]; //$rs->MoveNext(); 
                                                                                                                                ?>.wav" >Rec1 <?php echo $unique_id; ?> </a></label>
                        <?php $ydate = strtotime("-1 day", $date); ?>
		
			<label><a title="click here to download" target="_blank" href="recording/<?php echo date('Ymd', strtotime($rs->fields["call_date"] . "-1 days")) . "/" . $rs->fields["userfield"];
                                                                                        $rs->MoveNext(); ?>.wav" > Rec 2: <?php echo $unique_id; ?> </a></label>-->
                        <label><a title="click here to download" target="_blank" href="recording/<?php echo $unique_id; ?>.wav"><?php echo $unique_id; ?> </a></label>


                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Language :</label>
                        <label><?php echo $lang; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">IVR Selection :</label>
                        <label><?php echo $ivr_selection; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>

                    <!--  <li class="even">
                        <label class="field-title">Customer ID :</label>
                        <label><?php //echo $customer_id; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Account No :</label>
                        <label><?php //echo $account_no; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li> -->
                    <li class="even">
                        <label class="field-title">Agent Name :</label>
                        <label><?php echo $full_name; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>

                    <li>
                        <label class="field-title">Enqueue Start :</label>
                        <label><?php echo $enqueue_datetime; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Enqueue End :</label>
                        <label><?php echo $dequeue_datetime; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Enqueue Duration :</label>
                        <label><?php echo $enqueue_duration; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Agent Start : </label>
                        <label><?php echo $staff_start_datetime; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Agent End : </label>
                        <label><?php echo $staff_end_datetime; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Agent Talk Time : </label>
                        <label><?php echo $talk_time; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Call Duration : </label>
                        <label><?php echo $call_duration; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <!-- <li class="even">
                        <label class="field-title">PGen Attempts : </label>
                        <label><?php //echo $pin_generate; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">PRes Attempts : </label>
                        <label><?php //echo $pin_reset; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">PCha Attempts : </label>
                        <label><?php //echo $pin_change; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">PVer Attempts : </label>
                        <label><?php //echo $pin_verify; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Total HoldTime : </label>
                        <label><?php //echo $total_holdtime; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li>
                        <label class="field-title">Abandon From : </label>
                        <label><?php //echo $abandon; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even">
                        <label class="field-title">Conversion Trans : </label>
                        <label><?php //echo $conversion_trans; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li >
                        <label class="field-title">Redemption Trans : </label>
                        <label><?php //echo $redemption_trans; 
                                ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>-->
                    <li class="even">
                        <label class="field-title">Work Codes :</label>
                        <label><?php echo $workcodes; ?></label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                </ol>
            </fieldset>
            <span class="clearFix">&nbsp;</span>
        </form>
    </div>
</div>
<?php include($site_root . "includes/footer.php"); ?>