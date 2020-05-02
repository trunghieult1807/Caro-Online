<?php $mts_options = get_option('monospace'); ?>
<?php $featuredImgClass = !get_the_post_thumbnail() ? "no-image" : ""; ?>
<article class="latestPost-box excerpt <?php echo $featuredImgClass; ?>">
	<?php if($mts_options['mts_home_headline_meta'] == '1') { ?>
		<div class="home-tabber latest-post-meta-tabber" >
			<?php global $post; ?>
			<div class="post-box-meta-wrapper latest">
				<ul>
					<?php if(isset($mts_options['mts_home_headline_meta_info']['d']) == '1') { ?>
						<li class="post-box-meta-list category">
							<i class="icon-map-marker"></i>
							<span>
								<?php $category = get_the_category(); 
								echo $category[0]->cat_name; ?>
							</span>
						</li>
					<?php } ?>
					<?php if(isset($mts_options['mts_home_headline_meta_info']['b']) == '1') { ?>
						<li class="post-box-meta-list comments">
							<i class="icon-comments"></i>
							<span>
								<?php echo get_comments_number( $post->ID ); ?> <?php _e('Comments', 'mythemeshop'); ?>
							</span>
						</li>
					<?php } ?>
					<?php if(isset($mts_options['mts_home_headline_meta_info']['c']) == '1') { ?>
						<li class="post-box-meta-list date">
							<i class="icon-calendar"></i>
							<span class="thetime"> <?php the_time('j M y'); ?></span>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
 
	<div class="latest-post-container">		
		<div class="latest-post-data">
			<div class="top-row">
				<a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" title="<?php the_title(); ?>" rel="nofollow" class="post-format-link">
						<?php if(get_post_meta($post->ID, '_format_link_url', true) != ""){ echo  get_post_meta($post->ID, '_format_link_url', true); } ?>		
				</a>
				<span class="post-format-icon icon-link"></span>
			</div>
			<div class="bottom-row">					
				<hr class="top-line" />
				<div class="front-view-content">
					<header>
						<h2 class="title front-view-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					</header>
					<div class="post-excerpt">
						<?php if ( get_the_post_thumbnail() ) { ?>
							<?php echo mts_excerpt(40);?>
						<?php } else { ?>
							<?php echo mts_excerpt(85);?>
						<?php } ?>
					</div>
				</div>
				<hr />
				<div class="readMore with-author">
					<?php if(isset($mts_options['mts_home_headline_meta']) == '1') { ?>
						<?php if(isset($mts_options['mts_home_headline_meta_info']['a']) == '1') { ?>
							<span class="by"><?php _e('By', 'mythemeshop'); ?></span>
							<span class="theauthor"><?php  the_author_posts_link(); ?> </span>
						<?php } ?>
					<?php } ?>
				</div>
			</div>				
		</div>
		<?php if ( get_the_post_thumbnail() ) { ?>
			<div class="latest-post-img">
				<a href="<?php echo esc_attr(get_post_meta($post->ID, '_format_link_url', true)); ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail" target="_blank">
					<?php echo '<div class="">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>				
				</a>
			</div>
		<?php } ?>
	</div>
</article><!--.post excerpt-->