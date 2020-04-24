<?php $mts_options = get_option('monospace'); ?>
<?php $featuredImgClass = !get_the_post_thumbnail() ? "no-image" : ""; ?>
<article class="latestPost-box excerpt quote <?php echo $featuredImgClass; ?>">
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
				<?php if(isset($mts_options['mts_home_headline_meta']) == '1') { ?>
					<?php if(isset($mts_options['mts_home_headline_meta_info']['a']) == '1') { ?>
						<span class="theauthor-icon"><i class="icon-user"></i></span>
						<span class="theauthor"><?php the_author_posts_link(); ?> </span> 
					<?php } ?>
				<?php } ?>
				<span class="post-format-icon icon-quote-left"></span>
			</div>
			<div class="bottom-row">					
				<hr class="top-line" />
				<div class="front-view-content">
					<div class="post-excerpt">
						<?php echo get_the_content();?>
						<a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>" target="_blank"><?php if(get_post_meta($post->ID, '_format_quote_source_name', true) != ""){ echo '- ' . get_post_meta($post->ID, '_format_quote_source_name', true); } ?></a>
					</div>
				</div>
			</div>
		</div>
		<?php if ( get_the_post_thumbnail() ) { //If has featured img, show but don't link anywhere ?>
			<div class="latest-post-img">
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">				
					<?php echo '<div>'; the_post_thumbnail('featured3',array('title' => '')); echo '</div>'; ?>				
				</a>
			</div>
		<?php } ?>
	</div>
</article><!--.post excerpt-->