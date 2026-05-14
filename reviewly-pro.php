<?php
/**
 * Plugin Name: Reviewly Pro
 * Plugin URI:  https://github.com/syedmaasif/reviewly-pro
 * Description: A fully customizable review collection plugin with multiple UI themes, custom fields, and a powerful dashboard. Works on any WordPress site — services, hospitals, WooCommerce, blogs, and more.
 * Version:     1.0.4
 * Author:      syedmaasif
 * Author URI:  https://profiles.wordpress.org/syedmaasif/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: reviewly-pro
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'REVIEWLY_VERSION',     '1.0.4' );
define( 'REVIEWLY_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'REVIEWLY_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'REVIEWLY_PLUGIN_FILE', __FILE__ );

// Load all includes
require_once REVIEWLY_PLUGIN_DIR . 'includes/class-reviewly-post-type.php';
require_once REVIEWLY_PLUGIN_DIR . 'includes/class-reviewly-settings.php';
require_once REVIEWLY_PLUGIN_DIR . 'includes/class-reviewly-ajax.php';
require_once REVIEWLY_PLUGIN_DIR . 'includes/class-reviewly-shortcodes.php';
require_once REVIEWLY_PLUGIN_DIR . 'includes/class-reviewly-admin.php';

// Activation / Deactivation hooks
register_activation_hook(   __FILE__, [ 'Reviewly_Post_Type', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Reviewly_Post_Type', 'deactivate' ] );

// Boot the plugin
add_action( 'plugins_loaded', function() {
    Reviewly_Post_Type::init();
    Reviewly_Settings::init();
    Reviewly_Ajax::init();
    Reviewly_Shortcodes::init();
    Reviewly_Admin::init();
});
