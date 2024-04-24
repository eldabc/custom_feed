<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://.com
 * @since      1.0.0
 *
 * @package    Custom_Feed
 * @subpackage Custom_Feed/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Custom_Feed
 * @subpackage Custom_Feed/includes
 * @author     Portl <@gmail.com>
 */
class Custom_Feed_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		global $wpdb;

			// Start transaction
			$wpdb->query('START TRANSACTION');
			try {

				$custom_feed_meta_table = "DROP TABLE IF EXISTS {$wpdb->prefix}custom_feed_meta";
				$wpdb->query($custom_feed_meta_table);

				$custom_feed_table = "DROP TABLE IF EXISTS {$wpdb->prefix}custom_feed";
				$wpdb->query($custom_feed_table);

				$wpdb->query('COMMIT');
				
			} catch (Exception $e) {
				$wpdb->query('ROLLBACK');
				echo "Error in transaction: " . $e->getMessage();
			}

	}

}
