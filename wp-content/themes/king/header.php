<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( get_field( 'custom_html_head', 'options' ) ) : ?>
		<?php the_field( 'custom_html_head', 'options' ); ?>
	<?php endif; ?>
	<?php
	if ( get_field( 'enable_meta_tags', 'options' ) ) :
		king_meta_tags();
	endif;
	?>
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '193495583640077',
      cookie     : true,
      xfbml      : true,
      version    : 'v17.0'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
</head>
<body <?php body_class(); ?>>
<?php
// Header templates.
$headtemplate = get_field( 'header_templates', 'options' );
if ( $headtemplate ) :
	get_template_part( 'template-parts/header-templates/' . $headtemplate . '' );
else :
	get_template_part( 'template-parts/header-templates/header-template-01' );
endif;

$hidnav = get_field( 'hide_navbar', 'options' ) ? ' hidden-nav' : '';

?>

	<div id="content" class="site-content<?php echo esc_attr( $hidnav ); ?>">
