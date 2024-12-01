<?php
namespace LifeJacket\Client;

class Options {
	protected $options = [];
	protected $sources = [];

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

	public function get_defaults() {
		return $this->default_options;
	}

	public function get( $option ) {
		$value = $this->get_with_source( $option )['value'];
		return $value;
	}

	public function get_with_source( $option ) {
		$value  = '';
		$source = '';

		if ( isset( $this->options[ $option ] ) ) {
			$value  = $this->options[ $option ] ?? null;
			$source = $this->sources[ $option ] ?? null;
		}

		$constant_name = strtoupper( 'LIFEJACKET_' . $option );
		if ( ! $value && defined( $constant_name ) ) {
			$value  = constant( $constant_name );
			$source = 'constant';
		}

		if ( ! $value && is_multisite() && isset( $this->network_options[ $option ] ) ) {
			$value  = $this->network_options[ $option ];
			$source = 'network';
		}

		if ( ! $value && isset( $this->blog_options[ $option ] ) ) {
			$value  = $this->blog_options[ $option ];
			$source = 'blog';
		}

		if ( ! $value && isset( $this->default_options[ $option ] ) ) {
			$value  = $this->default_options[ $option ];
			$source = 'default';
		}

		$value = $this->set( $option, $value );

		$value = apply_filters( 'lifejacket/option/get', $value, $option );
		$value = apply_filters( "lifejacket/option/get/{$option}", $value );

		$source = apply_filters( 'lifejacket/option_source/get', $source, $option );
		$source = apply_filters( "lifejacket/option_source/get/{$option}", $source );

		return [
			'value'  => $value,
			'source' => $source,
		];
	}

	protected function set( $option, $value ) {
		$value = apply_filters( 'lifejacket/option/set', $value, $option );
		$value = apply_filters( "lifejacket/option/set/{$option}", $value );

		$this->options[ $option ] = $value;

		return $this->options[ $option ];
	}
}
