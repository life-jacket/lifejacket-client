
# LifeJacket Client

This is the **Client** part of the LifeJacket project, which enables you to use a custom update server for your WordPress site.

To use this tool, you will also need a custom update server set up somewhere. We have a companion plugin called LifeJacket Server, which could be used for this purpose, but with some configuration, you should be able to use any alternative update server solution, so long as that solution implements the .org API

## Installation

Initially you'll need to download and manually install a .zip file for this plugin. You can find the latest release [here](https://github.com/life-jacket/lifejacket-client).

## Configuration

Configuration for this plugin is currently done via constants in the `wp-config.php` file:

```php
// ===== Required
// URL to the update server
define( 'LIFEJACKET_SERVER', 'https://example.tld/wp-json/lifejacket/v1' );

// ===== Optional
// To enable authentication via application passwords (supported by LifeJacket Server only)
define( 'LIFEJACKET_REQUIRE_AUTH', true );
// Application password to access the LifeJacket Server
define( 'LIFEJACKET_APPLICATION_PASSWORD', 'AAAA BBBB CCCC DDDD EEEE FFFF' );
```
