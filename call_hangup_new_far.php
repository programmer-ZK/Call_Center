<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "call_hangup.php";
        $page_title = "Call Hangup | Step 1";
        $page_level = "2";
        $page_group_id = "1";
        $page_menu_title = "Call Hangup";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/work_codes_new.php");
        $work_codes = new work_codes();

?>
<?php include($site_root."includes/iheader2.php");?>
<?php
//  $cb = $_POST['cb'];
        $cb = explode(",", $_REQUEST['echoSelection3']);

 //print_r($cb);
if(isset($_REQUEST['submitwc'])){

  if(empty($cb)){
    echo("You didn't select any workcodes.");
  }
  else{
        $selected_radio = $_POST['radio'];

        $unique_id = $_REQUEST["unique_id"];
        $caller_id = $_REQUEST["caller_id"];
        $agent_id = $_SESSION[$db_prefix.'_UserId'];
        $value_desc = $_REQUEST["value_desc"];
        $N = count($cb);
//	print_r($cb);exit;
        $flag = true;
        $outgoing_wc = "No Answer,Busy,Not Connected,Powered Off,Connected,Not Answering";
        $outgoing_wc2 = "Connected";
    for($i=1; $i < $N; $i++){
          $workcodes =$cb[$i];
  //echo $workcodes;
         $work_codes->insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id,$value_desc,$selected_radio);
          $que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id;

          /*By Farhan Start*/
          if (preg_match("/".$workcodes."/", $outgoing_wc) ) {
		echo "chaeck";exit;
              $sql_que = "update ".$db_prefix."_queue_stats set call_status='".strtoupper($workcodes)."' where caller_id='".$caller_id."' ";
              $sql_que .= "and unique_id='".$unique_id."'";
              $tools_admin->exec_query($sql_que);
              //$sql_que = "update ".$db_prefix."_campaign_detail set status='1' where caller_id='".$caller_id."' ";
                //    $sql_que .= "and unique_id='".$unique_id."'";
                   // $tools_admin->exec_query($sql_que);

                if (!preg_match("/".$workcodes."/", $outgoing_wc2) ) {
                    $sql_que = "update ".$db_prefix."_campaign_detail set status='1' where caller_id='".$caller_id."' ";
                    $sql_que .= "and unique_id='".$unique_id."'";

                    $tools_admin->exec_query($sql_que);
                }
              $flag = false;
          }
          /*By Farhan End*/
    }
        $tools_admin->exec_query("update cc_admin set is_busy='0' where admin_id='".$_SESSION[$db_prefix.'_UserId']."'and status='1'");
        $_SESSION[$db_prefix.'_GM'] = "Call Ended Successfully.";


        include_once("classes/user_pin.php");
        $user_pin = new user_pin();
        $user_pin->update_user_status($unique_id,$caller_id,'-1',0,$_SESSION[$db_prefix.'_UserId']);
?>
<!--    <script type="text/javascript">
        window.open('', '_self', '');   window.focus();
        window.close();

        </script>-->
 <?
 //      header ("Location: exit.php");

        //header ("Location: call_hangup2.php?".$que_str);
        $tools_admin->update_cdr($unique_id, $agent_id);
  }
}
?>
<div class="box">

        <h4 class="white"><?php echo "Set Work Codes" ;?></h4>
                <div class="box-container">
                <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
                                DESCRIPTION <input name="value_desc" id="value_desc" class="txtbox-short" value="" />
                                <input type="hidden" id="caller_id" name="caller_id" value="<?php echo $_REQUEST["caller_id"];?>"/>
                                <input type="hidden" id="unique_id" name="unique_id" value="<?php echo $_REQUEST["unique_id"];?>"/>
                                <div style="padding:10px; overflow-y: auto; height:400px; ">

<input type="radio" name="radio"  id="radio" value="Inbound">Inbound
<input type="radio" name="radio" id="radio"  value="Outbound">Outbound
<input type="radio" name="radio" id="radio"  value="Outbound">Campaign<br/>

<textarea id="echoSelection3" name="echoSelection3" rows="5" cols="50" style="resize:none" readonly>
</textarea>

<script>
                                        $('input:radio').change(
    function(e){
        if ($(this).is(':checked')){
            $(show).show();
        }
    });




</script>



                                        <div id="show" style="display:none">

        <!-- Tree #3 -->

					        <div id="tree3"></div>
					         <span id="echoSelection3">-</span>
                                        </div>

                                </div>
                        <div style="padding:10px;">
                                <a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Submit</span></a>
                                <input type="hidden" value="submitwc" id="submitwc" name="submitwc" />
                        </div>
                        </form>
        </div>
</div>
<?php include($site_root."includes/ifooter.php"); ?>

