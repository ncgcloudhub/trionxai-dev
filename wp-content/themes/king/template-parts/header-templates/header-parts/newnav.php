<?php
/**
 * The header part - headnav.
 *
 * This is the header template part.
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
<?php
$menu_slug = 'header-nav';
$hnavs     = '';

if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_slug ] ) ) {
	$menus = get_term( $locations[ $menu_slug ] );
	if ($menus) {
		$hnavs = wp_get_nav_menu_items( $menus->term_id );
	}
	
}
$smenu = array();
if ( $hnavs ) :
	foreach ( $hnavs as $key => $hnav ) {
		$pid = $hnav->menu_item_parent;
		if ( $pid ) {
			$smenu[ $pid ]['links_in_mega_menu'][] = array(
				'mega_menu_link_text' => $hnav->title,
				'mega_menu_link_url'  => $hnav->url,
			);
		}
	}
	$hnavs = king_wp_nav_menu_objects( $hnavs, null );
	foreach ( $hnavs as $hnav ) :
		$mtype = ( 'category' === $hnav->object ) ? 'c' : 't';

		?>
		<?php if ( empty( $hnav->menu_item_parent ) ) : ?>
			<li>
				<a class="king-head-nav-a" href="<?php echo esc_url( $hnav->url ); ?>"><?php echo wp_kses_post( $hnav->title ); ?></a>
				<?php if ( get_field( 'enable_mega_menu', $hnav ) ) :
					
					if ( 'category' === $hnav->object || 'post_tag' === $hnav->object ) :
						$sid = isset($smenu[ $hnav->ID ]) ? $smenu[ $hnav->ID ] : '';
						$pnumber = get_field( 'mmenu_post_number', $hnav );
						if ( get_field( 'mega_menu_left_description', $hnav ) ) {
							$dleft['desc'] = term_description( $hnav->object_id );
							$bgimage = get_field( 'category_background_image', 'term_' . $hnav->object_id );
							$dleft['bgimage'] = isset( $bgimage['url'] ) ? $bgimage['url'] : '';
							$dleft['color'] = get_field( 'category_colors', 'term_' . $hnav->object_id );
							$dleft['title'] =  $hnav->title;
						} else {
							$dleft = array();
						}
					
					?>
					<?php echo wp_kses_post( king_mega_menu( $sid, $hnav->object_id, $pnumber, 'recent', array( 'post', 'list', 'poll', 'trivia' ), $mtype, $dleft ) ); ?>
					<?php else : ?>
						<div class="king-nav-dropdown">
							<?php if ( get_field( 'mega_menu_left_description', $hnav ) ) :	?>
								<div class="king-d-left" data-king-img-src="<?php echo esc_url( the_field( 'left_description_background', $hnav ) ); ?>">
									<span class="king-d-content"><h3><?php echo the_field( 'left_desc_title', $hnav ); ?></h3></span>
								</div>
							<?php endif; ?>
							<ul class="headn-menu">
							<?php
							$nlinks = king_menu_item_array( $hnavs, $hnav->ID );
							if ( isset($nlinks) ) :
								foreach ( $nlinks as $nlink ) :
									?>
								 <li>
									<a href="<?php echo esc_url( $nlink['item']->url ); ?>" class="new-parent"><?php echo esc_attr( $nlink['item']->title ); ?></a>
									<?php foreach ($nlink['childs'] as $key => $value) : ?>
										<a href="<?php echo esc_url( $value['item']->url ); ?>" class="new-child"><?php echo esc_attr( $value['item']->title ); ?></a>
									<?php endforeach; ?>
								</li>
								<?php endforeach; ?>
						<?php endif; ?>
					</ul>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
