<?php include template("admin/header");?>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<form method="POST" action="<?php echo SITE_URL;?>index.php?app=common&ac=admin&mg=info&ts=about_do">
<table  cellpadding="0" cellspacing="0">
<tr><td>关于我们</td></tr>
<tr><td><textarea style="width:600px;height:300px" name="infocontent"><?php echo $strInfo['infocontent'];?></textarea></td></tr>
<tr><td>
<input type="hidden" name="infokey" value="about" />
<input type="submit" value="提 交" /></td></tr>
</table>
</form>
</div>

<?php include template("admin/footer");?>