<?php
	/* 
	 * 添加团购
	 */
	 switch($ts){
		case "":
	 		$tuancate = $db->fetch_all_assoc("select * from ".dbprefix."tuan_cate order by cate_id");
	 		include template("admin/addtuan");
		break;
		case "do":
			$cateid = $_POST['cateid'];
			$title = $_POST['title'];
			$price_market = $_POST['price_market'];
			$price_tuan = $_POST['price_tuan'];
			$count_sold = $_POST['count_sold'];
			$tuan_url = $_POST['tuan_url'];
			$istop = $_POST['istop'];
			$isshow = $_POST['isshow'];
			require_once  THINKROOT.'/letutao/class.uploadfile.php';
			$upload_file =  new t_upload_file('picfile');
			if($upload_file->upload('tuanfile')){
				
				$images = str_replace(DS, '/', $upload_file->path . '/' . $upload_file->filename);
				
			}else{
				
				qiMsg("文件上传失败！","<a href=\"index.php?app=tuan&ac=admin&mg=cate\">返回</a>");
				
			}
			
			$inserttuan = $db->query("insert into ".dbprefix."tuan SET  cateid='".$cateid."',title='".$title."',images='".$images."',price_market='".$price_market."',price_tuan='".$price_tuan."',count_sold='".$count_sold."',tuan_url='".$tuan_url."',istop='".$istop."',isshow='".$isshow."',addtime='".time()."'");

			
			qiMsg("团购添加成功！","<a href=\"index.php?app=tuan&ac=admin&mg=goods&ts=list\">返回</a>");
		break;
	}