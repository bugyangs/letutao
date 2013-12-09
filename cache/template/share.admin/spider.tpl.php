<?php include template("admin/header");?>
<script src="<?php echo SITE_URL; ?>public/js/jquery.js" type="text/javascript"></script>

<script>
$(function(){
    var uri = "<?php echo SITE_URL; ?>index.php?app=share&ac=admin&mg=spider&ts=ajax_get_tb_cate";
    $('.J_tbcats').die('change').live('change', function(){
        var _this = $(this),
            _cid = _this.val();
        _this.nextAll('.J_tbcats').remove();
        $.getJSON(uri, {cid:_cid}, function(result){
			
            if(result.status == '1'){
				
                var _childs = $('<select class="J_tbcats mr10"><option value="0">--所有--</option></select>');
                for(var i=0; i<result.data.length; i++){
                    $('<option value="'+result.data[i].cid+'">'+result.data[i].name+'</option>').appendTo(_childs);
                }
                _childs.insertAfter(_this);
            }
        });
        $('#J_cid').val(_cid);
    });
});
</script>

<!--main-->
<div class="midder">

<?php include template("admin/menu");?>
<form id="J_alimama_form" name="searchform" method="get">
    <table width="100%" cellspacing="0" class="table_form">
        <tbody>
            <tr>
                <th width="150">
                    淘宝商品分类：
                </th>
                <td>
                    <select class="J_tbcats mr10">
                        <option value="0">
                            --所有--
                        </option>
                        <?php foreach((array)$item_cate as $key=>$item) {?>
                         <option value="<?php echo $item['cid'];?>"><?php echo $item['name'];?></option>
                        <?php }?>
                    </select>
                    <input type="hidden" id="J_cid" name="cid" val="">
                    <span class="gray ml10">
                        分类和关键词至少设置一个
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    关键词：
                </th>
                <td>
                    <input name="keyword" type="text" class="input-text" size="40">
                    <span class="gray ml10">
                        分类和关键词至少设置一个
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    排序：
                </th>
                <td>
                    <select name="sort">
                        <option value="default">
                            默认排序
                        </option>
                        <option value="price_desc">
                            价格从高到低
                        </option>
                        <option value="price_asc">
                            价格从低到高
                        </option>
                        <option value="credit_desc">
                            信用等级从高到低
                        </option>
                        <option value="commissionRate_desc">
                            佣金比率从高到低
                        </option>
                        <option value="commissionRate_asc">
                            佣金比率从低到高
                        </option>
                        <option value="commissionNum_desc">
                            成交量成高到低
                        </option>
                        <option value="commissionNum_asc">
                            成交量从低到高
                        </option>
                        <option value="commissionVolume_desc">
                            总支出佣金从高到低
                        </option>
                        <option value="commissionVolume_asc">
                            总支出佣金从低到高
                        </option>
                        <option value="delistTime_desc">
                            商品下架时间从高到低
                        </option>
                        <option value="delistTime_asc">
                            商品下架时间从低到高
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    商品价格：
                </th>
                <td>
                    <input type="text" name="start_price" size="8" class="input-text">
                    -
                    <input type="text" name="end_price" size="8" class="input-text">
                    元
                    <span class="gray ml10">
                        可不填，起始价格和最高价格一起设置才有效
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    佣金比率：
                </th>
                <td>
                    <input type="text" name="start_commissionRate" size="5" class="input-text">
                    % -
                    <input type="text" name="end_commissionRate" size="5" class="input-text">
                    %
                    <span class="gray ml10">
                        可不填，最低比率和最高比率一起设置才有效
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    30天推广量：
                </th>
                <td>
                    <input type="text" name="start_commissionNum" size="8" class="input-text">
                    -
                    <input type="text" name="end_commissionNum" size="8" class="input-text">
                    <span class="gray ml10">
                        可不填，最低推广量和最高推广量一起设置才有效
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    30天成交量：
                </th>
                <td>
                    <input type="text" name="start_totalnum" size="8" class="input-text">
                    -
                    <input type="text" name="end_totalnum" size="8" class="input-text">
                    <span class="gray ml10">
                        可不填，最低销量和最高销量一起设置才有效
                    </span>
                </td>
            </tr>
            <tr>
                <th>
                    卖家信用：
                </th>
                <td>
                    <select name="start_credit">
                        <option value="1heart">
                            一心
                        </option>
                        <option value="2heart">
                            两心
                        </option>
                        <option value="3heart">
                            三心
                        </option>
                        <option value="4heart">
                            四心
                        </option>
                        <option value="5heart">
                            五心
                        </option>
                        <option value="1diamond">
                            一钻
                        </option>
                        <option value="2diamond">
                            两钻
                        </option>
                        <option value="3diamond">
                            三钻
                        </option>
                        <option value="4diamond">
                            四钻
                        </option>
                        <option value="5diamond">
                            五钻
                        </option>
                        <option value="1crown">
                            一冠
                        </option>
                        <option value="2crown">
                            两冠
                        </option>
                        <option value="3crown">
                            三冠
                        </option>
                        <option value="4crown">
                            四冠
                        </option>
                        <option value="5crown">
                            五冠
                        </option>
                        <option value="1goldencrown">
                            一黄冠
                        </option>
                        <option value="2goldencrown">
                            两黄冠
                        </option>
                        <option value="3goldencrown">
                            三黄冠
                        </option>
                        <option value="4goldencrown">
                            四黄冠
                        </option>
                        <option value="5goldencrown">
                            五黄冠
                        </option>
                    </select>
                    -
                    <select name="end_credit">
                        <option value="1heart">
                            一心
                        </option>
                        <option value="2heart">
                            两心
                        </option>
                        <option value="3heart">
                            三心
                        </option>
                        <option value="4heart">
                            四心
                        </option>
                        <option value="5heart">
                            五心
                        </option>
                        <option value="1diamond">
                            一钻
                        </option>
                        <option value="2diamond">
                            两钻
                        </option>
                        <option value="3diamond">
                            三钻
                        </option>
                        <option value="4diamond">
                            四钻
                        </option>
                        <option value="5diamond">
                            五钻
                        </option>
                        <option value="1crown">
                            一冠
                        </option>
                        <option value="2crown">
                            两冠
                        </option>
                        <option value="3crown">
                            三冠
                        </option>
                        <option value="4crown">
                            四冠
                        </option>
                        <option value="5crown">
                            五冠
                        </option>
                        <option value="1goldencrown">
                            一黄冠
                        </option>
                        <option value="2goldencrown">
                            两黄冠
                        </option>
                        <option value="3goldencrown">
                            三黄冠
                        </option>
                        <option value="4goldencrown">
                            四黄冠
                        </option>
                        <option value="5goldencrown" selected="">
                            五黄冠
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                    更多条件：
                </th>
                <td>
                    <label class="mr10">
                        <input type="checkbox" name="mall_item" value="1">
                        仅天猫商品
                    </label>
                    <label class="mr10">
                        <input type="checkbox" name="guarantee" value="1">
                        仅消保卖家
                    </label>
                    <label class="mr10">
                        <input type="checkbox" name="sevendays_return" value="1">
                        仅支持7天退换
                    </label>
                    <label class="mr10">
                        <input type="checkbox" name="real_describe" value="1">
                        仅支持先行赔付
                    </label>
                    <label class="mr10">
                        <input type="checkbox" name="cash_coupon" value="1">
                        仅支持抵价券
                    </label>
                </td>
            </tr>
            <tr>
                <th>
                    商品喜欢数设置：
                </th>
                <td>
                    <select name="like_init">
                        <option value="0">
                            默认为0
                        </option>
                        <option value="volume">
                            30天成交量
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>
                </th>
                <td>
                    <input type="hidden" name="app" value="share">
                    <input type="hidden" name="ac" value="admin">
                    <input type="hidden" name="mg" value="spider">
                    <input type="hidden" name="ts" value="search">
                    <input type="submit" name="search" class="btn btn_submit mr10" value="搜索筛选">
                    <input style="display:none" type="button" name="import" class="J_showdialog btn" value="直接入库" data-uri="<?php echo SITE_URL; ?>index.php?app=share&ac=admin&mg=spider&ts=import" data-title="直接入库" data-width="450">
                </td>
            </tr>
        </tbody>
    </table>
</form>
</div>
<?php include template("admin/footer");?>