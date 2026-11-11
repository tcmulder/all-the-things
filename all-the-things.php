<?php
/**
 * Plugin Name: Pattern Library
 * Description: Adds a basic pattern library to your WordPress site.
 * Version:     3.0.2
 * Author:      Tomas Mulder
 * Author URI:  https://www.thinkaquamarine.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aqua-pattern-library
 * Domain Path: /languages
 *
 * @package Aqua_Pattern_Library
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define constants
 */
define( 'AQUA_PATTERNS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AQUA_PATTERNS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'AQUA_PATTERNS_VERSION', '3.0.2' );

/**
 * Load includes
 */
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/access.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/settings.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/post-type.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/assets.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/templates.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/shortcode.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/menu.php';
require_once AQUA_PATTERNS_PLUGIN_DIR . 'includes/extension-hack.php';
