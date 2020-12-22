<?php
/**
 * Phami Settings Options
 */
if (!class_exists('Redux_Framework_phami_settings')) {
    class Redux_Framework_phami_settings {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        function compiler_action($options, $css, $changed_values) {
        }
        function dynamic_section($sections) {
            return $sections;
        }
        function change_arguments($args) {
            return $args;
        }
        function change_defaults($defaults) {
            return $defaults;
        }
        function remove_demo() {
        }
        public function setSections() {
            $page_layouts = phami_options_layouts();
            $sidebars = phami_options_sidebars();
            $phami_header_type = phami_options_header_types();
            $phami_banners_effect = phami_options_banners_effect();
            // General Settings  ------------
            $this->sections[] = array(
                'icon' => 'fa fa-home',
                'icon_class' => 'icon',
                'title' => esc_html__('General', 'phami'),
                'fields' => array(                
                )
            );  
            // Layout Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'phami'),
                'fields' => array(
                    array(
                        'id' => 'background_img',
                        'type' => 'media',
                        'title' => esc_html__('Background Image', 'phami'),
                        'sub_desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id'=>'show-newletter',
                        'type' => 'switch',
                        'title' => esc_html__('Show Newletter Form', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Show', 'phami'),
                        'off' => esc_html__('Hide', 'phami'),
                    ),
                    array(
                        'id' => 'background_newletter_img',
                        'type' => 'media',
                        'title' => esc_html__('Popup Newletter Image', 'phami'),
                        'url'=> true,
                        'readonly' => false,
                        'sub_desc' => '',
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/newsletter-image.jpg'
                        )
                    ),
                    array(
                            'id' => 'back_active',
                            'type' => 'switch',
                            'title' => esc_html__('Back to top', 'phami'),
                            'sub_desc' => '',
                            'desc' => '',
                            'default' => '1'// 1 = on | 0 = off
                            ),                          
                    array(
                            'id' => 'direction',
                            'type' => 'select',
                            'title' => esc_html__('Direction', 'phami'),
                            'options' => array( 'ltr' => esc_html__('Left to Right', 'phami'), 'rtl' => esc_html__('Right to Left', 'phami') ),
                            'default' => 'ltr'
                        )        
                )
            );
            // Logo & Icons Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo & Icons', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'sitelogo',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Logo', 'phami'),
                        'desc'      => esc_html__('Upload Logo image default here.', 'phami'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo/logo.png'
                        )
                    )
                )
            );
			//Vertical Menu
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'subsection' => true,
                'title' => esc_html__('Vertical Menu', 'phami'),
                'fields' => array( 
                    array(
                        'id'        => 'max_number_1530',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on screen >= 1530px', 'phami'),
                        'default'   => '12'
                    ),
                    array(
                        'id'        => 'max_number_1200',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 1200px', 'phami'),
                        'default'   => '8'
                    ),
					array(
                        'id'        => 'max_number_991',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 991px', 'phami'),
                        'default'   => '6'
                    )
                )
            );
            // Header Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Header', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'header_style',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Header Type', 'phami'),
                        'options' => $phami_header_type,
                        'default' => '1'
                    ),
                    array(
                        'id'=>'show-header-top',
                        'type' => 'switch',
                        'title' => esc_html__('Show Header Top', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'show-searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Form', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'show-ajax-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Ajax Search', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami')
                    ),
                    array(
                        'id'=>'limit-ajax-search',
                        'type' => 'text',
                        'title' => esc_html__('Limit Of Result Search', 'phami'),
						'default' => 6,
						'required' => array('show-ajax-search','equals',true)
                    ),					
                    array(
                        'id'=>'search-cats',
                        'type' => 'switch',
                        'title' => esc_html__('Show Categories', 'phami'),
                        'required' => array('search-type','equals',array('post', 'product')),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'show-wishlist',
                        'type' => 'switch',
                        'title' => esc_html__('Show Wishlist', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'show-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),		
                    array(
                        'id'=>'enable-sticky-header',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Header', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),		
                    array(
                        'id'=>'phone',
                        'type' => 'text',
                        'title' => esc_html__('Header Phone', 'phami'),
                        'default' => ''
                    ),
					array(
                        'id'=>'email',
                        'type' => 'text',
                        'title' => esc_html__('Header Email', 'phami'),
                        'default' => ''
                    ),
					array(
                        'id'=>'link-email',
                        'type' => 'text',
                        'title' => esc_html__('Header Link Email', 'phami'),
                        'default' => '#'
                    ),
                    array(
                        'id'=>'timeopen',
                        'type' => 'text',
                        'title' => esc_html__('Time Open', 'phami'),
                        'default' => ''
                    ),	
                    array(
                        'id'=>'shipping',
                        'type' => 'text',
                        'title' => esc_html__('Shipping', 'phami'),
                        'default' => ''
                    ),  
                    array(
                        'id'=>'money-back',
                        'type' => 'text',
                        'title' => esc_html__('Free Money Back', 'phami'),
                        'default' => ''
                    ),             		
                )
            );
            // Footer Settings
            $footers = phami_get_footers();
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Footer', 'phami'),
                'fields' => array(
                    array(
                        'id' => 'footer_style',
                        'type' => 'image_select',
                        'title' => esc_html__('Footer Style', 'phami'),
                        'sub_desc' => esc_html__( 'Select Footer Style', 'phami' ),
                        'desc' => '',
                        'options' => $footers,
                        'default' => '32'
                    ),
                )
            );
            // Copyright Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Copyright', 'phami'),
                'fields' => array(
                    array(
                        'id' => "footer-copyright",
                        'type' => 'textarea',
                        'title' => esc_html__('Copyright', 'phami'),
                        'default' => sprintf( wp_kses('&copy; Copyright %s. All Rights Reserved.', 'phami'), date('Y') )
                    ),
                    array(
                        'id'=>'footer-payments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Payments Logos', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'footer-payments-image',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Payments Image', 'phami'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/payments.png'
                        )
                    ),
                    array(
                        'id'=>'footer-payments-image-alt',
                        'type' => 'text',
                        'title' => esc_html__('Payments Image Alt', 'phami'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'footer-payments-link',
                        'type' => 'text',
                        'title' => esc_html__('Payments Link URL', 'phami'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    )
                )
            );
            // Page Title Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Page Title', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'page_title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page Title', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'page_title_bg',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Background', 'phami'),
                        'required' => array('page_title','equals', true),
	                    'default' => array(
                            'url' => "",
                        )							
                    ),
                    array(
                        'id' => 'breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Show Breadcrumb', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                        'required' => array('page_title','equals', true),
                    ),
                )
            );
            // 404 Page Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('404 Error', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'title-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'phami'),
                        'desc' => esc_html__('Input a block slug name', 'phami'),
                        'default' => '404'
                    ),
					array(
                        'id'=>'sub-title',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'phami'),
                        'desc' => esc_html__('Input a block slug name', 'phami'),
                        'default' => 'Page Not Found!'
                    ), 					
                    array(
                        'id'=>'sub-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'phami'),
                        'desc' => esc_html__('Input a block slug name', 'phami'),
                        'default' => 'Oops! Page you are looking for does not exist.'
                    ),               
                    array(
                        'id'=>'btn-error',
                        'type' => 'text',
                        'title' => esc_html__('Button Page 404', 'phami'),
                        'desc' => esc_html__('Input a block slug name', 'phami'),
                        'default' => 'back to home page'
                    ),
                    array(
                        'id'=>'img-404',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Image', 'phami'),
                        'desc'      => esc_html__('Upload images 404 default here.', 'phami'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/image_404.png'
                        )
                    )                      
                )
            );
            // Social Share Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Social Share', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'social-share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Links', 'phami'),
                        'desc' => esc_html__('Show social links in post and product, page, portfolio, etc.', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'share-fb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Facebook Share', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'share-tw',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Twitter Share', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'share-linkedin',
                        'type' => 'switch',
                        'title' => esc_html__('Enable LinkedIn Share', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'share-pinterest',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Pinterest Share', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                )
            );
            $this->sections[] = array(
				'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Socials Link', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'socials_link',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Socials link', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'link-fb',
                        'type' => 'text',
                        'title' => esc_html__('Enter Facebook link', 'phami'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-tw',
                        'type' => 'text',
                        'title' => esc_html__('Enter Twitter link', 'phami'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-linkedin',
                        'type' => 'text',
                        'title' => esc_html__('Enter LinkedIn link', 'phami'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-youtube',
                        'type' => 'text',
                        'title' => esc_html__('Enter Youtube link', 'phami'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Enter Pinterest link', 'phami'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-instagram',
                        'type' => 'text',
                        'title' => esc_html__('Enter Instagram link', 'phami'),
						'default' => '#'
                    ),
                )
            );			
            //     The end -----------
            // Styling Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-brand-appstore',
                'icon_class' => 'icon',
                'title' => esc_html__('Styling', 'phami'),
                'fields' => array(              
                )
            );  
            // Color & Effect Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Color & Effect', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'compile-css',
                        'type' => 'switch',
                        'title' => esc_html__('Compile Css', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),					
                    array(
                      'id' => 'main_theme_color',
                      'type' => 'color',
                      'title' => esc_html__('Main Theme Color', 'phami'),
                      'subtitle' => esc_html__('Select a main color for your site.', 'phami'),
                      'default' => '#222222',
                      'transparent' => false,
					  'required' => array('compile-css','equals',array(true)),
                    ),      
                    array(
                        'id'=>'show-loading-overlay',
                        'type' => 'switch',
                        'title' => esc_html__('Loading Overlay', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Show', 'phami'),
                        'off' => esc_html__('Hide', 'phami'),
                    ),
                    array(
                        'id'=>'banners_effect',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Banner Effect', 'phami'),
                        'options' => $phami_banners_effect,
                        'default' => 'banners-effect-1'
                    )                   
                )
            );
            // Typography Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Typography', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'select-google-charset',
                        'type' => 'switch',
                        'title' => esc_html__('Select Google Font Character Sets', 'phami'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'google-charsets',
                        'type' => 'button_set',
                        'title' => esc_html__('Google Font Character Sets', 'phami'),
                        'multi' => true,
                        'required' => array('select-google-charset','equals',true),
                        'options'=> array(
                            'cyrillic' => 'Cyrrilic',
                            'cyrillic-ext' => 'Cyrrilic Extended',
                            'greek' => 'Greek',
                            'greek-ext' => 'Greek Extended',
                            'khmer' => 'Khmer',
                            'latin' => 'Latin',
                            'latin-ext' => 'Latin Extneded',
                            'vietnamese' => 'Vietnamese'
                        ),
                        'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
                    ),
                    array(
                        'id'=>'family_font_body',
                        'type' => 'typography',
                        'title' => esc_html__('Body Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
						'output'      => array('body'),
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id'=>'h1-font',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' 	=> false,
						'output'      => array('body h1'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'36px',
                            'line-height' => '44px'
                        ),
                    ),
                    array(
                        'id'=>'h2-font',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h2'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'300',
                            'font-family'=>'Open Sans',
                            'font-size'=>'30px',
                            'line-height' => '40px'
                        ),
                    ),
                    array(
                        'id'=>'h3-font',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h3'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'25px',
                            'line-height' => '32px'
                        ),
                    ),
                    array(
                        'id'=>'h4-font',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h4'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'20px',
                            'line-height' => '27px'
                        ),
                    ),
                    array(
                        'id'=>'h5-font',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h5'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'600',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'h6-font',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h6'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'family_font_custom',
                        'type' => 'typography',
                        'title' => esc_html__('Custom Font', 'phami'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                            'id' => 'class_font_custom',
                            'type' => 'text',
                            'title' => esc_html__('Custom Class', 'phami'),
                            'sub_desc' => esc_html__( 'Example : .product_title .', 'phami' ), 
                            'default' => '.product_title'
                    )                   
                )
            );
            //     The end -----------          
            if ( class_exists( 'Woocommerce' ) ) :
                $this->sections[] = array(
                    'icon' => 'icofont icofont-cart-alt',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Ecommerce', 'phami'),
                    'fields' => array(              
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product Archives', 'phami'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'phami'),
                            'options' => $page_layouts,
                            'default' => 'left'
                        ),
                        array(
                            'id'=>'woo-show-rating',
                            'type' => 'switch',
                            'title' => esc_html__('Show Rating in Woocommerce Products Widget', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'category-view-mode',
                            'type' => 'button_set',
                            'title' => esc_html__('View Mode', 'phami'),
                            'options' => phami_ct_category_view_mode(),
                            'default' => 'grid',
                        ),
						array(
                            'id'=>'show-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Category', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id' => 'product_count',
                            'type' => 'text',
                            'title' => esc_html__('Shop pages show at product', 'phami'),
                            'default' => '12',
                            'sub_desc' => esc_html__( 'Type Count Product Per Shop Page', 'phami' ),
                        ),							
                        array(
                            'id' => 'product_col_large',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Desktop', 'phami'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '4',
                            'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'phami' ),
                        ),
                        array(
                            'id' => 'product_col_medium',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Medium Desktop', 'phami'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'phami' ),
                        ),
                        array(
                            'id' => 'product_col_sm',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Ipad Screen', 'phami'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'phami' ),
                        ),						
                        array(
                            'id'=>'category-image-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Hover Effect', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'category-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Hover Effect', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
						array(
							'id'=>'product-compare',
							'type' => 'switch',
							'title' => esc_html__('Show Compare', 'phami'),
							'default' => false,
							'on' => esc_html__('Yes', 'phami'),
							'off' => esc_html__('No', 'phami'),
						),						
                        array(
                            'id'=>'product_quickview',
                            'type' => 'switch',
                            'title' => esc_html__('Show Quick View', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami')
                        ),
                        array(
                            'id'=>'product-quickview-label',
                            'type' => 'text',
                            'required' => array('product-quickview','equals',true),
                            'title' => esc_html__('"Quick View" Text', 'phami'),
                            'default' => ''
                        ),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'phami'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_detail_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'phami'),
                            'options' => $page_layouts,
                            'default' => 'full'
                        ),
                        array(
                            'id'=>'product-stock',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Out of stock" Status', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),						
                        array(
                            'id'=>'product-short-desc',
                            'type' => 'switch',
                            'title' => esc_html__('Show Short Description', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),                  
                        array(
                            'id'=>'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Products', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'product-related-count',
                            'type' => 'text',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Products Count', 'phami'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-related-cols',
                            'type' => 'button_set',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Product Columns', 'phami'),
                            'options' => phami_ct_related_product_columns(),
                            'default' => '4',
                        ),
                        array(
                            'id'=>'product-upsell',
                            'type' => 'switch',
                            'title' => esc_html__('Show Upsell Products', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),                      
                        array(
                            'id'=>'product-upsell-count',
                            'type' => 'text',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Products Count', 'phami'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-upsell-cols',
                            'type' => 'button_set',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Product Columns', 'phami'),
                            'options' => phami_ct_related_product_columns(),
                            'default' => '3',
                        ),
                        array(
                            'id'=>'product-crosssells',
                            'type' => 'switch',
                            'title' => esc_html__('Show Crooss Sells Products', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),                      
                        array(
                            'id'=>'product-crosssells-count',
                            'type' => 'text',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Products Count', 'phami'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-crosssells-cols',
                            'type' => 'button_set',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Product Columns', 'phami'),
                            'options' => phami_ct_related_product_columns(),
                            'default' => '3',
                        ),						
                        array(
                            'id'=>'product-hot',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Hot" Label', 'phami'),
                            'desc' => esc_html__('Will be show in the featured product.', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'product-hot-label',
                            'type' => 'text',
                            'required' => array('product-hot','equals',true),
                            'title' => esc_html__('"Hot" Text', 'phami'),
                            'default' => ''
                        ),
                        array(
                            'id'=>'product-sale',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Sale" Label', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                         array(
                            'id'=>'product-sale-percent',
                            'type' => 'switch',
                            'required' => array('product-sale','equals',true),
                            'title' => esc_html__('Show Sale Price Percentage', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),  
                        array(
                            'id'=>'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Social Share Links', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Image Product', 'phami'),
                    'fields' => array(
                        array(
                            'id'=>'product-thumbs',
                            'type' => 'switch',
                            'title' => esc_html__('Show Thumbnails', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),
                        array(
                            'id'=>'position-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Position Thumbnails', 'phami'),
                            'options' => array('left' => esc_html__('Left', 'phami'),
												'right' => esc_html__('Right', 'phami'),
												'bottom' => esc_html__('Bottom', 'phami'),
												'outsite' => esc_html__('Outsite', 'phami')),
                            'default' => 'bottom',
							'required' => array('product-thumbs','equals',true),
                        ),						
                        array(
                            'id' => 'product-thumbs-count',
                            'type' => 'button_set',
                            'title' => esc_html__('Thumbnails Count', 'phami'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4', 
									'5' => '5', 									
                                    '6' => '6'                          
                                ),
							'default' => '4',
							'required' => array('product-thumbs','equals',true),
                        ),
                        array(
                            'id'=>'product-image-popup',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Popup', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
                        ),						
                        array(
                            'id'=>'layout-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Layouts Thumbnails', 'phami'),
                            'options' => array('zoom' => esc_html__('Zoom', 'phami'),
												'scroll' => esc_html__('Scroll', 'phami'),
												'list' => esc_html__('List', 'phami'),
												'list2' => esc_html__('List 2', 'phami'),
											),	
                            'default' => 'zoom',
                        ),
                        array(
                            'id'=>'zoom-type',
                            'type' => 'button_set',
                            'title' => esc_html__('Zoom Type', 'phami'),
                            'options' => array('inner' => esc_html__('Inner', 'phami'), 'lens' => esc_html__('Lens', 'phami')),
                            'default' => 'inner',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-scroll',
                            'type' => 'switch',
                            'title' => esc_html__('Scroll Zoom', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border',
                            'type' => 'text',
                            'title' => esc_html__('Border Size', 'phami'),
                            'default' => '2',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Border Color', 'phami'),
                            'default' => '#f9b61e',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),                      
                        array(
                            'id'=>'zoom-lens-size',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Size', 'phami'),
                            'default' => '200',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-shape',
                            'type' => 'button_set',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Shape', 'phami'),
                            'options' => array('round' => esc_html__('Round', 'phami'), 'square' => esc_html__('Square', 'phami')),
                            'default' => 'square',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-contain-lens',
                            'type' => 'switch',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Contain Lens Zoom', 'phami'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'phami'),
                            'off' => esc_html__('No', 'phami'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-border',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Border', 'phami'),
                            'default' => true,
							'required' => array('layout-thumbs','equals',"zoom")
                        ),
                    )
                );
            endif;
            // Blog Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-ui-copy',
                'icon_class' => 'icon',
                'title' => esc_html__('Blog', 'phami'),
                'fields' => array(              
                )
            );      
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'post-format',
                        'type' => 'switch',
                        'title' => esc_html__('Show Post Format', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'hot-label',
                        'type' => 'text',
                        'title' => esc_html__('"HOT" Text', 'phami'),
                        'desc' => esc_html__('Hot post label', 'phami'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'sidebar_blog',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'phami'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id' => 'layout_blog',
                        'type' => 'button_set',
                        'title' => esc_html__('Layout Blog', 'phami'),
                        'options' => array(
                                'list'  =>  esc_html__( 'List', 'phami' ),
                                'grid' =>  esc_html__( 'Grid', 'phami' ),
								'masonry' =>  esc_html__( 'Masonry', 'phami' )	
                        ),
                        'default' => 'list',
                        'sub_desc' => esc_html__( 'Select style layout blog', 'phami' ),
                    ),
                    array(
                        'id' => 'blog_col_large',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Desktop', 'phami'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '4',
                        'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'phami' ),
                    ),
                    array(
                        'id' => 'blog_col_medium',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Medium Desktop', 'phami'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'phami' ),
                    ),   
                    array(
                        'id' => 'blog_col_sm',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Ipad Screen', 'phami'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'phami' ),
                    ),   					
                    array(
                        'id'=>'archives-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'archives-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Count Comments', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),                  
                    array(
                        'id'=>'blog-excerpt',
                        'type' => 'switch',
                        'title' => esc_html__('Show Excerpt', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'list-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('List Excerpt Length', 'phami'),
                        'desc' => esc_html__('The number of words', 'phami'),
                        'default' => '50',
                    ),
                    array(
                        'id'=>'grid-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('Grid Excerpt Length', 'phami'),
                        'desc' => esc_html__('The number of words', 'phami'),
                        'default' => '12',
                    ),                  
                )
            );
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Single Post', 'phami'),
                'fields' => array(
                    array(
                        'id'=>'post-single-layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'phami'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id'=>'post-title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'post-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author Info', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
                    ),
                    array(
                        'id'=>'post-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Comments', 'phami'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'phami'),
                        'off' => esc_html__('No', 'phami'),
					)
				)
			);	
            $this->sections[] = array(
				'id' => 'wbc_importer_section',
				'title'  => esc_html__( 'Demo Importer', 'phami' ),
				'icon'   => 'fa fa-cloud-download',
				'desc'   => wp_kses( 'Increase your max execution time, try 40000 I know its high but trust me.<br>
				Increase your PHP memory limit, try 512MB.<br>
				1. The import process will work best on a clean install. You can use a plugin such as WordPress Reset to clear your data for you.<br>
				2. Ensure all plugins are installed beforehand, e.g. WooCommerce - any plugins that you add content to.<br>
				3. Be patient and wait for the import process to complete. It can take up to 3-5 minutes.<br>
				4. Enjoy','social' ),				
				'fields' => array(
					array(
						'id'   => 'wbc_demo_importer',
						'type' => 'wbc_importer'
					)
				)
            );			
        }
        public function setHelpTabs() {
        }
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                'opt_name'          => 'phami_settings',
                'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'phami'),
                'display_version'   => esc_html__('Theme Version: ', 'phami') . phami_version,
                'menu_type'         => 'submenu',
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__('Theme Options', 'phami'),
                'page_title'        => esc_html__('Theme Options', 'phami'),
                'footer_credit'     => esc_html__('Theme Options', 'phami'),
                'google_api_key' => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII',
                'disable_google_fonts_link' => true,
                'async_typography'  => false,
                'admin_bar'         => false,
                'admin_bar_icon'       => 'dashicons-admin-generic',
                'admin_bar_priority'   => 50,
                'global_variable'   => '',
                'dev_mode'          => false,
                'customizer'        => false,
                'compiler'          => false,
                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'menu_icon'         => '',
                'last_tab'          => '',
                'page_icon'         => 'icon-themes',
                'page_slug'         => 'phami_settings',
                'save_defaults'     => true,
                'default_show'      => false,
                'default_mark'      => '',
                'show_import_export' => true,
                'show_options_object' => false,
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => false,
                'output_tag'        => false,
                'database'              => '',
                'system_info'           => false,
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                ),
                'ajax_save'                 => false,
                'use_cdn'                   => true,
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }
            $this->args['intro_text'] = sprintf('<p style="color: #0088cc">'.wp_kses('Please regenerate again default css files in <strong>Skin > Compile Default CSS</strong> after <strong>update theme</strong>.', 'phami').'</p>', $v);
        }           
    }
	if ( !function_exists( 'wbc_extended_example' ) ) {
		function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );
			$current_key = key( $demo_active_import );	
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] )) {
				//Import Sliders
				if ( class_exists( 'RevSlider' ) ) {
					$wbc_sliders_array = array(
						'phami' => array('slider-1.zip','slider-2.zip','slider-3.zip','slider-4.zip','slider-5.zip','slider-6.zip','slider-7.zip','slider-8.zip')
					);
					$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
					if( is_array( $wbc_slider_import ) ){
						foreach ($wbc_slider_import as $slider_zip) {
							if ( !empty($slider_zip) && file_exists( $demo_directory_path.'rev_slider/'.$slider_zip ) ) {
								$slider = new RevSlider();
								$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$slider_zip );
							}
						}
					}else{
						if ( file_exists( $demo_directory_path.'rev_slider/'.$wbc_slider_import ) ) {
							$slider = new RevSlider();
							$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$wbc_slider_import );
						}
					}
				}				
				// Setting Menus
				$primary = get_term_by( 'name', 'Main menu', 'nav_menu' );
				$primary_vertical = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
				$primary_currency = get_term_by( 'name', 'Currency Menu', 'nav_menu' );
				$primary_language = get_term_by( 'name', 'Language Menu', 'nav_menu' );
				if ( isset( $primary->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
							'main_navigation' => $primary->term_id,
							'vertical_menu' => $primary_vertical->term_id,
							'currency_menu' => $primary_currency->term_id,
							'language_menu' => $primary_language->term_id	
						)
					);
				}
				// Set HomePage
				$home_page = 'Home 1';	
				$page = get_page_by_title( $home_page );
				if ( isset( $page->ID ) ) {
					update_option( 'page_on_front', $page->ID );
					update_option( 'show_on_front', 'page' );
				}					
			}
		}
		// Uncomment the below
		add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
	}
    global $reduxPhamiSettings;
    $reduxPhamiSettings = new Redux_Framework_phami_settings();
}