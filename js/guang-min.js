(function(a) {
	

	
    a.guang = a.guang || {
        version: "v1.0.0"
    };
    a.extend(a.guang, {
        util: {
            isIE6: function() {
                return a.browser.msie && "6.0" == a.browser.version ? !0 : !1
            },
            isIOS: function() {
                return /\((iPhone|iPad|iPod)/i.test(navigator.userAgent)
            },
            trim: function(a) {
                return a.replace(/(^\s*)|(\s*$)/g, "")
            },
            lTrim: function(a) {
                return a.replace(/(^\s*)/g, "")
            },
            rTrim: function(a) {
                return a.replace(/(\s*$)/g, "")
            },
            getStrLength: function(b) {
                var b = a.guang.util.trim(b),
                d = 0,
                b = b.replace(/[^\x00-\xff]/g, "**").length;
                return d = parseInt(b / 2) == b / 2 ? b / 2 : parseInt(b / 2) + 0.5
            },
            ellipse: function(b, d) {
                var c = 2 * a.guang.util.getStrLength(b) > d;
                return b && c ? b.replace(RegExp("([\\s\\S]{" + d + "})[\\s\\S]*"), "$1\u2026") : b
            },
            isEmpty: function(b) {
                return "" == a.guang.util.trim(b) ? !1 : !0
            },
            isEmail: function(a) {
                return /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(a)
            },
            isNick: function(a) {
                return /^[a-zA-Z\d\u4e00-\u9fa5_-]*$/.test(a)
            },
            nickMin: function(b) {
                return 4 > 2 * a.guang.util.getStrLength(b) ? !1 : !0
            },
            nickMax: function(b) {
                return 30 < 2 * a.guang.util.getStrLength(b) ? !1 : !0
            },
            tooShort: function(a, d) {
                return a.length < d ? !1 : !0
            },
            noLink: function(a) {
                return null == a.match(/(http[s]?:\/\/)?[a-zA-Z0-9-]+(\.[a-zA-Z0-9]+)+/) ? !0 : !1
            },
            getPosition: function(b) {
                var d = b.offset().top,
                c = b.offset().left,
                e = d + b.outerHeight(),
                f = c + b.outerWidth(),
                g = c + b.outerWidth() / 2,
                h = d + b.outerHeight() / 2;
                /iPad/i.test(navigator.userAgent) && (d -= a(window).scrollTop(), e -= a(window).scrollTop(), h -= a(window).scrollTop());
                return {
                    leftTop: function() {
                        return {
                            x: c,
                            y: d
                        }
                    },
                    leftMid: function() {
                        return {
                            x: c,
                            y: h
                        }
                    },
                    leftBottom: function() {
                        return {
                            x: c,
                            y: e
                        }
                    },
                    topMid: function() {
                        return {
                            x: g,
                            y: d
                        }
                    },
                    rightTop: function() {
                        return {
                            x: f,
                            y: d
                        }
                    },
                    rightMid: function() {
                        return {
                            x: f,
                            y: h
                        }
                    },
                    rightBottom: function() {
                        return {
                            x: f,
                            y: e
                        }
                    },
                    MidBottom: function() {
                        return {
                            x: g,
                            y: e
                        }
                    },
                    middle: function() {
                        return {
                            x: g,
                            y: h
                        }
                    }
                }
            },
            openWin: function(a) {
                var d = a.substr(a.lastIndexOf("snsType=") + 8, 1);
                4 == d || 5 == d ? (d = 820 < document.body.clientWidth ? (document.body.clientWidth - 820) / 2 : 0, window.open(a, "connect_window", "height=700, width=820, toolbar=no, menubar=no, scrollbars=yes, resizable=no,top=190,left=" + d + ", location=no, status=no")) : 8 == d ? (d = (document.body.clientWidth - 580) / 2, window.open(a, "connect_window", "height=620, width=580, toolbar=no, menubar=no, scrollbars=yes, resizable=no,top=190,left=" + d + ", location=no, status=no")) : 9 == d ? (d = 900 < document.body.clientWidth ? (document.body.clientWidth - 900) / 2 : 0, window.open(a, "connect_window", "height=550, width=900, toolbar=no, menubar=no, scrollbars=yes, resizable=no,top=190,left=" + d + ", location=no, status=no")) : (d = (document.body.clientWidth - 580) / 2, window.open(a, "connect_window", "height=420, width=580, toolbar=no, menubar=no, scrollbars=yes, resizable=no,top=190,left=" + d + ", location=no, status=no"))
            }
        },
        msg: {}
    });
    a.fn.extend({
        returntop: function() {
            if (this[0]) {
                var b = this.click(function() {
                    a("html, body").animate({
                        scrollTop: 0
                    },
                    120)
                });
                a(window).bind("scroll",
                function() {
                    var d = a(document).scrollTop(),
                    c = a(window).height();
                    0 < d ? b.fadeIn() : b.fadeOut();
                    a.guang.util.isIE6() && b.css("top", d + c - 60)
                })
            }
        },
        resizeImage: function(b, d) {
            this.each(function() {
                var c = a(this)[0],
                e = c.width,
                f = c.height;
                if (! (e <= b && f <= d)) if (e <= b && f > d) c.width = e * d / f,
                c.height = d;
                else if (e > b && f <= d) c.width = b,
                c.height = f * b / e;
                else if (c.width = b, c.height = f * b / e, f * b / e > d) c.width = e * d / f,
                c.height = d
            })
        },
        textareaAutoHeight: function() {
            var b = this,
            d = b.height();
            b.bind("keyup input propertychange focus",
            function() {
                0 > d && (d = b.height()); (a.browser.mozilla || a.browser.safari) && b.height(d);
                var c = b[0].scrollHeight,
                e = c < d ? d: c,
                e = e < 1.5 * d ? d: c;
                b.height(e)
            })
        }
    })
})(jQuery); (function(a) {
    function b(b, d) {
        var e = b.find("ul:eq(0)"),
        f = e.children(),
        g = a(f[0]).outerWidth(),
        h = d.step * g,
        j = function() {
            e.animate({
                opacity: 1
            },
            d.timer,
            function() {
                e.find("li:eq(6)").css("opacity", 0.5);
                e.animate({
                    marginLeft: -1 * h
                },
                d.speed,
                function() {
                    e.find("li:eq(6)").css("opacity", 1);
                    e.find("li:first").appendTo(e);
                    e.css({
                        marginLeft: 0
                    })
                });
                r()
            })
        },
        p = function() {
            e.animate({
                opacity: 1
            },
            d.timer,
            function() {
                e.animate({
                    marginLeft: h
                },
                d.speed,
                function() {
                    e.find("li:last").hide().prependTo(e).fadeIn();
                    e.css({
                        marginLeft: 0
                    })
                });
                r()
            })
        },
        r = function() {
            "left" == d.direction ? j() : p()
        };
        f.length > d.length && r();
        e.hover(function() {
            e.stop()
        },
        r)
    }
    a.fn.feedSlider = function(c) {
        c = a.extend({
            speed: "normal",
            step: 1,
            length: 7,
            timer: 3E3,
            direction: "left"
        },
        c || {});
        return this.each(function() {
            new b(a(this), c)
        })
    }
})(jQuery);(function(a) {
    a.guang.judgement = {
        identityCallback: function() {},
        repeatIdentityClk: function() {},
        identityOper: function(b, d, c) {
            a.ajax({
                url: GUANGER.path + ("0" == c ? "index.php?app=share&ac=do&le=like":"index.php?app=share&ac=do&le=identity"),
                type: "post",
                dataType: "json",
                data: {
                    productId: d,
                    commentType: c
                },
                success: function(k) {
                    switch (k.code) {
                    case 100:
                        a.guang.judgement.identityCallback(b, c);
						$("#flikenum_"+d).html(parseInt($("#flikenum_"+d).html())+1);
                        break;
                    case 101:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show(b, k.msg);
                        break;
                    case 103:
                        a.guang.judgement.repeatIdentityClk(b, k.desirable)
                    }
                }
            })
        },
		
		like_s: function(b, d, c) {
            a.ajax({
                url: GUANGER.path + ("index.php?app=share&ac=do&le=like-s"),
                type: "post",
                dataType: "json",
                data: {
                   postid: d,
                   commentType: c
                },
                success: function(d) {
                    switch (d.code) {
                    case 100:
						$("#J_LikeCount").html(parseInt($("#J_LikeCount").html())+1);
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                        a.guang.tip.show(b, d.msg);
                        break;
                    case 101:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show(b, d.msg);
                        break;
                    case 103:
                        a.guang.judgement.repeatIdentityClk(b, d.desirable)
                    }
                }
            })
        },
		
        cmtSubmitOkClk: function() {},
        cmtSubmitErrorClk: function() {},
        cmtSubmit: function(b, d, c) {
            var e = a.guang.util.trim(c.find("textarea[name='commentContent']").val()),
            f = c.find("input[name='commentType']").val();
            d.find(".error-row");
            $this = c;
            "" != e ? 256 > a.guang.util.getStrLength(e) ? a.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=comment",
                type: "post",
                dataType: "json",
                data: {
                    productId: b,
                    commentContent: e,
                    commentType: f
                },
                success: function(k) {
                    switch (k.code) {
                    case 100:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                        a.guang.tip.show($this, "\u8bc4\u8bba\u53d1\u8868\u6210\u529f\uff01");
						$("#fcnum_"+b).html(parseInt($("#fcnum_"+b).html())+1);
                        a.guang.judgement.cmtSubmitOkClk();
                        break;
                    case 101:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        a.guang.tip.show($this, b.msg),
                        a.guang.judgement.cmtSubmitErrorClk()
                    }
                }
            }) : (a.guang.tip.conf.tipClass = "tipmodal tipmodal-general", a.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u8d85\u8fc7256\u4e2a\u6c49\u5b57\uff01")) : (a.guang.tip.conf.tipClass = "tipmodal tipmodal-general", a.guang.tip.show($this, ">_< \u8bc4\u8bba\u5185\u5bb9\u4e0d\u80fd\u4e3a\u7a7a\uff01"))
        }
    };
	
	    a.guang.tipForOper = {
        conf: {
            html: ""
        },
        init: function() {
            a("#J_TipForOper")[0] ? a("#J_TipForOper").data("overlay").load() : (a("body").append('<div id="J_TipForOper" class="g-dialog tip-for-oper"><div class="dialog-content"><div class="bd clearfix"></div></div></div>'), a("#J_TipForOper").overlay({
                top: "center",
                mask: {
                    color: "#000",
                    loadSpeed: 200,
                    opacity: 0.3
                },
                closeOnClick: !1,

                load: !0
            }));
            a("#J_TipForOper").find(".bd").html(a.guang.tipForOper.conf.html);
            a("#J_TipForOper .closeD").click(function() {
                a("#J_TipForOper").overlay().close()
            })
        }
    };
	
    a.guang.dialog = {
	
		  
		  
		   add_tag: function() {
				  var b;
                b = '<div id=\"add_tags\"class=\"g-dialog\"style=\"width:330px;\"><div class=\"dialog-content\"><div class=\"hd\"><h3>&#x6DFB;&#x52A0;&#x4E2A;&#x4EBA;&#x6807;&#x7B7E;</h3></div><div class=\"bd clearfix\"><div class=\"add_tag_m\"><input type=\"text\"class=\"base-input\" style=\"width:230px\"name=\"tags\"id=\"tags\"value=\"\" placeholder=\"&#x591A;&#x4E2A;&#x6807;&#x7B7E;&#x7528;&#x7A7A;&#x683C;&#x6216;&#x8005;,&#x53F7;&#x9694;&#x5F00;\"><div style=\"position:absolute; top:63px; right:10px;\"><a href=\"javascript:void(0);\" class=\"bbl-btn submit\">&#x786E;&#x5B9A;</a></div></div><div class=\"addgoods-loading\">&nbsp;</div></div>';
                a("body").append(b+'<a class=\"close\"href=\"javascript:;\"></a></div></div>');
				 a("#add_tags").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
				$(".close").live("click",function(){
					a("#add_tags").remove()
	});
				a(".submit").click(function() {
					$this = a(this);
					$thismsg = a(".dialog-content");
					var tags = a("#tags").val()
					if (tags){
					 a(".add_tag_m").hide()
				   	 a(".addgoods-loading").show() 
					$.ajax({
				   url: GUANGER.path+"index.php?app=tag&ac=add_ajax&ts=do",
				   type : "post",
				   dataType: "json",
				   data: {
					  tags : tags,
					  objname:'user',
					  idname:'userid',
					  objid:GUANGER.userId
				   },
				   success: function(data){
					   var $json = data;
					   switch($json.status){
					   case(1):
					    setTimeout(function() {
											history.go(0) 
											}
											,100)
						
						  break;
					   case(0):
					  	  
						$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($thismsg,$json.msg);
						a(".addgoods-loading").hide()
						a(".add_tag_m").show()
					   	break;
					   }  
				   }
			});

  }
			});
		   },
		   
		   
		   upfileimg: function() {
				  var b;
                b = '<div id=\"upfileimgs\"class=\"g-dialog\"style=\"width:330px;\"><div class=\"dialog-content\"><div class=\"hd\"><h3>&#x8BBE;&#x7F6E;&#x98CE;&#x683C;</h3></div><div class=\"bd clearfix\"><div class=\"upfileimg_m\"><form method=\"POST\" action=\"'+GUANGER.path+'index.php?app=zhuti&ac=add_ajax&ts=upfileimg\" enctype=\"multipart/form-data\"id=\"selector\"><input type="file" name="picfile"id=\"picfile\"/><br><br>&#x6807;&#x9898;&#x989C;&#x8272;：<input name=\"titlecolor\" value=\"'+ GUANGER.titlecolor +'\" /><br><br>&#x80CC;&#x666F;&#x989C;&#x8272;：<input name=\"backcolor\" value=\"'+ GUANGER.backcolor +'\" /><br><br>&#x7B80;&#x4ECB;&#x989C;&#x8272;：<input name=\"desccolor\" value=\"'+ GUANGER.desccolor +'\" /><div style=\"position:absolute; top:160px; right:10px;\"><input name=\"themeid\" value=\"'+ GUANGER.themeid +'\" type=\"hidden\" /><a href=\"javascript:void(0);\" class=\"bbl-btn submit\">&#x786E;&#x5B9A;</a></form></div></div><div class=\"addgoods-loading\">&nbsp;</div></div>';
                a("body").append(b+'<a class=\"close\"href=\"javascript:;\"></a></div></div>');
				 a("#upfileimgs").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
				$(".close").live("click",function(){
					a("#upfileimgs").remove()
	});
				a(".submit").click(function() {
					$this = a(this);
					$("#selector").submit();
			});
		   },
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
		    add_pic: function() {
				  var b;
                b += '<div id="Add_pic" class="g-dialog ugc-dialog">',
                b += '<div class="dialog-content">',
                b += '<div class="hd"><h3>分享图片</h3></div>',
                b += '<div class="bd clearfix">',
                b += '<form id="J_GoodsPubForm" action="' + GUANGER.path + 'index.php?app=share&ac=do&le=add_pic" method="POST">',
				 b += '<div class="form-row clearfix">',
                b += '<div class="goods-gallery"><div class="gallery-bd"><div class="fl" style="height:140px; width:140px;box-shadow: 0 0 4px rgba(180,180,180,0.3);border:#CCC 1px solid;"><div id="loadingImg0"></div> <img id="thumb0" style="display:none;"/></div><div class="fl"><input class="bbl-btn ml15" value="+ 上传图片 +" type="button"><input class="tfile PUB_PIC_FILE" name="uploadShareImg" type="file" id="uploadShareImg" onchange="return UploadShareImg();"><input type="hidden" name="img_url" value="" id="img_url" /><div class="form-roww"><textarea class="base-txa" name="content" placeholder="\u559c\u6b22\u5b83\u4ec0\u4e48\u5462\uff1f"></textarea></div></div></div></div>',
                b += "</div>",
				b += '<div class="form-row"><label>选择分类\uff1a</label>',
                b += '<span class="goodsNm"><input type="text" class="base-input select" name="catename" readonly="readonly" value="请选择图片的分类" /></span>',
			    b += '<div id="pannel" class="pannel" style="width:388px;"></div>',
                b += "</div>",
				b += '<div class="form-row"><label>推广链接\uff1a</label>',
                b += '<span class="goodsNm"><input type="text" class="base-input" name="taoke_url" value="" /></span>',
                b += "</div>",
				b += '<div class="form-row"><label>添加价格\uff1a</label>',
                b += '<span class="goodsNm"><input type="text" class="base-input" name="price" value="￥" /></span>',
                b += "</div>",
                b += '<div class="form-row"><label>添加标签\uff1a</label>',
                b += '<div class="inlineblock"><input type="text" class="base-input" name="tags" value="" />',
                b += '<p class="pt5 gc">\u591a\u4e2a\u6807\u7b7e\u7528\u4e2d\u6587\u6216\u82f1\u6587\u9017\u53f7\u9694\u5f00</p></div>',
                b += "</div>",
              
                b += '<div class="goods-act">',
                b += '<div class="clearfix"><a class="bbl-btn" id="J_GoodsPub" href="javascript:;">\u53d1\u5e03</a>',
                b += '<div class="errc mt10"></div>',
                b += "</div>",
                b += "</form>",
                b += "</div>",
                b += '<a class="close" href="javascript:;"></a>',
                b += "</div>",
                b += "</div>",
                a("body").append(b);
				 a("#Add_pic").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
				$(".close").live("click",function(){
					a("#Add_pic").remove()
	});
				a("#J_GoodsPub").click(function() {
					$("#J_GoodsPubForm").submit();
			});
		   },
		   
		   
		    join_group: function(groupid) {
				$thismsg = a(".join_group");
					var url = GUANGER.path+'index.php?app=group&ac=do&ts=joingroup';
			$.post(url,{groupid:groupid},function(rs){
				if(rs == 1){
				 $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
				$.guang.tip.show($thismsg,"您已经加入");
			  }else if(rs == 2){
				window.location.reload(); 
			  }
		})
		   
		   	   },
			   
			   
			    out_group: function(groupid) {
				$thismsg = a(".join_group");
					var url = GUANGER.path+'index.php?app=group&ac=do&ts=exitgroup';
			$.post(url,{groupid:groupid},function(rs){
				if(rs == 0){
				 $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
				$.guang.tip.show($thismsg,"组长责任重大！");
			  }else if(rs == 1){
				window.location.reload(); 
			  }
		})
		   
		   	   },
			   
			   
			   
	
	        add_good: function(f) {
			f = f?f:0;
            if (a("#Add_good")[0]) a("#Add_good").data("overlay").load();
            else {
                var b;
                b = '<div id=\"Add_good\"class=\"g-dialog\"><div class=\"dialog-content\"><div class=\"hd\"><h3>&#x5206;&#x4EAB;&#x5546;&#x54C1;</h3></div><div class=\"bd clearfix\"><div class=\"good_img\"></div><div class=\"add_good_m\"><input type=\"text\"class=\"base-input\" style=\"width:412px\"name=\"g_url\"id=\"g_url\"value=\"\"placeholder=\"&#x5C06;&#x5546;&#x54C1;&#x7F51;&#x5740;&#x7C98;&#x8D34;&#x5230;&#x8BE5;&#x6846;&#x4E2D;&#x5373;&#x53EF;\"><br><br><a href=\"http://www.taobao.com\" target=\"_blank\" title=\"&#x6DD8;&#x5B9D;\" class=\"taob\" style=\"background-image:url('+ GUANGER.path +'images/taobao.gif);\">&#x6DD8;&#x5B9D;</a><a href=\"http://www.tmall.com\" target=\"_blank\" title=\"&#x5929;&#x732B;&#x5546;&#x57CE;\" class=\"taob\" style=\"background-image:url('+ GUANGER.path +'images/tianmao.gif);\">&#x5929;&#x732B;&#x5546;&#x57CE;</a><!--<a href=\"http://www.paipai.com\" target=\"_blank\" title=\"&#x62CD;&#x62CD;\" class=\"taob\" style=\"background-image:url('+ GUANGER.path +'images/paipai.gif);\">&#x62CD;&#x62CD;</a>--><div style=\"position:absolute; top:49px; right:10px;\"><a href=\"javascript:void(0);\" class=\"bbl-btn submit\">&#x786E;&#x5B9A;</a></div></div><div class=\"addgoods-loading\">&nbsp;</div></div>';
                a("body").append(b+'<a class=\"close\"href=\"javascript:;\"></a></div></div>');
                a("#Add_good").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
				 a("#Add_good").css('position','absolute');
                a(".submit").click(function() {
                    $this = a(this);
					$thismsg = a(".dialog-content");
					
					var url = a("#g_url").val()
					if (url){
					

					
					$.ajax({
				   url: GUANGER.path+"index.php?app=share&ac=ajax",
				   type : "post",
				   dataType: "json",
				   data: {
					  url : url
				   },
				    beforeSend: function() {
                            a(".add_good_m").hide()
				   			a(".addgoods-loading").show() 
                        },
				   success: function(data){
					   var $json = data;
					   switch($json.status){
					   case(1):
					   var c;
					   
					    if($json.cate_name){
							$cateinfo = $json.cate_name;
						   }else{
							   
							$cateinfo = '发现喜欢（未找到合适分类）';
							   
						   }
					   

					   c = "<div class=\"form-row\"><label>\u5b9d\u8d1d\u540d\u79f0\uff1a</label><input type=\"text\"id=\"pname\"class=\"base-input\"name=\"pname\"value=\""+$json.name+"\"/></div><div class=\"form-row\"><label>\u8bc4\u8bba\u4e00\u4e0b\uff1a</label><textarea class=\"base-txa\"name=\"comment\"id=\"comment\"placeholder=\"\u559c\u6b22\u5b83\u4ec0\u4e48\u5462\uff1f\"></textarea></div><div class=\"form-row\"><label>\u5b9d\u8d1d\u6807\u7b7e\uff1a</label><div class=\"inlineblock\"><input type=\"text\"id=\"tags\"class=\"base-input\"name=\"tags\"value=\"\"/><div class=\"goodstags\"><ul>"+ $json.tags +"</ul></div></div></div><div class=\"form-row clearfix\"><label>选择分类：</label><span class=\"goodsNm\"style=\padding:0px;\"><input type=\"text\" class=\"base-input select\"id=\"catename\" name=\"catename\" readonly=\"readonly\" value=\""+ $cateinfo +"\"></span><div id=\"pannel\" class=\"pannel\" style=\"width:388px;\"></div></div><div class=\"form-row clearfix\"><label>\u5b9d\u8d1d\u56fe\u7247\uff1a</label><textarea style=\"display:none\" name=\"info\"id=\"info\">"+ $json.info +"</textarea><input id=\"cate_id\" value=\""+ $json.cate_id +"\" type=\"hidden\" /><input id=\"themeid\" value=\""+ f +"\" type=\"hidden\" /><input id=\"defaulttags\" value=\""+ $json.defaulttags +"\" type=\"hidden\" /><div class=\"goods-gallery\"><div class=\"gallery-bd\"><div class=\"items\"><ul>"+ $json.pic_url +"</ul></div></div><div class=\"gallery-ft clearfix\"><span class=\"status\">已选 <em>0</em> 张</span><span class=\"errc\"></span><a href=\"javascript:;\" id=\"J_AddPicBtn\" class=\"ap-btn sgr-btn\" style=\"display: none; \">上传本地图片</a></div></div></div><div class=\"goods-act\"><div class=\"clearfix\"><a class=\"bbl-btn save_goods\"href=\"javascript:;\">\u53d1\u5e03</a></div><div class=\"errc mt10\"></div></div>"

	
											a(".addgoods-loading").hide()
											 a("#Add_good").css({
												top: 50 + "px"
											});
											a(".good_img").append(c)

						
						  break;
						  
						  
						  	   case(2):
							   var e
							   a("#Add_good").remove();
							  
							     e = '<div id="J_GoodsExistD" class="g-dialog"><div class="dialog-content"><div class="hd"><h3>\u5df2\u7ecf\u6709\u8fd9\u4e2a\u5b9d\u8d1d\u5566</h3></div><div class="bd clearfix">' + ('<form id="J_GoodsExistForm" action="' + GUANGER.path + 'index.php?app=share&ac=do&le=comment" method="POST">');
							   
					   		   e = e + '<div class="clearfix"><div class="goods-avatar"><a href="' + $json.URL + '" target="_blank" title="' + $json.name + '"><img src="' + GUANGER.path+$json.img + '" alt="' + $json.name + '" /></a>';
                e = e + '</div><div class="goods-info"><p class="goodsNm"><a href="' + $json.URL + '" target="_blank" title="' + $json.name + '">' + $json.name + '</a></p>';
				
				 a("body").append(e + '<p class="pb5">\u8bc4\u8bba\u4e00\u4e0b\uff1a</p><p><textarea class="base-txa" name="proComment" id="proComment" placeholder="\u559c\u6b22\u5b83\u4ec0\u4e48\u5462\uff1f"></textarea></p><p><input type="hidden" class="base-input" id="goods_id" value="'+ $json.goods_id +'" /></p></div></div><div class="goods-act"><div class="clearfix"><a class="bbl-btn" id="J_GoodsSave" href="javascript:;">\u786e\u5b9a</a></div></div></form><div class=\"addgoods-loading\">&nbsp;</div></div><a class="close" href="javascript:;"></a></div></div>');
				 a("#J_GoodsExistD").css("z-index","9999");
				a("#J_GoodsExistD").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
				
				a("#J_GoodsSave").unbind().bind("click",
                function() {
                    $this = a(this);
                    var $commentContent = a("#proComment").val();
					var $goods_id = a("#goods_id").val();
					var $commentType = 0;
                    a.ajax({
                        url: a("#J_GoodsExistForm").attr("action"),
                        type: "post",
                        dataType: "json",
                        data: {
                            productId: $goods_id,
							commentContent: $commentContent,
							commentType: $commentType,
							andlike: 1
							
                        },
                        beforeSend: function() {
							a("#J_GoodsExistForm").hide()
                           a(".addgoods-loading").show()
                        },
                     	success: function(data){
					   var $json = data;
					   if($json.code == 100){
							window.location.href=GUANGER.path+$json.backurl;

					   }else if($json.code == 101){
						$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($thismsg,">_< "+$json.msg);
						a(".addgoods-loading").hide()
						a("#J_GoodsExistForm").show()
					   }  
				   }
                    });
                    return ! 1
                });		
						
						  break;
						  
						  
					   case(0):
					  	  
						$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($thismsg,$json.msg);
						a(".addgoods-loading").hide()
						a(".add_good_m").show()
					   	break;
					   }  
				   }
			});
					
						

				   }
                });
				
			
				

				
				
				  a(".save_goods").live("click",function(){
                    $this = a(this);
					$thismsg = a(".dialog-content");
					  var img = [];
					  $("#Add_good li.selected").each(function() {
                     img.push($(this).find("img").attr("src"))
                    });
					var name = $("#pname").val();
					var tags = $("#tags").val();
					var defaulttags = $("#defaulttags").val();
					var cate_id = $("#cate_id").val();
					var info = $("#info").val();
					var themeid = $("#themeid").val();
					var comment = $("#comment").val();
					var catename = $("#catename").val();

					if(img && name && cate_id){
				$.ajax({
				   url: GUANGER.path+"index.php?app=share&ac=do&le=add_good",
				   type : "post",
				   dataType: "json",
				   data: {
					  img       : img,
					  name      : name,
					  tags      : tags,
					  defaulttags: defaulttags,
					  comment   : comment,
					  info      : info,
					  catename   : catename,
					  cate_id   : cate_id,
					  themeid   : themeid
				   },
				  beforeSend: function() {
                           a(".good_img").hide()
							a(".addgoods-loading").show()
                        },
				   success: function(data){
					   var $json = data;
					   if($json.status == 1){
						   if($json.themeid>0){
							setTimeout(function() {
								history.go(0)
												}
												,1) 
						   }else{
							   
							   	setTimeout(function() {
												window.location.href=GUANGER.path+$json.backurl;
												}
												,1) 
						   }
					   }else if($json.status == 0){
						$.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
						$.guang.tip.show($thismsg,">_< "+$json.msg);
						a(".addgoods-loading").hide()
						a(".good_img").show()
					   }  
				   }
			});
						
					}
					else{
					 $.guang.tip.conf.tipClass = "tipmodal tipmodal-general";
					$.guang.tip.show($this,">_< &#x6570;&#x636E;&#x4E0D;&#x5168;&#xFF0C;&#x65E0;&#x6CD5;&#x63D0;&#x4EA4;");
					
					}
                });
				
	$(".close").live("click",function(){
					a("#Add_good").remove()
	});
				
                a(".snslogin a").unbind("click").click(function() {
                    var b = a(this).attr("href");
                    a.guang.util.openWin(b);
                    return ! 1
                });
                a("#Add_good").overlay().getClosers().bind("click",
                function() {
                  
                    a("#Add_good").find(".error-row").hide()
                })
            }
        },
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
        isLogin: function() {
            return "" == GUANGER.userId ? (a.guang.dialog.login(), !1) : !0
        },
        login: function() {
            if (a("#loginDialog")[0]) a("#loginDialog").data("overlay").load();
            else {
                var b;
                b = '<div id="loginDialog" class="g-dialog"><div class="dialog-content"><div class="hd"><h3>\u767b\u5f55</h3></div><div class="bd clearfix"><div class="bd-l">' + ('<form id="J_LoginDForm" action="' + GUANGER.path + 'index.php?app=user&ac=login&ts=do" method="POST">');
                b = b + '<div class="error-row"><p class="error"></p></div><div class="form-row"><label>Email\uff1a</label><input type="text" class="base-input" name="email" id="email" value="" placeholder="" /></div><div class="form-row"><label>\u5bc6\u7801\uff1a</label><input type="password" class="base-input" name="pwd" id="pwd" value="" /></div><div class="form-row"><label>&nbsp;</label><input type="checkbox" class="check" name="cktime" value="1209600" checked="checked" /><span>\u4e24\u5468\u5185\u81ea\u52a8\u767b\u5f55</span></div><div class="form-row clearfix"><label>&nbsp;</label><input type="submit" class="bbl-btn login-submit" value="\u767b\u5f55" />' + ('<a class="ml10 l30" href="' + GUANGER.path + 'index.php/user/forgetpwd">\u5fd8\u8bb0\u5bc6\u7801\uff1f</a></div>');
                b += '<div class="noaccount">\u8fd8\u6ca1\u6709\u5e10\u53f7\uff1f<a href="' + GUANGER.path + 'index.php/user/register">\u514d\u8d39\u6ce8\u518c\u4e00\u4e2a</a></div>';
                  b = b + '</form></div><div class="bd-r"><p>\u4f60\u4e5f\u53ef\u4ee5\u4f7f\u7528\u8fd9\u4e9b\u5e10\u53f7\u767b\u5f55</p><div class="snslogin mt15 clearfix"><ul class="fl mr20 outlogin-b">' + ('<li><a class="l-qq" href="' + GUANGER.path + 'index.php?app=pubs&ac=plugin&plugin=qq&in=qq_login">QQ\u5e10\u53f7\u767b\u5f55</a></li><li><a class="l-sina" href="' + GUANGER.path + 'index.php?app=pubs&ac=plugin&plugin=sina&in=sina_login">新浪微博\u5e10\u53f7\u767b\u5f55</a></li><li><a class="l-tao" href="' + GUANGER.path + 'index.php?app=pubs&ac=plugin&plugin=taobao&in=tb_login">淘宝\u5e10\u53f7\u767b\u5f55</a></li>');
              
              
                b = b + '</ul><ul class="fl outlogin-s share-link">' + ('');
                a("body").append(b + '</ul></div></div></div><a class="close" href="javascript:;"></a></div></div>');
                a("#loginDialog").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
              
                a(".snslogin a").unbind("click").click(function() {
                    var b = a(this).attr("href");
                    a.guang.util.openWin(b);
                    return ! 1
                });
                a("#loginDialog").overlay().getClosers().bind("click",
                function() {
                    a("#J_LoginDForm")[0].reset();
                    a("#loginDialog").find(".error-row").hide()
                })
            }
        },
        reg: function() {
            if (a("#setDialog")[0]) a("#setDialog").data("overlay").load();
            else {
                var b;
                a("body").append('<div id="setDialog" class="g-dialog"><div class="hd"><h3>\u6b22\u8fce</h3><a class="close" href="javascript:;">X</a></div><div class="bd"><div class="set-box"><div class="title-info clearfix"><div class="face"><img src="../img/face.jpg" width="50" height="50" alt="" /></div><div class="info"><span class="name">Hi\uff0c\u6b22\u8fce\u6765\u5230\u901b.com~</span><p>\u5feb\u901f\u8bbe\u7f6e\u4e00\u4e2a\u90ae\u7bb1\u5e10\u53f7\uff0c\u65b9\u4fbf\u4ee5\u540e\u76f4\u63a5\u767b\u5f55\u548c\u627e\u56de\u5bc6\u7801</p></div></div><form class="set-form" action=""><div class="form-row"><label>\u6635\u79f0\uff1a</label><input type="text" class="base-input" name="nick" id="nick" value="" /></div><div class="form-row"><label>\u90ae\u7bb1\uff1a</label><input type="text" class="base-input" name="email" id="email" value="" placeholder="\u7528\u4e8e\u767b\u5f55\u548c\u627e\u56de\u5bc6\u7801" /></div><div class="form-row"><label>&nbsp;</label><input type="submit" class="bbl-btn reg-submit" value="\u5b8c\u6210" /></div><div class="form-row"><label>&nbsp;</label><input type="checkbox" class="check" name="remember" value="1" checked="checked" /><span>\u6211\u5df2\u9605\u8bfb\u5e76\u540c\u610f<a href="#">\u300a\u4f7f\u7528\u534f\u8bae\u300b</a></span></div></form></div></div></div>');
                a("#setDialog").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                })
            }
        },
        lkCommentSubmitOkClk: function() {},
        lkComment: function(b,f) {
            var d = a("#J_HiddenProductId").val();
            if (a("#cmtDialog")[0]) a("#cmtDialog").find("textarea").val(""),
            a("#cmtDialog").fadeIn();
            else {
                var c;
               a("body").append('<div id="cmtDialog" class="c-dialog"><p class="title clearfix"><a class="cmtclose fr" href="javascript:;">x</a>'+ f +'~</p><div id="cmt-form"><div class="error-row error-like"><p class="error"></p></div><div><textarea class="cmt-txa" id="lkcommentContent" name="lkcommentContent" placeholder="\u8bf4\u8bf4\u559c\u6b22\u7684\u7406\u7531\u5427~"></textarea><input type="hidden" name="commentType" value="0"/></div><div class="cmt-act tar"><input type="submit" id="lkCommentSubmit" class="pub" value="\u53d1\u5e03"/></div></div>');
                a(".cmt-txa").focus(function() {
                    var b = a("#cmtDialog").offset().top;
                    a("#cmtDialog").css({
                        top: b - 50 + "px",
                        height: 104
                    });
                    a(this).height(50);
                    a(".cmt-txa").unbind("focus")
                })
            }
            c = a.guang.util.getPosition(b).topMid();
            var e = a("#cmtDialog").outerWidth(),
            f = a("#cmtDialog").outerHeight();
            a("#cmtDialog").css({
                left: c.x - e / 2 + "px",
                top: c.y - f - 12 + "px"
            }).fadeIn();
           a("#lkCommentSubmit").unbind("click").click(function(c) {
                c.preventDefault();
                a("#J_HiddenProductId")[0] || (d = b.attr("data-proid"));
                a.guang.judgement.cmtSubmitOkClk = function() {
                    a("#cmtDialog").fadeOut();
                    a.guang.dialog.lkCommentSubmitOkClk(a.guang.util.trim(a("#cmtDialog").find("textarea[name='lkcommentContent']").val()))
                };
                a.guang.judgement.cmtSubmit(d, a("#cmtDialog"), a("#cmt-form"), "like")
            });
            a(".cmtclose").unbind("click").click(function() {
                a("#cmtDialog").fadeOut()
            })
        },
        commentSubmitOk: function() {},
        comment: function(b) {
            var d = b.attr("data-type"),
            c = a("#J_HiddenProductId").val();
            a("#commentDialog")[0] ? (a("#commentDialog").data("overlay").load(), a("#commentDialog").find("textarea").text("")) : (a("body").append('<div id="commentDialog" class="g-dialog"><div class="dialog-content"><div class="hd"><h3>\u6dfb\u52a0\u8bc4\u8bba</h3></div><div class="bd clearfix"><div id="comment-form"><div class="error-row error-worth"><p class="error worth-error"></p></div><div class="form-row">' + ('<textarea class="b-textarea cmt-txa" name="commentContent" placeholder="\u8bf4\u8bf4\u4f60\u7684\u7406\u7531\u5427~"></textarea><input type="hidden" name="commentType" value="' + d + '"/></div>') + '<div class="clearfix"><input type="submit" class="bbl-btn pub" id="J_WorthCommentSubmit" value="\u53d1\u5e03"/></div></div></div><a class="close" href="javascript:;"></a></div></div>'), a("#commentDialog").overlay({
                top: "center",
                mask: {
                    color: "#000",
                    loadSpeed: 200,
                    opacity: 0.3
                },
                closeOnClick: !1,
                load: !0
            }), a("#J_WorthCommentSubmit").click(function() {
                a("#J_HiddenProductId")[0] || (c = b.attr("data-proid"));
                a.guang.judgement.cmtSubmitOkClk = function() {
                    a("#commentDialog").overlay().close()
                };
                a.guang.judgement.cmtSubmit(c, a("#commentDialog"), a("#comment-form"), "worth")
            }))
        }
    }
})(jQuery); (function(a) {
    a.guang.goods = {
        conf: {
            distance: 400,
            timeout: null,
            timeoutLength: 2E3,
            timeoutLengthMax: 32E3,
            page: 1,
            container: ".goods-block",
            colArray: [],
           containerW:980,columns:4,columnWidthInner:210,columnMargin:20,columnPadding:20,columnWidthOuter:250,
            ajaxUrl: GUANGER.path + "index.php?app=xihuan",
            ajaxData: {
                spage: null,
                bpage: null,
                cateId: null,
                tagId: null,
                userId: null
            }
        },
        init: function() {
            var b = a.guang.goods,
            d = a.guang.goods.conf;
            d.columnWidthOuter = d.columnWidthInner + d.columnMargin + d.columnPadding;
            if (0 == d.colArray.length) for (var c = 0; c < d.columns; c++) d.colArray[c] = 0;
            d = a(".goods-wall").find(".goods");
            1 < d.length ? b.flowGoods(d) : b.ajaxLoad();
            a(window).bind("scroll", b.lazyLoad);
            d.live("mouseover mouseout",
            function(b) {
                var c = a(this);
                if (b.type == "mouseover") {
                    c.css({
                        color: "#666",
                        "box-shadow": "0 1px 2px rgba(35,25,25,0.5)",
                        "-moz-box-shadow": "0 1px 2px rgba(35,25,25,0.5)",
                        "-webkit-box-shadow": "0 1px 2px rgba(35,25,25,0.5)"
                    });
                    c.find(".ilike-m")[0] && c.find(".ilike-m").show();
                    c.find(".ilike-del")[0] && c.find(".ilike-del").show();
                    c.find(".ilike-topic")[0] && c.find(".ilike-topic").show()
                } else {
                    c.css({
                        color: "#999",
                        "box-shadow": "0 1px 2px rgba(34,25,25,0.2)",
                        "-moz-box-shadow": "0 1px 2px rgba(34,25,25,0.2)",
                        "-webkit-box-shadow": "0 1px 2px rgba(34,25,25,0.2)"
                    });
                    c.find(".ilike-m")[0] && c.find(".ilike-m").hide();
                    c.find(".ilike-del")[0] && c.find(".ilike-del").hide();
                    c.find(".ilike-topic")[0] && c.find(".ilike-topic").hide()
                }
            })
        },
		 isLoading: !1,
        lazyLoad: function() {
            var b = a.guang.goods,
            d = a.guang.goods.conf,
            c = a(document).height() - a(window).scrollTop() - a(window).height();
            if (!b.isLoading && c < d.distance) b.isLoading = !0,
            b.ajaxLoad()
        },
      setTimeout: function() {
            var b = a.guang.goods,
            d = a.guang.goods.conf;
            d.timeout = setTimeout(function() {
                b.ajaxLoad()
            },
            d.timeoutLength)
        },
        resetTimeout: function() {
            var b = a.guang.goods,
            d = a.guang.goods.conf;
            if (3E3 < d.timeoutLength) d.timeoutLength = 3E3,
            window.clearTimeout(d.timeout),
            b.setTimeout()
        },
		ajaxLoad: function() {
            var b = a.guang.goods,
            d = a.guang.goods.conf;
            a.guang.goods.conf.ajaxData.spage = d.page;
            a(".goods-loading").show();
            a.post(d.ajaxUrl, d.ajaxData,
            function(c) {
                var e = a("<div>" + c + "</div>").find(".goods"),
                f = a("<div>" + c + "</div>").find(".J_HiddenSpage:last").val(),
                c = a("<div>" + c + "</div>").find(".J_HiddenIsEnd:last").val();
                b.flowGoods(e);
                d.page += 1;
                b.isLoading = !1;
                if (6 == d.page || "true" == c || "5" == f) b.fill(),
                a(".goods-loading").remove(),
                a(".page-box").show(),
                a(window).unbind("scroll", b.lazyLoad)
            })
        },
        flowGoods: function(b) {
            var d = a.guang.goods,
            c = a.guang.goods.conf;
            a(".goods-wall").append('<div class="goods-block"></div>');
            b.each(function() {
                var b = a(this)[0],
                d = jQuery.inArray(Math.min.apply(Math, c.colArray), c.colArray),
                g = c.colArray[d];
                b.style.top = g + "px";
                b.style.left = d * c.columnWidthOuter + "px";
                a(c.container + ":last").append(b);
                c.colArray[d] = g + b.offsetHeight + c.columnMargin
            });
            a(".goods-wall")[0].style.height = Math.max.apply(Math, c.colArray) + "px";
            d.showGoods()
        },
        showGoods: function() {
            a(a.guang.goods.conf.container + ":last").animate({
                opacity: "1"
            },
            500)
        },
        fill: function() {
            for (var b = a.guang.goods.conf,
            d = Math.max.apply(Math, b.colArray), c = jQuery.inArray(d, b.colArray), e = 0; e < b.columns; e++) e != c && a(b.container + ":last").append('<div class="goods-fill" style="top:' + b.colArray[e] + "px;left:" + e * b.columnWidthOuter + "px;height:" + (d - b.colArray[e] - b.columnMargin) + 'px"></div>')
        }
    }
})(jQuery); (function(a) {
    function b(b, f) {
        var g = this,
        h = b.find(":input").not(":button, :image, :reset, :submit");
        a.each(d,
        function() {
            var b = this,
            d = b[0],
            e = b[1],
            k = b[2];
            if (h.filter(a(d))) {
                var j = a(d);
                j.data("vali", 0);
                "info" == k ? j.bind(f.infoEvent,
                function() {
                    c.effects(j, e, k)
                }) : j.bind(f.valiEvent,
                function() {
                    b[3].call(g, j, j.val()) ? "error" == k && (j.data("vali", 1), c.effects(j, "OK", "correct")) : (j.data("vali", 0), c.effects(j, e, k))
                })
            }
        });
        a("input[name=email]")[0] && a("input[name=email]").bind("blur",
        function() {
            var b = a(this);
            1 == b.data("vali") && 11 != b.data("vali") && (b.data("vali", 0), c.effects(b, "", "ajax"), a.ajax({
                type: "post",
                url: GUANGER.path + "index.php?app=user&ac=do&ts=inemail",
                dataType: "json",
                data: "email=" + b.val(),
                success: function(a) {
                    0 == a.code ? (b.data("vali", 11), c.effects(b, "OK", "correct")) : 1 == a.code ? (b.data("vali", 0), c.effects(b, "\u6b64Email\u5df2\u88ab\u6ce8\u518c", "error")) : (b.data("vali", 0), c.effects(b, "\u7cfb\u7edf\u51fa\u9519\u4e86\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\u2026", "error"))
                }
            }))
        });
        a("input[name=username]")[0] && a("input[name=username]").bind("blur",
        function() {
            var b = a(this);
            1 == b.data("vali") && 11 != b.data("vali") && (b.data("vali", 0), c.effects(b, "", "ajax"), a.ajax({
                type: "post",
                url: GUANGER.path + "index.php?app=user&ac=do&ts=isusername",
                dataType: "json",
                data: "username=" + b.val(),
                success: function(a) {
                    0 == a.code ? (b.data("vali", 11), c.effects(b, "OK", "correct")) : 2 == a.code ? (b.data("vali", 0), c.effects(b, "\u6b64\u6635\u79f0\u5df2\u88ab\u6ce8\u518c", "error")) : (b.data("vali", 0), c.effects(b, "\u7cfb\u7edf\u51fa\u9519\u4e86\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\u2026", "error"))
                }
            }))
        });
        a("input.check")[0] && a("input.check").click(function() { ! 1 == a(this)[0].checked ? (a("input[type=submit]")[0].disabled = "disabled", a("input[type=submit]").removeClass("bbl-btn").addClass("disabled")) : (a("input[type=submit]")[0].disabled = "", a("input[type=submit]").removeClass("disabled").addClass("bbl-btn"))
        });
        b.submit(function() {
            var b = !0;
            h.each(function() {
                0 == a(this).data("vali") && (b = !1)
            });
            b || h.trigger("blur");
            a("input.check")[0] && !1 == a("input.check")[0].checked && (b = !1);
            return b
        })
    }
    a.guang.validator = {
        conf: {
            infoEvent: "focus",
            valiEvent: "blur",
            speed: 100
        },
        message: {},
        fn: function(b, c, g, h) {
            a.isFunction(c) && (h = c, c = "");
            d.push([b, c, g, h])
        },
        effects: function(b, c, d) {
            if (!b.next("span")[0]) {
                b.after('<span class="tip"></span>');
                var h = a.guang.util.getPosition(b).rightTop();
                b.next("span").css({
                    left: h.x + 10 + "px",
                    top: h.y + "px"
                })
            }
            switch (d) {
            case "info":
                b.next(".tip").removeClass().addClass("tip").html(c).fadeIn();
                break;
            case "require":
                b.next(".tip").removeClass().addClass("tip error").html(c).fadeIn();
                b.unbind("focus");
                break;
            case "error":
                b.next(".tip").removeClass().addClass("tip error").html(c).fadeIn();
                b.unbind("focus");
                break;
            case "ajax":
                b.next(".tip").removeClass().addClass("tip ajaxvali").html("").fadeIn();
                b.unbind("focus");
                break;
            case "correct":
                b.next(".tip").removeClass().addClass("tip correct").html("").fadeIn(),
                b.unbind("focus")
            }
        }
    };
	
    var d = [],
    c = a.guang.validator;
    c.fn("input[name=email]", "\u8bf7\u8f93\u5165\u4f60\u7684\u5e38\u7528Email", "info");
    c.fn("input[name=email]", "Email\u683c\u5f0f\u4e0d\u6b63\u786e", "error",
    function(b, c) {
        return a.guang.util.isEmail(c)
    });
    c.fn("input[name=email]", "\u8bf7\u586b\u5199Email", "require",
    function(b, c) {
        return a.guang.util.isEmpty(c)
    });
    c.fn("input[name=username]", "4-30\u4e2a\u5b57\u7b26\uff0c\u652f\u6301\u4e2d\u82f1\u6587\u3001\u6570\u5b57\u3001\u201c_\u201d\u548c\u51cf\u53f7", "info");
    c.fn("input[name=username]", "\u4ec5\u652f\u6301\u4e2d\u82f1\u6587\u3001\u6570\u5b57\u3001\u201c_\u201d\u548c\u51cf\u53f7", "error",
    function(b, c) {
        return a.guang.util.isNick(c)
    });
    c.fn("input[name=username]", "\u6700\u957f\u4e0d\u80fd\u8d85\u8fc730\u4e2a\u5b57\u7b26", "require",
    function(b, c) {
        return a.guang.util.nickMax(c)
    });
    c.fn("input[name=username]", "\u8bf7\u8f93\u5165\u81f3\u5c114\u4e2a\u5b57\u7b26", "require",
    function(b, c) {
        return a.guang.util.nickMin(c)
    });
    c.fn("input[name=username]", "\u8bf7\u586b\u5199\u6635\u79f0", "require",
    function(b, c) {
        return a.guang.util.isEmpty(c)
    });
    c.fn("input[name=pwd]", "6-16\u4e2a\u534a\u89d2\u5b57\u7b26\uff0c\u652f\u6301\u5b57\u6bcd\u3001\u6570\u5b57\u3001\u7b26\u53f7\uff0c\u533a\u5206\u5927\u5c0f\u5199", "info");
    c.fn("input[name=pwd]", "\u5bc6\u7801\u4e2d\u4e0d\u80fd\u5305\u542b\u7a7a\u683c", "error",
    function(a, b) {
        return /^\S+$/.test(b)
    });
    c.fn("input[name=pwd]", "\u5bc6\u7801\u592a\u957f\u4e86\uff0c\u6700\u591a16\u4f4d", "require",
    function(a, b) {
        return 16 < b.length ? !1 : !0
    });
    c.fn("input[name=pwd]", "\u5bc6\u7801\u592a\u77ed\u4e86\uff0c\u6700\u5c116\u4f4d", "require",
    function(b, c) {
        return a.guang.util.tooShort(c, 6)
    });
    c.fn("input[name=pwd]", "\u8bf7\u8f93\u5165\u5bc6\u7801", "require",
    function(a, b) {
        return 0 == b.length ? !1 : !0
    });
    c.fn("input[name=repwd]", "\u8bf7\u91cd\u590d\u8f93\u5165\u4e00\u6b21\u5bc6\u7801", "info");
    c.fn("input[name=repwd]", "\u4e24\u6b21\u8f93\u5165\u7684\u5bc6\u7801\u4e0d\u4e00\u81f4\uff0c\u8bf7\u91cd\u65b0\u8f93\u5165", "error",
    function(b, c) {
        return c == a("#pwd").val()
    });
    c.fn("input[name=repwd]", "\u8bf7\u91cd\u590d\u8f93\u5165\u4e00\u6b21\u5bc6\u7801", "require",
    function(b, c) {
        return a.guang.util.isEmpty(c)
    });
    a.fn.validator = function(c) {
        var d = this.data("validator");
        d && (d.destroy(), this.removeData("validator"));
        c = a.extend(!0, {},
        a.guang.validator.conf, c);
        if (this.is("form")) return this.each(function() {
            var g = a(this);
            d = new b(g, c);
            g.data("validator", d)
        });
        d = new b(this.eq(0).closest("form"), c);
        return this.data("validator", d)
    }
})(jQuery); (function(a) {
    a.fn.textSlider = function(b) {
        b = a.extend({
            speed: "normal",
            step: 1,
            timer: 1E3
        },
        b || {});
        return this.each(function() {
            a.fn.textSlider.scllor(a(this), b)
        })
    };
    a.fn.textSlider.scllor = function(b, d) {
        var c = b.find("ul:eq(0)"),
        e = c.children(),
        f = a(e[0]).height(),
        g = 0 - d.step * f;
        7 < e.length && window.setInterval(function() {
            c.animate({
                marginTop: g
            },
            d.speed,
            function() {
                for (i = 0; i < d.step; i++) c.find("li:first").removeClass("fade"),
                c.find("li:first").appendTo(c);
                c.css({
                    marginTop: 0
                });
                c.find("li:first").addClass("fade")
            })
        },
        d.timer)
    }
})(jQuery); (function(a) {
    a.guang.tip = {
        conf: {
            timer: null,
            timerLength: 3E3,
            tipClass: ""
        },
        show: function(b, d) {
            clearTimeout(a.guang.tip.conf.timer);
            var c = a.guang.util.getPosition(b).topMid();
            a(".tipbox")[0] || a("body").append('<div class="tipbox"></div>');
            a(".tipbox").attr("class", "tipbox " + a.guang.tip.conf.tipClass);
            a(".tipbox").html(d);
            var e = a(".tipbox").outerWidth(),
            f = a(".tipbox").outerHeight();
            a(".tipbox").css({
                left: c.x - e / 2 + "px",
                top: c.y - f - 10 + "px"
            }).fadeIn();
            a.guang.tip.conf.timer = setTimeout(function() {
                a(".tipbox").fadeOut()
            },
            a.guang.tip.conf.timerLength)
        }
    }
})(jQuery); (function(a) {
    a.cookie = function(a, d, c) {
        if ("undefined" != typeof d) {
            c = c || {};
            if (null === d) d = "",
            c.expires = -1;
            var e = "";
            if (c.expires && ("number" == typeof c.expires || c.expires.toUTCString))"number" == typeof c.expires ? (e = new Date, e.setTime(e.getTime() + 864E5 * c.expires)) : e = c.expires,
            e = "; expires=" + e.toUTCString();
            var f = c.path ? "; path=" + c.path: "",
            g = c.domain ? "; domain=" + c.domain: "",
            c = c.secure ? "; secure": "";
            document.cookie = [a, "=", encodeURIComponent(d), e, f, g, c].join("")
        } else {
            d = null;
            if (document.cookie && "" != document.cookie) {
                c = document.cookie.split(";");
                for (e = 0; e < c.length; e++) if (f = jQuery.trim(c[e]), f.substring(0, a.length + 1) == a + "=") {
                    d = decodeURIComponent(f.substring(a.length + 1));
                    break
                }
            }
            return d
        }
    }
})(jQuery);
$(function() {
    $(window).bind("scrollTop",
    function() {
        var a = $(document).scrollTop();
        83 < a ? $(".m-nav").addClass("fixed") : $(".m-nav").removeClass("fixed");
        $.guang.util.isIE6() && (83 < a ? $(".m-nav").css("top", a) : $(".m-nav").css("top", "83px"))
    });
    $(".login-menu .share-link a").unbind("click").click(function() {
        var a = $(this).attr("href");
        $.guang.util.openWin(a);
        return ! 1
    });
    $(".more-login .more-link").unbind("click").click(function() {
        $(".login-dropdown").fadeIn()
    });
	
    $(".login-dropdown").hover(function() {
        $(this).show()
    },
    function() {
        $(this).hide()
    });
    $("#returnTop").returntop()
});


	
$(function() {
	
		var a;		
		 $(".gohome").hover(function() {
			 $(".shareit-dropdown").hide();
			$(".xiaoxi-dropdown").hide();
			$(".login-dropdown").hide();
            $(".set-dropdown").show();
			
			 a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".set-dropdown").hide();
            },
            700)
        });
		
		$(".set-dropdown").hover(function() {
            a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".set-dropdown").hide();
            },
            700)
        });
		
		 $(".xiaoxi").hover(function() {
			$(".set-dropdown").hide();
			$(".shareit-dropdown").hide();
			$(".login-dropdown").hide();
            $(".xiaoxi-dropdown").show();
			 a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".xiaoxi-dropdown").hide();
            },
            700)
        });
		
		$(".xiaoxi-dropdown").hover(function() {
            a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".xiaoxi-dropdown").hide();
            },
            700)
        });
		
		 $(".btn-sg").hover(function() {
			$(".set-dropdown").hide();
			$(".login-dropdown").hide();
			$(".xiaoxi-dropdown").hide();
            $(".shareit-dropdown").show();
			 a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".shareit-dropdown").hide();
            },
            700)
        });
		
		$(".shareit-dropdown").hover(function() {
            a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".shareit-dropdown").hide();
            },
            700)
        });
		
		
		$(".regLogin").hover(function() {
			$(".set-dropdown").hide();
			$(".xiaoxi-dropdown").hide();
            $(".shareit-dropdown").hide();
			$(".login-dropdown").show();
			 a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".login-dropdown").hide();
            },
            700)
        });
		
		$(".login-dropdown").hover(function() {
            a != null && clearTimeout(a)
        },
        function() {
            a = setTimeout(function() {
                $(".login-dropdown").hide();
            },
            700)
        });
		
		$("#Add_good li a, #Add_good li i").die().live("click",
                function() {
                    $(this).parent("li").hasClass("selected") ? $(this).parent("li").removeClass("selected") : $(this).parent("li").addClass("selected");
                    $("#Add_good .status em").text($("#Add_good li.selected").length)
                });
				
				$(".hd-create-topic, .create-btn").live("click",function(){
				if($.guang.dialog.isLogin()){
					
					window.location.href=$(this).attr('date-href');
				}
	});
});



$(function() {
    if (0 < GUANGER.userId.length) {
        var a = function(a) {
            var c = !1,
            d;
            d = "<div class='xiaoxi-tip'><a href='javascript:;' class='closetip'>x</a>";
            a.fansMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='fans'><a href='" + GUANGER.path + a.fansurl + "'>" + a.fansMessageNum + " \u4f4d\u65b0\u7c89\u4e1d</a></div>");
            a.commentMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='comments'><a href='" + GUANGER.path + a.fansurl + "'>" + a.commentMessageNum + " \u6761\u65b0\u8bc4\u8bba</a></div>");
            a.replyMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='reply'><a href='" + GUANGER.path + a.fansurl + "'>" + a.replyMessageNum + " \u6761\u65b0\u56de\u590d</a></div>");
            a.atMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='at'><a href='" + GUANGER.path + a.fansurl + "'>" + a.atMessageNum + " \u6761\u65b0@\u6211</a></div>");
            a.appraisalMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='appraisal'><a href='" + GUANGER.path + a.fansurl + "'>" + a.appraisalMessageNum + " \u6761\u65b0\u9274\u5b9a</a></div>");
            a.systemMessageNum && (c = !0, d += "<div class='xiaoxi-item' data-type='sys'><a href='" + GUANGER.path + a.systemurl + "'>" + a.systemMessageNum + " \u4e2a\u65b0\u901a\u77e5</a></div>");
            c && $("#header .person").after(d + "</div>");
            0 < a.feedsMessageNum && (a = "<span class='xiaoxi-sum'>" + (99 < a.feedsMessageNum ? "N": a.feedsMessageNum) + "</span>", $("#header #feeds-xiaoxi").append(a));
            $("#header .xiaoxi-tip .closetip").click(function() {
                var a = $(this).parent(".xiaoxi-tip");
                $.ajax({
                    url: GUANGER.path + "index.php?app=share&ac=do&le=cancel_notify",
                    type: "post",
                    dataType: "json",
                    data: {},
                    success: function() {
                        a.fadeOut(500)
                    }
                })
            })
        };
        $.ajax({
            url: GUANGER.path + "index.php?app=share&ac=do&le=M_count",
            type: "post",
            dataType: "json",
            success: function(b) {
                100 == b.code && (0 < b.fansMessageNum || 0 < b.commentMessageNum || 0 < b.replyMessageNum || 0 < b.atMessageNum || 0 < b.appraisalMessageNum || 0 < b.systemMessageNum || 0 < b.feedsMessageNum) && a(b)
            }
        })
    }
});