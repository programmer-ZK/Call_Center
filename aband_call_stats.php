<?php
$page_name = "aband_call_stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Abandoned Call Stats";
$page_menu_title = "Abandon Call Stats";
?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
?>

<?php

$rs = $reports->iget_aband_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime, $search_keyword, $keywords, 1, $today);

?>


<div id="mid-col" class="mid-col">
  <div class="box">
    <h4 class="white"><?php echo ($page_title); ?></h4>

    <table class="table-short" id="tbl3" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
      <thead>
        <tr>
          <td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
        </tr>
        <tr>
          <td> Caller ID</td>
          <td> Date</td>
          <td> Time</td>
          <td> Call ID</td>
        </tr>
      </thead>
      <tbody>
        <?php while (!$rs->EOF) { ?>
          <tr class="odd">

            <td><?php echo $rs->fields["caller_id"]; ?></td>

            <td class="col-first"><?php echo ($rs->fields["update_date"]); ?> </td>
            <td class="col-first"><?php echo date("h:i:s a", strtotime($rs->fields["update_time"])); ?> </td>
            <?php $wrs = $reports->iget_fullname($rs->fields["staff_id"]); ?>


            <?php
            $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
            $i = 1;
            $workcodes = "";
            while (!$rsw->EOF) {
              $workcodes .= "\r\n" . $i . "- " . $rsw->fields['workcodes'];
              $i++;
              $rsw->MoveNext();
            }
            ?>

            <td>
              <?php echo $rs->fields["unique_id"]; ?>
            </td>

          </tr>
        <?php
          $rs->MoveNext();
          $ttl_record++;
        } ?>
      </tbody>
    </table>

    </br>
    </br>
    <div style="float:right; font-size: 15px;">Total number of Abandoned calls: <b><?php echo $ttl_record; ?></b></div>
    </br>
    </br> </br>
  </div>
</div>