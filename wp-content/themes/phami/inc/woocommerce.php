<?php
add_action( 'init', 'phami_button_product' );
add_action( 'init', 'phami_woocommerce_single_product_summary' );
add_filter( 'phami_custom_category', 'woocommerce_maybe_show_product_subcategories' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display');
function phami_button_product(){
	$phami_settings = phami_global_settings();
	//Button List Product
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	//Category
	if(isset($phami_settings['show-category']) && $phami_settings['show-category'] ){
		add_action('woocommerce_before_shop_loop_item', 'phami_woocommerce_template_loop_category', 15 );
	}
	//Cart
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		add_action('woocommerce_after_shop_loop_item', 'phami_woocommerce_template_loop_add_to_cart', 15 );
	//Whishlist
	if(isset($phami_settings['product-wishlist']) && $phami_settings['product-wishlist'] && class_exists( 'YITH_WCWL' ) ){
		add_action('woocommerce_after_shop_loop_item', 'phami_add_loop_wishlist_link', 15 );	
	}
	//Compare
	if(isset($phami_settings['product-compare']) && $phami_settings['product-compare'] && class_exists( 'YITH_WOOCOMPARE' ) ){
		add_action('woocommerce_after_shop_loop_item', 'phami_add_loop_compare_link', 20 );
	}	
	//Quickview
		add_action('woocommerce_after_shop_loop_item', 'phami_quickview', 35 );
	/* Remove sold by in product loops */
	if(class_exists("WCV_Vendors")){
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9, 2);
		add_action('woocommerce_after_shop_loop_item_title', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 5 );
	}
	/* Remove result count in product shop */
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
}
function phami_woocommerce_single_product_summary(){
	$phami_settings = phami_global_settings();
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');	
	add_action( 'woocommerce_after_add_to_cart_button', 'phami_add_loop_wishlist_link', 30 );
	add_action( 'woocommerce_after_add_to_cart_button', 'phami_add_loop_compare_link', 35 );
	add_action( 'woocommerce_single_product_summary', 'phami_add_social', 45 );
	if(isset($phami_settings['product-stock']) && $phami_settings['product-stock']){
		add_action( 'woocommerce_single_product_summary', 'phami_label_stock', 10 );
	}	
}
function phami_woocommerce_template_loop_category() {
	global $product;
	$html = '';
	$category =  get_the_terms( $product->get_id(), 'product_cat' );
	if ( $category && ! is_wp_error( $category ) ) {	
		$html = '<div class="cat-products">';
			$html .= '<a href="'.get_term_link( $category[0]->term_id, 'product_cat' ).'">';
				$html .= $category[0]->name;
			$html .= '</a>';
		$html .= '</div>';
	}
	echo wp_kses($html,'social');
}
function phami_update_total_price() {
	global $woocommerce;
	$data = array(
		'total_price' => $woocommerce->cart->get_cart_total(),
	);
	wp_send_json($data);
}	
add_action( 'wp_ajax_phami_update_total_price', 'phami_update_total_price' );
add_action( 'wp_ajax_nopriv_phami_update_total_price', 'phami_update_total_price' );
function phami_ajax_url_fn(){
	$custom_js = '<script type="text/javascript">';
		$custom_js .= 'var phami_ajax_url = '.esc_url(admin_url('admin-ajax.php', 'relative')).';';
	$custom_js .= '</script>';
	wp_add_inline_style( 'phami-script', $custom_js );
}
add_action('wp_enqueue_scripts', 'phami_ajax_url_fn' );	
/* Ajax Search */
add_action( 'wp_ajax_phami_search_products_ajax', 'phami_search_products_ajax' );
add_action( 'wp_ajax_nopriv_phami_search_products_ajax', 'phami_search_products_ajax' );
function phami_search_products_ajax(){
	$character = (isset($_GET['character']) && $_GET['character'] ) ? $_GET['character'] : '';
	$limit = (isset($_GET['limit']) && $_GET['limit'] ) ? $_GET['limit'] : 5;
	$category = (isset($_GET['category']) && $_GET['category'] ) ? $_GET['category'] : "";
	$args = array(
		'post_type' 			=> 'product',
		'post_status'    		=> 'publish',
		'ignore_sticky_posts'   => 1,	  
		's' 					=> $character,
		'posts_per_page'		=> $limit
	);
	
	if($category){
		$args['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category ));
	}
	$list = new WP_Query( $args );
	$json = array();
	if ($list->have_posts()) {
		while($list->have_posts()): $list->the_post();
		global $product, $post;
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'shop_catalog' );
		$json[] = array(
			'product_id' => $product->id,
			'name'       => $product->get_title(),		
			'image'		 =>  $image[0],
			'link'		 =>  get_permalink( $product->id ),
			'price'      =>  $product->get_price_html(),
		);			
		endwhile;
	}
	die (json_encode($json));
}
function phami_label_stock(){
	global $product; 
	$stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
	<div class="product-stock <?php echo esc_attr( $stock ); ?>">    
		<span><?php esc_html_e( 'Availability:', 'phami' ); ?></span>
		<i class="fa fa-check-square-o"></i><span class="stock"><?php  if( $product->is_in_stock() ){ echo esc_html__( 'In Stock', 'phami' ); }else{ echo esc_html__( 'Out stock', 'phami' ); } ?></span>
	</div>
<?php }
function phami_woocommerce_template_loop_add_to_cart( $args = array() ) {
	global $product;
	if ( $product ) {
		$defaults = array(
			'quantity' => 1,
			'class'    => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'read_more',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			) ) ),
		);
		$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
		wc_get_template( 'loop/add-to-cart.php', $args );
	}
}	
function phami_add_excerpt_in_product_archives() {
	global $post;
	if ( ! $post->post_excerpt ) return;		
	echo '<div class="item-description item-description2">'.wp_trim_words( $post->post_excerpt, 25 ).'</div>';
}	
/*add second thumbnail loop product*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'phami_woocommerce_template_loop_product_thumbnail', 10 );
function phami_product_thumbnail( $size = 'woocommerce_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $phami_settings,$product;
	$html = '';
	$id = get_the_ID();
	$gallery = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';
	if(!empty($gallery)) {
		$gallery = explode(',', $gallery);
		$first_image_id = $gallery[0];
		$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
	}
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), '' );
		if ( has_post_thumbnail() ){
			if( $attachment_image && $phami_settings['category-image-hover']){
				$html .= '<div class="product-thumb-hover">';
				$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';
				$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'phami').'">';
				if($phami_settings['category-image-hover']){
					$html .= $attachment_image;
				}
				$html .= '</a>';
				$html .= '</div>';				
			}else{
				$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
				$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'phami').'">';
				$html .= '</a>';
			}		
		}else{
			$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
			$html .= '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'phami').'">';
			$html .= '</a>';	
		}
	/* quickview */
	return $html;
}
function phami_woocommerce_template_loop_product_thumbnail(){
	echo phami_product_thumbnail();
}
function phami_countdown_woocommerce_template_loop_product_thumbnail(){
	echo phami_product_thumbnail("shop_single");
}
//Button List Product
/*********QUICK VIEW PRODUCT**********/
function phami_product_quick_view_scripts() {	
	wp_enqueue_script('wc-add-to-cart-variation');
}
add_action( 'wp_enqueue_scripts', 'phami_product_quick_view_scripts' );	
function phami_quickview(){
	global $product;
	$quickview = phami_get_config('product_quickview'); 
	if( $quickview ) : 
		echo '<span class="product-quickview"><a href="#" data-product_id="'.esc_attr($product->get_id()).'" class="quickview quickview-button quickview-'.esc_attr($product->get_id()).'" >'.apply_filters( 'out_of_stock_add_to_cart_text', 'Quick View' ).' <i class="icon_search"></i>'.'</a></span>';
	endif;
}
add_action("wp_ajax_phami_quickviewproduct", "phami_quickviewproduct");
add_action("wp_ajax_nopriv_phami_quickviewproduct", "phami_quickviewproduct");
function phami_quickviewproduct(){
	echo phami_content_product();exit();
}
function phami_content_product(){
	$productid = (isset($_REQUEST["product_id"]) && $_REQUEST["product_id"]>0) ? $_REQUEST["product_id"] : 0;
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 
		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	return $output;	
}
//Wish list
function phami_add_loop_wishlist_link(){	
	if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
}
//Compare
function phami_add_loop_compare_link(){
	global $post;
	$product_id = $post->ID;	
	if( class_exists( 'YITH_WOOCOMPARE' ) ){
		echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. esc_attr($product_id) .'" rel="nofollow">'.esc_html__("Compare","phami").'</a></div>';	
	}	
}
function phami_add_social() {
	if ( shortcode_exists( 'social_share' ) ) :
		echo '<div class="social-icon">';
			echo '<div class="social-title">' . esc_html__( 'Share:', 'phami' ) . '</div>';
			echo do_action( 'woocommerce_share' );
			echo do_shortcode( "[social_share]" );
		echo '</div>';
	endif;	
}
function phami_add_thumb_single_product() {
	echo '<div class="image-thumbnail-list">';
	do_action( 'woocommerce_product_thumbnails' );
	echo '</div>';
}
function phami_get_class_item_product(){
	$phami_settings = phami_global_settings();
	$product_col_large = 12 /(phami_get_config('product_col_large',4));	
	$product_col_medium = 12 /(phami_get_config('product_col_medium',3));
	$product_col_sm 	= 12 /(phami_get_config('product_col_sm',1));
	$class_item_product = 'col-lg-'.$product_col_large.' col-md-'.$product_col_medium.' col-sm-'.$product_col_sm;
	return $class_item_product;
}
function phami_catalog_perpage(){
	$phami_settings = phami_global_settings();
	$query_string = phami_get_query_string();
	parse_str($query_string, $params);
	$query_string 	= '?'.$query_string;
	$per_page 	=   (isset($phami_settings['product_count']) && $phami_settings['product_count'])  ? (int)$phami_settings['product_count'] : 12;
	$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
	?>
	<div class="phami-woocommerce-sort-count">
		<div class="woocommerce-sort-count pwb-dropdown dropdown">
			<span class="pwb-dropdown-toggle dropdown-toggle" data-toggle="dropdown"><?php echo esc_html__('Show','phami'); ?></span>
			<ul class="pwb-dropdown-menu dropdown-menu">
				<li data-value="<?php echo esc_attr($per_page); 	?>"<?php if ($product_count == $per_page){?>class="active"<?php } ?>><a href="<?php echo phami_add_url_parameter($query_string, 'product_count', $per_page); ?>"><?php echo esc_attr($per_page); ?></a></li>
				<li data-value="<?php echo esc_attr($per_page*2); 	?>"<?php if ($product_count == $per_page*2){?>class="active"<?php } ?>><a href="<?php echo phami_add_url_parameter($query_string, 'product_count', $per_page*2); ?>"><?php echo esc_attr($per_page*2); ?></a></li>
				<li data-value="<?php echo esc_attr($per_page*3); 	?>"<?php if ($product_count == $per_page*3){?>class="active"<?php } ?>><a href="<?php echo phami_add_url_parameter($query_string, 'product_count', $per_page*3); ?>"><?php echo esc_attr($per_page*3); ?></a></li>
			</ul>
		</div>
	</div>
<?php }	
add_filter('loop_shop_per_page', 'phami_loop_shop_per_page');
function phami_loop_shop_per_page() {
	$phami_settings = phami_global_settings();
	$query_string = phami_get_query_string();
	parse_str($query_string, $params);
	$per_page 	=   (isset($phami_settings['product_count']) && $phami_settings['product_count'])  ? (int)$phami_settings['product_count'] : 12;
	$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
	return $product_count;
}	
function phami_found_posts(){
	wc_get_template( 'loop/woocommerce-found-posts.php' );
}	
remove_action('woocommerce_before_main_content', 'phami_woocommerce_breadcrumb', 20);	
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
function phami_search_form_product(){
	$query_string = phami_get_query_string();
	parse_str($query_string, $params);
	$category_slug = isset( $params['product_cat'] ) ? $params['product_cat'] : '';
	$terms =	get_terms( 'product_cat', 
	array(  
		'hide_empty' => true,	
		'parent' => 0	
	));
	$class_ajax_search 	= "";	 
	$ajax_search 		= phami_get_config('show-ajax-search',false);
	$limit_ajax_search 		= phami_get_config('limit-ajax-search',5);
	if($ajax_search){
		$class_ajax_search = "ajax-search";
	}
	?>
	<form role="search" method="get" class="search-from <?php echo esc_attr($class_ajax_search); ?>" action="<?php echo esc_url(home_url( '/' )); ?>" data-admin="<?php echo admin_url( 'admin-ajax.php', 'phami' ); ?>" data-noresult="<?php echo esc_html__("No Result","phami") ; ?>" data-limit="<?php echo esc_attr($limit_ajax_search); ?>">
		<?php if($terms){ ?>
		<div class="select_category pwb-dropdown dropdown">
			<span class="pwb-dropdown-toggle dropdown-toggle" data-toggle="dropdown"><?php echo esc_html__("Category","phami"); ?></span>
			<span class="caret"></span>
			<ul class="pwb-dropdown-menu dropdown-menu category-search">
			<li data-value="" class="<?php  echo (empty($category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html__("Browse Category","phami"); ?></li>
				<?php foreach($terms as $term){?>
					<li data-value="<?php echo esc_attr($term->slug); ?>" class="<?php  echo (($term->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term->name); ?></li>
					<?php
						$terms_vl1 =	get_terms( 'product_cat', 
						array( 
								'parent' => '', 
								'hide_empty' => false,
								'parent' 		=> $term->term_id, 
						));						
					?>	
					<?php foreach ($terms_vl1 as $term_vl1) { ?>
						<li data-value="<?php echo esc_attr($term_vl1->slug); ?>" class="<?php  echo (($term_vl1->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl1->name); ?></li>
						<?php
							$terms_vl2 =	get_terms( 'product_cat', 
							array( 
									'parent' => '', 
									'hide_empty' => false,
									'parent' 		=> $term_vl1->term_id, 
						));	?>					
						<?php foreach ($terms_vl2 as $term_vl2) { ?>
						<li data-value="<?php echo esc_attr($term_vl2->slug); ?>" class="<?php  echo (($term_vl2->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl2->name); ?></li>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</ul>	
			<input type="hidden" name="product_cat" class="product-cat" value="<?php echo esc_attr($category_slug); ?>"/>
		</div>	
		<?php } ?>	
		<div class="search-box">
			<button id="searchsubmit" class="btn" type="submit">
				<i class="icon_search"></i>
				<span><?php echo esc_html__('search','phami'); ?></span>
			</button>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" class="input-search s" placeholder="<?php echo esc_attr__( 'Search', 'phami' ); ?>" />
			<ul class="result-search-products">
			</ul>
		</div>
		<input type="hidden" name="post_type" value="product" />
	</form>
<?php }
function phami_top_cart(){
	global $woocommerce; ?>
	<div id="cart" class="top-cart">
		<a class="cart-icon" href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" title="<?php esc_attr_e('View your shopping cart', 'phami'); ?>">
			<i class="flaticon-bag"></i>
		</a>
	</div>
<?php }
function phami_button_filter(){
	$html = '<a class="button-filter-toggle hidden-xs hidden-sm">'.esc_html__( 'Filter', 'phami' ).'</a>';
	echo wp_kses_post($html);
}	
function phami_image_single_product(){
	$phami_settings = phami_global_settings();
	$class = new stdClass;
	$class->show_thumb = phami_get_config('product-thumbs',false);
	$position = (isset($phami_settings['position-thumbs']) && $phami_settings['position-thumbs']) ? $phami_settings['position-thumbs'] : "bottom";
	$position = get_post_meta( get_the_ID(), 'product_position_thumb', true ) ? get_post_meta( get_the_ID(), 'product_position_thumb', true ) : $position;
	$class->position = $position;
	if($class->show_thumb && $position == "outsite"){
		add_action( 'woocommerce_single_product_summary', 'phami_add_thumb_single_product', 40 );
	}	
	if($position == 'left' || $position == "right"){
		$class->class_thumb = "col-sm-2";
		$class->class_data_image = 'data-vertical="true" data-verticalswiping="true"';
		$class->class_image = "col-sm-10";
	}else{
		$class->class_thumb = $class->class_image = "col-sm-12";
		$class->class_data_image = "";
	}
	if(isset($phami_settings['product-thumbs-count']) && $phami_settings['product-thumbs-count'])
		$product_count_thumb = 	$phami_settings['product-thumbs-count'];
	else
		$product_count_thumb = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$product_count_thumb = get_post_meta( get_the_ID(), 'product_count_thumb', true ) ? get_post_meta( get_the_ID(), 'product_count_thumb', true ) : $product_count_thumb;
	$class->product_count_thumb =	$product_count_thumb;
	$product_layout_thumb = (isset($phami_settings['layout-thumbs']) && $phami_settings['layout-thumbs']) ? $phami_settings['layout-thumbs'] : "zoom";
	$product_layout_thumb = get_post_meta( get_the_ID(), 'product_layout_thumb', true ) ? get_post_meta( get_the_ID(), 'product_layout_thumb', true ) : $product_layout_thumb;
	$class->product_layout_thumb =	$product_layout_thumb;	
	return $class;
}
function phami_category_top_bar(){
	$sidebar_product = phami_category_sidebar();
	add_action('woocommerce_before_shop_loop','phami_display_view', 35);
	remove_action('woocommerce_before_shop_loop','phami_found_posts', 20);
	add_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30);
	add_action('woocommerce_before_shop_loop','phami_catalog_perpage', 40);
	if($sidebar_product == 'full'){
		add_action('woocommerce_before_shop_loop','phami_button_filter', 25);
	}	
	do_action( 'woocommerce_before_shop_loop' );
}
function phami_get_product_discount(){
	global $product;
	$discount = 0;
	if ($product->is_on_sale() && $product->is_type( 'variable' )){
		$available_variations = $product->get_available_variations();
		for ($i = 0; $i < count($available_variations); ++$i) {
			$variation_id=$available_variations[$i]['variation_id'];
			$variable_product1= new WC_Product_Variation( $variation_id );
			$regular_price = $variable_product1->get_regular_price();
			$sales_price = $variable_product1->get_sale_price();
			if(is_numeric($regular_price) && is_numeric($sales_price)){
				$percentage = round( (( $regular_price - $sales_price ) / $regular_price ) * 100 ) ;
				if ($percentage > $discount) {
					$discount = $percentage;
				}
			}
		}
	}elseif($product->is_on_sale() && $product->is_type( 'simple' )){
		$regular_price	= $product->get_regular_price();
		$sales_price	= $product->get_sale_price();
		if(is_numeric($regular_price) && is_numeric($sales_price)){
			$discount = round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 );
		}
	}
	if( $discount > 0 ){
		$text_discount = "-".$discount.'%';
	}else{
		$text_discount = '';
	}
	return 	$text_discount;
}
add_action( 'woocommerce_before_quantity_input_field', 'phami_display_quantity_plus' );
function phami_display_quantity_plus() {
   $html = '<button type="button" class="plus" >+</button>';
   echo wp_kses($html,'social');
}
add_action( 'woocommerce_after_quantity_input_field', 'phami_display_quantity_minus' );
function phami_display_quantity_minus() {
	$html = '<button type="button" class="minus" >-</button>';
	echo wp_kses($html,'social');
}
?>