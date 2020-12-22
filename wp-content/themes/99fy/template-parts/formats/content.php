<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package 99fy
 */
$meta_status    = get_option( 'nnfy_blog_title_meta_status', false );
$readmore       = get_option( 'nnfy_blog_read_more_txt', 'Read More' );
$blog_col_size  = get_option( 'nnfy_blog_col_size', 3 );

for($i = 1; $i <= $blog_col_size; $i++){

    switch ($blog_col_size) {
        case '1':
            $col_class = 'ht-col-xs-12 ht-col-lg-12';
            $nnfybl_image_size = 'full';
            break;

        case '2':
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-6';
            $nnfybl_image_size = 'nnfy_blog_grid_thumb';
            break;

        case '4':
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-3';
            $nnfybl_image_size = 'nnfy_blog_grid_thumb';
            break;
        
        default:
            $col_class = 'ht-col-xs-12 ht-col-sm-6 ht-col-lg-4';
            $nnfybl_image_size = 'nnfy_blog_grid_thumb';
            break;
    }
 }
?>


<div class="<?php echo esc_attr($col_class); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	    <div class="product-wrapper mb-30">
	    	<?php if(has_post_thumbnail()): ?>
	        <div class="blog-img">
	            <a href="<?php the_permalink( ); ?>">
	                <?php the_post_thumbnail( $nnfybl_image_size ); ?>
	            </a>
	        </div>
	    	<?php endif; ?>

	        <div class="blog-info">
	            <h4><a href="<?php the_permalink( ); ?>"><?php nnfy_post_title(); ?></a></h4>
                <?php if( $meta_status != true ): ?>
    	            <h6><?php echo esc_html__( 'By ', '99fy' ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author_meta('nickname') ?></a> <?php echo esc_html__( 'on', '99fy' ); ?> <span><?php echo get_the_date(  get_option( 'date_format' ) ); ?></span></h6>
                <?php endif; ?>

	            <p><?php nnfy_post_excerpt(); ?></p>
                <?php
                    if( !empty( $readmore ) ){
                        echo '<a href="'.esc_url( get_the_permalink() ).'" class="read_more">'.esc_html( $readmore ).'</a>';
                    }
                ?>
	        </div>
	    </div>
	</article>
</div>
