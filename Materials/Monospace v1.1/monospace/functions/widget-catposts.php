<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: MyThemeShop Category Posts
	Version: 2.0
	
-----------------------------------------------------------------------------------*/


class single_category_posts_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'single_category_posts_widget',
			__('MyThemeShop: Category Posts','mythemeshop'),
			array( 'description' => __( 'Display the most recent posts from a single category','mythemeshop' ) )
		);
	}

 	public function form( $instance ) {
		$defaults = array(
			'comment_num' => 1,
			'author' => 1,
			'show_thumb1' => 1,
			'show_excerpt' => 1,
			'excerpt_length' => 10
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Featured Category','mythemeshop' );
		$cat = isset( $instance[ 'cat' ] ) ? intval( $instance[ 'cat' ] ) : 0;
		$qty = isset( $instance[ 'qty' ] ) ? intval( $instance[ 'qty' ] ) : 5;
		$comment_num = isset( $instance[ 'comment_num' ] ) ? intval( $instance[ 'comment_num' ] ) : 1;
		$author = isset( $instance[ 'author' ] ) ? intval( $instance[ 'author' ] ) : 1;
		$show_thumb1 = isset( $instance[ 'show_thumb1' ] ) ? intval( $instance[ 'show_thumb1' ] ) : 1;
		$show_excerpt = isset( $instance[ 'show_excerpt' ] ) ? esc_attr( $instance[ 'show_excerpt' ] ) : 1;
		$excerpt_length = isset( $instance[ 'excerpt_length' ] ) ? intval( $instance[ 'excerpt_length' ] ) : 10;
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','mythemeshop' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e( 'Category:','mythemeshop' ); ?></label> 
			<?php wp_dropdown_categories( Array(
				'orderby'            => 'ID', 
				'order'              => 'ASC',
				'show_count'         => 1,
				'hide_empty'         => 1,
				'hide_if_empty'      => true,
				'echo'               => 1,
				'selected'           => $cat,
				'hierarchical'       => 1, 
				'name'               => $this->get_field_name( 'cat' ),
				'id'                 => $this->get_field_id( 'cat' ),
				'taxonomy'           => 'category',
			) ); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'qty' ); ?>"><?php _e( 'Number of Posts to show','mythemeshop' ); ?></label> 
			<input id="<?php echo $this->get_field_id( 'qty' ); ?>" name="<?php echo $this->get_field_name( 'qty' ); ?>" type="number" min="1" step="1" value="<?php echo $qty; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("show_thumb1"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_thumb1"); ?>" name="<?php echo $this->get_field_name("show_thumb1"); ?>" value="1" <?php if (isset($instance['show_thumb1'])) { checked( 1, $instance['show_thumb1'], true ); } ?> />
				<?php _e( 'Show Thumbnails', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("author"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("author"); ?>" name="<?php echo $this->get_field_name("author"); ?>" value="1" <?php checked( 1, $instance['author'], true ); ?> />
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
		$instance['cat'] = intval( $new_instance['cat'] );
		$instance['qty'] = intval( $new_instance['qty'] );
		$instance['comment_num'] = intval( $new_instance['comment_num'] );
		$instance['author'] = intval( $new_instance['author'] );
		$instance['show_thumb1'] = intval( $new_instance['show_thumb1'] );
		$instance['show_excerpt'] = intval( $new_instance['show_excerpt'] );
		$instance['excerpt_length'] = intval( $new_instance['excerpt_length'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cat = $instance['cat'];
		$comment_num = $instance['comment_num'];
		$author = $instance['author'];
		$qty = (int) $instance['qty'];
		$show_thumb1 = (int) $instance['show_thumb1'];
		$show_excerpt = $instance['show_excerpt'];
		$excerpt_length = $instance['excerpt_length'];

		echo $before_widget;
		if ( ! empty( $title ) ) echo $before_title . $title . $after_title;
		echo self::get_cat_posts( $cat, $qty, $comment_num, $author, $show_thumb1, $show_excerpt, $excerpt_length );
		echo $after_widget;
	}

	public function get_cat_posts( $cat, $qty, $comment_num, $author, $show_thumb1, $show_excerpt, $excerpt_length ) {
		$posts = new WP_Query(
			"cat=".$cat."&orderby=date&order=DESC&posts_per_page=".$qty
		);

		echo '<ul class="category-posts">';
		
		while ( $posts->have_posts() ) { $posts->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>">
				<?php if ( $show_thumb1 == 1 ) : ?>
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
					<span class="theauthor"><?php _e('By', 'mythemeshop');?> <?php  the_author_posts_link(); ?></span>
				<?php endif; ?>
			</div> <!--end .entry-meta--> 
		</li>	
		<?php }			
		echo '</ul>'."\r\n";
	}

}
add_action( 'widgets_init', create_function( '', 'register_widget( "single_category_posts_widget" );' ) );