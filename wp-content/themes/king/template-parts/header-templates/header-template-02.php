<?php
/**
 * The header template-02.
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
<?php $hero = get_field( 'header_02_options', 'options' ); ?>
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
<div id="page" class="site header-template-02" <?php if ( $hero['margin'] ) : ?> style="margin:0 <?php echo esc_attr( $hero['margin'] ); ?>px;" <?php endif; ?>>
<header id="masthead" class="site-header">
	<div class="king-header header-02 lr-padding">
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