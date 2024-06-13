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

// To be removed.
require_once WPDEV_BLOCK_SETTINGS_PATH . '/inc/example.php';
