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
  <div>
    <form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

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
                    <input name="ex_number" id="ex_number" class="txtbox-short-date mt-1">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Name :
                    </label>
                    <input name="ex_name" id="ex_name" class="txtbox-short-date mt-1">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Password :
                    </label>
                    <input name="ex_password" id="ex_password" class="txtbox-short-date mt-1">
                  </td>
                  <td style="border: none;">
                    <label class="fw-500">
                      Rights :
                    </label>
                    <select name="ex_rights" id="ex_rights" class="mt-1">
                      <option value="Only_Extensions">Only Extensions</option>
                      <option value="Complete_Outgoing">Complete Outgoing</option>
                      <option value="call_Center_Agent">Call Center Agent</option>
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
        <tr>
          <td>1</td>
          <td>3009</td>
          <td>John Doe</td>
          <td>*********</td>
          <td>Call Center Agent</td>
          <td><a href="#">Edit</a> | <a href="#">Delete</a> </td>
        </tr>
        <tr>
          <td>2</td>
          <td>3009</td>
          <td>John Doe</td>
          <td>*********</td>
          <td>Call Center Agent</td>
          <td><a href="#">Edit</a> | <a href="#">Delete</a> </td>
        </tr>
        <tr>
          <td>3</td>
          <td>3009</td>
          <td>John Doe</td>
          <td>*********</td>
          <td>Call Center Agent</td>
          <td><a href="#">Edit</a> | <a href="#">Delete</a> </td>
        </tr>
        <tr>
          <td>4</td>
          <td>3009</td>
          <td>John Doe</td>
          <td>*********</td>
          <td>Call Center Agent</td>
          <td><a href="#">Edit</a> | <a href="#">Delete</a> </td>
        </tr>
        <tr>
          <td>5</td>
          <td>3009</td>
          <td>John Doe</td>
          <td>*********</td>
          <td>Call Center Agent</td>
          <td><a href="#">Edit</a> | <a href="#">Delete</a> </td>
        </tr>
      </tbody>
    </table>


  </div>
  </div>
  </div>
  </div>
  <?php include($site_admin_root . "includes/footer.php"); ?>

  <script>
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