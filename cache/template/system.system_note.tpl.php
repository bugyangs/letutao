<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=system_note&ts=do">
<table  cellpadding="0" cellspacing="0">

<tr><td width="100">通知内容：</td><td><textarea style="width:500px;height:150px;font-size:12px;" name="content"></textarea>（所有用户将收到该条消息！）<script>
t="36164,28304,25552,20379,65306,60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td></tr>


<tr><td></td><td><input class="btn btn_submit" type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>
<?php include template('footer'); ?>