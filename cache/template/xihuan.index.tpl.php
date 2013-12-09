<div class="goods-block" style="opacity: 1; ">
<?php if($Good) { ?>
<?php foreach((array)$Good as $key=>$item) {?>
<div class="goods">		
		<div class="goods-pic" style="height: <?php echo $item['img_h'];?>px;">            
			<a href="<?php echo SITE_URL;?><?php echo tsurl('baobei',$item['goods_id'])?>" target="_blank">                
				<img src="<?php if($DISK_YUN['isopen']) { ?><?php echo BCS_URL;?><?php echo $item['img'];?><?php } else { ?><?php echo SITE_URL;?><?php echo $item['img'];?><?php } ?>">
			</a>
			<?php if($item['uid'] == $TS_USER['user'][userid] || $TS_USER['user'][userid] == 1) { ?>
			<a class="ilike-del" href="javascript:void(0);" data-type="4" data-proid="<?php echo $item['goods_id'];?>" data-le="del_good" style="display: none; ">喜欢(<em class="like-count"><?php echo $item['count_like'];?></em>)</a>
            <a class="ilike-topic" href="javascript:void(0);" data-proid="<?php echo $item['goods_id'];?>" style="display: none; ">加入主题</a>
			<?php } else { ?>
			<a class="ilike-m" href="javascript:void(0);" data-type="0" data-proid="<?php echo $item['goods_id'];?>" style="display: none; ">喜欢(<em class="like-count"><?php echo $item['count_like'];?></em>)</a>
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
            <a class="a-img" href="<?php if($item['OneComment'][userid] == 0) { ?>javascript:'';<?php } else { ?><?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['OneComment'][userid]))?><?php } ?>" title="<?php echo $item['OneComment'][user][username];?>" target="_blank">
                                
<img src="<?php echo $item['OneComment'][user][face_32];?>" width="30px" height="30px" alt="<?php echo $item['OneComment'][user][username];?>">

                                                                </a>
                                <a class="ofh" href="<?php if($item['OneComment'][userid] == 0) { ?>javascript:'';<?php } else { ?><?php echo SITE_URL;?><?php echo tsurl('user','space',array(userid=>$item['OneComment'][userid]))?><?php } ?>" title="<?php echo $item['OneComment'][user][username];?>" target="_blank"><?php echo $item['OneComment'][user][username];?>：</a> 
                                                                                                                    <div class="bewrite ofh"><?php echo $item['OneComment'][content];?></div>
                                                    </div>
                                                    
            <?php } ?>
	</div>
<?php }?>
<?php } ?>
</div>
 <div class="goods-hidden">
<input type="hidden" class="J_HiddenSpage" value="<?php echo $spage;?>"/>   
<input type="hidden" class="J_HiddenBpage" value="<?php echo $bpage;?>"/>
<input type="hidden" class="J_HiddenIsEnd" value="<?php echo $goodsh;?>"/>
</div>