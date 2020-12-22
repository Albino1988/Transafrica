<?php 
	get_header(); 
	$phami_settings = phami_global_settings();
	$background = phami_get_config('background');
	$bgs 			= 	( isset($phami_settings['img-404']['url']) && $phami_settings['img-404']['url'] ) ? $phami_settings['img-404']['url'] : get_template_directory_uri() . '/images/image_404.png';
	$title_error 	=	( isset($phami_settings['title-error']) && $phami_settings['title-error'] ) ? $phami_settings['title-error'] : esc_html__('404', 'phami');
	$sub_title 		=	( isset($phami_settings['sub-title']) && $phami_settings['sub-title'] ) ? $phami_settings['sub-title'] : esc_html__('Page Not Found!', 'phami');
	$sub_error 		=	( isset($phami_settings['sub-error']) && $phami_settings['sub-error'] ) ? $phami_settings['sub-error'] : esc_html__('Oops! Page you are looking for does not exist.', 'phami');
	$btn_error 		=	( isset($phami_settings['btn-error']) && $phami_settings['btn-error'] ) ? $phami_settings['btn-error'] : esc_html__('back to home page', 'phami');
?>
<div class="container">
	<div class="page-404">
		<div class="img-404">
			<img src="<?php echo esc_url($bgs); ?>" alt="<?php echo esc_attr__('Image 404','phami'); ?>">
			<div class="title-error"><?php echo esc_html($title_error); ?></div>
		</div>
		<div class="content-page-404">
			<div class="sub-title"><?php echo esc_html($sub_title); ?></div>
			<div class="sub-error"><?php echo esc_html($sub_error); ?></div>
			<a class="btn" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo esc_html($btn_error); ?></a>	
		</div>
	</div>
</div>
<?php
get_footer();