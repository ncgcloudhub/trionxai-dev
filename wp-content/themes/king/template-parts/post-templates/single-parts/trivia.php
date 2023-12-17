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
	if ( have_rows( 'quiz_questions' ) ) :
		$parent_i = 0;
		?>
		<ul class="king-polls-ul">
			<?php
			while ( have_rows( 'quiz_questions' ) ) :
				the_row();
				$parent_i++;

				$ptitle  = get_sub_field( 'quiz_title' );
				$hpoll   = get_sub_field( 'hide_quiz_title' );
				$pimage  = get_sub_field( 'quiz_image' );
				$pastyle = get_sub_field( 'quiz_answers_style' );
				$nonce   = wp_create_nonce( 'king_quiz_nonce' );
				$tcount  = count( get_field( 'quiz_questions' ) );
				$rotate  = round( ( $parent_i * 100 ) / ( $tcount ) );
				?>
				<li class="king-poll" data-parent="<?php echo esc_attr( $tcount ); ?>" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-postid="<?php echo esc_attr( get_the_ID() ); ?>" data-voted="0" id="<?php echo esc_attr( $parent_i ); ?>">
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
					if ( have_rows( 'quiz_grid_answers' ) ) :
						$child_i = 0;
						?>
						<ul class="king-poll-answers <?php echo esc_attr( $pastyle ); ?>" >
							<?php
							while ( have_rows( 'quiz_grid_answers' ) ) :
								the_row();
								$child_i++;
								$paimage = get_sub_field( 'quiz_answer_image' );
								$patitle = get_sub_field( 'quiz_answer' );
								$correct = get_sub_field( 'quiz_correct' );

								?>
								<li class="king-quiz-answer" data-child="<?php echo esc_attr( $child_i ); ?>">
									<div class="king-poll-answer-in">
										<?php if ( $paimage && 'pollgrid-1' !== $pastyle ) : ?>
											<span class="king-poll-image">
												<img src="<?php echo esc_url( $paimage['sizes']['medium_large'] ); ?>" alt="<?php echo esc_attr( $paimage['alt'] ); ?>" />
											</span>
										<?php endif; ?>
										<?php echo esc_html( $patitle ); ?>
										<?php if ( $correct ) : ?>
											<input type="hidden" name="king_quiz" value="1" />
										<?php else : ?>
											<input type="hidden" name="king_quiz" value="0" />
										<?php endif; ?>
									</div>
								</li>
							<?php endwhile; ?>
						</ul>
					<?php endif; ?>
				</li>
				<?php endwhile; ?>
		</ul>
	<?php endif; ?>
	<div class="king-quiz-result"></div>
</div>

