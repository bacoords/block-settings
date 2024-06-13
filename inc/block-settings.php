<?php


/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function wpdev_block_settings_enqueue() {
	$asset_file = include WPDEV_BLOCK_SETTINGS_PATH . '/build/index.asset.php';

	wp_register_script(
		'wpdev-block-settings',
		WPDEV_BLOCK_SETTINGS_URL . '/build/index.js',
		$asset_file['dependencies'],
		$asset_file['version'],
		true
	);

	wp_localize_script(
		'wpdev-block-settings',
		'wpdev_block_settings',
		array(
			'settings' => apply_filters( 'wpdev_block_settings', array() ),
		)
	);

	wp_enqueue_script( 'wpdev-block-settings' );
}
add_action( 'enqueue_block_editor_assets', 'wpdev_block_settings_enqueue' );



/**
 * Register Block Settings
 *
 * @param array $settings_array
 * @return void
 */
function wpdev_register_block_setting( $new_settings ) {

	add_filter(
		'wpdev_block_settings',
		function ( $settings ) use ( $new_settings ) {
			$settings[] = $new_settings;
			return $settings;
		}
	);
}
