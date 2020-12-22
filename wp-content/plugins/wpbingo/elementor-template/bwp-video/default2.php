<div class="bwp-widget-video <?php echo esc_attr($class); ?> <?php echo esc_attr($layout); ?>">	
	<div class="bg-video">		
		<div class="video-wrapper videos">
			<div class="bwp-image">
				<?php  if($link): ?>
					<a class="bwp-video" href="<?php echo esc_url($link); ?>">
						<div class="videoThumb">
							<?php  if($image): ?>
								<img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="" />
							<?php endif;?>
						</div>
					</a>
				<?php endif;?>
			</div>
		</div>
	</div>	
	<?php if( $title1) : ?>
	<div class="title-video"><h2><?php echo esc_html( $title1 ); ?></h2></div>
	<?php endif; ?>
</div>
