var UserTopic = {
    page: $("#J_Page"),
    topicBanner: $("#J_TopicBanner"),
    topicId: $("#J_TopicId").val(),
    deleteUserTopic: function() {
        var a = $("#J_UserTopicDel");
        $.ajax({
            url: GUANGER.path + "index.php?app=share&ac=do&le=del_zhuti",
            dataType: "json",
            type: "post",
			data: {
                    themeid: GUANGER.themeid,
                    topicid: GUANGER.topicid
                },
            success: function(b) {
                switch (b.code) {
                case 100:
					url = b.backurl;
                    b = '<p class="success-text"><span class="correct">\u4e3b\u9898\u5df2\u5220\u9664\u6210\u529f\uff01</span></p>' + ('<p class="clearfix"><span class="fl mr10 l30">5\u79d2\u540e\u5c06</span><a class="bbl-btn goCheck" href="' +  url + '">返回主题首页</a>');
                    $.guang.tipForOper.conf.html = b;
                    $.guang.tipForOper.init();
                    setTimeout(function() {
                        window.location.href = url;
                    },
                    5E3);
                    break;
                case 101:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                    $.guang.tip.show(a, "\u8bf7\u6c42\u5931\u8d25\u4e86\uff0c\u91cd\u65b0\u63d0\u4ea4\u8bd5\u4e0b\uff01");
                    break;
                case 105:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                    $.guang.tip.show(a, "\u60a8\u6ca1\u6709\u6743\u9650\u5220\u9664\u6b64\u4e3b\u9898\u54e6\uff01")
                }
            }
        })
    },
    removeProduct: function() {},
    bgColor: function(a, b, d) {
        var c = a.data("colorval");
        $("#J_" + b + "ColorPickerD")[0] || $("body").append("" + ('<div id="J_' + b + 'ColorPickerD" class="g-dialog sg-dialog tip-dialog cp-dialog">') + '<div class="content">' + ('<input id="J_' + b + 'ColorVal" type="text" class="base-input" value="' + c + '" style="background-color:' + c + '"/>') + ('<div id="J_' + b + 'ColorPicker">') + '</div><div class="tipbox-up"><em>\u25c6</em><span>\u25c6</span></div><a class="close" href="javascript:;"></a></div></div>');
        $(".tip-dialog").css("display", "none");
        var e = $("#J_" + b + "ColorPickerD");
        e.css({
            left: a.offset().left - 30,
            top: a.offset().top + a.outerHeight() + 10
        }).fadeIn("fast");
        e.find(".close").click(function() {
            e.fadeOut("fast")
        });
        var g = e.find("#J_" + b + "ColorVal"),
        f = $.farbtastic("#J_" + b + "ColorPicker");
        f.setColor(c);
        f.linkTo(function(a) {
            d(a);
            g.val(a).css("backgroundColor", a)
        });
        g.blur(function() {
            var a = $(this).val();
            f.setColor(a);
            d(a);
            $(this).css("backgroundColor", a)
        });
        document.onclick = function(a) {
            var d = $("#J_" + b + "ColorPickerD"),
            a = a || window.event,
            c = a.srcElement || a.target,
            c = a.srcElement ? a.srcElement: a.target;
            0 == $(c).closest("#J_" + b + "ColorPickerD").length && ("I" != c.tagName && c.id != "J_" + b + "Color") && d.hide()
        }
    },
    picUpload: function(a, b) {
        var d = "";
        if (!$("#J_" + b + "PicUploadD")[0]) {
            var c;
            c = "" + ('<div id="J_' + b + 'PicUploadD" class="g-dialog sg-dialog tip-dialog upload-dialog">') + '<div class="content">' + $("#J_" + b + "PicUploadCon").html();
            $("body").append(c + '<div class="tipbox-up"><em>\u25c6</em><span>\u25c6</span></div><a class="close" href="javascript:;"></a></div></div>')
        }
		
        $(".tip-dialog").css("display", "none");
        var e = $("#J_" + b + "PicUploadD");
		
        e.css({
            left: a.offset().left - 4,
            top: a.offset().top + a.outerHeight() + 10,
            height: "120px"
        }).fadeIn("fast");
		
        e.find(".close").click(function() {
            e.fadeOut("fast")
        });
		
        publishPicSuccess = function(a, d, c) {
            switch (a) {
            case "100":
                switch (d) {
                case "topicBanner":
                    UserTopic.topicBanner.css("backgroundImage", 'url("'+GUANGER.path + c + '")');
                    $("#J_HeaderPicBtn").data("src", c);
                    break;
                case "topicBg":
                    UserTopic.page.css("backgroundImage", 'url("'+GUANGER.path + c + '")'),
                    $("#J_PagePicBtn").data("src", c)
                }
                $("#J_" + b + "PicUploadD").fadeOut("fast");
                break;
            case "101":
                alert("\u4eb2,\u4e0a\u4f20\u5931\u8d25\u4e86, \u91cd\u65b0\u63d0\u4ea4\u8bd5\u8bd5\uff01")
            }
        };
        window.submitPic = function(a, b) {
            if (1 != $(a).data("isSubmit")) {
                $(a).data("isSubmit", 1);
                $("#" + b + "picUploadTarget");
                d = $(a).val();
                if(b=='header') t='topicBanner',J='J_HeaderFileInput';
				
				if(b=='page') t='topicBg',J='J_PageFileInput';
				
			$.ajaxFileUpload({
            url:$(a).closest("form").attr("action"),
			secureuri :false,
			dataType: "json",
			fileElementId :J,
            success:function(data){
				 $json=data;
				 publishPicSuccess($json.code,t,$json.imgurl);
            },
            error:function ()
            {
                alert("上传失败");
            }
        });
				
				
				
				
                var c;
                /\.(gif|jpg|png|jpeg|bmp)$/i.test(d) ? c = !0 : (alert("\u8bf7\u4e0a\u4f20\u6807\u51c6\u56fe\u7247\u6587\u4ef6,\u652f\u6301gif,jpg,png,jpeg."), c = !1);
				
                c && $(a).closest("form").submit();
                $(a).data("isSubmit", 0)
				
				
            }
        }
    },
    bgRepeat: function(a, b) {
        "1" == a.val() ? (b.css("backgroundRepeat", "repeat"), a.val("0")) : (b.css("backgroundRepeat", "no-repeat"), a.val("1"))
    },
    bgPosition: function(a, b) {
        b.css("backgroundPosition", "center " + a.val());
        a.data("val", a.val())
    },
    photoDel: function(a, b, d) {
        b.css("backgroundImage", 'url("http://static.letushuo.com/images/ui/placeholder.png")');
        d.data("src", "")
    },
    style: {
        headerBgColor: function() {
            $("#J_HeaderBgColor").click(function() {
                var a = $(this);
                UserTopic.bgColor($(this), "HeaderBg",
                function(b) {
                    UserTopic.topicBanner.css("backgroundColor", b);
                    a.data("colorval", b);
                    a.find("i").css("backgroundColor", b)
                })
            })
        },
        headeWordColor: function() {
            $("#J_HeaderWordColor").click(function() {
                var a = $(this);
                UserTopic.bgColor(a, "HeaderWord",
                function(b) {
                    UserTopic.topicBanner.find(".subtitle").css("color", b);
                    a.data("colorval", b);
                    a.find("i").css("backgroundColor", b)
                })
            })
        },
        headerHeight: function() {
            var a = $("#J_HeaderHeight"),
            b = $("#J_SubTitle").height() + 40;
            if ("auto" == a.val()) {
                var d = UserTopic.topicBanner.height() < b ? b: UserTopic.topicBanner.height();
                UserTopic.topicBanner.height(d);
                a.val(d)
            }
            UserTopic.topicBanner.height() < b && UserTopic.topicBanner.height(b);
            a.blur(function() {
                80 > a.val() || 600 < a.val() ? ($.guang.tip.conf.tipClass = "tipmodal tipmodal-error", $.guang.tip.show($(this), "\u9ad8\u5ea6\u8303\u56f4\u662f80px~600px\uff01"), 80 > a.val() ? (a.val("80"), UserTopic.topicBanner.css("height", "80px")) : (a.val("600"), UserTopic.topicBanner.css("height", "600px"))) : UserTopic.topicBanner.css("height", a.val())
            })
        },
        headerRepeat: function() {
            $("#J_HeaderBgRepeat").click(function() {
                UserTopic.bgRepeat($(this), UserTopic.topicBanner)
            })
        },
        headerPosition: function() {
            var a = $("#J_HeaderBgPosition");
            a.val(a.data("val"));
            a.change(function() {
                UserTopic.bgPosition($(this), UserTopic.topicBanner)
            })
        },
        headerPhotoDel: function() {
            $("#J_HeaderPhotoDel").click(function() {
                UserTopic.photoDel($(this), UserTopic.topicBanner, $("#J_HeaderPicBtn"))
            })
        },
        pageBgColor: function() {
            $("#J_PageBgColor").click(function() {
                var a = $(this);
                UserTopic.bgColor($(this), "PageBg",
                function(b) {
                    UserTopic.page.css("backgroundColor", b);
                    a.data("colorval", b);
                    a.find("i").css("backgroundColor", b)
                })
            })
        },
        pageBgRepeat: function() {
            $("#J_PageBgRepeat").click(function() {
                UserTopic.bgRepeat($(this), UserTopic.page)
            })
        },
        pageBgAttachment: function() {
            $("#J_PageBgAttachment").click(function() {
                var a = $(this);
                "1" == a.val() ? (UserTopic.page.css("backgroundAttachment", "fixed"), a.val("0")) : (UserTopic.page.css("backgroundRepeat", "scroll"), a.val("1"))
            })
        },
        pageBgPosition: function() {
            var a = $("#J_PageBgPosition");
            a.val(a.data("val"));
            a.change(function() {
                UserTopic.bgPosition($(this), UserTopic.page)
            })
        },
        pagePhotoDel: function() {
            $("#J_PagePhotoDel").click(function() {
                UserTopic.photoDel($(this), UserTopic.page, $("#J_PagePicBtn"))
            })
        },
        init: function() {
            UserTopic.style.headerBgColor();
            UserTopic.style.headeWordColor();
            UserTopic.style.headerHeight();
            UserTopic.style.headerRepeat();
            UserTopic.style.headerPosition();
            UserTopic.style.headerPhotoDel();
            UserTopic.style.pageBgColor();
            UserTopic.style.pageBgRepeat();
            UserTopic.style.pageBgAttachment();
            UserTopic.style.pageBgPosition();
            UserTopic.style.pagePhotoDel()
        }
    },
    userTopicStyleSave: function(a) {
        var b = {
            color: $("#J_HeaderWordColor").data("colorval"),
            height: $("#J_HeaderHeight").val(),
            backgroundColor: $("#J_HeaderBgColor").data("colorval"),
            backgroundRepeat: 1 == $("#J_HeaderBgRepeat").val() ? "no-repeat": "repeat",
            backgroundPosition: $("#J_HeaderBgPosition").val()
        },
        d = {
            backgroundColor: $("#J_PageBgColor").data("colorval"),
            backgroundRepeat: 1 == $("#J_PageBgRepeat").val() ? "no-repeat": "repeat",
            backgroundAttachment: 1 == $("#J_PageBgAttachment").val() ? "scroll": "fixed",
            backgroundPosition: $("#J_PageBgPosition").val()
        },
        b = {
            topicId: UserTopic.topicId,
            headerPhoto: $("#J_HeaderPicBtn").data("src"),
            topStyle: JSON.stringify(b),
            bgPhoto: $("#J_PagePicBtn").data("src"),
            pageStyle: JSON.stringify(d)
        };
        $.ajax({
            url: GUANGER.path + "index.php?app=share&ac=do&le=editStyle",
            dataType: "json",
            type: "post",
            data: b,
            success: function(b) {
                switch (b.code) {
                case 100:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                    $.guang.tip.show(a, "\u4fdd\u5b58\u6210\u529f\uff01");
                    $("#J_HeaderPicBtn").data("src", b.detailHeadPhoto);
                    $("#J_PagePicBtn").data("src", b.topic.backgroundPhoto);
                    break;
                case 101:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                    $.guang.tip.show(a, "\u4fdd\u5b58\u4e0d\u6210\u529f\uff0c\u91cd\u65b0\u63d0\u4ea4\u8bd5\u8bd5\uff01");
                    break;
                case 102:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                    $.guang.tip.show(a, "\u53c2\u6570\u9519\u8bef\uff01");
                    break;
                case 105:
                    $.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                    $.guang.tip.show(a, "\u4eb2\uff0c\u60a8\u6ca1\u6743\u9650\u54e6\uff01")
                }
            },
            error: function() {
                $.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                $.guang.tip.show(a, "\u670d\u52a1\u5668\u6b27\u5df4\u4e58\u51c9\u53bb\u4e86\uff0c\u91cd\u65b0\u63d0\u4ea4\u8bd5\u8bd5\uff01")
            }
        })
    },
    userTopicStyleClose: function() {
        var a = $("#J_UserTopicStyle");
        $("#J_UserTopicStyleOpenBtn").click(function(b) {
            b.preventDefault();
            "block" == a.css("display") ? a.slideUp() : a.slideDown()
        });
        $("#J_UserTopicStyleCloseBtn").click(function(b) {
            b.preventDefault();
            a.slideUp()
        })
    },
    init: function() {
        $("#J_SubTitle").html($.trim($("#J_SubTitle").html()).replace(/\[br\]/g, "<br/>"));
        $("#J_UserTopicDel").click(function(a) {
            a.preventDefault(); (function(a, d, c) {
                $("#J_ConfirmD")[0] && $("#J_ConfirmD").remove();
                $("body").append('<div id="J_ConfirmD" class="g-dialog tip-dialog"><div class="dialog-content"><div class="hd"><h3>\u63d0\u793a</h3></div><div class="bd clearfix">' + ('<p class="pt10 tac">' + a + "</p>") + '<div class="act-row"><p class="inlineblock"><a class="bbl-btn mr10" id="J_Confirm" href="javascript:;">\u786e\u5b9a</a><a class="bgr-btn" id="J_Cancel" href="javascript:;">\u53d6\u6d88</a></p></div></div><a class="close" href="javascript:;"></a></div></div>');
                $("#J_ConfirmD").overlay({
                    top: "center",
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !0,
                    load: !0,
                    onClose: function() {
                        c();
                        $("#J_ConfirmD,#exposeMask").remove()
                    }
                });
                $("#J_Cancel").unbind("click").click(function() {
                    $("#J_ConfirmD").overlay().close()
                });
                $("#J_Confirm").unbind("click").click(function() {
                    $("#J_ConfirmD").overlay().close();
                    d()
                })
            })("\u771f\u8981\u5220\u9664\u8fd9\u4e2a\u4e3b\u9898\u5417\uff1f\u5220\u4e86\u5c31\u6ca1\u4e86\u54e6...", UserTopic.deleteUserTopic,
            function() {})
        });
        $("#GoodsWall .ilike-del").die().live("click",
        function() {
            var a = $(this),
            b = a.parents(".goods"),
            a = a.data("proid");
            $.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=removeGood",
                type: "post",
                dataType: "json",
                data: {
                    topicId: UserTopic.topicId,
                    tpId: a
                },
                success: function(a) {
                    switch (a.code) {
                    case 100:
                        b.addClass("goods-gray");
                        break;
                    case 101:
                        alert(a.msg)
                    }
                }
            })
        });
		
		
		$("#J_ResetSimg").live("click",
        function() {
			
            var a = $(this);
            $.ajax({
                url: GUANGER.path+"index.php?app=share&ac=do&le=reset_simg",
                type: "post",
                dataType: "json",
                data: {
                    themeid : GUANGER.themeid
                },
				beforesend:a.html('加载中...'),
                success: function(b) {
                    switch (b.code) {
                    case 100:
					  
					a.html('更换成功');
					
					$.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                    $.guang.tip.show(a, "主题缩略图更换成功，可以返回主题列表页查看");
					a.html('更换缩略图 ');
					
                    break;
                    case 101:
                   alert('更换失败');
                    }
                }
            })
        });
		
		
		
		$("#J_AdminTop, #J_AdminRecom").die().live("click",
        function() {
            var a = $(this),
            b = GUANGER.themeid;
			c =a.attr("datatype");
			e =a.attr("type");
            $.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le="+e+"_theme",
                type: "post",
                dataType: "json",
                data: {
                    themeId: b,
					datatype: c
                },
                success: function(d) {
                    switch (d.code) {
                    case 100:
					 a.attr("datatype",d.datatype)
					 a.html(d.html);
                      $.guang.tip.conf.tipClass = "tipmodal tipmodal-ok";
                   	 $.guang.tip.show(a, d.msg);
                        break;
                    case 101:
                        alert(d.msg)
                    }
                }
            })
        });
		
		
        UserTopic.userTopicStyleClose();
        $("#J_HeaderPicBtn").click(function() {
            UserTopic.picUpload($(this), "Header")
        });
        $("#J_PagePicBtn").click(function() {
            UserTopic.picUpload($(this), "Page")
        });
        UserTopic.style.init();
        $("#J_UserProductUrl").val("");
        $("#J_TopicStyleSave").click(function() {
            UserTopic.userTopicStyleSave($(this))
        });
        $("#J_UserProductUrl").focus(function() {
            if ("true" == GUANGER.isBlack) return alert("\u60a8\u7684\u5206\u4eab\u529f\u80fd\u5df2\u88ab\u7981\u7528"),
            !1;
            var a = $(this),
            b = $("#J_UserAddProduct");
            if ($("#J_ShareGoodsTipD")[0]) $(".sg-text-tip").html("");
            else {
                $("body").append('<div id="J_ShareGoodsTipD" class="g-dialog sg-dialog"><div class="content"><div class="sg-text-tip"></div><div class="sg-source"><p class="pt5 pb5">\u5df2\u652f\u6301\u7f51\u7ad9\uff08<a href="http://letushuo.com/contact" target="_blank">\u5546\u5bb6\u7533\u8bf7\u52a0\u5165</a>\uff09\uff1a</p><div class="source-list clearfix"><a class="icon-source icon-taobao" href="http://www.taobao.com/" target="_blank">\u6dd8\u5b9d\u7f51</a><a class="icon-source icon-tmall" href="http://www.tmall.com/" target="_blank">\u5929\u732b\u5546\u57ce</a><a class="icon-source icon-paipai" href="http://buy.qq.com/" target="_blank">QQ\u7f51\u8d2d</a><a class="icon-source icon-mbaobao" href="http://www.mbaobao.com/" target="_blank">\u9ea6\u5305\u5305</a><a class="icon-source icon-vancl" href="http://www.vancl.com/" target="_blank">\u51e1\u5ba2\u8bda\u54c1</a></div></div></div></div>');
                var d = $("#J_ShareGoodsTipD");
                $("#J_UserProductUrl").blur(function() {
                    d.hide()
                });
                d.click(function() {
                    d.show()
                });
                b.click(function() {
                    var c = $.trim(a.val()),
                    e = $(".sg-text-tip");
                    d.show();
                    "" == c ? e.html('<span class="errc">\u5b9d\u8d1d\u7f51\u5740\u4e0d\u80fd\u4e3a\u7a7a~</span>').show() : $.guang.util.validSite(c) ? $.ajax({
                        url: GUANGER.path + "/ugc/api/findProduct",
                        type: "post",
                        dataType: "json",
                        data: {
                            url: c
                        },
                        beforeSend: function() {
                            e.html('<span class="gc6">\u5b9d\u8d1d\u4fe1\u606f\u6293\u53d6\u4e2d\u2026</span>').show();
                            b.disableBtn("bbl-btn")
                        },
                        success: function(a) {
                            100 == a.code ? (d.hide(), $.guang.ugc.goodspub(a.product, a.isUploadRole, UserTopic.addProduct)) : 105 == a.code || 108 == a.code ? (d.hide(), $.guang.ugc.goodsExist(a.product, UserTopic.addProduct)) : 101 == a.code || 106 == a.code ? e.html('<span class="errc">\u5b9d\u8d1d\u4fe1\u606f\u6293\u53d6\u5931\u8d25\uff0c\u8bf7\u91cd\u8bd5\u2026</span>').show() : 107 == a.code ? e.html('<span class="errc">\u6682\u65f6\u8fd8\u4e0d\u652f\u6301\u8fd9\u4e2a\u5b9d\u8d1d\u2026</span>').show() : 110 == a.code ? e.html('<span class="errc">\u4eb2\uff0c\u8be5\u5546\u54c1\u6240\u5728\u5546\u5bb6\u5df2\u5217\u5165\u9ed1\u540d\u5355\uff0c\u7533\u8bc9\u8bf7\u8054\u7cfbGCTU@letushuo.com</span>').show() : 444 == a.code ? (alert("\u4f60\u5df2\u88ab\u7981\u6b62\u767b\u5f55\uff01"), window.location.href = "http://letushuo.com/logout") : 442 == a.code ? alert("\u4eb2\uff0c\u8bf7\u4e0d\u8981\u9891\u7e41\u63a8\u8350\u540c\u4e00\u5e97\u94fa\u5546\u54c1") : 443 == a.code ? alert("\u7531\u4e8e\u8fc7\u5ea6\u63a8\u8350\u540c\u5e97\u94fa\u5546\u54c1\uff0c\u8d26\u6237\u5df2\u51bb\u7ed3\uff0c\u5982\u6709\u7591\u95ee\u8bf7\u8054\u7cfb GCTU@letushuo.com") : 445 == a.code && alert("\u57ce\u7ba1\u5927\u961f\u6000\u7591\u4f60\u6076\u610f\u53d1\u5e7f\u544a\uff0c\u5c06\u7981\u6b62\u4f60\u53d1\u5e03\u5546\u54c1\u7684\u6743\u5229\uff0c\u7533\u8bc9\u8bf7\u8054\u7cfbGCTU@letushuo.com");
                            b.enableBtn("bbl-btn")
                        }
                    }) : e.html('<span class="errc">\u6682\u65f6\u8fd8\u4e0d\u652f\u6301\u8fd9\u4e2a\u7f51\u7ad9\u5462~</span>').show()
                })
            }
            var c = $.guang.util.getPosition(a).leftBottom(),
            e = c.x,
            c = c.y + 5;
            $("#J_ShareGoodsTipD").css({
                right: "auto",
                left: e + "px",
                top: c + "px"
            }).fadeIn("fast")
        })
    }
};
UserTopic.init();