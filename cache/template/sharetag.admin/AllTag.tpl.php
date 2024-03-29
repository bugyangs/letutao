<?php include template("admin/header");?>
<style>
#loading {
	position:absolute; left:10px; color:#FFF; padding:2px 4px; float:left;position: fixed;_position: absolute;z-index: 10; background-color:#F00; display:none;
}
.blank_tag{padding: 2px 5px;white-space: nowrap;border-radius: 2px; background-color:#CCC; color:#FFF}
.n_tag{padding: 2px 5px;white-space: nowrap;border-radius: 2px; background-color:#006B9F; color:#FFF}
.h_tag{background-color:#F00}
.tip { margin:5px}
.tip p {line-height:24px; padding:0; margin:0;}
.core_pop_wrap {
background-color: #fff;
border: 1px solid #ccc;
box-shadow: 0 0 5px rgba(0,0,0,0.2);
border-radius: 3px;
position:absolute;
right:450px;
top:-30px;
z-index: 10;
color: #333;
outline: none;
}
.pop_top {
line-height: 18px;
padding: 9px 0 8px;
border-top: 1px solid #fff;
border-bottom: 1px solid #e7e7e7;
background: #f6f6f6;
zoom: 1;
margin-bottom: 5px;
}

.hr {
border-bottom:#e4e4e4 1px dashed;
height: 1px;
overflow: hidden;
font: 0/0 Arial;
clear: both;
padding-top:10px;
margin: 10px 0;
}
.pop_close {
margin-top: 5px;
float: right;
width: 16px;
height: 16px;
overflow: hidden;
text-indent: -2000em;
background: url(images/close.png) no-repeat;
-webkit-transition: all 0.2s ease-out;
margin-left: 10px;
}
.pop_top .pop_close {
margin-right: 15px;
}
.pop_top strong {
text-indent: 15px;
font-size: 14px;
color: #333;
font-weight: 700;
white-space: nowrap;
margin-right: 10px;
float: left;
}
.pop_cont {
background: #fff;
color: #333;
padding: 5px 7px 5px;
}
.cc {
zoom: 1;
}
.pop_top:after {
content: '\20';
display: block;
height: 0;
clear: both;
visibility: hidden;
width: 1px;
}
.pop_top {
line-height: 18px;
zoom: 1;
}
.cc{
	zoom:1;
}
.cc:after{
	content:'\20';
	display:block;
	height:0;
	clear:both;
	visibility: hidden;
}
.c{
	clear:both;
	height:0;
	font:0/0 Arial;
	overflow:hidden;
	width:0;
}
thead th.first {
border: none;
padding-left: 5px;
}
.midder table tr td {
	vertical-align: middle;
}
.pop_region_list {
padding-bottom: 10px;
}
.pop_region_list ul {
padding: 5px;
}
.pop_region_list ul li {
margin:2px;
float: left;
line-height: 20px;
}
.pop_region_list ul li a, .pop_region_list ul li span {
display: block;
padding: 0 5px;
color: #333;
white-space: nowrap;
border-radius: 2px;
}
.pop_region_list ul li a:hover{
	background:#e0e0e0;
	text-decoration:none;
}
.pop_region_list ul li.current a,
.pop_region_list ul li.current span{
	background:#266aae;
	color:#ffffff;
}

.odd ul li a { display:block; width:30px; height:30px; background: no-repeat url(<?php echo SITE_URL; ?>images/b1_wide_120802.png) center center; text-indent:9999999px; border:#DDD 1px solid; overflow:hidden;}
.odd ul li .laoding { background-image: url(<?php echo SITE_URL; ?>images/ico-operating.gif);}
.odd ul li .zhu { border-color:#FFD0D0}

.tfile {
filter: alpha(opacity=0);
opacity: 0;
font-size: 16px;
height: 31px;
width: 31px;
float: left;
margin-top: -30px;
overflow:hidden;
cursor: pointer;
}

</style>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL; ?>js/ajaxfileupload.min.js" type="text/javascript"></script>
<script>

function set_is_index(tag_id,is_index,cate_id){
		is_index==1?$("#is_index").val(0):$("#is_index").val(1);
			$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=AllCateTag&ts=set_is_index",
		data:"&tag_id="+tag_id+"&is_index="+is_index+"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			window.location.reload(true); 
			
		}
	})
		};
		
function setweight(tag_id,weight,cate_id){
	
			$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=AllCateTag&ts=setweight",
		data:"&tag_id="+tag_id+"&weight="+weight+"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			if(result == '1'){
				//window.location.reload(true); 
			}
		}
	})
		};

function UploadShareImg(g_id){
	
	$("#a_"+g_id).addClass("laoding");
	$.ajaxFileUpload({
		url:"<?php echo SITE_URL; ?>index.php?app=share&ac=do&le=UploadTagImg&f=uploadShareImg_"+g_id,
		secureuri:false,
		dataType:'text',
		fileElementId:'uploadShareImg_'+g_id,
		success:function(result){
			$("#a_"+g_id). removeClass("laoding");
			var img_src = "<?php echo SITE_URL; ?>"+result;
			$("#a_"+g_id).css({"background-image":"url("+result+")","background-size":"30px 30px"});
			$("#img_url_"+g_id).attr("value",result);
			}
		}
	)}

function set_is_hot(tag_id,is_hot){
			$.ajax({
		type:"POST",
		url:"index.php?app=share&ac=do&le=set_tag_hot",
		data:"&tag_id="+tag_id+"&is_hot="+is_hot,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			
		}
	})
		};


function set_cate(tag_id){
	
	$.ajax({
		type:"POST",
		url:"index.php?app=share&ac=do&le=getCateBytag",
		data:"&tag_id="+tag_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			if(result){
				$("#J_cate_"+tag_id).html(result);
				$("#J_region_"+tag_id).show();
				
			}
		}
	})
		
		};
		
function setweight(tag_id,weight,cate_id){
	
			$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=AllCateTag&ts=setweight",
		data:"&tag_id="+tag_id+"&weight="+weight+"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			if(result == '1'){
				//window.location.reload(true); 
			}
		}
	})
		};
function del_tag(id){
	if(confirm('同时删除标签归类，您确定删除吗？')){
			$.ajax({
		type:"POST",
		url:"index.php?app=sharetag&ac=admin&mg=goods_tags&ts=del_tag",
		data:"&id="+id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();
			if(result == '1'){
				$("#"+id).remove(); 
			}
		}
	})
		};
}

function s(type){
	if(type=='tag_id'||type=='name'||type=='uid'){
		$("#selectc").html('<input type="text" onkeydown="javascript:;" class="input-text" id="selectvalue" name="selectvalue" value="" style="width:150px;" />');
		$.browser.msie?'':$("#selectc").css("padding-top",2);
	}
	if(type=='cate_name'){
		$("#selectc").html('<select id="selectvalue" name="selectvalue" style="width:157px"><?php echo getCateOption($selectvalue)?>{/loop}</select>');
		$("#selectc").css("padding-top",0)
		
	}
}
 
 
function sumb(){
	var selecttype=document.getElementById("selecttype").value;
	var selectvalue=document.getElementById("selectvalue").value;
	window.location='<?php echo SITE_URL;?>index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype='+selecttype+"&selectvalue="+selectvalue;
}

function J_close(tagid){
	
	$("#J_region_"+tagid).hide();
	
}

function J_set_cate(tagid,cate_id){
	
	
	$.ajax({
		type:"POST",
		url:"index.php?app=share&ac=do&le=set_cate_tag",
		data:"&tagid="+tagid+"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide();

				if($("#J_getcate_"+tagid+cate_id).hasClass("current")){
					$("#J_getcate_"+tagid+cate_id).removeClass("current");
				}else{
					$("#J_getcate_"+tagid+cate_id).addClass('current');
					
				}
				if(result){
					
					$("#J_cate_Go_"+tagid).html(result);
					
				}else{
					$("#J_cate_Go_"+tagid).html('<a href="javascript:;" onclick="return set_cate('+tagid+');"  class="blank_tag">未归类</a>');
					}
				setTimeout($("#J_region_"+tagid).hide(),800); 
			}
	})
	
	
}

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
<div id="loading">正在加载...</div>
<!--main-->
<div class="midder">

<?php include template("admin/menu");?>
<?php if($pageUrl) { ?><div class="manu"><?php echo $pageUrl;?></div><?php } ?>
<form action="<?php echo SITE_URL;?>index.php" method="post">
<div class="tip">请看说明：<p>1、标签归类的准确度决定了自动判断商品分类的准确性，尽量不要一个标签对应多个分类；</p><p>2、标签热度即标签的商品数，大于100并且设为热门标签则首页热门标签自动显示红色背景</p><p>3、标签归类项的红色背景为首页标签即首页大分类下显示的标签，标签缩略图也将在首页这里显示，<span style="color:#F00">筛选分类后可对首页标签、权重等进行设置</span>。</p><p>4、随商品的增多，标签库会自动丰富，但这些自动提取的标签不会归类，所以要经常手动归类，将提升自动匹配分类的准确度。</p><p>5、权重值即标签在某个分类的权重，必须筛选分类才能设置，如值设为1000可以100%匹配，也就是说，只要标题中含有该标签即可以判断为该分类。<br />  如：某个商品名为【新款夏欧美女装休闲套装短袖修身白色上衣】，其中包含了【上衣】这个关键词，可以判断100%是属于上装分类，那么就把【<a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=name&selectvalue=上衣">上衣</a>】这个关键词的权重设置为1000即可。</p><p>6、支持多标签名筛选，多个请用<strong> 空格 </strong>分开。</p></div>
<table>
 <tr>
      <td>
      <select id="selecttype" style="float:left;margin-right:10px;" name="selecttype" onchange="s(this.value)">
        <option value="name" <?php if($selecttype=='name') { ?>selected="selected"<?php } ?>>按标签名称筛选</option>
        <option value="cate_name" <?php if($selecttype=='cate_name') { ?>selected="selected"<?php } ?>>按标签分类筛选</option>
        </select>

      &nbsp;&nbsp;
      
      
       <?php if($selecttype!=='cate_name'&&$selecttype!=='tag_id') { ?>
       <div id="selectc" style="float:left;padding-top: 2px; margin-right:10px;">
         <input type="text" class="input-text" id="selectvalue" name="selectvalue" onkeydown="javascript:;" value="<?php echo $selectvalue;?>" style="width:150px;">
            </div>
         <?php } ?>
         <?php if($selecttype=='cate_name') { ?>
           <div id="selectc" style="float:left;">
         <select id="selectvalue" name="selectvalue" style="width:157px"><?php echo getCateOption($selectvalue)?>{/loop}</select>
            </div>
		<?php } ?>
         
   
      <div style="float:left; margin-left:0px;">
          <input class="btn btn_submit"  style="float:left;" type="button" onclick="sumb()" value="筛 选" />
           <input class="btn btn_submit"  style="float:left;" type="button" onclick="window.location.reload(true);" value="刷 新" />
      </div>
      <?php if($selecttype) { ?>

      <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=del_tag_by&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>"  onclick="return confirm('同时删除标签归类的标签，您确定全部删除吗？');">删除当前筛选的<span style="color:#F00"><?php echo $tagNum;?></span>个标签</a>
      
      <?php } else { ?>
       <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=del_tag_by&selecttype=all"  onclick="return confirm('同时删除标签归类的标签，您确定全部删除吗？');">清空全部标签</a>
      <?php } ?>
     </td>
      <td style="color:#363">
     </td>
    </tr>
</table>
<table id="checkList" class="table-list list" cellpadding="0" cellspacing="0"
border="0">

    <thead>
      <tr class="" style="background-color:#F9F9F9">
            <td width="50"><input type="checkbox" class="J_checkall"><a href="javascript:;"  onclick="del_tag();">删除</a></td>
            <td align="left" width="30">ID</td>
            <td align="left" width="100">标签名称</td>
            <td align="left" width="240">标签归类（可点击进行归类）</td>
            <td align="left" width="50">缩略图</td>
            <td align="left" width="80">
            <?php if($sort=='is_hot') { ?>
             <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&page=<?php echo $page;?>">热门标签↓</a>
             <?php } else { ?>
              <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&sort=is_hot&page=<?php echo $page;?>" title="点击按热门排序">热门标签↑</a>
<?php } ?>
           </td>
            <td align="center" width="50">
            
             <?php if($sort=='count') { ?>
            <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&page=<?php echo $page;?>">热度↓</a>
             <?php } else { ?>
             <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&sort=count&page=<?php echo $page;?>" title="点击按热度排序">热度↑</a>
<?php } ?>
           </td>
            <?php if($selecttype=='cate_name') { ?>
           <td align="center" width="80">
            
             <?php if($sort=='is_index') { ?>
            <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&page=<?php echo $page;?>" title="点击按权重排序">首页标签↓</a>
             <?php } else { ?>
             <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&sort=is_index&page=<?php echo $page;?>" title="点击按权重排序">首页标签↑</a>
<?php } ?>
           </td>
           
               <td align="center" width="100">
            
             <?php if($sort=='weight') { ?>
            <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&page=<?php echo $page;?>" title="点击按权重排序">权重↓</a>
             <?php } else { ?>
             <a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list&selecttype=<?php echo $selecttype;?>&selectvalue=<?php echo $selectvalue;?>&sort=weight&page=<?php echo $page;?>" title="点击按权重排序">权重↑</a>
                </td>
            			 
           <?php } ?>
           <?php } else { ?>  
             
              <td align="center" width="80" style="color:#CCC">首页标签</td>
           
           	  <td align="center" width="80" style="color:#CCC">权重</td>
<?php } ?>


            <td align="center">操作</td>
      </tr>
    </thead>
    <tbody>
    
    <?php foreach((array)$arrnavtag as $key=>$item) {?>
    
      <tr class="" id="<?php echo $item['tag_id'];?>" onmouseover="this.style.background='#F1F8FC'" onmouseout="this.style.background=''">
            <td class="first">
                <input type="checkbox" class="J_checkitem" name="tag_id[]" value="<?php echo $item['tag_id'];?>">
            </td>
             <td align="left">
                <?php echo $item['tag_id'];?>
            </td>
            <td align="left">
                <?php echo $item['tag_name'];?>
            </td>
             <td>
             <span  id="J_cate_Go_<?php echo $item['tag_id'];?>">
             <?php if($item['cate']) { ?>
             	<?php foreach((array)$item['cate'] as $k=>$v) {?>
                	<?php if($v['cate_name']) { ?>
                 	<a href="javascript:;" onclick="return set_cate(<?php echo $item['tag_id'];?>);"  <?php if($v['is_index']) { ?> class="n_tag h_tag" title="该标签为【<?php echo $v['cate_name'];?>】分类的首页标签" <?php } else { ?>class="n_tag"<?php } ?>><?php echo $v['cate_name'];?></a>
                    
                   
                    <?php } ?>
				<?php }?>
                <?php } else { ?>

                <a href="javascript:;" onclick="return set_cate(<?php echo $item['tag_id'];?>);" class="blank_tag"> 未归类 </a>

                <?php } ?>
                </span>
            </td>
            
             <td class="odd">
                <ul>
                <li>
                <a href="javascript:;" <?php if($item['img']) { ?>
style="background-image:url(<?php echo $item['img'];?>);background-size:30px 30px;"<?php } ?>  class="zhu" id="a_<?php echo $item['tag_id'];?>">上传图片</a>
                <input class="tfile PUB_PIC_FILE" name="uploadShareImg_<?php echo $item['tag_id'];?>" type="file" id="uploadShareImg_<?php echo $item['tag_id'];?>" onchange="return UploadShareImg(<?php echo $item['tag_id'];?>);">
                </li>
    			</ul>
               
            </td>
            
             <td>
             
               	<input type="checkbox" id="is_hot" <?php if($item['is_hot']==1) { ?>checked="checked"<?php } ?>  onchange="set_is_hot(<?php echo $item['tag_id'];?>,this.value);" value="<?php if($item['is_hot']==1) { ?>0<?php } else { ?>1<?php } ?>" style="margin-left:23px;">
            </td>
            <td align="center"><?php echo $item['count'];?></td>
            <?php if($selecttype=='cate_name') { ?>
			
            
            <td align="center">
               	<input type="checkbox" id="is_index" <?php if($item['is_index']==1) { ?>checked="checked"<?php } ?>  onchange="set_is_index(<?php echo $item['tag_id'];?>,this.value,<?php echo $item['cate_id'];?>);" value="<?php if($item['is_index']==1) { ?>0<?php } else { ?>1<?php } ?>" style="margin-left:17px;">
            </td>
            
            
            <td align="center">
               <input onchange="setweight('<?php echo $item['tag_id'];?>',this.value,<?php echo $item['cate_id'];?>);" class="input-text" style="width:50px;" value="<?php echo $item['weight'];?>"> 
            </td>
            <?php } else { ?>
           <td align="center">
               	
            </td>
            <td align="center">
              
            </td>
            <?php } ?>
            <td align="center" style="position:relative">
            <div class="core_pop_wrap" id="J_region_<?php echo $item['tag_id'];?>" style="display:none;">		
<div class="core_pop">		
<div style="width:400px;">	
<div class="pop_top">		
<a href="javascript:;" class="pop_close J_region_close" onclick="return J_close(<?php echo $item['tag_id'];?>);">关闭</a>	<strong>选择分类</strong>		</div>						
<div class="pop_cont">							
<div class="pop_region_list">
            <ul id="J_cate_<?php echo $item['tag_id'];?>" class="cc">
            </ul>
            </div>	
            </div>						
            </div>	
            </div>
            
            </div>
                 <a href="javascript:;" onclick="del_tag(<?php echo $item['tag_id'];?>)">删除</a>
            </td>
            </tr>
        <?php }?>    
            
    </tbody>
</table>
</form>
<div class="manu" style="margin-bottom:100px"><?php echo $pageUrl;?></div>
</div>

</div>
<?php include template("admin/footer");?>