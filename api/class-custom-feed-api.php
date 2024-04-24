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
                'methods'             => 'GET',
                'callback'            => array($this, 'get_items'),
                'permission_callback' => array($this, 'hola')
            )
        ));
    }

    function hola($request) {
        return true;
    }

    function get_items($request)
    {
        
        $response = new WP_REST_Response();
        $response->set_data([
			"saludo" => "hola",
        ]);
        
        return $response;
    }


}
