<?php $mts_options = get_option('monospace'); ?>
<?php get_header(); ?>

<div id="page">

	<?php if($mts_options['mts_grid_layout'] == '1'){ ?>
		<h1 class="postsby">
			<?php if (is_category()) { ?>
				<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
			<?php } elseif (is_tag()) { ?> 
				<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
			<?php } elseif (is_author()) { ?>
				<span><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->nickname; _e(" Archive", "mythemeshop"); ?></span> 
			<?php } elseif (is_day()) { ?>
				<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
			<?php } elseif (is_month()) { ?>
				<span><?php _e("Monthly Archive:", "mythemeshop"); ?>:</span> <?php the_time('F Y'); ?>
			<?php } elseif (is_year()) { ?>
				<span><?php _e("Yearly Archive:", "mythemeshop"); ?>:</span> <?php the_time('Y'); ?>
			<?php } ?>
		</h1>
		<div class="home article">
			<div id="content_box">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php get_template_part( 'functions/post-format/content', get_post_format() ); ?>
				<?php endwhile; endif; ?>
				<?php wp_reset_query(); ?>
			</div>
		</div>
	<?php } elseif($mts_options['mts_grid_layout'] == '0'){ ?>
		<h1 class="postsby">
			<?php if (is_category()) { ?>
				<span><?php single_cat_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
			<?php } elseif (is_tag()) { ?> 
				<span><?php single_tag_title(); ?><?php _e(" Archive", "mythemeshop"); ?></span>
			<?php } elseif (is_author()) { ?>
				<span><?php  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); echo $curauth->nickname; _e(" Archive", "mythemeshop"); ?></span> 
			<?php } elseif (is_day()) { ?>
				<span><?php _e("Daily Archive:", "mythemeshop"); ?></span> <?php the_time('l, F j, Y'); ?>
			<?php } elseif (is_month()) { ?>
				<span><?php _e("Monthly Archive:", "mythemeshop"); ?>:</span> <?php the_time('F Y'); ?>
			<?php } elseif (is_year()) { ?>
				<span><?php _e("Yearly Archive:", "mythemeshop"); ?>:</span> <?php the_time('Y'); ?>
			<?php } ?>
		</h1>
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

<?php get_footer(); ?>