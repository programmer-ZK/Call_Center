<h4 class="white">
<?
include_once($site_root."includes/config.php"); 
include_once($site_root."includes/db_info.php"); 
$server='10.4.29.249';


//$server='192.168.5.140';
//$db_uid='root';
//$db_pass='';
//$db = 'm3techcc';
//$conn=mysql_connect('localhost','root','') or die(mysql_error());
//mysql_select_db('m3techcc') or die(mysql_error());

$sql_level1="SELECT * from cc_workcodes_new where parent_id =0; ";
$res_level1=mysql_query($sql_level1);
?>
<td>SELECT WORKCODES</td>
<br/>
<td>Level-1</td>
<td><select name="level1" onChange="window.location.href='http://<? echo $server?>/iworkcode.php?level1='+this.value;">
<option select value="">Select Workcode</option>

<? 
$i=1;
while($row_level1 = mysql_fetch_array($res_level1))
  {?>
<option  <?php if(isset($_GET['level1'])){if($_GET['level1']==$row_level1['id']) echo "selected";}?> value='<?echo $row_level1['id']?>'><? echo $row_level1['wc_title']?></option>

<?$i++;}?>

</select>
</td>
</tr>

<tr>

<?
if(isset($_GET['level1'])){
$level1 = $_GET['level1'];
if($level1 != "" ){



$sql_level2="SELECT * FROM cc_workcodes_new where parent_id='$level1'";

$res_level2=mysql_query($sql_level2);
$num = mysql_num_rows($res_level2);

if ($num != 0 ){
?>
<br/>
<td>Level-2</td>
<td><select name="level2" onChange="window.location.href='http://<? echo $server?>/iworkcode.php?level1=<?echo $level1?>&level2='+this.value;">
<?//<td><select name="level2" >?>
<option select value="">Select Sub WorkCode</option>

<? 
$i=1;
while($row_level2 = mysql_fetch_array($res_level2))
  {?>

<option  <?php if(isset($_GET['level2'])){if($_GET['level2']==$row_level2['id']){ echo "selected"; $makename=$row_level2['id'];}}?> value='<?echo $row_level2['id']?>'><? echo $row_level2['wc_title']?></option>
<?$i++;}?>

</select>
</td>
</tr>
<tr>

<?
}}
$sql_level3="SELECT * FROM cc_workcodes_new where parent_id='$makename'";
$res_level3=mysql_query($sql_level3);
$num = mysql_num_rows($res_level3);
$level2 = $_GET['level2'];
if((isset($_GET['level2'])) && $num !=0 && $level2!='' ) {




?>
<br/>
<td>Level-3</td>
<td><select name="level3" onChange="window.location.href='http://<? echo $server?>/iworkcode.php?level1=<?echo $level1?>&level2=<?echo $level2?>&level3='+this.value;">
<?//<td><select name="level3" >?>
<option select value="">Select Sub WorkCode</option>
<? 
$i=1;
while($row_level3 = mysql_fetch_array($res_level3))
  {?>
  
  <option  <?php if(isset($_GET['level3'])){if($_GET['level3']==$row_level3['id']){ echo "selected"; $makename=$row_level3['id'];}}?> value='<?echo $row_level3['id']?>'><? echo $row_level3['wc_title']?></option>
  
<!--<option  value='<?echo $row_level3['id']?>'><? echo $row_level3['wc_title']?></option>-->

<?$i++;}?>

</select>
</td>
</tr>
<? }
//}?>


<?
$level3 = $_GET['level3'];

$sql_level4="SELECT * FROM cc_workcodes_new where parent_id='$level3'";
$res_level4=mysql_query($sql_level4);
$num = mysql_num_rows($res_level4);

if((isset($_GET['level3'])) && $num !=0 && $level3!='' ) {




?>
<br/>
<td>Level-4</td>
<td><select name="level4" onChange="window.location.href='http://<? echo $server?>/iworkcode.php?level1=<?echo $level1?>&level2=<?echo $level2?>&level3=<?echo $level3?>&level4='+this.value;">
<?//<td><select name="level4" >?>
<option select value="">Select Sub WorkCode</option>
<? 
$i=1;
while($row_level4 = mysql_fetch_array($res_level4))
  {?>
  
  <option  <?php if(isset($_GET['level4'])){if($_GET['level4']==$row_level4['id']){ echo "selected"; $makename=$row_level4['id'];}}?> value='<?echo $row_level4['id']?>'><? echo $row_level4['wc_title']?></option>
  


<?$i++;}?>

</select>
</td>
</tr>
<? }
//}?>


<?
$level4 = $_GET['level4'];

$sql_level5="SELECT * FROM cc_workcodes_new where parent_id='$level4'";
$res_level5=mysql_query($sql_level5);
$num = mysql_num_rows($res_level5);

if((isset($_GET['level4'])) && $num !=0 && $level4!='' ) {




?>
<br/>
<td>Level-5</td>
<td><select name="level5" onChange="window.location.href='http://<? echo $server?>/iworkcode.php?level1=<?echo $level1?>&level2=<?echo $level2?>&level3=<?echo $level3?>&level4=<?echo $level4?>&level5='+this.value;">
<?//<td><select name="level5" >?>
<option select value="">Select Sub WorkCode</option>
<? 
$i=1;
while($row_level5 = mysql_fetch_array($res_level5))
  {?>
  
  <option  <?php if(isset($_GET['level5'])){if($_GET['level5']==$row_level5['id']){ echo "selected"; $makename=$row_level5['id'];}}?> value='<?echo $row_level5['id']?>'><? echo $row_level5['wc_title']?></option>
  

<?$i++;}?>

</select>
</td>
</tr>
<? }
}?>
</h4>
