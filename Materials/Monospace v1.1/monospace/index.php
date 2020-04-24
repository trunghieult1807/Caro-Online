<?php $mts_options = get_option('monospace'); ?>
<?php get_header(); ?>
<div id="page">
	<?php if (is_home() && !is_paged()) { ?>
		<?php if($mts_options['mts_featured_slider'] == '1') { ?>
			<div class="slider-container loading">
				<div class="flex-container">
					<div id="slider" class="flexslider">
						<ul class="slides">						
							<?php if( $mts_options['mts_featured_slider_cat'] != '' ) $slider_cat = implode(",", $mts_options['mts_featured_slider_cat']); $my_query = new WP_Query('cat='.$slider_cat.'&posts_per_page=3');
								while ($my_query->have_posts()) : $my_query->the_post();
								$image_id = get_post_thumbnail_id();
								$image_url = wp_get_attachment_image_src($image_id,'slider_thumb');
								$image_url = $image_url[0];
								$comments_count = wp_count_comments( get_the_id() ); ?>
							<li data-thumb="<?php echo $image_url; ?>" style="position: relative; max-width: 100%;"> 
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?> - <?php the_date();?>">
									<?php the_post_thumbnail('slider',array('title' => '')); ?>
									<div class="flex-caption">
										<div class="slidertitle"><?php the_title(); ?></div>
										<div class="sliderdate">
											<span class="month"><?php echo get_the_date('M'); ?></span>
											<span class="dayYear"><?php echo get_the_date('d-Y'); ?></span>											 
										</div>
										<div class="slidercommentscount"><span><?php echo $comments_count->approved; ?></span> <span><?php _e('Comments '); ?></span></div>
									</div>
								</a> 
							</li>
							<?php endwhile; wp_reset_query(); ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- slider-container -->
		<?php } ?>
	<?php } ?>
</div>

<div id="page">
	<?php if (is_home() && !is_paged()) { ?>
		<?php if($mts_options['mts_featured_tab_1'] == '1') { ?>
			<div id="tabber" class="home-tabber featured-section">
				<div class="inside-featured-section">
					<?php if($mts_options['mts_featured_tab_1'] == '1'){ ?>
						<div id="tab1">
					        <ul>
								<?php $i = 1; $the_query = new WP_Query('cat='.$mts_options['mts_featured_tab_1_cat'].'&posts_per_page=4'); 
									while ($the_query->have_posts()) : $the_query->the_post(); ?>
									<?php if($i == 1){ ?>
										<?php if(isset($mts_options['mts_home_headline_meta']) == '1') { ?>
											<?php global $post; ?>
											<div class="post-box-meta-wrapper">
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
										<?php } ?>
										<?php $featuredImgClass = !get_the_post_thumbnail() ? "no-image" : ""; ?>
										<article class="article latestPost first excerpt <?php echo $featuredImgClass; ?>">
											<div class="post-inner-wrapper">
												<div class="featured-title"><h2><?php _e( get_cat_name($mts_options['mts_featured_tab_1_cat']) ); ?></h2></div>
												<header>
													<h1 class="title front-view-title"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
												</header>
												<div class="home-content">
													<div class="front-view-content">
														<?php echo mts_excerpt(50); // 55 is the_experts default limit. monosppacce_excerpt_length function added in case we want to rase the number of words (needs to be uncommented). ?>
													</div>
												</div>
											</div>
											<div class="post-inner-wrapper">
												<?php if ( get_the_post_thumbnail() ) { ?>
													<div class="latest-post-img">
														<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" id="featured-thumbnail">				
															<?php echo '<div class="">'; the_post_thumbnail('featured',array('title' => '')); echo '</div>'; ?>	
														</a>
													</div>
												<?php } ?>
											</div>
										</article><!--.post excerpt-->
									<?php } else { ?>
										<article class="latestPost second featured">
											<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
												<div class="small-title">
													<div id="featured-thumbnail" class="featured-thumbnail-wrapper">
														<?php if ( has_post_thumbnail() ) { ?>
															<?php echo '<div class="_featured-thumbnail">'; the_post_thumbnail('widgetthumb3',array('title' => '')); echo '</div>'; ?>
														<?php } ?>
													</div>
													<div class="small-content">
														<h3 class="title front-view-title"><?php the_title(); ?></h3>
														<div class="small commments-bottom"><?php comments_number(__('0 <span>Comments</span>','mythemeshop'), __('1 <span>Comment</span>','mythemeshop'),  __('% <span>Comments</span>','mythemeshop') ); ?></div>
													</div>
												</div>
												
											</a>
										</article><!--.post excerpt-->
									<?php } ?>
								<?php $i++; endwhile; wp_reset_query(); ?>               
							</ul>	
					    </div> <!--end #tab1 -->
				    <?php } ?>
					<div class="clear"></div>
				</div> <!--end .inside -->
				<div class="clear"></div>
			</div><!--end #tabber -->
		<?php } ?>
	<?php } ?>

	<?php if($mts_options['mts_grid_layout'] == '1'){ ?>
		<div class="home article">
			<?php if (is_home() && !is_paged()) { ?>
				<div class="latest-title"><h3><?php _e('Latest','mythemeshop'); ?></h3></div>
			<?php } ?>
			<div id="content_box">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part( 'functions/post-format/content', get_post_format() ); ?>
				<?php endwhile; endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	<?php } elseif($mts_options['mts_grid_layout'] == '0'){ ?>
		<div id="content_box_blog" class="article blog-layout">
			<?php if (is_home() && !is_paged()) { ?>
				<div class="latest-title"><h3><?php _e('Latest','mythemeshop'); ?></h3></div>
			<?php } ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'functions/post-format/content-blog', get_post_format() ); ?>
			<?php endwhile; endif; ?>
			<!--Start Pagination-->
			<?php if ($mts_options['mts_pagenavigation'] == '1' ) { ?>
				<?php if ($mts_options['mts_pagenavigation_type'] == '1' ) { ?>
					<?php  $additional_loop = 0; mts_pagination($additional_loop['max_num_pages']); ?>           
				<?php } else { ?>
					<div class="pagination">
						<ul>
							<li class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></li>
							<li class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></li>
						</ul>
					</div>
				<?php } ?>
			<?php } ?>
			<!--End Pagination-->
		</div>
		<?php get_sidebar(); ?>
	<?php } ?>

	<?php if($mts_options['mts_grid_layout'] == '1'){ ?>
		<!--Start Pagination-->
		<?php if ($mts_options['mts_pagenavigation'] == '1' ) { ?>
			<?php if ($mts_options['mts_pagenavigation_type'] == '1' ) { ?>
				<?php  $additional_loop = 0; mts_pagination($additional_loop['max_num_pages']); ?>           
			<?php } else { ?>
				<div class="pagination">
					<ul>
						<li class="nav-previous"><?php next_posts_link( __( '&larr; '.'Older posts', 'mythemeshop' ) ); ?></li>
						<li class="nav-next"><?php previous_posts_link( __( 'Newer posts'.' &rarr;', 'mythemeshop' ) ); ?></li>
					</ul>
				</div>
			<?php } ?>
		<?php } ?>
		<!--End Pagination-->
	<?php } ?>
	<div class="clear"></div>
	<?php if (is_home() && !is_paged()) { ?>
		<?php if($mts_options['mts_media_section'] == '1' && $mts_options['mts_media_section_cat'] != '') { ?>				
				<div id="media-section">
					<div class="featured-title"><h4><?php _e( get_cat_name($mts_options['mts_media_section_cat']) ); ?></h4></div>
			        <ul>
						<?php $media_query = new WP_Query('cat='.$mts_options['mts_media_section_cat'].'&posts_per_page=5'); 
							if($media_query->have_posts() ): while ($media_query->have_posts()) : $media_query->the_post(); ?> 
								<?php $post_format = (get_post_format()) ? get_post_format() : 'standard'; 	
									$icon_default = array('standard' => 'icon-pushpin', 'audio' => 'icon-volume-down', 'video' => 'icon-facetime-video','quote' => 'icon-quote-left', 'link' => 'icon-link', 'image' => 'icon-picture', 'gallery' => 'icon-camera', 'status' => 'icon-comment', 'aside' => 'icon-pushpin', 'chat' => 'icon-comment');
									$icon = $icon_default[$post_format];													
								?>
							<li>
								<?php if ( has_post_thumbnail() ) { ?>
									<div class="featured-thumbnail"> 
										<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="media-link">
										<?php the_post_thumbnail('featured3',array('title' => '')); ?>
											<span class="overlay"><i class="<?php echo $icon; ?>"></i></span>
										</a>
									</div>
								<?php } else { ?>
									<div class="">
										<a class="media-link">
											<img width="300" height="150" src="<?php echo get_template_directory_uri(); ?>/images/300x150.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">
										</a>
										
									</div>
								<?php } ?>
							</li>
						<?php endwhile; endif; wp_reset_query(); ?>
					</ul>
				</div>				
		<?php } ?>
	<?php } ?>

<?php get_footer(); ?>