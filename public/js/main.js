$(function() {
	
	

	$.scrollify({
		section:".panel"
	});
	

	$(".scroll").click(function(e) {
		e.preventDefault();
		$.scrollify("move",$(this).attr("href"));
	});
});