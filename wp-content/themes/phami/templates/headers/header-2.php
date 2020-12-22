	<?php 
		$phami_settings = phami_global_settings();
		$enable_sticky_header = ( isset($phami_settings['enable-sticky-header']) && $phami_settings['enable-sticky-header'] ) ? ($phami_settings['enable-sticky-header']) : false;
		$show_minicart = (isset($phami_settings['show-minicart']) && $phami_settings['show-minicart']) ? ($phami_settings['show-minicart']) : false;
		$show_searchform = (isset($phami_settings['show-searchform']) && $phami_settings['show-searchform']) ? ($phami_settings['show-searchform']) : false;		
		$show_wishlist = (isset($phami_settings['show-wishlist']) && $phami_settings['show-wishlist']) ? ($phami_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id="bwp-header" class="bwp-header header-v2">
		<div class='header-wrapper'>
			<div class="header-top">
				<div class="row">
					<?php if($show_minicart || $show_searchform || is_active_sidebar('top-link')){ ?>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-5 header-left">
							<div class="header-logo col-xs-12">
								<?php phami_header_logo();?>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-7 header-right">
							<div class="header-page-link">
								<div class="header-content sticky-sidebar">
									<div class="active-menu">
										<span class="line-1"></span>
										<span class="line-2"></span>
										<span class="line-3"></span>
									</div>
									<div class="header-main">
										<div class="active-menu"></div>
										<div class="wpbingo-menu-mobile wpbingo-menu-sidebar">
											<?php phami_top_menu(); ?>
										</div>
									</div>
								</div>
								<?php if(is_active_sidebar('top-link')){ ?>
									<div class="block-top-link">
										<?php dynamic_sidebar( 'top-link' ); ?>
									</div>
								<?php } ?>
								<!-- Begin Search -->
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
								<div class="search-box">
									<div class="search-toggle"><i class="icon-search"></i></div>
								</div>
								<?php } ?>
								<!-- End Search -->
								<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
								<div class="phami-topcart">
									<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
								</div>
								<?php } ?>
							</div>
						</div>
					<?php }else{ ?>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-8 header-test header-left">
							<div class="header-logo col-xs-12">
								<?php phami_header_logo();?>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-4 header-test header-right">
							<div class="header-page-link">
								<div class="header-content sticky-sidebar">
									<div class="active-menu">
										<span class="line-1"></span>
										<span class="line-2"></span>
										<span class="line-3"></span>
									</div>
									<div class="header-main">
										<div class="active-menu"></div>
										<div class="wpbingo-menu-mobile wpbingo-menu-sidebar">
											<?php phami_top_menu(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</header><!-- End #bwp-header -->