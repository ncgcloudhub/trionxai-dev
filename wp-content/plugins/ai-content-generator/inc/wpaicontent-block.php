<?php


class Sage_AI_Core_Gen_Block {

	public function __construct() {

		add_action( 'init', array( $this, 'create_block_init' ) );
	}

	public function create_block_init() {
		register_block_type( WP_SAGE_AI_DIR . '/build' );
	}
}

new Sage_AI_Core_Gen_Block();
