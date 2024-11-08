<?php
namespace LifeJacket\Client;

class Options {
	protected $options = array();

	protected $default_options = array(
		'api_slug'       => 'api',
		'downloads_slug' => 'downloads',
		'telemetry'      => 'disabled',
	);

	protected $network_options = array();
	protected $blog_options    = array();

	public function __construct() {
		$this->network_options = get_site_option( 'lifejacket_client', array() );
		$this->blog_options    = get_option( 'lifejacket_client', array() );
	}

	public function get( $option ) {
		$value = '';

		if ( isset( $this->options[ $option ] ) ) {
			$value = $this->options[ $option ];
		}

		if ( ! $value ) {
			$value = $this->blog_options[ $option ] ?? $this->network_options[ $option ] ?? '';
		}

		$constant_name = strtoupper( 'LIFEJACKET_' . $option );
		if ( ! $value && defined( $constant_name ) ) {
			$value = constant( $constant_name );
		}

		if ( ! $value && isset( $this->default_options[ $option ] ) ) {
			$value = $this->default_options[ $option ];
		}

		$value = $this->set( $option, $value );

		$value = apply_filters( 'lifejacket/option/get', $value, $option );
		$value = apply_filters( "lifejacket/option/get/{$option}", $value );

		return $value;
	}

	protected function set( $option, $value ) {
		$value = apply_filters( 'lifejacket/option/set', $value, $option );
		$value = apply_filters( "lifejacket/option/set/{$option}", $value );

		$this->options[ $option ] = $value;

		return $this->options[ $option ];
	}
}
