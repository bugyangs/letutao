<?php include template("admin/header");?>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script>
function setdaren(userid,darenid){
			$.ajax({
		type:"POST",
		url:"index.php?app=user&ac=admin&mg=user&ts=setdaren",
		data:"&userid="+userid+"&darenid="+darenid,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
		};

</script>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>

<div class="manu"><?php echo $pageUrl;?></div>

<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td width="60">UID</td><td width="200">Email</td><td width="100">姓名</td><td>注册时间</td><td>设置达人</td><td>操作</td></tr>
<?php foreach((array)$arrAllUser as $key=>$item) {?>
<tr class="odd"><td><?php echo $item['userid'];?></td>
<td><?php echo $item['email'];?></td><td><?php echo $item['username'];?></td>
<td><?php echo date('Y-m-d H:i:s',$item['addtime'])?></td>
<td>

<select onchange="setdaren(<?php echo $item['userid'];?>,this.value);" style="width:150px">
<option value="0">未设置达人</option>
<?php foreach((array)$arrdaren as $key=>$iitem) {?>
<option <?php if($iitem['darenid']==$item['darenid']) { ?>selected="selected"<?php } ?> value="<?php echo $iitem['darenid'];?>"><?php echo $iitem['darenname'];?></option>

<?php }?>
</select>

</td>
<td><a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=view&userid=<?php echo $item['userid'];?>">[明细]</a> <a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=isenable&&userid=<?php echo $item['userid'];?>&isenable=<?php if($item['isenable']=='0') { ?>1<?php } else { ?>0<?php } ?>"><?php if($item['isenable']=='0') { ?>[停用]<?php } else { ?><font color="red">[启用]</font><?php } ?></a> <a href="<?php echo SITE_URL;?>index.php?app=user&ac=admin&mg=user&ts=del&userid=<?php echo $item['userid'];?>" onClick="return confirm('您确定要删除该用户的全站的所有信息吗？如果您开启了ucenter，删除后如需再使用该email注册，需要先删除ucenter用户数据')"><font color="red">X删除</font></a></td></tr>
<?php }?>
</table>

</div>
<?php include template("admin/footer");?>