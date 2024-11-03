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

    protected $options;

    public function init() {
        add_filter( 'http_allowed_safe_ports', [ $this, 'maybe_allow_port' ] );
        add_filter( 'pre_http_request', [ $this, 'maybe_proxy_dotorg' ], 1, 3 );

        $this->options = new Options();
    }

    public function maybe_allow_port( $ports) {
        $server = $this->options->get( 'server' );
        $port = parse_url( $server, PHP_URL_PORT );
        if ( null !== $port && ! in_array( $port, $ports, true) ) {
            $ports[] = $port; 
        }
        return $ports;
    }

    public function get_hostnames() {
        $server = $this->options->get( 'server' );
        $hostnames = [
            'api.wordpress.org' => $server . '/api',
            'downloads.wordpress.org' => $server . '/downloads',    
        ];
        $hostnames = apply_filters( 'lifejacket/hostnames', $hostnames );
        return $hostnames;
    }

    public function maybe_proxy_dotorg( $response, $parsed_args, $url ) {
        $domain = '';
        $endpoint = '';
        foreach ( $this->get_hostnames() as $hostname => $replacement ) {
            if ( 1 === preg_match( '|^https?://' . $hostname . '|ims', $url ) ) {
                $domain = $hostname;
                $endpoint = $replacement;
                break;
            }
        }

        if ( $domain && $endpoint ) {
            if ( $this->options->get( 'require_auth' ) ) {
                $parsed_args['headers'] = $parsed_args['headers'] ?? [];
                $parsed_args['headers']['X-WP-Application-Password'] = $this->options->get( 'application_password' );    
            }
            $url = preg_replace( '|^https?://' . $domain . '|ims', $endpoint, $url );
            $response = wp_remote_request( $url, $parsed_args );
        }
        
        return $response;
    }
}