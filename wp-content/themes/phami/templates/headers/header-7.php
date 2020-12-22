	<?php 
		$phami_settings = phami_global_settings();
		$show_minicart = (isset($phami_settings['show-minicart']) && $phami_settings['show-minicart']) ? ($phami_settings['show-minicart']) : false;
		$enable_sticky_header = ( isset($phami_settings['enable-sticky-header']) && $phami_settings['enable-sticky-header'] ) ? ($phami_settings['enable-sticky-header']) : false;
		$show_searchform = (isset($phami_settings['show-searchform']) && $phami_settings['show-searchform']) ? ($phami_settings['show-searchform']) : false;
		$show_wishlist = (isset($phami_settings['show-wishlist']) && $phami_settings['show-wishlist']) ? ($phami_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v7">
		<?php if(isset($phami_settings['show-header-top']) && $phami_settings['show-header-top']){ ?>
		<div id="bwp-topbar" class="topbar-v1">
			<div class="topbar-inner">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 topbar-left">
						<?php if( isset($phami_settings['phone']) && $phami_settings['phone'] ) : ?>
						<div class="number-phone hidden-sm hidden-xs hidden-md">
							<label><i class="icon-telephone"></i></label><?php echo esc_html($phami_settings['phone']); ?>
						</div>
						<?php endif; ?>
						<?php if( isset($phami_settings['email']) && $phami_settings['email'] ) : ?>
						<div class="email">
							<label><i class="icon-mail"></i></label> <a href="<?php echo esc_attr($phami_settings['link-email']); ?>"><?php echo esc_html($phami_settings['email']); ?></a>
						</div>
						<?php endif; ?>
						<?php if( isset($phami_settings['timeopen']) && $phami_settings['timeopen'] ) : ?>
						<div class="time-open hidden-xs hidden-md">
							<label><i class="icon-time"></i></label><?php echo esc_html($phami_settings['timeopen']); ?>
						</div>
						<?php endif; ?>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 topbar-right">
						<?php if( isset($phami_settings['shipping']) && $phami_settings['shipping'] ) : ?>
						<div class="shipping hidden-xs hidden-sm hidden-md">
							<?php echo esc_html($phami_settings['shipping']); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class='header-wrapper '>
			<div class='header-content' data-sticky_header="<?php echo esc_attr($enable_sticky_header); ?>">
				<?php if(($show_searchform || $show_minicart || (is_active_sidebar('top-link')) ) && class_exists( 'WooCommerce' )){ ?>
				<div class="header-top">
					<div class="header-contents">
						<div class="row">
							<div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 header-logo">
								<?php phami_header_logo(); ?>
							</div>
							<div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12 wpbingo-menu-mobile header-main">
								<?php $class_vertical = phami_dropdown_vertical_menu(); ?>
								<div class="header-vertical-menu">
									<div class="categories-vertical-menu hidden-sm hidden-xs <?php echo esc_attr($class_vertical); ?>"
										data-textmore="<?php echo esc_html__("Other","phami"); ?>" 
										data-textclose="<?php echo esc_html__("Close","phami"); ?>" 
										data-max_number_1530="<?php echo esc_attr(phami_limit_verticalmenu()->max_number_1530); ?>" 
										data-max_number_1200="<?php echo esc_attr(phami_limit_verticalmenu()->max_number_1200); ?>" 
										data-max_number_991="<?php echo esc_attr(phami_limit_verticalmenu()->max_number_991); ?>">
										<?php echo phami_vertical_menu(); ?>
									</div>
									<div class="hidden-lg hidden-md pull-right">
										<?php phami_navbar_vertical_menu(); ?>
									</div>	
								</div>
								<div class="content-header">
									<div class="header-menu-bg">
										<?php phami_top_menu(); ?>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-9 col-md-6 col-sm-6 col-6 header-search-form header-page-link">
									<!-- Begin Search -->
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<div class="searchform-content hidden-xs hidden-sm">
										<?php get_template_part( 'search-form' ); ?>
									</div>
								<?php } ?>
								<!-- End Search -->	
								<!-- Begin Search -->
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<div class="search-box hidden-xl hidden-md hidden-lg">
										<div class="search-toggle"><i class="icon-search"></i></div>
									</div>
								<?php } ?>
								<?php if(is_active_sidebar('top-link')){ ?>
									<div class="block-top-link">
										<?php dynamic_sidebar( 'top-link' ); ?>
									</div>
								<?php } ?>
								<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
									<div class="wpbingoCartTop">
										<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
									</div>
								<?php } ?>								
							</div>						
						</div>
					</div>
				</div>
				<?php }else{ ?>
					<div class="header-default">
						<div class="container">
							<div class="row">
								<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-8 header-logo">
									<?php phami_header_logo(); ?>
								</div>
								<div class="col-xl-10 col-lg-10 col-md-6 col-sm-6 col-4 wpbingo-menu-mobile header-main header-content">
									<div class="content-header">
										<div class="header-menu-bg">
											<?php phami_top_menu(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>	
			</div>
		</div><!-- End header-wrapper -->	
	</header><!-- End #bwp-header -->