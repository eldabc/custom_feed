<?php

/**
 * Fired during plugin activation
 *
 * @link       https://.com
 * @since      1.0.0
 *
 * @package    Custom_Feed
 * @subpackage Custom_Feed/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Custom_Feed
 * @subpackage Custom_Feed/includes
 * @author     Portl <@gmail.com>
 */
class Custom_Feed_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
			global $wpdb;

			// Start transaction
			$wpdb->query('START TRANSACTION');

			try {
				
				$custom_feed_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}custom_feed(
					`id` bigint(20) NOT NULL AUTO_INCREMENT,
					`user_id` bigint(20) NOT NULL,
					`component` varchar(75) NOT NULL,
					`type` varchar(75) NOT NULL,
					`action` text NOT NULL,
					`content` longtext NOT NULL,
					`primary_link` text NOT NULL,
					`item_id` bigint(20) NOT NULL,
					`secondary_item_id` bigint(20) DEFAULT NULL,
					`date_recorded` datetime NOT NULL,
					`hide_sitewide` tinyint(1) DEFAULT '0',
					`mptt_left` int(11) NOT NULL DEFAULT '0',
					`mptt_right` int(11) NOT NULL DEFAULT '0',
					`is_spam` tinyint(1) NOT NULL DEFAULT '0',
					`privacy` varchar(75) NOT NULL DEFAULT 'public',
					PRIMARY KEY (`id`),
					KEY `date_recorded` (`date_recorded`),
					KEY `user_id` (`user_id`),
					KEY `item_id` (`item_id`),
					KEY `secondary_item_id` (`secondary_item_id`),
					KEY `component` (`component`),
					KEY `type` (`type`),
					KEY `mptt_left` (`mptt_left`),
					KEY `mptt_right` (`mptt_right`),
					KEY `hide_sitewide` (`hide_sitewide`),
					KEY `is_spam` (`is_spam`)
				)";

				$wpdb->query($custom_feed_table);

				$custom_feed_meta_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}custom_feed_meta(
					`id` bigint(20) NOT NULL AUTO_INCREMENT,
					`activity_id` bigint(20) NOT NULL,
					`meta_key` varchar(255) DEFAULT NULL,
					`meta_value` longtext,
					PRIMARY KEY (`id`),
					KEY `activity_id` (`activity_id`),
					KEY `meta_key` (`meta_key`(191))
				)";

				$wpdb->query($custom_feed_meta_table);

				$wpdb->query('COMMIT');

			} catch (Exception $e) {
				$wpdb->query('ROLLBACK');
				
				echo "Error in transacción: " . $e->getMessage();
			}

	}

}
