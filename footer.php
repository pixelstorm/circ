<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main>
<?php
if ( is_shop() || is_product_category() ) :
	$image = get_field( 'shop_before_footer_image', 'option' );
	$text  = get_field( 'shop_before_footer_text', 'option' );
	$logo  = get_field( 'shop_before_footer_logo', 'option' );
	$url   = get_field( 'shop_before_footer_url', 'option' );
	?>
	<div class="row row-collapse row-full-width mission mission-show" >
	<div class="col mission__image-wrapper medium-7 large-7">
		<div class="col-inner">
		<div class="img has-hover x md-x lg-x y md-y lg-y">
			<div class="img-inner dark">
			<img src="<?php echo $image; ?>" alt="">
			</div>
		</div>
		</div>
	</div>
	<div class="col mission__content-wrapper medium-5 large-5">
		<div class="col-inner">
		<div class="img has-hover mission__logo x md-x lg-x y md-y lg-y" >
			<div class="img-inner dark">
			<img src="<?php echo $logo; ?>" alt=""/>
			</div>
		</div>
		<div class="text mission__text">
			<p><?php echo $text; ?></p>
		</div>
		<a href="<?php echo $url; ?>" target="_self" class="button primary lowercase mission__btn">
			<span>About the charity</span>
		</a>
		</div>
	</div>
	</div>
<?php endif; ?>
<footer id="footer" class="footer-wrapper">
	<?php do_action( 'flatsome_footer' ); ?>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
