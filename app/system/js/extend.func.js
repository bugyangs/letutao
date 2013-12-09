function insertSubcate(id,cate_id){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=navtag&ts=add_subcate",
		data:"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide()
			if(result>0){
				$(id).append('<div class="top" style="height:70px"><div class="tag-img"><a href="index.php?app=system&ac=navtag&ts=subcate_ico&subcate_id='+result+'&cate_id={$strcate[cate_id]}" title="点击更换分类图标"><img src="images/subcate_ico.png" title="点击更换分类图标"></a></div><ul><textarea onchange="settag('+result+',this.value);" style="height:44px; width:90%; line-height:22px;overflow:hidden;"></textarea></ul><a href="javascript:;" onclick="del_subcate('+result+');" title="删除" style="color:#e63; line-height:24px;">删除</a></div>');
			}
		}
	})

}


function insertcate(cate_id){
	$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=navtag&ts=add_cate",
		data:"&cate_id="+cate_id,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			
			$("#loading").hide()
			if(result>0){
				$("#cate").append('<div class="item" id="item_'+result+'" style="background-color:#F2F9FB; margin:0 5px 5px 5px; padding:10px;"><h3 style="font-size:12px;"><input onchange="setcate('+result+',this.value);" class="input-text" style="width:50px;" value="请修改"> &nbsp;&nbsp;&nbsp;&nbsp; <span><a href="{$item[cate_name]}" title="查看全部标签" style="color:#999">全部标签</a></span> - <span><a href="javascript:;" onclick="del_cate('+result+');"  title="删除" style="color:#e63">删除</a></span> - <span><a href="javascript:;" onclick="insertSubcate(item_'+result+','+result+');" title="添加标签组" style="color:#e63">添加标签组</a></span></h3></div>');
			}
		}
	})

}



function setcate(cate_id,cate_name){
	
			$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=navtag&ts=do_catename",
		data:"&cate_id="+cate_id+"&cate_name="+cate_name,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide()
			
		}
	})
		};
		
function settag(subcate_id,tag){
		$.ajax({
		type:"POST",
		url:"index.php?app=system&ac=navtag&ts=do_subtag",
		data:"&subcate_id="+subcate_id+"&tag="+tag,
		beforeSend:function(){$("#loading").show();},
		success:function(result){
			$("#loading").hide()
			if(result == '1'){
				window.location.reload(true); 
			}
		}
	})
		};
		
function del_subcate(subcate_id){
		
		if(confirm('您确定要删除此标签组吗？')){

		$.ajax({
				type:"POST",
				url:"index.php?app=system&ac=navtag&ts=del_subtag",
				data:"&subcate_id="+subcate_id,
				beforeSend:function(){$("#loading").show();},
				success:function(result){
					$("#loading").hide()
					if(result == '1'){
						$("#top_"+subcate_id).remove(); 
					}
				}
			})
	}
		};
function del_cate(cate_id){
		
		if(confirm('您确定要删除此分类吗？')){

		$.ajax({
				type:"POST",
				url:"index.php?app=system&ac=navtag&ts=del_cate",
				data:"&cate_id="+cate_id,
				beforeSend:function(){$("#loading").show();},
				success:function(result){
					$("#loading").hide()
					if(result == '1'){
						$("#item_"+cate_id).remove(); 
					}else{
						
						alert('该分类下尚有标签组，请先删除标签组！');
						
					}
				}
			})
	}
		};
