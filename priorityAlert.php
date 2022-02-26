<?php include_once("includes/config.php"); ?>
<?php
session_start();
$page_name = "priorityAlert.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Priority Call Alert";
$page_menu_title = "Priority Call Alert";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
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
<script type="text/javascript" language="javascript1.2">
    function showWorkCode(wc) {
        if (wc || 0 !== wc.length) {
            alert(wc);
        } else {
            alert("No work code available!");
        }
    }
</script>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Prioroty Call Alert</div><br>
<div>
    <form method="post" action="priorityAlertPost.php" name="priorityAlertForm" id="priorityAlertFormId">
        <div class="box">
            <label for="number"> Enter Number
                <input type="text" name="number" id="number" />
            </label>
            <button id="saveBTN" value="saveBTN" name="saveBTN" type="submit">Add Data</button>
        </div>
    </form>
    <span style="color:red;font-weight:bold;"><?php echo $_SESSION['priorityAlertError']; ?></span>
    <br><br>
    <?php
    $rs = $reports->iget_priorityAlert_records();
    ?>

    <div class="box">
        <h4 class="white" style=" margin-bottom: 13px;"><?php echo ($page_title); ?>
        </h4>

        <div class="box-container">
            <table id="keywords" style="background-color:#FFFFFF; margin-left:0px;width:100%;  margin-bottom: 13px;">
                <thead>

                    <tr>
                        <span style="color:red;font-weight:bold;"><?php echo $_SESSION['priorityAlertErrorUpdate']; ?></span>
                        <td class="col-head2">Index No:</td>
                        <td class="col-head2">Numbers:</td>
                        <td class="col-head2">Action</td>
                    </tr>
                </thead>
                <tbody>

                    <?php while (!$rs->EOF) { ?>
                        <tr>
                            <td class="col-first"><?php echo $rs->fields["IndexNo"]; ?></td>
                            <td class="col-first"><?php echo $rs->fields["Number"]; ?></td>

                            <td><a class="button trigger" style="margin:0 !important;margin-right:10px !important;" onclick="editData('<?php echo $rs->fields['Number'] ?>','<?php echo $rs->fields['IndexNo'] ?>')">
                                    <span>Edit</span>
                                    <a class="button" style="margin:0 !important;margin-right:10px !important;" onclick='deleteConfrim(<?php echo $rs->fields["IndexNo"] ?>)'>
                                        <span>Delete</span>
                                    </a>
                            </td>
                        </tr>
                    <?php
                        $rs->MoveNext();
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<div class="modal">
    <div class="modal-content">
        <span class="close-button">×</span>
        <h1></h1>
        <form method="post" action="priorityAlertUpdate.php">
            <div class="box">
                <label for="number"> Enter Number
                    <input type="text" name="numberUpdate" id="numberUpdate" />
                    <input type="hidden" name="numberUpdateID" id="numberUpdateID" />
                </label>
                <button id="butUpdate" value="butUpdate" name="butUpdate" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    function editData(value, id) {
        var number = value;
        var id = id;
        $("#numberUpdate").val(number);
        $("#numberUpdateID").val(id);
        toggleModal();
        if (event.target === modal) {
            toggleModal();
        }
        closeButton.addEventListener("click", toggleModal);
    }
    var modal = document.querySelector(".modal");
    var closeButton = document.querySelector(".close-button");



    function toggleModal() {
        modal.classList.toggle("show-modal");
    }

    function windowOnClick(event) {
        if (event.target === modal) {
            toggleModal();
        }
    }

    trigger.addEventListener("click", toggleModal);
    window.addEventListener("click", windowOnClick);

    function deleteConfrim(id) {
        if (confirm('Are you sure you want to Delete Entry?')) {
            $.ajax({
                type: "POST",
                url: "priorityAlertDelete.php",
                data: {
                    id: id
                },
                success: function(res) {
                    location.reload();
                }
            });
        } else {
            console.log('Thing was not saved to the database.');
        }
    }
</script>
<script>
    $(".radioClass").change(function() {

        var rdio = $(this).val();
        console.log(rdio);
        $.ajax({
            url: 'priorityAlertChange.php',
            type: 'POST',
            data: {
                rdio: rdio
            },
            'success': function(response) {
                console.log(response);
                location.reload();
            },
        });
    });

    function clearAllSelection() {
        $.ajax({
            url: 'priorityAlertChange.php',
            type: 'POST',
            data: {
                dd: 'all'
            },
            'success': function(response) {
                console.log(response);
                location.reload();
            },
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#keywords').DataTable({
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
                    exportOptions: {
                        columns: [0, 1]
                    }
                }, {
                    extend: "csv",
                    exportOptions: {
                        columns: [0, 1]
                    }
                }, {
                    extend: "excel",
                    exportOptions: {
                        columns: [0, 1]
                    }
                }, {
                    extend: "pdf",
                    exportOptions: {
                        columns: [0, 1]
                    }
                }, {
                    extend: "print",
                    exportOptions: {
                        columns: [0, 1]
                    }
                },

            ]
        });
    });
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>