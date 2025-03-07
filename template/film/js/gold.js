
var hadpingfen = 0;

function gold_init(){
	
	$("ul.rating li").each(function(i) {
		var $title = $(this).attr("title");
		var $lis = $("ul.rating li");
		var num = $(this).index();
		var n = num + 1;
		$(this).click(function () {
				if (hadpingfen > 0) {
					$.showfloatdiv({txt: '已经评分,请务重复评分'});
					$.hidediv({});
				}
				else {
					$.showfloatdiv({txt: '数据提交中...', cssname: 'loading'});
					$lis.removeClass("active");
					$("ul.rating li:lt(" + n + ")").addClass("active");
					$("#ratewords").html($title);
				}
			}
		).hover(function () {
			this.myTitle = this.title;
			this.title = "";
			$(this).nextAll().removeClass("active");
			$(this).prevAll().addClass("active");
			$(this).addClass("active");
			$("#ratewords").html($title);
		}, function () {
			this.title = this.myTitle;
			$("ul.rating li:lt(" + n + ")").removeClass("hover");
		});
	});
	$(".rating-panle").hover(function(){
		$(this).find(".rating-show").show();
	},function(){
		$(this).find(".rating-show").hide();
	});
}
gold_init();