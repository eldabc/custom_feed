<?php

/**
 * @since             1.0.0
 * @package           Custom_Feed
 *
 * @wordpress-plugin
 * Plugin Name:       custom-feed
 * Plugin URI:        https://custom-feed.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Portl
 * Author URI:        https://.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_FEED_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-feed-activator.php
 */
function activate_custom_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-feed-activator.php';
	Custom_Feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-feed-deactivator.php
 */
function deactivate_custom_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-feed-deactivator.php';
	Custom_Feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_feed' );
register_deactivation_hook( __FILE__, 'deactivate_custom_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_feed() {

	$plugin = new Custom_Feed();
	$plugin->run();

}
run_custom_feed();
