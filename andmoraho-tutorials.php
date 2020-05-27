<?php
/*
Plugin Name: Tutorials
Description: Tutorials.
Version: 1.0.0
Author: Andres Morales (andmoraho)
Author URI: https://github.com/andmoraho/
Text Domain: tutorials
*/

// don't load directly
if (! defined('ABSPATH')) {
    die('Invalid request.');
}

/**
 * Currently plugin version.
 */
define('ANDMORAHO_TUTORIALS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-andmoraho-tutorials-activator.php
 */
function activate_andmoraho_tutorials()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-andmoraho-tutorials-activator.php';
    Andmoraho_Tutorials_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-andmoraho-tutorials-deactivator.php
 */
function deactivate_andmoraho_tutorials()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-andmoraho-tutorials-deactivator.php';
    Andmoraho_Tutorials_Deactivator::deactivate();
}
 
register_activation_hook(__FILE__, 'activate_andmoraho_tutorials');
register_deactivation_hook(__FILE__, 'deactivate_andmoraho_tutorials');


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-andmoraho-tutorials.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_andmoraho_tutorials()
{
    $andmoraho_tutorials = new Andmoraho_Tutorials();
    $andmoraho_tutorials->run();
}
run_andmoraho_tutorials();
