<?php
/**
 * Examples of registering block settings.
 *
 * @package wpdev
 */

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
			'multiple'   => true, // Will render as a `checkbox` and store attributes as an array.
			'options'    => array(
				array(
					'value' => 'block-style-outline', // the value that will be saved in the block AND added as a class.
					'label' => 'Outline',
				),
				array(
					'value' => 'block-style-solid',
					'label' => 'Solid',
				),
			),
		),
	);

	// Register a setting for the Columns block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixColumnMobileStyle',
			'blockTypes' => array( 'core/columns' ),
			'label'      => 'Mobile Column Style',
			'multiple'   => false, // Will render as a `select` and store attribute as a string. Needs a 'null' option.
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
		),
	);
}
add_action( 'init', 'wpdev_example_function_registering_block_settings' );
