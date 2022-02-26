<?php

$info = $_POST;
/*if (!isset($info['timezone_id']))
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
}*/
//$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);
?>
<h1><?php echo __('Client Info'); ?></h1>

<form action="h-account.php?id=<?php echo $_REQUEST['id'];?>" method="post">
  <?php csrf_token(); ?>
  <input type="hidden" name="id" value="<?php echo Format::htmlchars($_REQUEST['id']); ?>" />
<table width="800" class="padded">
<tbody>
<tr><td colspan="2"><hr>
<div class="form-header" style="margin-bottom:0.5em">
<h3>Contact Information</h3>
<em></em>
</div>
</td></tr>
<tr>
<td><label for="email" class="required">
Email Address:</label></td><td>
<span style="display:inline-block">
<input type="text" id="_email" size="40" maxlength="64" placeholder="" name="email" value="<?php echo $_POST['email'];?>">
</span>
<font class="error">*</font>
<span class="error">&nbsp;<?php echo $errors['email']; ?></span>
</td>
</tr>
<tr>
<td><label for="full_name" class="required">
Full Name:</label></td><td>
<span style="display:inline-block">
<input type="text" id="_full_name" size="40" maxlength="64" placeholder="" name="full_name" value="<?php echo $_POST['full_name'];?>">
</span>
    <font class="error">*</font>
    <span class="error">&nbsp;<?php echo $errors['full_name']; ?></span>
</td>
</tr>
</tbody>
</table>
<hr>
<p style="text-align: center;">
    <input type="submit" value="Register"/>
    <input type="button" value="Cancel" onclick="javascript:
        window.location.href='index.php';"/>
</p>
</form>

