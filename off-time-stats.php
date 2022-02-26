<?php
$page_name = "Abandoned Call Stats";
$page_level = "0";
$page_group_id = "0";
$page_title = "Abandoned Call Stats";
$page_menu_title = "Abandoned Call Stats";
?>


<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
?>
<?php
$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "update_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];
$rs = $admin->get_abandon_dashboard(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);
?>

<div id="mid-col" class="mid-col">
	<div class="box">
		<h4 class="white">Abandoned Call Stats</h4>
		<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
			<thead>

				<tr>
					<td class="col-head2">Caller ID</td>
					<td class="col-head2">Wait in Queue</td>
					<td class="col-head2">Date</td>
					<td class="col-head2">Time</td>

				</tr>
			</thead>
		</table>
		<div class="box-container-scroll">
			<table class="table-short" id="tbl">
				<tbody>

					<?php $stringData .= "<tag2>Caller ID</tag2>, <tag2>Time</tag2>, <tag2>Date</tag2>\r\n";
					$c3 = 0;  ?>
					<?php while (!$rs->EOF) { ?>

						<tr class="odd">
							<td class="col-first"><?php echo $rs->fields["clid"]; ?> </td>
							<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
							<td class="col-first">&nbsp;<?php echo $rs->fields["DATE"]; ?> </td>
							<td class="col-first">&nbsp;<?php echo $rs->fields["TIME"]; ?> </td>
						</tr>
					<?php
						$stringData .= $rs->fields["clid"] . ", " . date('h:i:s A', strtotime($rs->fields["TIME"])) . ", " . date('d-m-Y', strtotime($rs->fields["DATE"])) . "\r\n";

						$rs->MoveNext();
						$c3++;
					}

					$stringData = trim($stringData);
					?>
				</tbody>
			</table>

		</div>
		<br>
		<div style="float:right; font-size: 15px;">Total number of Abandoned Calls: <b><?php echo $c3; ?></b></div>
		</br> </br>
	</div>
</div>
