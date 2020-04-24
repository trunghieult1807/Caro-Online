<form method="get" id="searchform" class="search-form" action="<?php echo home_url(); ?>" _lpchecked="1">
	<fieldset>
		<input type="text" name="s" id="s" value="<?php _e('Search the site','mythemeshop'); ?>" onblur="if (this.value == '') {this.value = '<?php _e('Search the site','mythemeshop'); ?>';}" onfocus="if (this.value == '<?php _e('Search the site','mythemeshop'); ?>') {this.value = '';}" >
		<input id="search-image" class="sbutton" type="submit" value="">
		<i class="icon-search"></i>
	</fieldset>
</form>