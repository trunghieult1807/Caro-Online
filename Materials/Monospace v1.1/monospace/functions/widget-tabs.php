<?php
/*-----------------------------------------------------------------------------------

	Plugin Name: MyThemeShop Tabs Widget
	Description: Display the popular Posts and Latest Posts in tabbed format
	Version: 1.0

-----------------------------------------------------------------------------------*/
class mts_Widget_Tabs extends WP_Widget {

	function mts_Widget_Tabs() {
		$widget_ops = array('classname' => 'widget_tab', 'description' => __('Display the popular Posts and Latest Posts in tabbed format', 'mythemeshop'));
		$control_ops = array('width' => 400, 'height' => 350);
		$this->WP_Widget('tab', __('MyThemeShop: Tab Widget', 'mythemeshop'), $widget_ops, $control_ops);
	}
	
	function form( $instance ) { 
		$instance = wp_parse_args( (array) $instance, array( 
			'popular_post_num' => '5', 
			'recent_post_num' => '5', 
			'show_thumb4' => 1, 
			'show_thumb5' => 1, 
			'author1' => 1, 
			'author2' => 1, 
			'show_excerpt1' => 1,
			'show_excerpt2' => 1,
			'excerpt_length1' => 10,
			'excerpt_length2' => 10) 
		);
		$popular_post_num = $instance['popular_post_num'];
		$show_thumb4 = isset( $instance[ 'show_thumb4' ] ) ? esc_attr( $instance[ 'show_thumb4' ] ) : 1;
		$show_thumb5 = isset( $instance[ 'show_thumb5' ] ) ? esc_attr( $instance[ 'show_thumb5' ] ) : 1;
		$author1 = isset( $instance[ 'author1' ] ) ? esc_attr( $instance[ 'author1' ] ) : 1;
		$author2 = isset( $instance[ 'author2' ] ) ? esc_attr( $instance[ 'author2' ] ) : 1;
		$show_excerpt1 = isset( $instance[ 'show_excerpt1' ] ) ? esc_attr( $instance[ 'show_excerpt1' ] ) : 1;
		$excerpt_length1 = isset( $instance[ 'excerpt_length1' ] ) ? intval( $instance[ 'excerpt_length1' ] ) : 10;
		$show_excerpt2 = isset( $instance[ 'show_excerpt2' ] ) ? esc_attr( $instance[ 'show_excerpt2' ] ) : 1;
		$excerpt_length2 = isset( $instance[ 'excerpt_length2' ] ) ? intval( $instance[ 'excerpt_length2' ] ) : 10;
		$recent_post_num = format_to_edit($instance['recent_post_num']);
	?>
		<p><label for="<?php echo $this->get_field_id('popular_post_num'); ?>"><?php _e('Number of popular posts to show:', 'mythemeshop'); ?></label>
		<input id="<?php echo $this->get_field_id('popular_post_num'); ?>" name="<?php echo $this->get_field_name('popular_post_num'); ?>" type="number" min="1" step="1" value="<?php echo $popular_post_num; ?>" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id("show_thumb4"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_thumb4"); ?>" name="<?php echo $this->get_field_name("show_thumb4"); ?>" value="1" <?php if (isset($instance['show_thumb4'])) { checked( 1, $instance['show_thumb4'], true ); } ?> />
				<?php _e( 'Show Thumbnails', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("author1"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("author1"); ?>" name="<?php echo $this->get_field_name("author1"); ?>" value="1" <?php if (isset($instance['author1'])) { checked( 1, $instance['author1'], true ); } ?> />
				<?php _e( 'Show Author Name', 'mythemeshop'); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("show_excerpt1"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_excerpt1"); ?>" name="<?php echo $this->get_field_name("show_excerpt1"); ?>" value="1" <?php checked( 1, $instance['show_excerpt1'], true ); ?> />
				<?php _e( 'Show excerpt', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
	       <label for="<?php echo $this->get_field_id( 'excerpt_length1' ); ?>"><?php _e( 'Excerpt Length:', 'mythemeshop' ); ?>
	       <input id="<?php echo $this->get_field_id( 'excerpt_length1' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length1' ); ?>" type="number" min="1" step="1" value="<?php echo $excerpt_length1; ?>" />
	       </label>
       </p>
		
		<p><label for="<?php echo $this->get_field_id('recent_post_num'); ?>"><?php _e('Number of latest posts to show:', 'mythemeshop'); ?></label>
		<input type="number" min="1" step="1" id="<?php echo $this->get_field_id('recent_post_num'); ?>" name="<?php echo $this->get_field_name('recent_post_num'); ?>" value="<?php echo $recent_post_num; ?>" /></p>
		
		<p>
			<label for="<?php echo $this->get_field_id("show_thumb5"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_thumb5"); ?>" name="<?php echo $this->get_field_name("show_thumb5"); ?>" value="1" <?php if (isset($instance['show_thumb5'])) { checked( 1, $instance['show_thumb5'], true ); } ?> />
				<?php _e( 'Show Thumbnails', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("author2"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("author2"); ?>" name="<?php echo $this->get_field_name("author2"); ?>" value="1" <?php if (isset($instance['author2'])) { checked( 1, $instance['author2'], true ); } ?> />
				<?php _e( 'Show Author Name', 'mythemeshop'); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id("show_excerpt2"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("show_excerpt2"); ?>" name="<?php echo $this->get_field_name("show_excerpt2"); ?>" value="1" <?php checked( 1, $instance['show_excerpt2'], true ); ?> />
				<?php _e( 'Show excerpt', 'mythemeshop'); ?>
			</label>
		</p>
		
		<p>
	       <label for="<?php echo $this->get_field_id( 'excerpt_length2' ); ?>"><?php _e( 'Excerpt Length:', 'mythemeshop' ); ?>
	       <input id="<?php echo $this->get_field_id( 'excerpt_length2' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length2' ); ?>" type="number" min="1" step="1" value="<?php echo $excerpt_length2; ?>" />
	       </label>
       </p>

	<?php }
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['popular_post_num'] = $new_instance['popular_post_num'];
		$instance['recent_post_num'] =  $new_instance['recent_post_num'];
		$instance['show_thumb4'] = $new_instance['show_thumb4'];
		$instance['show_thumb5'] = $new_instance['show_thumb5'];
		$instance['author1'] = $new_instance['author1'];
		$instance['author2'] = $new_instance['author2'];
		$instance['show_excerpt1'] = intval( $new_instance['show_excerpt1'] );
		$instance['excerpt_length1'] = intval( $new_instance['excerpt_length1'] );
		$instance['show_excerpt2'] = intval( $new_instance['show_excerpt2'] );
		$instance['excerpt_length2'] = intval( $new_instance['excerpt_length2'] );
		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract($args);
		$popular_post_num = $instance['popular_post_num'];
		$recent_post_num = $instance['recent_post_num'];
		$show_thumb4 = $instance['show_thumb4'];
		$show_thumb5 = $instance['show_thumb5'];
		$author1 = $instance['author1'];
		$author2 = $instance['author2'];
		$show_excerpt1 = $instance['show_excerpt1'];
		$excerpt_length1 = $instance['excerpt_length1'];
		$show_excerpt2 = $instance['show_excerpt2'];
		$excerpt_length2 = $instance['excerpt_length2']
		?>
		
<?php echo $before_widget; ?>
	<div id="tabber">	
		<ul class="tabs">
			<li><a href="#popular-posts"><?php _e('Popular Posts', 'mythemeshop'); ?></a></li>
			<li class="tab-recent-posts"><a href="#recent-posts"><?php _e('Recent Posts', 'mythemeshop'); ?></a></li>
		</ul> <!--end .tabs-->
		<div class="clear"></div>
		<div class="inside">
			<div id="popular-posts">
				<ul>
					<?php rewind_posts(); ?>
					<?php $popular = new WP_Query( array('ignore_sticky_posts' => 1, 'showposts' => $popular_post_num, 'orderby' => 'comment_count', 'order' => 'desc')); while ($popular->have_posts()) : $popular->the_post(); ?>
					<?php if($popular_post_num != 1){echo '';} ?>
						<li>
							<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
								<?php if ( $show_thumb4 == 1 ) : ?>
									<div class="left">
										<?php if(has_post_thumbnail()): ?>
											<?php the_post_thumbnail('widgetthumb',array('title' => '')); ?>
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" alt="<?php the_title(); ?>"  class="wp-post-image" />
										<?php endif; ?>
										<div class="clear"></div>
									</div>
								<?php endif; ?>
								<p class="entry-title"><?php the_title(); ?></p>
							</a>
							<?php if ( $author1 == 1) : ?>
								<div class="meta">
									<?php if ( $author1 == 1 ) : ?>
										<span class="theauthor"><?php _e('By', 'mythemeshop');?> <?php  the_author_posts_link(); ?></span>
									<?php endif; ?>
								</div> <!--end .entry-meta--> 
							<?php endif; ?>	
							<?php if ( $show_excerpt1 == 1 ) : ?>
								<p>
									<?php echo mts_excerpt($excerpt_length1); ?>
								</p>
							<?php endif; ?>
							<div class="clear"></div>
						</li>
					<?php $popular_post_num++; endwhile; wp_reset_query(); ?>
				</ul>			
		    </div> <!--end #popular-posts-->
		       
		    <div id="recent-posts"> 
		        <ul>
					<?php $the_query = new WP_Query('showposts='. $recent_post_num .'&orderby=post_date&order=desc'); while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<li>
							<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>">
								<?php if ( $show_thumb4 == 1 ) : ?>
									<div class="left">
										<?php if(has_post_thumbnail()): ?>
											<?php the_post_thumbnail('widgetthumb',array('title' => '')); ?>
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/smallthumb.png" alt="<?php the_title(); ?>"  class="wp-post-image" />
										<?php endif; ?>
										<div class="clear"></div>
									</div>
								<?php endif; ?>
								<p class="entry-title"><?php the_title(); ?></p>
							</a>
							<?php if ( $author1 == 1) : ?>
								<div class="meta">
									<?php if ( $author1 == 1 ) : ?>
										<span class="theauthor"><?php _e('By', 'mythemeshop');?> <?php  the_author_posts_link(); ?></span>
									<?php endif; ?>
								</div> <!--end .entry-meta--> 
							<?php endif; ?>
							<?php if ( $show_excerpt2 == 1 ) : ?>
								<p>
									<?php echo mts_excerpt($excerpt_length2); ?>
								</p>
							<?php endif; ?>
							<div class="clear"></div>
						</li>
					<?php $recent_post_num++; endwhile; wp_reset_query(); ?>                      
				</ul>	
		    </div> <!--end #recent-posts-->
			
			<div class="clear"></div>
		</div> <!--end .inside -->
		<div class="clear"></div>
	</div><!--end #tabber -->
<?php echo $after_widget; ?>

<?php }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "mts_Widget_Tabs" );' ) );
?>