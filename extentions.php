<?php include_once("includes/config.php"); ?>
<?php
$page_name = "Extentions";
$page_level = "0";
$page_group_id = "0";
$page_title = "Extentions";
$page_menu_title = "Extentions";
?>


<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/reports.php");
$reports = new reports();

include_once("classes/all_agent.php");

$all_agent = new all_agent();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
  .fw-500 {
    font-weight: 500;
  }

  .mt-1 {
    margin-top: 5px;
  }

  #ex_save {
    background: #9E662F;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 4px 0px;
  }

  .tbl td {
    text-align: center;
  }

  input[type="search"],
  .dt-buttons,
  .dataTables_length {
    margin-top: 10px;
  }

  .errors {
    color: #e21833;
  }
</style>


<html>

<?php
$errors = array();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
  $id       =  $_REQUEST["id"];
  $ex       =  $_REQUEST["ex"];
  delete_extention($id, $ex);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ex_number       =  $_REQUEST["ex_number"];
  $ex_name         =  $_REQUEST["ex_name"];
  $ex_password     =  $_REQUEST["ex_password"];
  $ex_right       =  $_REQUEST["ex_right"];

  if (empty($ex_number)) {
    array_push($errors, "Extention Number is Required.");
  }
  if (!empty($ex_number) && strlen($ex_number) !=  4) {
    array_push($errors, "Extention Number should be 4 Digits.");
  }
  if (empty($ex_name)) {
    array_push($errors, "Extention Name is Required.");
  }
  if (empty($ex_password)) {
    array_push($errors, "Extention Password is Required.");
  }
  if (empty($ex_right)) {
    array_push($errors, "Extention Right is Required.");
  }
  if (count($errors) == 0) {
    insert_extention($ex_number, $ex_name, $ex_password, $ex_right);
    $ex_number = '';
    $ex_name = '';
    $ex_password = '';
    $ex_right = '';
  }
}


$rs = fetch_extention();
?>

<body>
  <div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <div id="mid-col" class="mid-col">
        <div class="box">
          <h4>Add New Extention</h4>
          <h4 class="white">
            <div>


              <table class="add_tbl">
                <tr>
                  <td style="border: none;">
                    <label class="fw-500">
                      Number :
                    </label>
                    <input name="ex_number" id="ex_number" class="mt-1" value="<?= $ex_number ?>">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Name :
                    </label>
                    <input name="ex_name" id="ex_name" class="mt-1" value="<?= $ex_name ?>">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Password :
                    </label>
                    <input name="ex_password" id="ex_password" class="mt-1" value="<?= $ex_password ?>">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Rights :
                    </label>
                    <select name="ex_right" id="ex_right" class="mt-1">
                      <option selected disabled>Select Right </option>
                      <option value="extensions" <?= ($ex_right == "extensions") ? "selected" : "" ?>>Only Extensions</option>
                      <option value="outside" <?= ($ex_right == "outside") ? "selected" : "" ?>>Complete Outgoing</option>
                      <option value="call_Center" <?= ($ex_right == "call_Center") ? "selected" : "" ?>>Call Center Agent</option>
                    </select>
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      <br>
                    </label>
                    <input type="submit" name="ex_save" id="ex_save" class="txtbox-short-date mt-1">
                  </td>
                </tr>
              </table>
              <p class="errors">
                <?php
                foreach ($errors as $err) {
                  echo "* " . $err . "<br>";
                }

                ?>
              </p>

              <div>
                <br>
                <br>
                <label>

                </label>

                <div>
                </div>
          </h4>
    </form>

    <br>
    <br>
    <div class="box ">
      <h4> Extentions</h4>
    </div>
    <br>
    <br>

    <table class="table-short" id="tbl">
      <thead>
        <th>#</th>
        <th>Number</th>
        <th>Name</th>
        <th>Password</th>
        <th>Rights</th>
        <th>Action</th>
      </thead>
      <tbody>
        <?php
        $s_no = 1;
        while (!$rs->EOF) {
          $id = $rs->fields['id'];
          $ex = $rs->fields['extension_num'];
        ?>
          <tr>
            <td><?= $s_no++ ?></td>
            <td><?= $rs->fields['extension_num']; ?></td>
            <td><?= $rs->fields['extension_name']; ?></td>
            <td><?= $rs->fields['password']; ?></td>
            <td><?= $rs->fields['rights']; ?></td>
            <td><a href="#"><i class="fa-solid fa-pen"></i></a> | <a href="#" onclick="deleteExtension(<?= $id ?>,
            <?= $ex ?>)"><i class="fa-solid fa-trash"></i> </a> </td>
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
  <?php include($site_admin_root . "includes/footer.php"); ?>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    function deleteExtension(id, ex) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        showLoaderOnConfirm: true,
        preConfirm: function() {
          return new Promise(function(resolve) {
            $.ajax({
                url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                type: 'POST',
                data: {
                  id: id,
                  ex: ex,
                  action: "delete"
                },
              })
              .done(function(response) {
                window.location = "extentions.php";
              })
              .fail(function() {
                swal('Oops...', 'Something went wrong!', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }

    $(document).ready(function() {
      $('#tbl').DataTable({
        "order": [
          [0, "desc"]
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
        }, ]
      });
    });
  </script>
</body>
<script type="text/javascript">

</script>