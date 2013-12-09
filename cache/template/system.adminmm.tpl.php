<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=adminmm&ts=do">
<table  cellpadding="0" cellspacing="0">

<tr><td width="100">输入新密码：</td><td><input class="input-text" type="password" style="width:300px;" name="password1" value="" /></td></tr>
<tr><td>重输新密码：</td><td><input class="input-text" type="password" style="width:300px;" name="password2" value="" /></td></tr>

<tr><td></td><td><input class="btn btn_submit" type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>
<?php include template('footer'); ?>