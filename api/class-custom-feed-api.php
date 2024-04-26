<?php

class Custom_Feed_Api extends WP_REST_Controller
{
    	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    protected $namespace =  'feed/v1';

    protected $rest_base = 'feed';



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    function register_routes()
    {
		register_rest_route($this->namespace, '/' . $this->rest_base . '/', array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array($this, 'add_items'),
                'permission_callback' => '__return_true'
            )
        ));

        register_rest_route($this->namespace, '/' . $this->rest_base . '/', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array($this, 'get_items'),
                'permission_callback' => array($this, 'hola')
            )
        ));
    }

    function hola($request) {
        return true;
    }

	function add_items($request)
    {
        global $wpdb;

			// Start transaction
			$wpdb->query('START TRANSACTION');

			try {
				$wpdb->insert($wpdb->prefix . 'custom_feed', $request['custom_feed']);
				$custom_feed_id = $wpdb->insert_id;
				
				if ($custom_feed_id === false) {
					throw new Exception('Error inserting data in wp_custom_feed.');
				}

				$custom_feed_meta_data = $request['custom_feed_meta'];

				foreach ($custom_feed_meta_data as $feed_meta_data) {
					
					$feed_meta_data['activity_id'] = $custom_feed_id;

					$wpdb->insert($wpdb->prefix . 'custom_feed_meta', $feed_meta_data);
				
					if ($wpdb->insert_id === false) {
						throw new Exception('Error inserting data in wp_custom_feed_meta.');
					}
				
				}

				$wpdb->query('COMMIT');
				$inserted_feed = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}custom_feed WHERE id = $custom_feed_id");
				$inserted_meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}custom_feed_meta WHERE activity_id = $custom_feed_id");
				
				$response_add = new WP_REST_Response();
				$response_add->set_data([
					"custom_feed" => $inserted_feed,
					"custom_feed_meta" => $inserted_meta,
					"messagge" => "Successful registration"
				]);
				
				return $response_add;

			} catch (Exception $e) {

				$wpdb->query('ROLLBACK');
				$response = new WP_REST_Response();
				return $response->set_data([ "error" => $e->getMessage() ]);
			}
    }

    function get_items($request)
    {
        
        $response = new WP_REST_Response();
        $response->set_data([
			"saludo" => "holaaa",
        ]);
        
        return $response;
    }


}
