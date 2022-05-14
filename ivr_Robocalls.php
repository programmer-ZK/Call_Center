<?php include_once("includes/config.php"); ?>
<?php
$page_name = "IVR_Robocalls";
$page_level = "0";
$page_group_id = "0";
$page_title = "IVR_Robocalls";
$page_menu_title = "IVR_Robocalls";
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

  .tbl_tr td {
    text-align: center !important;
    vertical-align: middle;
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
  delete_IVR($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $ivr_name         =    $_REQUEST["ivr_name"];
  $pre_name         =    ivr_file_pre_name();

  $file_type        =    "robo_0"; // Default Name

  $strLen           =    strlen($pre_name);
  $old_name         =    substr($pre_name, 5, $strLen);
  $new_num          =    (int)$old_name + 1;
  $file_type        =    "robo_" . $new_num; // Name will over write here

  $target_dir       =    "/var/lib/asterisk/sounds/robocalls/";
  $target_file      =    $target_dir . $file_type . ".wav";
  $uploadOk         =    1;
  $imageFileType    =    strtolower(pathinfo($target_dir . basename($_FILES["ivr_file"]["name"]), PATHINFO_EXTENSION));

  if ($_FILES["ivr_file"]["error"] > 0) {
    echo "<b>Error:</b> " . $_FILES["ivr_file"]["error"] . "<br>";
  } else {
    echo "<b>File Name:</b> " . $_FILES["ivr_file"]["name"] . "<br>";
    echo "<b>File Type:</b> " . $_FILES["ivr_file"]["type"] . "<br>";
    echo "<b>File Size:</b> " . ($_FILES["ivr_file"]["size"] / 1024) . " KB<br>";
    echo "<b>Stored in:</b> " . $_FILES["ivr_file"]["tmp_name"] . " <br>";
  }

  // Allow certain file formats
  if ($imageFileType != "wav") {
    echo "<b>Sorry, only .wav file is allowed. <br>";
    $uploadOk = 0;
  }

  if (empty($ivr_name)) {
    array_push($errors, "IVR name is Required.");
  }

  if (!empty($ivr_name) && if_ivr_roboCall_name_exists($ivr_name)) {
    array_push($errors, "Name already exists.");
  }

  if (preg_match('/\s/', trim($ivr_name))) {
    array_push($errors, "Name should not contain space.");
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0 || count($errors) > 0) {
    echo "<b>Sorry,</b> your file was not uploaded. <br>";
    // if everything is ok, try to upload file
  } else {

    $copy_file = copy($_FILES["ivr_file"]["tmp_name"], "robo_calls/$file_type.wav");

    if (move_uploaded_file($_FILES["ivr_file"]["tmp_name"], $target_dir . $file_type . ".wav")) {
      echo "<b>Upload status:</b> Success <br> ";
      echo "<b>File Name:</b> " .  $file_type . ".wav <br>";
      echo "<b>Dir/File Name:</b> " .  $target_file . "  <br> ";
      insert_IVR_robocall($ivr_name, $file_type);
      $ivr_name = '';
    } else {
      echo " <br> <b>Upload status:</b> Sorry, there was an error uploading your file.";
    }
  }
  echo "<br>";
}

$rs =  fetch_ivr_robo();
?>

<body>
  <div>

    <div id="mid-col" class="mid-col">
      <div class="box">
        <h4>Add New IVR Robocall</h4>
        <h4 class="white">
          <div>
            <table class="add_tbl">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" ENCTYPE="multipart/form-data">

                <input type="text" name="ivr_name" placeholder="IVR Name" required style="margin-right: 20px;">
                <input type="file" name="ivr_file" required>
                <input type="submit" value="Upload">

              </form>
            </table>
            <p style="margin-top: 20px;"><strong>NOTE :</strong> only wav format with 8000Hz frequency, 16bit resolution and mono channel is supported</p>
            <p class="errors" style="margin-top: 5px;">
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

        <br>
        <br>
        <div class="box ">
          <h4> IVR ROBOCALL</h4>
        </div>
        <br>
        <br>

        <table class="table-short" id="tbl">
          <thead>
            <th style="text-align: center">#</th>
            <th style="text-align: center">Name</th>
            <th style="text-align: center">File</th>
            <th style="text-align: center">Action</th>
          </thead>
          <tbody>
            <?php
            $s_no = 1;
            while (!$rs->EOF) {
              $id = $rs->fields['id'];
              $ivr_name = $rs->fields['ivr_name'];
              $file_name = $rs->fields['file_name'];
            ?>
              <tr class="tbl_tr">
                <td><?= $s_no++ ?></td>
                <td><?= $ivr_name ?></td>
                <td>
                  <audio controls="controls">
                    <source src=<?= "robo_calls/$file_name.wav" ?> type="audio/x-wav">
                    <!-- /var/www/html/Octopus/robo_calls/robo_1.wav -->
                  </audio>
                </td>
                <td>
                  <a href="#" onclick="deleteIVR(<?= $id ?>)">
                    <i class="fa-solid fa-trash"></i>
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
  <?php include($site_admin_root . "includes/footer.php"); ?>
  <?php $s_no -= 1; ?>
  <script>
    // For Confirm Resubmisson Dialog
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    // Function to Delete Extension
    function deleteIVR(id) {
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
                  action: "delete"
                },
              })
              .done(function(response) {
                window.location = "ivr_Robocalls.php";
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

          exportOptions: {
            columns: [0, 1]
          },
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "csv",
          exportOptions: {
            columns: [0, 1]
          },
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "excel",
          exportOptions: {
            columns: [0, 1]
          },
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "pdf",
          exportOptions: {
            columns: [0, 1]
          },
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, {
          extend: "print",
          exportOptions: {
            columns: [0, 1]
          },
          messageBottom: '<?= "Total number of records : " . $s_no; ?>',
          messageTop: '<?= $dateTime ?>'
        }, ]
      });
    });
  </script>
</body>
<script type="text/javascript">

</script>