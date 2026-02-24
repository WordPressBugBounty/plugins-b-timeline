<?php
/*
 * Plugin Name: Timeline 
 * Plugin URI:  https://bplugins.com/
 * Description: Easily display interactive Data Timeline.
 * Version: 2.0.1
 * Author: bPlugins
 * Author URI: http://bplugins.com
 * License: GPLv3
 * Text Domain:  b-timeline
 * Domain Path:  /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

// SOME INITIAL SETUP
define('BPTL_PLUGIN_DIR', plugin_dir_url(__FILE__));
define('BPTL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BPTL_VER', '2.0.1');

// Load Main Plugin Class
require_once BPTL_PLUGIN_PATH . 'inc/class-bptl-main.php';

// Initializing the Class
BTimeline::instance();

// Redirect to Dashboard After Activation
register_activation_hook(__FILE__, ['BTimeline', 'activation_redirect']);
add_action('admin_init', ['BTimeline', 'do_redirect_to_dashboard']);
