<?php 
defined('IN_TS') or die('Access Denied.');

switch($ts){
	case "":
		
		$title = '优化商品';
		include template("optimizegoods");
		break;

		case "delrepeat":
		
		$getgoodid = isset($_GET['goodid'])?$_GET['goodid']:1;
		
		$nid = $db->once_fetch_assoc("select goods_id from ".dbprefix."share_goods where goods_id > $getgoodid order by goods_id asc limit 0,1");
		
		$nextgoodid =	$nid['goods_id'];
		
		$arrGoods = $db->once_fetch_assoc("select goods_id,themeid,name,url from ".dbprefix."share_goods where goods_id ='$getgoodid'");

			$issit = $db->once_num_rows("select * from ".dbprefix."share_goods where url='".$arrGoods['url']."'");
				if($issit>1){
					
					$db->query("DELETE FROM ".dbprefix."share_goods WHERE goods_id = '".$arrGoods['goods_id']."'");
					
					//删除评论回复
					$db->query("DELETE FROM ".dbprefix."share_goods_comments WHERE shareid = '".$arrGoods['goods_id']."'");
					
					//删除喜欢
					$db->query("DELETE FROM ".dbprefix."share_goods_like WHERE goods_id = '".$arrGoods['goods_id']."'");
					
					//删除tag索引
					//$db->query("DELETE FROM ".dbprefix."tag_topic_index WHERE topicid = '".$topicid."'");
					
					//统计 
					if($arrGoods['themeid']){
					$db->query("update ".dbprefix."theme set `goodsnum`=goodsnum-1 where themeid='".$arrGoods['themeid']."'");
					}
					$sissiit = $issit-1;
					show_msg("成功清理".$sissiit."个重复商品！","index.php?app=system&ac=optimizegoods&ts=delrepeat&goodid=".$nextgoodid);
				}elseif($nextgoodid){
					$strname =substr($arrGoods['name'],0,0).'...';
				show_msg("商品ID:".$getgoodid.$strname."不重复，跳过！","index.php?app=system&ac=optimizegoods&ts=delrepeat&goodid=".$nextgoodid);
				}else{
					
					qiMsg("优化重复商品操作完成！","<a href=\"index.php?app=share&ac=admin&mg=optimizegoods\">返回</a>");
				}
				
		
		break;
		
		
}

function show_msg($message, $url_forward='') {

	if($url_forward) {
		$message = "<a href=\"$url_forward\">$message (跳转中...)</a><script>setTimeout(\"window.location.href ='$url_forward';\",10);</script>";
	}
		print<<<END
	<html>
<head>
<title>乐兔淘提示信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base target='_self'/>
</head>
<body leftmargin='0' topmargin='20px'>
<center>
<div style='border:4px #dff6ff solid;width:500px;height:149px;'>
<div style='border:1px solid #a6cbe7;'>
<div style='padding:7px 0;height:30;font-size:10pt; margin:1px; background:#e0f0f9; border-bottom:1px solid #a6cbe7;'>提示信息</div>
<div style='font-size:10pt;background-color:#ffffff;height:100px;'><br/><br/>$message<br /></div>
</div>
</div>
</div>
</center>
</body>
</html>
END;
	exit();
}