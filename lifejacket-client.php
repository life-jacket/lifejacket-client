<?php
/**
 * Plugin Name: LifeJacket Client
 * Version: 0.1.0
 * Plugin URI: https://github.com/life-jacket/lifejacket-client
 * Description: Enables you to use a custom update server for your WordPress site. Part of LifeJacket project
 * Author: LifeJacket
 * Author URI: https://github.com/life-jacket
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

require_once __DIR__ . '/vendor/autoload.php';

add_action( 'plugins_loaded', 'lifejacket_client' );

function lifejacket_client() {
    return LifeJacket\Client\Plugin::get_instance();
}