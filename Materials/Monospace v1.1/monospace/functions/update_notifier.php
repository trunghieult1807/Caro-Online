<?php

function mts_update_notifier_menu() {  
	$xml = get_latest_theme_version(43200); // Cache the remote call for 43200 seconds (12 hours)
	$theme_data = wp_get_theme(); // Get the current version from style.css
	
	if(version_compare($theme_data['Version'], $xml->latest) == -1) {
		add_dashboard_page( __('Theme Update','mythemeshop'), __('Theme Update','mythemeshop') . '<span class="update-plugins count-1"><span class="update-count">'.__('1','mythemeshop').'</span></span>', 'administrator', 'mythemeshop-updates', 'mts_update_notifier');
	}
}  
add_action('admin_menu', 'mts_update_notifier_menu');

function mts_update_notifier() { 
	$xml = get_latest_theme_version(43200); // Cache the remote call for 43200 seconds (12 hours)
	$theme_data = wp_get_theme(); // Get the current version from style.css ?>
	
	<style>
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
		<h2><?php echo $theme_data['Name']; ?> <?php _e('Theme Updates','mythemeshop'); ?></h2>
	    <div id="message" class="updated below-h2"><p><strong><?php _e('There is a new version of the theme available.','mythemeshop'); ?></strong> <?php _e('You have installed version','mythemeshop'); ?> <?php echo $theme_data['Version']; ?>. <?php _e('Update to version','mythemeshop'); ?> <?php echo $xml->latest; ?>.</p></div>
        
        <img style="float: left; margin: 0 20px 20px 0; max-width: 300px;" src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
        
        <div id="instructions">
            <h3><?php _e('Update Download and Instructions','mythemeshop'); ?></h3>
            <p><strong><?php _e('Please note','mythemeshop'); ?>:</strong> <?php _e('make a backup</strong> of the Theme inside your WordPress installation folder','mythemeshop'); ?> <strong>/wp-content/themes/</strong></p>
            <p><?php _e('To update the Theme, login to your','mythemeshop'); ?> <a href="https://mythemeshop.com/go/member" target="_blank"><?php _e('MyThemeShop Account','mythemeshop'); ?></a>, <?php _e('head over to your <strong>Active Resources</strong> section and re-download the theme like you did when you bought it.','mythemeshop'); ?></p>
            <p><?php _e('Extract the zip\'s contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the','mythemeshop'); ?> <strong>/wp-content/themes/monospace/</strong> <?php _e('folder overwriting the old ones (this is why it\'s important to backup any changes you\'ve made to the theme files)','mythemeshop'); ?>.</p>
            <p><?php _e('If you didn\'t make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.','mythemeshop'); ?></p>
        </div>
        
            <div class="clear"></div>
	    
	    <h3 class="title"><?php _e('Changelog','mythemeshop'); ?></h3>
	    <?php echo $xml->changelog; ?>

	</div>
    
<?php } 

function get_latest_theme_version($interval) {
	// remote xml file location
	$notifier_file_url = 'http://mythemeshop.com/changelog/monospace.xml';
	
	$db_cache_field = 'contempo-notifier-cache';
	$db_cache_field_last_updated = 'contempo-notifier-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );			
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	$xml = simplexml_load_string($notifier_data); 
	
	return $xml;
}

?>
