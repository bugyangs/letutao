<?php include template('header'); ?>

<div id="wrap">
		<div id="container">
        <div class="ad clearfix" style="margin:10px auto; width:980px;"><!-- 分类页广告1 -->
 		<?php doAction('adcode',null,'7')?>
		</div>
        
        <?php if($catetags) { ?>

			<div class="tag-book s1024">
            
				<div class="bd clearfix">
                <?php foreach((array)$catetags as $key=>$item) {?>
										<div class="item">
										<h3><a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',array(subcate=>$item['cate_name']))?>"  title="<?php echo $item['cate_name'];?>" <?php if($subcate==$item['cate_name']) { ?>class="cur"<?php } ?>><?php echo $item['cate_name'];?></a></h3>
                                        
                                        
                           <?php if(is_array($item['subcate'])) { ?>
                       <?php foreach((array)$item['subcate'] as $kkey=>$iitem) {?>
						<div class="top">
							<div class="tag-img">
								<a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',array(subcate=>$item['cate_name']))?>" title="<?php echo $item['cate_name'];?>">
								<img src="<?php if($iitem['subcate_icon']) { ?><?php echo SITE_URL;?><?php echo $iitem['subcate_icon'];?><?php } else { ?><?php echo SITE_URL;?>images/subcate_ico.png<?php } ?>" title="<?php echo $item['cate_name'];?>" alt="<?php echo $item['cate_name'];?>"/>
								</a>
							</div>
							<ul>
                             <?php if(is_array($iitem['arr_tag'])) { ?>
                            <?php foreach((array)$iitem['arr_tag'] as $kkkey=>$iiitem) {?>
                            <li><a class="<?php if($tag == $iiitem) { ?>cur<?php } ?>" href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('tag',$iiitem))?>"><?php echo $iiitem;?></a></li>
							<?php }?>
							 <?php } ?> 																	</ul>
						</div>
  <?php }?>
                        <?php } ?> 







											</div>
									<?php }?>
									</div>
			</div>
        <?php } ?>    
			<div class="goods-title clearfix" id="J_GoodsTitle">
													<h2><?php if($tag) { ?><?php echo $tag;?><?php } else { ?>全部<?php } ?></h2>
								<div class="sort">
                    <a <?php if($sort=='count_like') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','count_like'))?>">受欢迎</a>	
<a <?php if($sort=='count_worth') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','count_worth'))?>">值得买</a>
<a <?php if($sort=='count_view') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','count_view'))?>">热门</a>
<a <?php if($sort=='count_comment') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','count_comment'))?>">热评</a>

				</div>
                                <div class="range-box">
                         <a <?php if($sort=='0~100') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','0~100'))?>">0-100元</a>|
<a <?php if($sort=='100~200') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','100~200'))?>">100-200元</a>|
<a <?php if($sort=='200~500') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','200~500'))?>">200-500元</a>|

<a <?php if($sort=='500~9999999') { ?>class="on"<?php } ?> href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('sort','500~9999999'))?>">500元以上</a>
                </div>
                 <div style="float:right;">			
                      <ul class="pin-board-switcher clearfix">
         <li class="first selected"><a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('style','pin'))?>">瀑布流</a></li>
         <li class="last"><a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('style','boards'))?>">画板</a></li>
    </ul>	
    </div>							
			</div>
			
            
            <div class="goods-wall" id="J_GoodsWall">
			<div class="goods-block" style="opacity: 1; ">
			<?php if($Good && $page==1) { ?>
<?php foreach((array)$Good as $key=>$item) {?>
<div class="goods">		
		<div class="goods-pic" style="height:<?php if($item['imgheigt']) { ?><?php echo $item['imgheigt'];?><?php } else { ?>210<?php } ?>px;">            
			<a href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['goods_id'])?>" target="_blank">                
				<img src="<?php echo SITE_URL;?><?php echo $item['img'];?>" alt="<?php echo $item['name'];?>">
			</a>
			<?php if($item['uid'] == $TS_USER['user'][userid] || $TS_USER['user'][userid] == 1) { ?>
			<a class="ilike-del" href="javascript:void(0);" data-type="4" data-proid="<?php echo $item['goods_id'];?>" data-le="del_good" style="display: none; ">喜欢(<em class="like-count"><?php echo $item['count_like'];?>)</em></a>
            <a class="ilike-topic" href="javascript:void(0);" data-proid="<?php echo $item['goods_id'];?>" style="display: none; ">加入主题</a>
			<?php } else { ?>
			<a class="ilikeCount ilike-m" href="javascript:void(0);" data-type="0" data-proid="<?php echo $item['goods_id'];?>" style="display: none; ">喜欢(<em class="like-count"><?php echo $item['count_like'];?></em>)</a>
            <a class="ilike-topic" href="javascript:void(0);" data-proid="<?php echo $item['goods_id'];?>" style="display: none; ">加入主题</a>
			<?php } ?>
			
								</div>      
         <div class="comments-top">
         <span class="like-num"><em class="like-count"><?php echo $item['count_like'];?>  </em></span>
         <span class="like-comments"><em class="like-count"><?php echo $item['count_comment'];?></em></span>     
<?php if($item['price']> 0) { ?>
         <span class="like-price <?php if(intval($item['coupon_price'])>0 && time()<$item['coupon_end_time']) { ?>pin-price-discount<?php } ?>">￥<?php echo $item['price'];?></span>
         <?php } ?>
                        </div>
		                     
		<ul class="comments">  
		       <li>
		       		<?php echo $item['name'];?>
		       </li>
		</ul>
        
      <?php if($item['OneComment']&&$item['OneComment'][content]) { ?>
        <div class="user">   
            <a class="a-img" <?php if($item['OneComment'][userid] != 0) { ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['OneComment'][userid]))?>" title="<?php echo $item['OneComment'][user][username];?>" target="_blank" <?php } ?>>
                                
<img src="<?php echo $item['OneComment'][user][face_32];?>" width="30px" height="30px" alt="<?php echo $item['OneComment'][user][username];?>">

                                                                </a>
                                <a class="ofh" <?php if($item['OneComment'][userid] != 0) { ?> href="<?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['OneComment'][userid]))?>" title="<?php echo $item['OneComment'][user][username];?>" target="_blank" <?php } ?>><?php echo $item['OneComment'][user][username];?>：</a> 
                                                                                                                    <div class="bewrite ofh"><?php echo $item['OneComment'][content];?></div>
                                                    </div>
                                                    
            <?php } ?>
	</div>
<?php }?>
<?php } ?>
	
	</div>
			</div>
            
            
            
			<!--goods-wall end-->
						<div class="goods-loading">&nbsp;</div>
			
			<div class="page-box" style="margin-bottom:20px;">
				<div class="pagin inlineblock clearfix" id="J_Pagination">
					<span>1</span>
				</div>
			</div>
			 						
						<!-- 标签begin -->
			        <?php if($catetags) { ?>

			<div class="tag-book s1024">
            
				<div class="bd clearfix">
                <?php foreach((array)$catetags as $key=>$item) {?>
										<div class="item">
										<h3><a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',array(subcate=>$item['cate_name']))?>"  title="<?php echo $item['cate_name'];?>" <?php if($subcate==$item['cate_name']) { ?>class="cur"<?php } ?>><?php echo $item['cate_name'];?></a></h3>
                                        
                                        
                           <?php if(is_array($item['subcate'])) { ?>
                       <?php foreach((array)$item['subcate'] as $kkey=>$iitem) {?>
						<div class="top">
							<div class="tag-img">
								<a href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',array(subcate=>$item['cate_name']))?>" title="<?php echo $item['cate_name'];?>">
								<img src="<?php if($iitem['subcate_icon']) { ?><?php echo SITE_URL;?><?php echo $iitem['subcate_icon'];?><?php } else { ?><?php echo SITE_URL;?>images/subcate_ico.png<?php } ?>" title="<?php echo $item['cate_name'];?>" alt="<?php echo $item['cate_name'];?>"/>
								</a>
							</div>
							<ul>
                             <?php if(is_array($iitem['arr_tag'])) { ?>
                            <?php foreach((array)$iitem['arr_tag'] as $kkkey=>$iiitem) {?>
                            <li><a class="<?php if($tag == $iiitem) { ?>cur<?php } ?>" href="<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array('tag',$iiitem))?>"><?php echo $iiitem;?></a></li>
							<?php }?>
							 <?php } ?> 																	</ul>
						</div>
  <?php }?>
                        <?php } ?> 







											</div>
									<?php }?>
									</div>
			</div>
        <?php } ?>    
			<!-- 标签end -->
			
		</div><!--container end-->
	</div>
<?php include pubTemplate("JsConstant");?>

<script src="<?php echo SITE_URL;?>js/jquery-1.6.4.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.tools.min.js"></script>
<script type="text/javascript" src='<?php echo SITE_URL;?>js/guang.min.js?t=20120106230000.js'></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/common.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/comment.min.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/jquery.pagination.js"></script>
<script type="text/javascript" src='<?php echo SITE_URL;?>js/goods_flow_ajax.min.js?t=20120106230000.js'></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/like_say.min.js?t=20120106230000"></script>

<script type="text/javascript" src="<?php echo SITE_URL;?>js/ajaxfileupload.min.js"></script>

<script type="text/javascript">
var goodsPage = {
	sumGoodsNum : <?php echo $sumGoodsNum;?>,
	curPageNum : <?php echo $page;?>,
	urlType : '<?php echo $TS_SITE['base'][site_urltype];?>',
	pageUrl : "<?php echo SITE_URL;?><?php echo tsurl($cate_appname,'',url_array())?>",
	sort : "<?php echo $sort;?>",
	tag : "<?php echo $tag;?>",
	cateId : "<?php echo $cateid;?>",
	kw : "<?php echo $kw;?>"
}
if(goodsPage.sumGoodsNum > 0){
	jQuery(function() {
		jQuery.guang.goods.conf.ajaxData.bpage = "<?php echo $page;?>";
		jQuery.guang.goods.conf.ajaxData.cateId = "<?php echo $cateid;?>";
		jQuery.guang.goods.conf.ajaxData.tag = "<?php echo $tag;?>";
		jQuery.guang.goods.conf.ajaxData.sort = "<?php echo $sort;?>";
		jQuery.guang.goods.conf.ajaxData.kw = "<?php echo $kw;?>";
		jQuery.guang.goods.conf.ajaxData.subcate = "<?php echo $subcate;?>";
		jQuery.guang.goods.init();	
	});	
}
</script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/Pagination.js"></script>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/goods.min.js"></script>
<?php include template('footer'); ?>