<?php 
if ( !class_exists('Woocommerce') ) { 
	return false;
}
global $woocommerce; ?>
<div id="cart" class="dropdown mini-cart top-cart">
	<a class="dropdown-toggle cart-icon" data-toggle="dropdown" data-hover="dropdown" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'phami'); ?>">
		<div class="icons-cart"><i class="icon-shopping-basket"></i><span class="cart-count"><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?></span></div>
    </a>
	<div class="cart-popup">
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>