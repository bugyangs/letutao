<?php
	/* 
	 * 团购分类
	 */
	 switch($ts){
		case "":
	 		$tuancate = $db->fetch_all_assoc("select * from ".dbprefix."tuan_cate order by cate_id");
	 		include template("admin/cate");
		break;
		case "do":
			$arrcate_id = $_POST['cate_id'];
			$arrcate_name = $_POST['cate_name'];
			
			foreach($arrcate_name as $key=>$item){
			$cate_id = trim($arrcate_id[$key]);
			$cate_name = trim($item);
			if($cate_name){
				$iscateid = $db ->once_num_rows("select cate_id from ".dbprefix."tuan_cate where cate_id='".$cate_id."'");
				if($iscateid){
				$updatenav = $db->query("UPDATE ".dbprefix."tuan_cate SET  cate_name='".$cate_name."' where cate_id = '".$cate_id."'");
				}else{
				$insertnav = $db->query("insert into ".dbprefix."tuan_cate SET  cate_name='".$cate_name."'");
				}
					
			}else{
				
				qiMsg("团购分类名称不能为空！","<a href=\"index.php?app=tuan&ac=admin&mg=cate\">返回</a>");
				
			}
			
			
		}
			
			qiMsg("团购分类修改成功！","<a href=\"index.php?app=tuan&ac=admin&mg=cate\">返回</a>");
		break;
		
		case "del":
			$cate_id = $_GET['cate_id'];
			$isdel = $db->query("DELETE FROM ".dbprefix."tuan_cate WHERE cate_id=".$cate_id);
			qiMsg("团购分类删除成功！");
		break;
	}