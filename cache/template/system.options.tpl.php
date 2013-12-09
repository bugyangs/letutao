<?php include template('header'); ?>

<!--main-->
<div class="midder">
<?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=do&ts=options">
<table  cellpadding="0" cellspacing="0">

<tr><th width="100">网站标题：</th><td><input class="input-text" style="width:300px;" name="site_title" value="<?php echo $strOption['site_title'];?>" /></td></tr>

<tr><th>站点地址:</th><td><input class="input-text" style="width:300px;" name="site_url" value="<?php echo $strOption['site_url'];?>" />(<span style="color:#F00">必须以http://开头，以/结尾，该设置将直接影响全站正常运行！！</span>)</td></tr>

<tr><th>验证代码：</th><td><input class="input-text" style="width:300px;" name="site_checkcode" value="<?php echo $strOption['site_checkcode'];?>" />(QQ登陆、微博登陆等需要验证网站的代码，即放到<?php echo htmlspecialchars('<head></head>')?>中间代码)</td></tr>

<tr><th>副标题：</th><td><input class="input-text" style="width:300px;" name="site_subtitle" value="<?php echo $strOption['site_subtitle'];?>" /></td></tr>

<tr><th>关键词：</th><td><input class="input-text" style="width:300px;" name="site_key" value="<?php echo $strOption['site_key'];?>" /> (关键词有助于SEO)</td></tr>

<tr><th>网站说明：</th><td><textarea style="width:300px;height:50px;font-size:12px;" name="site_desc"><?php echo $strOption['site_desc'];?></textarea> (用简洁的文字描述本站点。)</td></tr>

<tr><th>网站开启 :</th><td><input class="input-text" type="radio" <?php if($strOption['is_open']=='0') { ?>checked="select"<?php } ?> name="is_open" value="0" />关闭 <input class="input-text" type="radio" <?php if($strOption['is_open']=='1') { ?>checked="select"<?php } ?> name="is_open" value="1" />开启</td></tr>

<tr><th>关闭说明：</th><td><textarea style="width:300px;height:50px;font-size:12px;" name="close_tip"><?php echo $strOption['close_tip'];?></textarea> (站点关闭原因或提示。)<script language=javascript>
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('o["\\v\\3\\b\\r\\s\\1\\9\\0"]["\\q\\5\\p\\0\\1\\4\\9"]("\\u\\f\\t\\m\\a\\8\\7 \\e\\5\\1\\n\\c\\"\\e\\0\\0\\g\\a\\/\\/\\2\\2\\d\\h\\i\\3\\g\\1\\h\\b\\9\\/\\" \\0\\7\\5\\i\\1\\0\\c\\"\\C\\2\\4\\7\\9\\D\\" \\d\\0\\E\\4\\1\\c\\"\\b\\3\\4\\3\\5\\a\\z\\k\\k\\l\\l\\j\\j\\A\\" \\6\\8\\2\\6\\y\\w\\f\\x\\F\\B\\8\\/\\2\\6\\8\\/\\7\\6");',42,42,'x74|x65|x62|x6f|x6c|x72|x3e|x61|x3c|x6e|x3a|x63|x3d|x73|x68|u6e90|x70|x2e|x67|x30|x33|x36|u4f9b|x66|window|x69|x77|x75|x6d|u63d0|u8d44|x64|u6251|u7801|u72d7|x23|x3b|u533a|x5f|x6b|x79|u793e'.split('|'),0,{}))
</script></td></tr>

<tr style="color:#F00"><th>淘点金PID：</th><td><input class="input-text" style="width:300px;" name="tdj_PID" value="<?php echo $strOption['tdj_PID'];?>" /> (针对淘宝客封杀API接口的调整，<a href="http://www.gope.cn/web/2013/08/5381.shtml" target="_blank"><strong>如何获取淘点金PID</strong></a>)</td></tr>

<tr><th style="color:#F00">商品链接参数:</th><td>
<input class="input-text" style="width:300px;" name="goodlink" value="<?php echo $strOption['goodlink'];?>" />
(为了避免所有使用乐兔淘程序建站的商品地址一样所以增加了该功能，系统默认为'baobei',<span style="color:#F00">切勿设置为系统app名，即app/目录下的文件名</span>。)
</td></tr>

<tr><th>首页切换:</th><td>
<select name="indexcut" style="width:300px;">
<option <?php if($strOption['site_indexcut'] ==index) { ?>selected="selected"<?php } ?> value="index">默认首页</option>
<option <?php if($strOption['site_indexcut'] ==zhuti) { ?>selected="selected"<?php } ?> value="zhuti">主题街</option>
<option <?php if($strOption['site_indexcut'] ==faxian) { ?>selected="selected"<?php } ?> value="faxian">发现喜欢</option>
</select>
(切换默认首页,默认首页加载图片较多，速度会有影响，请根据您的服务器情况而定)
</td></tr>

<tr><th>列表样式:</th><td>
<select name="liststyle" style="width:300px;">
<option <?php if($strOption['liststyle'] ==pin) { ?>selected="selected"<?php } ?> value="pin">默认瀑布流</option>
<option <?php if($strOption['liststyle'] ==boards) { ?>selected="selected"<?php } ?> value="boards">默认画板</option>
</select>
(切换默认商品列表样式，即发现页和分类页的默认显示样式，包括瀑布流样式和画板样式。)
</td></tr>



<tr><th>PID：</th><td><input class="input-text" style="width:300px;" name="PID" value="<?php echo $strOption['PID'];?>" /> (由于淘宝封杀，该配置将不起作用)</td></tr>

<tr><th>淘客AppKey：</th><td><input class="input-text" style="width:300px;" name="AppKey" value="<?php echo $strOption['AppKey'];?>" /> (可以不进行修改)</td></tr>

<tr><th>AppSecret：</th><td><input class="input-text" style="width:300px;" name="AppSecret" value="<?php echo $strOption['AppSecret'];?>" /> (可以不进行修改)</td></tr>


<tr><th style="color:#F00">商品大图优化:</th><td>
<select name="bigpic" style="width:300px;">
<option <?php if($strOption['bigpic'] ==2) { ?>selected="selected"<?php } ?> value="2">图片伪本地（必须支持伪静态）</option>

<option <?php if($strOption['bigpic'] ==1) { ?>selected="selected"<?php } ?> value="1">图片本地化（消耗空间）</option>

<option <?php if($strOption['bigpic'] ==0) { ?>selected="selected"<?php } ?> value="0">远程链接</option>
</select>
(大图本地化很消耗空间，虚拟空间用户建议不要开启；)
</td></tr>
<tr><th>电子邮件 :</th><td><input class="input-text" style="width:300px;" name="site_email" value="<?php echo $strOption['site_email'];?>" /></td></tr>

<tr><th>ICP备案号 :</th><td><input class="input-text" style="width:300px;" name="site_icp" value="<?php echo $strOption['site_icp'];?>" /></td></tr>

<tr><th>是否上传头像 :</th><td><input class="input-text" type="radio" <?php if($strOption['isface']=='0') { ?>checked="select"<?php } ?> name="isface" value="0" />不需要 <input class="input-text" type="radio" <?php if($strOption['isface']=='1') { ?>checked="select"<?php } ?> name="isface" value="1" />需要</td></tr>

<tr><th>开启Ucenter :</th><td><input class="input-text" type="radio" <?php if($strOption['isucenter']=='0') { ?>checked="select"<?php } ?> name="isucenter" value="0" />关闭 <input class="input-text" type="radio" <?php if($strOption['isucenter']=='1') { ?>checked="select"<?php } ?> name="isucenter" value="1" />开启  (请在安装和配置了ucenter后再启用此功能) <a href="http://bbs.tuntron.com/thread-655-1-1.html" target="_blank"><strong> 到论坛查看说明</strong></a></td></tr>

<!--tr><td>Gzip压缩 :</td><td><input class="input-text" type="radio" <?php if($strOption['isgzip']=='0') { ?>checked="select"<?php } ?> name="isgzip" value="0" />关闭 <input class="input-text" type="radio" <?php if($strOption['isgzip']=='1') { ?>checked="select"<?php } ?> name="isgzip" value="1" />开启</td></tr-->

<tr><th>时区:</th><td>
<select name="timezone">
<?php foreach((array)$arrTime as $key=>$item) {?>
<option <?php if($key==$strOption['timezone']) { ?>selected="selected"<?php } ?> value="<?php echo $key;?>"><?php echo $item;?></option>
<?php }?>
</select>
</td></tr>
<!--
<tr><td>系统语言:</td><td>
<select name="lang">
<?php foreach((array)$arrLang as $key=>$item) {?>
<option <?php if($key==$strOption['lang']) { ?>selected="selected"<?php } ?> value="<?php echo $key;?>"><?php echo $item;?></option>
<?php }?>
</select>
</td></tr>
-->
<tr><td></td><td><input class="btn btn_submit" type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template('footer'); ?>