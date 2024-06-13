# Block Settings

Proof of concept of a `register_block_setting()` function to quickly add settings fields to blocks with just PHP.

## Usage

```php
	// Register a "Button Style" setting for the Button block.
	wpdev_register_block_setting(
		array(
			'attribute'  => 'prefixButtonStyle',
			'blockTypes' => array( 'core/button' ),
			'label'      => 'Select Button Style',
			'multiple'   => false,
			'options'    => array(
				array(
					'value' => '',
					'label' => 'Default',
				),
				array(
					'value' => 'block-style-outline',
					'label' => 'Outline',
				),
				array(
					'value' => 'block-style-solid',
					'label' => 'Solid',
				),
			),
		),
	);
```
<img width="896" alt="Xnapper-2024-06-13-15 23 31" src="https://github.com/bacoords/block-settings/assets/6867360/5cdc6a92-4382-4c76-b132-5bf81bb8916d">

The selected value will be added as a className to the block and saved as an attribute in the block's JSON data:

```html
<div class="wp-block-button block-style-outline">
	...
</div>
```

```json
{
	"prefixButtonStyle": "block-style-outline"
}
```

## Multiple values support

If you set `multiple` to true, your options will be rendered as checkboxes instead of a select dropdown. 

<img width="928" alt="Xnapper-2024-06-13-15 23 54" src="https://github.com/bacoords/block-settings/assets/6867360/091a6089-a5a5-4e3e-bba1-55179872c668">

The selected values will be saved as an array in the block's JSON data:

```json
{
	"prefixButtonStyle": [ "block-style-outline", "block-style-solid" ]
}
```

This is also useful even if there's only one option but you want a checkbox/boolean behavior.


## Potential next steps...
- optional render_block attribute to enable modifying the block markup in one palce
- some sort of conditional register_block_style support or inline CSS built in?
