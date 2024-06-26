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
			'attribute'  => 'prefixButtonLink',
			'blockTypes' => array( 'core/button' ),
			'label'      => 'Select Button Link Type',
			'multiple'   => false, // Will render as a `checkbox` and store attributes as an array.
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'prefix-link-cta', // the value that will be saved in the block AND added as a class.
					'label' => 'Global CTA Link',
				),
				array(
					'value' => 'prefix-link-subscripe',
					'label' => 'Trigger Subscription Modal',
				),
			),
			'help'       => 'This will add a class to the button that can be used to style it.',
		),
	);

	// Register a setting for the Columns block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixColumnMobileFlexOrder',
			'blockTypes' => array( 'core/column' ),
			'label'      => 'Mobile Flex Order',
			'multiple'   => false, // Will render as a `select` and store attribute as a string. Needs a 'null' option.
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'flex-order-1',
					'label' => '1',
				),
				array(
					'value' => 'flex-order-2',
					'label' => '2',
				),
				array(
					'value' => 'flex-order-3',
					'label' => '3',
				),
			),
			'help'       => 'This will add a class to the button that can be used to style it.',
		),
	);
	// Register a setting for the Columns block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixColumnDesktopFlexOrder',
			'blockTypes' => array( 'core/column' ),
			'label'      => 'Desktop Flex Order',
			'multiple'   => false, // Will render as a `select` and store attribute as a string. Needs a 'null' option.
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'flex-order-1',
					'label' => '1',
				),
				array(
					'value' => 'flex-order-2',
					'label' => '2',
				),
				array(
					'value' => 'flex-order-3',
					'label' => '3',
				),
			),
		),
	);
}
add_action( 'init', 'wpdev_example_function_registering_block_settings' );
