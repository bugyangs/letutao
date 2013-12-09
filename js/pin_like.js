$(function() {
	
	var a;
	//$(".ilike-m").css("display","none");
	/* 喜欢 */
	$(".ilike-m,.ilike-n,a[rel=like]").live("click",function(){
		if($.guang.dialog.isLogin()){
			var $this = $(this);
			var commentType = $this.attr("data-type");
			var productId = $this.attr("data-proid");
			var $likeCount = $this.closest(".goods").find(".like-count:first");
			var $likeCount2 = $this.closest(".goods").find(".like-count:eq(1)");
			if($("#cmtDialog")[0]){
				$("#cmtDialog").fadeOut();
			}
			$.guang.judgement.repeatIdentityClk = function(o, commentType){

				$.guang.dialog.lkComment($this,'喜欢过了，再说两句');
			}
			$.guang.judgement.identityCallback = function(o, commentType){
				$likeCount.text(parseInt($likeCount.text()) + 1);
				$likeCount2.text(parseInt($likeCount2.text()) + 1);
				$.guang.dialog.lkComment($this,'喜欢了');
			}
			$.guang.judgement.identityOper($this, productId, commentType);
		}
	});
	

});