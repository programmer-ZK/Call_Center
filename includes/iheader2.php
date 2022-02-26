<?php ob_start(); ?>
<?php include($site_root."includes/make_page_url.php"); ?>
<?php include($site_root."includes/visitor_tracking.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $crm_name;?></title>
<!--    <link href="css/reset.css" rel="stylesheet" type="text/css" />-->


        <script src="jquery/jquery.js" type="text/javascript"></script>
        <script src="jquery/jquery-ui.custom.js" type="text/javascript"></script>
        <script src="jquery/jquery.cookie.js" type="text/javascript"></script>

        <link href="src/skin/ui.dynatree.css" rel="stylesheet" type="text/css" id="skinSheet">
        <script src="src/jquery.dynatree.js" type="text/javascript"></script>

        <!-- Start_Exclude: This block is not part of the sample code -->
        <link href="src/prettify.css" rel="stylesheet">
        <script src="src/prettify.js" type="text/javascript"></script>
        <link href="src/sample.css" rel="stylesheet" type="text/css">
        <script src="src/sample.js" type="text/javascript"></script>
        <!-- End_Exclude -->


<script type="text/javascript">


var treeData  = [ {title: "WorKCodes" ,  key: " " ,expand: true,
                       children:[ <?php echo $work_codes->recursive_make_tree_jq2(0,'root');?> }];






        $(function(){

                // --- Initialize sample trees
                $("#tree1").dynatree({
                        checkbox: true,
                        // Override class name for checkbox icon:
                        classNames: {checkbox: "dynatree-radio"},
                        selectMode: 1,
                        children: treeData,
                        onActivate: function(node) {
                                $("#echoActive1").text(node.data.title);
                        },
                        onSelect: function(select, node) {
                                // Display list of selected nodes
                                var s = node.tree.getSelectedNodes().join(", ");
                                $("#echoSelection1").text(s);
                        },
                        onDblClick: function(node, event) {
                                node.toggleSelect();
                        },
                        onKeydown: function(node, event) {
                                if( event.which == 32 ) {
                                        node.toggleSelect();
                                        return false;
                                }
                        },
                        // The following options are only required, if we have more than one tree on one page:
//                      initId: "treeData",
                        cookieId: "dynatree-Cb1",
                        idPrefix: "dynatree-Cb1-"
                });

                $("#tree2").dynatree({
                        checkbox: true,
                        selectMode: 2,
                        children: treeData,
                        onSelect: function(select, node) {
                                // Display list of selected nodes
                                var selNodes = node.tree.getSelectedNodes();
                                // convert to title/key array
                                var selKeys = $.map(selNodes, function(node){
                                           return "[" + node.data.key + "]: '" + node.data.title + "'";
                                });
                                $("#echoSelection2").text(selKeys.join(", "));
                        },
                        onClick: function(node, event) {
                                // We should not toggle, if target was "checkbox", because this
                                // would result in double-toggle (i.e. no toggle)
                                if( node.getEventTargetType(event) == "title" )
                                        node.toggleSelect();
                        },
                        onKeydown: function(node, event) {
                                if( event.which == 32 ) {
                                        node.toggleSelect();
                                        return false;
                                }
                        },
                        // The following options are only required, if we have more than one tree on one page:
                        cookieId: "dynatree-Cb2",
                        idPrefix: "dynatree-Cb2-"
                });

                $("#tree3").dynatree({
                        checkbox: true,
                        selectMode: 3,
                        children: treeData,
                        onSelect: function(select, node) {
                                // Get a list of all selected nodes, and convert to a key array:
                                var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
                                        return node.data.key;
                                });
                                $("#echoSelection3").text(selKeys.join(", "));

                                // Get a list of all selected TOP nodes
                                var selRootNodes = node.tree.getSelectedNodes(true);
                                // ... and convert to a key array:
                                var selRootKeys = $.map(selRootNodes, function(node){
                                        return node.data.key;
                                });
                                $("#echoSelectionRootKeys3").text(selRootKeys.join(", "));
                                $("#echoSelectionRoots3").text(selRootNodes.join(", "));
                        },
                        onDblClick: function(node, event) {
                                node.toggleSelect();
                        },
                        onKeydown: function(node, event) {
                                if( event.which == 32 ) {
                                        node.toggleSelect();
                                        return false;
                                }
                        },
                        // The following options are only required, if we have more than one tree on one page:
//                              initId: "treeData",
                        cookieId: "dynatree-Cb3",
                        idPrefix: "dynatree-Cb3-"
                });

                $("#tree4").dynatree({
                        checkbox: false,
                        selectMode: 2,
                        children: treeData,
                        onQuerySelect: function(select, node) {
                                if( node.data.isFolder )
                                        return false;
                        },
                        onSelect: function(select, node) {
                                // Display list of selected nodes
                                var selNodes = node.tree.getSelectedNodes();
                                // convert to title/key array
                                var selKeys = $.map(selNodes, function(node){
                                           return "[" + node.data.key + "]: '" + node.data.title + "'";
                                });
                                $("#echoSelection4").text(selKeys.join(", "));
                        },
                        onClick: function(node, event) {
                                if( ! node.data.isFolder )
                                        node.toggleSelect();
                        },
                        onDblClick: function(node, event) {
                                node.toggleExpand();
                        },
                        onKeydown: function(node, event) {
                                if( event.which == 32 ) {
                                        node.toggleSelect();
                                        return false;
                                }
                        },
                        // The following options are only required, if we have more than one tree on one page:
//                      initId: "treeData",
                        cookieId: "dynatree-Cb4",
                        idPrefix: "dynatree-Cb4-"
                });

                $("#btnToggleSelect").click(function(){
                        $("#tree2").dynatree("getRoot").visit(function(node){
                                node.toggleSelect();
                        });
                        return false;
                });
                $("#btnDeselectAll").click(function(){
                        $("#tree2").dynatree("getRoot").visit(function(node){
                                node.select(false);
                        });
                        return false;
                });
                $("#btnSelectAll").click(function(){
                        $("#tree2").dynatree("getRoot").visit(function(node){
                                node.select(true);
                        });
                        return false;
                });
                <!-- Start_Exclude: This block is not part of the sample code -->
                $("#skinCombo")
                .val(0) // set state to prevent caching
                .change(function(){
                        var href = "../src/"
                                + $(this).val()
                                + "/ui.dynatree.css"
                                + "?reload=" + new Date().getTime();
                        $("#skinSheet").attr("href", href);
                });
                <!-- End_Exclude -->
        });
</script>

    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/screen.css" rel="stylesheet" type="text/css" />
    <link href="js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
    <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox.css" />
    <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom.css" />
	<script src="js/datetimepicker_css.js"></script>
	<style type="text/css">
	        div.wysiwyg ul.panel li {padding:0px !important;}
			div#content {padding-top: 40px;} 
    </style>
    
</head>

<body style="background:none;" class="example">
<div id="container">

<!--    <div id="header">
      <div id="top">
      <h1><a href="index.php"><?php echo $crm_name; ?></a></h1>
      <p id="userbox">Hello <strong><?php echo $_SESSION[$db_prefix.'_UserName']; ?></strong> &nbsp;| &nbsp;<a href="admin_change_password.php">Settings</a> &nbsp;| &nbsp;<a href="logout.php">Logout</a> <br />
      <small>Last Login: <?php echo $_SESSION[$db_prefix.'_LLoginTime'];  ?></small></p>
      <span class="clearFix">&nbsp;</span>
      </div>
    </div>-->

<div id="content">
    
  <div id="mid-col">
 	 <?php // include($site_root."includes/message_panel.php"); ?>

<?php 
$static_time_array = array('00:00:00','01:00:00','02:00:00','03:00:00','04:00:00','05:00:00','06:00:00','07:00:00','08:00:00','09:00:00','10:00:00','11:00:00','12:00:00','13:00:00','14:00:00','15:00:00','16:00:00','17:00:00','18:00:00','19:00:00','20:00:00','21:00:00','22:00:00','23:00:00');
$static_hours_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
$static_minutes_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
?>
