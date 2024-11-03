<?php
/**
 * Plugin Name: LifeJacket Client
 * Version: 0.1.0
 */

require_once __DIR__ . '/vendor/autoload.php';

add_action( 'plugins_loaded', 'lifejacket_client' );

function lifejacket_client() {
    return LifeJacket\Client\Plugin::get_instance();
}