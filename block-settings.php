<?php
/**
 * Plugin Name:       Block Settings
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       block-settings
 *
 * @package           wpdev
 */


define( 'WPDEV_BLOCK_SETTINGS_VERSION', '0.1.0' );
define( 'WPDEV_BLOCK_SETTINGS_PATH', __DIR__ );
define( 'WPDEV_BLOCK_SETTINGS_URL', plugins_url( '', __FILE__ ) );

require_once WPDEV_BLOCK_SETTINGS_PATH . '/inc/block-settings.php';


/**
 * Examples of registering block settings.
 *
 * @return void
 */
function wpdev_example_function_registering_block_settings() {

	// Register a setting for the Button block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixButtonStyle',
			'blockTypes' => array( 'core/button' ),
			'label'      => 'Select Button Style',
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'block-style-outline', // the value that will be saved in the block AND added as a class.
					'label' => 'Outline',
				),
				array(
					'value' => 'block-style-solid',
					'label' => 'Solid',
				),
			),
			// render_block_callback?
			// register_block_styling?
			// field type?
		),
	);

	// Register a setting for the Columns block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixColumnMobileStyle',
			'blockTypes' => array( 'core/columns' ),
			'label'      => 'Mobile Column Style',
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'block-style-stacked',
					'label' => 'Stacked',
				),
				array(
					'value' => 'block-style-stacked-reverse',
					'label' => 'Stacked Reverse',
				),
			),
			// render_block_callback?
			// register_block_styling?
			// field type?
		),
	);
}
add_action( 'init', 'wpdev_example_function_registering_block_settings' );
