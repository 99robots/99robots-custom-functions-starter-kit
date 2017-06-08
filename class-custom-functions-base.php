<?php
/**
 * The Base
 *
 * ALl the classes inherit from this class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Custom_Functions_Base {

	/**
	 * Add action
	 *
	 * @see add_action
	 */
	protected function add_action( $hook, $func, $priority = 10, $args = 1 ) {
		add_action( $hook, array( $this, $func ), $priority, $args );
	}

	/**
	 * Add filter
	 *
	 * @see add_filter
	 */
	protected function add_filter( $hook, $func, $priority = 10, $args = 1 ) {
		add_filter( $hook, array( $this, $func ), $priority, $args );
	}

	/**
	 * Add shortcode
	 *
	 * @see add_shortcode
	 */
	protected function add_shortcode( $tag, $func ) {
		add_shortcode( $tag, array( $this, $func ) );
	}

	/**
	 * Remove Action
	 *
	 * @see remove_action
	 */
	protected function remove_action( $hook, $func, $priority = 10, $args = 1 ) {
		remove_action( $hook, array( &$this, $func ), $priority, $args );
	}

	/**
	 * Remove filter
	 *
	 * @see remove_filter
	 */
	protected function remove_filter( $hook, $func, $priority = 10, $args = 1 ) {
		remove_filter( $hook, array( &$this, $func ), $priority, $args );
	}

	/**
	 * Inject config into class
	 *
	 * @param  array  $config
	 * @return void
	 */
	protected function config( $config = array() ) {

		// Check
		if ( empty( $config ) ) {
			return;
		}

		foreach ( $config as $key => $value ) {
			$this->$key = $value;
		}
	}
}
