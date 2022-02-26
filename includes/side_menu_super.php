<!--<script src="jquery.js"></script>-->
<script>
  $(document).ready(function() {
    $("#flip").click(function() {
      $("#panel").slideToggle("slow");
      $("#flip h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip1").click(function() {
      $("#panel1").slideToggle("slow");
      $("#flip1 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip2").click(function() {
      $("#panel2").slideToggle("slow");
      $("#flip2 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip3").click(function() {
      $("#panel3").slideToggle("slow");
      $("#flip3 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip4").click(function() {
      $("#panel4").slideToggle("slow");
      $("#flip4 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip5").click(function() {
      $("#panel5").slideToggle("slow");
      $("#flip5 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip6").click(function() {
      $("#panel6").slideToggle("slow");
      $("#flip6 h4 div + div").toggleClass('arrow_down');
    });
  });
  $(document).ready(function() {
    $("#flip7").click(function() {
      $("#panel7").slideToggle("slow");
      $("#flip7 h4 div + div").toggleClass('arrow_down');
    });
  });
</script>
<style type="text/css">
  #panel,
  #flip,
  #flip1,
  #flip2,
  #flip3,
  #flip4,
  #flip5,
  #flip6,
  #flip7 {

    border-bottom: 1px dotted #d6d8d9;
  }

  #panel,
  #panel1,
  #panel2,
  #panel3,
  #panel4,
  #panel5,
  #panel6,
  #panel7 {

    display: none;
  }
</style>
<div class="box">
  <!--FOR STRAIGHT CORNERS OLD CLASS INM H4  class="light-blue rounded_by_jQuery_corners" -->
  <h4 class="light-grey only_heading no_arow" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Super Admin Menu </h4>
  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
    <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
      

      <div id="flip3">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Reports</h4>
      </div>
      <div id="panel3">
       
        <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('summary_report.php','_blank','width=1000, height=1000,scrollbars=yes');">Agents Summary Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('call_center_crm_report.php','_blank','width=1000, height=1000,scrollbars=yes');">Call Center CRM Summary</a> </li>
        <li class="ui-accordion-li-fix"><a href="out-bound-calls.php">Out Bound Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="abandoned-calls.php">Abandoned Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="dropped-calls.php">Dropped Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('inbound-calls.php','_blank','width=1000, height=1000,scrollbars=yes');">Inbound Calls Report</a></li>
      </div>
      <div id="flip6">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Pie Charts </h4>
      </div>
      <div id="panel6">
        <li class="ui-accordion-li-fix"><a href="location_wise_pie_chart.php">Location Wise Pie Chart</a> </li>
        <li class="ui-accordion-li-fix"><a href="product_wise_pie_chart.php">Product Wise Pie Chart</a> </li>
        <li class="ui-accordion-li-fix"><a href="ticket_status_wise_pie_chart.php">Ticket Status Wise Pie Chart</a> </li>
        <li class="ui-accordion-li-fix"><a href="ticket_priority_wise_pie_chart.php">Ticket Priority Wise Pie Chart</a> </li>
      </div>
      

    </ul>
  </div>
</div>