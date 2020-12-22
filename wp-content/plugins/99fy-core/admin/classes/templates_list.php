<div class="httemplates-templates-area">
    <div class="httemplate-row">

        <!-- PopUp Content Start -->
        <div id="httemplate-popup-area" style="display: none;">
            <div class="httemplate-popupcontent">
                <div class='htspinner'></div>
                <div class="htmessage" style="display: none;">
                    <p></p>
                    <span class="httemplate-edit"></span>
                </div>
                <div class="htpopupcontent">
                    <p><?php esc_html_e( 'Import template to your Library', '99fy' );?></p>
                    <span class="htimport-button-dynamic"></span>
                    <div class="htpageimportarea">
                        <p> <?php esc_html_e( 'Create a new page from this template', '99fy' ); ?></p>
                        <input id="htpagetitle" type="text" name="htpagetitle" placeholder="<?php echo esc_attr_x( 'Enter a Page Name', 'placeholder', '99fy' ); ?>">
                        <span class="htimport-button-dynamic-page"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top banner area Start -->
        <div class="httemplate-top-banner-area">
            <div class="htbanner-content">
                <div class="htbanner-desc">
                    <h3><?php esc_html_e( '99Fy Templates Library', '99fy' ); ?></h3>
                    <?php
                        $alltemplates = sizeof( NNFy_Template_Library::instance()->get_templates_info()['templates'] ) ? sizeof( NNFy_Template_Library::instance()->get_templates_info()['templates'] ) : 0;
                    ?>
                    <p><?php esc_html_e( $alltemplates, '99fy' ); esc_html_e( ' Templates', '99fy' ); ?></p>
                </div>
                <?php 
                    if( !is_plugin_active('99fy-pro/nnfy_pro.php') ){
                        echo '<a href="'.esc_url( NNFy_Template_Library::instance()->get_pro_link() ).'" target="_blank">'.esc_html__( 'Buy 99Fy Pro Version', '99fy' ).'</a>';
                    }
                ?>
            </div>
        </div>
        <!-- Top banner area end -->

        <?php if( NNFy_Template_Library::instance()->get_templates_info()['templates'] ): ?>
            
            <div class="htmega-topbar">
                <span id="htmegaclose">&larr; <?php esc_html_e( 'Back to Library', '99fy' ); ?></span>
                <h3 id="htmega-tmp-name"></h3>
            </div>

            <ul id="tp-grid" class="tp-grid">

                <?php foreach ( NNFy_Template_Library::instance()->get_templates_info()['templates'] as $httemplate ): 
                    
                    $allcat = explode( ' ', $httemplate['category'] );

                    $htimp_btn_atr = [
                        'templpateid' => $httemplate['id'],
                        'templpattitle' => $httemplate['title'],
                        'message' => esc_html__( 'Successfully '.$httemplate['title'].' has been imported.', '99fy' ),
                        'htbtnlibrary' => esc_html__( 'Import to Library', '99fy' ),
                        'htbtnpage' => esc_html__( 'Import to Page', '99fy' ),
                        'thumbnail' => esc_url( $httemplate['thumbnail'] ),
                        'fullimage' => esc_url( $httemplate['fullimage'] ),
                    ];

                ?>

                    <li data-pile="<?php echo esc_attr( implode( ' ', $allcat ) ); ?>">

                        <!-- Preview PopUp Start -->
                        <div id="httemplate-popup-prev-<?php echo $httemplate['id']; ?>" style="display: none;">
                            <img src="<?php echo esc_url( $httemplate['fullimage'] ); ?>" alt="<?php $httemplate['title']; ?>" style="width:100%;"/>
                        </div>
                        <!-- Preview PopUp End -->

                        <div class="htsingle-templates-laibrary">
                            <div class="httemplate-thumbnails">
                                <img data-preview='<?php echo wp_json_encode( $htimp_btn_atr );?>' src="<?php echo esc_url( $httemplate['thumbnail'] ); ?>" alt="<?php echo esc_attr( $httemplate['title'] ); ?>">
                                <div class="httemplate-action">
                                    <?php if( $httemplate['is_pro'] == 1 ): ?>
                                        <a href="<?php echo esc_url( NNFy_Template_Library::instance()->get_pro_link() ); ?>" target="_blank"><?php esc_html_e( 'Buy Now', '99fy' ); ?></a>
                                    <?php else:?>
                                        <a style="<?php if( empty( $httemplate['demourl'] ) ){ echo 'flex: 0 0 100%;'; } ?>" href="#" class="nnfytemplateimp" data-templpateopt='<?php echo wp_json_encode( $htimp_btn_atr );?>' >
                                            <?php esc_html_e( 'Import', '99fy' ); ?>
                                        </a>
                                    <?php endif; if( !empty( $httemplate['demourl'] ) ): ?>
                                        <a href="<?php echo esc_url( $httemplate['demourl'] ); ?>" target="_blank"><?php esc_html_e( 'Preview', '99fy' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="httemplate-content">
                                <h3><?php echo esc_html__( $httemplate['title'], '99fy' ); if( $httemplate['is_pro'] == 1 ){ echo ' <span>( '.esc_html__('Pro','99fy').' )</span>'; } ?></h3>
                                <div class="httemplate-tags">
                                    <?php echo implode( ' / ', explode( ',', $httemplate['tags'] ) ); ?>
                                </div>
                            </div>
                        </div>

                    </li>

                <?php endforeach; ?>

            </ul>

            <script type="text/javascript">
                jQuery(document).ready(function($) {

                    $(function() {
                        var $grid = $( '#tp-grid' ),
                            $name = $( '#htmega-tmp-name' ),
                            $close = $( '#htmegaclose' ),
                            $loaderimg = '<?php echo NNFY_ADMIN_ASSETS . '/images/ajax-loader.gif'; ?>',
                            $loader = $( '<div class="htmega-loader"><span><img src="'+$loaderimg+'" alt="" /></span></div>' ).insertBefore( $grid ),
                            stapel = $grid.stapel( {
                                onLoad : function() {
                                    $loader.remove();
                                },
                                onBeforeOpen : function( pileName ) {
                                    $( '.htmega-topbar,.httemplate-action' ).css('display','flex');
                                    $( '.httemplate-content span' ).css('display','inline-block');
                                    $close.show();
                                    $name.html( pileName );
                                },
                                onAfterOpen : function( pileName ) {
                                    $close.show();
                                }
                            } );
                        $close.on( 'click', function() {
                            $close.hide();
                            $name.empty();
                            $( '.htmega-topbar,.httemplate-action,.httemplate-content span' ).css('display','none');
                            stapel.closePile();
                        } );
                    } );

                });
            </script>
        <?php endif; ?>

    </div>
</div>