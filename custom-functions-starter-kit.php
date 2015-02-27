<?php
/*
Plugin Name: 99 Robots Custom Functions Starter Kit
plugin URI: http://99robots.com/plugins/custom-functions-starter-kit/
Description:
version: 1.0
Author: 99 Robots
Author URI: http://99robots.com
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

//Load text domain
add_action('init', array('Custom_Functions', 'load_textdomain'));

//Add settings menu
add_action('admin_menu', array('Custom_Functions', 'menu_page'));

//Add custom functions
add_action('init', array('Custom_Functions', 'do_custom_functions'));

//Add admin notices
add_action('admin_notices',array('Custom_Functions','handle_admin_notices'));

//Hide Plugin & Theme editors
add_action('admin_init',array('Custom_Functions','hide_editors'));

//Hide Core updates from non-admin
add_action('admin_head',array('Custom_Functions','hide_core_update'));

//Hide Admin bar setting from non-admin
add_action('admin_print_scripts-profile.php', array('Custom_Functions','hide_admin_bar_settings'));

//Hide Admin bar from non-admin
add_action('init',array('Custom_Functions','disable_admin_bar'));

//Add featured image to RSS feeds Excerpt
add_filter('the_excerpt_rss', array('Custom_Functions','featured_image_in_rss'));

//Add featured image to RSS feed content
add_filter('the_content_feed',array('Custom_Functions','featured_image_in_rss'));

//Disable self ping
add_action( 'pre_ping',array('Custom_Functions','disable_self_ping'));

//Allow contributor to upload photos
add_action('admin_init',array('Custom_Functions','allow_contributor_uploads'));

//Prevent author from viewing other authors posts
add_filter('pre_get_posts',array('Custom_Functions','posts_for_current_author'));

//Disable post revisions
add_filter('wp_revisions_to_keep',array('Custom_Functions','disable_post_revisions'),10,2);

//Externalize links
//add_filter('the_content', array('Custom_Functions','externalize_links'));

// Add Thumbnails in Manage Posts/Pages List
if (is_admin()) {

	// for posts
    add_filter( 'manage_posts_columns',array('Custom_Functions','add_thumb_column'));
    add_action( 'manage_posts_custom_column',array('Custom_Functions','add_thumb_value'),10,2);

    // for pages
    add_filter( 'manage_pages_columns',array('Custom_Functions','add_thumb_column'));
    add_action( 'manage_pages_custom_column',array('Custom_Functions','add_thumb_value'),10,2);
}


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
	public static $text_domain = 'nnr-custom-functions';

	/**
	 * prefix
	 *
	 * (default value: 'Custom_Functions_')
	 *
	 * @var string
	 * @access private
	 * @static
	 */
	public static $prefix = 'nnr_custom_functions_';

	/**
	 * prefix_dash
	 *
	 * (default value: 'cst-fnc-')
	 *
	 * @var string
	 * @access public
	 * @static
	 */
	public static $prefix_dash = 'nnr-cf-';

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
		'checkbox-1'	=> false,
		'checkbox-2'	=> false,
		'checkbox-3'	=> false,
		'checkbox-4'	=> false,
		'checkbox-5'	=> false,
		'checkbox-6'	=> false,
		'checkbox-7'	=> false,
		'checkbox-8'	=> false,
		'checkbox-9'	=> false,
		'checkbox-10'	=> false,
		'checkbox-11'	=> false,
		'checkbox-12'	=> false,
		'checkbox-13'	=> false,
		'checkbox-14'	=> false,
		'checkbox-15'	=> false,
		'checkbox-16'	=> false,
		'checkbox-17'	=> false,
		'checkbox-18'	=> false,
		'checkbox-19'	=> false,
		'checkbox-20'	=> false,
		'checkbox-21'	=> false,
		'checkbox-22'	=> false
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
		$settings_link = '<a href="tools.php?page=' . self::$settings_page . '">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	/**
	 * Hooks to 'admin_menu'
	 *
	 * @since 1.0.0
	 */
	static function menu_page() {

	    // Cast the first sub menu to the tools menu

	    $settings_page_load = add_submenu_page(
	    	'tools.php', 										// parent slug
	    	__('Custom Functions', self::$text_domain), 						// Page title
	    	__('Custom Functions', self::$text_domain), 						// Menu name
	    	'manage_options', 											// Capabilities
	    	self::$settings_page, 										// slug
	    	array('Custom_Functions', 'admin_settings')				// Callback function
	    );
	    add_action("admin_print_scripts-$settings_page_load", array('Custom_Functions', 'include_admin_scripts'));

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

		$settings = get_option(self::$prefix . 'settings');

		// Default values

		if ( $settings === false ) {
			$settings = self::$default;
		}

		// Save data and check nonce

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
				'checkbox-21'	=> isset($_POST[self::$prefix . 'checkbox-21']) && $_POST[self::$prefix . 'checkbox-21'] ? true : false,
				'checkbox-22'	=> isset($_POST[self::$prefix . 'checkbox-22']) && $_POST[self::$prefix . 'checkbox-22'] ? true : false
			);

			update_option(self::$prefix . 'settings', $settings);

		}

		require('admin/settings.php');
	}

	/**
	 * Checks $settings and enables individual functions
	 *
	 * @since 1.0.0
	 */
	public static function do_custom_functions() {

		$settings = get_option(self::$prefix . 'settings');

		/* Hide WordPress Version & Meta Data */

		if (isset($settings['checkbox-1']) && $settings['checkbox-1'] && !is_admin()) {

			remove_action('wp_head', 'wp_generator');

		}

		/* Hide WordPress Login Errors */

		if (isset($settings['checkbox-2']) && $settings['checkbox-2']) {

			add_filter('login_errors', create_function('$destroy_login_errors', "return null;"));

		}


		/* Disable WordPress Automatic Updates */

		if (isset($settings['checkbox-4']) && $settings['checkbox-4']) {

			add_filter( 'allow_minor_auto_core_updates', '__return_false' );

		} else {

			add_filter( 'allow_minor_auto_core_updates', '__return_true' );
		}

	} // end do_custom_functions

	/**
	 * Checks $settings and handles admin notices
	 *
	 * @since 1.0.0
	 */
	static function handle_admin_notices() {

		/* Check 'Admin' Security Vulnerability */

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-3']) && $settings['checkbox-3'] && is_admin()) {

			// Get user by login name 'admin'
			$bloguser = get_user_by('login','admin');

			// Check if object exists
			if ($bloguser){

				// Double-check if object is 'admin'
				if ($bloguser->user_login === 'admin') {

					// check if administrator
					if (current_user_can('manage_options')) {

						// Display admin notice
						echo '<div class="error"><p>';
						_e('WARNING! An administrator is using the "admin" username, which is highly targetted by <a href="https://99robots.com/wordpress-security-checklist/">brute force bot-net attacks</a>. Please create a new administrator user and delete the "admin" username.', self::$text_domain);
						echo '</p></div>';
					}
				}
			}
		}
	} // handle_admin_notices

	/**
	 * Checks $settings and hides plugin and theme editors
	 *
	 * @since 1.0.0
	 */
	static function hide_editors(){

		/* Hide Theme and Plugin Editors */

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-5']) && $settings['checkbox-5'] && is_admin()) {

			remove_submenu_page( 'themes.php', 'theme-editor.php' );
			remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

		}
	} // hide_editors

	/**
	 * Checks $settings and Hide WP Update notice from non-admins
	 *
	 * @since 1.0.0
	 */
	static function hide_core_update(){

		/* Hide Theme and Plugin Editors */

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-6']) && $settings['checkbox-6'] && is_admin()) {

			/* remove WordPress update message for everyone except Admin users */

			if(!current_user_can('update_core')) {

				remove_action( 'admin_notices', 'update_nag', 3 );

			}
		}
	} // hide_core_updates

	/**
	 * Checks $settings and Hide WP admin bar settings from non-admins
	 *
	 * @since 1.0.0
	 */
	static function hide_admin_bar_settings() {

		$settings = get_option(self::$prefix . 'settings');

		/* remove WordPress admin bar option from all users except admin  */
		if (isset($settings['checkbox-22']) && $settings['checkbox-22'] && !current_user_can('administrator')) {?>

			<style type="text/css"> .show-admin-bar { display: none; } </style>
		<?php }
	} // hide_admin_bar_settings

	/**
	 * Checks $settings and Hide WP admin bar from non-admins
	 *
	 * @since 1.0.0
	 */
	static function disable_admin_bar() {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-22']) && $settings['checkbox-22'] && !current_user_can('administrator')) {

			/* remove WordPress admin bar from all users except admin */
			add_filter( 'show_admin_bar', '__return_false' );
		}
	} // disable_admin_bar

	/**
	 * Checks $settings and display image in rss feeds
	 * @since 1.0.0
	 */
	static function featured_image_in_rss($content) {

		// Global $post variable
		global $post;

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-12']) && $settings['checkbox-12']) {

			// Check if the post has a featured image
		    if (has_post_thumbnail($post->ID)) {
		        $content = get_the_post_thumbnail($post->ID, 'large', array('style' => 'margin-bottom:10px;')) . $content;
		    }
		    return $content;
		}
	} // featured_image_in_rss

	/**
	 * Checks $settings and disables self pinging
	 * @since 1.0.0
	 */
	static function disable_self_ping(&$links) {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-13']) && $settings['checkbox-13']) {

			//remove pings to self

		    $home = get_option( 'home' );

		    foreach ( $links as $l => $link ) {

		        if ( 0 === strpos( $link, $home ) ){

		            unset($links[$l]);
				}
			}
		}
	} // disable_self_ping

	/**
	 * Checks $settings and allows contributors to upload images
	 * @since 1.0.0
	 */
	static function allow_contributor_uploads() {

		$settings = get_option(self::$prefix . 'settings');
		$contributor = get_role('contributor');
		if (isset($settings['checkbox-20']) && $settings['checkbox-20']) {

			$contributor->add_cap('upload_files');

		} else {

			$contributor->remove_cap('upload_files');

		}
	} // allow_contributor_uploads

	/**
	 * Checks $settings and prevents authors from seeing other posts
	 * @since 1.0.0
	 */
	static function posts_for_current_author($query) {

		$settings = get_option(self::$prefix . 'settings');
		global $pagenow;

		if (isset($settings['checkbox-21']) && $settings['checkbox-21']) {

		    if(!current_user_can('manage_options')) {

		       global $user_ID;
		       $query->set('author', $user_ID );

		    }

		    return $query;
		}
	} // posts_for_current_author

	/**
	 * Checks $settings and disables post revisions
	 * @since 1.0.0
	 */
	static function disable_post_revisions($num,$post) {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-11']) && $settings['checkbox-11']) {

			//set limit to 1 post
			$num = 1;

		} else {

			// reset to unlimited saved posts
			$num = -1;

		}

		return $num;

	} // posts_for_current_author

	/**
	 * Checks $settings and externalizes links
	 * @since 1.0.0
	 */
	static function externalize_links($content) {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-14']) && $settings['checkbox-14']) {

			$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";

			$hostname = parse_url(get_home_url());

			if(preg_match_all("/$regexp/siU", $content, $matches, PREG_SET_ORDER)) {
				foreach($matches as $match) {
/* 					error_log($match[0]);//full link */
/* 					error_log($match[1]);// */
/* 					error_log($match[2]);//anchor href */
/* 					error_log($match[3]);//anchor text */
					$parse = parse_url($match[2]);
/* 					error_log($parse['host']); */


					if (isset($content) &&
						isset($parse['host']) &&
						isset($match[2]) &&
						isset($hostname['host']) &&
						($hostname['host'] === $parse['host'])
						){

						$replace = preg_replace('<a', '<a target="_blank"', $match[0]);
/* 						error_log($replace); */

					}
				}
			}

		} // externalize_links

		return $content;
	}


	/**
	 * Checks $settings and adds thumnail column to admin list
	 * @since 1.0.0
	 */

	static function add_thumb_column($cols) {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-10']) && $settings['checkbox-10']) {

	        $cols['thumbnail'] = __('Thumbnail');

        }

        return $cols;

    }

    /**
	 * Checks $settings and adds thumbnails to thumbnail column
	 * @since 1.0.0
	 */

    static function add_thumb_value($column_name, $post_id) {

		$settings = get_option(self::$prefix . 'settings');

		if (isset($settings['checkbox-10']) && $settings['checkbox-10']) {

			$width = (int) 60;
			$height = (int) 60;

			if ( 'thumbnail' == $column_name ) {

			    // thumbnail of WP 2.9
			    $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

			    // image from gallery
			    $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
			    if ($thumbnail_id)
			        $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			    elseif ($attachments) {
			        foreach ( $attachments as $attachment_id => $attachment ) {
			            $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
			        }
			    }
		        if ( isset($thumb) && $thumb ) {
		            echo $thumb;
		        } else {
		            _e('None',self::$text_domain);
		        }
			}
		}
    }
} // end Custom_Functions

?>