<?php include_once("includes/config.php"); ?>
<?php
$page_name = "categoryRecords.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Category Records";
$page_menu_title = "Category Records";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
include_once("classes/reports.php");
$reports = new reports();
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
include_once("classes/user_tools.php");
$user_tools = new user_tools();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
    input[type="search"],
    .dt-buttons,
    .dataTables_length {
        margin-top: 10px;
    }
</style>
<script type="text/javascript" language="javascript1.2">
    function showWorkCode(wc) {
        if (wc || 0 !== wc.length) {
            alert(wc);
        } else {
            alert("No work code available!");
        }
    }
</script>

<?php
$today = date("YmdHms");
if (isset($_REQUEST['search_date'])) {
    $keywords            = $_REQUEST['keywords'];
    $search_keyword                 = $_REQUEST['search_keyword'];
    $fdate                 = $_REQUEST['fdate'];
    $tdate                 = $_REQUEST['tdate'];

    $static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
    $static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";

    if (isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {
        //$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
    }
} else {
    $fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
    $tdate             = empty($_REQUEST["tdate"]) ? date('d-m-Y') : $_REQUEST["tdate"];
    $static_stime     =  "00:00:00";
    $static_etime     =  "23:59:59";

    $keywords         = empty($_REQUEST["keywords"]) ? "" : $_REQUEST["keywords"];
    $search_keyword         = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}
$fdate = date('Y-m-d', strtotime($fdate));
$tdate = date('Y-m-d', strtotime($tdate));

$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

$ttl_record = 0;
?>
<?php

// $count_type = "cdr";
// $total_records_count = $reports->iget_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);

$field = empty($_REQUEST["field"]) ? "call_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];


$rs = $reports->iget_records_new_live(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdateTime, $tdateTime, $search_keyword, $keywords, 1, $today);
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Category Records</div>
<div>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
        <div class="box">
            <?php
            $form_type = "icdr";
            include($site_admin_root . "includes/search_form.php");
            include($site_admin_root . "includes/date_hour_search_bar.php");
            ?>
        </div>
        <br />
        <div id="mid-col" class="mid-col">
            <div class="box">
                <h4 class="white"><?php echo ($page_title); ?></h4>
                <div class="box-container">
                    <table class="table-short" id="tbl">
                        <thead>
                            <tr>
                                <td>Caller ID</td>
                                <td> Date</td>
                                <td> Time</td>
                                <td> Duration</td>
                                <td> Agent Name</td>
                                <td> Category</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while (!$rs->EOF) {  //date('Ymd',strtotime($rs->fields["call_date"])); 
                            ?>
                                <tr class="odd">
                                    <?php $split = explode('-', $rs->fields["call_date"]); ?>
                                    <td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo $split[0] . $split[1] . $split[2] . '/' . $rs->fields["userfield"]; ?>.wav"><?php echo $rs->fields["caller_id"]; ?> </a></td>
                                    <td class="col-first"><?php echo date('d-m-Y', strtotime($rs->fields["call_date"])) //$rs->fields["call_date"]; //;
                                                            ?> </td>
                                    <td class="col-first"><?php echo $rs->fields["call_time"]; //date("g:i s", strtotime($rs->fields["call_time"])); 
                                                            ?> </td>
                                    <td class="col-first"><?php echo $rs->fields["call_duration"]; ?> </td>
                                    <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>

                                    <?php $ext = strlen($rs->fields["caller_id"]);
                                    $ext = $ext == 4 || $ext == 3 ? 'Extension' : (($ext == 11 && substr($rs->fields["caller_id"], 0, 2) == '03' || $ext == 10 && substr($rs->fields["caller_id"], 0, 1) == '3' || $ext == 14 && substr($rs->fields["caller_id"], 0, 5) == '00923' || $ext == 12 && substr($rs->fields["caller_id"], 0, 3) == '003') ? 'Mobile' : 'Landline');
                                    ?>
                                    <td class="col-first"><?php echo $ext; ?></td>
                                </tr>
                            <?php
                                $rs->MoveNext();
                                $ttl_record++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#tbl').DataTable({
            "order": [
                [1, "desc"]
            ],
            "language": {
                "emptyTable": "No data available",
                "lengthMenu": "Show _MENU_ records",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "infoEmpty": "No records available",

            },
            dom: 'lfrtpiB',
            buttons: [{
                    extend: "copy",
                    messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
                    messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
                }, {
                    extend: "csv",
                    messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
                    messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
                }, {
                    extend: "excel",
                    messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
                    messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
                }, {
                    extend: "pdf",
                    messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
                    messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
                }, {
                    extend: "print",
                    messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
                    messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
                },

            ]
        });
    });
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>