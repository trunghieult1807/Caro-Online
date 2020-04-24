<?php get_header(); ?>
<?php $mts_options = get_option('monospace'); ?>
<div id="page" class="single">
	<article class="article">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
				<?php get_template_part( 'functions/post-format/single', get_post_format() );  ?>
				<?php if($mts_options['mts_single_post_layout'] == 'rclayout' || $mts_options['mts_single_post_layout'] == 'crlayuot') { ?>
					<!-- Start Related Posts -->
					<?php $categories = get_the_category($post->ID); if ($categories) { $category_ids = array(); foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id; $args=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=>5, 'ignore_sticky_posts' => 1, 'orderby' => 'rand' );
					$my_query = new wp_query( $args ); if( $my_query->have_posts() ) {
						echo '<div class="related-posts related-posts2"><div class="postauthor-top"><h3>'.__('Related Posts','mythemeshop').'</h3></div><hr /><ul>';
						$counter = '0'; while( $my_query->have_posts() ) { ++$counter; if($counter == 4) { $postclass = 'last'; $counter = 0; } else { $postclass = ''; } $my_query->the_post(); $li = 1; ?>
						<li class="<?php echo $postclass; ?> relatepostli<?php echo $li+$counter; ?>">
							<a class="relatedthumb" href="<?php the_permalink()?>" title="<?php the_title(); ?>">
								<?php if(has_post_thumbnail()): ?>
									<span class="rthumb">
										<?php the_post_thumbnail('slider_thumb', 'title='); ?>
									</span>
								<?php endif; ?>
								<div><?php the_title(); ?></div>
							</a>
						</li>
					<?php } echo '</ul></div>'; }} wp_reset_query(); ?>
					<!-- .related-posts -->
				<?php }?>
				<?php if($mts_options['mts_social_buttons'] == '1') { ?>
					<?php if($mts_options['mts_social_button_position'] == '2' || $mts_options['mts_social_button_position'] == '3') { ?>
						<!-- Start Share Buttons -->
						<div class="shareit">
							<?php if($mts_options['mts_twitter'] == '1') { ?>
								<!-- Twitter -->
								<span class="share-item twitterbtn">
									<a href="https://twitter.com/share" class="twitter-share-button" data-via="<?php echo $mts_options['mts_twitter_username']; ?>">Tweet</a>
								</span>
							<?php } ?>
							<?php if($mts_options['mts_gplus'] == '1') { ?>
								<!-- GPlus -->
								<span class="share-item gplusbtn">
									<g:plusone size="medium"></g:plusone>
								</span>
							<?php } ?>
							<?php if($mts_options['mts_facebook'] == '1') { ?>
								<!-- Facebook -->
								<span class="share-item facebookbtn">
									<div id="fb-root"></div>
									<div class="fb-like" data-send="false" data-layout="button_count" data-width="150" data-show-faces="false"></div>
								</span>
							<?php } ?>
							<?php if($mts_options['mts_linkedin'] == '1') { ?>
								<!--Linkedin -->
								<span class="share-item linkedinbtn">
									<script type="IN/Share" data-url="<?php get_permalink(); ?>"></script>
								</span>
							<?php } ?>
							<?php if($mts_options['mts_stumble'] == '1') { ?>
								<!-- Stumble -->
								<span class="share-item stumblebtn">
									<su:badge layout="1"></su:badge>
								</span>
							<?php } ?>
							<?php if($mts_options['mts_pinterest'] == '1') { ?>
								<!-- Pinterest -->
								<span class="share-item pinbtn">
									<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); echo $thumb['0']; ?>&description=<?php the_title(); ?>" class="pin-it-button" count-layout="horizontal">Pin It</a>
								</span>
							<?php } ?>
						</div>
						<!-- end Share Buttons -->
					<?php } ?>
				<?php } ?>
				<?php if($mts_options['mts_single_post_layout'] == 'cbrlayout') { ?>
					<!-- Start Related Posts -->
					<?php $categories = get_the_category($post->ID); if ($categories) { $category_ids = array(); foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id; $args=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'showposts'=>2, 'ignore_sticky_posts' => 1, 'orderby' => 'rand' );
					$my_query = new wp_query( $args ); if( $my_query->have_posts() ) {
						echo '<div class="related-posts"><div class="postauthor-top"><h3>'.__('Related Posts','mythemeshop').'</h3></div><hr /><ul>';
						$counter = '0'; while( $my_query->have_posts() ) { ++$counter; if($counter == 4) { $postclass = 'last'; $counter = 0; } else { $postclass = ''; } $my_query->the_post(); $li = 1; ?>
						<li class="<?php echo $postclass; ?> relatepostli<?php echo $li+$counter; ?>">
							<a class="relatedthumb" href="<?php the_permalink()?>" title="<?php the_title(); ?>">
								<?php $hasThumbClass = 'no-image' ?>
								<?php if(has_post_thumbnail()): ?>
									<?php $hasThumbClass = '' ?>
									<span class="rthumb">
										<?php the_post_thumbnail('widgetthumb', 'title='); ?>
									</span>								
								<?php endif; ?>
								<div><?php the_title(); ?></div>
							</a>
							<div class="related-post-excerpt <?php echo $hasThumbClass; ?>">
								<p><?php echo mts_excerpt(12); ?> </p>
								<?php if(isset($mts_options['mts_single_headline_meta_info'][4]) == '1') { ?>
									<div class="theauthor-wrap <?php echo $hasThumbClass; ?>"><span class="theauthor"> <?php _e('by ','mythemeshop'); the_author_posts_link(); ?> </span></div>
								<?php } ?>
							</div>
						</li>
					<?php } echo '</ul></div>'; }} wp_reset_query(); ?>
					<!-- .related-posts -->
				<?php }?>
				<?php if($mts_options['mts_author_box'] == '1') { ?>
					<div class="postauthor">
						<h3><?php _e('About The Author', 'mythemeshop'); ?></h3>
						<hr />
						<div class="author-wrap">
							<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100' );  } ?>
							<h5><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="nofollow"><?php the_author_meta( 'nickname' ); ?></a></h5>
							<p><?php the_author_meta('description') ?></p>
						</div>
					</div>
				<?php }?>  
			</div><!--.g post-->
			<?php comments_template( '', true ); ?>
		<?php endwhile; /* end loop */ ?>
	</article>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>