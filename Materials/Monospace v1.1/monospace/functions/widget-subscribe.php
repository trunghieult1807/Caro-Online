<?php

/*-----------------------------------------------------------------------------------

	Plugin Name: Email Subscriber
	Description: Feedburner Subscription Widget.
	Version: 1.0

-----------------------------------------------------------------------------------*/


// Add function to widgets_init that'll load our widget.
add_action( 'widgets_init', 'mts_subscribe_widgets' );


// Register widget.
function mts_subscribe_widgets() {
	register_widget( 'mts_Subscribe_Widget' );
}

// Widget class.
class mts_subscribe_widget extends WP_Widget {


/*-----------------------------------------------------------------------------------*/
/*	Widget Setup
/*-----------------------------------------------------------------------------------*/
	
	function mts_Subscribe_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mts_subscribe_widget', 'description' => __('Feedburner Subscription Widget.', 'mythemeshop') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'mts_subscribe_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'mts_subscribe_widget', __('MyThemeShop: Subscribe Widget', 'mythemeshop'), $widget_ops, $control_ops );
	}


/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$desc = $instance['desc'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display Widget */
		?>
        	
			<div class="mts-subscribe">
                
                <?php /* Display the widget title if one was input (before and after defined by themes). */
				if ( $title )
					echo $before_title . $title . $after_title;
				?>

                <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $desc; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" _lpchecked="1">
				<input type="text" value="<?php _e('Your email Address','mythemeshop'); ?>..." onblur="if (this.value == '') {this.value = '<?php _e('Your email Address','mythemeshop'); ?>...';}" onfocus="if (this.value == '<?php _e('Your email Address','mythemeshop'); ?>...') {this.value = '';}"  name="email">
				<input type="hidden" value="<?php echo $desc; ?>" name="uri"><input type="hidden" name="loc" value="en_US"><input type="submit" value="<?php _e('Subscribe','mythemeshop'); ?>">
				<i class="icon-envelope"></i>
				</form>

                <div class="result"></div>
                
            </div><!--subscribe_widget-->
		
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		/* Stripslashes for html inputs */
		$instance['desc'] = stripslashes( $new_instance['desc']);

		/* No need to strip tags for.. */

		return $instance;
	}
	

/*-----------------------------------------------------------------------------------*/
/*	Widget Settings
/*-----------------------------------------------------------------------------------*/
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'desc' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'mythemeshop') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<!-- Description: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e('Feedburner id (http://feeds.feedburner.com/<b>mythemeshop</b>):', 'mythemeshop') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['desc'] ), ENT_QUOTES)); ?>" />
		</p>
		
	<?php
	}
}
?>