<?php include template("admin/header");?>

<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script>
function insertMenu(){
	$("#before").before('<tr><td><input type="hidden" name="darenid[]" value="" /><input name="darenname[]" value="" /></td><td><input style="width:400px;" name="background[]" value="" /></td><td></td><td width="400"></td></tr>');
}
</script>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="index.php?app=user&ac=admin&mg=user&ts=adddaren">
<table  cellpadding="0" cellspacing="0">
<tr>

<td>达人类型名称</td>
<td width="400">显示背景</td>
<td>操作</td>
<td width="400"></td>
</tr>
<?php foreach((array)$arrdaren as $key=>$item) {?>
<tr>

<td>
<input type="hidden" name="darenid[]" value="<?php echo $item['darenid'];?>" />
<input class="input-text" name="darenname[]" value="<?php echo $item['darenname'];?>" /></td>
<td><input class="input-text" style="width:400px;" name="background[]" value="<?php echo $item['background'];?>" /></td>
<td><a href="index.php?app=system&ac=sitenav&ts=del&darenid=<?php echo $item['darenid'];?>" onClick="return confirm('您确定要删除吗，如不确定请点取消')">删除</a></td>
<td width="400"></td>
</tr>
<?php }?>
<tr id='before'>
<td><input type="submit" value="提 交" /></td>
<td></td>
<td></td>
<td width="400"></td>
</tr>
<tr>
<td></td>
<td><a href="javascript:void('0');" onclick="insertMenu();">添加达人类型</a></td>
<td></td>
<td width="400"></td>
</tr>
</table>
<div class="clear"></div>
<br />

</form>

</div>
<?php include template("admin/footer");?>