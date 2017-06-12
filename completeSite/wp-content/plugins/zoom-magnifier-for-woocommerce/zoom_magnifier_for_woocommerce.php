<?php
/**
* Plugin Name: Zoom Magnifier For WooCommerce

* Plugin URI: http://www.phoeniixx.com/

* Description: As the name suggests, Zoom Magnifier Plugin lets your customers zoom a product’s image so that they could view it with greater clarity and detail.

* Version: 1.3.3

* Text Domain: pwlp

* Domain Path: /i18n/languages/

* Author: phoeniixx

* Author URI: http://www.phoeniixx.com/

* License: GPL2
*/ 

if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    // Put your plugin code here
	
	require_once(ABSPATH . 'wp-settings.php');

	require_once('pzmp_settings.php');
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	add_action('admin_menu', 'pzmp_wishlist_tab');

		function pzmp_wishlist_tab(){
			
			$page_title="Zoom Magnifier";
			
			$menu_title="Zoom Magnifier";
			
			$capability="manage_options";
			
			$menu_slug="pzmp-zoom-manager";
			
			$plugin_dir_url =  plugin_dir_url( __FILE__ );
			
			add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'assets/image/logo-wp.png', 57 );
			
			add_submenu_page( 'phoeniixx', $page_title, $menu_title, $capability, $menu_slug ,'pzmp_settings');

		}
	
		$pzmp_genral_dataa=get_option('data_zoom_genral');
		
		if(!empty($pzmp_genral_dataa)){
			extract($pzmp_genral_dataa);
		}
	
	
		function pzmp_assets_file() {

			wp_enqueue_style( 'pzmp-magnifier-css', plugin_dir_url( __FILE__ ).'assets/css/pzmp_magnifier.css' );
			
			wp_enqueue_style( 'pzmp-magnifier-css2', plugin_dir_url( __FILE__ ).'assets/css/pzmp_frontend.css' );
	
			wp_enqueue_script( 'zoom-mag-jquery', plugin_dir_url( __FILE__ ) . 'assets/js/pzmp_jquery.carouFredSel.js', array( 'jquery' ) );	
			
			wp_enqueue_script( 'zoom-mag-jquery2', plugin_dir_url( __FILE__ ) . 'assets/js/pzmp_frontend.js', array( 'jquery' ) );	
			
			wp_enqueue_script( 'zoom-mag-jquery3', plugin_dir_url( __FILE__ ) . 'assets/js/pzmp_magnifier.js', array( 'jquery' ) );	
			
			$pzmp_genral_da=get_option('data_zoom_genral');
		
				if(!empty($pzmp_genral_da)){
					extract($pzmp_genral_da);
				}
			?>
			<script type="text/javascript" charset="utf-8">
				var box_width="<?php if(isset($box_width)){ echo ($box_width!='')?$box_width:'auto';}else{ echo "auto";}?>";
				var box_height="<?php if(isset($box_height)){ echo ($box_height!='')?$box_height:'auto';}else{ echo "auto";}?>";
				var box_pos="<?php if(isset($box_pos)){ echo ($box_pos!='')?$box_pos:'right';}else{ echo "right";} ?>";
			
				var pzmppp_magnifier_options = {
						
					};
				</script>
			<?php 
			
		}
		
		if($pzmp_is_enable==1){
			
			remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
		
			remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
			
			add_action('woocommerce_before_single_product_summary', 'pzmp_show_product_images', 20);
			
			add_action('woocommerce_product_thumbnails', 'pzmp_show_product_thumbnails', 20);
			
			add_action('wp_head', 'pzmp_assets_file');
			
			add_filter('woocommerce_available_variation', 'pzmp_available_variation', 10, 3);
		}
		
		function pzmp_available_variation($data, $wc_prod, $variation) {

            $attachment_id = get_post_thumbnail_id($variation->get_variation_id());
            $attachment = wp_get_attachment_image_src($attachment_id, 'shop_magnifier');

            $data['image_magnifier'] = $attachment ? current($attachment) : '';

            return $data;
        }
		   
		function pzmp_show_product_images() {

				if ( ! defined( 'ABSPATH' ) ) {
					exit;
				} // Exit if accessed directly

				global $post, $woocommerce, $product, $is_IE;

				$placeholder   = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : woocommerce_placeholder_img_src();

				?>
				<div class="images<?php if ( $is_IE ): ?> ie<?php endif ?>">

					<?php
					if ( has_post_thumbnail() ) {

						$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
						list( $magnifier_url, $magnifier_width, $magnifier_height ) = wp_get_attachment_image_src( get_post_thumbnail_id(), "shop_magnifier" );

						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="pzmp_magnifier_zoom woocommerce-main-image" title="%s">%s</a>', $magnifier_url, $image_title, $image ), $post->ID );

					} else {
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="pzmp_magnifier_zoom woocommerce-main-image"><img src="%s" alt="Placeholder" /></a>', $placeholder, $placeholder ), $post->ID );
					}
					?>

					<?php do_action( 'woocommerce_product_thumbnails' ); ?>

				</div>
				

				<?php 			
        } 
		
		
		
		
		function pzmp_show_product_thumbnails() {
			
					if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

					global $post, $product, $woocommerce;

					$enable_slider = true;

					$attachment_ids = $product->get_gallery_attachment_ids();

					if ( ! empty( $attachment_ids ) ) array_unshift( $attachment_ids, get_post_thumbnail_id() );

					//  make sure attachments ids are unique
					$attachment_ids = array_unique($attachment_ids);

					if ( $attachment_ids ) {
						?>
						<div class="thumbnails columns-3">
							<ul class="pzmp_magnifier_gallery">
							<?php
							$loop = 0;
							
							$columns = 3;
							
							if( !isset( $columns ) || $columns == null ) $columns = 3;

							foreach ( $attachment_ids as $attachment_id ) {
								$classes = array( 'pzmp_magnifier_thumbnail' );

								if ( $loop == 0 || $loop % $columns == 0 ) {
									$classes[] = 'first';
								}

								if ( ( $loop + 1 ) % $columns == 0 ) {
									$classes[] = 'last';
								}

								$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
								$image_class = esc_attr( implode( ' ', $classes ) );
								$image_title = esc_attr( get_the_title( $attachment_id ) );
								

								list( $thumbnail_url, $thumbnail_width, $thumbnail_height ) = wp_get_attachment_image_src( $attachment_id, "shop_single" );
								list( $magnifier_url, $magnifier_width, $magnifier_height ) = wp_get_attachment_image_src( $attachment_id, "shop_magnifier" );

								echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="%s"><a href="%s"  class="%s" title="%s" data-small="%s">%s</a></li>', $image_class, $magnifier_url, $image_class, $image_title, $thumbnail_url, $image ), $attachment_id, $post->ID, $image_class );

								$loop++;
							}
							?>
							</ul>

						</div>
					<?php
					}

        }
		
	
	function pzmp_activate() {

		$pzmp_genral_=get_option('data_zoom_genral');
		
			if((!isset($pzmp_genral_)||empty($pzmp_genral_))){
				
				$pzmp_genral_data_default=array('pzmp_is_enable'=>1);
		
				update_option('data_zoom_genral',$pzmp_genral_data_default);
			} 
	}

	register_activation_hook( __FILE__, 'pzmp_activate' );
	
	add_action('admin_head','pzmp_add_admin_assests');

		function pzmp_add_admin_assests(){
				
				wp_enqueue_style( 'pzmp-custom-css', plugin_dir_url( __FILE__ ).'assets/css/pzmp_custom_css.css' );
				
				wp_enqueue_script("pzmp-custom-js", plugin_dir_url( __FILE__ )."assets/js/pzmp_custom.js",array('jquery'),'',true);
				
			}

	
}
else
{ 
	?>
		<div class="error notice is-dismissible " id="message"><p>Please <strong>Activate</strong> WooCommerce Plugin First, to use it.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
	<?php 
}  
?>