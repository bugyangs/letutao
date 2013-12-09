<?php 

	defined('IN_TS') or die('Access Denied.');

	include_once 'sharegoods.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/TopClient.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/ItemGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/ItemcatsGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/ItemsListGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/ShopGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/TaobaokeItemsDetailGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/TaobaokeItemsGetRequest.php';
	include_once THINKROOT.'/plugins/sharesdks/taobaoapi/request/TaobaokeItemsCouponGetRequest.php';
class taobao_sharegoods implements interface_sharegoods
{
	public function fetch($url)
	{
		global $db;
		
		$id = $this->getID($url);
		if($id == 0)
		return false;
		$key = 'taobao_'.$id;
		$share_goods = 0;
		if($share_goods)
		{
		$result['status'] = -1;
		$result['share_id'] = $share_goods['share_id'];
		$result['goods_id'] = $share_goods['goods_id'];
		return $result;
		}
		$client = $this->_get_client();
		$req = new ItemGetRequest;
		$req->setFields("detail_url,title,nick,pic_url,price,item_imgs,is_xinpin");
		$req->setNumIid($id);
		$resp = $client->execute($req);
		if(!isset($resp->item))
		return false;
		$result = array();
		$goods = (array)$resp->item;
		
		if(empty($goods['detail_url']) ||empty($goods['pic_url']))
		return false;
		$result['item']['key'] = $key;
		$result['item']['nick'] = $goods['nick'];
		$result['item']['name'] = $goods['title'];
		$result['item']['price'] = $goods['price'];
		$result['item']['coupon_price'] = '0.00';
		$result['item']['img'] = $goods['item_imgs'];
		$result['item']['server_code'] = $image['server_code'];
		$result['item']['pic_url'] = $goods['pic_url'].'_100x100.jpg';
		$result['item']['url'] = $goods['detail_url'];
		$strOption = fileRead('options.php','data','system');
		$tao_ke_pid = $strOption['PID'];
		$shop_click_url = '';
		if(!empty($tao_ke_pid))
		{
		$req = new TaobaokeItemsDetailGetRequest;
		$req->setFields("click_url,shop_click_url,seller_credit_score");
		$req->setNumIids($id);
		$req->setPid($tao_ke_pid);
		$resp = $client->execute($req);
		
		$reqq = new TaobaokeItemsCouponGetRequest;
		$reqq->setKeyword($goods['title']);
		$reqq->setFields("num_iid,coupon_price,coupon_start_time,coupon_end_time");
		$respq = $client->execute($reqq);
		$ArrCoupons = array();
		$ArrCoupons=(array)$respq->taobaoke_items;
		$ArrCoupon = (array)$ArrCoupons['taobaoke_item'];
		if(isset($ArrCoupon)){
			
			if(isset($ArrCoupon[0])){
			foreach($ArrCoupon as $iitem){
					$iitem =(array)$iitem;
					if($iitem['num_iid']==$id){	
						$result['item']['coupon_price'] = $iitem['coupon_price'];
						$result['item']['coupon_start_time'] = strtotime($iitem['coupon_start_time']);
						$result['item']['coupon_end_time'] = strtotime($iitem['coupon_end_time']);
					}
				}
			}else{
				
				$result['item']['coupon_price'] = $ArrCoupon['coupon_price'];
				$result['item']['coupon_start_time'] = strtotime($ArrCoupon['coupon_start_time']);
				$result['item']['coupon_end_time'] = strtotime($ArrCoupon['coupon_end_time']);
			}
			
		}

		if(isset($resp->taobaoke_item_details))
		{
		$taoke = (array)$resp->taobaoke_item_details->taobaoke_item_detail;
		
		if(!empty($taoke['click_url']))
		$result['item']['taoke_url'] = $taoke['click_url'];
		if(!empty($taoke['seller_credit_score']))
		$result['item']['seller_credit_score'] = $taoke['seller_credit_score'];
		if(!empty($taoke['shop_click_url']))
		$shop_click_url = $taoke['shop_click_url'];
		}
		}
		if(!empty($goods['nick']))
		{
		$req = new ShopGetRequest;
		$req->setFields("sid,title,cid,title,shop_score");
		$req->setNick($goods['nick']);
		$resp = $client->execute($req);
		$shop = (array)$resp->shop;
		$shop_score = (array)$resp->shop->shop_score;
		$result['shop']['nick'] = $goods['nick'];
		$result['shop']['delivery_score'] = $shop_score['delivery_score'];
		$result['shop']['item_score'] = $shop_score['item_score'];
		$result['shop']['service_score'] = $shop_score['service_score'];
		}
		return $result;
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
		elseif(isset($params['default_item_id']))
		$id = $params['default_item_id'];
		}
		return $id;
	}
	
	public function getKey($url)
	{
		$id = $this->getID($url);
		return 'taobao_'.$id;
	}

	 /**
     * 获取商品列表
     * 返回商品列表和总数
     */
    public function _get_list($map, $p) {
		
        $client = $this->_get_client();
		$req = new TaobaokeItemsGetRequest;
        $req->setFields('num_iid,title,nick,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume');
		
		$strOption = fileRead('options.php','data','system');
		$tao_ke_pid = $strOption['PID'];
		if(!empty($tao_ke_pid)) $req->setPid($tao_ke_pid);
		
        $req->setPageNo($p);
        $req->setPageSize(20);
        $map['keyword'] && $req->setKeyword($map['keyword']); //关键词
        $map['cid'] && $req->setCid($map['cid']); //分类
        $map['start_price'] && $req->setStartPrice($map['start_price']); //价格下限
        $map['end_price'] && $req->setEndPrice($map['end_price']); //价格上限
        $map['start_commissionRate'] && $req->setStartCommissionRate($map['start_commissionRate'] * 100); //佣金比率下限
        $map['end_commissionRate'] && $req->setEndCommissionRate($map['end_commissionRate'] * 100); //佣金比率上限
        $map['start_commissionNum'] && $req->setStartCommissionNum($map['start_commissionNum']); //30天推广量下限
        $map['end_commissionNum'] && $req->setEndCommissionNum($map['end_commissionNum']); //30天推广量上限
        $map['start_totalnum'] && $req->setStartTotalnum($map['start_totalnum']); //总销量下限
        $map['end_totalnum'] && $req->setEndTotalnum($map['end_totalnum']); //总销量上限
        $map['start_credit'] && $req->setStartCredit($map['start_credit']); //卖家信用下限
        $map['end_credit'] && $req->setEndCredit($map['end_credit']); //卖家信用上限
        $map['mall_item'] && $req->setMallItem('true'); //是否天猫商品
        $map['guarantee'] && $req->setGuarantee('true'); //是否消保卖家
        $map['sevendays_return'] && $req->setSevendaysReturn('true'); //是否支持7天退换
        $map['real_describe'] && $req->setRealDescribe('true'); //是否先行赔付
        $map['cash_coupon'] && $req->setCashCoupon('true'); //是否支持抵价券
        $map['sort'] && $req->setSort($map['sort']);
        
        $req->setStartCommissionRate(1000);
        $req->setEndCommissionRate(2000);
        
        $resp = $client->execute($req);
        $count = $resp->total_results;
        //列表内容
        $iids = array();
        $resp_items = (array) $resp->taobaoke_items;
        $taobaoke_item_list = array();
		
		
        foreach ($resp_items['taobaoke_item'] as $val) {
            $val = (array) $val;
            //喜欢数
            switch ($map['like_init']) {
                case 'volume':
                    $val['likes'] = $val['volume'];
                    break;
                default:
                    $val['likes'] = 0;
                    break;
            }
            $taobaoke_item_list[$val['num_iid']] = $val;
        }
	
        //$taobaoke_item_list[$val['num_iid']]['imgs'] = $this->_Get_Item_Img($taobaoke_item_list);

        //返回
        return array(
            'count' => intval($count),
            'item_list' => $taobaoke_item_list,
        );
    }
	
	
	
	//获取商品相册信息
	public function _Get_Item_Img($taobaoke_item_list) {
		
		$client = $this->_get_client();
        $iids = array_keys($taobaoke_item_list);
       	$req = new ItemsListGetRequest;
        $req->setFields('num_iid,item_img');
        $req->setNumIids(implode(',', $iids));
        $resp = $client->execute($req);
        $resp_items = (array) $resp->items;
        $resp_item_list = $resp_items['item'];
        foreach ($resp_item_list as $val) {
            $imgs = array();
            $val = (array) $val;
            $item_imgs = (array) $val['item_imgs'];
            $item_imgs = (array) $item_imgs['item_img'];
            foreach ($item_imgs as $_img) {
                $_img = (array) $_img;
                if ($_img['url']) {
                    $imgs[] = array(
                        'url' => $_img['url'],
                        'surl' => $_img['url'] . '_100x100.jpg',
                        'ordid' => $_img['position']
                    );
                }
            }
            return $imgs;
        }
	}
	
	//获取淘宝分类
	public function _GetTaobaocats($cid = 0) {
        $client = $this->_get_client();
		$req = new ItemcatsGetRequest;
		$req->setFields("cid,parent_cid,name,is_parent");
		$req->setParentCid($cid);
		$resp = $client->execute($req);
		if(!isset($resp))
		return false;
        $res_cats = (array) $resp->item_cats;
        $item_cate = array();
		
        foreach ($res_cats['item_cat'] as $val) {
            $val = (array) $val;
            $item_cate[] = $val;
        }
        return $item_cate;
    }
	
	 public function _get_client() {
		include_once 'fun.base.php';
		$strOption = fileRead('options.php','data','system');
        $client = new TopClient;
		$client->appkey = $strOption['AppKey'];
		$client->secretKey = $strOption['AppSecret'];
        return $client;
    }
}

?>