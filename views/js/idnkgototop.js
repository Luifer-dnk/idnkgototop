
$(document).ready(function(){

	// hide #back-top first
	$("#gotoTop").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#gotoTop').fadeIn();
			} else {
				$('#gotoTop').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#gotoTop').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});