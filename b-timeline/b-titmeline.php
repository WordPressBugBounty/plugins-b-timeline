<?php
/*
 * Plugin Name: Timeline
 * Plugin URI:  https://bplugins.com/
 * Description: Easily display interactive Data Timeline.
 * Version: 2.0.4
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
define('BPTL_VER', '2.0.4');
define('BPTL_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Black Friday promo banner & plugins-list promo link (admin only)
if (is_admin()) {
    if (file_exists(BPTL_PLUGIN_PATH . 'inc/class-bptl-promo-banner.php')) {
        require_once BPTL_PLUGIN_PATH . 'inc/class-bptl-promo-banner.php';
    }
    if (file_exists(BPTL_PLUGIN_PATH . 'inc/class-bpl-promo-link.php')) {
        require_once BPTL_PLUGIN_PATH . 'inc/class-bpl-promo-link.php';
    }
}

// Load Main Plugin Class
require_once BPTL_PLUGIN_PATH . 'inc/class-bptl-main.php';

// Initializing the Class
BTimeline::instance();

// Redirect to Dashboard After Activation
register_activation_hook(__FILE__, ['BTimeline', 'activation_redirect']);
add_action('admin_init', ['BTimeline', 'do_redirect_to_dashboard']);