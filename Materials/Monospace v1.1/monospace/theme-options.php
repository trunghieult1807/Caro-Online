<?php
/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );
/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'mythemeshop'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'mythemeshop'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;
//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'mythemeshop');

//Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
										'link' => 'http://twitter.com/mythemeshopteam',
										'title' => 'Follow Us on Twitter', 
										'img' => NHP_OPTIONS_URL.'img/glyphicons/twitter.png'
										);
$args['share_icons']['linked_in'] = array(
										'link' => 'http://www.facebook.com/mythemeshop',
										'title' => 'Like us on Facebook', 
										'img' => NHP_OPTIONS_URL.'img/glyphicons/facebook.png'
										);

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = 'monospace';

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __('Theme Options', 'mythemeshop');

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Theme Options', 'mythemeshop');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = 'theme_options';

//Custom page capability - default is set to "manage_options"
//$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';

//parent menu - default is set to "themes.php" (Appearance)
//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'themes.php';

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

//Custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';
		
//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition		
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-1',
							'title' => __('Support', 'mythemeshop'),
							'content' => __('<p>If you are facing any problem with our theme or theme option panel, head over to our <a href="http://mythemeshop.com/support">Knowledge Base</a></p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-3',
							'title' => __('Credit', 'mythemeshop'),
							'content' => __('<p>Options Panel created using the <a href="http://leemason.github.com/NHP-Theme-Options-Framework/" target="_blank">NHP Theme Options Framework</a> Version 1.0.5</p>', 'mythemeshop')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-2',
							'title' => __('Earn Money', 'mythemeshop'),
							'content' => __('<p>Earn 60% commision on every sale by refering your friends and readers. Join our <a href="http://mythemeshop.com/affiliate-program/">Affiliate Program</a>.</p>', 'mythemeshop')
							);

//Set the Help Sidebar for the options page - no sidebar by default										
//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'mythemeshop');



$sections = array();

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/generalsetting.png',
				'title' => __('General Settings', 'mythemeshop'),
				'desc' => __('<p class="description">This tab contains common setting options which will be applied to whole theme.</p>', 'mythemeshop'),
				'fields' => array(
				
					array(
						'id' => 'mts_logo',
						'type' => 'upload',
						'title' => __('Logo Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your logo <strong>(Recommended size 190x30px)</strong> using the Upload Button or insert image URL.', 'mythemeshop')
						),
					array(
						'id' => 'mts_favicon',
						'type' => 'upload',
						'title' => __('Favicon', 'mythemeshop'), 
						'sub_desc' => __('Upload a <strong>16 x 16 px</strong> image that will represent your website\'s favicon. You can refer to this link for more information on how to make it: <a href="http://www.favicon.cc/" target="blank" rel="nofollow">http://www.favicon.cc/</a>', 'mythemeshop')
						),
					array(
						'id' => 'mts_twitter_username',
						'type' => 'text',
						'title' => __('Twitter Username', 'mythemeshop'),
						'sub_desc' => __('Enter your Username here.', 'mythemeshop'),
						),
					array(
						'id' => 'mts_feedburner',
						'type' => 'text',
						'title' => __('FeedBurner URL', 'mythemeshop'),
						'sub_desc' => __('Enter your FeedBurner\'s URL here, ex: <strong>http://feeds.feedburner.com/mythemeshop</strong> and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'mythemeshop'),
						'validate' => 'url'
						),
					array(
						'id' => 'mts_header_code',
						'type' => 'textarea',
						'title' => __('Header Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the code which you need to place <strong>before closing </head> tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'mythemeshop')
						),
					array(
						'id' => 'mts_analytics_code',
						'type' => 'textarea',
						'title' => __('Footer Code', 'mythemeshop'), 
						'sub_desc' => __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'mythemeshop')
						),
					array(
						'id' => 'mts_copyrights',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'mythemeshop'), 
						'sub_desc' => __('You can change or remove our link from footer and use your own custom text. (Link back is always appreciated)', 'mythemeshop'),
						'std' => 'Theme by <a href="http://mythemeshop.com/">MyThemeShop</a>'
						),
					array(
						'id' => 'mts_featured_slider',
						'type' => 'button_set_hide_below',
						'title' => __('Homepage Slider', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> a homepage slider by using this check box. This slider will show 5 recent articles from the selected category.', 'mythemeshop'),
						'std' => '0'
						),
						array(
						'id' => 'mts_featured_slider_cat',
						'type' => 'cats_multi_select',
						'title' => __('Slider Category(s)', 'mythemeshop'), 
						'sub_desc' => __('Select a category from the drop-down menu, latest 5 articles from this category will be shown <strong>in slider</strong>. Use ctrl key to select more than one category.', 'mythemeshop'),
						'args' => array('number' => '100')
						),
					array(
						'id' => 'mts_featured_tab_1',
						'type' => 'button_set_hide_below',
						'title' => __('HomePage Featured Section', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> Homepage Featured Section by using this check box. This section will show recent articles from the selected category.', 'mythemeshop'),
						'std' => '0'
						),
						array(
						'id' => 'mts_featured_tab_1_cat',
						'type' => 'cats_select',
						'title' => __('HomePage Featured Section Category', 'mythemeshop'), 
						'sub_desc' => __('Select a category from the drop-down menu, latest articles from this category will be shown in <strong>Homepage Featured Section</strong>.', 'mythemeshop'),
						'args' => array('number' => '100'),
						'std' => '1',
						),
					array(
						'id' => 'mts_media_section',
						'type' => 'button_set_hide_below',
						'title' => __('Media Section', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('<strong>Enable or Disable</strong> Media Section by using this check box. This section will show thumbnails of recent articles from the selected category.', 'mythemeshop'),
						'std' => '0'
						),
						array(
						'id' => 'mts_media_section_cat',
						'type' => 'cats_select',
						'title' => __('Media Section Category', 'mythemeshop'), 
						'sub_desc' => __('Select a category from the drop-down menu, thumbnails of latest articles from this category will be shown in <strong>Media Section</strong>.', 'mythemeshop'),
						'args' => array('number' => '100'),
						'std' => '1',
						),
					array(
						'id' => 'mts_pagenavigation',
						'type' => 'button_set_hide_below',
						'title' => __('Pagination', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable paginated navigation links.', 'mythemeshop'),
						'std' => '1'
						),
						array(
                        'id' => 'mts_pagenavigation_type',
                        'type' => 'radio',
                        'title' => __('Pagination Type', 'mythemeshop'),
                        'sub_desc' => __('Select pagination type.', 'nhp-opts'),
                        'options' => array('1' => __('Numbered(1 2 3 4...)','mythemeshop'),'2' => __('Next / Previous','mythemeshop')),
                        'std' => '1'
                        ),
					array(
						'id' => 'mts_prefetching',
						'type' => 'button_set',
						'title' => __('Prefetching', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in Chrome.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_home_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('HomePage Post Meta Info.', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info on HomePage. (<strong>Author name, Date etc.</strong>).', 'mythemeshop'),
						'std' => '1'
						),
						array(
                        'id' => 'mts_home_headline_meta_info',
                        'type' => 'multi_checkbox',
                        'title' => __('Meta Info to Show', 'mythemeshop'),
                        'sub_desc' => __('Choose What Meta Info to Show.', 'mythemeshop'),
                        'options' => array('a' => __('Author Name','mythemeshop'), 'b' => __('Comment Count','mythemeshop'), 'c' => __('Date','mythemeshop'), 'd' => __('Categories','mythemeshop')),
                        'std' => array('a' => '1', 'b' => '1', 'c' => '1', 'd' => '1')
                        ),
                    array(
						'id' => 'mts_home_post_format_icon',
						'type' => 'button_set',
						'title' => __('Post Format Icon on HomePage', 'mythemeshop'), 
						'options' => array('0' => 'Hide','1' => 'Show'),
						'sub_desc' => __('<strong>Show or Hide</strong> Post format icons present on HomePage.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_theme_update',
						'type' => 'button_set',
						'title' => __('Theme Update Notification', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Theme Update notification on dashboard. <strong>We recommend to keep this option ON</strong>, so you can see notification of latest theme updates.', 'mythemeshop'),
						'std' => '0'
						),
					)
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/stylesetting.png',
				'title' => __('Styling Options', 'mythemeshop'),
				'desc' => __('<p class="description">Control the visual appearance of your theme, such as colors, layout and patterns, from here.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme', 'mythemeshop'), 
						'sub_desc' => __('Theme comes with unlimited color schemes for your theme\'s styling.', 'mythemeshop'),
						'std' => '#f5ad34'
						),
					array(
						'id' => 'mts_color_scheme_sec',
						'type' => 'color',
						'title' => __('Secondary Color', 'mythemeshop'), 
						'sub_desc' => __('The second main color of the theme', 'mythemeshop'),
						'std' => '#de5c28'
						),
					array(
						'id' => 'mts_color_scheme_third',
						'type' => 'color',
						'title' => __('Third Color', 'mythemeshop'), 
						'sub_desc' => __('The third main color used in the theme', 'mythemeshop'),
						'std' => '#00a762'
						),
					array(
						'id' => 'mts_grid_layout',
						'type' => 'button_set',
						'title' => __('Homepage Layout Style', 'mythemeshop'), 
						'options' => array('0' => 'Blog','1' => 'Grid'),
						'sub_desc' => __('Choose tradition blog layout or beautiful grid layout for homepage.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_layout',
						'type' => 'radio_img',
						'title' => __('Layout Style', 'mythemeshop'), 
						'sub_desc' => __('Choose from <strong>2 different Universal layouts</strong> for your site.<br/><strong>[C]</strong>: Content<br/><strong>[S]</strong>: Sidebar.<br/><strong>Note:</strong> Grid Layout don\'t have sidebar on homepage.', 'mythemeshop'),
						'options' => array(
										'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
										'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
											),
						'std' => 'cslayout'
						),
					array(
						'id' => 'mts_single_post_layout',
						'type' => 'radio_img',
						'title' => __('Single Post Layout', 'mythemeshop'), 
						'sub_desc' => __('Choose from <strong>4 different single post layouts</strong> for your site. Sidebar\'s position can be adjusted from HomePage Layout options. <br/><strong>[1]</strong>: Content <br/><strong>[2]</strong>: Related Posts', 'mythemeshop'),
						'options' => array(
										'crlayuot' => array('img' => NHP_OPTIONS_URL.'img/layouts/cr.png'),
										'rclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/rc.png'),
										'cbrlayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cbr.png'),
										'clayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/c.png')
											),
						'std' => 'cbrlayout'
						),
					array(
						'id' => 'mts_bg_color',
						'type' => 'color',
						'title' => __('Background Color', 'mythemeshop'), 
						'sub_desc' => __('Pick any color using the <strong>color picker</strong>, or enter a hex color value in the input field to make it the site background color for your theme.', 'mythemeshop'),
						'std' => '#eeeeee'
						),
					array(
						'id' => 'mts_bg_pattern',
						'type' => 'radio_img',
						'title' => __('Background Pattern', 'mythemeshop'), 
						'sub_desc' => __('Choose from any of <strong>65</strong> awesome background patterns for your site\'s background.', 'mythemeshop'),
						'options' => array(
										'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
										'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
										'hbg1' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg1.png'),
										'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
										'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
										'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
										'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
										'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
										'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
										'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
										'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
										'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
										'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
										'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
										'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
										'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
										'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
										'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
										'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
										'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
										'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
										'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
										'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
										'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
										'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
										'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
										'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png'),
										'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
										'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
										'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
										'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
										'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
										'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
										'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
										'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
										'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
										'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
										'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
										'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
										'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
										'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
										'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
										'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
										'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
										'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
										'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
										'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
										'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
										'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
										'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
										'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
										'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
										'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
										'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
										'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
										'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
										'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
										'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
										'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
										'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
										'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
										'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
										'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
										'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
										'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
										'pattern38' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern38.png'),
											),
						'std' => 'hbg1'
						),
					array(
						'id' => 'mts_bg_pattern_upload',
						'type' => 'upload',
						'title' => __('Custom Background Image', 'mythemeshop'), 
						'sub_desc' => __('Upload your own custom background image or pattern.', 'mythemeshop')
						),
					array(
						'id' => 'mts_custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'mythemeshop'), 
						'sub_desc' => __('You can enter your own custom CSS here to further customize your theme. This will override the default CSS used on your site.', 'mythemeshop')
						),
					array(
						'id' => 'mts_responsive',
						'type' => 'button_set',
						'title' => __('Responsiveness', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('MyThemeShop themes are responsive, which means they adapt to tablet and mobile devices, ensuring that your content is always displayed beautifully no matter what device visitors are using. Enable or disable responsiveness using this option.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_lightbox',
						'type' => 'button_set',
						'title' => __('Lightbox', 'mythemeshop'),
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'mythemeshop'),
						'std' => '0'
						),																		
					)
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/header.png',
				'title' => __('Header', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the elements of header section.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_sticky_nav',
						'type' => 'button_set',
						'title' => __('Floating Navigation Menu', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to enable <strong>Floating Navigation Menu</strong>.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_header_section2',
						'type' => 'button_set',
						'title' => __('Show Logo', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide <strong>Logo</strong> completely.', 'mythemeshop'),
						'std' => '1'
						)
					)
				);	
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/singlepost.png',
				'title' => __('Single Posts', 'mythemeshop'),
				'desc' => __('<p class="description">From here, you can control the appearance and functionality of your single posts page.</p>', 'mythemeshop'),
				'fields' => array(					
					array(
						'id' => 'mts_single_headline_meta',
						'type' => 'button_set_hide_below',
						'title' => __('Post Meta Info.', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to Show or Hide Post Meta Info <strong>Author name and Categories</strong>.', 'mythemeshop'),
						'std' => '1'
						),
					array(
 						'id' => 'mts_single_headline_meta_info',
 						'type' => 'multi_checkbox',
 						'title' => __('Meta Info to Show', 'mythemeshop'),
 						'sub_desc' => __('Choose What Meta Info to Show.', 'mythemeshop'),
 						'options' => array('4' => __('Author Name','mythemeshop'),'5' => __('Date','mythemeshop'),'6' => __('Categories','mythemeshop'),'7' => __('Comment Count','mythemeshop')),
 						'std' => array('4' => '1', '5' => '1', '6' => '1', '7' => '1')
 						),
					array(
						'id' => 'mts_breadcrumb',
						'type' => 'button_set',
						'title' => __('Breadcrumbs', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_author_comment',
						'type' => 'button_set',
						'title' => __('Highlight Author Comment', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to highlight author comments.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_tags',
						'type' => 'button_set',
						'title' => __('Tag Links', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to show a tag cloud below the related posts.', 'mythemeshop'),
						'std' => '0'
						),
					array(
						'id' => 'mts_author_box',
						'type' => 'button_set',
						'title' => __('Author Box', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button if you want to display author information below the article.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_comment_date',
						'type' => 'button_set',
						'title' => __('Date in Comments', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Use this button to show the date for comments.', 'mythemeshop'),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/socialsetting.png',
				'title' => __('Social Buttons', 'mythemeshop'),
				'desc' => __('<p class="description">Enable or disable social sharing buttons on single posts using these buttons.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_social_buttons',
						'type' => 'button_set_hide_below',
						'title' => __('Social Media Buttons', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'sub_desc' => __('Check this box to show social sharing buttons after an article\'s content text.', 'mythemeshop'),
						'std' => '1'
						),
					array(
						'id' => 'mts_social_button_position',
						'type' => 'button_set',
						'title' => __('Social Sharing Buttons Position', 'mythemeshop'), 
						'options' => array('1' => __('Above Content','mythemeshop'),'2' => __('Below Content','mythemeshop'),'3' => __('Floating','mythemeshop')),
						'sub_desc' => __('Choose position for Social Sharing Buttons.', 'mythemeshop'),
						'std' => '3'
						),
					array(
						'id' => 'mts_twitter',
						'type' => 'button_set',
						'title' => __('Twitter', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_gplus',
						'type' => 'button_set',
						'title' => __('Google Plus', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_facebook',
						'type' => 'button_set',
						'title' => __('Facebook Like', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					array(
						'id' => 'mts_linkedin',
						'type' => 'button_set',
						'title' => __('LinkedIn', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_stumble',
						'type' => 'button_set',
						'title' => __('StumbleUpon', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '0'
						),
					array(
						'id' => 'mts_pinterest',
						'type' => 'button_set',
						'title' => __('Pinterest', 'mythemeshop'), 
						'options' => array('0' => 'Off','1' => 'On'),
						'std' => '1'
						),
					)
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/adsetting.png',
				'title' => __('Ad Management', 'mythemeshop'),
				'desc' => __('<p class="description">Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.</p>', 'mythemeshop'),
				'fields' => array(
					array(
						'id' => 'mts_posttop_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Title', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_posttop_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad before it expires. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text'
						),
					array(
						'id' => 'mts_postend_adcode',
						'type' => 'textarea',
						'title' => __('Below Post Content', 'mythemeshop'), 
						'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'mythemeshop')
						),
					array(
						'id' => 'mts_postend_adcode_time',
						'type' => 'text',
						'title' => __('Show After X Days', 'mythemeshop'), 
						'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad before it expires. Enter 0 to disable this feature.', 'mythemeshop'),
						'validate' => 'numeric',
						'std' => '0',
						'class' => 'small-text'
						),
					)
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/fontsetting.png',
				'title' => __('Fonts', 'mythemeshop'),
				'desc' => __('<p class="description"><div class="controls">You can find theme font options under the Appearance Section named <a href="themes.php?page=typography"><b>Theme Typography</b></a>, which will allow you to configure the typography used on your site.<br></div></p>', 'mythemeshop'),
				);
$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'img/glyphicons/navsetting.png',
				'title' => __('Navigation', 'mythemeshop'),
				'desc' => __('<p class="description"><div class="controls">Navigation settings can now be modified from the <a href="nav-menus.php"><b>Menus Section</b></a>.<br></div></p>', 'mythemeshop')
				);
				
				
	$tabs = array();

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function

/*--------------------------------------------------------------------
 * 
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('register_typography')) { 
  register_typography(array(
    'content_font' => array(
      'preview_text' => 'Content',
      'preview_color' => 'dark',
      'font_family' => 'Open Sans',
      'font_size' => '14px',
      'font_variant' => 'normal',
      'font_color' => '#B0B1B3',
      'css_selectors' => 'body'
    ),
    'logo_font' => array(
      'preview_text' => 'Site Title Font',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '30px',
      'font_color' => '#f5ad34',
      'css_selectors' => '#logo a'
    ),
    'site-description' => array(
      'preview_text' => 'Site Description Font',
      'preview_color' => 'dark',
      'font_family' => 'Open Sans',
      'font_variant' => '300',
      'font_size' => '14px',
      'font_color' => '#b0b1b3',
      'css_selectors' => '.site-description'
    ),
    'navigation_font' => array(
      'preview_text' => 'Navigation Font',
      'preview_color' => 'dark',
      'font_family' => 'Open Sans',
      'font_variant' => '300',
      'font_size' => '14px',
      'font_color' => '#b0b1b3',
      'css_selectors' => '.menu li, .menu li a'
    ),
    'h1_featured_postitle' => array(
      'preview_text' => 'Featured Post Title',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#ffffff',
      'css_selectors' => 'article.first header h1 a'
    ),
    'h2_featured_headline' => array(
      'preview_text' => 'Featured Section Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#ffffff',
      'css_selectors' => '.latestPost.first .featured-title h2'
    ), 
    'h1_headline' => array(
      'preview_text' => 'H1 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '28px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h1, single_post h1.title, single_page h1.title'
    ),
    'h2_headline' => array(
      'preview_text' => 'H2 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '24px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h2'
    ),   
    'h3_headline' => array(
      'preview_text' => 'H3 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '20px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h3'
    ),
    'h4_headline' => array(
      'preview_text' => 'H4 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h4'
    ),
    'h5_headline' => array(
      'preview_text' => 'H5 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '18px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h5'
    ),
    'h6_headline' => array(
      'preview_text' => 'H6 Headline',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_variant' => 'normal',
      'font_size' => '16px',
      'font_color' => '#ffffff',
      'css_selectors' => 'h6'
    ),
    'latestpost_author' => array(
      'preview_text' => 'Author\'s name',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_size' => '14px',
      'font_variant' => 'normal',
      'font_color' => '#d3d4d6',
      'css_selectors' => '.latest-post-data .theauthor a, .latest-post-data .readMore a'
    ),
    'latestpost_title' => array(
      'preview_text' => 'Latest Posts title',
      'preview_color' => 'dark',
      'font_family' => 'Bree Serif',
      'font_size' => '18px',
      'font_variant' => 'normal',
      'font_color' => '#f1f1f2',
      'css_selectors' => '.latest-post-data h2 a, .latest-post-data a h2 '
    )    
  ));
}

?>