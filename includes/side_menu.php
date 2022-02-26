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
  /*$(document).ready(function(){
    $("#flip8").click(function(){
      $("#panel8").slideToggle("slow");
  	$("#flip8 h4 div + div").toggleClass('arrow_down');
    });
  });
  */
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
  <h4 class="light-grey only_heading no_arow" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Supervisor Menu </h4>
  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
    <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
      <div id="flip7">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Call Agent Dashboard</h4>
      </div>
      <div id="panel7">
        <li class="ui-accordion-li-fix"><a href="agent-stats.php">Call Agent Dashboard</a> </li>
      </div>
      <div id="flip">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Call Records</h4>
      </div>
      <div id="panel">
        <!--	<li class="ui-accordion-li-fix"><a href="cdr-stats.php">Call Records</a> </li>-->
        <li class="ui-accordion-li-fix"><a href="icdr-stats.php">Call Records</a> </li>
        <li class="ui-accordion-li-fix"><a href="abandon_calls.php">Abandoned Call Records</a> </li>
        <li class="ui-accordion-li-fix"><a href="blacklist.php">BlackList Number</a> </li>
        <li class="ui-accordion-li-fix"><a href="priorityAlert.php">Priority Call Alert</a> </li>
        <li class="ui-accordion-li-fix"><a href="categoryRecords.php">Category Records</a> </li>
        <li class="ui-accordion-li-fix"><a href="categoryRecordsCount.php">Category Records Count</a> </li>
        <li class="ui-accordion-li-fix"><a href="recordCount.php">Records Count</a> </li>

      </div>
      <!-- <li><a href="blacklist.php"> BlackList Number</a></li> -->
      <div id="panel2">
        <!--<li class="ui-accordion-li-fix"><a href="agent_wise_campaign.php">Agent Wise Campaign Reports<font color="red">&nbsp;[New]</font></a> </li>-->
        <!--<li class="ui-accordion-li-fix"><a href="campaign_answers.php">View Campaign Answers<font color="red">&nbsp;[New]</font></a> </li>
	-->
        <!--<li class="ui-accordion-li-fix"><a href="caller_response.php">Caller Response<font color="red">&nbsp;[New]</font></a> </li>-->
        <!--<li class="ui-accordion-li-fix"><a href="campaign_answer_count.php">View Campaign Answers Count<font color="red">&nbsp;[New]</font></a> </li>
			
-->
      </div>
      <div id="flip3">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Reports</h4>
      </div>
      <div id="panel3">

        <li class="ui-accordion-li-fix"><a href="daily-stats.php">Daily Calls Report</a> </li>
        <!-- <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('monthly-stats.php','_blank','width=1000, height=1000');" >Monthly Report</a> </li>-->
        <li class="ui-accordion-li-fix"><a href="agent-pd-stats.php">Agents Productivity Report</a> </li>
        <!--   <li class="ui-accordion-li-fix"><a href="all_agent_pd_stats.php">All Agents Productivity Report</a></li>
      -->
        <li class="ui-accordion-li-fix"><a href="call_center_report.php">Call Center Statistics</a> </li>
        <!--   <li class="ui-accordion-li-fix"><a href="search_dropped_calls_report.php">Dropped-Calls Detailed Report</a> </li>
       -->
        <!--JD inline 22 dec 2014-->

        <li class="ui-accordion-li-fix"><a href="call_center_scheduling.php">IVR Recordings Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="summary_report.php" target="_blank" onclick="">Agents Summary Report</a> </li>
        <!-- window.open('summary_report.php','_blank','width=1000, height=1000,scrollbars=yes'); -->

        <!--		<li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('call_center_crm_report.php','_blank','width=1000, height=1000,scrollbars=yes');">Call Center CRM Summary</a> </li>!-->
        <!--  <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('call_center_crm_report_v2.php','_blank','width=1000, height=1000,scrollbars=yes');">Call Center CRM Summary V2</a> </li>-->
        <!--<li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('call_center_crm_detailed_report.php','_blank','width=1000, height=1000,scrollbars=yes');">Call Center CRM Detailed </a> </li>   !-->
        <!--<li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('call_center_crm_detailed_report_v2.php','_blank','width=1000, height=1000,scrollbars=yes');">Call Center CRM Detailed V2</a> </li>  -->

        <li class="ui-accordion-li-fix"><a href="out-bound-calls.php">Out Bound Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="in-bound-calls.php">Inbound Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="abandoned-calls.php">Abandoned Calls Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="dropped-calls.php">Dropped Calls Report</a> </li>
        <!--       <li class="ui-accordion-li-fix"><a href="javascript:;" onclick="window.open('inbound-calls.php','_blank','width=1000, height=1000,scrollbars=yes');">Inbound Calls Report</a></li>!-->
        <li class="ui-accordion-li-fix"><a href="offtime_call_summary.php">Off Time Call Summary</a> </li>
        <li class="ui-accordion-li-fix"><a href="agentLoginReport.php">Agent Login Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="breakRecord.php">Break Records</a> </li>
        <li class="ui-accordion-li-fix"><a href="callAnsTime.php">Call Answering Time Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="minMaxDuration.php">Minimum & Maximum Duration Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="callDistributionReport.php">Calls Distribution Report </a> </li>
        <li class="ui-accordion-li-fix"><a href="callCenterMain.php">Call Center Main Report </a> </li>

        <!-- <li class="ui-accordion-li-fix"><a href="work-code-summary.php">Work Code Summary Report</a> </li>-->
        <!--<li class="ui-accordion-li-fix"><a href="hourly_ratio_summary.php">Hourly Call Ratio Report</a> </li>
        <li class="ui-accordion-li-fix"><a href="offtime_call_summary.php">Off Time Call Summary</a> </li>-->
        <!-- <li class="ui-accordion-li-fix"><a href="inbound-calls.php">Inbound Calls Report</a> </li> -->
        <!--JD inline 22 dec 2014-->
        <!-- <li style="display:none;" class="ui-accordion-li-fix"><a href="iworkcode.php">WorkCode Report</a></li>-->
      </div>


      <!--JD inline 22 dec 2014-->
      <!--     <div  id="flip6">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Pie Charts </h4>
      </div>!-->
      <!--      <div  id="panel6">
       <li class="ui-accordion-li-fix"><a href="location_wise_pie_chart.php">Location Wise Pie Chart</a> </li>
       <li class="ui-accordion-li-fix"><a href="product_wise_pie_chart.php">Product Wise Pie Chart</a> </li>
       <li class="ui-accordion-li-fix"><a href="ticket_status_wise_pie_chart.php">Ticket Status Wise Pie Chart</a> </li>
       <li class="ui-accordion-li-fix"><a href="ticket_priority_wise_pie_chart.php">Ticket Priority Wise Pie Chart</a> </li> !-->
      <!--		<li class="ui-accordion-li-fix"><a href="call_eval.php">Call Evaluation</a> </li>-->
      <!--  <li class="ui-accordion-li-fix"><a href="icall_eval.php">Call Evaluation</a> </li>
      -->
      <!--<li class="ui-accordion-li-fix"><a href="call_scoring.php">Call Scoring</a> </li>-->
      <!-- </div>!-->
      <!--JD inline 22 dec 2014-->
      <div style="display:none;" id="flip4">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Test Scores</h4>
      </div>
      <div style="display:none;" id="panel4">
        <!--   <li class="ui-accordion-li-fix"><a href="test_scores_list.php">Test Scores</a> </li>
        <li class="ui-accordion-li-fix"><a href="test_scores_search.php">Test Scores Report</a> </li>
      -->
      </div>
      <!--JD inline 22 dec 2014-->
      <div style="display:none;" id="flip5">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Agent Performance</h4>
      </div>
      <div style="display:none;" id="panel5">
        <!--   <li class="ui-accordion-li-fix"><a href="agent_performance_report_search.php">Agent Performance</a> </li>
        <li class="ui-accordion-li-fix"><a href="agent_performance_report_weekly_search.php">Agent Performance Weekly</a> </li>
        <li class="ui-accordion-li-fix"><a href="agent_performance_report_weekly_graph_search.php">Agent Performance Weekly Graph</a> </li>
      -->
        <li class="ui-accordion-li-fix"><a href="agent_weekly_performance_trend_search.php">Agent Weekly Performance Trend</a> </li>
      </div>
      <!-- <div id="flip8">
        <h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Pie Charts</h4>
      </div>
      <div  id="panel8">
        <li class="ui-accordion-li-fix"><a href="agent_weekly_performance_trend_search.php">Agent Weekly Performance Trend</a> </li>
      </div>-->

    </ul>
  </div>
</div>