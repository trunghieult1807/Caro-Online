jQuery(document).ready(function(){
	jQuery('.buttonset').buttonset();
});

jQuery(document).ready(function(){
	jQuery('.form-table').delegate(".ui-buttonset .ui-button", "click", function(event){
        jQuery("html, body").animate({ scrollTop: jQuery(this).parent(".ui-buttonset").offset().top - 100 }, 600);
	});
});