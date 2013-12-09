$(function() {
		//分页
	
	var $page = $("#J_Pagination");
	var initPagination = function() {
		var num_entries = goodsPage.sumGoodsNum;//商品总数
		// 创建分页
		$page.pagination(num_entries, {
		    num_edge_entries: 2,//两侧显示的首尾分页的条目数
		    num_display_entries: 4,//连续分页主体部分显示的分页条目数
		    callback: pageselectCallback,//回调函数
		    items_per_page:100,
		    current_page:(parseInt(goodsPage.curPageNum)-1),
		    isJump:true
		});
	 }();
	 
	function pageselectCallback(page_index, jq){
		var urltype=goodsPage.urlType;
		var pageA = $page.find("a");
		var prevA = $page.find("a.prev");
		var nextA = $page.find("a.next");
		var pageUrl = goodsPage.pageUrl;
		var sort = goodsPage.sort;
		var tagid = goodsPage.tagid;
		var cateId = goodsPage.cateId;
		var kw = goodsPage.kw;
		pageA.each(function(){
			if(sort !="" || tagid !="" || cateId !="" || kw !=""){
				if(urltype=="1"){
					$(this).attr("href",pageUrl + "&p=" + $(this).text());
				}else{
					$(this).attr("href",pageUrl + "/p-" + $(this).text());	
				}
			}else{
				if(urltype=="1"){
					$(this).attr("href",pageUrl + "&p=" + $(this).text());
				}else{
					$(this).attr("href",pageUrl + "/p-" + $(this).text());	
				}
			}
		});
		if(prevA[0]){
			if(sort!="" || tagid!="" || cateId!=""  || kw !=""){
				if(urltype=="1"){
					prevA.attr("href",pageUrl + "&p=" + (parseInt(goodsPage.curPageNum) - 1));
				}else{
					prevA.attr("href",pageUrl + "/p-" + (parseInt(goodsPage.curPageNum) - 1));	
				}
			}else{
				if(urltype=="1"){
					prevA.attr("href",pageUrl + "&p=" + (parseInt(goodsPage.curPageNum) - 1));
				}else{
					prevA.attr("href",pageUrl + "/p-" + (parseInt(goodsPage.curPageNum) - 1));	
				}
				}
		}
		if(nextA[0]){
			if(sort!="" || tagid!="" || cateId!=""  || kw !=""){
				if(urltype=="1"){
			    	nextA.attr("href",pageUrl + "&p=" + (parseInt(goodsPage.curPageNum) + 1));
				}else{
					nextA.attr("href",pageUrl + "/p-" + (parseInt(goodsPage.curPageNum) + 1));	
				}
			}else{
				if(urltype=="1"){
			    	nextA.attr("href",pageUrl + "&p=" + (parseInt(goodsPage.curPageNum) + 1));
				}else{
				nextA.attr("href",pageUrl + "/p-" + (parseInt(goodsPage.curPageNum) + 1));	
				}
			}
		}
		pageA.live("click",function(){
			window.location.href = $(this).attr("href");
		});
		return false;
	}	
	

});