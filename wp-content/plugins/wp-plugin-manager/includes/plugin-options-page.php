<?php
/**
 * Add a submenu under the "plugins" menu
 */
if ( ! function_exists('is_plugin_active') ){ include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); }
add_action( 'admin_menu', 'htpm_submenu' );
function htpm_submenu() {
	add_submenu_page( 'plugins.php', esc_html__('Plugin Manager', 'htpm'), esc_html__('Plugin Manager', 'htpm'), 'manage_options', 'htpm-options', 'htpm_options_page_html' );
}

/**
 * Render the option page
 */
function htpm_options_page_html() {
	 // check user capabilities
	 if ( ! current_user_can( 'manage_options' ) ) {
	 	return;
	 }

	 // show message when updated
	 if ( isset( $_GET['settings-updated'] ) ) {
	 	add_settings_error( 'htpm_messages', 'htpm_message', esc_html__( 'Settings Saved', 'htpm' ), 'updated' );
	 }
	 
	 // show error/update messages
	 settings_errors( 'htpm_messages' );
	 ?>

	 <div class="wrap">
		 <h1><?php echo esc_html( get_admin_page_title() ); ?> <?php echo esc_html__( 'Options', 'htpm' ) ?></h1>
		<h2 class="nav-tab-wrapper">
		 	<a href="#htpm-tab-1" class="htmp-nav nav-tab nav-tab-active"><?php esc_html_e('Plugin Manager Option', 'htpm')?></a>
		 	<a href="#htmp-tab-2" class="htmp-nav nav-tab"><?php esc_html_e('Our Plugins', 'htpm')?></a>
		</h2>
		<div id="htpm-tab-1" class="htpm-tab-group htmp-active-tab" style="display: none;">
			<form action="options.php" method="post">
				 <?php
					 // output general section and their fields
					 do_settings_sections( 'options_group_general' );

					 // general option fields
					 settings_fields( 'options_group_general' );

					 // output save settings button
					 submit_button( 'Save Settings' );
				 ?>
			</form>
		</div>
		<div id="htmp-tab-2" class="htpm-tab-group" style="display: none;">
	        <div class="htmp-row">
	        	<div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/woolentor.png' ?>">
	                	</div>
	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'Woolentor Pro','htpm' );?></h3>
		                    <p><?php esc_html_e( 'WooLentor is a most popular WooCommerce Elementor Addon on WordPress.org. Downloaded more than 100,000 times and 15,000 stores are using WooLentor plugin.', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/plugins/woolentor-pro-woocommerce-page-builder/" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                       
		                        <?php htpm_plugin_install_button( 'woolentor-addons/woolentor_addons_elementor.php','woolentor-addons' ); ?>
		                    </div>
		                </div>
	                </div>
	            </div>
	            <div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/ht-mega.png' ?>">
	                	</div>
	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'HT Mega','htpm' );?></h3>
		                    <p><?php esc_html_e( 'HTMega is a absolute addons for elementor includes 80+ elements & 360 Blocks with unlimited variations.', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/plugins/ht-mega-pro/" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                       
		                        <?php htpm_plugin_install_button( 'ht-mega-for-elementor/htmega_addons_elementor.php','ht-mega-for-elementor' ); ?>
		                    </div>
		                </div>
	                </div>
	            </div>
	            <div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/multy-currency.png' ?>">
	                	</div>
	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'Multi Currency Pro for WooCommerce','htpm' );?></h3>
		                    <p><?php esc_html_e( 'Multi-Currency Pro for WooCommerce is a prominent currency switcher plugin for WooCommerce.', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/plugins/multi-currency-pro-for-woocommerce/" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                        <?php htpm_plugin_install_button( 'wc-multi-currency/wcmilticurrency.php','wc-multi-currency' ); ?>
		                    </div>
	                    </div>
	                </div>
	            </div>
	            <div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/ht-script.png' ?>">
	                	</div>

	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'HT Script - Insert Headers and Footers Code','htpm' );?></h3>
		                    <p><?php esc_html_e( 'Insert Headers and Footers Code allows you to insert Google Analytics, Facebook Pixel, custom CSS, custom HTML, JavaScript code to your website header and footer without modifying your theme code.', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/plugins/insert-headers-and-footers-code-ht-script/" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                        <?php htpm_plugin_install_button( 'insert-headers-and-footers-script/init.php','insert-headers-and-footers-script' ); ?>
		                    </div>
	                	</div>
	                </div>
	            </div>
	            <div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/hashbar.png' ?>">
	                	</div>
	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'HashBar Pro','htpm' );?></h3>
		                    <p><?php esc_html_e( 'HashBar is a WordPress Notification / Alert / Offer Bar plugin which allows you to create unlimited notification bars.This plugin has option to show email subscription form, Offer text and buttons about your promotions', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/wordpress-notification-bar-plugin/" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                        <?php htpm_plugin_install_button( 'hashbar-wp-notification-bar/init.php','hashbar-wp-notification-bar' ); ?>
		                    </div>
		                </div>
	                </div>
	            </div>
	            <div class="htmp-column-2">
	                <div class="htmp-singleplugin">
	                	<div class="htmp-thumb">
	                		<img src="<?php echo HTPM_ROOT_URL . '/assets/images/plugins-image/wcbuilder.png' ?>">
	                	</div>
	                	<div class="htmp-content">
		                    <h3><?php esc_html_e( 'WC Builder','htpm' );?></h3>
		                    <p><?php esc_html_e( 'WC Builder Pro is a WooCommerce Page Builder which allows you to build Shop, Product Details, Cart, Checkout, My Account and Thank You page without even touching a single line of code!', 'htpm' )?></p>
		                    <div class="htmp-button-area">
		                        <a class="button primary" href="https://hasthemes.com/plugins/wc-builder-woocoomerce-page-builder-for-wpbakery/#pricing" target="_blank"><?php esc_html_e( 'More Details', 'htpm' )?></a>
		                       
		                        <?php htpm_plugin_install_button( 'wc-builder/wc-builder.php','wc-builder' ); ?>
		                    </div>
		                </div>
	                </div>
	            </div>
	        </div>
		</div>
	 </div>

	 <?php
}

/**
 * Register option name & group
 * Add section
 * Add fields
 */
add_action( 'admin_init', 'htpm_settings_init' );
function htpm_settings_init() {
	// reginster option named "htpm_options"
	register_setting( 'options_group_general', 'htpm_options' );

	add_settings_section(
	 'section_1',
	 '',
	 '',
	 'options_group_general'
	);

	add_settings_field(
		'htpm_list_plugins', // field name
		esc_html__( 'Enable/Disable Plugins', 'htpm' ),
		'htpm_list_plugins_cb',
		'options_group_general',
		'section_1',
		[
			'label_for' => 'htpm_list_plugins',
			'class' => 'htpm_row',
		]
	);

	
}

/**
 * htpm_list_plugins_cb callback
 */
function htpm_list_plugins_cb( $args ) {
	$options = get_option( 'htpm_options' );
	$htpm_list_plugins = $options['htpm_list_plugins'];
 ?>
	<div id="htpm_accordion" class="htpm_accordion">
		<?php
		$active_plugins = get_option('active_plugins');
		$plugin_dir = HTPM_PLUGIN_DIR;
		if($active_plugins):
			foreach($active_plugins as $plugin):
				$idividual_options = isset( $htpm_list_plugins[$plugin] ) ? $htpm_list_plugins[$plugin] : array('condition_list'=>'','enable_deactivation'=>Null,'uri_type'=>'','posts'=>'','pages'=>'');
				$plugin_headers = get_plugin_data($plugin_dir . '/' . $plugin);
				$value = isset($htpm_list_plugins[$plugin]) ? $htpm_list_plugins[$plugin] : '';
			?>
			  <h3 class="<?php echo isset( $idividual_options['enable_deactivation'] ) ? 'htpm_is_disabled' : ''; ?>"><?php echo esc_html( $plugin_headers['Name'] ); ?></h3>
			  <div class="htpm_single_accordion" data-htpm_uri_type="<?php echo esc_attr( $idividual_options['uri_type'] ? $idividual_options['uri_type'] : 'page'); ?>">

			  	<div class="htpm_single_field">
				  	<label><?php echo esc_html__('Enable Deactivation:', 'htpm') ?></label>
					<input type="checkbox" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][enable_deactivation]" value="yes" <?php checked( isset($idividual_options['enable_deactivation']), 1 ); ?>>
				</div>

				<div class="htpm_single_field">
				  	<label><?php echo esc_html__( 'URI Type:', 'htpm' ); ?></label>
				  	<select class="htpm_uri_type" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][uri_type]">
				  		<option value="page" <?php selected( $idividual_options['uri_type'], 'page' ) ?>><?php echo esc_html__( 'Page', 'htpm' ) ?></option>
				  		<option value="post" <?php selected( $idividual_options['uri_type'], 'post' ) ?>><?php echo esc_html__( 'Post', 'htpm' ) ?></option>
				  		<option value="page_post" <?php selected( $idividual_options['uri_type'], 'page_post' ) ?>><?php echo esc_html__( 'Post And Pages', 'htpm' ) ?></option>
				  		<option value="page_post_cpt" <?php selected( $idividual_options['uri_type'], 'page_post_cpt' ) ?>><?php echo esc_html__( 'Post , Pages & Custom Post Type ', 'htpm' ) ?></option>
				  		<option value="custom" <?php selected( $idividual_options['uri_type'], 'custom' ) ?>><?php echo esc_html__('Custom', 'htpm') ?></option>
				  	</select>
				</div>

				<div class="htpm_single_field htpm_selected_page_checkboxes">
				  	<label><?php echo esc_html__( 'Select Pages:', 'htpm' ) ?></label>
				  	<div>
					  	<select class="htpm_select2_active" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][pages][]" multiple="multiple">
			  	  		  	<?php
			  	  		  		$selected_pages = isset($idividual_options['pages']) && $idividual_options['pages'] ? $idividual_options['pages'] : array();
			  	  		  		$pages = get_pages();
			  	  		  		foreach ( $pages as $key => $page ) {
			  	  		  			$option_value = esc_attr($page->ID) .','. esc_url(get_page_link( $page->ID ));
			  	  		  			$is_selected = in_array($option_value,  $selected_pages);
			  	  		  			?>
			  	  		  			<option value="<?php echo esc_attr($option_value); ?>" <?php selected($is_selected , true ) ?>><?php echo esc_html($page->post_title);  ?></option>
			  	  		  			<?php
			  	  		  			$option_page_id = false;
			  	  		  		}
			  	  		  	?>
					  	</select>
				  	</div>
				</div>
				
				<div class="htpm_single_field htpm_selected_post_checkboxes">
				  	<label><?php echo esc_html__( 'Select Posts:', 'htpm' ) ?></label>
				  	<div>
	  				  	<select class="htpm_select2_active" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][posts][]" multiple="multiple">
	  		  	  		  	<?php
	  		  	  		  		$selected_posts = isset($idividual_options['posts']) && $idividual_options['posts'] ? $idividual_options['posts'] : array();
	  		  	  		  		$posts = get_posts(array(
	  		  	  		  			'numberposts' => '-1'
	  		  	  		  		));
	  		  	  		  		foreach ( $posts as $key => $post ) {
	  		  	  		  			$option_value = esc_attr($post->ID) .','. esc_url(get_permalink( $post->ID ));
	  		  	  		  			$is_selected = in_array($option_value,  $selected_posts);
	  		  	  		  			?>
	  		  	  		  			<option value="<?php echo esc_attr($option_value); ?>" <?php selected($is_selected, true ) ?>><?php echo esc_html($post->post_title);  ?></option>
	  		  	  		  			<?php
	  		  	  		  		}
	  		  	  		  	?>
	  				  	</select>
				  	</div>
				</div>
			  	<table id="htpmrepeatable-fieldset" class="htpm_repeater" width="100%">
	            <thead>
	                <tr>
	                    <th><?php echo esc_html__( 'URI Condition', 'htpm' ) ?></th>
	                    <th><?php echo esc_html__( 'Value', 'htpm' ); ?></th>
	                    <th><?php echo esc_html__( 'Action', 'htpm' ); ?></th>
	                </tr>
	            </thead>
	            <tbody>
	            	<?php 
	            	$condition_list = array();
	            	$condition_list = $idividual_options['condition_list'];
	            	if( !$condition_list):
	            	?>
            		<tr>
            	        <td>
            	        	<select name="htpm_options[htpm_list_plugins][<?php echo esc_attr( $plugin ) ?>][condition_list][name][]">
            	        		<option value="uri_equals"><?php echo esc_html__( 'URI Equals', 'htpm' ) ?></option>
            	        		<option value="uri_not_equals"><?php echo esc_html__( 'URI Not Equals', 'htpm' ) ?></option>
            	        		<option value="uri_contains"><?php echo esc_html__( 'URI Contains', 'htpm' ) ?></option>
            	        		<option value="uri_not_contains"><?php echo esc_html__( 'URI Not Contains', 'htpm' ) ?></option>
            	        	</select>
            	        </td>
            	        <td>
            	            <input class="widefat" type="text" placeholder="<?php echo esc_html__('E.g: http://example.com/contact-us/ you can use \'contact-us\'', 'htpm'); ?>" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]" value="">
            	        </td>
            	        <td>
            	            <a class="button htpm-remove-row" href="#"><?php echo esc_html__('Remove', 'htpm') ?></a>
            	            <a class="button htpm-add-row" href="#"><?php echo esc_html__( 'Clone', 'htpm' ) ?></a>
            	        </td>
            	    </tr>
	            	<?php
	            	endif;

	            	if($condition_list):
	            	for($i = 0; $i < count($condition_list['name']); $i++ ):
	            		if($condition_list['name'][$i]):
	            	?>
	            	<tr>
	                    <td>
	                    	<select name="htpm_options[htpm_list_plugins][<?php echo esc_attr( $plugin ) ?>][condition_list][name][]">
	                    		<option value="uri_equals" <?php selected( $condition_list['name'][$i], 'uri_equals') ?>><?php echo esc_html__( 'URI Equals', 'htpm' ) ?></option>
	                    		<option value="uri_not_equals" <?php selected( $condition_list['name'][$i], 'uri_not_equals') ?>><?php echo esc_html__( 'URI Not Equals', 'htpm' ) ?></option>
	                    		<option value="uri_contains" <?php selected( $condition_list['name'][$i], 'uri_contains') ?>><?php echo esc_html__( 'URI Contains', 'htpm' ) ?></option>
	                    		<option value="uri_not_contains" <?php selected( $condition_list['name'][$i], 'uri_not_contains') ?>><?php echo esc_html__( 'URI Not Contains', 'htpm' ) ?></option>
	                    	</select>
	                    </td>
	                    <td>
	                        <input class="widefat" type="text" placeholder="<?php echo esc_html__('E.g: http://example.com/contact-us/ you can use \'contact-us\'', 'htpm'); ?>'" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]" value="<?php echo esc_attr($condition_list['value'][$i]); ?>">
	                    </td>
	                    <td>
	                        <a class="button htpm-remove-row" href="#"><?php echo esc_html__('Remove', 'htpm') ?></a>
	                        <a class="button htpm-add-row" href="#"><?php echo esc_html__( 'Clone', 'htpm' ) ?></a>
	                    </td>
	                </tr>
	            	<?php
	            		endif;
	            	endfor;
	            	endif;
	            	?>
	            </tbody>
	        </table>
	        <table class="screen-reader-text">
	        	 <!-- empty hidden one for jQuery -->
	        	 <tr class="htpm-empty-row screen-reader-text">
	        	     <td>
	        	         <input type="text" placeholder="Enter Title" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][name][]">
	        	     </td>
	        	     <td>
	        	         <input type="text" placeholder="Enter Price" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]">
	        	     </td>
	        	     <td>
	        	     	<a class="button htpm-remove-row" href="#"><?php echo esc_html__('Remove', 'htpm') ?></a>
	        	     	<a class="button htpm-add-row" href="#"><?php echo esc_html__( 'Add Another', 'htpm' ) ?></a>
	        	     </td>
	        	 </tr>
	        </table>
			  </div>
			<?php
			endforeach;
		endif;
		?>
	</div>
 <?php
}


function htpm_admin_footer(){
	$notice_text = '<p>This feature is available in the pro version. <a target="_blank" href="'.  esc_url('//hasthemes.com/plugins/wp-plugin-manager-pro/') .'">More details</a></p>';
	?>
	<div id="htpm_pro_notice" style="display:none">
		<?php echo wp_kses_post($notice_text); ?>
	</div>
	<?php
}
add_action( 'admin_footer', 'htpm_admin_footer' );