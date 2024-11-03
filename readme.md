
# LifeJacket Client

This is the **Client** part of the LifeJacket project, which enables you to use a custom update server for your WordPress site.

To use this tool, you will also need a custom update server set up somewhere. We have a companion plugin called [LifeJacket Server](https://github.com/life-jacket/lifejacket-server), which could be used for this purpose, but with some configuration, you should be able to use any alternative update server solution, so long as that solution implements the .org API

## Installation

Initially you'll need to download and manually install a .zip file for this plugin. You can find the latest release [here](https://github.com/life-jacket/lifejacket-client/releases).

This plugin can be activated several ways:

1. As a *regular* plugin - via the WordPress Admin UI;
2. As a *must-use* (MU) plugin - by placing it into `wp-content/mu-plugins/` directory;

Using it as a mu-plugin is advangageous as it gets activated earlier in WordPress load cycle.
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
