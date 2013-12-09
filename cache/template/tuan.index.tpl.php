<?php include template('header'); ?>
  		<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/tuan/tuan_v5.css"/>
     
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/tuan/paginator.css"/>
        
        <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>css/tuan/global.min.css"/>

        <div class="content">
		<div class="group_buy box-shadow clearfix">
        <div class="cate_filter">
        	<dl class="by_type" id="ft">
            	<dt>类型：</dt>
                <dd <?php if($cateid==0) { ?>class="current"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan">全部</a></dd>
                <?php foreach((array)$tuancate as $key=>$item) {?>
                <dd <?php if($cateid==$item['cate_id']) { ?>class="current"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan&cateid=<?php echo $item['cate_id'];?>"><?php echo $item['cate_name'];?></a></dd>
                <?php }?>
                
            </dl>
            <dl class="by_price" id="fp">
            </dl>
        </div>
        
        <div class="tab_sort">
			<ul id="st">
				<li <?php if($sort=='default') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan<?php if($cateid) { ?>&cateid=<?php echo $cateid;?><?php } ?>" class="default">默认</a></li>
				<li <?php if($sort=='price') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan<?php if($cateid) { ?>&cateid=<?php echo $cateid;?><?php } ?>&sort=price" class="up">价格<span class="arrow"></span></a></li>
				<li <?php if($sort=='zk') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan<?php if($cateid) { ?>&cateid=<?php echo $cateid;?><?php } ?>&sort=zk" class="up">折扣<span class="arrow"></span></a></li>
				<li <?php if($sort=='sold') { ?>class="select"<?php } ?>><a href="<?php echo SITE_URL;?>index.php?app=tuan<?php if($cateid) { ?>&cateid=<?php echo $cateid;?><?php } ?>&sort=sold">销量<span class="arrow"></span></a></li>
			</ul>
		</div>
		<div class="page_sbar">
        <div class="paginator">
        <?php echo $pageUrl;?>
        </div></div>
		<!--S 多个团购商品列表 -->
<div class="item_list_wrap">	
    <ul class="item_list group">    
    <?php foreach((array)$Arr_tuan as $key=>$item) {?>
    
    <li class="">
    <h2><a target="_blank" href="<?php echo $item['tuan_url'];?>" title="<?php echo $item['title'];?>"><?php echo $item['title'];?></a></h2> 
    
    <div class="inner"> <a href="<?php echo $item['tuan_url'];?>" target="_blank"><img src="<?php echo SITE_URL;?><?php echo $item['images'];?>" height="292" title="" alt=""></a>  
    <div class="mask_bg"></div>                            
    <div class="details"> <a target="_blank" href="<?php echo $item['tuan_url'];?>"> <span class="price">市场价：¥<?php echo $item['price_market'];?></span><span class="discount">折扣：<?php echo $item['zk'];?>折</span><span class="count"><b class="clr_red"><?php echo $item['count_sold'];?>人</b>已购买</span> </a> </div>                     </div>                        <div class="btns_wrap">      <div class="buy_now"> <span class="price_new">¥<em><?php echo $item['price_tuan'];?></em></span> 
    
 <div class="btn_wrap"><a class="btn btn_now" href="<?php echo $item['tuan_url'];?>" target="_blank" title="<?php echo $item['title'];?>">我要团</a></div>                              </div>                       </div>                  </li>
    
    <?php }?>
    
    
    
    
       </ul>
</div>

		<div class="page_sbar" style="margin-bottom:10px;">
        <div class="paginator">
        <?php echo $pageUrl;?>
        </div></div>
		
	</div>
        	<div class="clear_f"> </div>
        </div>
      
<?php include pubTemplate("JsConstant");?>
<script type="text/javascript" src="<?php echo SITE_URL;?>js/do.min.js"></script>
<script>
(function(){
var b="?t="+GUANGER.staticVersion,a=function(a){return"<?php echo SITE_URL;?>js/"+a+b};Do.add("guang",{path:a("guang.min.js"),type:"js",requires:["tools","cookie"]});Do.add("tools",{path:a("jquery.tools.min.js"),type:"js"});Do.add("cookie",{path:a("jquery.cookie.min.js"),type:"js"});Do.add("share_guang",{path:a("share_guang.min.js"),type:"js",requires:["guang"]});Do.add("search_suggest",{path:a("search_suggest.min.js"),type:"js",requires:["guang"]});Do.add("localstorage",{path:a("localstorage.min.js"),type:"js"});Do.add("track_info",{path:a("track_info.min.js"),type:"js"});
    Do.add("guang_comment",{path:a("comment.min.js"),type:"js"});Do.add("add_topic_say",{path:a("add_topic_say.min.js"),type:"js"});Do.add("like_say",{path:a("like_say.min.js"),type:"js"});Do.add("common",{path:a("common.min.js"),type:"js",requires:["share_guang","search_suggest","localstorage"]});Do.global("guang");Do("common");Do("track_info");
})();
Do('ajaxfileupload');
</script>


<?php include template('footer'); ?>