<?php
/**
 * King AMP Header.
 *
 * @package King_Theme
 */
?>
<header class="amp-king-header">
	<div class="amp-king-logo">
			<a href="<?php echo esc_url( site_url() ); ?>" class="amp-king-logo-img">
				<?php if ( get_field( 'page_logo', 'options' ) ) : $logo = get_field( 'page_logo', 'options' ); ?>
					<amp-img src="<?php echo esc_url( $logo['url'] ); ?>" width="<?php echo esc_attr( $logo['width'] ); ?>" height="<?php echo esc_attr( $logo['height'] ); ?>"></amp-img>
				<?php else : ?>
					<span><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</a>
	</div>
	<div on="tap:sidebar.toggle" class="ampstart-btn caps m2" role="button" tabindex="0"><span></span></div>
</header>
