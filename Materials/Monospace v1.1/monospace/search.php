<?php $mts_options = get_option('monospace'); ?>
<?php get_header(); ?>

<div id="page">

	<?php if($mts_options['mts_grid_layout'] == '1'){ ?>
		<h1 class="postsby">
			<span><?php _e("Search Results for:", "mythemeshop"); ?></span> <?php the_search_query(); ?>
		</h1>
		<div class="home article">
			<div id="content_box">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part( 'functions/post-format/content', get_post_format() ); ?>
				<?php endwhile; else: ?>
					<div class="no-results single_post">
						<h1><?php _e('No Results Found','mythemeshop'); ?></h1>
						<h3><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'mythemeshop'); ?></h3>
						<?php get_search_form(); ?>
					</div><!--noResults-->
				<?php endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	<?php } elseif($mts_options['mts_grid_layout'] == '0'){ ?>
		<h1 class="postsby">
			<span><?php _e("Search Results for:", "mythemeshop"); ?></span> <?php the_search_query(); ?>
		</h1>
		<div id="content_box_blog" class="article blog-layout">
			<?php if (is_home() && !is_paged()) { ?>
				<div class="latest-title"><h3><?php _e('Latest','mythemeshop'); ?></h3></div>
			<?php } ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part( 'functions/post-format/content-blog', get_post_format() ); ?>
			<?php endwhile; else: ?>
				<div class="no-results single_post">
					<h1><?php _e('No Results Found','mythemeshop'); ?></h1>
					<h3><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'mythemeshop'); ?></h3>
					<?php get_search_form(); ?>
				</div><!--noResults-->
			<?php endif; ?>
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

<?php get_footer(); ?>