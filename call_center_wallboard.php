<?php include_once("includes/config.php"); ?>
<?php
$page_name = "call_center_wallboard.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Call Center Wallboard";
$page_menu_title = "Call Center Wallboard";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
//	include_once("classes/admin.php");
//	$admin = new admin();
//		
//	include_once("classes/tools_admin.php");
//    $tools_admin = new tools_admin();

include_once("classes/reports.php");
$reports = new reports();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}
</style>
<meta http-equiv="refresh" content="45">
<?php
$total_calls     = $reports->get_ccw_total_calls();
$inbound_calls     = $reports->get_ccw_inbound_calls();

$inbound_calls_ACW  = $reports->get_ccw_inbound_calls_ivr();

$ccw_shift_calls = $reports->get_ccw_shift_calls();
$inbound_calls_answer   = $reports->get_ccw_inbound_calls_answer();

$abandon_calls   = $reports->get_ccw_Abandon_calls();

$rs_bs_t = $reports->get_agent_break_times_sum_nopara();
$inbound_calls_offtime   = $reports->get_ccw_inbound_calls_offtime();
$Break = $reports->get_break_agents();

$B = "00:00:00";
$_SESSION['bt'] = "00:00:00";
$i = 0;
$arr_names   = array("Namaz Break", "Lunch Break", "Tea Break", "Auxiliary Break", "Campaign");
$arr_values = array('2', '3', '4', '5', '7');
$duration  = array();

while ($i < 4 /*!$rs_bs_t->EOF*/) {
  if ($arr_values[$i] == $rs_bs_t->fields["crm_status"]) {

    $B = $tools_admin->sum_the_time($B, $rs_bs_t->fields["duration"]);
    $_SESSION['bt'] = $tools_admin->sum_the_time($_SESSION['bt'], $rs_bs_t->fields["duration"]);
    $duration[$i] = $rs_bs_t->fields["duration"];
    $rs_bs_t->MoveNext();
  } else {
    $duration[$i] = "-";
  }
  $i++;
}


$drop_calls        = $reports->get_ccw_inbound_calls_drop();

$ivr_calls         = $reports->get_ccw_inbound_calls_ivr();
$outbound_calls   = $reports->get_ccw_outbound_calls();
//	$drop_calls 		= $reports->get_ccw_drop_calls();
//$service_level 	= $reports->get_ccw_service_level();
$abandoned_calls   = $reports->get_ccw_abandoned_calls();
$busy_agents     = $reports->get_ccw_busy_agents();
$on_call_agents   = $reports->get_ccw_on_call_agents();
$after_cw_agents = $reports->get_after_cw_agents();
$onhold_agents = $reports->get_onhold_agents();


//$service_level	= $total_calls / ($inbound_calls + $drop_calls);
$service_level    = round((($inbound_calls / ($inbound_calls + $drop_calls)) * 100), 2);


?>
<?php
session_start(); // this MUST be at the very top of the page, the only thing before it is <?php 
if (!isset($_SESSION['number'])) {
  $_SESSION['number'] = 0;
} elseif ($_SESSION['number'] == 1) {
  $_SESSION['number'] = 0;
} else {
  $_SESSION['number'] = $_SESSION['number'] + 1;
}
//echo $_SESSION['number'];
$id = isset($_GET['id']) ? $_GET['id'] : "";
if ($id == 'start') {

  $chek = "checked";
  if ($_SESSION['number'] == 1) {
    unset($_SESSION['number']);
    header("Location: agent-stats-summary.php?id=" . $_GET['id']);
  }
} else {
  $chek = "";
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
  <div id="mid-col" class="mid-col">
    <div style="font-size:18px; font-weight:bold; line-height:20px; display:block; text-align:right; margin-bottom:10px;">Auto Switching<input type="radio" name="radio" id="radio" <?php echo $chek; ?> style="width:20px; height:20px; float:right; margin-top:2px;"></div>
    <div class="box">
      <h4 id="np" class="white new_wht">
        <a class="heading-link clr_heading active" href="javascript:;"><?php echo ($page_title); ?></a>
        &nbsp;&nbsp;
        <a class="heading-link clr_heading" href="agent-stats.php"><span>Agent Stats</span></a>
        &nbsp;&nbsp;
        <a class="heading-link clr_heading" href="agent-stats-summary.php"><span>Agent Stats Summary</span></a>
      </h4>
      <div class="box-container">
        <table id="tbl1" style="display:inline-block; width:100%; margin-top:10px;">
          <thead>
            <td style="font-weight: bolder; text-align: center; padding: 10px;">Type</td>
            <td style="font-weight: bolder; text-align: center; padding: 10px;">Calls</td>
          </thead>
          <tbody>
            <tr style="height:25px;">
              <td><i style="color:#FFC107" class="fa fa-square	
                "></i> Inbound Calls Answer</td>
              <td id="inboundCalls"><?php echo $inbound_calls_answer; ?></td>
            </tr>
            <tr style="height:25px;">
              <td><i style="color:#9E9E9E" class="fa fa-square	
                "></i> Drop Calls</td>
              <td id="dropCalls"><?php echo $drop_calls; ?></td>
            </tr>
            <tr style="height:25px;">
              <td><i style="color:#86608e" class="fa fa-square	
                "></i> Abandoned calls</td>
              <td id="campaignCalls"><?php echo $abandoned_calls; ?></td>
            </tr>
            <tr style="height:25px;">
              <td><i style="color:#466757" class="fa fa-square	
                "></i> Total Inbound Calls(Answer + Drop + Abandoned)</td>
              <td id="totalInboundCalls"><?php echo $inbound_calls; ?></td>
            </tr>
            <tr style="height:25px;">
              <td><i style="color:#3bb393" class="fa fa-square	
                "></i> Outbound Calls (Success + Unsuccess)</td>
              <td id="outboundCalls"><?php echo $outbound_calls; ?></td>
            </tr>

            <tr style="height:25px;">
              <td style="width:50%"><i style="color:#4CAF50" class="fa fa-square
                "></i> Total Calls (Inbound + Outbound)</td>
              <td style="width:50%" id="totalCalls"><?php echo $total_calls; ?></td>
            </tr>
            <!--<tr style="height:25px;">
              <td>Service Level (I/(I+D))</td><td><?php echo $service_level; ?></td>
              </tr>	-->
            <tr style="height:25px;">
              <td><i style="color:#00BCD4" class="fa fa-square
                "></i> Agents on ACW </td>
              <td id="transferCalls"><?php echo $after_cw_agents; ?></td>
            </tr>
            <tr style="height:25px;">
              <td><i style="color:#E91E63" class="fa fa-square
                "></i> Agents on Hold </td>
              <td id="shiftCalls"><?php echo $onhold_agents; ?></td>
            </tr>


            <tr style="height:25px;">
              <td><i style="color:#02075d" class="fa fa-square	
                "></i> Agents on call</td>
              <td id="agentsOnCall"><?php echo $on_call_agents; ?></td>
            </tr>
            <!--<tr style="height:25px;">
              <td>Agents Busy</td><td><?php echo $busy_agents; ?></td>
              </tr>-->
            <?php /*					<tr style="height:25px;">
              <td>Drop Calls</td><td><?php echo $drop_calls;?></td>
            </tr>
            */ ?>
            <!--<tr style="height:25px;">
              <td>Abandoned Calls</td><td><?php echo $abandoned_calls; ?></td>
              </tr>-->
            <tr style="height:25px;">
              <td><i style="color:#ff7538" class="fa fa-square	
                "></i> Break Time</td>
              <td id="offTimeCalls"><?php echo $Break; ?></td>
            </tr>
            <!--				<?php //while(!$rs->EOF){ 
                        ?>
              <tr class="odd">
                            <td class="col-first"><?php //echo $rs->fields["full_name"]; 
                                                  ?> </td>
              <td class="col-first"><?php //echo(empty($rs->fields["is_crm_login"])?"<font color=\"red\">No</font>":"Yes"); 
                                    ?> </td>
              <td class="col-first"><?php //echo(empty($rs->fields["is_phone_login"])?"<font color=\"red\">No</font>":"Yes"); 
                                    ?> </td>
              <?php
              /*$position = strpos($rs->fields["t_duration"], "-");
                
                if($rs->fields["is_busy"] == 2){
                	$bstr="<font color=\"green\">Ringing</font>";
                	$rsx = $admin->ringing_id($rs->fields["admin_id"]);
                	$str_callerid = $rsx->fields["caller_id"];
                	$str_t_duration = '';
                }
                else if($rs->fields["is_busy"] == 1){
                	if($rs->fields["call_type"] == "OUTBOUND")
                	{
                		$bstr="<font color=\"green\">On Call</font>";
                	}else
                	{
                		$bstr="<font color=\"red\">On Call</font>";
                	}
                	//$rsx = $admin->last_call_id($rs->fields["admin_id"]);
                	$str_callerid = $rs->fields["caller_id"];
                	if ($position === false)
                					$str_t_duration = $rs->fields["t_duration"];
                	else
                		$str_t_duration = '';
                					
                }
                else if($rs->fields["is_busy"] == 0){
                	$bstr="Free";
                	$str_callerid = '';
                	if ($position === false)
                					$str_t_duration = $rs->fields["t_duration"];
                	else
                		$str_t_duration = '';
                	//$str_t_duration = $rs->fields["t_duration"];
                }
                else if($rs->fields["is_busy"] == 3){
                	$bstr="<font color=\"red\">Busy</font>";
                	$str_callerid = $rs->fields["caller_id"];
                	if ($position === false)
                					$str_t_duration = $rs->fields["t_duration"];
                	else
                		$str_t_duration = '';
                	//$str_t_duration = $rs->fields["t_duration"];
                }*/
              ?>
              
              <td class="col-first"><?php //echo $bstr; 
                                    ?> </td>
              
              <?php
              /*if($rs->fields["is_crm_login"] == 1){
                	$str ="Online";
                }
                else if($rs->fields["is_crm_login"] == 2){
                	$str ="<font color=\"red\">Namaz Break</font>";
                }
                else if($rs->fields["is_crm_login"] == 3){
                	$str ="<font color=\"red\">Lunch Break</font>";
                }
                else if($rs->fields["is_crm_login"] == 4){
                	$str ="<font color=\"red\">Tea Break</font>";
                }
                else if($rs->fields["is_crm_login"] == 5){
                	$str ="<font color=\"red\">Break</font>";
                }
                else if($rs->fields["is_crm_login"] == 6){
                	$str ="<font color=\"red\">Assignment</font>";
                }
                else if($rs->fields["is_crm_login"] == 0){
                		$str ="<font color=\"red\">Offline</font>";
                		$str_t_duration = '';
                }
                else {
                		$str ="Unkown";
                }				*/
              ?>						
              <td class="col-first"><?php //echo $str; 
                                    ?> </td>
              <td class="col-first"><?php //echo $str_callerid; //$rs->fields["caller_id"]; 
                                    ?> </td>
              <td class="col-first"><?php //echo $str_t_duration; 
                                    ?> </td>
              
              <?php //$crm_status_time = $admin->crm_status_time($rs->fields["admin_id"]); 
              ?>
              <td class="col-first"><?php //echo $crm_status_time; 
                                    ?> </td>
              
              
              <?php //$last_busy_time = $admin->last_busy_time($rs->fields["admin_id"]); 
              ?>
              <td class="col-first"><?php //echo $last_busy_time; 
                                    ?> </td>
              
              
              </tr>
              <?php //$rs->MoveNext();	} 
              ?>-->
          </tbody>
        </table>
        <div class="mypiechart">
          <canvas id="myCanvas2" width="300" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
  <?php //include($site_admin_root."queue-stats.php"); 
  ?>
  <br />
  <?php //include($site_admin_root."queue_wait_stats.php"); 
  ?>
  <br />
  <?php //include($site_admin_root."drop_call_stats.php"); 
  ?>
  <br />
  <?php //include($site_admin_root."off-time-stats.php"); 
  ?>
  </div>
</form>
<script type="text/javascript">

// $(document).ready(function() {
// 		$('#tbl1').DataTable({
// 			dom: 'tB',
// 			buttons: [{
// 					extend: "copy",
// 					title: "Call Center Wallboard",
// 					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
// 				}, {
// 					extend: "csv",
// 					title: "Call Center Wallboard",
// 					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
// 				}, {
// 					extend: "excel",
// 					title: "Call Center Wallboard",
// 					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
// 				}, {
// 					extend: "pdf",
// 					title: "Call Center Wallboard",
// 					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
// 				}, {
// 					extend: "print",
// 					title: "Call Center Wallboard",
// 					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
// 				},

// 			]
// 		});
// 	});

  $(document).ready(function() {
    var list = [];
    var colors = [];

    //var totalCalls = $('#totalCalls').html();
    var transferCalls = $('#transferCalls').html();
    var shiftCalls = $('#shiftCalls').html();
    var inboundCalls = $('#inboundCalls').html();
    var dropCalls = $('#dropCalls').html();
    var campaignCalls = $('#campaignCalls').html();
    //var totalInboundCalls = $('#totalInboundCalls').html();
    var outboundCalls = $('#outboundCalls').html();
    var agentsOnCall = $('#agentsOnCall').html();
    var offTimeCalls = $('#offTimeCalls').html();

    //totalCalls = parseInt(totalCalls);
    transferCalls = parseInt(transferCalls);
    shiftCalls = parseInt(shiftCalls);
    inboundCalls = parseInt(inboundCalls);
    dropCalls = parseInt(dropCalls);
    campaignCalls = parseInt(campaignCalls);
    //totalInboundCalls = parseInt(totalInboundCalls);
    outboundCalls = parseInt(outboundCalls);
    agentsOnCall = parseInt(agentsOnCall);
    offTimeCalls = parseInt(offTimeCalls);


    // if(totalCalls!=0){
    // 	list.push(totalCalls);
    // 	colors.push('#4CAF50');
    // }
    if (transferCalls != 0) {
      list.push(transferCalls);
      colors.push('#00BCD4');
    }
    if (shiftCalls != 0) {
      list.push(shiftCalls);
      colors.push('#E91E63');
    }
    if (inboundCalls != 0) {
      list.push(inboundCalls);
      colors.push('#FFC107');
    }
    if (dropCalls != 0) {
      list.push(dropCalls);
      colors.push('#9E9E9E');
    }

    if (campaignCalls != 0) {
      list.push(campaignCalls);
      colors.push("#86608e");
    }
    // if(totalInboundCalls!=0){
    // 	list.push(totalInboundCalls);
    // 	colors.push('#466757');
    // }
    if (outboundCalls != 0) {
      list.push(outboundCalls);
      colors.push('#3bb393');
    }
    if (agentsOnCall != 0) {
      list.push(agentsOnCall);
      colors.push('#02075d');
    }
    if (offTimeCalls != 0) {
      list.push(offTimeCalls);
      colors.push('#ff7538');
    }



    // console.log(totalCalls);
    // console.log(transferCalls);
    // console.log(shiftCalls);
    // console.log(inboundCalls);
    // console.log(dropCalls);
    // console.log(campaignCalls);
    // console.log(totalInboundCalls);
    // console.log(outboundCalls);
    // console.log(offTimeCalls);

    var obj2 = {
      values: list,
      colors: colors,
      animation: true,
      animationSpeed: 30,
      fillTextData: true,
      fillTextColor: '#fff',
      fillTextAlign: 1.50,
      fillTextPosition: 'inner',
      doughnutHoleSize: null,
      doughnutHoleColor: '#fff',
      offset: 1
    };
    generatePieGraph('myCanvas2', obj2);
  });
</script>
<?php if (!isset($_GET['id'])) { ?>
  <script>
    $(document).ready(function() {


      $('#radio').click(function() {
        var url = window.location.href + '?id=start';
        window.location = url;




      });
    });
  </script>
<?php } else { ?>
  <script>
    $(document).ready(function() {


      $('#radio').click(function() {
        window.location.href = window.location.href.split('?')[0];;





      });
    });
  </script>
<?php } ?>
<?php include($site_admin_root . "includes/footer.php"); ?>