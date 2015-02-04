<?php
/*
Plugin Name: WPsite Custom Functions Starter Kit
plugin URI: http://wpsite.com/custom-functions-starter-kit/
Description: 
version: 1.0
Author: Kyle Benk
Author URI: http://kylebenkapps.com
License: GPL2
*/

/**
 * Global Definitions
 */

/* Plugin Name */

if (!defined('CUSTOM_FUNCTIONS_PLUGIN_NAME'))
    define('CUSTOM_FUNCTIONS_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('CUSTOM_FUNCTIONS_PLUGIN_DIR'))
    define('CUSTOM_FUNCTIONS_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . CUSTOM_FUNCTIONS_PLUGIN_NAME);

/* Plugin url */

if (!defined('CUSTOM_FUNCTIONS_PLUGIN_URL'))
    define('CUSTOM_FUNCTIONS_PLUGIN_URL', WP_PLUGIN_URL . '/' . CUSTOM_FUNCTIONS_PLUGIN_NAME);

/* Plugin verison */

if (!defined('CUSTOM_FUNCTIONS_VERSION_NUM'))
    define('CUSTOM_FUNCTIONS_VERSION_NUM', '1.0.0');


/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('Custom_Functions', 'register_activation'));

/**
 * Hooks / Filter
 */

add_action('init', array('Custom_Functions', 'load_textdomain'));
add_action('admin_menu', array('Custom_Functions', 'menu_page'));

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('Custom_Functions', 'plugin_links'));

/**
 *  Custom_Functions main class
 *
 * @since 1.0.0
 * @using Wordpress 3.8
 */

class Custom_Functions {

	/**
	 * text_domain
	 *
	 * (default value: 'custom-functions')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $text_domain = 'custom-functions';

	/**
	 * prefix
	 *
	 * (default value: 'Custom_Functions_')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $prefix = 'Custom_Functions_';

	/**
	 * prefix_dash
	 *
	 * (default value: 'cst-fnc-')
	 *
	 * @var string
	 * @access public
	 * @static
	 */
	public static $prefix_dash = 'cst-fnc-';

	/**
	 * settings_page
	 *
	 * (default value: 'general-admin-menu-settings')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $settings_page = 'custom-functions-admin-menu-settings';

	/**
	 * tabs_settings_page
	 *
	 * (default value: 'general-admin-menu-tab-settings')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $tabs_settings_page = 'custom-functions-admin-menu-tab-settings';

	/**
	 * usage_page
	 *
	 * (default value: 'general-admin-menu-usage')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $usage_page = 'custom-functions-admin-menu-usage';

	/**
	 * default
	 *
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $default = array(
		'checkbox-1'	=> true,
		'checkbox-2'	=> true,
		'checkbox-3'	=> true,
		'checkbox-4'	=> true,
		'checkbox-5'	=> true,
		'checkbox-6'	=> true,
		'checkbox-7'	=> true,
		'checkbox-8'	=> true,
		'checkbox-9'	=> true,
		'checkbox-10'	=> true,
		'checkbox-11'	=> true,
		'checkbox-12'	=> true,
		'checkbox-13'	=> true,
		'checkbox-14'	=> true,
		'checkbox-15'	=> true,
		'checkbox-16'	=> true,
		'checkbox-17'	=> true,
		'checkbox-18'	=> true,
		'checkbox-19'	=> true,
		'checkbox-20'	=> true,
		'checkbox-21'	=> true
	);

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	static function load_textdomain() {
		load_plugin_textdomain(self::$text_domain, false, CUSTOM_FUNCTIONS_PLUGIN_DIR . '/languages');
	}

	/**
	 * Hooks to 'register_activation_hook'
	 *
	 * @since 1.0.0
	 */
	static function register_activation() {

		/* Check if multisite, if so then save as site option */

		if (function_exists('is_multisite') && is_multisite()) {
			update_site_option(self::$prefix . 'version', CUSTOM_FUNCTIONS_VERSION_NUM);
		} else {
			update_option(self::$prefix . 'version', CUSTOM_FUNCTIONS_VERSION_NUM);
		}
	}

	/**
	 * Hooks to 'plugin_action_links_' filter
	 *
	 * @since 1.0.0
	 */
	static function plugin_links($links) {
		$settings_link = '<a href="admin.php?page=' . self::$settings_page . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Hooks to 'admin_menu'
	 *
	 * @since 1.0.0
	 */
	static function menu_page() {

		// Add the menu Page

		add_menu_page(
			__('Custom Functions', self::$text_domain),				// Page Title
			__('Custom Functions', self::$text_domain), 				// Menu Name
	    	'manage_options', 											// Capabilities
	    	self::$settings_page, 										// slug
	    	array('Custom_Functions', 'admin_settings')				// Callback function
	    );

	    // Cast the first sub menu to the top menu

	    $settings_page_load = add_submenu_page(
	    	self::$settings_page, 										// parent slug
	    	__('Settings', self::$text_domain), 						// Page title
	    	__('Settings', self::$text_domain), 						// Menu name
	    	'manage_options', 											// Capabilities
	    	self::$settings_page, 										// slug
	    	array('Custom_Functions', 'admin_settings')				// Callback function
	    );
	    add_action("admin_print_scripts-$settings_page_load", array('Custom_Functions', 'include_admin_scripts'));

	    // Another sub menu

	    $usage_page_load = add_submenu_page(
	    	self::$settings_page, 										// parent slug
	    	__('Usage', self::$text_domain),  							// Page title
	    	__('Usage', self::$text_domain),  							// Menu name
	    	'manage_options', 											// Capabilities
	    	self::$usage_page, 											// slug
	    	array('Custom_Functions', 'admin_usage')								// Callback function
	    );
	    add_action("admin_print_scripts-$usage_page_load", array('Custom_Functions', 'include_admin_scripts'));

	    // Another sub menu

	    $tabs_page_load = add_submenu_page(
	    	self::$settings_page, 										// parent slug
	    	__('Tabs', self::$text_domain),  							// Page title
	    	__('Tabs', self::$text_domain),  							// Menu name
	    	'manage_options', 											// Capabilities
	    	self::$tabs_settings_page, 											// slug
	    	array('Custom_Functions', 'admin_tabs')		// Callback function
	    );
	    add_action("admin_print_scripts-$tabs_page_load", array('Custom_Functions', 'include_admin_scripts'));
	}

	/**
	 * Hooks to 'admin_print_scripts-$page'
	 *
	 * @since 1.0.0
	 */
	static function include_admin_scripts() {

		// CSS

		wp_register_style(self::$prefix . 'settings_css', CUSTOM_FUNCTIONS_PLUGIN_URL . '/css/settings.css');
		wp_enqueue_style(self::$prefix . 'settings_css');

		// Javascript

		wp_register_script(self::$prefix . 'settings_js', CUSTOM_FUNCTIONS_PLUGIN_URL . '/js/settings.js');
		wp_enqueue_script(self::$prefix . 'settings_js');

		// BootStrap

		wp_enqueue_style(self::$prefix . 'bootstrap_css', CUSTOM_FUNCTIONS_PLUGIN_URL . '/include/bootstrap-3.2.0-dist/css/bootstrap.css');
		wp_enqueue_script(self::$prefix . 'bootstrap_js', CUSTOM_FUNCTIONS_PLUGIN_URL . '/include/bootstrap-3.2.0-dist/js/bootstrap.js', array('jquery'));
	}

	/**
	 * Displays the HTML for the 'general-admin-menu-settings' admin page
	 *
	 * @since 1.0.0
	 */
	static function admin_settings() {

		if (function_exists('is_multisite') && is_multisite()) {
			$settings = get_site_option(self::$prefix . 'settings');
		} else {
			$settings = get_option(self::$prefix . 'settings');
		}

		// Default values

		if ( $settings === false ) {
			$settings = self::$default;
		}

		// Save data nd check nonce

		if (isset($_POST['submit']) && check_admin_referer(self::$prefix . 'admin_settings')) {

			$settings = array(
				'checkbox-1'	=> isset($_POST[self::$prefix . 'checkbox-1']) && $_POST[self::$prefix . 'checkbox-1'] ? true : false,
				'checkbox-2'	=> isset($_POST[self::$prefix . 'checkbox-2']) && $_POST[self::$prefix . 'checkbox-2'] ? true : false,
				'checkbox-3'	=> isset($_POST[self::$prefix . 'checkbox-3']) && $_POST[self::$prefix . 'checkbox-3'] ? true : false,
				'checkbox-4'	=> isset($_POST[self::$prefix . 'checkbox-4']) && $_POST[self::$prefix . 'checkbox-4'] ? true : false,
				'checkbox-5'	=> isset($_POST[self::$prefix . 'checkbox-5']) && $_POST[self::$prefix . 'checkbox-5'] ? true : false,
				'checkbox-6'	=> isset($_POST[self::$prefix . 'checkbox-6']) && $_POST[self::$prefix . 'checkbox-6'] ? true : false,
				'checkbox-7'	=> isset($_POST[self::$prefix . 'checkbox-7']) && $_POST[self::$prefix . 'checkbox-7'] ? true : false,
				'checkbox-8'	=> isset($_POST[self::$prefix . 'checkbox-8']) && $_POST[self::$prefix . 'checkbox-8'] ? true : false,
				'checkbox-9'	=> isset($_POST[self::$prefix . 'checkbox-9']) && $_POST[self::$prefix . 'checkbox-9'] ? true : false,
				'checkbox-10'	=> isset($_POST[self::$prefix . 'checkbox-10']) && $_POST[self::$prefix . 'checkbox-10'] ? true : false,
				'checkbox-11'	=> isset($_POST[self::$prefix . 'checkbox-11']) && $_POST[self::$prefix . 'checkbox-11'] ? true : false,
				'checkbox-12'	=> isset($_POST[self::$prefix . 'checkbox-12']) && $_POST[self::$prefix . 'checkbox-12'] ? true : false,
				'checkbox-13'	=> isset($_POST[self::$prefix . 'checkbox-13']) && $_POST[self::$prefix . 'checkbox-13'] ? true : false,
				'checkbox-14'	=> isset($_POST[self::$prefix . 'checkbox-14']) && $_POST[self::$prefix . 'checkbox-14'] ? true : false,
				'checkbox-15'	=> isset($_POST[self::$prefix . 'checkbox-15']) && $_POST[self::$prefix . 'checkbox-15'] ? true : false,
				'checkbox-16'	=> isset($_POST[self::$prefix . 'checkbox-16']) && $_POST[self::$prefix . 'checkbox-16'] ? true : false,
				'checkbox-17'	=> isset($_POST[self::$prefix . 'checkbox-17']) && $_POST[self::$prefix . 'checkbox-17'] ? true : false,
				'checkbox-18'	=> isset($_POST[self::$prefix . 'checkbox-18']) && $_POST[self::$prefix . 'checkbox-18'] ? true : false,
				'checkbox-19'	=> isset($_POST[self::$prefix . 'checkbox-19']) && $_POST[self::$prefix . 'checkbox-19'] ? true : false,
				'checkbox-20'	=> isset($_POST[self::$prefix . 'checkbox-20']) && $_POST[self::$prefix . 'checkbox-20'] ? true : false,
				'checkbox-21'	=> isset($_POST[self::$prefix . 'checkbox-21']) && $_POST[self::$prefix . 'checkbox-21'] ? true : false
			);

			if (function_exists('is_multisite') && is_multisite()) {
				update_site_option(self::$prefix . 'settings', $settings);
			} else {
				update_option(self::$prefix . 'settings', $settings);
			}
		}

		require('admin/settings.php');
	}

	/**
	 * Displays the HTML for the 'general-admin-menu-usage' admin page
	 *
	 * @since 1.0.0
	 */
	static function admin_usage() {
		?>
		<div id="<?php echo self::$prefix; ?>content">
			<h1><?php _e('Usage Page', self::$text_domain); ?> <small><?php _e('Information about how to use this plugin.', self::$text_domain); ?></small></h1>
		</div>
		<?php
	}

	/**
	 * Displays the HTML for the 'general-admin-menu-tab-settings' admin page
	 *
	 * @since 1.0.0
	 */
	static function admin_tabs() {
		?>

		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#myTab a').click(function (e) {
					e.preventDefault();
					$(this).tab('show');
				})
			});
		</script>

		<div id="<?php echo self::$prefix; ?>content">

			<h1><?php _e('Tabs Page', self::$text_domain); ?></h1>

			<!-- Nav tabs -->
			<ul id="myTab" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#<?php echo self::$prefix;?>tab_1" role="tab" data-toggle="tab"><?php _e('Tab 1', self::$text_domain); ?></a></li>
				<li role="presentation"><a href="#<?php echo self::$prefix;?>tab_2" role="tab" data-toggle="tab"><?php _e('Tab 2', self::$text_domain); ?></a></li>
			</ul>
			<br/>

			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="<?php echo self::$prefix;?>tab_1">
					<p><?php _e('Content of Tab 1', self::$text_domain); ?></p>
				</div>
				<div role="tabpanel" class="tab-pane" id="<?php echo self::$prefix;?>tab_2">
					<p><?php _e('Content of Tab 2', self::$text_domain); ?></p>
				</div>
			</div>

		</div>
		<?php
	}
}

?>