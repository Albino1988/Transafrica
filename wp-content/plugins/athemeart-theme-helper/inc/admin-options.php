<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class aThemeArt_Admin_Options {
	static $_instance;
	public $title;
	public $config;
	public $current_tab = '';
	public $url = ''; // current page url
	public $pro;
	static function get_instance() {
		
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
            self::$_instance->url = admin_url( 'admin.php' );
	        self::$_instance->url = add_query_arg( array( 'page' => 'athemeart-admin-options' ), self::$_instance->url );

            self::$_instance->title = apply_filters( 'ata_admin_options_text', esc_html__( 'aThemeArt Options', 'athemeart-theme-helper' ));
            add_action( 'admin_menu', array( self::$_instance, 'add_menu' ), 5 );
			self::$_instance->pro = esc_url( apply_filters( 'ata_admin_options_pro_link', 'https://athemeart.com/downloads/category/wordpress/') );
			
				add_filter( 'cs_shortcode_options', '__return_false' );
				add_filter( 'cs_customize_options', '__return_false' );
				add_filter( 'cs_metabox_options', '__return_false' );
				add_filter( 'cs_framework_settings', '__return_false' );
				add_filter( 'cs_framework_options', '__return_false' );
				add_filter('cs_shortcode_options', '__return_false');
            

        }
        return self::$_instance;
    }
	
	public function add_menu(){
        add_theme_page(
            $this->title,
            $this->title,
            'manage_options',
            'athemeart-admin-options',
            array( $this, 'page' )
        );
    }
	
	public function add_url_args( $args = array() ){
		return add_query_arg( $args, self::$_instance->url );
	}
	
	
	
	
	public function page(){
     	echo $this->header_setup();
        echo '<div class="wrap athemeart-admin-wrap">';
		
		$cd_box = $this->info_array();
		
		if( !empty( $cd_box ) && is_array( $cd_box ) ): 
		echo '<div class="cd-row">';
			foreach (  $cd_box as $key => $data ):
			
      	?>
        <div class="cd-md-3">
        <div class="cd-box box-plugins">
        <div class="cd-box-top"><?php echo esc_html( $data['title'] );?></div>
        <?php if( $data['title'] != "" ){ ?>
        <div class="cd-sites-thumb"> <img src="<?php echo esc_url( $data['image'] );?>"> </div>
        <?php } ?>
        <div class="cd-box-content">
        <p><?php echo esc_html( $data['text'] );?></p>
         <?php if( $data['btn_text'] != ""  && $data['btn_url'] != ""){ ?>
        <p> <a href="<?php echo esc_url( $data['btn_url'] );?>" class="button action-btn view-site-library"> <?php echo esc_html( $data['btn_text'] );?> </a> </p>
        <?php }?>
        </div>
        </div>
        </div>
        <?php 
		endforeach;
		echo '</div>';
		endif;
		echo '<div class="cd-row">';
			$pro_features = $this->info_pro_features();
		if( !empty( $pro_features ) && is_array( $pro_features ) ): 
		foreach (  $pro_features as  $data ):
		?>
        <div class="cd-box cd-md-6">
          <div class="cd-box-top"> <?php echo apply_filters( 'ata_admin_options_themme', esc_html__( 'aThemeArt Pro Feature', 'athemeart-theme-helper' ));?><a class="cd-upgrade" target="_blank" href="<?php echo esc_url(  $this->pro );?>"><?php echo esc_html__( 'Upgrade Now →', 'athemeart-theme-helper' );?></a></div>
          <div class="cd-box-content cd-modules">
          
          
          </div>
        </div>
        <?php
		endforeach;
		endif; 
		?>
        
        <div class="cd-box cd-md-30">
          <div class="cd-box-top"> <?php echo esc_html__( 'Changelog', 'athemeart-theme-helper' );?></div>
           
            <code class="cd-box-content cd-modules">
          <?php
		  global $wp_filesystem;
		  $changelog_file = apply_filters( 'athemeart_changelog_file', get_template_directory() . '/readme.txt' );
		  	if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
		  ?>
          </code>
         
        </div>
        <?php
		echo '</div>';
        echo '</div>';
    }
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}
	public function info_pro_features(){
		$array = array(
		  esc_html__( 'Theme Customizer', 'athemeart-theme-helper' ),
		);
	return $array;
	}
	public function info_array(){
		$array = array(
			'customize' =>  array(
				'title' =>  esc_html__( 'Theme Customizer', 'athemeart-theme-helper' ),
				'image' =>  '',
				'text' =>  esc_html__( 'All Theme Options are available via Customize screen.', 'athemeart-theme-helper' ),
				'btn_text' =>   esc_html__( 'Customize', 'athemeart-theme-helper' ),
				
				'btn_url' =>  esc_url( apply_filters( 'ata_admin_options_demo_link', admin_url( 'customize.php' ) ) ),
			),
			'demo' =>  array(
				'title' =>  esc_html__( 'aThemeArt ready to import sites', 'athemeart-theme-helper' ),
				'image' =>  'http://localhost/resume-vcard/wp-content/plugins/futurio-extra/lib/admin/img/futurio-sites.png',
				'text' =>  esc_html__( 'Import your favorite site with one click and start your project in style!', 'athemeart-theme-helper' ),
				'btn_text' =>   esc_html__( 'See Library', 'athemeart-theme-helper' ),
				
				'btn_url' =>  esc_url( apply_filters( 'ata_admin_options_demo_link', admin_url( 'themes.php?page=pt-one-click-demo-import') ) ),
				
			),
			'plugins' =>  array(
				'title' =>  esc_html__( 'Recommend Plugins', 'athemeart-theme-helper' ),
				'image' =>  '',
				'text' =>  esc_html__( 'To take full advantage of all the features this theme has to offer number of plugins, please install and activate all plugins', 'athemeart-theme-helper' ),
				'btn_text' =>   esc_html__( 'Begin installing plugins', 'athemeart-theme-helper' ),
				
				'btn_url' => esc_url(  apply_filters( 'ata_admin_options_install_link', admin_url( 'themes.php?page=tgmpa-install-plugins') ) ),
				
			),
			'knowledge' =>  array(
				'title' =>  esc_html__( 'Knowledge Base', 'athemeart-theme-helper' ),
				'image' =>  '',
				'text' =>  esc_html__( 'Not sure how something works? Take a peek at the knowledge base and learn.', 'athemeart-theme-helper' ),
				'btn_text' =>   esc_html__( 'Visit Knowledge Base', 'athemeart-theme-helper' ),
				
				'btn_url' => esc_url( apply_filters( 'ata_admin_options_knowledge_link', 'https://athemeart.com/') ),
				'target' => esc_attr( '_blank' )
				
			),
			'pro' =>  array(
				'title' =>  esc_html__( 'Need more features?', 'athemeart-theme-helper' ),
				'image' =>  '',
				'text' =>  esc_html__( 'Get the Pro version for more stunning elements, demos and Theme options. Now with 25% discount for lifetime plan.' ),
				'btn_text' =>   esc_html__( 'Upgrade to PRO Version', 'athemeart-theme-helper' ),
				
				'btn_url' => esc_url(  $this->pro ),
				'target' => esc_attr( '_blank' )
				
			),
			
			
			
		);
		
		
		
		return apply_filters( 'ata_admin_options_cd_box',$array );
	}
	
	public function header_setup(){
		?>
        <div class="cd-header">
            <div class="cd-row">
                <div class="cd-header-inner">
                    <a href="https://futuriowp.com" target="_blank" class="cd-branding">
                        <img src="http://localhost/resume-vcard/wp-content/themes/futurio/img/futurio-logo.png" alt="logo">
                    </a>
                    
                    <a class="cd-upgrade" target="_blank" href="<?php echo esc_url(  $this->pro );?>"><?php echo esc_html__( 'Upgrade Now →', 'athemeart-theme-helper' );?></a>
                </div>
            </div>
        </div>
        <?php	
		}

}
aThemeArt_Admin_Options::get_instance();





