<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>
<table>
<tr><td width="100">全站：</td><td><a href="index.php?app=system&ac=cache&ts=del">清理全站缓存</a></td></tr>


<tr><td>模板：</td><td><a href="index.php?app=system&ac=cache&ts=del">清理模板缓存</a></td></tr>

<tr><td>相册：</td><td><a href="index.php?app=system&ac=cache&ts=del">清理相册缓存</a></td></tr>

<tr><td>板块头像：</td><td><a href="index.php?app=system&ac=cache&ts=del">清理板块头像缓存</a></td></tr>

<tr><td>用户头像：</td><td><a href="index.php?app=system&ac=cache&ts=del">清理用户头像缓存</a></td></tr>

</table>

</div>
<?php include template('footer'); ?>