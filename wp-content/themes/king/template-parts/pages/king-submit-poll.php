<?php
/**
 * The template for submit poll.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="acf-field acf-field-repeater acf-field-609eb497417b5 king-repeater" data-key="field_609eb497417b5" data-name="king_poll" data-type="repeater">
	<div class="acf-input">
		<div class="acf-repeater -block" data-max="50" data-min="1">
			<input name="acf[field_609eb497417b5]" type="hidden" value="">
				<table class="acf-table">
					<tbody class="ui-sortable">
						<tr class="acf-row" data-id="row-0">
							<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
								<a class="acf-icon -collapse acf-js-tooltip small" data-event="collapse-row" href="#" title="Click to toggle">
								</a>
								<span>
									1
								</span>
								<div class="acf-row-handle remove">
									<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
									</a>
								</div>
							</td>
							<td class="acf-fields">
								<div class="acf-field acf-field-text acf-field-609eb5aa417b7 -collapsed-target" data-conditions='[[{"field":"field_609eb628417b8","operator":"!=","value":"1"}]]' data-key="field_609eb5aa417b7" data-name="poll_title" data-type="text">
									<div class="acf-input">
										<div class="acf-input-wrap">
											<input id="acf-field_609eb497417b5-row-0-field_609eb5aa417b7" maxlength="400" name="acf[field_609eb497417b5][row-0][field_609eb5aa417b7]" placeholder="<?php echo esc_html_e( 'question', 'king' ); ?>" type="text"/>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-true-false acf-field-609eb628417b8 acf-hidden" data-conditions='[[{"field":"field_60a001af265bf","operator":"!=empty"}]]' data-key="field_609eb628417b8" data-name="hide_poll_title" data-type="true_false" hidden="">
									<div class="acf-input">
										<div class="acf-true-false">
											<input disabled="" name="acf[field_609eb497417b5][row-0][field_609eb628417b8]" type="hidden" value="0">
												<label>
													<input autocomplete="off" class="acf-switch-input" disabled="" id="acf-field_609eb497417b5-row-0-field_609eb628417b8" name="acf[field_609eb497417b5][row-0][field_609eb628417b8]" type="checkbox" value="1">
														<div class="acf-switch">
															<span class="acf-switch-on acf-js-tooltip" title="<?php echo esc_html_e( 'show question title', 'king' ); ?>">
																<i class="fas fa-heading">
																</i>
															</span>
															<span class="acf-switch-off acf-js-tooltip" title="<?php echo esc_html_e( 'hide question title', 'king' ); ?>">
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
								<div class="acf-field acf-field-image acf-field-60a001af265bf" data-key="field_60a001af265bf" data-name="poll_image" data-type="image">
									<div class="acf-input">
										<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
											<input name="acf[field_609eb497417b5][row-0][field_60a001af265bf]" type="hidden" value="">
												<div class="show-if-value image-wrap" style="max-width: 150px">
													<img alt="" data-name="image" src="" style="max-height: 150px;">
														<div class="acf-actions -hover">
															<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
															</a>
															<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
								<div class="acf-field acf-field-radio acf-field-609eb66c417b9 poll-radio -c0" data-key="field_609eb66c417b9" data-name="poll_answers_style" data-type="radio">
									<div class="acf-input">
										<input name="acf[field_609eb497417b5][row-0][field_609eb66c417b9]" type="hidden">
											<ul class="acf-radio-list acf-hl" data-allow_null="0" data-other_choice="0">
												<li>
													<label class="selected">
														<input checked="checked" class="hide" id="acf-field_609eb497417b5-row-0-field_609eb66c417b9-pollgrid-1" name="acf[field_609eb497417b5][row-0][field_609eb66c417b9]" type="radio" value="pollgrid-1">
															<i class="fas fa-bars"></i>
														</input>
													</label>
												</li>
												<li>
													<label>
														<input class="hide" id="acf-field_609eb497417b5-row-0-field_609eb66c417b9-pollgrid-2" name="acf[field_609eb497417b5][row-0][field_609eb66c417b9]" type="radio" value="pollgrid-2">
															<i class="fas fa-th-large"></i>
														</input>
													</label>
												</li>
												<li>
													<label>
														<input class="hide" id="acf-field_609eb497417b5-row-0-field_609eb66c417b9-pollgrid-3" name="acf[field_609eb497417b5][row-0][field_609eb66c417b9]" type="radio" value="pollgrid-3">
															<i class="fas fa-grip-horizontal"></i>
														</input>
													</label>
												</li>
											</ul>
										</input>
									</div>
								</div>
								<div class="acf-field acf-field-repeater acf-field-609ebc61fab81 dflex" data-key="field_609ebc61fab81" data-name="poll_grid_answers" data-type="repeater" data-width="100" style="	width:100%; min-height: 278px;">
									<div class="acf-input">
										<div class="acf-repeater -block" data-max="20" data-min="2">
											<input name="acf[field_609eb497417b5][row-0][field_609ebc61fab81]" type="hidden" value="">
												<table class="acf-table">
													<tbody class="ui-sortable">
														<tr class="acf-row" data-id="row-0">
															<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
																<span>
																	1
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82 acf-hidden" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image" hidden="">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][row-0][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input id="acf-field_609eb497417b5-row-0-field_609ebc61fab81-row-0-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][row-0][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														<tr class="acf-row" data-id="row-1">
															<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
																<span>
																	2
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82 acf-hidden" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image" hidden="">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][row-1][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input id="acf-field_609eb497417b5-row-0-field_609ebc61fab81-row-1-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][row-1][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														<tr class="acf-row acf-clone" data-id="acfcloneindex" style="">
															<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
																<span>
																	1
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][acfcloneindex][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input disabled="" id="acf-field_609eb497417b5-row-0-field_609ebc61fab81-acfcloneindex-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][row-0][field_609ebc61fab81][acfcloneindex][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'answer', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
												<div class="acf-actions">
													<a class="acf-button button button-primary acf-js-tooltip" data-event="add-row" href="#" title="<?php echo esc_html_e( 'Add Answer', 'king' ); ?>">
														<i class="fas fa-plus"></i>
													</a>
												</div>
											</input>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr class="acf-row acf-clone" data-id="acfcloneindex" style="">
							<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
								<a class="acf-icon -collapse small acf-js-tooltip" data-event="collapse-row" href="#" title="Click to toggle">
								</a>
								<span>
									1
								</span>
								<div class="acf-row-handle remove">
									<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
									</a>
								</div>
							</td>
							<td class="acf-fields">
								<div class="acf-field acf-field-text acf-field-609eb5aa417b7 -collapsed-target" data-conditions='[[{"field":"field_609eb628417b8","operator":"!=","value":"1"}]]' data-key="field_609eb5aa417b7" data-name="poll_title" data-type="text">
									<div class="acf-input">
										<div class="acf-input-wrap">
											<input disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609eb5aa417b7" maxlength="400" name="acf[field_609eb497417b5][acfcloneindex][field_609eb5aa417b7]" placeholder="<?php echo esc_html_e( 'question', 'king' ); ?>" type="text"/>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-true-false acf-field-609eb628417b8" data-conditions='[[{"field":"field_60a001af265bf","operator":"!=empty"}]]' data-key="field_609eb628417b8" data-name="hide_poll_title" data-type="true_false">
									<div class="acf-input">
										<div class="acf-true-false">
											<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609eb628417b8]" type="hidden" value="0">
												<label>
													<input autocomplete="off" class="acf-switch-input" disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609eb628417b8" name="acf[field_609eb497417b5][acfcloneindex][field_609eb628417b8]" type="checkbox" value="1">
														<div class="acf-switch">
															<span class="acf-switch-on acf-js-tooltip" title="<?php echo esc_html_e( 'show question title', 'king' ); ?>">
																<i class="fas fa-heading">
																</i>
															</span>
															<span class="acf-switch-off acf-js-tooltip" title="<?php echo esc_html_e( 'hide question title', 'king' ); ?>">
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
								<div class="acf-field acf-field-image acf-field-60a001af265bf" data-key="field_60a001af265bf" data-name="poll_image" data-type="image">
									<div class="acf-input">
										<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
											<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_60a001af265bf]" type="hidden" value="">
												<div class="show-if-value image-wrap" style="max-width: 150px">
													<img alt="" data-name="image" src="" style="max-height: 150px;">
														<div class="acf-actions -hover">
															<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
															</a>
															<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
								<div class="acf-field acf-field-radio acf-field-609eb66c417b9 poll-radio" data-key="field_609eb66c417b9" data-name="poll_answers_style" data-type="radio">
									<div class="acf-input">
										<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609eb66c417b9]" type="hidden">
											<ul class="acf-radio-list acf-hl" data-allow_null="0" data-other_choice="0">
												<li>
													<label class="selected">
														<input checked="checked" class="hide" disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609eb66c417b9-pollgrid-1" name="acf[field_609eb497417b5][acfcloneindex][field_609eb66c417b9]" type="radio" value="pollgrid-1">
															<i class="fas fa-bars"></i>
														</input>
													</label>
												</li>
												<li>
													<label>
														<input class="hide" disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609eb66c417b9-pollgrid-2" name="acf[field_609eb497417b5][acfcloneindex][field_609eb66c417b9]" type="radio" value="pollgrid-2">
															<i class="fas fa-th-large"></i>
														</input>
													</label>
												</li>
												<li>
													<label>
														<input class="hide" disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609eb66c417b9-pollgrid-3" name="acf[field_609eb497417b5][acfcloneindex][field_609eb66c417b9]" type="radio" value="pollgrid-3">
															<i class="fas fa-grip-horizontal"></i>
														</input>
													</label>
												</li>
											</ul>
										</input>
									</div>
								</div>
								<div class="acf-field acf-field-repeater acf-field-609ebc61fab81 dflex" data-key="field_609ebc61fab81" data-name="poll_grid_answers" data-type="repeater" style="width:100%;">
									<div class="acf-input">
										<div class="acf-repeater -empty -block" data-max="20" data-min="2">
											<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81]" type="hidden" value="">
												<table class="acf-table">
													<tbody>
														<tr class="acf-row" data-id="row-0">
															<td class="acf-row-handle order" title="Drag to reorder">
																<span>
																	1
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][row-0][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609ebc61fab81-row-0-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][row-0][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'question', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														<tr class="acf-row" data-id="row-1">
															<td class="acf-row-handle order" title="Drag to reorder">
																<span>
																	2
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][row-1][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609ebc61fab81-row-1-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][row-1][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'question', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
														<tr class="acf-row acf-clone" data-id="acfcloneindex">
															<td class="acf-row-handle order" title="Drag to reorder">
																<span>
																	1
																</span>
																<div class="acf-row-handle remove">
																	<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="Remove row">
																	</a>
																</div>
															</td>
															<td class="acf-fields">
																<div class="acf-field acf-field-image acf-field-609ebc62fab82" data-conditions='[[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-2"}],[{"field":"field_609eb66c417b9","operator":"==","value":"pollgrid-3"}]]' data-key="field_609ebc62fab82" data-name="poll_answer_image" data-type="image">
																	<div class="acf-input">
																		<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="" data-preview_size="thumbnail" data-uploader="wp">
																			<input disabled="" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][acfcloneindex][field_609ebc62fab82]" type="hidden" value="">
																				<div class="show-if-value image-wrap" style="max-width: 150px">
																					<img alt="" data-name="image" src="" style="max-height: 150px;">
																						<div class="acf-actions -hover">
																							<a class="acf-icon -pencil dark" data-name="edit" href="#" title="Edit">
																							</a>
																							<a class="acf-icon -cancel dark" data-name="remove" href="#" title="Remove">
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
																<div class="acf-field acf-field-text acf-field-609ebc62fab83" data-key="field_609ebc62fab83" data-name="poll_answer" data-type="text">
																	<div class="acf-input">
																		<div class="acf-input-wrap">
																			<input disabled="" id="acf-field_609eb497417b5-acfcloneindex-field_609ebc61fab81-acfcloneindex-field_609ebc62fab83" maxlength="200" name="acf[field_609eb497417b5][acfcloneindex][field_609ebc61fab81][acfcloneindex][field_609ebc62fab83]" type="text" placeholder="<?php echo esc_html_e( 'question', 'king' ); ?>"/>
																		</div>
																	</div>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
												<div class="acf-actions">
													<a class="acf-button button button-primary acf-js-tooltip" data-event="add-row" href="#" title="<?php echo esc_html_e( 'Add Answer', 'king' ); ?>">
														<i class="fas fa-plus"></i>
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