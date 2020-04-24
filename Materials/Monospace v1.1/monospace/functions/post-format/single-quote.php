<?php $mts_options = get_option('monospace'); ?>

<div class="single_post quote-format">		
	<?php if ($mts_options['mts_breadcrumb'] == '1') { ?>
		<div class="breadcrumb" itemprop="breadcrumb"><?php mts_the_breadcrumb(); ?></div>
	<?php } ?>
	<header>
		<h1 class="title single-title"><?php the_title(); ?></h1>	
	</header><!--.headline_area-->
	<hr />
	<?php if($mts_options['mts_single_headline_meta'] == '1') { ?>
		<div class="post-info">
			<?php if(isset($mts_options['mts_single_headline_meta_info']['4']) == '1') { ?>
				<span class="theauthor"><?php _e('By', 'mythemeshop'); ?> <?php  the_author_posts_link(); ?></span>  
			<?php } ?>
			<?php if(isset($mts_options['mts_single_headline_meta_info']['5']) == '1') { ?>
				<span class="thetime updated"><?php the_time( get_option( 'date_format' ) ); ?></span>  
			<?php } ?>
			<?php if(isset($mts_options['mts_single_headline_meta_info']['6']) == '1') { ?>
				<span class="thecategory"><i class="icon-tags"></i> <?php the_category(', ') ?></span>
			<?php } ?>
			<?php if(isset($mts_options['mts_single_headline_meta_info']['7']) == '1') { ?>
				<span class="thecomment"><i class="icon-comments"></i> <a rel="nofollow" href="<?php comments_link(); ?>"><?php echo comments_number('<span class="comm">0</span> '.__('Comment','mythemeshop'), '<span class="comm">1</span> '.__('Comment','mythemeshop'), '<span class="comm">%</span> '.__('Comments','mythemeshop')); ?></a></span>
			<?php } ?>
		</div>
	<?php } ?>
	
	<div class="post-single-content box mark-links">
		<?php if ($mts_options['mts_posttop_adcode'] != '') { ?>
			<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
				<div class="topad">
					<?php echo $mts_options['mts_posttop_adcode']; ?>
				</div>
			<?php } ?>
		<?php } ?>
		<blockquote><?php echo get_the_content() ?></blockquote>
		<a href="<?php echo get_post_meta($post->ID, '_format_quote_source_url', true); ?>" target="_blank"><?php if(get_post_meta($post->ID, '_format_quote_source_name', true) != ""){ echo '- ' . get_post_meta($post->ID, '_format_quote_source_name', true); } ?></a>
		<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','mythemeshop'), 'previouspagelink' => __('Previous','mythemeshop'), 'pagelink' => '%','echo' => 1 )); ?>
		<?php if ($mts_options['mts_postend_adcode'] != '') { ?>
			<?php $endtime = $mts_options['mts_postend_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$endtime day")), get_the_time("Y-m-d") ) >= 0) { ?>
				<div class="bottomad">
					<?php echo $mts_options['mts_postend_adcode'];?>
				</div>
			<?php } ?>
		<?php } ?> 
		<?php if($mts_options['mts_tags'] == '1') { ?>
			<div class="tags"><?php the_tags('<span class="tagtext">'.__('Tags','mythemeshop').':</span>',', ') ?></div>
		<?php } ?>
	</div>
</div><!--.single-post -->