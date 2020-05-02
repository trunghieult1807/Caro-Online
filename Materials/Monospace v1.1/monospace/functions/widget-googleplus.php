<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: MyThemeShop Google Plus Badge Box
	Description: A widget for displaying Google Plus Badge Box.
	Version: 1.0

-----------------------------------------------------------------------------------*/
add_action('widgets_init', 'mts_googleplus_load_widgets');

function mts_googleplus_load_widgets()
{
	register_widget('mts_googleplus_Widget');
}

class mts_googleplus_Widget extends WP_Widget {
	
	function mts_googleplus_Widget()
	{
		$widget_ops = array('classname' => 'mts_googleplus', 'description' => __('Add Google Plus Badge Box.','mythemeshop'));

		$control_ops = array('id_base' => 'google-badge-box');

		$this->WP_Widget('google-badge-box', __('MyThemeShop: Google Plus Badge Box','mythemeshop'), $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);

		$title = apply_filters('widget_title', $instance['title']);		
		$page_type = $instance['page_type'];
		$page_url = $instance['page_url'];
		$width = $instance['width'];
		$color_scheme = $instance['color_scheme'];
		$gp_layout = $instance['gp_layout'];
		$cover_photo = isset($instance['cover_photo']) ? 'true' : 'false';
		$tagline = isset($instance['tagline']) ? 'true' : 'false';
		echo $before_widget;

		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($page_url): ?>	
		<div <?php if($page_type == 'profile') { ?>class="g-person"<?php } elseif($page_type == 'page') { ?>class="g-page"<?php } elseif($page_type == 'community') { ?>class="g-community"<?php } ?> data-width="<?php echo $width; ?>" data-href="<?php echo $page_url; ?>" data-layout="<?php echo $gp_layout; ?>" data-theme="<?php echo $color_scheme; ?>" data-rel="publisher" data-showtagline="<?php echo $tagline; ?>" data-showcoverphoto="<?php echo $cover_photo; ?>"></div>
<!-- Place this tag after the last badgev2 tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
		<?php endif;
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page_type'] = $new_instance['page_type'];
		$instance['page_url'] = $new_instance['page_url'];
		$instance['width'] = $new_instance['width'];
		$instance['gp_layout'] = $new_instance['gp_layout'];
		$instance['color_scheme'] = $new_instance['color_scheme'];
		$instance['cover_photo'] = $new_instance['cover_photo'];
		$instance['tagline'] = $new_instance['tagline'];
		
		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => __('Find us on Google Plus','mythemeshop'), 'page_url' => '', 'width' => '300', 'color_scheme' => 'light', 'gp_layout' => 'portrait', 'page_type' => 'profile', 'cover_photo' => 'on', 'tagline' => 'on');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('page_type'); ?>"><?php _e('Page type','mythemeshop'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('page_type'); ?>" name="<?php echo $this->get_field_name('page_type'); ?>" style="width:100%;">
				<option <?php if ('profile' == $instance['page_type']) echo 'selected="selected"'; ?>>profile</option>
				<option <?php if ('page' == $instance['page_type']) echo 'selected="selected"'; ?>>page</option>
				<option <?php if ('community' == $instance['page_type']) echo 'selected="selected"'; ?>>community</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','mythemeshop'); ?>:</label>
			<input type="text" class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e('Google+ Page URL','mythemeshop'); ?>:</label>
			<input type="text" class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" value="<?php echo $instance['page_url']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width','mythemeshop'); ?>:</label>
			<input type="text" class="widefat" style="width: 40px;" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e('Color Scheme','mythemeshop'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>" style="width:100%;">
				<option <?php if ('light' == $instance['color_scheme']) echo 'selected="selected"'; ?>>light</option>
				<option <?php if ('dark' == $instance['color_scheme']) echo 'selected="selected"'; ?>>dark</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('gp_layout'); ?>"><?php _e('Layout','mythemeshop'); ?>:</label> 
			<select id="<?php echo $this->get_field_id('gp_layout'); ?>" name="<?php echo $this->get_field_name('gp_layout'); ?>" style="width:100%;">
				<option <?php if ('portrait' == $instance['gp_layout']) echo 'selected="selected"'; ?>>portrait</option>
				<option <?php if ('landscape' == $instance['gp_layout']) echo 'selected="selected"'; ?>>landscape</option>
			</select>
		</p>
		
		<p>
			<b><?php _e('Portrait Layout Settings','mythemeshop'); ?></b>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['cover_photo'], 'on'); ?> id="<?php echo $this->get_field_id('cover_photo'); ?>" name="<?php echo $this->get_field_name('cover_photo'); ?>" /> 
			<label for="<?php echo $this->get_field_id('cover_photo'); ?>"><?php _e('Cover Photo','mythemeshop'); ?></label>
		</p>
		
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['tagline'], 'on'); ?> id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $this->get_field_name('tagline'); ?>" /> 
			<label for="<?php echo $this->get_field_id('tagline'); ?>"><?php _e('Tagline','mythemeshop'); ?></label>
		</p>
	<?php
	}
}
?>