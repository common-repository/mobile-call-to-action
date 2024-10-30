;(function($){
	$(document).ready(function() {
		$(window).scroll(function() {
			var y = $(this).scrollTop();
			var w = $(this).width();
			$(window).resize(function() {
				var w = $(this).width();
				if( y > 60 && w < 768 ) {
					$('.mcta-wrapper').show();
				} else {
					$('.mcta-wrapper').hide();
				}
			});
			if( y > 60 && w < 768 ) {
				$('.mcta-wrapper').show();
			} else {
				$('.mcta-wrapper').hide();
			}
		});
	});
})(jQuery);