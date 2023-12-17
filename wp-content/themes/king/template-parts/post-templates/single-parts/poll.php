<?php
/**
 * The singe post part - poll.
 *
 * This is a content template part.
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
<div class="king-polls">
	<?php
	if ( have_rows( 'king_poll' ) ) :
		$parent_i = 0;
		?>
		<ul class="king-polls-ul">
			<?php
			while ( have_rows( 'king_poll' ) ) :
				the_row();
				$parent_i++;
				if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
				} else {
					$user_id = king_get_the_user_ip();
					if ( empty( $user_id ) ) {
						$user_id = '9999999';
					}
				}
				$ptitle  = get_sub_field( 'poll_title' );
				$hpoll   = get_sub_field( 'hide_poll_title' );
				$pimage  = get_sub_field( 'poll_image' );
				$pastyle = get_sub_field( 'poll_answers_style' );
				$result  = get_sub_field( 'poll_results' );
				$results = maybe_unserialize( $result );
				$nonce   = wp_create_nonce( 'king_poll_nonce' );
				$total   = is_array( $results ) ? count( $results ) : '0';
				$tcount  = count( get_field( 'king_poll' ) );
				if ( is_array( $results ) && array_key_exists( $user_id, $results ) ) {
					$show = ' voted';
				} else {
					$show = '';
				}
				$rotate = round( ( $parent_i * 100 ) / ( $tcount ) );
				?>
				<li class="king-poll<?php echo esc_attr( $show ); ?>" data-parent="<?php echo esc_attr( $parent_i ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-postid="<?php echo esc_attr( get_the_ID() ); ?>" data-total="<?php echo esc_attr( $total ); ?>">
					<div class="king-poll-title">
						<div class="poll-circle">
							<svg class="circle" viewbox="0 0 40 40">
								<circle class="circle-back" fill="none" cx="20" cy="20" r="15.9"/>
								<circle class="circle-chart"  stroke-dasharray="<?php echo esc_attr( $rotate ); ?>,100" stroke-linecap="round" fill="none" cx="20" cy="20" r="15.9"/>
							</svg>
						</div>
						<?php echo esc_attr( $parent_i ) . esc_html__( ' of ', 'king' ) . esc_attr( $tcount ); ?>
						<?php if ( ! $hpoll ) : ?>
							<h4><?php echo esc_html( $ptitle ); ?></h4>
						<?php endif; ?>
					</div>
					<?php if ( $pimage ) : ?>
						<img class="king-poll-img" src="<?php echo esc_url( $pimage['sizes']['medium_large'] ); ?>" />
					<?php endif; ?>
					<?php
					if ( have_rows( 'poll_grid_answers' ) ) :
						$child_i = 0;
						?>
						<ul class="king-poll-answers <?php echo esc_attr( $pastyle ); ?>">
							<?php
							while ( have_rows( 'poll_grid_answers' ) ) :
								the_row();
								$child_i++;
								$paimage = get_sub_field( 'poll_answer_image' );
								$patitle = get_sub_field( 'poll_answer' );
								if ( isset( $results[ $user_id ] ) && $results[ $user_id ] == $child_i ) {
									$voted = ' vote';
								} else {
									$voted = '';
								}
								$count  = is_array( $results ) ? array_count_values( $results ) : '';
								$counts = isset( $count[ $child_i ] ) ? $count[ $child_i ] : '0';
								if ( ' voted' === $show ) {
									$per = round( ( $counts * 100 ) / ( $total ) );
									$css = 'style="width: ' . esc_attr( $per ) . '%; height: ' . esc_attr( $per ) . '%"';
									$num = $counts;
								} else {
									$css = '';
									$num = '';
									$per = '';
								}
								?>
								<li class="king-poll-answer<?php echo esc_attr( $voted ); ?>" data-child="<?php echo esc_attr( $child_i ); ?>" data-voted="<?php echo esc_attr( $counts ); ?>">
									<div class="king-poll-answer-in">
										<?php if ( $paimage && 'pollgrid-1' !== $pastyle ) : ?>
											<span class="king-poll-image">
												<img src="<?php echo esc_url( $paimage['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $paimage['alt'] ); ?>" />
											</span>
										<?php endif; ?>
										<?php echo esc_html( $patitle ); ?>
										<span class="king-poll-result" <?php echo wp_kses_post( $css ); ?>></span>
										<span class="king-poll-num"><span class="poll-result-percent"><?php echo esc_attr( $per ); ?>%</span> <i class="fas fa-chart-line"></i> <span class="poll-result-voted"><?php echo esc_attr( $num ); ?></span></span>
									</div>
								</li>
							<?php endwhile; ?>
							<div class="quiz-share" style="display:none;">
								<h5><?php echo esc_html_e( 'Share This Poll :', 'king' ); ?></h5>
								<span class="qresult-share"><?php echo king_ft_share( get_the_ID(), $ptitle ); ?></span>
							</div>
						</ul>
					<?php endif; ?>
				</li>
				<?php endwhile; ?>
		</ul>
	<?php endif; ?>
</div>

