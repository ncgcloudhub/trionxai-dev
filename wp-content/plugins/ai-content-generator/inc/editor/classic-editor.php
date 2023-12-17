<?php

/**
 * Generate HTML for classic editor from structure.
 *
 * @param array $structure Structure of the post.
 * @return string html of the post.
 */
function sage_ai_make_content_for_classic_editor( $structure ) {
	$complete_article = '';

	foreach ( $structure as $structure_item ) {
		switch ( $structure_item['type'] ) {
			case 'toc':
				$complete_article .= sage_ai_make_toc_for_classic_editor( $structure_item );
				break;
			case 'image':
				$complete_article .= sage_ai_make_image_for_classic_editor( $structure_item );
				break;
			default:
				$complete_article .= sage_ai_make_paragraphs_for_classic_editor( $structure_item );
		}
	}

	return $complete_article;
}

/**
 * Generate HTML for table of content.
 *
 * @param array $structure_item Table of content structure data.
 * @return string Table of content HTML.
 */
function sage_ai_make_toc_for_classic_editor( $structure_item ) {

	$toc_html = '<div class="wp_ai_content_toc">';
	$title    = $structure_item['title'];
	$style    = $structure_item['style'];
	$items    = $structure_item['items'];

	$ordered = false;
	if ( $style === 'numbered' ) {
		$ordered = true;
	}

	$toc_html .= '<h3>' . $title . '</h3>';

	$toc_html .= $ordered ? '<ol>' : '<ul>';

	foreach ( $structure_item['items'] as $item ) {
		$toc_html .= '<li> <a href="#' . $item['id'] . '">' . $item['anchorText'] . '</a> </li>';
	}

	$toc_html .= $ordered ? '</ol>' : '</ul>';
	$toc_html .= '</div>';

	return $toc_html;
}

/**
 * Image for post.
 *
 * @param array $structure_item Image Structure data of post.
 * @return string Image html.
 */
function sage_ai_make_image_for_classic_editor( $structure_item ) {

	$url        = $structure_item['text'];
	$alt        = $structure_item['alt'];
	$image_html = '<img src="' . $url . '" alt="' . $alt . '" style="max-width: 100%"/>';

	return $image_html;
}

/**
 * Article body of the post.
 *
 * @param array $structure_item article content structure data.
 * @return string Article body HTML.
 */
function sage_ai_make_paragraphs_for_classic_editor( $structure_item ) {

	$html_content = '';
	
	if ( ! empty( $structure_item['headingTag'] ) ) {

		$heading_tag   = $structure_item['headingTag'];

		$heading_text  = $structure_item['headingText'];

		$id            = preg_replace( '/\W/', '-', $heading_text );
		$id            = preg_replace( '/^\d+\s*/', '', $id ); // replace starting number if any
		$id            = strtolower( $id );
		$heading_level = 2;

		switch ( $heading_tag ) {
			case 'h1':
				$html_content .= '<h1 id="' . $id . '">' . $heading_text . '</h1>';
				break;
			case 'h2':
				$html_content .= '<h2 id="' . $id . '">' . $heading_text . '</h2>';
				break;
			case 'h3':
				$html_content .= '<h3 id="' . $id . '">' . $heading_text . '</h3>';
				break;
			case 'h4':
				$html_content .= '<h4 id="' . $id . '">' . $heading_text . '</h4>';
				break;
			case 'h5':
				$html_content .= '<h5 id="' . $id . '">' . $heading_text . '</h5>';
				break;
			case 'h6':
				$html_content .= '<h6 id="' . $id . '">' . $heading_text . '</h6>';
				break;
		}
	}

	$paragraph = $structure_item['text'];

	// look for list items (step 1: or 1.)
	$list_items = preg_replace( '/(step\s\d+:|\d+\.)\s/i', '<listItem>', $paragraph );

	$first_list_item_pos = strpos( $list_items, '<listItem>' );

	if ( $first_list_item_pos !== false ) {
		// text contains list items
		$text_items = explode( '<listItem>', $list_items );

		$text = '';
		if ( isset( $text_items[0] ) ) {
			// some intro paragraph before list begins
			$text .= '<p>' . $text_items[0] . '</p>';
			array_shift( $text_items ); // remove first para from textitems for further processing
		}

		$text .= '<ul>';
		foreach ( $text_items as $item ) {
			$text .= '<li>' . $item . '</li>';
		}
		$text .= '</ul>';

		$html_content .= $text;
	} else {
		$html_content .= '<p>' . $paragraph . '</p>';
	}

	return $html_content;
}
