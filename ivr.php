<?php include_once("includes/config.php"); ?>
<?php
$page_name = "IVR";
$page_level = "0";
$page_group_id = "0";
$page_title = "IVR";
$page_menu_title = "IVR";
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

  .ivr_box .title {
    text-transform: uppercase;
    font-weight: 600;
    font-size: 20px;
  }

  .file-upload {
    display: flex;
    margin-top: 20px;
  }

  .file-upload p {
    margin: 0px 80px 0px 0px;
  }

  .file-upload input[type="submit"] {
    border: none;
    border-radius: 5px;
    padding: 4px 20px;
    background: #9E662F;
    color: white;
  }


  .line_br {
    width: 60%;
  }
</style>


<html>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $file_type       =  $_REQUEST["file_type"];
  $target_dir = "/var/lib/asterisk/sounds/usr_sounds/call_center/";
  $target_file = $target_dir . $file_type . ".wav";
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["ivr_file"]["name"]), PATHINFO_EXTENSION));

  if ($_FILES["ivr_file"]["error"] > 0) {
    echo "Error: " . $_FILES["ivr_file"]["error"] . "<br>";
  } else {
    echo "File Name: " . $_FILES["ivr_file"]["name"] . "<br>";
    echo "File Type: " . $_FILES["ivr_file"]["type"] . "<br>";
    echo "File Size: " . ($_FILES["ivr_file"]["size"] / 1024) . " KB<br>";
    echo "Stored in: " . $_FILES["ivr_file"]["tmp_name"] . " KB<br>";
  }

  // Check if file already exists
  if (file_exists($target_file)) {
    $date = date("Y-m-d");
    if (rename($target_file, "'$target_dir'/'$file_type'_'$date'.wav")) {
      echo "File Rename status: Done <br>";
    } else {
      echo "File Rename status: Nope <br>";
    }
  }

  // Allow certain file formats
  if ($imageFileType != "wav") {
    echo "Sorry, only .wav file is allowed. <br>";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded. <br>";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["ivr_file"]["tmp_name"],  $target_dir . $file_type . ".wav")) {
      echo "Upload status: Success <br> ";
      echo "File Name: " .  $file_type . ".wav";
    } else {
      echo " <br> Upload status: Sorry, there was an error uploading your file.";
    }
  }
}
?>

<head>
  <script type="text/javascript">
    function getHtml4Excel() {
      document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
    }
  </script>
</head>

<body>
  <div style="margin-left: 20px;">

    <div class="box ">
      <h4> IVR Settings</h4>
    </div>
    <br>
    <br>


    <div class="ivr_box">
      <h1 class="title">Welcome IVR</h1>

      <div class="file-upload">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <input type="file" name="ivr_file">
          <input type="hidden" name="file_type" value="intro">
          <input type="submit" value="Upload">
        </form>
      </div>

      <br>
      <div class="line_br">
        <hr>
      </div>
      <br>
    </div>

    <div class="ivr_box">
      <h1 class="title">Busy IVR</h1>

      <div class="file-upload">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <input type="file" name="ivr_file">
          <input type="hidden" name="file_type" value="Busy-IVR">
          <input type="submit" value="Upload">
        </form>
      </div>

      <br>
      <div class="line_br">
        <hr>
      </div>
      <br>
    </div>

    <div class="ivr_box">
      <h1 class="title">Hold IVR</h1>

      <div class="file-upload">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <input type="file" name="ivr_file">
          <input type="hidden" name="file_type" value="Bahria-Adv">
          <input type="submit" value="Upload">
        </form>
      </div>

      <br>
      <div class="line_br">
        <hr>
      </div>
      <br>
    </div>


  </div>
  </div>
  </div>
  </div>
  <?php include($site_admin_root . "includes/footer.php"); ?>

</body>
<script type="text/javascript">

</script>