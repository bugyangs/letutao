<?php include template('header'); ?>
<div id="loading" style="position:absolute; right:10px; color:#ee2266; display:none;">正在加载...</div>
<script src="<?php echo SITE_URL;?>public/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL;?>app/system/js/extend.func.js" type="text/javascript"></script>
<link href="<?php echo SITE_URL;?>css/tag.css" rel="stylesheet" type="text/css" />
<div class="midder">
<?php include template('menu'); ?>
<h2 style="font-size:12px">导航设置 > <?php echo $strcate['cate_name'];?> > 标签分组 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="insertcate(<?php echo $strcate['cate_id'];?>);" style="color:#FFF; background-color:#039;padding: 2px 4px;line-height: 20px;">添加分组</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?app=system&ac=sitenav" class="btn btn_submit">返回</a>&nbsp;&nbsp;<a href="javascript:window.location.reload(true);" class="btn btn_submit">刷新</a></h2>
<div class="tag-book s1024" style="border:#999 1px dashed;">
            <span style="color:#FF0000;  line-height:24px;">提示：1.信息可以直接进行编辑！2.标签用，或空格分开</span>
				<div class="bd clearfix" id="cate">
					<?php foreach((array)$arr_cates as $key=>$item) {?>
                    <div class="item" id="item_<?php echo $item['cate_id'];?>" style="background-color:#F2F9FB; margin:0 5px 5px 5px; padding:10px;">
										<h3 style="font-size:12px;"><input onchange="setcate('<?php echo $item['cate_id'];?>',this.value);" class="input-text" style="width:50px;" value="<?php echo $item['cate_name'];?>"> &nbsp;&nbsp;&nbsp;&nbsp; <span><a href="javascript:;" onclick="insertSubcate(item_<?php echo $item['cate_id'];?>,<?php echo $item['cate_id'];?>);" title="添加标签组" style="color:#e63">添加标签组</a></span> - <span><a href="javascript:;" title="删除" onclick="del_cate(<?php echo $item['cate_id'];?>);" style="color:#e63">删除</a></span></h3>
                       <?php if(is_array($item['subcate'])) { ?>
                       <?php foreach((array)$item['subcate'] as $kkey=>$iitem) {?>
						<div class="top" id="top_<?php echo $iitem['subcate_id'];?>" style="height:70px">
							<div class="tag-img">
								<a href="<?php echo SITE_URL;?>index.php?app=system&ac=navtag&ts=subcate_ico&subcate_id=<?php echo $iitem['subcate_id'];?>&cate_id=<?php echo $strcate['cate_id'];?>" title="点击更换分类图标">
								<img src="<?php if($iitem['subcate_icon']) { ?><?php echo $iitem['subcate_icon'];?><?php } else { ?><?php echo SITE_URL;?>images/subcate_ico.png<?php } ?>" title="点击更换分类图标" alt="<?php echo $item['cate_name'];?>">
								</a>
							</div>
							<ul>
<textarea onchange="settag('<?php echo $iitem['subcate_id'];?>',this.value);" style="height:44px; width:90%; line-height:22px;overflow:hidden;">
<?php echo $iitem['tag'];?>
</textarea>																											
							</ul>
                            
							<a href="javascript:;" onclick="del_subcate(<?php echo $iitem['subcate_id'];?>);" title="删除" style="color:#e63; line-height:24px;">删除</a> 		
                          
						</div>
                        <?php }?>
                        <?php } ?>  
											</div>
                    
                	<?php }?>
                    
                                            
				</div>
			</div>
</div>
<?php include template('footer'); ?>