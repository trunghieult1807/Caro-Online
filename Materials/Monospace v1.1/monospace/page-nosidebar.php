<?php
/**
 * Template Name: Page Without Sidebar
 */
?>
<?php $mts_options = get_option('monospace'); ?>
<?php get_header(); ?>
<div id="page" class="single">
	<article class="article no-sidebar">
		<div class="single_post">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('g post'); ?>>
					<div class="single_page">
						<header>
							<h1 class="title"><?php the_title(); ?></h1>
						</header>
						<hr />						
						<div class="post-single-content box mark-links">
							<?php if ( has_post_thumbnail() ) { ?> 
								<?php the_post_thumbnail('large'); ?>
								<div class="clear"></div>
							<?php } ?>
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','mythemeshop'), 'previouspagelink' => __('Previous','mythemeshop'), 'pagelink' => '%','echo' => 1 )); ?>
						</div><!--.post-content box mark-links-->
					</div>
				</div>
				<?php comments_template( '', true ); ?>
			<?php endwhile; ?>
		</div>
	</article>
	<?php //get_sidebar(); ?>
<?php get_footer(); ?>