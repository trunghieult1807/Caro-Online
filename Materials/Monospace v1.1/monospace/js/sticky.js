jQuery(document).ready(function() {
	function isScrolledTo(elem) {
		var docViewTop = jQuery(window).scrollTop(); //num of pixels hidden above current screen
		var docViewBottom = docViewTop + jQuery(window).height();

		var elemTop = jQuery(elem).offset().top; //num of pixels above the elem
		var elemBottom = elemTop + jQuery(elem).height();

		return ((elemTop <= docViewTop));
	}

	var catcher = jQuery('#catcher');
	var sticky = jQuery('#sticky');
	
	jQuery(window).scroll(function() {
		if(isScrolledTo(sticky)) {
			sticky.css({'position':'fixed','top':'0', 'z-index':'1000', 'width':'100%', 'max-width':'1060px', 'padding':'5px 0'});
			$('#header').css({'margin-top':'0'});
			sticky.addClass('floating');
		} 
		var stopHeight = catcher.offset().top + catcher.height();
		if ( stopHeight >= sticky.offset().top) {
			sticky.css({'position':'relative','top':'auto', 'padding':'0'});
			$('#header').css({'margin-top':'60px'});
			sticky.removeClass('floating');
		}
	});
});