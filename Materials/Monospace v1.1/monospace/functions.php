<?php
/*-----------------------------------------------------------------------------------*/
/*	Do not remove these lines, sky will fall on your head.
/*-----------------------------------------------------------------------------------*/
require_once( dirname( __FILE__ ) . '/theme-options.php' );
include("functions/tinymce/tinymce.php");
if ( ! isset( $content_width ) ) $content_width = 1060;

/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'mythemeshop', get_template_directory().'/lang' );
if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/*  Disable theme updates from WordPress.org theme repository
/*-----------------------------------------------------------------------------------*/
// Check if MTS Connect plugin already done this
if ( !class_exists('mts_connection') ) {
    // If wrong updates are already shown, delete transient so that we can run our workaround
    if ( false === get_option( 'mts_wp_org_updates_disabled' ) ) { // check only once
        update_option( 'mts_wp_org_updates_disabled', 'disabled' );

        delete_site_transient('update_themes' );
        delete_site_transient('update_plugins' );
    }
    // Hide mts themes/plugins
    add_action('admin_init', 'mts_remove_themes_plugins_from_update', 20 );
    function mts_remove_themes_plugins_from_update() {
        if ( $themes_transient = get_site_transient( 'update_themes' ) ) {
            if ( property_exists( $themes_transient, 'response' ) && is_array( $themes_transient->response ) ) {
                foreach ( $themes_transient->response as $key => $value ) {
                    $theme = wp_get_theme( $value['theme'] );
                    $theme_uri = $theme->get( 'ThemeURI' );
                    if ( 0 !== strpos( $theme_uri, 'mythemeshop.com' ) ) {
                        unset( $themes_transient->response[$key] );
                    }
                }
                set_site_transient( 'update_themes', $themes_transient );
            }
        }
        if ( $plugins_transient = get_site_transient( 'update_plugins' ) ) {
            if ( property_exists( $plugins_transient, 'response' ) && is_array( $plugins_transient->response ) ) {
                foreach ( $plugins_transient->response as $key => $value ) {
                    $plugin = get_plugin_data( WP_PLUGIN_DIR.'/'.$key, false, false );
                    $plugin_uri = $plugin['PluginURI'];
                    if ( 0 !== strpos( $plugin_uri, 'mythemeshop.com' ) ) {
                        unset( $plugins_transient->response[$key] );
                    }
                }
                set_site_transient( 'update_plugins', $plugins_transient );
            }
        }
    }

}
// Disable auto update
add_filter( 'auto_update_theme', '__return_false' );

/*-----------------------------------------------------------------------------------*/
/*	Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
if ( function_exists( 'add_theme_support' ) ) { 
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 150, true );
	add_image_size( 'featured', 270, 300, true ); //featured
	add_image_size( 'featured2', 300, 150, true ); //featured big
	add_image_size( 'featured3', 200, 220, true ); //featured long
	add_image_size( 'widgetthumb', 70, 70, true ); //Widget thumb & Related Posts
	add_image_size( 'widgetthumb3', 80, 85, true ); //widget thumb & Related Posts
	add_image_size( 'slider', 860, 360, true ); //slider
	add_image_size( 'slider_thumb', 200, 120, true ); //slider thumb
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Menu Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		  'primary-menu' => 'Primary Menu'
		)
	);
}

/*-----------------------------------------------------------------------------------*/
/*	Enable Widgetized sidebar and Footer
/*-----------------------------------------------------------------------------------*/
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name'=>'Sidebar',
		'description'   => __( 'Appears on Posts and Pages.', 'mythemeshop' ),
		'before_widget' => '<li id="%1$s" class="widget widget-sidebar %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Left Footer',
		'description'   => __( 'Appears in left side of footer.', 'mythemeshop' ),
		'id' => 'footer-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Center Footer',
		'description'   => __( 'Appears in center of footer.', 'mythemeshop' ),
		'id' => 'footer-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Right Footer',
		'description'   => __( 'Appears in right side of footer.', 'mythemeshop' ),
		'id' => 'footer-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

/*-----------------------------------------------------------------------------------*/
/*  Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/
// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad300.php");

// Add the Tabbed Custom Widget
include("functions/widget-tabs.php");

// Add the Latest Tweets Custom Widget
include("functions/widget-tweets.php");

// Add the Theme Shortcodes
include("functions/theme-shortcodes.php");

// Add Recent Posts Widget
include("functions/widget-recentposts.php");

// Add Related Posts Widget
include("functions/widget-relatedposts.php");

// Add Popular Posts Widget
include("functions/widget-popular.php");

// Add Facebook Like box Widget
include("functions/widget-fblikebox.php");

// Add Google Plus box Widget
include("functions/widget-googleplus.php");

// Add Subscribe Widget
include("functions/widget-subscribe.php");

// Add Social Profile Widget
include("functions/widget-social.php");

// Add Category Posts Widget
include("functions/widget-catposts.php");

// Add Welcome message
include("functions/welcome-message.php");

// Theme Functions
include("functions/theme-actions.php");

// Plugin Activation
include("functions/class-tgm-plugin-activation.php");

if($mts_options['mts_theme_update'] == '1') {
// Update Notification
include("functions/update_notifier.php");
}

/*-----------------------------------------------------------------------------------*/
/*	Filters customize wp_title
/*-----------------------------------------------------------------------------------*/
function mts_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'mythemeshop' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'mts_wp_title', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*	Javascsript
/*-----------------------------------------------------------------------------------*/
function mts_add_scripts() {
	$mts_options = get_option('monospace');

	wp_enqueue_script('jquery');

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_register_script('customscript', get_template_directory_uri() . '/js/customscript.js', true);
	wp_enqueue_script ('customscript');

	//Slider
	wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');
	wp_enqueue_script ('flexslider');
	
    wp_enqueue_script('jquery-ui-slider');

	global $is_IE;
    if ($is_IE) {
        wp_register_script ('html5shim', "http://html5shim.googlecode.com/svn/trunk/html5.js");
        wp_enqueue_script ('html5shim');
	}
}

add_action('wp_enqueue_scripts','mts_add_scripts');

function mts_load_footer_scripts() {  
	$mts_options = get_option('monospace');
	
	// Site wide js
	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.min.js', true);
	wp_enqueue_script ('modernizr');

	//Lightbox
	if($mts_options['mts_lightbox'] == '1') {
		wp_register_script('prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', true);
		wp_enqueue_script('prettyPhoto');
	}
	
	//Sticky Nav
	if($mts_options['mts_sticky_nav'] == '1') {
		wp_register_script('StickyNav', get_template_directory_uri() . '/js/sticky.js', true);
		wp_enqueue_script('StickyNav');
	}
}  
add_action('wp_footer', 'mts_load_footer_scripts');  

/*-----------------------------------------------------------------------------------*/
/* Enqueue CSS
/*-----------------------------------------------------------------------------------*/
function mts_enqueue_css() {
	$mts_options = get_option('monospace');

	//Font Awesome
	wp_register_style('fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', 'style');
	wp_enqueue_style('fontawesome');
	global $is_IE;
    if ($is_IE) {
       wp_register_style('ie7-fontawesome', get_template_directory_uri() . '/css/font-awesome-ie7.min.css', 'style');
	   wp_enqueue_style('ie7-fontawesome');
	}

	//slider
	wp_register_style('flexslider', get_template_directory_uri() . '/css/flexslider.css', 'style');
	wp_enqueue_style('flexslider');	
	
	//lightbox
	if($mts_options['mts_lightbox'] == '1') {
		wp_register_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', 'style');
		wp_enqueue_style('prettyPhoto');
	}
	
	wp_enqueue_style('stylesheet', get_template_directory_uri() . '/style.css', 'style');
	
	//Responsive
	if($mts_options['mts_responsive'] == '1') {
        wp_enqueue_style('responsive', get_stylesheet_directory_uri() . '/css/responsive.css', 'style');
	}
	
	if ($mts_options['mts_bg_pattern_upload'] != '') {
		$mts_bg = $mts_options['mts_bg_pattern_upload'];
	} else {
		if($mts_options['mts_bg_pattern'] != '') {
			$mts_bg = get_template_directory_uri().'/images/'.$mts_options['mts_bg_pattern'].'.png';
		}
	}

	$mts_sclayout = '';
	$mts_shareit_left = '';
	$mts_shareit_right = '';
	$mts_author = '';
	$mts_header_section = '';
	$mts_single_layout = '';
	$mts_home_icon = '';
	$mts_single_icon = '';
	$mts_blog_sclayout ='';
	if ($mts_options['mts_home_post_format_icon'] == '0') {
		$mts_home_icon = '.latest-post-container .post-format-icon, #media-section .overlay i { display:none; }';
	}
	if ($mts_options['mts_layout'] == 'sclayout') {
		$mts_sclayout = '.article, #content_box_blog { float: right;}
		.sidebar.c-4-12 { float: left; padding-right: 0; }';
	}
	if ($mts_options['mts_layout'] == 'sclayout' && $mts_options['mts_grid_layout'] == '0') {
		$mts_blog_sclayout = '.blog-layout .home-tabber.latest-post-meta-tabber { right: -37px; left: auto; } .blog-layout .post-box-meta-wrapper { right: -58px; left: auto; } .blog-layout .post-box-meta-wrapper li { float: left; }';
	}
	if ($mts_options['mts_header_section2'] == '0') {
		$mts_header_section = '.logo-wrap { display: none; } .secondary-navigation { width: 100%; float: left; } #navigation > ul > li:first-child a { margin-left: 0; } #navigation .menu [class^="icon-"]:first-child:before, #navigation .menu [class*=" icon-"]:first-child:before { left: 0; } #navigation .menu .sub-menu [class^="icon-"]:first-child:before, #navigation .menu .sub-menu [class*=" icon-"]:first-child:before { left: 12px; }';
	}
	if($mts_options['mts_social_button_position'] == '3') {
		$mts_shareit_left = '.shareit { top: 300px; left: auto; z-index: 1; margin: 0 0 0 -100px; width: 90px; position: fixed; overflow: hidden; padding: 5px; border:none; border-right: 0; background: #474d55; -moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.2); -webkit-box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2); box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2);}
		.share-item {margin: 2px;}';
	} else {
		$mts_shareit_left = '.shareit { margin-right: 0; margin-left: 0; }';
	}
	if($mts_options['mts_author_comment'] == '1') {
		$mts_author = '.commentlist li.bypostauthor {background: #E9E9E9;-webkit-box-shadow: none;-moz-box-shadow: none;box-shadow: none;}';
	}
	if($mts_options['mts_layout'] == 'cslayout') {
		if ($mts_options['mts_single_post_layout'] == 'rclayout' && $mts_options['mts_social_button_position'] 
== '3' ) {
			$mts_shareit_right = '.shareit { margin: 0 0 0 -105px; }';
		}
	}
	if($mts_options['mts_layout'] == 'sclayout') {
		if ($mts_options['mts_single_post_layout'] == 'rclayout' && $mts_options['mts_social_button_position'] 
== '3' ) {
			$mts_shareit_right = '.shareit { margin: 0 0 0 745px; }';
		} elseif ($mts_options['mts_single_post_layout'] == 'crlayuot' || $mts_options['mts_single_post_layout'] == 'cbrlayout' || $mts_options['mts_single_post_layout'] == 'clayout') {
			if( $mts_options['mts_social_button_position'] == '3') {
				$mts_shareit_right = '.shareit { margin: 0 0 0 745px; }';
			}
		}
	}
	if($mts_options['mts_single_post_layout'] == 'crlayuot') {
		$mts_single_layout = '
			.single_post { width: 75%; float: left; }';
	}elseif($mts_options['mts_single_post_layout'] == 'rclayout') {
		$mts_single_layout = '
			.single_post { width: 75%; float: right; }
			.related-posts2 { float: left; }';
	}elseif($mts_options['mts_single_post_layout'] == 'clayout' || $mts_options['mts_single_post_layout'] == 'cbrlayout') {
		$mts_single_layout = '
			.single_post { width: 100%; }';
	}
	$custom_css = "
		body, .main-container, #sticky.floating {background-color:{$mts_options['mts_bg_color']}; background-image: url({$mts_bg}); }
		
		::selection { background: {$mts_options['mts_color_scheme_sec']}; }
		#navigation ul ul li:hover, .reply a, #commentform input#submit, .contactform #submit, #header #searchform, #move-to-top:hover, .pagination a:hover, .pagination .current a, .currenttext, .tagcloud a:hover, .widget-slider .slider-title, .widget .widget-slider .flex-direction-nav li, .small.thetime, .widget-icon, .quote-post .home-content, .home .latestPost .format-icon:before, .single_post .format-icon, .mejs-controls .mejs-time-rail .mejs-time-loaded, #searchsubmit, .flex-control-thumbs li, .flex-caption .sliderdate, .post-box-meta-wrapper ul .post-box-meta-list.comments, .home .latestPost .post-inner-wrapper .comments-tab span, .reply a:hover, .flex-direction-nav li:hover, .pagination .nav-previous a:hover, .pagination .nav-next a:hover, #navigation ul li:hover a:after, .mts-subscribe input[type='submit']:hover {background-color:{$mts_options['mts_color_scheme']}; color: #fff!important; }

		#navigation ul li:hover ul { border-top: 3px solid {$mts_options['mts_color_scheme']}}
		a, .sidebar_list ul li .theauthor a, #tabber .latestPost.second:hover h3, .latestPost.second .title:hover, .sidebar_list .menu-item a:hover, #cancel-comment-reply-link:hover, .postauthor h5, .copyrights a, .sidebar .textwidget a, footer .textwidget a, #logo a, .pnavigation2 a, .sidebar.c-4-12 a:hover, .copyrights a:hover, footer .widget li a:hover, .sidebar.c-4-12 a:hover, .related-posts li:hover a, .related-posts .theauthor a, .title a:hover, .post-info a:hover, .comm, #tabber .inside li a:hover, .readMore a:hover,  a, a:hover, .related-posts .post-info a, .comment-meta a, .sidebar.c-4-12 .mts_recent_tweets a, footer .mts_recent_tweets a, .readMore a, .thecomment span, #wp-calendar a, #navigation ul li:hover > a, #navigation ul li:hover:before, #navigation ul li.sfHover > a, .latest-post-data .theauthor a:hover, .latest-post-data .readMore a:hover, .widget .theauthor a, #tabber ul.tabs li a:hover, #tabber .entry-title:hover {color:{$mts_options['mts_color_scheme']};}

		.theauthor a:hover, .widget .theauthor a:hover {color:{$mts_options['mts_color_scheme_sec']};}

		 #move-to-top{background:  {$mts_options['mts_color_scheme_sec']} url(".get_bloginfo('template_directory')."/images/flexslider/slider-up.png) center center no-repeat;}
		
		 .flex-caption .slidertitle,.flex-direction-nav li, .post-box-meta-wrapper ul .post-box-meta-list.date, .home .latestPost .post-inner-wrapper .date-tab span, #commentform input#submit:hover, .contactform #submit:hover, .pagination a, #media-section .overlay i:before, .widget-slider .format-icon:after, .tagcloud a, .mts-subscribe input[type='submit'] {background: {$mts_options['mts_color_scheme_sec']};}

		 .flex-caption .slidercommentscount, .post-box-meta-wrapper ul .post-box-meta-list.category, .home .latestPost .post-inner-wrapper .category-tab span{background: {$mts_options['mts_color_scheme_third']};}
		
		{$mts_header_section}
		{$mts_sclayout}
		{$mts_shareit_left}
		{$mts_single_icon}
		{$mts_home_icon}
		{$mts_shareit_right}
		{$mts_blog_sclayout}
		{$mts_author}
		{$mts_single_layout}
		{$mts_options['mts_custom_css']}
			";
	wp_add_inline_style( 'stylesheet', $custom_css );
}
add_action('wp_enqueue_scripts', 'mts_enqueue_css', 99);

/*-----------------------------------------------------------------------------------*/
/*	Filters that allow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
add_filter('the_content_rss', 'do_shortcode');

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function mts_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" style="position:relative;">
			<div  class="comment-data-holder">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
				</div>
				<div class="comment-wrap">
					<?php printf(__('<span class="fn">%s</span>', 'mythemeshop'), get_comment_author_link()) ?> 
					<?php $mts_options = get_option('monospace'); if($mts_options['mts_comment_date'] == '1') { ?>
						<span class="ago"><?php comment_date(get_option( 'date_format' )); ?> <?php _e('at','mythemeshop');?> <?php comment_time(); ?></span>
					<?php } ?>
					<span class="comment-meta">
						<?php edit_comment_link(__('(Edit)', 'mythemeshop'),'  ','') ?>
					</span>
					<?php if ($comment->comment_approved == '0') : ?>
						<div><em><?php _e('Your comment is awaiting moderation.', 'mythemeshop') ?></em></div>
					<?php endif; ?>
					<div class="commentmetadata">
						<?php comment_text() ?>		            
					</div>				
				</div>

		</div>
			<hr class="inner-line" />
				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
		</div>
	</li>
<?php }
/*
 * Change the comment reply link to use 'Reply to &lt;Author First Name>'
 */
function add_comment_author_to_reply_link($link, $args, $comment){

    $comment = get_comment( $comment );

    // If no comment author is blank, use 'Anonymous'
    if ( empty($comment->comment_author) ) {
        if (!empty($comment->user_id)){
            $user=get_userdata($comment->user_id);
            $author=$user->user_login;
        } else {
            $author = __('Anonymous', 'mythemeshop');
        }
    } else {
        $author = $comment->comment_author;
    }

    // If the user provided more than a first name, use only first name
    if(strpos($author, ' ')){
        $author = substr($author, 0, strpos($author, ' '));
    }

    // Replace Reply Link with "Reply to &lt;Author First Name>"
    $reply_link_text = $args['reply_text'];
    $link = str_replace($reply_link_text, __('Reply to ', 'mythemeshop') . $author, $link);

    return $link;
}
add_filter('comment_reply_link', 'add_comment_author_to_reply_link', 10, 3);

/*-----------------------------------------------------------------------------------*/
/*	excerpt length
/*-----------------------------------------------------------------------------------*/
function mts_excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  $new_content = strip_tags($excerpt);
  return $new_content;
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
function mts_pagination_add_nofollow($content) {
    return 'rel="nofollow"';
}
add_filter('next_posts_link_attributes', 'mts_pagination_add_nofollow' );
add_filter('previous_posts_link_attributes', 'mts_pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/
/* Nofollow to category links
/*-----------------------------------------------------------------------------------*/
add_filter( 'the_category', 'mts_add_nofollow_cat' ); 
function mts_add_nofollow_cat( $text ) {
$text = str_replace('rel="category tag"', 'rel="nofollow"', $text); return $text;
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow post author link
/*-----------------------------------------------------------------------------------*/
add_filter('the_author_posts_link', 'mts_nofollow_the_author_posts_link');
function mts_nofollow_the_author_posts_link ($link) {
return str_replace('<a href=', '<a rel="nofollow" href=',$link); 
}

/*-----------------------------------------------------------------------------------*/	
/* nofollow to reply links
/*-----------------------------------------------------------------------------------*/
function mts_add_nofollow_to_reply_link( $link ) {
return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'mts_add_nofollow_to_reply_link' );

/*-----------------------------------------------------------------------------------*/
/* removes the WordPress version from your header for security
/*-----------------------------------------------------------------------------------*/
function wb_remove_version() {
	return '<!--Theme by MyThemeShop.com-->';
}
add_filter('the_generator', 'wb_remove_version');
	
/*-----------------------------------------------------------------------------------*/
/* Removes Trackbacks from the comment count
/*-----------------------------------------------------------------------------------*/
add_filter('get_comments_number', 'mts_comment_count', 0);
function mts_comment_count( $count ) {
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}

/*-----------------------------------------------------------------------------------*/
/* adds a class to the post if there is a thumbnail
/*-----------------------------------------------------------------------------------*/
function has_thumb_class($classes) {
	global $post;
	if( has_post_thumbnail($post->ID) ) { $classes[] = 'has_thumb'; }
		return $classes;
}
add_filter('post_class', 'has_thumb_class');

/*-----------------------------------------------------------------------------------*/	
/* Breadcrumb
/*-----------------------------------------------------------------------------------*/
function mts_the_breadcrumb() {
	echo '<a href="';
	echo home_url();
	echo '" rel="nofollow"><i class="icon-home"></i>&nbsp;'.__('Home','mythemeshop');
	echo "</a>";
	if (is_category() || is_single()) {
		echo "&nbsp;>&nbsp;";
		the_category(' & ');
			if (is_single()) {
				echo "&nbsp;>&nbsp;";
				the_title();
			}
	} elseif (is_page()) {
		echo "&nbsp;>&nbsp;";
		echo the_title();
	} elseif (is_search()) {
		echo "&nbsp;>&nbsp;".__('Search Results for','mythemeshop')."... ";
		echo '"<em>';
		echo the_search_query();
		echo '</em>"';
	}
}

/*-----------------------------------------------------------------------------------*/	
/* Pagination
/*-----------------------------------------------------------------------------------*/
function mts_pagination($pages = '', $range = 3) { 
	$showitems = ($range * 3)+1;
	global $paged; if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query; $pages = $wp_query->max_num_pages; 
		if(!$pages){ $pages = 1; } 
	}
	if(1 != $pages) { 
		echo "<div class='pagination'><ul>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link(1)."'>&laquo; ".__('First','mythemeshop')."</a></li>";
		if($paged > 1 && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link($paged - 1)."' class='inactive'>&lsaquo; ".__('Previous','mythemeshop')."</a></li>";
		for ($i=1; $i <= $pages; $i++){ 
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) { 
				echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a rel='nofollow' href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
			} 
		} 
		if ($paged < $pages && $showitems < $pages) 
			echo "<li><a rel='nofollow' href='".get_pagenum_link($paged + 1)."' class='inactive'>".__('Next','mythemeshop')." &rsaquo;</a></li>";
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
			echo "<li><a rel='nofollow' class='inactive' href='".get_pagenum_link($pages)."'>".__('Last','mythemeshop')." &raquo;</a></li>";
			echo "</ul></div>"; 
	}
}

/*-----------------------------------------------------------------------------------*/
/* Redirect feed to feedburner
/*-----------------------------------------------------------------------------------*/
$mts_options = get_option('monospace');
if ( $mts_options['mts_feedburner'] != '') {
function mts_rss_feed_redirect() {
    $mts_options = get_option('monospace');
    global $feed;
    $new_feed = $mts_options['mts_feedburner'];
    if (!is_feed()) {
        return;
    }
    if (preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])){
        return;
    }
    if ($feed != 'comments-rss2') {
        if (function_exists('status_header')) status_header( 302 );
        header("Location:" . $new_feed);
        header("HTTP/1.1 302 Temporary Redirect");
        exit();
    }
}
add_action('template_redirect', 'mts_rss_feed_redirect');
}

/*-----------------------------------------------------------------------------------*/
/* Single Post Pagination
/*-----------------------------------------------------------------------------------*/
function mts_wp_link_pages_args_prevnext_add($args)
{
    global $page, $numpages, $more, $pagenow;
    if (!$args['next_or_number'] == 'next_and_number')
        return $args; 
    $args['next_or_number'] = 'number'; 
    if (!$more)
        return $args; 
    if($page-1) 
        $args['before'] .= _wp_link_page($page-1)
        . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'
    ;
    if ($page<$numpages) 
    
        $args['after'] = _wp_link_page($page+1)
        . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
        . $args['after']
    ;
    return $args;
}
add_filter('wp_link_pages_args', 'mts_wp_link_pages_args_prevnext_add');

/*-----------------------------------------------------------------------------------*/
/* add <!-- next-page --> button to tinymce
/*-----------------------------------------------------------------------------------*/
add_filter('mce_buttons','wysiwyg_editor');
function wysiwyg_editor($mce_buttons) {
   $pos = array_search('wp_more',$mce_buttons,true);
   if ($pos !== false) {
       $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
       $tmp_buttons[] = 'wp_page';
       $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
   }
   return $mce_buttons;
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'mts_custom_gravatar' ) ) {
    function mts_custom_gravatar( $avatar_defaults ) {
        $mts_avatar = get_bloginfo('template_directory') . '/images/gravatar.png';
        $avatar_defaults[$mts_avatar] = 'Custom Gravatar (/images/gravatar.png)';
        return $avatar_defaults;
    }
    add_filter( 'avatar_defaults', 'mts_custom_gravatar' );
}

/*-----------------------------------------------------------------------------------*/
/*  TGM plugin activation
/*-----------------------------------------------------------------------------------*/
function mts_plugins() {
	// Add the following plugins
	$plugins = array(
		array(
			'name'     				=> 'CF Post Formats', // The plugin name
			'slug'     				=> 'cf-post-formats', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/plugins/cf-post-formats.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
	);
	// Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'mythemeshop';
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
			'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
			'menu'         		=> 'mythemeshop-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> __( 'Install Required Plugins', 'mythemeshop' ),
				'menu_title'                       			=> __( 'Theme Plugins', 'mythemeshop' ),
				'installing'                       			=> __( 'Installing Plugin: %s', 'mythemeshop' ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', 'mythemeshop' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop( 'This theme requires the following plugin to enable Post Formats: %1$s.', 'This theme requires the following plugin to enable Post Formats: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', 'mythemeshop' ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'mythemeshop' ),
				'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'mythemeshop' ), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);
		tgmpa($plugins, $config);
	}
add_action( 'tgmpa_register', 'mts_plugins' );

/*-----------------------------------------------------------------------------------*/
/*  Add support for the multiple Post Formats
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'post-formats', array('gallery', 'image', 'link', 'quote', 'audio', 'video', 'status'));

/*-----------------------------------------------------------------------------------*/
/*  Convert hex colors to rgb
/*-----------------------------------------------------------------------------------*/
function mts_hex2rgb($hex, $returnArray = false) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   if( !$returnArray ) return implode(",", $rgb); // returns the rgb values separated by commas
   else return $rgb; // returns an array with the rgb values
}

/*-----------------------------------------------------------------------------------*/
/*  Remove default comment form title, so we keep the custom title only, followd by the hr line
/*-----------------------------------------------------------------------------------*/
add_filter( 'comment_form_defaults', 'mts_commentform_rtitle' );
function mts_commentform_rtitle( $defaults )
{
    $defaults['title_reply'] = '';
    return $defaults;
}
?>