<?php include template('header'); ?>

<div class="midder">
<?php include template('menu'); ?>

<h2>链接形式</h2>

<div>
<form method="POST" action="index.php?app=system&ac=urltype&ts=do">

<table>
    <tr>
      <td width="100">关闭伪静态：</td>
      <td><input type="radio" <?php if($TS_SITE['base'][site_urltype]==1) { ?>checked="select"<?php } ?> name="site_urltype" value="1" /> index.php?app=coats&tag=</td></tr>
	<tr>
	  <td>开启伪静态：</td><td><input type="radio" <?php if($TS_SITE['base'][site_urltype]==4) { ?>checked="select"<?php } ?> name="site_urltype" value="4" /> /coats/tag (暂只支持apache和iis环境的rewrite)</td></tr>
</table>

<div class="clear"></div>
<br />
<input class="btn btn_submit" type="submit" value="更改链接形式" />
</form>

</div>

</div>
<?php include template('footer'); ?>