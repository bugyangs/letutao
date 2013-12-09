<?php include template("admin/header");?>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script>
function setcate(goods_id,cate_name){
	
			$.ajax({
		type:"POST",
		url:"index.php?app=share&ac=admin&mg=goods&ts=setcate",
		data:"&goods_id="+goods_id+"&cate_name="+cate_name,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
		};
		
function setname(goods_id,name){
	
$.ajax({
		type:"POST",
		url:"index.php?app=share&ac=admin&mg=goods&ts=setname",
		data:"&goods_id="+goods_id+"&name="+name,
		beforeSend:function(){},
		success:function(result){
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
		};
function s(type){
	if(type=='goods_id'||type=='name'||type=='uid'){
		document.getElementById("selectc").innerHTML='<input type="text"  class="input-text" id="selectvalue" name="selectvalue" value="" style="width:230px;" />';
	}
	if(type=='cate_id'){
		document.getElementById("selectc").innerHTML='<select id="selectvalue" name="selectvalue" style="width:150px"><?php echo getCateOption($selectvalue)?>{/loop}</select>';
		
	}
}
 
function sumb(){
	var selecttype=document.getElementById("selecttype").value;
	var selectvalue=document.getElementById("selectvalue").value;
	window.location='<?php echo SITE_URL;?>index.php?app=share&ac=admin&mg=goods&ts=list&selecttype='+selecttype+"&selectvalue="+selectvalue;
}
</script>
<script>
$(function(){
   //全选反选
		$('.J_checkall').live('click', function(){
			$('.J_checkitem').attr('checked', this.checked);
			$('.J_checkall').attr('checked', this.checked);
    	});
});
function redirect(url) {
		window.location.replace(url);
	}

</script>
<script language="javascript" for="document" event="onkeydown">
  var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
     if (keyCode == 13) {
      sumb();
     } 
 </script>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>
<?php if($pageUrl) { ?><div class="manu"><?php echo $pageUrl;?></div><?php } ?>
  <table  cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2">
      <select id="selecttype" name="selecttype" onchange="s(this.value)">
        <option value="0">搜索条件</option>
        <option value="goods_id" <?php if($selecttype=='goods_id') { ?>selected="selected"<?php } ?>>按商品ID搜索</option>
        <option value="name" <?php if($selecttype=='name') { ?>selected="selected"<?php } ?>>按商品标题搜索</option>
        <option value="uid" <?php if($selecttype=='uid') { ?>selected="selected"<?php } ?>>按商品发布者搜索</option>
        <option value="cate_id" <?php if($selecttype=='cate_id') { ?>selected="selected"<?php } ?>>按商品分类搜索</option>
        </select>
     </td>
      <td colspan="6" >
      <div id="selectc" style="float:left;">
      	 <?php if($selecttype&&$selecttype!=='cate_id') { ?>
         <input type="text" class="input-text" id="selectvalue" name="selectvalue" value="<?php echo $selectvalue;?>" style="width:230px;">
         <?php } ?>
         <?php if($selecttype=='cate_id') { ?>
         <select id="selectvalue" name="selectvalue" style="width:150px"><?php echo getCateOption($selectvalue)?>{/loop}</select>
		<?php } ?>
      </div>
      <div style="float:left; margin-left:15px;">
          <input class="btn btn_submit"  style="float:left;" type="button" onclick="sumb()" value="搜  索" />
      </div>
     </td>
    </tr>
   <form action="<?php echo SITE_URL;?>index.php?app=share&ac=admin&mg=goods&ts=delmore" method="post">
    <tr class="old">
      <td width="50"><input style=" margin-top:8px;" type="checkbox" name="checkall" class="J_checkall" />
        全选</td>
      <td width="20" align="center">ID</td>
      <td width="240">标题(可直接编辑修改)</td>
      <td width="100">发布者</td>
      <td>分类</td>
      <td>相关参数</td>
      <td>发布时间</td>
      <td>操作</td>
    </tr>
    <?php foreach((array)$arrgoods as $key=>$item) {?>
  <tr onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
    <td ><input  type="checkbox" class="J_checkitem" name="goods_iid[]" value="<?php echo $item['goods_id'];?>" /></td>
    <td><a href="index.php?app=baobei&amp;ac=<?php echo $item['goods_id'];?>" target="_blank" title="点击查看商品"><?php echo $item['goods_id'];?></a></td>
    <td><input class="input-text" onchange="setname('<?php echo $item['goods_id'];?>',this.value);" name="name" value="<?php echo $item['name'];?>"  style=" line-height:24px; width:240px;"/></td>
    <td><a href="index.php?app=user&amp;ac=admin&amp;mg=user&amp;ts=view&amp;userid=<?php echo $item['uid'];?>" target="_blank"><?php echo $item['user'][username];?></a></td>
    <td><select name="select" style="width:150px" onchange="setcate('<?php echo $item['goods_id'];?>',this.value);">
      <option value="0">修改分类</option>
     <?php echo getCateOption($item['cate_name'])?>
    </select></td>
    <td><input class="input-text" name="name" value="评论:<?php echo $item['count_comment'];?>,查看:<?php echo $item['count_view'];?>,喜欢:<?php echo $item['count_like'];?>,值得:<?php echo $item['count_worth'];?>, 价格:<?php echo $item['price'];?>元"  style=" line-height:24px;"/></td>
    <td><?php echo date('Y-m-d H:i:s',$item['uptime'])?></td>
    <td><a href="<?php echo SITE_URL;?>index.php?app=share&amp;ac=admin&amp;mg=goods&amp;ts=del&amp;goods_id=<?php echo $item['goods_id'];?>" onclick="return confirm('您确定要删除该商品吗？')"><font color="red">X删除</font></a></td>
  </tr>
    <?php }?>
  <tr>
    <td width="50"><input style=" margin-top:8px;" type="checkbox" name="checkall" class="J_checkall" />
      全选</td>
    <td align="left" colspan="7"><input style="margin-top:6px; float:left;color:#FFFFFF; background:#318dd0; font-size:12px;  border-color:#106BAB #106BAB #0D68A9;color:#333;background:#f1f0f0;border:1px solid #c4c4c4;border-radius:2px;padding:4px 15px;display:inline-block;
cursor:pointer;text-decoration:none;overflow:visible;text-align:center;zoom:1;white-space:nowrap;margin-right:10px;font-family:inherit;position:relative;" type="submit" onclick="return confirm('您确定要删除勾选商品吗？')" value="删  除" /></td>
  </tr>
  </form>
  </table>

<div class="manu"><?php echo $pageUrl;?></div>
</div>
<?php include template("admin/footer");?>