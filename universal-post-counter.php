<?php
/**
 *
 * @link              www.presstigers.com
 * @since             1.0.0
 * @package           Universal_Post_Counter
 *
 * @wordpress-plugin
 * Plugin Name:       Universal Post Counter
 * Plugin URI:    	  https://wordpress.org/plugins/universal-post-counter/
 * Description:       Universal Post Counter allows the admin to see post count for default and custom post types.
 * Version:           1.0.0
 * Author:            PressTigers
 * Author URI:        www.presstigers.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       universal-post-counter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UNIVERSAL_POST_COUNTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-universal-post-counter-activator.php
 */
function activate_universal_post_counter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-universal-post-counter-activator.php';
	Universal_Post_Counter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-universal-post-counter-deactivator.php
 */
function deactivate_universal_post_counter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-universal-post-counter-deactivator.php';
	Universal_Post_Counter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_universal_post_counter' );
register_deactivation_hook( __FILE__, 'deactivate_universal_post_counter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-universal-post-counter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_universal_post_counter() {
	$plugin = new Universal_Post_Counter();
	$plugin->run();
}
 function check_logged_in_universal_post_counter() {
    if(current_user_can('administrator')) {
		run_universal_post_counter();
	}     
 }
 if(is_admin() ) {
	add_action( 'init', 'check_logged_in_universal_post_counter' );	
 }

