<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=admin&mg=options&ts=do">
<table  cellpadding="0" cellspacing="0">

<tr><td width="150">APP名称：</td><td><input name="appname" value="<?php echo $strOption['appname'];?>" /></td></tr>
<tr><td>APP介绍：</td><td><textarea name="appdesc"><?php echo $strOption['appdesc'];?></textarea></td></tr>
<tr><td>APP是否启用:</td><td><input <?php if($strOption['isenable']=='0') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="0" />启用 <input <?php if($strOption['isenable']=='1') { ?>checked="select"<?php } ?> name="isenable" type="radio" value="1" />关闭</td></tr>

<tr style="display:none"><td>模式：</td>
<td>

<input <?php if($strOption['ismode']=='0') { ?>checked="select"<?php } ?> name="ismode" type="radio" value="0" />多板块模式

<input <?php if($strOption['ismode']=='1') { ?>checked="select"<?php } ?> name="ismode" type="radio" value="1" />单板块模式

(慎用)

</td></tr>

<?php if($strOption['ismode']=='0') { ?>

<tr><td>是否允许用户创建板块 :</td><td><input <?php if($strOption['iscreate']=='0') { ?>checked="select"<?php } ?> name="iscreate" type="radio" value="0" />允许 <input <?php if($strOption['iscreate']=='1') { ?>checked="select"<?php } ?> name="iscreate" type="radio" value="1" />不允许</td></tr>

<tr><td>创建板块是否需要审核 :</td><td><input <?php if($strOption['isaudit']=='1') { ?>checked="select"<?php } ?> name="isaudit" type="radio" value="1" />审核 <input <?php if($strOption['isaudit']=='0') { ?>checked="select"<?php } ?> name="isaudit" type="radio" value="0" />不审核</td></td></tr>

<tr>
<td style="display:none">板块分类设置：</td>
<td style="display:none"><input type="radio" <?php if($strOption['iscate']=='1') { ?>checked="select"<?php } ?> name="iscate" value="1" />一级分类 <input type="radio" <?php if($strOption['iscate']=='2') { ?>checked="select"<?php } ?> name="iscate" value="2" />二级分类</td>
</tr>

<?php } ?>

<tr><td></td><td><input type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template("admin/footer");?>