<?php
/**
 * Block Settings
 *
 * @package wpdev
 */

/**
 * Enqueue Block Settings
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

	wp_enqueue_style(
		'wpdev-block-settings',
		WPDEV_BLOCK_SETTINGS_URL . '/build/style-index.css',
		array(),
		$asset_file['version']
	);
}
add_action( 'enqueue_block_editor_assets', 'wpdev_block_settings_enqueue' );



/**
 * Register Block Settings
 *
 * @param array $new_settings  The settings array.
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


/**
 * Add default settings to block settings.
 *
 * @param array $settings The block settings.
 * @return array
 */
function wpdev_add_defaults_to_block_settings( $settings ) {
	$default_settings = array(
		'attribute'  => '',
		'blockTypes' => array(),
		'label'      => '',
		'multiple'   => false,
		'options'    => array(),
		'field'      => 'select', // Not functional yet.
		'help'       => '',
	);

	if ( $default_settings['multiple'] && 'select' === $default_settings['field'] ) {
		$default_settings['field'] = 'checkbox';
	}

	foreach ( $settings as $key => $setting ) {
		$settings[ $key ] = wp_parse_args( $setting, $default_settings );
	}

	return $settings;
}
add_filter( 'wpdev_block_settings', 'wpdev_add_defaults_to_block_settings', 99 );
