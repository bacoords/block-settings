import { addFilter } from "@wordpress/hooks";
import { createHigherOrderComponent } from "@wordpress/compose";

import { SelectControl, PanelBody, PanelRow } from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

import classnames from "classnames";

/**
 * additional block attributes object
 */

console.log(wpdev_block_settings, wpdev_block_settings.settings);

const settingsArray = wpdev_block_settings.settings;

/**
 * Add attributes to the BlockType
 */

addFilter(
	"blocks.registerBlockType",
	"wpdev/block-settings/register-block-type",
	function (settings, name) {
		// Filter out blocks that are not in our settings array.
		const blockSettings = settingsArray.filter((setting) =>
			setting.blockTypes.includes(name),
		);

		if (!blockSettings.length) {
			return settings;
		}

		blockSettings.forEach((setting) => {
			settings.attributes[setting.attribute] = {
				type: "string",
				default: "",
			};
		});

		return settings;
	},
);

/**
 * Add user interface controls to the BlockEdit
 */
function Edit(props) {
	// Filter out blocks that are not in our settings array.
	const blockSettings = settingsArray.filter((setting) =>
		setting.blockTypes.includes(props.name),
	);

	if (!blockSettings.length) {
		return null;
	}

	return (
		<InspectorControls>
			<PanelBody title={__("Block Settings")}>
				{blockSettings.map((setting) => {
					return (
						<PanelRow key={setting.attribute}>
							<SelectControl
								label={setting.label}
								value={props.attributes[setting.attribute]}
								options={setting.options}
								onChange={(value) => {
									props.setAttributes({
										[setting.attribute]: value,
									});
								}}
							/>
						</PanelRow>
					);
				})}
			</PanelBody>
		</InspectorControls>
	);
}

addFilter(
	"editor.BlockEdit",
	"wpdev/block-settings/block-edit",
	createHigherOrderComponent((BlockEdit) => {
		return (props) => {
			return (
				<>
					<BlockEdit {...props} />
					{props.isSelected && <Edit {...props} />}
				</>
			);
		};
	}),
);

const classNameGenerator = (attributes, setting) => {
	const classNames = [];

	if (attributes[setting.attribute]) {
		classNames.push(attributes[setting.attribute]);
	}

	return classNames.join(" ");
};

/**
 * Add classnames to the Block Edit block markup
 */

const BlockList = createHigherOrderComponent((BlockList) => {
	return (props) => {
		const { name, attributes } = props;
		const { className } = props.attributes;

		// Filter out blocks that are not in our settings array.
		const blockSettings = settingsArray.filter((setting) =>
			setting.blockTypes.includes(name),
		);

		if (blockSettings.length > 0) {
			const newClassNames = blockSettings.map((setting) => {
				return classNameGenerator(attributes, setting);
			});
			const classNames = classnames(className, newClassNames);

			return <BlockList {...props} className={classNames} />;
		}
		return <BlockList {...props} />;
	};
});

addFilter(
	"editor.BlockListBlock",
	`wpdev/block-settings/block-list-block`,
	BlockList,
);

/**
 * Add classnames to the Block Save block markup
 */

const BlockSave = (props, block, attributes) => {
	const { className } = props;

	// Filter out blocks that are not in our settings array.
	const blockSettings = settingsArray.filter((setting) =>
		setting.blockTypes.includes(block.name),
	);

	if (blockSettings.length > 0) {
		const newClassNames = blockSettings.map((setting) => {
			return classNameGenerator(attributes, setting);
		});
		const classNames = classnames(className, newClassNames);

		return { ...props, className: classNames };
	}

	return props;
};

addFilter(
	"blocks.getSaveContent.extraProps",
	"wpdev/block-settings/block-save",
	BlockSave,
);
