window.onerror=function(){return true;}
$(function() {	
var a;
$(".add_sub").live("click",function(){
					if($.guang.dialog.isLogin()){
					$.guang.dialog.add_sub();
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
	

	 $(".add_goods").live("click",function(){
				if($.guang.dialog.isLogin()){
				$.guang.dialog.add_good();
				}
	});
	
	
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
		   

	

	$("#J_BannerScroll").scrollImg({timer:6000,navis:".navi a"});

		$(".topic-block .main-pic").hover(function(){

			$(this).find(".description").animate({

				bottom: "0px"

			},300);

		},function(){

			$(this).find(".description").animate({

				bottom: "-24px"

			},300);

		});

		

		$(".tab-nav li a").click(function(e){

			$(".tab-nav li").removeClass("cur");

			$(this).parent("li").addClass("cur");

			Pagination.init();

		});	

		/* 

	 * 分页功能

	 * 回调函数的作用是显示对应分页的列表项内容,回调函数在用户每次点击分页链接的时候执行,参数page_index{int整型}表示当前的索引页

	 */

		var Pagination = {

			options : {},

			conf : function(){

				var config = {

						hiddenResultObj:null,

						showResultObj:null,

						paginationObj:null,

						myClass:null

				}

				var config = jQuery.extend(true, config, Pagination.options);

				return config;

			},

			firstLoad: true,

			pageselectCallback : function(page_index, jq){

				if(!Pagination.firstLoad){

					$("html, body").animate({

						scrollTop: 320

					}, 120);

				}

				Pagination.firstLoad = false;

				var tab = $(".tab-nav .cur a").data("tab"),

				config = Pagination.conf(),

				findStr = tab=="all" ? config.myClass : config.myClass+"[data-cag*="+tab+"]";

				var length = config.showResultObj.find(findStr).length;

				var maxLength = Math.min((page_index+1) * 10, length);

				config.showResultObj.hide();

				config.showResultObj.find(config.myClass).hide();

				config.showResultObj.find(".street-ll").hide();

				// 获取加载元素

				for(var i=page_index*10;i<maxLength;i++){

					var item = config.showResultObj.find(findStr+":eq("+i+")");

					//按需加载

					item.find("img").each(function(){

						if($(this).attr("src")=="http://static.letushuo.com/images/ui/street-point.png"){

							$(this).attr("src",$(this).data("src"));

						}

					})

					item.show();

					if(item.next().hasClass("street-ll")){

						item.next().show();

					}else{

						item.after('<div class="street-ll"><i class="crossroads crossroads-lt"></i><i class="crossroads crossroads-rt"></i></div>');

					}

				}

				config.showResultObj.fadeIn("normal",function(){

					var streetH = config.showResultObj.outerHeight()+265+"px";

					$(".topic-main .street-v").css("height",streetH);

				});

				return false;

			},

			init : function(length, callback){

			    var tab = $(".tab-nav .cur a").data("tab"),

				config = Pagination.conf(),				

			    findStr = tab=="all" ? config.myClass : config.myClass+"[data-cag*="+tab+"]";

			    

				var num_entries = config.showResultObj.find(findStr).length;

				if(num_entries>10){

					config.paginationObj.show();

				}

				// 创建分页

				config.paginationObj.pagination(num_entries, {

					num_edge_entries: 1, //边缘页数

					num_display_entries: 4, //主体页数

					callback: Pagination.pageselectCallback,

					items_per_page:10, //每页显示10项

					isJump:false

				});	

			}

		}

		

		Pagination.options = {

			hiddenResultObj : $("#J_HiddenArea"),

			showResultObj:$(".tab-content"),

			paginationObj:$("#J_Pagination"),

			myClass : ".topic-block"

		}

		Pagination.init();

		

		jQuery.ajax({

			url: "/xihuan",

			cache: false,

  			success: function(html){

  				var list = $('<div>'+html+'</div>');

  				$(".topic-aside .tag-link").html("");

  				for(var i=0; i<9; i++){

  					var tag = list.find(".sub-tag li:eq("+i+")");

  					if(tag){

  						$(".topic-aside .tag-link").append(tag.clone());

  					}

  				}

  			}

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
