<?php
namespace LifeJacket\Client;

/**
 * Main plugin class
 */
class Plugin {
	protected static $instance    = null;
	protected static $initialised = false;

	public static function get_instance( $init = true ) {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		if ( $init && ! self::$initialised ) {
			self::$instance->init();
			self::$initialised = true;
		}
		return self::$instance;
	}

	private function __construct() {}

	public $options;
	protected $settings;

	public function init() {
		add_filter( 'http_allowed_safe_ports', [ $this, 'maybe_allow_port' ] );
		add_filter( 'http_request_host_is_external', [ $this, 'maybe_allow_external_host' ], 10, 3 );
		add_filter( 'pre_http_request', [ $this, 'maybe_proxy_dotorg' ], 1, 3 );

		$this->options  = new Options();
		$this->settings = new Settings();
		$this->settings->init();
	}

	public function maybe_allow_port( $ports ) {
		$server = $this->options->get( 'server' );
		$port   = wp_parse_url( $server, PHP_URL_PORT );
		if ( null !== $port && ! in_array( $port, $ports, true ) ) {
			$ports[] = $port;
		}
		return $ports;
	}

	public function maybe_allow_external_host( $allow, $host, $url ) {
		$server = $this->options->get( 'server' );
		$server_host   = wp_parse_url( $server, PHP_URL_HOST );
		return $server_host === $host;
	}

	public function get_hostnames() {
		$server         = $this->options->get( 'server' );
		$api_slug       = $this->options->get( 'api_slug' );
		$downloads_slug = $this->options->get( 'downloads_slug' );
		$hostnames      = [
			'api.wordpress.org'       => $server . '/' . $api_slug,
			'downloads.wordpress.org' => $server . '/' . $downloads_slug,
		];
		$hostnames      = apply_filters( 'lifejacket/hostnames', $hostnames );
		return $hostnames;
	}

	public function maybe_proxy_dotorg( $response, $parsed_args, $url ) {
		$domain   = '';
		$endpoint = '';
		foreach ( $this->get_hostnames() as $hostname => $replacement ) {
			if ( 1 === preg_match( '|^https?://' . $hostname . '|ims', $url ) ) {
				$domain   = $hostname;
				$endpoint = $replacement;
				break;
			}
		}

		if ( $domain && $endpoint ) {
			if ( $this->options->get( 'require_auth' ) ) {
				$parsed_args['headers']                              = $parsed_args['headers'] ?? [];
				$parsed_args['headers']['X-WP-Application-Password'] = $this->options->get( 'application_password' );
			}
			$url                       = preg_replace( '|^https?://' . $domain . '|ims', $endpoint, $url );
			$parsed_args['user-agent'] = $this->process_user_agent( $parsed_args['user-agent'] ?? '' );
			$response                  = wp_remote_request( $url, $parsed_args );
		}

		return $response;
	}

	protected function process_user_agent( $user_agent ) {
		switch ( $this->options->get( 'telemetry' ) ) {
			case 'enabled':
				break;
			case 'anonymized':
				$user_agent    = explode( '; ', $user_agent );
				$user_agent[1] = md5( trailingslashit( $user_agent[1] ) ?? '' );
				$user_agent    = implode( '; ', $user_agent );
				break;
			case 'disabled':
			default:
				$user_agent    = explode( '; ', $user_agent );
				$user_agent[1] = 'n/a';
				$user_agent    = implode( '; ', $user_agent );
				break;
		}
		return $user_agent;
	}
}
