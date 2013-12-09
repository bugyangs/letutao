(function($) { 
	var a;
	$.guang = $.guang || {
        version: "v1.0.0"
    };
	
	
	
$(".add_sub").live("click",function(){
					if($.guang.dialog.isLogin()){
					$.guang.dialog.add_sub();
				}
	});
	
	
	$(".update_sub").live("click",function(){
					if($.guang.dialog.isLogin()){
					var themeId = $(this).attr("data-themeid");
					var title = $(this).attr("data-title");
					var desc = $(this).attr("data-desc");
					var tag = $(this).attr("data-tag");
					$.guang.dialog.update_sub(themeId,title,desc,tag);
				}
	});
	
	
		 $(".add_goods").hover(function() {
            $(".m_button").addClass("cblock");
			a != null && clearTimeout(a);
        },
        function() {
            a = setTimeout(function() {
                $(".m_button").removeClass("cblock");
            },
            700)
        });
		
		$(".m_button").hover(function() {
            a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".m_button").removeClass("cblock");
            },
            700)
        });
	
		
	$(".combox").hover(function(){
        $(this).css("border","1px solid #65c5b3");		
    },function(){
        $(this).css("border","1px solid #EDEDED");		
    });
    $("#pannel li").live("mouseover",function(){
        $(this).removeClass("out");
        $(this).addClass("over");	
    }).live('mouseout',function(){
        $(this).removeClass("over");
        $(this).addClass("out");	
    }).live('click',function(){
        $(".select").val($(this).attr("default"));
        $("#pannel").hide();	
    });
	
	 $(".select").live("click",function(){
				
				resulthtml = GUANGER.resulthtml;
                $("#pannel").html(resulthtml);
                $("#pannel").show();
				
	});
	
	$(".add_pic").live("click",function(){
				if($.guang.dialog.isLogin()){
				$.guang.dialog.add_pic();
				}
	});
	
	
	//置顶
	var $themetop = $(".themetop");
	//$themetop.css("display","none");
	$themetop.live("click",function(){
		if($.guang.dialog.isLogin()){
			var themeId = $(this).attr("data-themeid");
			var datatype = $(this).attr("data-type");
			var curGoodsItem = $(this).closest(".goods");
			$.ajax({
				   url: GUANGER.path+"index.php?app=share&ac=do&le=top_theme",
				   type : "post",
				   dataType: "json",
				   data: {
					   themeId : themeId,
					   datatype : datatype
				   },
				   success: function(data){
					   var $json = data;
					   switch($json.code){
					   case(100):
					   $.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($themetop,"^_^"+$json.msg);
						  break;
					   case(101):
						   alert($json.msg);
					   	break;
					   }  
				   }
			});
		}
				
	});
	
	$(".add_goods").live("click",function(){
				if($.guang.dialog.isLogin()){
				$.guang.dialog.add_good();
				}
	});
	
	$(".upfileimg").live("click",function(){
				if($.guang.dialog.isLogin()){
				$.guang.dialog.upfileimg();
				}
	});
	
	
	$.extend($.guang, {
	goods: {
		conf: {
    		colArray: [],
    		containerW: 960,
    		columns: 4,
    		columnWidthInner: 210,
    		columnMargin: 13,
    		columnPadding: 20,
    		columnWidthOuter: 243
		},
		init: function(){
			var self = $.guang.goods,
    		conf = $.guang.goods.conf;
			conf.columnWidthOuter = conf.columnWidthInner + conf.columnMargin + conf.columnPadding;
        	if(conf.colArray.length==0){
        		for (var i = 0; i < conf.columns; i++) {
        			conf.colArray[i] = 0;
        		}
        	}       	
       		self.flow();
		},
		flow: function(){
			var self = $.guang.goods,
    		conf = $.guang.goods.conf;
			var ele = $(".goods-wall").find(".goods");
			ele.each(function(i){
            	var d = $(this)[0],
            	c = jQuery.inArray(Math.min.apply(Math, conf.colArray), conf.colArray),
            	f = conf.colArray[c];
            	d.style.top = f + "px";
            	d.style.left = c * conf.columnWidthOuter + "px";
            	conf.colArray[c] = f + d.offsetHeight + conf.columnMargin;
            	$(".goods-wall").append(d);
        	});
        	$(".goods-wall")[0].style.height = Math.max.apply(Math, conf.colArray) + "px";
        	self.fill();
        	$(".goods-container").remove();
        	$(".goods-wall").animate({
            	opacity: "1"
        	},
        	500);
		},
		fill: function() {
    		var self = $.guang.goods,
    		conf = $.guang.goods.conf;
    		var colMaxH = Math.max.apply(Math, conf.colArray),
    		index = jQuery.inArray(colMaxH, conf.colArray);
    		for(var i=0;i<conf.columns;i++){
    			if(i != index){
    				$(".goods-wall").append('<div class="goods-fill" style="top:' + conf.colArray[i] + 'px;left:' + i* conf.columnWidthOuter +'px;height:' + (colMaxH - conf.colArray[i] - conf.columnMargin) + 'px"></div>');
    			}
    		}
    	}
	}
	});
})(jQuery);

$(function(){	                    
	$.guang.goods.init();
		
	$(".goodstags li").live('click', function(){
		var tagInput = $('#tags');
		var tagValue = tagInput.val();
		tagValue = tagValue.replace('　',' ');
		tagValue = tagValue.replace(/ +/g,' ');
		tagValue = ' ' + $.trim(tagValue) + ' ';
		if($(this).hasClass('on'))
		{
			tagValue = tagValue.replace(' ' + $(this).html() + ' ',' ');
			$(this).removeClass('on');
		}
		else
		{
			tagValue += $(this).html();
			$(this).addClass('on');
		}
		
		tagValue = $.trim(tagValue);
		tagInput.val(tagValue);
	});
	
	$(".goods-wall .goods").bind("mouseover mouseout",function(event){	
		if(event.type == "mouseover"){
			$(this).find(".ilike-m").show();
			$(this).find("h3").css({
				"color":"#666"
			});
			$(this).css({
				"box-shadow":"0 1px 5px rgba(35,25,25,0.7)",
				"-moz-box-shadow":"0 1px 5px rgba(35,25,25,0.7)",
				"-webkit-box-shadow":"0 1px 5px rgba(35,25,25,0.7)"
			});
		}else{
			$(this).find(".ilike-m").hide();
			$(this).find("h3").css({
				"color":"#999"
			});
			$(this).css({
				"box-shadow":"0 1px 3px rgba(34,25,25,0.2)",
				"-moz-box-shadow":"0 1px 3px rgba(34,25,25,0.2)",
				"-webkit-box-shadow":"0 1px 3px rgba(34,25,25,0.2)"
			});
		}
	});
		   
	
	$(".ilike-m").live("click",function(){
		if($.guang.dialog.isLogin()){
			var $this = $(this);
			var commentType = $this.attr("data-type");
			var productId = $this.attr("data-proid");
			var $likeCount = $this.closest(".goods").find(".like-count:first");
			if($("#cmtDialog")[0]){
				$("#cmtDialog").fadeOut();
			}
			$.guang.judgement.repeatIdentityClk = function(o, commentType){
				$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
				$.guang.tip.show($this,">_< 你已经喜欢过了哦~");
			}
			$.guang.judgement.identityCallback = function(o, commentType){
				$likeCount.text(parseInt($likeCount.text()) + 1);
				$.guang.dialog.lkComment($this);
			}
			$.guang.judgement.identityOper($this, productId, commentType);
		}
	});
	//分页
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
