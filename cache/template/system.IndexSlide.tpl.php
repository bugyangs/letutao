<?php include template('header'); ?>
<style>
.midder table tr td {
border-bottom: 1px solid #DDDDDD;
height: 24px;
line-height: 8px;
padding: 5px 20px;
vertical-align: top;
margin: 0;
outline: 0 none;
}
.btt {margin-top:6px; float:left;color:#FFFFFF; background:#318dd0; font-size:12px;  border-color:#106BAB #106BAB #0D68A9;color:#333;background:#f1f0f0;border:1px solid #c4c4c4;border-radius:2px;padding:4px 15px;display:inline-block;
cursor:pointer;text-decoration:none;overflow:visible;text-align:center;zoom:1;white-space:nowrap;margin-right:10px;font-family:inherit;position:relative;}
.odd a { display:block; width:177px; height:50px; line-height:10000px; background: no-repeat url(<?php echo SITE_URL; ?>images/b1_wide_120802.png) center center; text-indent:9999999px; border:#DDD 1px solid; overflow:hidden;}
.odd .laoding { background-image: url(<?php echo SITE_URL; ?>images/ico-operating.gif);}
.odd .zhu { border-color:#CCC}
.midder table tr td{ padding-top:20px;}
.mt_20{ margin-top:17px;}
.tfile {
filter: alpha(opacity=0);
opacity: 0;
font-size: 16px;
height: 51px;
width: 178px;
float: left;
margin-top: -30px;
overflow:hidden;
cursor: pointer;
}
</style>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL; ?>js/ajaxfileupload.min.js" type="text/javascript"></script>
<script>

function UploadShareImg(g_id){
	
	$("#a_"+g_id).addClass("laoding");
	$.ajaxFileUpload({
		url:"<?php echo SITE_URL; ?>index.php?app=share&ac=do&le=UploadImg&f=uploadShareImg_"+g_id,
		secureuri:false,
		dataType:'text',
		fileElementId:'uploadShareImg_'+g_id,
		success:function(result){
			$("#a_"+g_id). removeClass("laoding");
			var img_src = "<?php echo SITE_URL; ?>"+result;
			$("#a_"+g_id).css({"background-image":"url("+result+")","background-size":"177px 50px"});
			$("#img_url_"+g_id).attr("value",result);
			}
		}
	)}

</script>
<script>
function insertMenu(){
	$("#before").before('<tr><td><input class="input-text" name="slidetitle[]" value="请输入标题"></td><td><input class="input-text" name="slidedesc[]" style="width:250px;" value=""></td><td><input class="input-text" name="slideurl[]" style="width:250px;" value=""></td><td><input class="input-text" name="slideimg[]" style="width:250px;" value="">(图片尺寸960x270)</td><td><input class="input-text" name="sort[]" style="width:100px;" value=""></td></tr>');
}

</script>

<div class="midder">
<?php include template('menu'); ?>
<form method="POST" action="index.php?app=system&ac=IndexSlide&ts=do">
<table cellpadding="0" cellspacing="0">

<tbody><tr><td>幻灯标题（可留空）</td><td>幻灯简介（可留空）</td><td>幻灯链接（必填）</td><td>图片(必选，点击上传，注意尺寸)</td><td>排序</td></tr>

<?php foreach((array)$arrSlides as $key=>$item) {?>
<tr class="odd"><td><input type="hidden" name="id[]" value="<?php echo $item['id'];?>"><input class="input-text mt_20" name="slidetitle[]" value="<?php echo $item['title'];?>"></td><td><textarea name="slidedesc[]" style="height:52px; width:400px;line-height:24px;" ><?php echo $item['desc'];?></textarea></td><td><input class="input-text mt_20" name="slideurl[]" style="width:250px;" value="<?php echo $item['url'];?>"></td><td> <a href="javascript:;" style="background-image:url(<?php echo $item['img'];?>);background-size:177px 50px;" class="zhu" id="a_<?php echo $item['id'];?>">上传图片</a>
    <input class="tfile PUB_PIC_FILE" name="uploadShareImg_<?php echo $item['id'];?>" type="file" id="uploadShareImg_<?php echo $item['id'];?>" onchange="return UploadShareImg(<?php echo $item['id'];?>);">
    <input type="hidden" name="slideimg[]" value="<?php echo $item['img'];?>" id="img_url_<?php echo $item['id'];?>">
    
    </td><td><input class="input-text mt_20" name="sort[]" style="width:30px;" value="<?php echo $item['sort'];?>"></td></tr>
<?php }?>
<tr id="before"><td><input class="btn btn_submit" type="submit" value="提 交"></td><td></td><td>说明：首页只显示5个</td><td>清空提交即删除。</td><td></td></tr>

</tbody></table>

<form>
</div>
<?php include template('footer'); ?>