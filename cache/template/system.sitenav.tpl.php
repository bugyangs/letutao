<?php include template('header'); ?>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script>
function insertMenu(){
	$("#before").before('<tr onmouseover="this.style.background=\'#F1F8FC\'" onmouseout="this.style.background=\'\'"><td><input class="input-text" style="width:20px;" name="sort[]" value="" /></td><td width="100"><input class="input-text" type="hidden" name="cate_id[]" value="" /><input class="input-text" style="width:100px;" name="cate_name[]" value="" /></td><td><input class="input-text" style="width:100px;" name="appname[]" value="" /></td><td><textarea name="seo_keywords[]" ></textarea></td><td><textarea name="seo_desc[]" ></textarea></td><td></td></tr>');
}
//设为显示
function isappnav(cate_id){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=sitenav&ts=isnav",
		data:"&cate_id="+cate_id,
		beforeSend:function(){},
		success:function(b){
			window.location.reload(true); 
		}
	})
}

//取消隐藏
function unisappnav(cate_id){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=sitenav&ts=unnav",
		data:"&cate_id="+cate_id,
		beforeSend:function(){},
		success:function(b){
				window.location.reload(true); 
		}
	})
}

</script>
<div class="midder">
<?php include template('menu'); ?>

<h2>导航设置 <span style="color:#FF0000; font-size:12px;">注意：appname(必须英文，不能用app/目录下文件夹名)</span></h2>

<div>
<form method="POST" action="index.php?app=system&ac=sitenav&ts=do_nav">

<table  cellpadding="0" cellspacing="0">
<tr class="old">
<td width="20">排序</td>
<td width="80">导航名称</td>
<td width="100">appname</td>
<td width="170">关键词</td>
<td width="170">描述（建议120字以内）</td>
<td width="36">状态</td>
<td width="38">删除</td>
</tr>

<tr  onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="indexname" value="<?php echo $TS_SITE['sysnav']['index']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="index"/></td>
<td><textarea name="index_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['index']['seo_keywords'];?></textarea></td>
<td><textarea name="index_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['index']['seo_desc'];?></textarea></td>


<td><?php if($TS_SITE['sysnav']['index'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('index');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('index');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>


<tr  onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="faxianname" value="<?php echo $TS_SITE['sysnav']['faxian']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="faxian"/></td>
<td><textarea name="faxian_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['faxian']['seo_keywords'];?></textarea></td>
<td><textarea name="faxian_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['faxian']['seo_desc'];?></textarea></td>

<td><?php if($TS_SITE['sysnav']['faxian'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('faxian');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('faxian');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>


<?php foreach((array)$sitenav as $key=>$item) {?>
<?php if($item['appname']!==faxian) { ?>
<tr  onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;" name="sort[]" value="<?php echo $item['sort'];?>" /></td>
<td width="100">
<input class="input-text" type="hidden" name="cate_id[]" value="<?php echo $item['cate_id'];?>" />
<input class="input-text" type="hidden" name="is_nav[]" value="<?php echo $item['is_nav'];?>" />
<input class="input-text" style="width:100px;" name="cate_name[]" value="<?php echo $item['cate_name'];?>" /></td>
<td><input class="input-text" style="width:100px;" name="appname[]" value="<?php echo $item['appname'];?>" /></td>
<td><textarea name="seo_keywords[]" rows="1"><?php echo $item['seo_keywords'];?></textarea></td>
<td><textarea name="seo_desc[]" rows="1"><?php echo $item['seo_desc'];?></textarea></td>
<td><?php if($item['is_nav']==1) { ?><a href="javascript:;" onclick="unisappnav('<?php echo $item['cate_id'];?>');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('<?php echo $item['cate_id'];?>');">已隐藏</a><?php } ?></td>
<td><a href="index.php?app=system&ac=sitenav&ts=del&cate_id=<?php echo $item['cate_id'];?>" onClick="return confirm('您确定要删除吗，如不确定请点取消')">删除</a></td>
</tr>
<?php } ?>
<?php }?>
<tr id='before' style=" display:none"><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>



<tr  onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="groupname" value="<?php echo $TS_SITE['sysnav']['group']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="group"/></td>
<td><textarea name="group_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['group']['seo_keywords'];?></textarea></td>
<td><textarea name="group_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['group']['seo_desc'];?></textarea></td>


<td><?php if($TS_SITE['sysnav']['group'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('group');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('group');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>


<tr onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="feedname" value="<?php echo $TS_SITE['sysnav']['feed']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="feed"/></td>
<td><textarea name="feed_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['feed']['seo_keywords'];?></textarea></td>
<td><textarea name="feed_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['feed']['seo_desc'];?></textarea></td>


<td><?php if($TS_SITE['sysnav']['feed'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('feed');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('feed');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>

<tr onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="zhutiname" value="<?php echo $TS_SITE['sysnav']['zhuti']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="zhuti"/></td>
<td><textarea name="zhuti_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['zhuti']['seo_keywords'];?></textarea></td>
<td><textarea name="zhuti_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['zhuti']['seo_desc'];?></textarea></td>


<td><?php if($TS_SITE['sysnav']['zhuti'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('zhuti');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('zhuti');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>

<tr onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
<td><input class="input-text" style="width:30px;color:#CCC"  readonly="readonly" value="默认"/></td>
<td width="100">
<input class="input-text" style="width:100px;" name="tuanname" value="<?php echo $TS_SITE['sysnav']['tuan']['name'];?>" /></td>
<td><input class="input-text" style="width:100px;color:#CCC"  readonly="readonly" value="tuan"/></td>
<td><textarea name="tuan_seo_keywords" rows="1"><?php echo $TS_SITE['sysnav']['tuan']['seo_keywords'];?></textarea></td>
<td><textarea name="tuan_seo_desc" rows="1"><?php echo $TS_SITE['sysnav']['tuan']['seo_desc'];?></textarea></td>


<td><?php if($TS_SITE['sysnav']['tuan'][is_show]==1) { ?><a href="javascript:;" onclick="unisappnav('tuan');">已显示</a><?php } else { ?><a href="javascript:;" onclick="isappnav('tuan');">已隐藏</a><?php } ?></td>
<td><a href="javascript:;"  style="color:#CCC" onClick="return alert('系统导航禁止删除')">删除</a></td>
</tr>

<tr id='before'><td></td><td><input class="btn btn_submit" type="submit" value="提 交" /></td><td></td><td></td><td></td>

<td></td>
  <td></td>
</tr>






<tr><td></td><td></td><td><a href="javascript:void('0');" onclick="insertMenu();">点我添加导航</a></td><td></td><td></td><td></td>
  <td></td>
</tr>
</table>

<div class="clear"></div>
<br />
</form>

</div>

</div>
<?php include template('footer'); ?>