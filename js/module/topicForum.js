(function(a) {
    var e = null;
    a(".share2 .a2").hover(function() {
        null != e && clearTimeout(e);
        a(".share2 .a3").slideDown()
    },
    function() {
        e = setTimeout(function() {
            a(".share2 .a3").slideUp()
        },
        1E3)
    });
    a(".share2 .a3").hover(function() {
        clearTimeout(e)
    },
    function() {
        e = setTimeout(function() {
            a(".share2 .a3").slideUp()
        },
        1E3)
    });
    var f = a("#J_LikeCount");
    a(".likes").hover(function() {
        f.text("+1")
    },
    function() {
        f.text(f.data("val"))
    });
    a(".ilike,.ilike-s").click(function() {
        if (a.guang.dialog.isLogin()) {
            var d = a(this);
            "disable" != d.data("enable") && (d.data("enable", "disable"), setTimeout(function() {
                d.data("enable", "enable")
            },
            1E3), a.guang.judgement.repeattaolunzuLikeClk = function(c) {
                c.data("enable", "enable");
                a("#cmtDialog")[0] && (a("#cmtDialog").remove(), clearTimeout(parseInt(c.data("timeout"), 10)));
                var b;
                b = '<div id="cmtDialog" class="c-dialog" style="width:180px"><p class="title clearfix"><a class="cmtclose fr" href="javascript:;">x</a>&gt;_&lt;\u559c\u6b22\u8fc7\u4e86~</p>' + ('<a class="sbl-btn speakmore" href="' + GUANGER.path  + GUANGER.topicurl + '#J_PostCmtSegment">\u518d\u8bf4\u4e24\u53e5</a>');
                a("body").append(b + "</div>");
                b = a.guang.util.getPosition(c).topMid();
                var h = a("#cmtDialog").outerWidth(),
                d = a("#cmtDialog").outerHeight();
                a("#cmtDialog").css({
                    left: b.x - h / 2 + "px",
                    top: b.y - d - 12 + "px"
                }).fadeIn();
                c.data("timeout", setTimeout(function() {
                    a("#cmtDialog").fadeOut()
                },
                3E3))
            },
            a.guang.judgement.taolunzuLikeCallback = function(c) {
                c.data("enable", "enable");
                f = a("#J_LikeCount");
                var b;
                b = '<div id="cmtDialog" class="c-dialog"><p class="title clearfix"><a class="cmtclose fr" href="javascript:;">x</a>\u559c\u6b22\u4e86~</p>' + ('<a class="sbl-btn speakmore" href="' + GUANGER.path  + GUANGER.topicurl + '#J_PostCmtSegment">\u518d\u8bf4\u4e24\u53e5</a>');
                a("body").append(b + "</div>");
                b = a.guang.util.getPosition(c).topMid();
                var d = a("#cmtDialog").outerWidth(),
                e = a("#cmtDialog").outerHeight();
                a("#cmtDialog").css({
                    left: b.x - d / 2 + "px",
                    top: b.y - e - 12 + "px"
                }).fadeIn();
                b = parseInt(f.text(), 10) + 1;
                f.text(b);
                c.data("timeout", setTimeout(function() {
                    a("#cmtDialog").fadeOut()
                },
                3E3))
            },
            a.guang.judgement.taolunzuLikeSubmit(d, {
                url: GUANGER.path + "index.php?app=share&ac=do&le=like-s",
                data: {
                    postid: GUANGER.themeid,
					commentType: 'z'
                }
            }))
        }
    });
    var g = a("#J_SideCmtContent");
    g.focus(function() {
        a.guang.dialog.isLogin()
    });
    a("#J_SideCmt").bind("click",
    function() {
        if (a.guang.dialog.isLogin()) {
            var d = a(this),
            c = g.val();
			
            0 == c.length || 1E4 < c.length ? (g.highlight({
                color: "#ed8585",
                speed: 500,
                complete: function() {},
                iterator: "sinusoidal"
            }), 0 != c.length && (a.guang.tip.conf.tipClass = "tipmodal tipmodal-error", a.guang.tip.show(d, "\u5185\u5bb9\u5c0f\u4e8e10000\u5b57\uff01"))) : (g.val(""), a.ajax({
                url: GUANGER.path + "index.php?app=share&ac=do&le=SideCmt",
                type: "post",
                dataType: "json",
                data: {
                    topicid: GUANGER.topicid,
                    content: c
                },
                success: function(b) {
                    switch (b.code) {
                    case 100:
						
                        var c = b.reply,
                        b = b.userLevel,
                        e = '<a href="'+GUANGER.path+'index.php?app=user&ac=space&userid='+GUANGER.userId+'" target="_blank">' + GUANGER.nick + "</a>";
                        b && "daren" == b && (e = '<a class="g-daren" href="'+GUANGER.path+'index.php?app=user&ac=space&userid='+GUANGER.userId+'" target="_blank"><em>' + GUANGER.nick + '</em><i class="i-daren">\u8fbe\u4eba</i></a>');
                        c = '<li><div class="user-pic"><a href="'+GUANGER.path+'index.php?app=user&ac=space&userid='+GUANGER.userId+'" target="_blank"><img src="' + GUANGER.face + '" width="30" height="30" alt="' + GUANGER.nick + '" title="' + GUANGER.nick + '"></a></div><div class="user-news">' + e + "\uff1a" + c.content + '<br/><span class="comment-time">' + c.showTime + "</span></div></li>";

                        a("#J_CmtList").prepend(c);
						
                        c = a("#J_CmtList li:last-child");
                        11 == a("#J_CmtList li").length && c.remove();
                        a.guang.goods.conf.colArray = [0, 0, 0, jQuery(".side").outerHeight() + 13];
                        a.guang.goods.init();
                        break;
                    case 101:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show(d, b.msg);
                        break;
                    case 200:
                        a.guang.dialog.login();
                        break;
						
					 case 201:
						g.highlight({
						color: "#ed8585",
						speed: 500,
						complete: function() {},
						iterator: "sinusoidal"
					})
						
						
                        break;

                    case 440:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show(d, "\u4f60\u5df2\u88ab\u7981\u8a00\uff01");
                        break;
                    case 441:
                        a.guang.tip.conf.tipClass = "tipmodal tipmodal-error";
                        a.guang.tip.show(d, "\u4eb2,\u64cd\u4f5c\u8fc7\u5feb\u4e86\u54e6,\u4f11\u606f\u7247\u523b\uff01");
                        break;
                    case 444:
                        alert("\u4f60\u5df2\u88ab\u7981\u6b62\u767b\u5f55\uff01"),
                        window.location.href = "#"
                    }
                }
            }))
        }
    })
})(jQuery);