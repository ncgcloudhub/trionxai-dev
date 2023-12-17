<?php
/**
 * The template for submit trivia quiz.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="inside acf-fields -top king-trivia">
	<ul class="king-tabs">
		<li class="active"><a href="#kquestions" data-toggle="tab"><i class="fas fa-question-circle"></i> <?php echo esc_html_e( 'Questions', 'king' ); ?></a></li>
		<li><a href="#kresults" data-toggle="tab"><i class="fas fa-greater-than-equal"></i> <?php echo esc_html_e( 'Results', 'king' ); ?></a></li>
	</ul>
	<div class="acf-field acf-field-repeater acf-field-60afc5cb49251 king-repeater active" data-key="field_60afc5cb49251" data-name="quiz_questions" data-type="repeater" id="kquestions">
		<div class="acf-input">
			<div class="acf-repeater -block" data-max="30" data-min="1">
				<input name="acf[field_60afc5cb49251]" type="hidden" value="">
				<table class="acf-table">
					<tbody class="ui-sortable">
						<tr class="acf-row" data-id="row-0">
							<td class="acf-row-handle order ui-sortable-handle" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
								<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php echo esc_html_e( 'Click to toggle', 'king' ); ?>">
								</a>
								<span>1</span>
								<div class="acf-row-handle remove">
									<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
									</a>
								</div>
							</td>
							<td class="acf-fields">
								<div class="acf-field acf-field-text acf-field-60afc61249252 -collapsed-target" data-conditions='[[{"field":"field_60afc76a49254","operator":"!=","value":"1"}]]' data-key="field_60afc61249252" data-name="quiz_title" data-type="text">
									<div class="acf-input">
										<div class="acf-input-wrap">
											<input id="acf-field_60afc5cb49251-row-0-field_60afc61249252" name="acf[field_60afc5cb49251][row-0][field_60afc61249252]" type="text" placeholder="<?php echo esc_html_e( 'question ?', 'king' ); ?>" />
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-true-false acf-field-60afc76a49254 acf-hidden" data-conditions='[[{"field":"field_60afc6a449253","operator":"!=empty"}]]' data-key="field_60afc76a49254" data-name="hide_quiz_title" data-type="true_false" hidden="">
									<div class="acf-input">
										<div class="acf-true-false">
											<input disabled="" name="acf[field_60afc5cb49251][row-0][field_60afc76a49254]" type="hidden" value="0">
											<label>
												<input autocomplete="off" class="acf-switch-input" disabled="" id="acf-field_60afc5cb49251-row-0-field_60afc76a49254" name="acf[field_60afc5cb49251][row-0][field_60afc76a49254]" type="checkbox" value="1">
												<div class="acf-switch">
													<span class="acf-switch-on acf-js-tooltip" title="<?php echo esc_html_e('show question title', 'king'); ?>">
														<i class="fas fa-heading">
														</i>
													</span>
													<span class="acf-switch-off acf-js-tooltip" title="<?php echo esc_html_e('hide question title', 'king'); ?>">
														<i class="far fa-eye-slash">
														</i>
													</span>
													<div class="acf-switch-slider">
													</div>
												</div>
											</input>
										</label>
									</input>
								</div>
							</div>
						</div>
						<div class="acf-field acf-field-image acf-field-60afc6a449253" data-key="field_60afc6a449253" data-name="quiz_image" data-type="image">
							<div class="acf-input">
								<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif," data-preview_size="thumbnail" data-uploader="wp">
									<input name="acf[field_60afc5cb49251][row-0][field_60afc6a449253]" type="hidden" value="">
									<div class="show-if-value image-wrap" style="max-width: 150px">
										<img alt="" data-name="image" src="" style="max-height: 150px;">
										<div class="acf-actions -hover">
											<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
											</a>
											<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
											</a>
										</div>
									</img>
								</div>
								<div class="hide-if-value">
									<p>
										<a class="acf-button button" data-name="add" href="#">
											<?php echo esc_html_e( 'Add Image', 'king' ); ?>
										</a>
									</p>
								</div>
							</input>
						</div>
					</div>
				</div>
				<div class="acf-field acf-field-radio acf-field-60afc8e93975d poll-radio -c0" data-key="field_60afc8e93975d" data-name="quiz_answers_style" data-type="radio">
					<div class="acf-input">
						<input name="acf[field_60afc5cb49251][row-0][field_60afc8e93975d]" type="hidden">
						<ul class="acf-radio-list acf-hl" data-allow_null="0" data-other_choice="0">
							<li>
								<label class="selected">
									<input type="radio" id="acf-field_60afc5cb49251-row-0-field_60afc8e93975d-pollgrid-1" name="acf[field_60afc5cb49251][row-0][field_60afc8e93975d]" value="pollgrid-1" checked="checked" class="hide">
									<i class="fas fa-bars"></i>
								</input>
							</label>
						</li>
						<li>
							<label>
								<input type="radio" id="acf-field_60afc5cb49251-row-0-field_60afc8e93975d-pollgrid-2" name="acf[field_60afc5cb49251][row-0][field_60afc8e93975d]" value="pollgrid-2" class="hide">
								<i class="fas fa-th-large"></i>
							</input>
						</label>
					</li>
					<li>
						<label>
							<input type="radio" id="acf-field_60afc5cb49251-row-0-field_60afc8e93975d-pollgrid-3" name="acf[field_60afc5cb49251][row-0][field_60afc8e93975d]" value="pollgrid-3" class="hide">
							<i class="fas fa-grip-horizontal"></i>
						</input>
					</label>
				</li>
			</ul>
		</input>
	</div>
</div>
<div class="acf-field acf-field-repeater acf-field-60afc95c3975e dflex" data-key="field_60afc95c3975e" data-name="quiz_grid_answers" data-type="repeater">
	<div class="acf-input">
		<div class="acf-repeater -block" data-max="20" data-min="2">
			<input name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e]" type="hidden" value="">
			<table class="acf-table">
				<tbody class="ui-sortable">
					<tr class="acf-row" data-id="row-0">
						<td class="acf-row-handle order ui-sortable-handle" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
							<span>
								1
							</span>
							<div class="acf-row-handle remove">
								<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
								</a>
							</div>
						</td>
						<td class="acf-fields">
							<div class="acf-field acf-field-image acf-field-60afc9b33975f acf-hidden" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image" hidden="">
								<div class="acf-input">
									<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
										<input disabled="" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-0][field_60afc9b33975f]" type="hidden" value="">
										<div class="show-if-value image-wrap" style="max-width: 150px">
											<img alt="" data-name="image" src="" style="max-height: 150px;">
											<div class="acf-actions -hover">
												<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
												</a>
												<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
												</a>
											</div>
										</img>
									</div>
									<div class="hide-if-value">
										<p>
											<a class="acf-button button" data-name="add" href="#">
												<?php echo esc_html_e( 'Add Image', 'king' ); ?>
											</a>
										</p>
									</div>
								</input>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
						<div class="acf-input">
							<div class="acf-input-wrap">
								<input id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-row-0-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-0][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
						<div class="acf-input">
							<div class="acf-true-false">
								<input name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-0][field_60afcaf36c797]" type="hidden" value="0">
								<label>
									<input autocomplete="off" checked="true" class="" id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-row-0-field_60afcaf36c797" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-0][field_60afcaf36c797]" type="checkbox" value="1">
									<span class="message">
										<?php echo esc_html_e( 'Correct', 'king' ); ?>
									</span>
								</input>
							</label>
						</input>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr class="acf-row" data-id="row-1">
		<td class="acf-row-handle order ui-sortable-handle" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
			<span>
				2
			</span>
			<div class="acf-row-handle remove">
				<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
				</a>
			</div>
		</td>
		<td class="acf-fields">
			<div class="acf-field acf-field-image acf-field-60afc9b33975f acf-hidden" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image" hidden="">
				<div class="acf-input">
					<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
						<input disabled="" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-1][field_60afc9b33975f]" type="hidden" value="">
						<div class="show-if-value image-wrap" style="max-width: 150px">
							<img alt="" data-name="image" src="" style="max-height: 150px;">
							<div class="acf-actions -hover">
								<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
								</a>
								<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
								</a>
							</div>
						</img>
					</div>
					<div class="hide-if-value">
						<p>
							<a class="acf-button button" data-name="add" href="#">
								<?php echo esc_html_e( 'Add Image', 'king' ); ?>
							</a>
						</p>
					</div>
				</input>
			</div>
		</div>
	</div>
	<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
		<div class="acf-input">
			<div class="acf-input-wrap">
				<input id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-row-1-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-1][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
			</div>
		</div>
	</div>
	<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
		<div class="acf-input">
			<div class="acf-true-false">
				<input name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-1][field_60afcaf36c797]" type="hidden" value="0">
				<label>
					<input autocomplete="off" class="" id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-row-1-field_60afcaf36c797" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][row-1][field_60afcaf36c797]" type="checkbox" value="1">
					<span class="message">
						<?php echo esc_html_e( 'Correct', 'king' ); ?>
					</span>
				</input>
			</label>
		</input>
	</div>
</div>
</div>
</td>
</tr>
<tr class="acf-row acf-clone" data-id="acfcloneindex" style="">
	<td class="acf-row-handle order ui-sortable-handle" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
		<span>
			1
		</span>
		<div class="acf-row-handle remove">
			<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
			</a>
		</div>
	</td>
	<td class="acf-fields">
		<div class="acf-field acf-field-image acf-field-60afc9b33975f" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image">
			<div class="acf-input">
				<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
					<input disabled="" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][acfcloneindex][field_60afc9b33975f]" type="hidden" value="">
					<div class="show-if-value image-wrap" style="max-width: 150px">
						<img alt="" data-name="image" src="" style="max-height: 150px;">
						<div class="acf-actions -hover">
							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
							</a>
							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
							</a>
						</div>
					</img>
				</div>
				<div class="hide-if-value">
					<p>
						<a class="acf-button button" data-name="add" href="#">
							<?php echo esc_html_e( 'Add Image', 'king' ); ?>
						</a>
					</p>
				</div>
			</input>
		</div>
	</div>
</div>
<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
	<div class="acf-input">
		<div class="acf-input-wrap">
			<input disabled="" id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-acfcloneindex-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][acfcloneindex][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
		</div>
	</div>
</div>
<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
	<div class="acf-input">
		<div class="acf-true-false">
			<input disabled="" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][acfcloneindex][field_60afcaf36c797]" type="hidden" value="0">
			<label>
				<input autocomplete="off" class="" disabled="" id="acf-field_60afc5cb49251-row-0-field_60afc95c3975e-acfcloneindex-field_60afcaf36c797" name="acf[field_60afc5cb49251][row-0][field_60afc95c3975e][acfcloneindex][field_60afcaf36c797]" type="checkbox" value="1">
				<span class="message">
					<?php echo esc_html_e( 'Correct', 'king' ); ?>
				</span>
			</input>
		</label>
	</input>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
<div class="acf-actions">
	<a class="acf-button button button-primary acf-js-tooltip" data-event="add-row" href="#" title="<?php echo esc_html_e('Add Answer', 'king'); ?>">
		<i class="fas fa-plus">
		</i>
	</a>
</div>
</input>
</div>
</div>
</div>
</td>
</tr>
<tr class="acf-row acf-clone" data-id="acfcloneindex" style="">
	<td class="acf-row-handle order ui-sortable-handle" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
		<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php echo esc_html_e( 'Click to toggle', 'king' ); ?>">
		</a>
		<span>
			1
		</span>
		<div class="acf-row-handle remove">
			<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
			</a>
		</div>
	</td>
	<td class="acf-fields">
		<div class="acf-field acf-field-text acf-field-60afc61249252 -collapsed-target" data-conditions='[[{"field":"field_60afc76a49254","operator":"!=","value":"1"}]]' data-key="field_60afc61249252" data-name="quiz_title" data-type="text">
			<div class="acf-input">
				<div class="acf-input-wrap">
					<input disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc61249252" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc61249252]" type="text" placeholder="<?php echo esc_html_e( 'question ?', 'king' ); ?>"/>
				</div>
			</div>
		</div>
		<div class="acf-field acf-field-true-false acf-field-60afc76a49254" data-conditions='[[{"field":"field_60afc6a449253","operator":"!=empty"}]]' data-key="field_60afc76a49254" data-name="hide_quiz_title" data-type="true_false">
			<div class="acf-input">
				<div class="acf-true-false">
					<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc76a49254]" type="hidden" value="0">
					<label>
						<input autocomplete="off" class="acf-switch-input" disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc76a49254" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc76a49254]" type="checkbox" value="1">
						<div class="acf-switch">
							<span class="acf-switch-on">
								Yes
							</span>
							<span class="acf-switch-off">
								No
							</span>
							<div class="acf-switch-slider">
							</div>
						</div>
					</input>
				</label>
			</input>
		</div>
	</div>
</div>
<div class="acf-field acf-field-image acf-field-60afc6a449253" data-key="field_60afc6a449253" data-name="quiz_image" data-type="image">
	<div class="acf-input">
		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif," data-preview_size="thumbnail" data-uploader="wp">
			<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc6a449253]" type="hidden" value="">
			<div class="show-if-value image-wrap" style="max-width: 150px">
				<img alt="" data-name="image" src="" style="max-height: 150px;">
				<div class="acf-actions -hover">
					<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
					</a>
					<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
					</a>
				</div>
			</img>
		</div>
		<div class="hide-if-value">
			<p>
				<a class="acf-button button" data-name="add" href="#">
					<?php echo esc_html_e( 'Add Image', 'king' ); ?>
				</a>
			</p>
		</div>
	</input>
</div>
</div>
</div>
<div class="acf-field acf-field-radio acf-field-60afc8e93975d poll-radio" data-key="field_60afc8e93975d" data-name="quiz_answers_style" data-type="radio">
	<div class="acf-input">
		<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc8e93975d]" type="hidden">
		<ul class="acf-radio-list acf-hl" data-allow_null="0" data-other_choice="0">
			<li>
				<label class="selected">
					<input type="radio" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc8e93975d-pollgrid-1" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc8e93975d]" value="pollgrid-1" checked="checked" class="hide">
					<i class="fas fa-bars"></i>
				</input>
			</label>
		</li>
		<li>
			<label>
				<input type="radio" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc8e93975d-pollgrid-2" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc8e93975d]" value="pollgrid-2" class="hide">
				<i class="fas fa-th-large"></i>
			</input>
		</label>
	</li>
	<li>
		<label>
			<input type="radio" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc8e93975d-pollgrid-3" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc8e93975d]" value="pollgrid-3" class="hide">
			<i class="fas fa-grip-horizontal"></i>
		</input>
	</label>
</li>
</ul>
</input>
</div>
</div>
<div class="acf-field acf-field-repeater acf-field-60afc95c3975e dflex" data-key="field_60afc95c3975e" data-name="quiz_grid_answers" data-type="repeater">
	<div class="acf-input">
		<div class="acf-repeater -empty -block" data-max="20" data-min="2">
			<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e]" type="hidden" value="">
			<table class="acf-table">
				<tbody>
					<tr class="acf-row" data-id="row-0">
						<td class="acf-row-handle order" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
							<span>
								1
							</span>
							<div class="acf-row-handle remove">
								<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
								</a>
							</div>
						</td>
						<td class="acf-fields">
							<div class="acf-field acf-field-image acf-field-60afc9b33975f" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image">
								<div class="acf-input">
									<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
										<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-0][field_60afc9b33975f]" type="hidden" value="">
										<div class="show-if-value image-wrap" style="max-width: 150px">
											<img alt="" data-name="image" src="" style="max-height: 150px;">
											<div class="acf-actions -hover">
												<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
												</a>
												<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
												</a>
											</div>
										</img>
									</div>
									<div class="hide-if-value">
										<p>
											<a class="acf-button button" data-name="add" href="#">
												<?php echo esc_html_e( 'Add Image', 'king' ); ?>
											</a>
										</p>
									</div>
								</input>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
						<div class="acf-input">
							<div class="acf-input-wrap">
								<input disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-row-0-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-0][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
						<div class="acf-input">
							<div class="acf-true-false">
								<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-0][field_60afcaf36c797]" type="hidden" value="0">
								<label>
									<input autocomplete="off" checked="true" class="" disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-row-0-field_60afcaf36c797" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-0][field_60afcaf36c797]" type="checkbox" value="1">
									<span class="message">
										<?php echo esc_html_e( 'Correct', 'king' ); ?>
									</span>
								</input>
							</label>
						</input>
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr class="acf-row" data-id="row-1">
		<td class="acf-row-handle order" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
			<span>
				2
			</span>
			<div class="acf-row-handle remove">
				<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
				</a>
			</div>
		</td>
		<td class="acf-fields">
			<div class="acf-field acf-field-image acf-field-60afc9b33975f" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image">
				<div class="acf-input">
					<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
						<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-1][field_60afc9b33975f]" type="hidden" value="">
						<div class="show-if-value image-wrap" style="max-width: 150px">
							<img alt="" data-name="image" src="" style="max-height: 150px;">
							<div class="acf-actions -hover">
								<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
								</a>
								<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
								</a>
							</div>
						</img>
					</div>
					<div class="hide-if-value">
						<p>
							<a class="acf-button button" data-name="add" href="#">
								<?php echo esc_html_e( 'Add Image', 'king' ); ?>
							</a>
						</p>
					</div>
				</input>
			</div>
		</div>
	</div>
	<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
		<div class="acf-input">
			<div class="acf-input-wrap">
				<input disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-row-1-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-1][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
			</div>
		</div>
	</div>
	<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
		<div class="acf-input">
			<div class="acf-true-false">
				<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-1][field_60afcaf36c797]" type="hidden" value="0">
				<label>
					<input autocomplete="off" class="" disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-row-1-field_60afcaf36c797" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][row-1][field_60afcaf36c797]" type="checkbox" value="1">
					<span class="message">
						<?php echo esc_html_e( 'Correct', 'king' ); ?>
					</span>
				</input>
			</label>
		</input>
	</div>
</div>
</div>
</td>
</tr>
<tr class="acf-row acf-clone" data-id="acfcloneindex">
	<td class="acf-row-handle order" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
		<span>
			1
		</span>
		<div class="acf-row-handle remove">
			<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
			</a>
		</div>
	</td>
	<td class="acf-fields">
		<div class="acf-field acf-field-image acf-field-60afc9b33975f" data-conditions='[[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-2"}],[{"field":"field_60afc8e93975d","operator":"==","value":"pollgrid-3"}]]' data-key="field_60afc9b33975f" data-name="quiz_answer_image" data-type="image">
			<div class="acf-input">
				<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
					<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][acfcloneindex][field_60afc9b33975f]" type="hidden" value="">
					<div class="show-if-value image-wrap" style="max-width: 150px">
						<img alt="" data-name="image" src="" style="max-height: 150px;">
						<div class="acf-actions -hover">
							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
							</a>
							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
							</a>
						</div>
					</img>
				</div>
				<div class="hide-if-value">
					<p>
						<a class="acf-button button" data-name="add" href="#">
							<?php echo esc_html_e( 'Add Image', 'king' ); ?>
						</a>
					</p>
				</div>
			</input>
		</div>
	</div>
</div>
<div class="acf-field acf-field-text acf-field-60afca756c796" data-key="field_60afca756c796" data-name="quiz_answer" data-type="text">
	<div class="acf-input">
		<div class="acf-input-wrap">
			<input disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-acfcloneindex-field_60afca756c796" maxlength="200" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][acfcloneindex][field_60afca756c796]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
		</div>
	</div>
</div>
<div class="acf-field acf-field-true-false acf-field-60afcaf36c797" data-key="field_60afcaf36c797" data-name="quiz_correct" data-type="true_false" id="qcorrect">
	<div class="acf-input">
		<div class="acf-true-false">
			<input disabled="" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][acfcloneindex][field_60afcaf36c797]" type="hidden" value="0">
			<label>
				<input autocomplete="off" class="" disabled="" id="acf-field_60afc5cb49251-acfcloneindex-field_60afc95c3975e-acfcloneindex-field_60afcaf36c797" name="acf[field_60afc5cb49251][acfcloneindex][field_60afc95c3975e][acfcloneindex][field_60afcaf36c797]" type="checkbox" value="1">
				<span class="message">
					<?php echo esc_html_e( 'Correct', 'king' ); ?>
				</span>
			</input>
		</label>
	</input>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
<div class="acf-actions">
	<a class="acf-button button button-primary acf-js-tooltip" data-event="add-row" href="#" title="<?php echo esc_html_e('Add Answer', 'king'); ?>">
		<i class="fas fa-plus">
		</i>
	</a>
</div>
</input>
</div>
</div>
</div>
</td>
</tr>
</tbody>
</table>
<div class="acf-actions">
	<a class="acf-button button button-primary" data-event="add-row" href="#">
		<i class="fas fa-plus"></i>
	</a>
</div>
</input>
</div>
</div>
</div>
<div class="acf-field acf-field-repeater acf-field-60afe3a831738 king-repeater" data-key="field_60afe3a831738" data-name="quiz_results" data-type="repeater" id="kresults">
	<div class="acf-input">
		<div class="acf-repeater -block" data-max="30" data-min="1">
			<input name="acf[field_60afe3a831738]" type="hidden" value="">
			<table class="acf-table">
				<tbody>
					<tr class="acf-row" data-id="row-0">
						<td class="acf-row-handle order" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
							<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php echo esc_html_e( 'Click to toggle', 'king' ); ?>">
							</a>
							<span>
								1
							</span>
							<div class="acf-row-handle remove">
								<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
								</a>
							</div>
						</td>
						<td class="acf-fields">
							<div class="acf-field acf-field-number acf-field-60afe3e731739" data-key="field_60afe3e731739" data-name="result_range_low" data-type="number" data-width="15" style="width:15%;">
								<div class="acf-input">
									<div class="acf-input-append">
										%
									</div>
									<div class="acf-input-wrap">
										<input class="acf-is-appended" id="acf-field_60afe3a831738-row-0-field_60afe3e731739" max="100" min="0" name="acf[field_60afe3a831738][row-0][field_60afe3e731739]" step="any" type="number" placeholder="<?php echo esc_html_e( 'Low', 'king' ); ?>"/>
									</div>
								</div>
							</div>
							<div class="acf-field acf-field-number acf-field-60afe4a33173a" data-key="field_60afe4a33173a" data-name="result_range_high" data-type="number" data-width="15" style="width:15%;">
								<div class="acf-input">
									<div class="acf-input-append">
										%
									</div>
									<div class="acf-input-wrap">
										<input class="acf-is-appended" id="acf-field_60afe3a831738-row-0-field_60afe4a33173a" max="100" min="0" name="acf[field_60afe3a831738][row-0][field_60afe4a33173a]" step="any" type="number" placeholder="<?php echo esc_html_e( 'high', 'king' ); ?>"/>
									</div>
								</div>
							</div>
							<div class="acf-field acf-field-text acf-field-60afe5223173b -collapsed-target" data-key="field_60afe5223173b" data-name="quiz_result" data-type="text" data-width="70" style="width:70%;">
								<div class="acf-input">
									<div class="acf-input-wrap">
										<input id="acf-field_60afe3a831738-row-0-field_60afe5223173b" name="acf[field_60afe3a831738][row-0][field_60afe5223173b]" type="text" placeholder="<?php echo esc_html_e( 'result here', 'king' ); ?>"/>
									</div>
								</div>
							</div>
							<div class="acf-field acf-field-image acf-field-60afe54d3173c" data-key="field_60afe54d3173c" data-name="quiz_result_image" data-type="image">
								<div class="acf-input">
									<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif," data-preview_size="thumbnail" data-uploader="wp">
										<input name="acf[field_60afe3a831738][row-0][field_60afe54d3173c]" type="hidden" value="">
										<div class="show-if-value image-wrap" style="max-width: 150px">
											<img alt="" data-name="image" src="" style="max-height: 150px;">
											<div class="acf-actions -hover">
												<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
												</a>
												<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
												</a>
											</div>
										</img>
									</div>
									<div class="hide-if-value">
										<p>
											<a class="acf-button button" data-name="add" href="#">
												<?php echo esc_html_e( 'Add Image', 'king' ); ?>
											</a>
										</p>
									</div>
								</input>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-textarea acf-field-60afe5933173d" data-key="field_60afe5933173d" data-name="quiz_result_description" data-type="textarea">
						<div class="acf-input">
							<textarea id="acf-field_60afe3a831738-row-0-field_60afe5933173d" maxlength="800" name="acf[field_60afe3a831738][row-0][field_60afe5933173d]" rows="6" placeholder="<?php echo esc_html_e( 'enter description', 'king' ); ?>"></textarea>
						</div>
					</div>
				</td>
			</tr>
			<tr class="acf-row acf-clone" data-id="acfcloneindex">
				<td class="acf-row-handle order" title="<?php echo esc_html_e( 'Drag to reorder', 'king' ); ?>">
					<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php echo esc_html_e( 'Click to toggle', 'king' ); ?>">
					</a>
					<span>
						1
					</span>
					<div class="acf-row-handle remove">
						<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
						</a>
					</div>
				</td>
				<td class="acf-fields">
					<div class="acf-field acf-field-number acf-field-60afe3e731739" data-key="field_60afe3e731739" data-name="result_range_low" data-type="number" data-width="15" style="width:15%;">
						<div class="acf-input">
							<div class="acf-input-append">
								%
							</div>
							<div class="acf-input-wrap">
								<input class="acf-is-appended" disabled="" id="acf-field_60afe3a831738-acfcloneindex-field_60afe3e731739" max="100" min="0" name="acf[field_60afe3a831738][acfcloneindex][field_60afe3e731739]" step="any" type="number" placeholder="<?php echo esc_html_e( 'Low', 'king' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-number acf-field-60afe4a33173a" data-key="field_60afe4a33173a" data-name="result_range_high" data-type="number" data-width="15" style="width:15%;">
						<div class="acf-input">
							<div class="acf-input-append">
								%
							</div>
							<div class="acf-input-wrap">
								<input class="acf-is-appended" disabled="" id="acf-field_60afe3a831738-acfcloneindex-field_60afe4a33173a" max="100" min="0" name="acf[field_60afe3a831738][acfcloneindex][field_60afe4a33173a]" step="any" type="number" placeholder="<?php echo esc_html_e( 'High', 'king' ); ?>"/>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-text acf-field-60afe5223173b -collapsed-target" data-key="field_60afe5223173b" data-name="quiz_result" data-type="text" data-width="70" style="width:70%;">
						<div class="acf-input">
							<div class="acf-input-wrap">
								<input disabled="" id="acf-field_60afe3a831738-acfcloneindex-field_60afe5223173b" name="acf[field_60afe3a831738][acfcloneindex][field_60afe5223173b]" type="text"/>
							</div>
						</div>
					</div>
					<div class="acf-field acf-field-image acf-field-60afe54d3173c" data-key="field_60afe54d3173c" data-name="quiz_result_image" data-type="image">
						<div class="acf-input">
							<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif," data-preview_size="thumbnail" data-uploader="wp">
								<input disabled="" name="acf[field_60afe3a831738][acfcloneindex][field_60afe54d3173c]" type="hidden" value="">
								<div class="show-if-value image-wrap" style="max-width: 150px">
									<img alt="" data-name="image" src="" style="max-height: 150px;">
									<div class="acf-actions -hover">
										<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php echo esc_html_e( 'Edit', 'king' ); ?>">
										</a>
										<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php echo esc_html_e( 'Remove', 'king' ); ?>">
										</a>
									</div>
								</img>
							</div>
							<div class="hide-if-value">
								<p>
									<a class="acf-button button" data-name="add" href="#">
										<?php echo esc_html_e( 'Add Image', 'king' ); ?>
									</a>
								</p>
							</div>
						</input>
					</div>
				</div>
			</div>
			<div class="acf-field acf-field-textarea acf-field-60afe5933173d" data-key="field_60afe5933173d" data-name="quiz_result_description" data-type="textarea">
				<div class="acf-input">
					<textarea disabled="" id="acf-field_60afe3a831738-acfcloneindex-field_60afe5933173d" maxlength="800" name="acf[field_60afe3a831738][acfcloneindex][field_60afe5933173d]" rows="6"></textarea>
				</div>
			</div>
		</td>
	</tr>
</tbody>
</table>
<div class="acf-actions">
	<a class="acf-button button button-primary" data-event="add-row" href="#">
		<i class="fas fa-plus"></i>
	</a>
</div>
</input>
</div>
</div>
</div>
</div>