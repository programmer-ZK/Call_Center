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

  .file-upload button {
    border: none;
    border-radius: 5px;
    padding: 4px 20px;
    background: #9E662F;
    color: white;
  }


  .line_br{
    width: 75%;
  }
</style>


<html>

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
        <p>filename.mp3</p>
        <input type="file">
        <button> Upload</button>
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
        <p>filename.mp3</p>
        <input type="file">
        <button> Upload</button>
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
        <p>filename.mp3</p>
        <input type="file">
        <button> Upload</button>
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