<?php

function pxs_add_banner() {

  if (is_shop()) {
  // get reusable gutenberg block for CTA
        $reuse_block = get_post( 1407 ); 
        $reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
        echo $reuse_block_content;
    
  }

}

add_action('flatsome_after_header','pxs_add_banner', 10);

//wp_enqueue_script( 'jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, null, true );
//wp_enqueue_script( 'bundle', get_stylesheet_directory_uri() . '/public/bundle.js', array(jQuery) );

/**
 * 
 * product single
 * remove the data tabs  
 * 
 */
remove_action ('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

/**
 * product single 
 * re add the tabs into woocommerce_single_product_summary hook 
 * 
 */

add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 70);

/**
 * 
 * add mission slim banner after main content on single product page 
 * 
 */

function pxs_add_slim_mission() {
  if ( is_single() ) { 
  $image = get_field( 'before_footer_image', 'option' );  
  $text = get_field( 'before_footer_text', 'option' );   
  $logo = get_field( 'before_footer_logo', 'option' ); 
  $url = get_field( 'before_footer_url', 'option' ); 
?>
  <div class="mission-slim">
      <div class="mission-slim__inner">
        <div class="mission-slim__image"><img src="<?php echo $image; ?>" alt=""></div>
        <div class="mission-slim__content">
          <div class="mission-slim__text">
            <h5><?php echo $text; ?></h5>
          </div>
          <div class="mission-slim__logo"><a href="<?php echo $url; ?>"><img src="<?php echo $logo; ?>" alt=""/></a></div>
        </div>
      </div>
  </div>
  <?php
  }
}
add_action('woocommerce_after_main_content','pxs_add_slim_mission', 20);

add_filter( 'woocommerce_product_tabs', 'pxs_rename_product_tabs', 98 );
function pxs_rename_product_tabs( $tabs ) {
	$tabs['description']['title'] = __( 'Features and Specifications' );
	return $tabs;
}

add_filter( 'woocommerce_output_related_products_args', 'pxs_related_products_args', 20 );
function pxs_related_products_args( $args ) {
	$args['posts_per_page'] = 4;
	return $args;
}

/**
 * 
 *  add acf options pages
 * 
 */

if( function_exists('acf_add_options_page') ) {
	
  //parent page

	acf_add_options_page(array(
		'page_title' 	=> 'General Settings',
		'menu_title'	=> 'General Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	
  //sub page
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Contact Details',
		'menu_title'	=> 'Contact Details',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}

/**
 *  
 * add btn to product 
 * 
 */

add_action('flatsome_product_box_after','pxs_add_btn_to_product', 20);

function pxs_add_btn_to_product() { ?>
  <a class="featured-products__button" href="<?php the_permalink(); ?>">Buy Now</a>
<?php }

/**
 * 
 * add logo to footer 
 * 
 */
add_action('flatsome_absolute_footer_secondary','pxs_add_logo', 10);

function pxs_add_logo() { ?>
<?php $footer_logo = get_field( 'footer_logo', 'option' ); ?>
<?php if ( $footer_logo ) : ?>
<div class="footer__logo">
	<img src="<?php echo esc_url( $footer_logo['url'] ); ?>" alt="<?php echo esc_attr( $footer_logo['alt'] ); ?>" />
</div>
<?php endif;
}

/**
 * 
 * add contact text widget to footer 
 * 
 */

add_action('flatsome_absolute_footer_secondary','pxs_add_footer_text', 9);

function pxs_add_footer_text() { ?>
<div class="footer__first-col">

<div class="footer__wrapper footer__wrapper--top">
  <div class="footer__email">
    <?php $email_address = get_field( 'email_address', 'option' ); ?>
    <?php if ( $email_address ) : ?>
      <a href="<?php echo esc_url( $email_address['url'] ); ?>" target="<?php echo esc_attr( $email_address['target'] ); ?>"><?php echo esc_html( $email_address['title'] ); ?></a>
    <?php endif; ?>
  </div>
  <div class="footer__phone">
    <?php $phone_link = get_field( 'phone_link', 'option' ); ?>
    <?php if ( $phone_link ) : ?>
      <a href="<?php echo esc_url( $phone_link['url'] ); ?>" target="<?php echo esc_attr( $phone_link['target'] ); ?>"><?php echo esc_html( $phone_link['title'] ); ?></a>
    <?php endif; ?>
  </div>

</div>
<div class="footer__wrapper footer__wrapper--bottom">
  <div class="footer__copyright">
    <?php the_field( 'copyright', 'option' ); ?>
  </div>
</div>
</div>
<?php 
} 

add_filter('acf/settings/save_json', 'pxs_acf_json_save_point');
function pxs_acf_json_save_point( $path ) {
  $path = get_stylesheet_directory() . '/acf-json';
  return $path;
}

add_filter('acf/settings/load_json', 'pxs_acf_json_load_point');
function pxs_acf_json_load_point( $paths ) {
  unset($paths[0]);
  $paths[] = get_stylesheet_directory() . '/acf-json';
  return $paths;
}

/**
 * style messages 
 * custom add to cart message
 */

add_filter( 'wc_add_to_cart_message', 'custom_add_to_cart_message' );
function custom_add_to_cart_message() {
	global $woocommerce;

	// Output success messages
	if (get_option('woocommerce_cart_redirect_after_add')=='yes') :

		$return_to 	= get_permalink(woocommerce_get_page_id('shop'));

		$message 	= sprintf('<a href="%s" class="button">%s</a> %s', $return_to, __('Continue Shopping &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );

	else :

    $message 	= sprintf('<a href="%s" class="button special">%s</a> %s', 
    get_permalink(woocommerce_get_page_id('cart')), __('View Cart &rarr;', 'woocommerce'), __('<p class = "message-text">Product successfully added to your cart.</p>', 'woocommerce') );

	endif;

		return $message;
}
/* Custom Add To Cart Messages */
?>
