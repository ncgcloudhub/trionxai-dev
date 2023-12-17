<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * After payment complete add period of membership.
 *
 * @param <type> $order_id  The order identifier.
 */
function king_payment_complete( $order_id ) {
	$order   = wc_get_order( $order_id );
	$user_id = $order->user_id;

	if ( '' != $user_id && $user_id > 0 && 'refund' !== $order->order_type ) {
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$pid     = $item['product_id'];
			$product = wc_get_product( $pid );
			$period  = get_field( 'membership_period_number', $pid );
			$perday  = get_field( 'membership_period_days', $pid );
			$time    = get_field( 'membership_expiration_date', 'user_' . $user_id );
			if ( 'subscription' !== $product->get_type() ) {
				if ( 'unlimited' === $perday ) {
					$text = date( 'Y-m-d', strtotime( '12 year' ) );
					update_user_meta( $user_id, '_membership_unlimited', 'field_5fcf7b8771ed9' );
					update_user_meta( $user_id, 'membership_unlimited', true );
				} else {
					if ( $time ) {
						$text = date( 'Y-m-d', strtotime( $period . ' ' . $perday, strtotime( $time ) ) );
					} else {
						$text = date( 'Y-m-d', strtotime( $period . ' ' . $perday ) );
					}
				}
				update_user_meta( $user_id, '_membership_expiration_date', 'field_5fcf678cd4bf5' );
				update_user_meta( $user_id, 'membership_expiration_date', $text );
			}
			update_user_meta( $user_id, '_premium_member', 'field_5fcf951c1962d' );
			update_user_meta( $user_id, 'premium_member', true );
		}
	}
}
add_action( 'woocommerce_order_status_completed', 'king_payment_complete' );
/**
 * If order refunded or canceled.
 *
 * @param <type> $order_id The order identifier.
 * @param <type> $old_status The old status.
 * @param string $new_status The new status.
 */
function king_order_status_changed( $order_id, $old_status, $new_status ) {
	if ( $new_status == 'cancelled' ||  $new_status == 'refunded' ) {
		$order   = wc_get_order( $order_id );
		$user_id = $order->user_id;
		$items   = $order->get_items();
		foreach ( $items as $item ) {
			$pid    = $item['product_id'];
			$period = get_field( 'membership_period_number', $pid );
			$perday = get_field( 'membership_period_days', $pid );
			$time   = get_field( 'membership_expiration_date', 'user_' . $user_id );

			if ( 'unlimited' === $perday ) {
				$text = date( 'Y-m-d', strtotime( '12 year' ) );
				update_user_meta( $user_id, '_membership_unlimited', 'field_5fcf7b8771ed9' );
				update_user_meta( $user_id, 'membership_unlimited', false );
			} else {
				$text = date( 'Y-m-d', strtotime( '-' . $period . ' ' . $perday ) );
			}
			update_user_meta( $user_id, '_premium_member', 'field_5fcf951c1962d' );
			update_user_meta( $user_id, 'premium_member', false );

			update_user_meta( $user_id, '_membership_expiration_date', 'field_5fcf678cd4bf5' );
			update_user_meta( $user_id, 'membership_expiration_date', $text );

		}
	}
}
add_action( 'woocommerce_order_status_changed', 'king_order_status_changed', 99, 3 );
if ( ! function_exists( 'king_check_membership' ) ) :
	/**
	 * Check membership expired or not.
	 *
	 * @param boolean $pstid The postid.
	 *
	 * @return boolean  ( description_of_the_return_value )
	 */
	function king_check_membership( $pstid = false, $userid = false ) {
		if ( $userid ) {
			$usrid = $userid;
		} else {
			$usrid = get_current_user_id();
		}
		$time  = get_field( 'membership_expiration_date', 'user_' . $usrid );
		$now   = date( 'm/d/Y' );
		$terms = '';
		if ( $pstid ) {
			$terms = wp_get_post_terms( $pstid, 'category', array( 'meta_query' => array( array( 'key' => 'category_for_free', 'compare' => 'LIKE', 'value' => 1 ) ) ) );
		}
		$result = true;
		if ( get_field( 'enable_membership', 'options' ) ) {
			if ( get_field( 'premium_member', 'user_' . $usrid ) && ( $time >= $now || get_field( 'membership_unlimited', 'user_' . $usrid ) ) && is_user_logged_in() ) {
				$result = true;
			} elseif ( king_plugin_active( 'WC_Subscription' ) && wcs_user_has_subscription( $usrid, '', 'active' ) && is_user_logged_in() ) {
				$result = true;
			} elseif ( ! empty( $terms ) ) {
				$result = true;
			} else {
				$result = false;
			}
		} else {
			$result = true;
		}
		return $result;
	}
endif;
/**
 * Disable woocommerce allscripts in main page.
 */
function king_disable_woocommerce_loading_css_js() {
	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'wc-block-style' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'wc-add-to-cart' );
		wp_deregister_script( 'js-cookie' );
		wp_dequeue_script( 'js-cookie' );
	}
}
add_action( 'wp_enqueue_scripts', 'king_disable_woocommerce_loading_css_js' );


if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5fcbd33546161',
	'title' => 'Membership',
	'fields' => array(
		array(
			'key' => 'field_5fcbd35c5c7b2',
			'label' => 'Membership Product',
			'name' => 'membership_product',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fcbd3735c7b3',
			'label' => 'Membership Product Period',
			'name' => 'membership_period_number',
			'type' => 'number',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5fcbd35c5c7b2',
						'operator' => '==',
						'value' => '1',
					),
					array(
						'field' => 'field_5fe07cf1d8f38',
						'operator' => '!=',
						'value' => 'unlimited',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'default_value' => 1,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => 1,
			'max' => '',
			'step' => '',
		),
		array(
			'key' => 'field_5fe07cf1d8f38',
			'label' => 'Membership Product Period',
			'name' => 'membership_period_days',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5fcbd35c5c7b2',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'day' => 'Day(s)',
				'week' => 'Week(s)',
				'month' => 'Month(s)',
				'year' => 'Year(s)',
				'unlimited' => 'Unlimited',
			),
			'default_value' => false,
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5fcf674d81476',
	'title' => 'User Membership',
	'fields' => array(
		array(
			'key' => 'field_5fcf951c1962d',
			'label' => 'Premium Member',
			'name' => 'premium_member',
			'type' => 'true_false',
			'instructions' => 'Select this user profile as a premium',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5fcf678cd4bf5',
			'label' => 'Membership expiration date',
			'name' => 'membership_expiration_date',
			'type' => 'date_time_picker',
			'instructions' => 'this user premium membership will finish this date',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5fcf7b8771ed9',
						'operator' => '!=',
						'value' => '1',
					),
					array(
						'field' => 'field_5fcf951c1962d',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'm/d/Y',
			'return_format' => 'm/d/Y',
			'first_day' => 1,
		),
		array(
			'key' => 'field_5fcf7b8771ed9',
			'label' => 'Unlimited',
			'name' => 'membership_unlimited',
			'type' => 'true_false',
			'instructions' => 'this user will be a premium member forever.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5fcf951c1962d',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
		),
	),
	'menu_order' => 3,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;

