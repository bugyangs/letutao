<h2>商品管理</h2>
<div class="tabnav">
<ul>

<li <?php if($mg=='goods' && $ts=='list') { ?>class="select"<?php } ?>><a href="index.php?app=share&ac=admin&mg=goods&ts=list">商品管理</a></li>

<?php if($mg=='goods' && $ts=='view') { ?><li class="select"><a href="index.php?app=user&ac=admin&mg=user&ts=list"><?php echo $strUser['username'];?>商品信息</a></li>

<?php } ?>

<li <?php if($mg=='piliang') { ?>class="select"<?php } ?>><a href="index.php?app=share&ac=admin&mg=piliang&ts=list">批量添加</a></li>


<li <?php if($mg=='optimizegoods') { ?>class="select"<?php } ?>><a href="index.php?app=share&ac=admin&mg=optimizegoods">优化商品</a></li>

<li <?php if($mg=='spider') { ?>class="select"<?php } ?>><a href="index.php?app=share&ac=admin&mg=spider">采集商品</a></li>


<li><a href="index.php?app=tuan&ac=admin&mg=goods&ts=list">团购管理</a></li>


</ul>
</div>