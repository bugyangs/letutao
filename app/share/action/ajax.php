<?php
defined('IN_TS') or die('Access Denied.');

		$url = _post('url');
		//$url ='http://item.taobao.com/item.htm?id=14662154382';
		$return=aac('share')->get_goodinfo_by_url($url);
		if($return['status']=='2'){
			
			$json = array(
			'code'=>100,
			'userSns'=>array(
				'qzone'=>'off',
			),
			'product'=>array(
				'code'=>100,
				'id'=>$return['goods_id'],
				'imgs'=>$return['img'],
				'name'=>getsubstrutf8($return['name'],0,20),
				'pid'=>$return['goods_id'],
				'tags'=>$return['tags'],
				'url'=>SITE_URL.tsurl('baobei',$return['goods_id']),
			),
			);
			
		}elseif($return['status']=='1'){
			$tag = explode(' ',$return['defaulttags']);
			$imgs = explode(' ',$return['pic_url']);
			$json = array(
			'code'=>100,
			'userSns'=>array(
				'qzone'=>'off',
			),
			'product'=>array(
				'code'=>100,
				'id'=>'51886191df56923aef39f02a',
				'imgs'=>$imgs,
				'name'=>$return['name'],
				'pid'=>'',
				'info'=>$return['info'],
				'cate_id'=>$return['cate_id'],
				'defaulttags'=>$return['defaulttags'],
				'cate_name'=>$return['cate_name'],
				'price'=>$return['price'],
				'tags'=>$return['tags'],
				'url'=>$return['url'],
			),
			);
		}else{
			
			$json['status'] = 0;
			$json['msg'] = "加载失败，请确认网址无误";	
			
		}
		
		outputJson($json);


