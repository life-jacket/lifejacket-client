<?php
namespace LifeJacket\Client;

class Plugin {
    protected static $instance = null;
    protected static $initialised = false;

    public static function get_instance( $init = true ) {
        if ( null == self::$instance ) {
            self::$instance = new self();
        }
        if ( $init && ! self::$initialised ) {
            self::$instance->init();
            self::$initialised = true;
        }
        return self::$instance;
    }

    private function __construct() {}

    protected $options = [
        'password' => 'G483 3CLL BlXt qpjc 4r5y Txcc',
        'require_auth' => true,
        'hostnames' => [
            'api.wordpress.org' => 'localhost:10169/wp-json/lifejacket/v1/api',
            'downloads.wordpress.org' => 'localhost:10169/wp-json/lifejacket/v1/downloads',    
        ],
    ];

    public function init() {
        add_filter( 'http_allowed_safe_ports', [ $this, 'maybe_allow_port' ] );
        add_filter( 'pre_http_request', [ $this, 'maybe_proxy_dotorg' ], 1, 3 );
    }

    public function maybe_allow_port( $ports) {
        // TO DO: make dynamic;
        $ports[] = 10169; 
        return $ports;
    }

    public function maybe_proxy_dotorg( $response, $parsed_args, $url ) {
        $domain = '';
        $endpoint = '';
        foreach ( $this->options['hostnames'] as $hostname => $replacement ) {
            if ( 1 === preg_match( '|^https?://' . $hostname . '|ims', $url ) ) {
                $domain = $hostname;
                $endpoint = $replacement;
                break;
            }
        }

        if ( $domain && $endpoint ) {
            if ( $this->options['require_auth'] ) {
                $parsed_args['headers'] = $parsed_args['headers'] ?? [];
                $parsed_args['headers']['X-WP-Application-Password'] = $this->options['password'];    
            }
            $url = preg_replace( '|^https?://' . $domain . '|ims', 'http://' . $endpoint, $url );
            $response = wp_remote_request( $url, $parsed_args );
        }
        
        return $response;
    }
}