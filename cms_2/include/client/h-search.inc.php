<?php
$info = $_POST;
if (!isset($info['timezone_id']))
    $info += array(
        'timezone_id' => $cfg->getDefaultTimezoneId(),
        'dst' => $cfg->observeDaylightSaving(),
        'backend' => null,
    );
if (isset($user) && $user instanceof ClientCreateRequest) {
    $bk = $user->getBackend();
    $info = array_merge($info, array(
        'backend' => $bk::$id,
        'username' => $user->getUsername(),
    ));
}
$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);

?>
<h1><?php echo __('Client Search'); ?></h1>

<form method="post" action="">
   <?php csrf_token(); ?>
<table width="800" class="padded">
<tbody>
<tr>
<td><label for="phone"  class="required">
Phone Number:</label></td><td>
<span style="display:inline-block">
<input id="_phone" type="text" name="phone" value="<?php echo $_POST['phone'];?>"> Ext:
<input type="text" name="phone-ext" style="width: 50px;" value="<?php echo $_POST['phone-ext'];?>" size="5">
</span>
<font class="error">*</font>
<span class="error">&nbsp;<?php echo $errors['phone']; ?></span>

</td>
</tr>
<tr>
<td colspan="2">
<hr>
<p style="text-align: center;">
    <input type="submit" value="Search"/>
    
</p>
</td>
</tr>
</tbody>
</table>

</form>

