<?php
/**
 * The header template-04.
 *
 * This is the header template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $hide;
?>
<div id="page" class="site header-template-08">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
	<?php if ( is_front_page() && is_home() && get_field( 'display_slider', 'options' ) && empty( $GLOBALS['hide'] ) ) : ?>
	<div class="king-slider-08">
		<?php
		if ( ( get_field( 'slider_template', 'options' ) === 'slider-template-1' || get_field( 'slider_template', 'options' ) === 'slider-template-2' ) ) :
			get_template_part( 'template-parts/king-featured-posts' );
	elseif ( get_field( 'slider_template', 'options' ) === 'slider-template-3' ) :
		get_template_part( 'template-parts/king-featured-video' );
	endif;
	?>
</div>
<?php endif; ?>
<header id="masthead" class="site-header">
	<div class="king-header header-08 lr-padding">	
		<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
		<?php
			$args['dots'] = false;
			get_template_part( 'template-parts/header-templates/header-parts/headnav', null, $args );
			?>
		<div class="king-header-right no-back">
			<?php get_template_part( 'template-parts/header-templates/header-parts/search' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/extraicons' ); ?>
			<?php
			if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
				echo king_header_bookmark();
			endif;
			?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
			<div class="king-right-toggle" data-toggle="dropdown" data-target=".king-rightmenu" aria-expanded="false" role="button"><span class="right-toggle-line"></span></div>			

		</div>
	</div><!-- .king-header -->
</header><!-- #masthead -->
<?php get_template_part( 'template-parts/header-templates/header-parts/rightmenu' ); ?>
<?php get_template_part( 'template-parts/header-templates/header-parts/submit-v2' ); ?>
