<?php
namespace LifeJacket\Client;

class Settings {
	protected $rest_prefix = 'lifejacket-client/v1';

	public function init() {
		add_action( 'admin_menu', [ $this, 'register_menu' ] );
		add_action( 'rest_api_init', [ $this, 'register_rest' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );
	}

	public function register_menu() {
		add_options_page(
			__( 'LifeJacket Client', 'lifejacket' ),
			__( 'LifeJacket Client', 'lifejacket' ),
			'manage_options',
			'lifejacket-client',
			[ $this, 'render_settings' ]
		);
	}

	public function register_rest() {
		register_rest_route(
			$this->rest_prefix,
			'/settings',
			array(
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_options' ],
				'permission_callback' => [ $this, 'get_permissions' ],
			)
		);
		register_rest_route(
			$this->rest_prefix,
			'/settings',
			array(
				'methods'             => 'POST',
				'callback'            => [ $this, 'set_options' ],
				'permission_callback' => [ $this, 'get_permissions' ],
			)
		);
	}

	public function get_permissions() {
		return current_user_can( 'manage_options' );
	}

	public function get_options() {
		$option_names = [
			'server',
			'telemetry',
			'require_auth',
			'application_password',
			'api_slug',
			'downloads_slug',
		];
		$options      = [];
		$sources      = [];
		foreach ( $option_names as $name ) {
			$option           = Plugin::get_instance()->options->get_with_source( $name );
			$options[ $name ] = $option['value'];
			$sources[ $name ] = $option['source'];
		}
		$response = new \WP_REST_Response(
			[
				'values'  => $options,
				'sources' => $sources,
			]
		);
		return $response;
	}

	public function set_options( $request ) {
		$options = $request->get_json_params();
		update_option( 'lifejacket_client', $options );
		$response = new \WP_REST_Response( 'Data successfully added.', '200' );
		return $response;
	}

	public function admin_assets() {
		$asset = require_once LIFEJACKET_CLIENT_PLUGIN_PATH . '/build/index.asset.php';
		wp_register_script(
			'lifejacket-client-settings',
			LIFEJACKET_CLIENT_PLUGIN_URL . '/build/index.js',
			$asset['dependencies'],
			$asset['version'],
			true
		);
		wp_register_style(
			'lifejacket-client-settings',
			LIFEJACKET_CLIENT_PLUGIN_URL . '/build/index.css',
			[ 'wp-components' ],
			$asset['version']
		);
		// todo - conditionally load
		wp_enqueue_script( 'lifejacket-client-settings' );
		wp_enqueue_style( 'lifejacket-client-settings' );
	}

	public function render_settings() {
		echo '<div id="lifejacket-client-settings"></div>';
	}
}
