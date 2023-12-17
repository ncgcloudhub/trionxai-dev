<?php
/**
 * Navigation in header theme part.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! get_field( 'hide_navbar', 'options' ) ) :

	?> 

<?php if ( get_field( 'header_templates', 'options' ) === 'header-template-08' ) : ?>
<nav id="site-navigation" class="main-navigation lr-padding">
<?php else : ?>
<nav id="site-navigation" class="king-npup lr-padding">
	<div class="main-navigation">
<?php endif; ?>
	<span class="king-menu-toggle"  data-toggle="dropdown" data-target=".header-nav" aria-expanded="false" role="button"><i class="fa fa-align-center fa-lg" aria-hidden="true"></i></span>

	<?php if ( king_plugin_active( 'WooCommerce' ) && ( ! get_field( 'enable_membership', 'options' ) || get_field( 'display_cart_icon', 'options' ) ) ) : ?>
		<?php $king_shop_count = WC()->cart->get_cart_contents_count(); ?>
		<div class="king-cart">
			<span class="king-cart-toggle"  data-toggle="modal" data-target=".king-cart-content" aria-expanded="false" role="button">
				<?php if ( $king_shop_count ) : ?>
					<span class="king-cart-badge"><?php echo (int) $king_shop_count; ?></span>
				<?php else : ?>
					<span class="king-cart-badge hide">0</span>
				<?php endif; ?>
				<i class="fa fa-shopping-bag" aria-hidden="true"></i>
			</span>
			<div class="king-cart-content">
			<button type="button" class="king-cart-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</div>
		</div>
	<?php endif; ?>	  
	<div class="header-nav">
		<?php
		// Primary navigation menu.
		wp_nav_menu( array(
			'menu_id'     => 'primary-menu',
			'theme_location' => 'primary',
		) );
			?>
	</div>
<?php if ( get_field( 'header_templates', 'options' ) !== 'header-template-08' ) : ?>
	</div>
<?php endif; ?>


</nav><!-- #site-navigation -->
<?php endif; ?>
