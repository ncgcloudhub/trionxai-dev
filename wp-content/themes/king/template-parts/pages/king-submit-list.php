<?php
/**
 * The template for membership.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="acf-field acf-field-repeater acf-field-58bddb0df74fe king-repeater king-submit-video" data-key="field_58bddb0df74fe" data-name="news_list_items" data-type="repeater">
	<div class="acf-input">
		<div class="acf-repeater -block" data-max="80" data-min="1">
			<input name="acf[field_58bddb0df74fe]" type="hidden" value="">
				<table class="acf-table">
					<tbody class="ui-sortable">
						<tr class="acf-row" data-id="row-0">
							<td class="acf-row-handle order ui-sortable-handle" title="<?php esc_html_e( 'Drag to reorder', 'king' ); ?>">
								<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php esc_html_e( 'Click to toggle', 'king' ); ?>">
								</a>
								<span>
									1
								</span>
								<div class="acf-row-handle remove">
									<a class="acf-icon -plus small acf-js-tooltip hide-on-shift" data-event="add-row" href="#" title="<?php esc_html_e( 'Add', 'king' ); ?>">
									</a>
									<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php esc_html_e( 'Remove', 'king' ); ?>">
									</a>
								</div>
							</td>
							<td class="acf-fields">
								<div class="acf-field acf-field-text acf-field-58bddb31f74ff -collapsed-target" data-key="field_58bddb31f74ff" data-name="news_list_title" data-type="text">
									<div class="acf-input">
										<div class="acf-input-wrap">
											<input id="acf-field_58bddb0df74fe-row-0-field_58bddb31f74ff" name="acf[field_58bddb0df74fe][row-0][field_58bddb31f74ff]" type="text" placeholder="<?php esc_html_e( 'title', 'king' ); ?>" />
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-true-false acf-field-58bddb5ef7500" data-key="field_58bddb5ef7500" data-name="news_image_or_video" data-type="true_false">
									<div class="acf-input">
										<div class="acf-true-false">
											<input name="acf[field_58bddb0df74fe][row-0][field_58bddb5ef7500]" type="hidden" value="0">
												<label>
													<input autocomplete="off" class="acf-switch-input" id="acf-field_58bddb0df74fe-row-0-field_58bddb5ef7500" name="acf[field_58bddb0df74fe][row-0][field_58bddb5ef7500]" type="checkbox" value="1">
														<div class="acf-switch">
															<span class="acf-switch-on" style="min-width: 35.725px;">
																<?php esc_html_e( 'Image ', 'king' ); ?>
															</span>
															<span class="acf-switch-off" style="min-width: 35.725px;">
																<?php esc_html_e( 'Video ', 'king' ); ?>
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
								<div class="acf-field acf-field-image acf-field-58bddb82f7501" data-conditions='[[{"field":"field_58bddb5ef7500","operator":"!=","value":"1"}]]' data-key="field_58bddb82f7501" data-name="news_list_image" data-type="image">
									<div class="acf-input">
										<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif" data-preview_size="medium" data-uploader="wp">
											<input name="acf[field_58bddb0df74fe][row-0][field_58bddb82f7501]" type="hidden" value="">
												<div class="show-if-value image-wrap" style="max-width: 300px">
													<img alt="" data-name="image" src="" style="max-height: 100%;">
														<div class="acf-actions -hover">
															<a class="acf-icon -pencil dark" data-name="edit" href="#">
															</a>
															<a class="acf-icon -cancel dark" data-name="remove" href="#">
															</a>
														</div>
													</img>
												</div>
												<div class="hide-if-value">
													<p>
														<a class="acf-button button" data-name="add" href="#">
															<?php esc_html_e( 'Add Image ', 'king' ); ?>
														</a>
													</p>
												</div>
											</input>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-oembed acf-field-58bddbb9f7502 acf-hidden" data-conditions='[[{"field":"field_58bddb5ef7500","operator":"==","value":"1"}]]' data-key="field_58bddbb9f7502" data-name="news_list_media" data-type="oembed" hidden="">
									<div class="acf-input">
										<div class="acf-oembed">
											<input class="input-value" disabled="" name="acf[field_58bddb0df74fe][row-0][field_58bddbb9f7502]" type="hidden" value="">
												<div class="title">
													<input autocomplete="off" class="input-search" placeholder="<?php esc_html_e( 'Enter URL', 'king' ); ?>" type="text" value="">
														<div class="acf-actions -hover">
															<a class="acf-icon -cancel grey" data-name="clear-button" href="#">
															</a>
														</div>
													</input>
												</div>
												<div class="canvas">
													<div class="canvas-media">
													</div>
												</div>
											</input>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-textarea acf-field-58bddbd2f7503" data-key="field_58bddbd2f7503" data-name="news_list_content" data-type="textarea">
									<div class="acf-input">
										<textarea id="acf-field_58bddb0df74fe-row-0-field_58bddbd2f7503" name="acf[field_58bddb0df74fe][row-0][field_58bddbd2f7503]" rows="8" placeholder="<?php esc_html_e( 'description', 'king' ); ?>" data-ms-editor="true"></textarea>
									</div>
								</div>
							</td>
						</tr>
						<tr class="acf-row acf-clone" data-id="acfcloneindex" style="">
							<td class="acf-row-handle order ui-sortable-handle" title="Drag to reorder">
								<a class="acf-icon -collapse small" data-event="collapse-row" href="#" title="<?php esc_html_e( 'Click to toggle', 'king' ); ?>">
								</a>
								<span>
									1
								</span>
								<div class="acf-row-handle remove">
									<a class="acf-icon -plus small acf-js-tooltip hide-on-shift" data-event="add-row" href="#" title="<?php esc_html_e( 'Add', 'king' ); ?>">
									</a>
									<a class="acf-icon -minus small acf-js-tooltip" data-event="remove-row" href="#" title="<?php esc_html_e( 'Remove', 'king' ); ?>">
									</a>
								</div>
							</td>
							<td class="acf-fields">
								<div class="acf-field acf-field-text acf-field-58bddb31f74ff -collapsed-target" data-key="field_58bddb31f74ff" data-name="news_list_title" data-type="text">
									<div class="acf-input">
										<div class="acf-input-wrap">
											<input disabled="" id="acf-field_58bddb0df74fe-acfcloneindex-field_58bddb31f74ff" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddb31f74ff]" type="text" placeholder="<?php esc_html_e( 'title', 'king' ); ?>"/>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-true-false acf-field-58bddb5ef7500" data-key="field_58bddb5ef7500" data-name="news_image_or_video" data-type="true_false">
									<div class="acf-input">
										<div class="acf-true-false">
											<input disabled="" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddb5ef7500]" type="hidden" value="0">
												<label>
													<input autocomplete="off" class="acf-switch-input" disabled="" id="acf-field_58bddb0df74fe-acfcloneindex-field_58bddb5ef7500" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddb5ef7500]" type="checkbox" value="1">
														<div class="acf-switch">
															<span class="acf-switch-on">
																<?php esc_html_e( 'Image', 'king' ); ?>
															</span>
															<span class="acf-switch-off">
																<?php esc_html_e( 'Video', 'king' ); ?>
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
								<div class="acf-field acf-field-image acf-field-58bddb82f7501" data-conditions='[[{"field":"field_58bddb5ef7500","operator":"!=","value":"1"}]]' data-key="field_58bddb82f7501" data-name="news_list_image" data-type="image">
									<div class="acf-input">
										<div class="acf-image-uploader" data-library="uploadedTo" data-mime_types="jpg, jpeg, png, gif" data-preview_size="medium" data-uploader="wp">
											<input disabled="" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddb82f7501]" type="hidden" value="">
												<div class="show-if-value image-wrap" style="max-width: 300px">
													<img alt="" data-name="image" src="" style="max-height: 100%;">
														<div class="acf-actions -hover">
															<a class="acf-icon -pencil dark" data-name="edit" href="#" title="<?php esc_html_e( 'Edit', 'king' ); ?>">
															</a>
															<a class="acf-icon -cancel dark" data-name="remove" href="#" title="<?php esc_html_e( 'Remove', 'king' ); ?>">
															</a>
														</div>
													</img>
												</div>
												<div class="hide-if-value">
													<p>
														<a class="acf-button button" data-name="add" href="#">
															<?php esc_html_e( 'Add Image', 'king' ); ?>
														</a>
													</p>
												</div>
											</input>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-oembed acf-field-58bddbb9f7502" data-conditions='[[{"field":"field_58bddb5ef7500","operator":"==","value":"1"}]]' data-key="field_58bddbb9f7502" data-name="news_list_media" data-type="oembed">
									<div class="acf-input">
										<div class="acf-oembed">
											<input class="input-value" disabled="" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddbb9f7502]" type="hidden" value="">
												<div class="title">
													<input autocomplete="off" class="input-search" placeholder="<?php esc_html_e( 'Enter URL', 'king' ); ?>" type="text" value="">
														<div class="acf-actions -hover">
															<a class="acf-icon -cancel grey" data-name="clear-button" href="#">
															</a>
														</div>
													</input>
												</div>
												<div class="canvas">
													<div class="canvas-media">
													</div>
												</div>
											</input>
										</div>
									</div>
								</div>
								<div class="acf-field acf-field-textarea acf-field-58bddbd2f7503" data-key="field_58bddbd2f7503" data-name="news_list_content" data-type="textarea">
									<div class="acf-input">
										<textarea disabled="" id="acf-field_58bddb0df74fe-acfcloneindex-field_58bddbd2f7503" name="acf[field_58bddb0df74fe][acfcloneindex][field_58bddbd2f7503]" rows="8" placeholder="<?php esc_html_e( 'description', 'king' ); ?>" data-ms-editor="true"></textarea>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="acf-actions">
					<a class="acf-button button button-primary" data-event="add-row" href="#">
						<i class="fas fa-plus">
						</i>
					</a>
				</div>
			</input>
		</div>
	</div>
</div>