<?php
/**
 * The header template-03.
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
<div id="page" class="site header-template-03">
<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
	<div class="king-top-header top-header-03 lr-padding">
		<div class="king-top-header-menu">
			<?php wp_nav_menu( array( 'theme_location' => 'top-header-menu' ) ); ?>
		</div>
		<div class="king-top-header-icons">
		<?php
			$group     = get_field( 'header_03_options', 'options' );
			$repeaters = $group['top_header_right_icons'];
		if ( $repeaters ) :
			foreach ( $repeaters as $repeater ) {
					echo '<a href="' . esc_url( $repeater['link_url'] ) . '" >' . wp_kses_post( $repeater['icon_code'] ) . '</a>';
			}
		endif;
		?>
		</div>
	</div><!-- .king-top-header -->
<header id="masthead" class="site-header sticky-header-03">
	<div class="king-header header-03 lr-padding">
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