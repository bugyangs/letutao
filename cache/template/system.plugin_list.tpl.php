<?php include template('header'); ?>
<!--main-->
<div class="midder">

<h2>登陆设置</h2>

<table  cellpadding="0" cellspacing="0">
<tr class="old"><td width="100">名称</td ><td width="30">版本</td><td>作者/介绍</td><td width="100">操作</td></tr>
<?php foreach((array)$arrPlugin as $key=>$item) {?>
<?php if($item['name']!=='gobad' && $item['name']!=='counter' && $item['name']!=='sitemap') { ?>

<tr class="odd"><td><?php echo $item['about'][name];?> (<?php echo $item['name'];?>)</td><td><?php echo $item['about'][version];?></td><td><?php echo $item['about'][desc];?><br />作者：<a href="<?php echo $item['about'][author_url];?>"><?php echo $item['about'][author];?></a></td><td>

<?php if(in_array($item['name'],$app_plugins)) { ?><a href="index.php?app=system&ac=plugin&ts=do&apps=<?php echo $apps;?>&pname=<?php echo $item['name'];?>&isused=0">停用</a><?php } else { ?><a href="index.php?app=system&ac=plugin&ts=do&apps=<?php echo $apps;?>&pname=<?php echo $item['name'];?>&isused=1">启用</a><?php } ?>

<?php if($item['about'][isedit]=='1' && in_array($item['name'],$app_plugins)) { ?><a href="index.php?app=<?php echo $apps;?>&ac=plugin&plugin=<?php echo $item['name'];?>&in=edit&ts=set">配置</a><?php } ?>

<a href="index.php?app=system&ac=plugin&ts=del&pname=<?php echo $item['name'];?>">删除</a>

</td></tr>
<?php } ?>
<?php }?>
</table>

</div>
<?php include template('footer'); ?>