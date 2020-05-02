<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: MyThemeShop Popular Posts
	Version: 2.0
	
-----------------------------------------------------------------------------------*/


class mts_poluar_posts_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'mts_poluar_posts_widget',
			__('MyThemeShop: Popular Posts','mythemeshop'),
			array( 'description' => __( 'Displays most Popular Posts with Thumbnail.','mythemeshop' ) )
		);
	}

 	public function form( $instance ) {
		$defaults = array(
			'comment_num' => 1,
			'author' => 1,
			'days' => 30,
			'show_thumb3' => 1,
			'show_excerpt' => 1,
			'excerpt_length' => 10,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Popular Posts','mythemeshop' );
		$qty = isset( $instance[ 'qty' ] ) ? intval( $instance[ 'qty' ] ) : 5;
		$comment_num = isset( $instance[ 'comment_num' ] ) ? intval( $instance[ 'comment_num' ] ) : 1;
		$author = isset( $instance[ 'author' ] ) ? intval( $instance[ 'author' ] ) : 1;
		$days = isset( $instance[ 'days' ] ) ? intval( $instance[ 'days' ] ) : 30;
		$show_thumb3 = isset( $instance[ 'show_thumb3' ] ) ? intval( $instance[ 'show_thumb3' ] ) : 1;
		$show_excerpt = isset( $instance[ 'show_excerpt' ] ) ? esc_attr( $instance[ 'show_excerpt' ] ) : 1;
		$excerpt_length = isset( $instance[ 'excerpt_length' ] ) ? intval( $instance[ 'excerpt_length' ] ) : 10;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','mythemeshop' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
	       <label for="<?php echo $this->get_field_id( 'days' ); ?>"><?php _e( 'Popular limit (days):', 'mythemeshop' ); ?>
	       <input id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" type="number" min="1" step="1" value="<?php echo $days; ?>" />
	       </label>
       </p>
	   
		<p>
			<label for="<?php echo $this->get_field_id( 'qty' ); ?>"><?php _e( 'Number of Posts to show','mythemeshop' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'qty' ); ?>" name="<?php echo $this->get_field_name( 'qty' ); ?>" type="number" min="1" step="1" value="<?php echo $qty; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("show_thumb3"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_thumb3"); ?>" name="<?php echo $this->get_field_name("show_thumb3"); ?>" value="1" <?php if (isset($instance['show_thumb3'])) { checked( 1, $instance['show_thumb3'], true ); } ?> />
				<?php _e( 'Show Thumbnails', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("author"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("author"); ?>" name="<?php echo $this->get_field_name("author"); ?>" value="1" <?php if (isset($instance['author'])) { checked( 1, $instance['author'], true ); } ?> />
				<?php _e( 'Show Post Author', 'mythemeshop'); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("comment_num"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>" value="1" <?php checked( 1, $instance['comment_num'], true ); ?> />
				<?php _e( 'Show number of comments', 'mythemeshop'); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("show_excerpt"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_excerpt"); ?>" name="<?php echo $this->get_field_name("show_excerpt"); ?>" value="1" <?php checked( 1, $instance['show_excerpt'], true ); ?> />
				<?php _e( 'Show excerpt', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
	       <label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>"><?php _e( 'Excerpt Length:', 'mythemeshop' ); ?>
	       <input id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" type="number" min="1" step="1" value="<?php echo $excerpt_length; ?>" />
	       </label>
        </p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['qty'] = intval( $new_instance['qty'] );
		$instance['comment_num'] = intval( $new_instance['comment_num'] );
		$instance['author'] = intval( $new_instance['author'] );
		$instance['days'] = intval( $new_instance['days'] );
		$instance['show_thumb3'] = intval( $new_instance['show_thumb3'] );
		$instance['show_excerpt'] = intval( $new_instance['show_excerpt'] );
		$instance['excerpt_length'] = intval( $new_instance['excerpt_length'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$comment_num = $instance['comment_num'];
		$author = $instance['author'];
		$days = $instance['days'];
		$qty = (int) $instance['qty'];
		$show_thumb3 = (int) $instance['show_thumb3'];
		$show_excerpt = $instance['show_excerpt'];
		$excerpt_length = $instance['excerpt_length'];

		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		echo self::get_popular_posts( $qty, $comment_num, $author, $days, $show_thumb3, $show_excerpt, $excerpt_length );
		echo $after_widget;
	}

	public function get_popular_posts( $qty, $comment_num, $author, $days, $show_thumb3, $show_excerpt, $excerpt_length ) {
	
		global $post; 
		if ( $days ) {
			global $popular_days;
			$popular_days = $days;

			// Register the filtering function
			add_filter( 'posts_where', 'filter_where' );
		}
		//Create a new filtering function that will add our where clause to the query
		function filter_where( $where = '' ) {
		  global $popular_days;
		  //posts in the last X days
		  $where .= " AND post_date > '" . date('Y-m-d', strtotime('-'.$popular_days.' days')) . "'";
		  return $where;
		}
		
		$popular = get_posts( array( 'suppress_filters' => false, 'ignore_sticky_posts' => 1, 'orderby' => 'comment_count', 'numberposts' => $qty ) );
		echo '<ul class="popular-posts">';
		foreach($popular as $post) :
			setup_postdata($post);
			?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<?php if ( $show_thumb3 == 1 ) : ?>
					<?php if(has_post_thumbnail()): ?>
						<?php the_post_thumbnail('widgetthumb',array('title' => '')); ?>
					<?php else: ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" alt="<?php the_title(); ?>" class="wp-post-image" />
					<?php endif; ?>
				<?php endif; ?>
				<div class="post-title"><?php the_title(); ?></div>
			</a>
			<div class="meta">
				<?php if ( $show_excerpt == 1 ) : ?>
					<p>
						<?php echo mts_excerpt($excerpt_length); ?>
					</p>
				<?php endif; ?>
				<?php if ( $comment_num == 1 ) : ?>
					<?php echo comments_number(__('<span class="comm">0</span> Comment','mythemeshop'), __('<span class="comm">1</span> Comment','mythemeshop'), '<span class="comm">%</span> '.__('Comments','mythemeshop'));?>
				<?php endif; ?>
				<?php if ( $author == 1 ) : ?>
					<span class="theauthor"><?php _e('By', 'mythemeshop');?> <?php the_author_posts_link(); ?></span>
				<?php endif; ?>
			</div> <!--end .entry-meta-->
		</li>	
		<?php endforeach; wp_reset_postdata();
		echo '</ul>'."\r\n";
		remove_filter( 'posts_where', 'filter_where' );
	}

}
add_action( 'widgets_init', create_function( '', 'register_widget( "mts_poluar_posts_widget" );' ) );