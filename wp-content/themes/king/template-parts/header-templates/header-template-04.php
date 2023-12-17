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
?>
<div id="page" class="site header-template-04">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
<?php
$hero = get_field( 'header_04_options', 'options' );
if ( $hero['code'] && king_add_free_mode() ) :
	?>
	<div class="king-top-ad top-header-04" style="<?php if ( $hero['background'] ) : ?>background-color:<?php echo esc_attr( $hero['background'] ); ?>;<?php endif; ?><?php if ( $hero['top_background_image'] ) : ?>background-image: url(<?php echo esc_attr( $hero['top_background_image'] ); ?>);<?php endif; ?><?php if ( $hero['top_height'] ) : ?>height: <?php echo esc_attr( $hero['top_height'] ); ?>px;<?php endif; ?>" >
			<div class="king-top-ad-inner"><?php echo do_shortcode( $hero['code'] ); ?></div>
	</div><!-- .king-header -->
<?php endif; ?>	
<header id="masthead" class="site-header">
	<div class="king-header header-04 lr-padding">
		<span class="king-head-toggle" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false" role="button">
			<i class="fa-solid fa-bars"></i>
		</span>	
		<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
		<?php get_template_part( 'template-parts/header-templates/header-parts/headnav' ); ?>
		<div class="king-header-right">
			<?php get_template_part( 'template-parts/header-templates/header-parts/extraicons' ); ?>
			<div id="searchv2-button"><i class="fa fa-search fa-lg" aria-hidden="true"></i></div>
			<?php
			if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
				echo king_header_bookmark();
			endif;
			?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/notify' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/submit' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/user' ); ?>
		</div>
	</div><!-- .king-header -->
	<?php get_template_part( 'template-parts/header-templates/header-parts/search-v2' ); ?>
</header><!-- #masthead -->
<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>