<?php foreach((array)$arrMessage as $key=>$item) {?>

<dl>
                                                                                
								<dt></dt>
							<dd>
                            <?php echo $item['user'][username];?> <?php if($item['isread']='0') { ?><span style="padding-left:0px; padding-right:10px; color:#F00">new</span> <?php } ?><?php echo $item['content'];?> 
                            
                            <span><?php echo date('H:i:s',$item['addtime'])?></span></dd>
						</dl>


<?php }?>



