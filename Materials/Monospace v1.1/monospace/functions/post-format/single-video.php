<?php $mts_options = get_option('monospace'); ?>
<?php 
$content = get_post_meta($post->ID, '_format_video_embed', true);
$content = preg_replace('#\<iframe(.*?)\ssrc\=\"(.*?)\"(.*?)\>#i', '<iframe$1 src="$2?wmode=opaque"$3>', $content);
$content = preg_replace('#\<iframe(.*?)\ssrc\=\"(.*?)\?(.*?)\?(.*?)\"(.*?)\>#i', '<iframe$1 src="$2?$3&$4"$5>', $content);
?>
	
<div class="single_post">
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
		<?php if($mts_options['mts_social_buttons'] == '1' && $mts_options['mts_social_button_position'] == '1') { ?>
			<!-- Start Share Buttons -->
			<div class="shareit top">
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
		<?php if ($mts_options['mts_posttop_adcode'] != '') { ?>
			<?php $toptime = $mts_options['mts_posttop_adcode_time']; if (strcmp( date("Y-m-d", strtotime( "-$toptime day")), get_the_time("Y-m-d") ) >= 0) { ?>
				<div class="topad">
					<?php echo $mts_options['mts_posttop_adcode']; ?>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if(!empty($content)){ ?>
			<?php if(substr($content, 0, 7) == 'http://' || $content == ''){ ?>
			<?php }else{
				echo '<div class="video-format">';
				echo $content;
				echo '</div>';
			} ?>
		<?php } ?>
		<?php the_content(); ?>
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