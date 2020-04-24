/*----------------------------------------------------
/* Scroll to top
/*--------------------------------------------------*/
jQuery(document).ready(function() {
    //START -- MOVE-TO-TOP ARROW
	//move-to-top arrow
	jQuery("body").prepend("<div id='move-to-top' class='animate '>&#9650;</div>");
	var scrollDes = 'html,body';  
	/*Opera does a strange thing if we use 'html' and 'body' together so my solution is to do the UA sniffing thing*/
	if(navigator.userAgent.match(/opera/i)){
		scrollDes = 'html';
	}
	//show ,hide
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 160) {
			jQuery('#move-to-top').addClass('filling').removeClass('hiding');
		} else {			
			jQuery('#move-to-top').removeClass('filling').addClass('hiding');
		}
	});
	// scroll to top when click 
	jQuery('#move-to-top').click(function () {
		jQuery(scrollDes).animate({ 
			scrollTop: 0
		},{
			duration :500
		});
	});
	//END -- MOVE-TO-TOP ARROW
});

jQuery(document).ready(function() {
	jQuery("a[href$='.jpg'], a[href$='.jpeg'], a[href$='.gif'], a[href$='.png'], a[rel^='prettyPhoto']").prettyPhoto({
		slideshow: 5000,
		autoplay_slideshow: false,
		animationSpeed: 'normal',
		padding: 40,
		opacity: 0.35,
		showTitle: true,
		social_tools: false,
	});
})

jQuery(document).ready(function() {
jQuery('a[href^="#"]').click(function() {
var target = jQuery(this.hash);
if (target.length == 0) target = jQuery('a[name="' + this.hash.substr(1) + '"]');
if (target.length == 0) target = jQuery('html');
jQuery('html, body').animate({ scrollTop: target.offset().top }, 500);
return false;
});
});

!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");