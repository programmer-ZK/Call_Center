<?php
$page_name = "drop_call_stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Dropped Call Stats";
$page_menu_title = "Drop Call Stats";
?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
?>

<?php
$rs = $admin->get_drop_call_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);

?>


<div id="mid-col" class="mid-col">
	<div class="box">
		<h4 class="white"><?php echo ($page_title); ?></h4>

		<table class="table-short" id="tbl2" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
			<thead>
				<tr>
					<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
				</tr>
				<tr>

					<td class="col-head2">Caller ID</td>
					<td class="col-head2">Wait In Queue</td>
					<td class="col-head2">Agent Name</td>
					 <td class="col-head2">Date</td>
					<td class="col-head2">Time</td>
				</tr>
			</thead>
			<tbody>
					<?php $stringData .= "<tag2>Caller ID</tag2>, <tag2>Wait In Queue</tag2>, <tag2>Agent Name</tag2>, <tag2>Date</tag2>, <tag2>Time</tag2>\r\n";  ?>
					<?php
					$c3 = 0;
					while (!$rs->EOF) { ?>

						<tr class="odd">

							<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
							<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
							<td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
							<td class="col-first"><?php echo $rs->fields["date"]; ?> </td>
							<td class="col-first"><?php echo $rs->fields["time"]; ?> </td>

						</tr>

					<?php
						$stringData .= $rs->fields["caller_id"] . ", " . $rs->fields["duration"] . ", " . $rs->fields["full_name"] . ", " . $rs->fields["date"] . ", " . $rs->fields["time"] . "\r\n";

						$rs->MoveNext();
						$c3++;
					} ?>
				</tbody>
		</table>
		
		</br>
		</br>
		<div style="float:right; font-size: 15px;">Total number of Dropped calls: <b><?php echo $c3; ?></b></div>
		</br>
		</br> </br>
	</div>
</div>
