<?php
defined('IN_TS') or die('Access Denied.');

class share{

	var $db;
	private $share_module;
	private $url;

	//通过URL构造获取相应的采集解析模型 狗扑站长狗扑源码社区子 bbs.gope.cn
	public function __construct($url)
	{

		$rs = preg_match("/^(http:\/\/|https:\/\/)/",$urlt,$match);
		if(intval($rs)==0)
		{
			$urlt = "http://".$urlt;
		}
		$rs= parse_url($urlt);

		$scheme = isset($rs['scheme'])?$rs['scheme']."://":"http://";
		$host = isset($rs['host'])?$rs['host']:"none";
        $host = explode('.',$host);
        $host = array_slice($host,-2,2);
        $domain = implode('.',$host);
		$class = 'taobao';

		$file = THINKROOT."/letutao/class.share.php";
		if(file_exists($file))
		{
			require_once $file;
			$class_name = $class."_sharegoods";
			if(class_exists($class_name))
			{
				$this->share_module = new $class_name;
			}
		}
		$this->url = $url;
	}

	/**
	 * 返回结果为false时采集失败
	 */
	public function fetch()
	{
		if($this->share_module)
		{
			return $this->share_module->fetch($this->url);
		}
		else
			return false;
	}
	
	
	/**
	 * 发布商品
	 */
	public function add_good($post,$userid=1,$publish=false)
	{
			global $db,$DISK_YUN;
			$arrimg = explode(',',$post['imgs']);//多图
			if(empty($arrimg)&&!$publish)
			{
							$json['status'] = 0;
							$json['msg'] = "至少要选择一张图片吧...";
							outputJson($json);
			}

			$info = trim($post['info']);
			$arrresult  = mb_unserialize(base64_decode($info));
			$shop_info =  $arrresult['shop'];
			if(is_array($arrimg)){
				
				foreach($arrimg as $key=>$item){
				$item = str_replace('_40x40.jpg','',$item);
				$item = str_replace('_100x100.jpg','',$item);
				$item = str_replace('_60x60.jpg','',$item);
				$strimg.= $item.'|';
			}};
			$post['tags']= str_replace(',',' ',$post['tags']);
			$post['tags'] = is_array($post['tags'])?implode(' ',$post['tags']) : $post['tags'];
			$pic_url     = $arrresult['item']['pic_url'];
			$name	     = t(trim($post['title']));
			$content	 = t(trim($post['content']));
			$tags        = trim($post['tags']);
			$defaulttags =  trim($post['defaulttags']);
			$cate_id     = intval(trim($post['cate_id']));
			$themeid     = intval(trim($post['themeid']));
			$comment     = t(trim($post['comment']));
			$catename    = t(trim($post['catename']));
			$islike      = trim($post['favor']);

			$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$catename."'");
			$cate_id = $cateData['cate_id'];
			
			
			if(empty($tags))
			{
							$json['status'] = 0;
							$json['msg'] = "至少要选择一个标签吧...";
							outputJson($json);
			}
			
			if($catename == '发现喜欢（未找到合适分类）' || empty($cate_id))
			{
							$cate_id = 1;
			}
	
			$uptime = time();
			$fold = date('Ymd',$uptime);
			
			$random = random(14);
			$dir = "cache/thumb/index/".$fold;
			!is_dir($dir)?mkdir($dir,0777):'';
			$imgurl="cache/thumb/index/".$fold."/".$random."w210.jpg";
			$pic_url = str_replace('_100x100.jpg','',$pic_url);
			require_once 'letutao/class.image.php';
			$resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
			if(!is_file($imgurl)) $resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
			
			if(!is_file($imgurl)&&$publish) return 'Cantresizeimage';
			$img_info = getimagesize($imgurl);	
			$img_h= $img_info[1];
			if($DISK_YUN['isopen']){
				if(!aac('system')->DiskYun_baidu_upload($imgurl)){
					echo '<script>alert("文件上传到云空间失败，请检查云存储配置,暂用本地图片！")</script>';
				}
			}
			$img = $imgurl;
			if($arrresult['item']['coupon_price']){
				$arrData = array(
					'uid'				 => intval($userid),
					'img'				 => $img,
					'img_h'				 => $img_h,
					'oldimg'			 => $strimg?$strimg:$arrresult['item']['pic_url'],
					'name'	             => $name,
					'price'				 => intval($arrresult['item']['price']),
					'taoke_url'		     => $arrresult['item']['taoke_url'],
					'url'		         =>  str_replace('&spm=2014.12369186.0.0','',$arrresult['item']['url']),
					'seller_credit_score'=> $arrresult['item']['seller_credit_score']?$arrresult['item']['seller_credit_score']:0,
					'shop_info'		     => serialize($shop_info),
					//折扣价
			
						'coupon_price'		 => $arrresult['item']['coupon_price'],
					'coupon_start_time'	 => $arrresult['item']['coupon_start_time'],
					'coupon_end_time'	 => $arrresult['item']['coupon_end_time'],
			
					
					
					'cate_id'		     => intval($cate_id),
					'comment'		     => $comment,
					'uptime'		     => time(),
				);
				
			}else{
				$arrData = array(
					'uid'				 => intval($userid),
					'img'				 => $img,
					'img_h'				 => $img_h,
					'oldimg'			 => $strimg?$strimg:$arrresult['item']['pic_url'],
					'name'	             => $name,
					'price'				 => intval($arrresult['item']['price']),
					'taoke_url'		     => $arrresult['item']['taoke_url'],
					'url'		         =>  str_replace('&spm=2014.12369186.0.0','',$arrresult['item']['url']),
					'seller_credit_score'=> $arrresult['item']['seller_credit_score']?$arrresult['item']['seller_credit_score']:0,
					'shop_info'		     => serialize($shop_info),
					//折扣价
					'cate_id'		     => intval($cate_id),
					'comment'		     => $comment,
					'uptime'		     => time(),
				);
				
			}
				
		//限制发布时间 2秒内
		$limitgood = $db->once_fetch_assoc("select uptime from ".dbprefix."share_goods where uid='".$userid."' order by uptime desc");
		if(!$publish){
			if($uptime-$limitgood['uptime']>2) $goodsid = $db->insertArr($arrData,dbprefix.'share_goods');
		}else{
			$goodsid = $db->insertArr($arrData,dbprefix.'share_goods');
		}
		
		//添加到主题
		if($themeid){
			
			$tData = $db->once_fetch_assoc("select strgoodid,simg from ".dbprefix."theme where themeid='".$themeid."'");
	
			$strid = $tData['strgoodid']?$tData['strgoodid'].','.$goodsid:$goodsid;
			
			if(!$tData['simg']){
	
				$simgurl = aac('zhuti')->themesimg($goodsid);
				$db->query("update ".dbprefix."theme set `simg`='$simgurl',uptime='$uptime' where themeid='".$themeid."'");
				
			}
	
			$arr = explode(',',$tData['strgoodid']);
			if(!in_array($goodsid,$arr)){
			$db->query("update ".dbprefix."theme set `strgoodid`='$strid' where themeid='$themeid'");
			}
	
		}
	
	
		aac('sharetag')->addTag('share','goods_id',$goodsid,$tags);
		
		aac('sharetag')->addTag('default','goods_id',$goodsid,$defaulttags);
		
		if($themeid>0){
			$db->query("update ".dbprefix."theme set `goodsnum`=goodsnum+1,uptime=".time()." where themeid='$themeid'");
		}
		
				//更新积分
		$db->query("update ".dbprefix."user_info set `count_score`=count_score+2 where userid='$userid'");
		
		
		//feed开始
		//限制发布时间 2秒内
		$uptime = time();
		$limitfeed = $db->once_fetch_assoc("select addtime from ".dbprefix."feed where userid='".$userid."' order by addtime desc");
		if($uptime-$limitfeed['addtime']>2){;
		$feed_template = '<a href="{link}" title="{title}"><img src="{img}" width="120" alt="{title}" title="{title}"></a></div><div class="pro-info"><h3 class="ofh"><a href="{link}" target="_blank">{title}</a></h3><p class="pro-intro">{content}</p><div class="friend-comment-list">';
	
		$feed_data = array(
			'link'	=>  tsurl('baobei',$goodsid),
			'title'	=> $name,
			'ctyle' => '分享了宝贝',
			'goods_id' => $goodsid,
			'img'	=> $img,
			'content'	=> getsubstrutf8(t($comment),'0','50'),
		);
		aac('feed')->addFeed($userid,$feed_template,serialize($feed_data),'goods',$goodsid);
		}
		//feed结束
		
		//更新喜欢
		if($islike){
			$db->query("insert into ".dbprefix."share_goods_like (`userid`,`goods_id`,`commentType`,`addtime`) values ('".$userid."','".$goodsid."','0','".time()."')");
			$db->query("update ".dbprefix."share_goods set count_like='$islike' where goods_id='$goodsid'");
			
			}
	
	
		$this->url = $arrresult['item']['url'];
		$this->GetAndIntoComment($goodsid,$arrresult['item']['url']);
		
		return $goodsid;
	}
	
	
	/**
	 * 发布采集商品
	 */
	public function add_publish_good($post,$userid=1,$publish=false)
	{
			global $db,$DISK_YUN;
			$arrimg = $post['img'];//多图
			$info = trim($post['info']);
			$arrresult  = mb_unserialize(base64_decode($info));
			$shop_info =  $arrresult['shop'];
				//折扣价
			$coupon_price		 =  $arrresult['coupon_price'];
			$coupon_start_time	 =  $arrresult['coupon_start_time'];
			$coupon_end_time	 =  $arrresult['coupon_end_time'];
			if(is_array($arrimg)){
				
				foreach($arrimg as $key=>$item){
				$item = str_replace('_40x40.jpg','',$item);
				$item = str_replace('_100x100.jpg','',$item);
				$strimg.= $item.'|';
			}};
			
			$post['tags'] = is_array($post['tags'])?implode(' ',$post['tags']) : $post['tags'];
			$pic_url     = $arrresult['item']['pic_url'];
			$name	     = t(trim($post['name']));
			$content	 = t(trim($post['content']));
			$tags        =  trim($post['tags']);
			$defaulttags =  trim($post['defaulttags']);
			$cate_id     = intval(trim($post['cate_id']));
			$themeid     = intval(trim($post['themeid']));
			$comment     = t(trim($post['comment']));
			$catename    = t(trim($post['catename']));
			$islike      = trim($post['tomyfav']);
			
			$cateData = $db->once_fetch_assoc("select cate_id from ".dbprefix."goods_cate where cate_name like '".$catename."'");
			$cate_id = $cateData['cate_id'];
			if($catename == '发现喜欢（未找到合适分类）' || empty($cate_id)) $cate_id = 1;
	
			$uptime = time();
			$fold = date('Ymd',$uptime);
			
			$random = random(14);
			$dir = "cache/thumb/index/".$fold;
			!is_dir($dir)?mkdir($dir,0777):'';
			$imgurl="cache/thumb/index/".$fold."/".$random."w210.jpg";
			$pic_url = str_replace('_100x100.jpg','',$pic_url);
			
			require_once 'letutao/class.image.php';
			$resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
		
			if(!is_file($imgurl)) $resizeimage = new tsImg("$pic_url", "210", "", "0", "$imgurl" );
			
			if(!is_file($imgurl)&&$publish) return 'Cantresizeimage';
			$img_info = getimagesize($imgurl);	
			$img_h= $img_info[1];
			if($DISK_YUN['isopen']){
				if(!aac('system')->DiskYun_baidu_upload($imgurl)){
					echo '<script>alert("文件上传到云空间失败，请检查云存储配置,暂用本地图片！")</script>';
				}
			}
			$img = $imgurl;
				$arrData = array(
					'uid'				 => intval($userid),
					'img'				 => $img,
					'img_h'				 => $img_h,
					'oldimg'			 => $strimg?$strimg:$arrresult['item']['pic_url'],
					'name'	             => $name,
					'price'				 => intval($arrresult['item']['price']),
					'taoke_url'		     => $arrresult['item']['taoke_url'],
					'url'		         =>  str_replace('&spm=2014.12369186.0.0','',$arrresult['item']['url']),
					'seller_credit_score'=> $arrresult['item']['seller_credit_score']?$arrresult['item']['seller_credit_score']:0,
					'shop_info'		     => serialize($shop_info),
					//折扣价
					'coupon_price'		 => $coupon_price,
					'coupon_start_time'	 => $coupon_start_time,
					'coupon_end_time'	 => $coupon_end_time,
					'cate_id'		     => intval($cate_id),
					'comment'		     => $comment,
					'uptime'		     => time(),
				);
			
	
			$goodsid = $db->insertArr($arrData,dbprefix.'share_goods');

		aac('sharetag')->addTag('share','goods_id',$goodsid,$tags);
		
		aac('sharetag')->addTag('default','goods_id',$goodsid,$defaulttags);
		$this->url = $arrresult['item']['url'];
		$this->GetAndIntoComment($goodsid,$arrresult['item']['url']);
		return $goodsid;
	}
	
	
	
	/**
	 * 发布采集的商品
	 */
	public function publish_good($val, $catename, $userid=1)
	{
		
		global $db;

		$item['url']=$this->url='http://item.taobao.com/item.htm?id='.$val['num_iid'];
		$sNum = $db->once_fetch_assoc("select goods_id from ".dbprefix."share_goods where url ='".$item['url']."'");
		if(is_array($sNum)){
			
			return 'isExists';
			
		}
		$post['name']=$val['title'];
		$tagsarr = $this -> newWords() -> segment($val['title'],10);
		$arrtags = $this -> newWords() -> segment($val['title'],100);
		$post['tags']=$tagsarr;
		$post['defaulttags']=$arrtags;
		$post['cate_id']='';
		$post['themeid']='';
		$post['comment']=$val['title'];
		if($catename==0){
			
			$post['cate_id']=$this->getCateByTags($arrtags);
			$cateData = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id='".$post['cate_id']."'");
			$post['catename']=$cateData['cate_name'];
			
		}else{
			$strcate = $db->once_fetch_assoc("select * from ".dbprefix."goods_cate where appname LIKE '%".$catename."%'");
			$post['catename']=$strcate['cate_name'];
		}
		$post['tomyfav']=$val['likes'];
		
			$item['key']='taobao_'.$val['num_iid'];
			$item['nick']=$val['nick'];
			$item['name']=$val['title'];
			$item['price']=$val['price'];
			$item['taoke_url']=$val['click_url'];
			$item['seller_credit_score']=$val['seller_credit_score'];
			$item['pic_url']=$val['pic_url'];
			
			$item['coupon_price']		 =  $val['coupon_price'];
			$item['coupon_start_time']	 =  $val['coupon_start_time'];
			$item['coupon_end_time']	 =  $val['coupon_end_time'];
			
			$shop['nick']=$val['nick'];
			$shop['delivery_score']=$val['delivery_score'];
			$shop['item_score']=$val['delivery_score'];
			$shop['service_score']=$val['delivery_score'];
			
		$info = array(
			'item'=>$item,
			'shop'=>$shop
			);
			
		$post['info']=base64_encode(serialize($info));
		//抓取多图
		$post['img']= $this->GetPublishMorepic();
				
		$post['name']=$val['title'];
		
		$goodsid =$this->add_publish_good($post,$userid,true);
		return $goodsid;
		
	}
	
	
	/**
	 * 通过url获取商品信息
	 */
	public function get_goodinfo_by_url($url,$get_tao_url=0)
	{
		global $db;
		$this->url=$url;
		$result=$this->fetch();
		if($get_tao_url) return $result['item']['taoke_url'];

		$name =$result['item']['name'];
		$tagsarr = $this -> newWords() -> segment($name,10);
		$arrtags = $this -> newWords() -> segment($name,100);
		foreach($tagsarr as $key=>$item){
			$tags .= '<li>'.$item.'</li>';
		}
		foreach($tagsarr as $key=>$item){
		$defaulttags .= $item.' ';
		}
		$cate_id = $this->getCateByTags($arrtags);
		$cateData = $db->once_fetch_assoc("select cate_name from ".dbprefix."goods_cate where cate_id='".$cate_id."'");
		$cate_name = $cateData['cate_name'];
		if($result)
		{
			
			$json['status'] = 1;
			$json['info'] = base64_encode(serialize($result));
			//抓取多图
			$getmorepic_c = $this->GetMorepic_c();
			$getmorepic_t = $this->GetMorepic_t();
			$getmorepic = $getmorepic_c.$getmorepic_t;
			
			$d_pic = str_replace('_100x100.jpg','',$result['item']['pic_url']);
			$result['item']['url'] = str_replace('&spm=2014.12369186.0.0','',$result['item']['url']);
			
			$json['pic_url'] = $getmorepic?$getmorepic:$d_pic;
			$json['name'] = $result['item']['name'];
			$json['tags'] = $tags;
			$json['cate_name'] = $cate_name;
			$json['defaulttags'] = $defaulttags;
			$json['cate_id'] = $cate_id;
			$json['price'] = $result['price'];
			$json['url'] = $result['url'];
			$userid = intval($TS_USER['user']['userid']);
			$Num = $db->once_num_rows("select goods_id from ".dbprefix."share_goods where url ='".$result['item']['url']."' and uid =".$userid);
			$sNum = $db->once_fetch_assoc("select goods_id,name,img from ".dbprefix."share_goods where url ='".$result['item']['url']."'");
			if(is_array($sNum)){
				
				$sNum['status']=2;
				$sNum['tags'] = $arrtags;
				$sNum['img'] = array(0=>$sNum['img']);
				return $sNum;
				exit;
			}
			return $json;
			
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 通过商品标题获取标签
	 */
	public function newWords()
	{
		require_once (THINKROOT.'/plugins/words/words_class.php');
		$Words = new WordsService();
		return $Words;
	}
	
	
	
	/**
	 * 返回淘宝分类
	 */
	public function Taobaocats($cid=0)
	{
		if($this->share_module)
		{
			return $this->share_module->_GetTaobaocats($cid);
		}
		else
			return false;
	}
	
	/**
	 * 获取商品列表
	 */
	public function _get_list($map, $p)
	{

		if($this->share_module)
		{
			return $this->share_module->_get_list($map, $p);
		}
		else
			return false;
	}

	/**
	 * 获取该商品的标识，用于检测是否已经采集
	 */
	public function getKey()
	{
		if($this->share_module)
		{
			return $this->share_module->getKey($this->url);
		}
		else
			return '';
	}

	/**
	 * 检测是否已经采集过商品
	 */
	public function getExists($goods)
	{
		$key = $this->getKey();
		if(isset($goods[$key]))
			return true;
		else
			return false;
	}
	
	/**
	 * 根据标题标签判断所属类别
	 */
	
	public function getCateByTags($tags)
	{
		global $db;
		static $tag_cates = array();

		$tags = array_unique($tags);

		foreach($tags as $tag)
		{
			if(!empty($tag))
			{
				
		$arrttg = $db->fetch_all_assoc("select tag_id,tag_name from ".dbprefix."goods_tags where tag_name = '".$tag."'");
		
		foreach($arrttg as $data)
					{
						$arrcate = $db->fetch_all_assoc("select cate_id,weight from ".dbprefix."goods_category_tags where tag_id = '".$data['tag_id']."'");
						foreach($arrcate as $cdata)
							{
								$cateid = $cdata['cate_id'];
								$cate_id[$cateid] += $cdata['weight'];
							}
					}
			}
		}

		return array_search(max($cate_id),$cate_id);
	}
	
		//获取一条用户评论
		
		public function GetOneComment($shareid){
			global $db;
			$OneComment = $db->once_fetch_assoc("select userid,content from ".dbprefix."share_goods_comments where shareid=".$shareid." order by addtime desc");
			
		$OneComment['user'] = aac('user')->getSimpleUser($OneComment['userid']);
		$OneComment['content']=t($OneComment['content']);
		if($OneComment['userid']==0) $OneComment['user']['username'] = '买过的人说';
		return $OneComment;
			
	}
	
	
		//获取C店商品多图
		
		public function GetMorepic_c(){
			
		$urlid = $this->getID($this->url);
			
		$content      =  file_get_contents('http://item.taobao.com/item.htm?id='.$urlid);
		$content = mb_convert_encoding($content,"UTF-8","gb2312");
		preg_match_all('/<div class="tb-pic tb-s40">\s+<a href="#"><img data-src=".+/', $content, $arrpic);
		$strpic = implode('img',$arrpic[0]);
		
		preg_match_all('/<img data-src=.+\/>/', $strpic, $doarrpic);
		
		foreach ($doarrpic[0] as $k=>$item)
		{
			$item = str_replace('_40x40.jpg','_100x100.jpg',$item);
			$pattern="/<img.*?data-src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,$item,$match); 
			$is_b = (count($doarrpic[0])-$k-1)>0?' ':'';
			$pichtml.=$match[1][0].$is_b;
		}
		return $pichtml;

		}
		
		
				//获取天猫商品多图
		
		public function GetMorepic_t(){
			
		$urlid = $this->getID($this->url);
			
		$content      =  file_get_contents('http://item.taobao.com/item.htm?id='.$urlid);
		$content = mb_convert_encoding($content,"UTF-8","gb2312");
		preg_match_all('/<li class="tb-pic tb-s60.+">\s+<a href="#"><img src=".+/', $content, $arrpic);
		$strpic = implode('img',$arrpic[0]);
		
		preg_match_all('/<img src=.+\/>/', $strpic, $doarrpic);
		
		foreach ($doarrpic[0] as $k=>$item)
		{
			$item = str_replace('_40x40.jpg','_100x100.jpg',$item);
			$pattern="/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/"; 
			preg_match_all($pattern,$item,$match); 
			$is_b = (count($doarrpic[0])-$k-1)>0?' ':'';
			$pichtml.=$match[1][0].$is_b;
		}
		return $pichtml;

		}
		
		//获取采集多图
		
		public function GetPublishMorepic(){
		
		$urlid = $this->getID($this->url);
		$content      =  file_get_contents('http://item.taobao.com/item.htm?id='.$urlid);
		$content = mb_convert_encoding($content,"UTF-8","gb2312");
		preg_match_all('/<div class="tb-pic tb-s40">\s+<a href="#"><img data-src=".+/', $content, $arrpic);
		$strpic = implode('img',$arrpic[0]);
		
		preg_match_all('/<img data-src=.+\/>/', $strpic, $doarrpic);
		$doarrpic = str_replace("<img data-src=\"","",$doarrpic[0]);
		$doarrpic = str_replace("\" />","",$doarrpic);
		return $doarrpic;

		}
		
		
		//获取并写入互联网评论
		public function GetAndIntoComment($shareid,$url,$cnum)
	{
		global $db;
		
		$cnum = 10;
		
		if(empty($url) || empty($shareid)) return '';
		
		$urlid = $this->getID($url);
		
		$meta      =     get_meta_tags($url);
		
		$arrusernumid = $meta['microscope-data'];
		
		preg_match_all('/(userid)=(\d+)/is', $arrusernumid, $usernumidd);
		
		$usernumid= $usernumidd[2][0];
		
		$re_url = 'http://rate.taobao.com/detail_rate.htm?userNumId='.$usernumid.'&auctionNumId='.$urlid.'&showContent=1';
		
		$str= file_get_contents($re_url);
		if(empty($str)){
		$str= file_get_contents($re_url);
		if(empty($str)){
		$str= file_get_contents($re_url);
		}
		}
		
		
		$darrstr = mb_convert_encoding($str,"UTF-8","gb2312");
		$arrstr =explode('"rateContent":"',$darrstr);
		
		foreach ($arrstr as $itme)
		{
			$doarrstr =explode('","rateDate"',$itme);
			$i=0;
			foreach ($doarrstr as $iitme)
			{
					if(($i/2)=='0' && !strstr($iitme,'scoreInfo')){
					
						$arrData	= array(
						'shareid'			=> intval($shareid),
						'userid'			=> '0',
						'content'	        => $iitme,
						'addtime'		    => time(),
					);
					if(!empty($iitme)){
					$commentid = $db->insertArr($arrData,dbprefix.'share_goods_comments');
					}
	
					//统计评论数
					$count_comment = $db->once_num_rows("select * from ".dbprefix."share_goods_comments where shareid='$shareid'");
					
					$uptime = time();
				
					$db->query("update ".dbprefix."share_goods set uptime='$uptime',count_comment='$count_comment' where goods_id='$shareid'");
					}
				$i++;
			}
		}
		
	}
	
	public function getID($url)
	{
		$id = 0;
		$parse = parse_url($url);
		if(isset($parse['query']))
		{
            parse_str($parse['query'],$params);
			if(isset($params['id']))
				$id = $params['id'];
            elseif(isset($params['item_id']))
                $id = $params['item_id'];
			elseif(isset($params['mallstItemId']))
                $id = $params['mallstItemId'];
			elseif(isset($params['default_item_id']))
                $id = $params['default_item_id'];
        }
		return $id;
	}
	

}