<?php
/**
 * Plugin Name: Features Request
 * Description: Using this you can share your experience or request a feature.
 * Version: 1.0.0
 * Author: Indione LLC
 * Author URI: https://profiles.wordpress.org/indionetech/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: features-request
 */

// ABS PATH
if (!defined('ABSPATH'))
{
    exit;
}

// Constant
define('FEREQ_VERSION', isset($_SERVER['HTTP_HOST']) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '1.0.0');
define('FEREQ_DIR_URL', plugin_dir_url(__FILE__));
define('FEREQ_DIR_PATH', plugin_dir_path(__FILE__));

require_once FEREQ_DIR_PATH . 'inc/block.php';
require_once FEREQ_DIR_PATH . 'inc/class-fereq-activation-callback.php';
require_once FEREQ_DIR_PATH . 'inc/class-fereq-deactivation-callback.php';
require_once FEREQ_DIR_PATH . 'inc/class-fereq-shortcode.php';
require_once FEREQ_DIR_PATH . 'inc/class-fereq-admin-menu-add.php';


register_activation_hook(__FILE__, "fereq_activate_function_callback");
register_deactivation_hook(__FILE__, 'fereq_deactivation_function_callback');


function fereq_activate_function_callback()
{
    new Features_Request_Activation();
}

function fereq_deactivation_function_callback()
{
    new Features_Request_Deactivation();
}


