$(document).ready(function(){
	/* Global navigation
	--------------------------------------------------------------------------------------- */
	$("#global-nav>li>ul").addClass("sub-away").show().hide(); // Remove CSS interaction and hide
	$("#global-nav>li").has("ul.sub-away").hover(
		function(){
			$(this).children("ul").stop(false, true).fadeIn(500).animate({top: 30}, {duration: 200, queue: false});
		}, function(){
			$(this).children("ul").stop(false, true).fadeOut(100).animate({top: 120}, {duration: 200, queue: false});
		}
	);
	

});