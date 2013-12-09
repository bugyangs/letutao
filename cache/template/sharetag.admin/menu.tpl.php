<h2>标签管理</h2>
<div class="tabnav">
<ul>
<li <?php if($mg=='goods_tags') { ?>class="select"<?php } ?>><a href="index.php?app=sharetag&ac=admin&mg=goods_tags&ts=list">全部标签(共<?php echo $AlltagNum;?>个)</a></li>
<li <?php if($mg=='add_tag') { ?>class="select"<?php } ?>><a href="index.php?app=sharetag&ac=admin&mg=add_tag">添加标签</a></li>
<li <?php if($mg=='TestGetCate') { ?>class="select"<?php } ?>><a href="index.php?app=sharetag&ac=admin&mg=TestGetCate">自动分类调试</a></li>
</ul>
</div>