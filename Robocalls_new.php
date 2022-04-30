<?php include_once("includes/config.php"); ?>
<?php
$page_name = "Robocalls";
$page_level = "0";
$page_group_id = "0";
$page_title = "Robocalls";
$page_menu_title = "Robocalls";
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

include('lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
include('lib/spreadsheet-reader-master/SpreadsheetReader.php');
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

  .tbl_tr td {
    text-align: center !important;
  }

  .save_btn {
    /* display: none; */
    opacity: 0;
    background: #9E662F;
    transition: all 1s;
    color: white;
    border: none;
    border-radius: 20px;
    margin-left: 10px;
    padding: 4px 15px;
  }
</style>

<html>

<?php
$dateTime = date("d-m-Y H:i:s");
$errors = array();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "delete") {
  $id       =  $_REQUEST["id"];
  $ex_num       =  $_REQUEST["ex_num"];
  delete_roboCall($id, $ex_num);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "update") {
  $id            =    $_REQUEST["id"];
  $ex_num        =    $_REQUEST["ex_num"];
  $ex_prev       =    $_REQUEST["ex_prev"];
  $ex_name       =    $_REQUEST["ex_name"];
  $ex_pass       =    $_REQUEST["ex_pass"];
  $ex_right      =    $_REQUEST["ex_right"];

  update_extention($id, $ex_num, $ex_prev, $ex_name, $ex_pass, $ex_right);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $name          =    $_REQUEST["name"];
  $IVR_name      =    $_REQUEST["IVR_name"];
  $startTime     =    $_REQUEST["startTime"];
  $retries       =    $_REQUEST["retries"];

  $mimes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.oasis.opendocument.spreadsheet'];

  if (empty($_FILES["file"]["name"])) {
    array_push($errors, "File is Required");
  }
  if (!in_array($_FILES["file"]["type"], $mimes)) {
    array_push($errors, "Sorry, File type is not allowed. Only Excel file.");
  }
  if (empty($name)) {
    array_push($errors, "Name is Required.");
  }
  if (!empty($name) && if_roboCall_name_exists($name)) {
    array_push($errors, "Name already exists.");
  }
  if (preg_match('/\s/', trim($name))) {
    array_push($errors, "Name should not contain space.");
  }
  if (empty($IVR_name)) {
    array_push($errors, "IVR Name is Required.");
  }
  if (empty($startTime)) {
    array_push($errors, "Start time is Required.");
  }

  if (count($errors) == 0) {

    $uploadFilePath = 'upload/' . basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath);

    $Reader = new SpreadsheetReader($uploadFilePath);

    $totalSheet = count($Reader->sheets());

    /* For Loop for all sheets */
    for ($i = 0; $i < $totalSheet; $i++) {
      $Reader->ChangeSheet($i);

      foreach ($Reader as $Row) {
        if (isset($Row[0]) && intval($Row[0])) {
          $numbers =  $Row[0];
        } else {
          continue;
        }
        insert_roboCall(trim($name), $IVR_name, $numbers, $startTime, $retries);
      }
    }

    // echo "<b>NO. of sheet </b> : " . $totalSheet;
    echo "<b>Data Inserted in dababase</b><br>";

    unlink($uploadFilePath);

    $name = '';
  }
}

$rs = fetch_robo();
$ivr_robo =  fetch_ivr_robo();
?>

<body>
  <div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" ENCTYPE="multipart/form-data">

      <div id="mid-col" class="mid-col">
        <div class="box">
          <h4>Add New Robocall</h4>
          <h4 class="white">
            <div>

              <table class="add_tbl">
                <tr>
                  <td style="border: none;">
                    <label class="fw-500">
                      Name :
                    </label>
                    <input name="name" id="name" class="mt-1" value="<?= $name ?>" required>
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      IVR :
                    </label>
                    <select name="IVR_name" id="IVR_name" style="width: 150px; height: 25px; margin-top: 5px;">
                      <?php
                      while (!$ivr_robo->EOF) {
                        $ivr_id = $ivr_robo->fields['id'];
                        $ivr_name = $ivr_robo->fields['ivr_name'];
                        $file_name = $ivr_robo->fields['file_name'];
                      ?>
                        <option value="<?= $ivr_name ?>"><?= $ivr_name ?></option>
                      <?php
                        $ivr_robo->MoveNext();
                      } ?>
                    </select>
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      File :
                    </label>
                    <input type="file" name="file" id="file" class="mt-1" required>
                  </td>
                </tr>
                <tr>
                  <td style="border: none;">
                    <label class="fw-500">
                      Start Time :
                    </label>
                    <input type="datetime-local" name="startTime" id="startTime" required>
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Retries :
                    </label>
                    <Select name="retries" id="retries" style="width: 150px; height: 25px; margin-top: 5px;">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                    </Select>
                  </td>
                  <td style=" border: none;">
                    <input type="submit" value="Add" name="ex_save" id="ex_save" class="txtbox-short-date mt-1">
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
        <th style="text-align: center">#</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center">IVR Name</th>
        <th style="text-align: center">Upload Date</th>
        <th style="text-align: center">Phone Number</th>
        <th style="text-align: center">Start Time</th>
        <th style="text-align: center">Retries</th>
        <th style="text-align: center">No. of calls</th>
        <!-- <th style="padding-left: 30px">Action</th> -->
      </thead>
      <tbody>
        <?php
        $s_no = 1;
        while (!$rs->EOF) {
          $id = $rs->fields['id'];
          $name = $rs->fields['name'];
          $ivr_name = $rs->fields['ivr_name'];
          $upload_date = $rs->fields['upload_date'];
          $phone_number = $rs->fields['phone_number'];
          $timetostart = $rs->fields['timetostart'];
          $retries = $rs->fields['retries'];
          $noofcalls = $rs->fields['noofcalls'];
        ?>
          <tr class="tbl_tr">
            <td><?= $s_no++ ?></td>
            <td><?= $name ?></td>
            <td><?= $ivr_name ?></td>
            <td><?= $upload_date ?></td>
            <td><?= $phone_number ?></td>
            <td><?= $timetostart ?></td>
            <td><?= $retries ?></td>
            <td><?= $noofcalls ?></td>
            <!-- <td >
              <a href="#" onclick="delete_robocall(<?= $id ?>,<?= $ex_num ?>)">
                <i class="fa-solid fa-trash"></i>
              </a>
              <button value="<?= $id ?>" type="button" id="save_btn_<?= $id ?>" class="txtbox-short-date save_btn">Save</button>
            </td> -->
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
  <?php $s_no -= 1; ?>

  <script>
    // For Confirm Resubmisson Dialog
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    // Function to Delete Extension
    function delete_robocall(id, ex_num) {
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
                  ex_num: ex_num,
                  action: "delete"
                },
              })
              .done(function(response) {
                window.location = "extentions.php";
              })
              .fail(function() {
                swal.fire('Oops...', 'Something went wrong!', 'error');
              });
          });
        },
        allowOutsideClick: false
      });
    }

    // DataTable's Initialization
    $(document).ready(function() {
      $('#tbl').DataTable({
        "order": [
          [0, "desc"]
        ],
        "stripeClasses": [],
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
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "csv",
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "excel",
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "pdf",
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "print",
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, ]
      });
    });
  </script>
</body>
<script type="text/javascript">

</script>