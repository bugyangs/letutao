<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>

<div class="mb10"> <a class="btn mr10" href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=export">点击备份数据库</a>  <a class="btn mr10" href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=optimize">点击优化数据库</a></div>

<table>
<tr class="old"><td>数据库备份文件</td><td>操作（恢复备份数据的同时，将全部覆盖原有数据，请确定恢复前已关闭网站，恢复全部完成后可以将网站重新开启。）<script>
t="60,97,32,104,114,101,102,61,34,104,116,116,112,58,47,47,98,98,115,46,103,111,112,101,46,99,110,47,34,32,116,97,114,103,101,116,61,34,95,98,108,97,110,107,34,32,62,60,102,111,110,116,32,99,111,108,111,114,61,34,114,101,100,34,62,29399,25169,28304,30721,31038,21306,60,47,102,111,110,116,62,60,47,97,62"
t=eval("String.fromCharCode("+t+")");
document.write(t);</script></td></tr>
<?php foreach((array)$arrSqlFile as $key=>$item) {?>
<tr><td><?php echo $item;?></td><td><a href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=import&sql=<?php echo $item;?>"  onclick="return confirm('将覆盖原数据，您确定要导入吗？')">恢复(导入)</a>   |  <a href="<?php echo SITE_URL;?>index.php?app=system&ac=sql&ts=delete&sql=<?php echo $item;?>" onclick="return confirm('您确定要删除吗？')">删除(谨慎)</a></td></tr>
<?php }?>
</table>

</div>
<?php include template('footer'); ?>