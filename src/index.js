import { addFilter } from "@wordpress/hooks";
import { createHigherOrderComponent } from "@wordpress/compose";

import {
	SelectControl,
	CheckboxControl,
	PanelBody,
	PanelRow,
	__experimentalVStack as VStack,
} from "@wordpress/components";
import { InspectorControls } from "@wordpress/block-editor";
import { __ } from "@wordpress/i18n";

import classnames from "classnames";

import "./style.scss";

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
				type: setting.multiple ? "array" : "string",
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
			<PanelBody
				title={__("Block Settings")}
				className="wpdev-block-settings-panel"
			>
				{blockSettings.map((setting) => {
					return (
						<PanelRow key={setting.attribute}>
							{!setting.multiple && (
								<SelectControl
									label={setting.label}
									className="wpdev-block-settings-panel__select"
									value={props.attributes[setting.attribute]}
									options={setting.options}
									onChange={(value) => {
										props.setAttributes({
											[setting.attribute]: value,
										});
									}}
									help={setting.help}
								/>
							)}
							{setting.multiple && (
								<>
									<VStack spacing={0}>
										<label className="wpdev-block-settings-panel__label">
											{setting.label}
										</label>
										{setting.options.map((option) => {
											return (
												<CheckboxControl
													key={option.value}
													label={option.label}
													checked={props.attributes[setting.attribute].includes(
														option.value,
													)}
													__nextHasNoMarginBottom
													onChange={(value) => {
														const currentValue =
															props.attributes[setting.attribute];
														const newValue = currentValue.includes(option.value)
															? currentValue.filter((v) => v !== option.value)
															: [...currentValue, option.value];

														props.setAttributes({
															[setting.attribute]: newValue,
														});
													}}
												/>
											);
										})}
										{setting.help && (
											<p className="wpdev-block-settings-panel__help">
												{setting.help}
											</p>
										)}
									</VStack>
								</>
							)}
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
		if (Array.isArray(attributes[setting.attribute])) {
			attributes[setting.attribute].forEach((value) => {
				classNames.push(value);
			});
		} else {
			classNames.push(attributes[setting.attribute]);
		}
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
