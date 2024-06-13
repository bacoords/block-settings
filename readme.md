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

If you set `multiple` to true, your options will be rendered as checkboxes instead of a select dropdown. The selected values will be saved as an array in the block's JSON data:

```json
{
	"prefixButtonStyle": [ "block-style-outline", "block-style-solid" ]
}
```

This is also useful even if there's only one option but you want a checkbox/boolean behavior.


## Potential next steps...

- Support for more field types or at least a multiselect
- optional render_block attribute to modify the block
- some sort of register_block_style support or inline CSS built in
