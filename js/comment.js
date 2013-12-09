(function(a) {

    a.guang.addToTopic = {
        proId: "",
        topicsOptions: "",
        galleryOptions: "",
        galleryId: "",
        sceneId: "",
        submitData: {},
        isEnable: !0,
        submit: function() {
            if (a.guang.addToTopic.isEnable) a.guang.addToTopic.isEnable = !1;
            else return ! 1;
            a.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=addToTopic",
                type: "post",
                dataType: "json",
                data: a.guang.addToTopic.submitData,
				beforeSend: function() {
							a(".addgoods-loading").show(); 
                        },
                success: function(b) {
                    switch (b.code) {
                    case 100:
                        var c = a("#J_AddToTopicD");
                        c.overlay().close();
						a(".addgoods-loading").hide(); 
                        c.find("input[type=text]").val("");
                        c.find("textarea").val("");
                        c.find("input[name='topicType'][value=0]").attr("checked", !0);
                        b = '<p class="success-text"><span class="correct">\u52a0\u5165\u4e3b\u9898\u6210\u529f\uff01</span></p>' + ('<p class="clearfix"><a class="bbl-btn goCheck" href="' + b.url + '">\u67e5\u770b\u6211\u7684\u4e3b\u9898</a>');
                        a.guang.tipForOper.conf.html = b + '<a class="bgr-btn closeD ml10" href="javascript:;">\u5173\u95ed</a></p>';
                        a.guang.tipForOper.init();
                        setTimeout(function() {
                            a("#J_TipForOper").fadeOut()
                        },
                        2E3);
                        setTimeout(function() {
                            a.guang.addToTopic.isEnable = !0
                        },
                        1E3);
                        break;
                    case 101:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show($this, "\u52a0\u5165\u4e3b\u9898\u5931\u8d25");
                        break;
                    case 102:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show($this, "\u53c2\u6570\u9519\u8bef");
                        break;
                    case 300:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        a.guang.tip.show($this, "\u4eb2\uff0c\u60a8\u53ef\u80fd\u672a\u767b\u5f55\uff01")
                    }
                },
                error: function() {
                    a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                    a.guang.tip.show($this, "\u4eb2\uff0c\u60a8\u53ef\u80fd\u672a\u767b\u5f55\uff01\u5237\u65b0\u518d\u8bd5\u4e0b\u5427\uff01")
                }
            })
        },

        dialog: function() {
            if (a("#J_AddToTopicD")[0]) a("#J_AddToTopicD").data("overlay").load();
            else {
                a("body").append('<div id="J_AddToTopicD" class="g-dialog ilike-topic-dialog"><div class="dialog-content"><div class="hd"><h3>\u52a0\u5165\u6211\u7684\u4e3b\u9898</h3></div><div class="bd clearfix"><ul><li id="J_HasTopicList"><label><input type="radio" name="topicType" checked="checked" value="0"/>\u5df2\u6709\u4e3b\u9898\uff1a</label><select id="J_SelTopic"></select></li><li id="J_NewTopic"><label><input type="radio" name="topicType" value="1"/>\u65b0\u7684\u4e3b\u9898\uff1a</label><input class="b-input" type="text" value=""/></li><li class="gallery-scene" id="J_GalleryScene" style="display:none;"><select id="J_SelCag" name="cate" class="sel-cag"><option value="">\u9009\u62e9\u5206\u7c7b</option></select></li><li><textarea class="b-textarea" placeholder="\u8bf4\u4e24\u53e5"></textarea></li></ul><div class="clearfix pt10"><input type="button" class="bbl-btn ok" value="\u5b8c\u6210"/><input type="button" class="bgr-btn cancel" value="\u53d6\u6d88"></div><div class="addgoods-loading">&nbsp;</div></div><a class="close" href="javascript:;"></a></div></div>');
                var b = a("#J_AddToTopicD");
                b.width("365");
                b.overlay({
                    top: "center",
                    fixed: !1,
                    mask: {
                        color: "#000",
                        loadSpeed: 200,
                        opacity: 0.3
                    },
                    closeOnClick: !1,
                    load: !0
                });
                var c = a("#J_NewTopic").find("input[type=text]"),
                d = a("#J_SelTopic"),
                e = a("#J_GalleryScene");
                c.focus(function() {
                    b.find("input[name='topicType'][value=1]").attr("checked", !0);
                    e.fadeIn()
                });
                d.html(a.guang.addToTopic.topicsOptions);
                d.change(function() {
                    b.find("input[name='topicType'][value=0]").attr("checked", !0);
                    e.fadeOut()
                });
                a("#J_SelCag").change(function() {
                    var b = a(this).val();
                    a.guang.addToTopic.relateScene(b)
                });
                a("#J_HasTopicList").click(function() {
                    e.fadeOut()
                });
                a("#J_NewTopic").click(function() {
                    e.fadeIn()
                });
                b.find(".ok").click(function() {
                    var d = a(this),
                    e = a.guang.util.trim(b.find("textarea").val());
                    if ("1" == b.find("input[name='topicType']:checked").val()) {
                        var j = a.guang.util.trim(c.val());
                        if ("" == j || 15 < a.guang.util.getStrLength(j)) a.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        a.guang.tip.show(d, "\u4e3b\u9898\u6807\u9898\u4e3a1~15\u4e2a\u6c49\u5b57");
                        else if (1E3 < a.guang.util.getStrLength(e)) a.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                        a.guang.tip.show(d, "\u8bc4\u8bba\u8d85\u8fc71000\u6c49\u5b57\u4e86");
                        else {
                            a.guang.addToTopic.submitData = {
                                productId: a.guang.addToTopic.proId,
                                topicTitle: j,
                                userComment: e,
                                cate: a("#J_SelCag").val()
                            };
                            a.guang.addToTopic.submit(d)
                        }
                    } else {a.guang.addToTopic.submitData = {
                        productId: a.guang.addToTopic.proId,
                        topicId: a("#J_SelTopic").val(),
                        userComment: e
                    },
                    a.guang.addToTopic.submit()}
                });
                b.find(".cancel").click(function() {
                    b.overlay().close()
                })
            }
        },
        init: function(b) {
            if (!a.guang.dialog.isLogin()) return ! 1;
            a.guang.addToTopic.proId = b.data("proid");
            a.guang.addToTopic.dialog();
            a.getJSON(GUANGER.path + "index.php?app=share&ac=do&le=getzhutiJSON&t=" + Math.floor(new Date / 10),
            function(c) {
                switch (c.code) {
                case 100:
                    a("#J_AddToTopicD").find("input[name='topicType'][value=0]").attr("checked", !0);
                    a("#J_HasTopicList").css("display", "block");
                    a("#J_GalleryScene").css("display", "none");
                    var d = [];
                    a.map(c.userTopics,
                    function(a) {
                        d.push('<option value="' + a.themeid + '">' + a.title + "</option>")
                    });
                    a.guang.addToTopic.topicsOptions = d.join("");
                    a("#J_SelTopic").html(a.guang.addToTopic.topicsOptions);
                    break;
                case 101:
                    a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                    a.guang.tip.show(b, "\u83b7\u53d6\u4e3b\u9898\u5931\u8d25\uff0c\u5237\u6d17\u9875\u9762\u518d\u8bd5\u4e00\u4e0b\uff01");
                    break;
                case 110:
                    a.guang.addToTopic.topicsOptions = "";
                    a.guang.addToTopic.dialog();
                    a("#J_HasTopicList").css("display", "none");
                    a("#J_AddToTopicD").find("input[name='topicType'][value=1]").attr("checked", !0);
                    a("#J_GalleryScene").fadeIn();
                    break;
                case 300:
                    a.guang.tip.conf.tipClass = "tipmodal tipmodal-error",
                    a.guang.tip.show(b, "\u4eb2\uff0c\u60a8\u53ef\u80fd\u672a\u767b\u5f55\u54e6\uff01")
                }
                var e = [];
                e.push('<option value="">\u9009\u62e9\u5206\u7c7b</option>');
                a.map(c.galleryList,
                function(a) {
                    e.push('<option value="' + a.name + '">' + a.name + "</option>")
                });
                a.guang.addToTopic.galleryOptions = e.join("");
                a("#J_SelCag").html(a.guang.addToTopic.galleryOptions);
               
            })
        }
    };
    a(".ilike-topic,.i-baobei").die().live("click",
    function() {
        a.guang.addToTopic.init(a(this))
    })
})(jQuery); 