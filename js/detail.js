$(function() {	
	var a;
	var $showResult = $("#J_ShowResult");
	var cmtHtml = "";
	var productId = $("#J_HiddenProductId").val();
	
	function getTime(){
		var now= new Date();
		var hour=now.getHours();
		var minute=now.getMinutes();
		var curTime = hour + ":" + minute;
		return curTime;
	}

	//值得比例
	var $worth = $("#J_Worth");
	if($worth[0]){
		var dataBcount = parseInt($worth.attr("data-bcount"));
		var dataScount = parseInt($worth.attr("data-scount"));
		var scale = dataScount/dataBcount*100 + "%";
		$worth.css("width", scale);
	}	
	/* 主商品相册多图切换 */
	$(".thumb-list li").hover(function(){
		var curImg = $(this).find("img");
		largeImgSrc = curImg.attr("data-src");
		$(".pic-box img").attr("src",largeImgSrc);
		$(".thumb-list li.cur").removeClass("cur");
		$(this).addClass("cur");
	});
	//小图滚动
	$(".scrollable").scrollable({circular:false});

	var $likeCount = $("#J_LikeCount");
	$(".likes").hover(function(){
		$likeCount.text("+1");
	},function(){
		$likeCount.text($likeCount.attr("data-val"));
	});
	/* 喜欢 */
	$(".ilike, .likes").click(function(){
			if($.guang.dialog.isLogin()){
			var $this = $(this);
			var commentType = $this.attr("data-type");
			var $likeCount = $this.closest(".goods").find(".like-count:first");
			if($("#cmtDialog")[0]){
				$("#cmtDialog").fadeOut();
			}
			$.guang.judgement.repeatIdentityClk = function(o, commentType){
				
				$.guang.dialog.lkComment($this,'已经喜欢过了,再说两句');
			}
			$.guang.judgement.identityCallback = function(o, commentType){
				var $likeCount = $("#J_LikeCount");
				var newCount = parseInt($likeCount.attr("data-val")) + 1;
				var userId = $("#J_HiddenUserId").val();
				var userNick = $("#J_HiddenUserNick").val();
				var userPhoto = $("#J_HiddenUserPhoto").val();
				$likeCount.text(newCount);
				$likeCount.attr("data-val",newCount);
				
				$.guang.dialog.lkComment($this,'喜欢了');
			}
			$.guang.judgement.identityOper($this, productId, commentType);
		}
	});
	
	$("#J_LkCommentSubmit").live("click",function(){
		var $this = $(this);
		var back_url = GUANGER.cmurl;
		var referid = $(this).attr("data-referid");
		if($.guang.dialog.isLogin()){
			var e = $.guang.util.trim($("#J_CommentTxa").val()),
            f = $(".worth-radioclick-on").attr("data-type");
			 "" != e ? 256 > $.guang.util.getStrLength(e) ? $.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=comment",
                type: "post",
                dataType: "json",
                data: {
                    productId: productId,
                    commentContent: e,
					referid       : referid,
                    commentType: f
                },
                success: function(k) {
                    switch (k.code) {
                    case 100:
                        $.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                        $.guang.tip.show($this, "\u8bc4\u8bba\u53d1\u8868\u6210\u529f\uff01");
                        $.guang.judgement.cmtSubmitOkClk();
						setTimeout(function(){
							window.location.href=back_url;
						},1000);
						
                        break;
                    case 101:
                        $.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        $.guang.tip.show($this, b.msg),
                        $.guang.judgement.cmtSubmitErrorClk()
                    }
                }
            }) : ($.guang.tip.conf.tipClass = "tipmodal tipmodal-general", $.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u8d85\u8fc7256\u4e2a\u6c49\u5b57\uff01")) : ($.guang.tip.conf.tipClass = "tipmodal tipmodal-general", $.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u4e3a\u7a7a\uff01"))

		}
	});
	
	$("#lkCommentSubmit").live("click",function(){
		var $this = $(this);
		var referid = $(this).attr("data-referid");
		if($.guang.dialog.isLogin()){
			var e = $.guang.util.trim($("#lkcommentContent").val());
           
			 "" != e ? 256 > $.guang.util.getStrLength(e) ? $.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=comment",
                type: "post",
                dataType: "json",
                data: {
                    productId: productId,
                    commentContent: e,
					referid : referid,
                    commentType: 0
                },
                success: function(k) {
                    switch (k.code) {
                    case 100:
                        $.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                        $.guang.tip.show($this, "\u8bc4\u8bba\u53d1\u8868\u6210\u529f\uff01");
						
                        $.guang.judgement.cmtSubmitOkClk();
                        break;
                    case 101:
                        $.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        $.guang.tip.show($this, b.msg),
                        $.guang.judgement.cmtSubmitErrorClk()
                    }
                }
            }) : ($.guang.tip.conf.tipClass = "tipmodal tipmodal-general", $.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u8d85\u8fc7256\u4e2a\u6c49\u5b57\uff01")) : ($.guang.tip.conf.tipClass = "tipmodal tipmodal-general", $.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u4e3a\u7a7a\uff01"))

		}
	});
	  $(".appraisal .jd-radio").live("click",
    function() {
        var a = $(this);
        a.hasClass("worth-radioclick-on") ? a.removeClass("worth-radioclick-on").addClass("worth-radioclick-off") : ($(".worth-radioclick-on").removeClass("worth-radioclick-on").addClass("worth-radioclick-off"), a.removeClass("worth-radioclick-off").addClass("worth-radioclick-on"))
    });
	
	/* 值得、不值得 */
	$(".J_CmtReplyBtn").click(function(){
		var $this = $(this);
		var username = $this.attr("data-username");
		$.guang.dialog.comment($this,'回复'+username);
		
		
	})
	/* 值得、不值得 */
	$(".appraisal .bbl-btn, .appraisal .bgr-btn, .evaluate .sbl-btn, .evaluate .sgr-btn").click(function(){
		var $this = $(this);
		var $identityWorth = $this.closest(".J_IdentityWorth");
		if($.guang.dialog.isLogin()){
			var commentType = $this.attr("data-type");
			var $countValue = $this.closest(".J_CountValue");
			var $scount = $countValue.find(".scount:first");
			var $bcount = $countValue.find(".bcount:first");
			function showResult(worthType){
				var msg = "你鉴定的结果：";
				if(worthType == "1"){
					$identityWorth.html(msg + "值得");
				}else if(worthType == "0"){
					$identityWorth.html(msg + "不值得");
				}
				//alert(worthType)
			}
			$.guang.judgement.repeatIdentityClk = function(o, desirableType){
				$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
				$.guang.tip.show($identityWorth,">_< 你已经鉴定过此商品了！");
				showResult(desirableType);
			}
			$.guang.judgement.identityCallback = function(o, commentType){
				var dataBcount,dataScount,scale;
				if(commentType == "1"){//值得
					dataBcount = parseInt($worth.attr("data-bcount")) + 1;
					dataScount = parseInt($worth.attr("data-scount")) + 1;
				}else{//不值得
					dataBcount = parseInt($worth.attr("data-bcount")) - 1;
					dataScount = parseInt($worth.attr("data-scount")) - 1;
				}
				$worth.attr("data-bcount",dataBcount);
				$worth.attr("data-scount",dataScount);
				scale = dataScount/dataBcount*100 + "%";
				$worth.css("width", scale);
				showResult(commentType);
				$scount.text(dataScount);
				$bcount.text(dataBcount);
				$.guang.dialog.comment($this);
			}
			$.guang.judgement.identityOper($this, productId, commentType);
		}
	});
	
	/* 购买店铺行换色 */
	$(".shops li,#J_MoreShopsM li,#J_MoreShopsS li").hover(function(){
		$(this).addClass("bg-blue");
		$(this).find(".buy-link").addClass("hover");
	},function(){
		$(this).removeClass("bg-blue");
		$(this).find(".buy-link").removeClass("hover");
	});
	/* 显示全部商家 */
	$(".buyit .more-shops a").click(function(){
		$this = $(this);
		if($("#J_MoreShopsM").find("li").length >0){
			$("#J_MoreShopsM").slideToggle(function(){
				$this.text()=="显示全部商家" ? $this.text("收起") : $this.text("显示全部商家");
			});
		}
	});
	$(".buy-info .more-shops a").click(function(){
		$this = $(this);
		if($("#J_MoreShopsS").find("li").length > 0){
			$("#J_MoreShopsS").slideToggle(function(){
				$this.text()=="显示全部商家" ? $this.text("收起") : $this.text("显示全部商家");
			});			
		}

	});
	
	
	$(".gotoshopping,.shops li").hover(function() {
        $(".tooltip").show();
    },
    function() {
        $(".tooltip").hide()
    });
	
	/* 发现喜欢 换一组 */
	var $changeGroupBtn = $("#J_ChangeGroupBtn");
	var $findGoods = $("#J_FindGoods");	
	var $finds = $(".finds");
	$finds.css("margin-left",-Math.floor(Math.random()*4)*280).show();//页面第一次加载的时候发现喜欢商品随机显示
	var findsItemLen = $finds.find(".finds-item").length;
	var ticking = null;	
	function changeFinds(){
		var seconds = 10;
		ticking = setInterval(function(){
			var width = $(".ticking").outerWidth();
			var newW = seconds==10 ? 190 : (width-19);
			$(".ticking").animate({
				width:newW+"px"
			},500);
			$(".tick-txt em").text(seconds);
			seconds -=1;		
			if(seconds==-1){
				seconds = 10;
				var ml = parseInt($finds.css("margin-left"));
				var itemW = (findsItemLen-1)*280;
				var newml = (ml==-itemW||ml<-itemW) ? 0 : ml-280+"px";
				var itemIndex = Math.abs(parseInt(newml)/280);
				changeInfo(itemIndex);
				/*$finds.animate({
					marginLeft:newml
				},1000);*/
				$finds.fadeOut(500,function(){
					$finds.css("margin-left",newml);
					$finds.fadeIn(500);
				});
			}
		},1000);		
	}
	changeFinds();
	
	function changeInfo(curItemIndex){
		var $finds = $(".finds");
		var $findsCount = $("#J_FindsCount");
		var $curfindsItem = $finds.find(".finds-item:eq(" + curItemIndex + ")");
		var dataLikeCnt = $curfindsItem.attr("data-likeCnt");
		var dataCommentCnt = $curfindsItem.attr("data-commentCnt");
		var dataSaleCnt = $curfindsItem.attr("data-saleCnt");
		$findsCount.find(".like-count").text(dataLikeCnt);
		$findsCount.find(".cmt-count").text(dataCommentCnt);
		$findsCount.find(".sale-count").text(dataSaleCnt);	
		$changeGroupBtn.attr("data-index",curItemIndex);
	}
	
	//发现喜欢换一组数据交互
	var $changeGroupBtn = $("#J_ChangeGroupBtn");
	var $findGoods = $("#J_FindGoods");
	
	var isEnable = "true";//默认按钮可用
	$changeGroupBtn.click(function(){
		clearInterval(ticking);
		var $this = $(this);
		var $finds = $(".finds");
		var itemIndex = $this.attr("data-index");
		var findsItemLen = $finds.find(".finds-item").length;
		var nextIndex = (parseInt(itemIndex) >= (findsItemLen-1))?"0":parseInt(itemIndex)+1;
		var changeml = "-" + nextIndex*280 + "px";
		$finds.css("margin-left",changeml);
		changeInfo(nextIndex);
		changeFinds();
	});
});


 function UploadShareImg()
    {

        $("#loadingImg0").show();
		$.ajaxFileUpload({
            url:GUANGER.path+"index.php?app=share&ac=do&le=UploadImg",
			secureuri :false,
			dataType: 'text',
			fileElementId :'uploadShareImg',
            success:function(result)
            {
				
				if(result){
				$("#loadingImg0").hide()
				$("#thumb0").show();
				$("#thumb0").attr("src",GUANGER.path + result);
				$("#img_url").val(GUANGER.path+result);
			
					
				}else{
					
					 alert("上传失败");
				}
         
                  

				
            },
            error:function ()
            {
                alert("上传失败");
            }
        });
       
    }


$(function() {	
		

		   
		   
	//删除
	var $ilikeDel = $(".baobeidel");
	//$ilikeDel.css("display","none");
	$ilikeDel.live("click",function(){
		if($.guang.dialog.isLogin()){
			var goodsId = $(this).attr("data-proid");
			var curGoodsItem = $(this).closest(".goods");
			$.ajax({
				   url: GUANGER.path+"index.php?app=share&ac=do&le=del_good",
				   type : "post",
				   dataType: "json",
				   data: {
					   goodsId : goodsId
				   },
				   success: function(data){
					   var $json = data;
					   switch($json.code){
					   case(100):
					   $.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($ilikeDel,">_< 删除成功");
						history.go(-1);
						  break;
					   case(101):
						   alert($json.msg);
					   	break;
					   }  
				   }
			});
		}
				
	});
	
		//置顶
	var $baobeitop = $(".baobeitop");
	//$baobeitop.css("display","none");
	$baobeitop.live("click",function(){
		if($.guang.dialog.isLogin()){
			var goodsId = $(this).attr("data-proid");
			var datatype = $(this).attr("data-type");
			var curGoodsItem = $(this).closest(".goods");
			$.ajax({
				   url: GUANGER.path+"index.php?app=share&ac=do&le=top_good",
				   type : "post",
				   dataType: "json",
				   data: {
					   goodsId : goodsId,
					   datatype : datatype
				   },
				   success: function(data){
					   var $json = data;
					   switch($json.code){
					   case(100):
					   $.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($baobeitop,"^_^"+$json.msg);
						  break;
					   case(101):
						   alert($json.msg);
					   	break;
					   }  
				   }
			});
		}
				
	});
	
	
	$("#J_CommentTxa").click(function(){
	$("#J_CmtHiddenForm").show();
});

$("#J_HiddenForm").click(function(){
	
	$("#J_CmtHiddenForm").hide();
});

});
