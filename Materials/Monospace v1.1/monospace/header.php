<!DOCTYPE html>
<?php $mts_options = get_option('monospace'); ?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php mts_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>
<body id ="blog" <?php body_class('main'); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="secondary-navigation mobile">
		<nav id="navigation" class="clearfix">
			<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'container' => '' ) ); ?>
			<?php } else { ?>
				<ul class="menu clearfix">
					<?php wp_list_categories('title_li='); ?>
				</ul>
			<?php } ?>
		</nav>
	</div>
	<div class="main-container">
	<a href="#" id="pull"><?php _e('Menu','mythemeshop'); ?></a>
		<header class="main-header">
			<div class="container">
				<?php if($mts_options['mts_sticky_nav'] == '1') { ?>
					<div id="catcher"></div>
					<div id="sticky">
				<?php } ?>
				<div id="header">
					<div class="logo-wrap">
						<?php if ($mts_options['mts_logo'] != '') { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="image-logo">
										<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="image-logo">
										<a href="<?php echo home_url(); ?>"><img src="<?php echo $mts_options['mts_logo']; ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
									</h2><!-- END #logo -->
							<?php } ?>
						<?php } else { ?>
							<?php if( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="text-logo">
										<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
									</h1><!-- END #logo -->
							<?php } else { ?>
								  <h2 id="logo" class="text-logo">
										<a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>
									</h2><!-- END #logo -->
							<?php } ?>
							<div class="site-description">
								<?php bloginfo( 'description' ); ?>
							</div>
						<?php } ?>
					</div>
					<div class="secondary-navigation">
						<nav id="navigation" class="clearfix">
							<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
								<?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu clearfix', 'container' => '' ) ); ?>
							<?php } else { ?>
								<ul class="menu clearfix">
									<?php wp_list_categories('title_li='); ?>
								</ul>
							<?php } ?>
						</nav>
					</div>              
				</div><!--#header-->
				<?php if($mts_options['mts_sticky_nav'] == '1') { ?>
					</div>
				<?php } ?>
			</div><!--.container-->        
		</header>