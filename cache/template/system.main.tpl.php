<?php include template('header'); ?>

<style>
.fbox{float:left;width:45%;margin-right:10px;}
</style>

<div class="midder">

<div class="fbox">
<h2>目录权限</h2>
<table>
<tr><td width="100">cache目录</td><td><?php if(iswriteable('cache')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>data目录</td><td><?php if(iswriteable('data')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>plugins目录</td><td><?php if(iswriteable('plugins')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
<tr><td>uploadfile目录</td><td><?php if(iswriteable('uploadfile')==0) { ?><font color="red">不可写</font>(请设置为可写777权限)<?php } else { ?>可写<?php } ?></td></tr>
</table>
</div>

<div class="fbox">
<h2>软件信息</h2>
<table>
<tr><td width="100">系统支持：</td><td>乐兔淘购物分享系统</td></tr>
<tr><td>程序版本：</td><td><?php echo $TS_SOFT['info'][version];?></td></tr>
<tr><td>联系方式：</td><td><?php echo $TS_SOFT['info'][email];?></td></tr>
<tr><td>官方网址：</td><td><a href="http://www.tuntron.com" target='_blank'>橙创网络科技有限公司</a></td></tr>
</table>
</div>

<div class="fbox"> 
<h2>服务器信息</h2>
<table>
    <tr><td width="100">服务器软件：</td><td><?php echo $TS_SOFT['system'][server];?></td></tr>
    <tr><td>操作系统：</td><td><?php echo $TS_SOFT['system'][phpos];?></td></tr>
    <tr><td>PHP版本：</td><td><?php echo $TS_SOFT['system'][phpversion];?></td></tr>
    <tr><td>MySQL版本：</td><td><?php echo $TS_SOFT['system'][mysql];?></td></tr>
    <tr><td>物理路径：</td><td><?php echo $_SERVER['DOCUMENT_ROOT'];?></td></tr>
	 <tr><td>附件上传限制：</td><td><?php echo $TS_SOFT['system'][upload];?></td></tr>
    <tr><td>图像处理：</td><td><?php echo $TS_SOFT['system'][gd];?> </td></tr>
    <tr><td>语言：</td><td><?php echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];?></td></tr>
    <tr><td>gzip压缩：</td><td><?php echo $_SERVER['HTTP_ACCEPT_ENCODING'];?></td></tr>
</table>
</div>

<div class="fbox" id="admindex_msg">
<h2>乐兔淘官方消息</h2>
<iframe src="http://www.tuntron.com/msg.html" width="100%" height="360" rows="150,800" frameborder="0" scrolling="no" style="overflow: visible;margin:0;padding:0;"></iframe>
</div>
<div id="footer" style="text-align:center; padding:10px;"></div>
</div>
<?php include template('footer'); ?>