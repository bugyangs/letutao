<?php include template('header'); ?>

<!--main-->
<div class="midder">
<?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=do&ts=diskyun">
<table  cellpadding="0" cellspacing="0">
<tr><th>开启云存储 :</th><td><input class="input-text" type="radio" <?php if($YunOption['isopen']=='0') { ?>checked="select"<?php } ?> name="isopen" value="0" />关闭 <input class="input-text" type="radio" <?php if($YunOption['isopen']=='1') { ?>checked="select"<?php } ?> name="isopen" value="1" />开启  (系统所产生的图片将上传到云空间。 <a href="http://bbs.tuntron.com/thread-1465-1-1.html" target="_blank">如何设置云存储？</a>）</td></tr>

<tr><th width="100">云平台：</th><td>
<select name="YunCom" style="width:300px;">
<option <?php if($YunOption['YunCom'] ==baidu) { ?>selected="selected"<?php } ?> value="baidu">百度云</option>
</select>
(选择云存储商家，暂只支持百度云存储，需要做其他云存储请联系客服：QQ70020765)
</td></tr>

<tr><th>AK 公钥：</th><td><input class="input-text" style="width:300px;" name="AK" value="<?php echo $YunOption['AK'];?>" /> 
(云平台提供)</td></tr>

<tr><th>SK 私钥：</th><td><input class="input-text" style="width:300px;" name="SK" value="<?php echo $YunOption['SK'];?>" /> (云平台提供)</td></tr>

<tr><th>空间名：</th><td><input class="input-text" style="width:300px;" name="Bucket" value="<?php echo $YunOption['Bucket'];?>" /> (云平台提供的空间名称，如百度云的Bucket名称。<a href="http://developer.baidu.com/bae/bcs/bucket/" target="_blank">进入百度云存储</a>)</td></tr>

<tr><th>加载链接：</th><td><input class="input-text" style="width:300px;" name="loadUrl" value="<?php echo $YunOption['loadUrl'];?>" /> (即文件上传后的打开地址，必须以http://开头，以/结尾，如百度云存储为http://bcs.duapp.com/Bucket名称/)</td></tr>

<tr><th>删除本地缓存 :</th><td><input class="input-text" type="radio" <?php if($YunOption['isdel']=='1') { ?>checked="select"<?php } ?> name="isdel" value="1" />删除 <input class="input-text" type="radio" <?php if($YunOption['isdel']=='0') { ?>checked="select"<?php } ?> name="isdel" value="0" />保留  (图片上传到云空间后是否本地保留，非必要请选择“删除”，提高本地存储空间。）</td></tr>

<tr><td></td><td><input class="btn btn_submit" type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template('footer'); ?>