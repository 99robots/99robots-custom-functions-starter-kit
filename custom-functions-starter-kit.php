<?php
/**
 * Plugin Name: custom-functions-starter-kit
 * Refrance URI: http://austinpassy.com/wordpress-plugins/featured-image-column
 * Description: Adds a column to the edit screen with the featured image if it exists.
 * Version: 1.0
 * Author: pankaj makwana
 * @package custom-functions-starter-kit
 */
 /**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('custom_functions_starter_kit', 'register_activation'));
add_action('admin_menu', array('custom_functions_starter_kit', 'menu_page'));
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", array('custom_functions_starter_kit', 'plugin_links'));
//add_filter('parse_query', array('custom_functions_starter_kit','only_user_post') );
//remove_meta_box( 'commentsdiv', 'post', 'normal' );

if ( !class_exists( 'custom-functions-starter-kit' ) ) {

	class custom_functions_starter_kit {
		
		const domain  = 'featured-image-column';
		const version = '1.0';
		private static $prefix1 = 'starter_kit_';
		private static $text_domain1="starter-kit";
		private static $settings_page1 = 'custom-function-starter-kit-settings';
		private static $username="";
		
		
		private static $default = array(
		'check_image'		=> true,
		'check_post'	=> true,
		'login_error'	=> true,
		'check_update'  =>true,
		'check_upload_file' => true,
		'check_image_quality' => true,
		'check_Self-Pinging' => true,
		'check_meta' => true,
		'check_widgets' => true,
		'check_remove_metabox' => true,
		'check_author_link' => true,
		'check_post_revision' => true,
		'check_link' => true,
		'check_admin' => true,
		'check_auto_update' => true,
		'check_rss' => true
	);
		/**
		 * Ensures that the rest of the code only runs on edit.php pages
		 *
		 * @since 	0.1
		 */
		function __construct() {
		
			add_action( 'load-edit.php', array( $this, 'load' ));
			global $get_feature_image_val12;
			$get_feature_image_val12=get_option(self::$prefix1 . 'settings');
			
			if($get_feature_image_val12['login_error']==1){
			add_filter('login_errors', create_function('$a', "return null;"));
			}
			if($get_feature_image_val12['check_update']==1){
			add_action('admin_init', array(&$this, 'check_user'));
			//register_activation_hook( __FILE__, 'remove_update_message' );	
			}
			
			if($get_feature_image_val12['check_image_quality']==1){
				//add_filter( 'jpeg_quality', array( $this,create_function( '', 'return 100;' )) );
				add_filter( 'jpeg_quality', array( $this,'tgm_image_full_quality' ));
				add_filter( 'wp_editor_set_quality', array( $this,'tgm_image_full_quality' ));
			}
			if($get_feature_image_val12['check_Self-Pinging']==1){
				add_action( 'pre_ping', array( $this,'no_self_ping' ));
				add_action( 'pre_ping', 'no_self_ping' );
			}
			if($get_feature_image_val12['check_meta']==1){
				remove_action( 'wp_head' , array( $this,'wp_generator' ));
				remove_action( 'wp_head' , 'wp_generator' );
			}
			if($get_feature_image_val12['check_rss']==1){
				add_filter('the_excerpt_rss', array( $this,'add_featured_image_to_feed', 1000, 1));
				add_filter('the_content_feed', array( $this,'add_featured_image_to_feed', 1000, 1));
				add_filter('the_excerpt_rss', 'add_featured_image_to_feed', 1000, 1);
				add_filter('the_content_feed', 'add_featured_image_to_feed', 1000, 1);
			}
			add_action('admin_init',  array( $this,'allow_contributor_uploads'));
			if($get_feature_image_val12['check_widgets']==1){
			add_action('admin_menu', array( $this,'widgets_redirect'));
			add_action('admin_head', array( $this,'remove_widgets_submenu')); 
			add_action('admin_menu', array( $this,'menu_redirect'));
			add_action('admin_head', array( $this,'remove_menu_submenu')); 
			}
			if($get_feature_image_val12['check_remove_metabox']==1){
				add_action( 'add_meta_boxes',  array( $this,'my_remove_post_meta_boxes' ));	
			}
			if($get_feature_image_val12['check_author_link']==1){
				add_filter( 'author_link', array( $this,'my_author_link' ));
			}
			if($get_feature_image_val12['check_post_revision']==1){
				define('WP_POST_REVISIONS', false);
			}
			
			if($get_feature_image_val12['check_link']==1){
			//add_action('wp_footer', 'open_link_new_tab');
			add_action('wp_footer', array( $this,'open_link_new_tab'));
			}
			if($get_feature_image_val12['check_admin']==1){
			add_action('admin_notices', array( $this,'showAdminMessages'));
			}
			if($get_feature_image_val12['check_auto_update']==1){
				define( 'WP_AUTO_UPDATE_CORE', false );
			}
			$this->_define_constants();
			$this->_load_wp_includes();
			$this->_load_wpua();
			/*wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
			add_action('admin_head', array( $this,'wpss_admin_js'));*/
		}
	/**
   * Define paths
   * @since 1.9.2
   */
  private function _define_constants() {
    define('WPUA_VERSION', '1.9.13');
    define('WPUA_FOLDER', basename(dirname(__FILE__)));
    define('WPUA_DIR', plugin_dir_path(__FILE__));
    define('WPUA_INC', WPUA_DIR.'includes'.'/');
    define('WPUA_URL', plugin_dir_url(WPUA_FOLDER).WPUA_FOLDER.'/');
    define('WPUA_INC_URL', WPUA_URL.'includes'.'/');
  }

  /**
   * WordPress includes used in plugin
   * @since 1.9.2
   * @uses is_admin()
   */
  private function _load_wp_includes() {
    if(!is_admin()) {
      // wp_handle_upload
      require_once(ABSPATH.'wp-admin/includes/file.php');
      // wp_generate_attachment_metadata
      require_once(ABSPATH.'wp-admin/includes/image.php');
      // image_add_caption
      require_once(ABSPATH.'wp-admin/includes/media.php');
      // submit_button
      require_once(ABSPATH.'wp-admin/includes/template.php');
    }
    // add_screen_option
    require_once(ABSPATH.'wp-admin/includes/screen.php');
  }

  /**
   * Load WP User Avatar
   * @since 1.9.2
   * @uses bool $wpua_tinymce
   * @uses is_admin()
   */
  private function _load_wpua() {
    global $wpua_tinymce;
    require_once(WPUA_INC.'wpua-globals.php');
    require_once(WPUA_INC.'wpua-functions.php');
    require_once(WPUA_INC.'class-wp-user-avatar-admin.php');
    require_once(WPUA_INC.'class-wp-user-avatar.php');
    require_once(WPUA_INC.'class-wp-user-avatar-functions.php');
    // Only needed on front pages and if NextGEN Gallery isn't installed
    // if(!is_admin() && !defined('NEXTGEN_GALLERY_PLUGIN_DIR') && !defined('NGG_GALLERY_PLUGIN_DIR')) {
    //   require_once(WPUA_INC.'class-wp-user-avatar-resource-manager.php');
    //   WP_User_Avatar_Resource_Manager::init();
    // }
    require_once(WPUA_INC.'class-wp-user-avatar-shortcode.php');
    require_once(WPUA_INC.'class-wp-user-avatar-subscriber.php');
    require_once(WPUA_INC.'class-wp-user-avatar-update.php');
    require_once(WPUA_INC.'class-wp-user-avatar-widget.php');
    // Load TinyMCE only if enabled
    if((bool) $wpua_tinymce == 1) {
      require_once(WPUA_INC.'wpua-tinymce.php');
    }
  }
		function wpss_admin_js() {
			 $siteurl = get_option('siteurl');
			 $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/admin_script.js';
			 echo "<script type='text/javascript' src='$url'></script>"; 
		}

		/* Show update message to admin only
		*@since 	0.1
		*/
		function check_user() {
				$user_info = get_userdata(1);
				if ((implode(', ', $user_info->roles))!="administrator")
					add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
			}
		/* Display message if username is admin
		*@since 	0.1
		*/
		function showAdminMessages()
		{
					global $current_user;
					get_currentuserinfo();
					$username=$current_user->user_login;
					if($username=="admin")
					{
					echo '<div id="message" class="error">';
					echo ("<p><strong>Username as admin is not allowed.</strong></p>");
					echo "</div>";
					//echo "user name is admin is not allowed";
					}
			
		}
		function tgm_image_full_quality( $quality ) {
		 
			return 100;
		 
		}

		/* Open Link In New Tab
		*@since 	0.1
		*/
		function open_link_new_tab() {
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui-tabs');
			?>
		<script type="text/javascript">// <![CDATA[
		jQuery(document).ready(function($){
			$('.post a').each(function(){
				if( $(this).attr('href') && 0 != $(this).attr('href').indexOf('#') ) {
					$(this).attr('target', '_blank');
				}
			});
		});
		// ]]></script>
				<?php
		}

		/* Redirect author to another page 
		*@since 	0.1
		*/		
		function my_author_link() {
			return home_url( '?page_id=8' );
		}
		/* To remove meta box 
		*@since 	0.1
		*/
		function my_remove_post_meta_boxes() {

			/* Publish meta box. */
			remove_meta_box( 'submitdiv', 'post', 'normal' );

			/* Comments meta box. */
			remove_meta_box( 'commentsdiv', 'post', 'normal' );

			/* Revisions meta box. */
			remove_meta_box( 'revisionsdiv', 'post', 'normal' );

			/* Author meta box. */
			remove_meta_box( 'authordiv', 'post', 'normal' );

			/* Slug meta box. */
			remove_meta_box( 'slugdiv', 'post', 'normal' );

			/* Post tags meta box. */
			remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' ); 

			/* Category meta box. */
			remove_meta_box( 'categorydiv', 'post', 'side' );

			/* Excerpt meta box. */
			remove_meta_box( 'postexcerpt', 'post', 'normal' );

			/* Post format meta box. */
			remove_meta_box( 'formatdiv', 'post', 'normal' );

			/* Trackbacks meta box. */
			remove_meta_box( 'trackbacksdiv', 'post', 'normal' );

			/* Custom fields meta box. */
			remove_meta_box( 'postcustom', 'post', 'normal' );

			/* Comment status meta box. */
			remove_meta_box( 'commentstatusdiv', 'post', 'normal' );

			/* Featured image meta box. */
			remove_meta_box( 'postimagediv', 'post', 'side' );

			/* Page attributes meta box. */
			remove_meta_box( 'pageparentdiv', 'page', 'side' );
		}
		
		/**
		 * Since the load-edit.php hook is too early for checking the post type, hook the rest
		 * of the code to the wp action to allow the query to be run first
		 *
		 * @since 	1.0
		 */
		function load() {
			add_action( 'wp', array( $this, 'init' ) );
			global $get_feature_image_val1;
			$get_feature_image_val1=get_option(self::$prefix1 . 'settings');
		/**
		 * simple filter to prevent error for login screen
		 *
		 * @since 	1.0
		 */
			if($get_feature_image_val1['check_post']==1){
				add_filter('parse_query', array( $this, 'only_user_post') );
			}
		}
		/**
		 * Sets up the Custom_Functions_Starter_Kit plugin and loads files at the appropriate time.
		 *
		 * @since 	0.1.6
		 */
		function init() {
		
			 $post_type = get_post_type();
			
			if ( !self::included_post_types( $post_type ) )
				return;
			/* Print style */
			add_action( 'admin_enqueue_scripts',array( $this, 'style' ), 0 );
			/* Column manager */
			
			add_filter( "manage_{$post_type}_posts_columns",		array( $this, 'columns' ) );
			add_action( "manage_{$post_type}_posts_custom_column",	array( $this, 'column_data' ), 10, 2 );	
			/**
			 * Sample filter to remove post type
			add_filter( 'Custom_Functions_Starter_Kit_post_types',array( $this, 'remove_post_type' ), 99 );
			 */

			do_action( 'Custom_Functions_Starter_Kit_loaded' );
		}
		/* User see only their post
		*@since 	0.1
		*/
		function only_user_post( $wp_query ) {
			if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/edit.php' ) !== false ) {
				if ( !current_user_can( 'update_core' ) ) {
					global $current_user;
					$wp_query->set( 'author', $current_user->id );
				}
			}
		}
		/**
		 * To remove update message except admin
		 *@since 	0.1
		 */
		/*function remove_update_message() {
		   global $user_login;
			   get_currentuserinfo();
			   if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins 
				add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
				add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
			   }
		}*/
		/* Allow media file to upload from contributors
		*@since 	0.1
		*/
		function allow_contributor_uploads() {
		$get_feature_image_val12=get_option(self::$prefix1 . 'settings');
			$contributor = get_role('contributor');
			if($get_feature_image_val12['check_upload_file']==1){
				$contributor->add_cap('upload_files');
			}
			else
			{
				$contributor->remove_cap('upload_files');
			}
		}
		/* Remove self ping
		*@since 	0.1
		*/
		function no_self_ping( &$links ) {
			$home = get_option( 'home' );
			foreach ( $links as $l => $link )
			if ( 0 === strpos( $link, $home ) )
			unset($links[$l]);
		}
		
		/* Add featured image to feed
		*@since 	0.1
		*/
		function add_featured_image_to_feed($content) {
				global $post;
				if ( has_post_thumbnail( $post->ID ) ){
					$content = '' . get_the_post_thumbnail( $post->ID, 'large' ) . '' . $content;
				}
				return $content;
			}
		/* Remove widgets submenu
		*@since 	0.1
		*/
		function remove_widgets_submenu() {
		  global $submenu;
	 
		  if (!current_user_can('editor')) {
			  return;
		  }
		  // remove "Widgets" submenu
		  foreach($submenu['themes.php'] as $key=>$item) {
			  if ($item[2]=='widgets.php') {
					unset($submenu['themes.php'][$key]);
					break;
			  }
		  }
		}
		/* Redirect widgets to index page
		*@since 	0.1
		*/
		function widgets_redirect() {
		  $result = stripos($_SERVER['REQUEST_URI'], 'widgets.php');
		  if ($result!==false) {
			wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
		  }
		}
		/* Remove menue from dashboard
		*@since 	0.1
		*/
		function remove_menu_submenu() {
		  global $submenu;
	 
		  if (!current_user_can('editor')) {
			  return;
		  }
		  // remove "Widgets" submenu
		  foreach($submenu['themes.php'] as $key=>$item) {
			  if ($item[2]=='menus.php') {
					unset($submenu['themes.php'][$key]);
					break;
			  }
		  }
		}
		/* Redirect menue from index page
		*@since 	0.1
		*/
		function menu_redirect() {
		  $result = stripos($_SERVER['REQUEST_URI'], 'menus.php');
		  if ($result!==false) {
			wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
		  }
		}
		/**
		 * Enqueue stylesheaet
		 * @since 	0.1
		 */
		function style() {
			wp_register_style( 'featured-image-column', apply_filters( 'Custom_Functions_Starter_Kit_css', plugin_dir_url( __FILE__ ) . 'css/column.css' ), null, self::version );
			wp_enqueue_style( 'featured-image-column' );
		}
		
		/**
		 * Filter the image in before the 'title'
		 */
		function columns( $columns ) {
		 $get_feature_image_val=get_option(self::$prefix1 . 'settings');
 
			if ( !is_array( $columns ) )
				$columns = array();
			
			$new = array();
			
			foreach( $columns as $key => $title ) {
			if($get_feature_image_val['check_image']==1){

				if ( $key == 'title' ) // Put the Thumbnail column before the Title column
					$new['featured-image'] = __( 'Image', self::domain );
					}
				$new[$key] = $title;
			}
			
			return $new;
		}
		
		/**
		 * Hooks to 'register_activation_hook'
		 *
		 * @since 1.0.0
		 */
		static function register_activation() {
		
			/* Check if multisite, if so then save as site option */

			if (is_multisite()) {
				add_site_option(self::$prefix1 . 'version', GENERAL_VERSION_NUM);
			} else {
				add_option(self::$prefix1 . 'version', GENERAL_VERSION_NUM);
			}
		}
		/**
		 * Hooks to 'plugin_action_links_' filter
		 *
		 * @since 1.0.0
		 */
		static function plugin_links($links) {
			$settings_link = '<a href="admin.php?page=' . self::$settings_page1 . '">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}
		/**
		 * Hooks to 'admin_menu'
		 *
		 * @since 1.0.0
		 */
		static function menu_page() {

			/* Add the menu Page */

			add_menu_page(
				__('starter kit', self::$text_domain1),							// Page Title
				__('starter kit', self::$text_domain1), 							// Menu Name
				'manage_options', 											// Capabilities
				self::$settings_page1, 										// slug
				array('custom_functions_starter_kit', 'admin_settings')	// Callback function
			);

			/* Cast the first sub menu to the top menu */

			$settings_page_load = add_submenu_page(
				self::$settings_page1, 										// parent slug
				__('Settings', self::$text_domain1), 						// Page title
				__('Settings', self::$text_domain1), 						// Menu name
				'manage_options', 											// Capabilities
				self::$settings_page1, 										// slug
				array('custom_functions_starter_kit', 'admin_settings')	// Callback function
			);
			//add_action("admin_print_scripts-$settings_page_load", array('custom_functions_starter_kit', 'include_admin_scripts'));
		}
		function set_account_pages() {
		remove_post_type_support( 'post', 'author' );
		}
		/**
		 * Displays the HTML for the 'custom-function-starter-kit-admin-menu-settings' admin page
		 *
		 * @since 1.0.0
		 */
		static function admin_settings() {		
			global $settings; 
			$settings = get_option(self::$prefix1 . 'settings');
			/* Default values */

			if ($settings === false) {
				$settings = self::$default;
			}

			/* Save data nd check nonce */

			if (isset($_POST['submit']) && check_admin_referer(self::$prefix1 . 'admin_settings')) {
				$settings = get_option(self::$prefix1 . 'settings');
				/* Default values */
				if ($settings === false) {
					$settings = self::$default;
				}
				$settings = array(	
					'check_image'	=> isset($_POST[self::$prefix1 . 'check_image']) && $_POST[self::$prefix1 . 'check_image'] ? true : false,
					'check_post'	=> isset($_POST[self::$prefix1 . 'check_post']) && $_POST[self::$prefix1 . 'check_post'] ? true : false,
					'login_error'	=> isset($_POST[self::$prefix1 . 'login_error']) && $_POST[self::$prefix1 . 'login_error'] ? true : false,
					'check_update'	=> isset($_POST[self::$prefix1 . 'check_update']) && $_POST[self::$prefix1 . 'check_update'] ? true : false,
					'check_upload_file'	=> isset($_POST[self::$prefix1 . 'check_upload_file']) && $_POST[self::$prefix1 . 'check_upload_file'] ? true : false,
					'check_image_quality'	=> isset($_POST[self::$prefix1 . 'check_image_quality']) && $_POST[self::$prefix1 . 'check_image_quality'] ? true : false,
					'check_Self-Pinging'	=> isset($_POST[self::$prefix1 . 'check_Self-Pinging']) && $_POST[self::$prefix1 . 'check_Self-Pinging'] ? true : false,
					'check_meta'	=> isset($_POST[self::$prefix1 . 'check_meta']) && $_POST[self::$prefix1 . 'check_meta'] ? true : false,
					'check_widgets'	=> isset($_POST[self::$prefix1 . 'check_widgets']) && $_POST[self::$prefix1 . 'check_widgets'] ? true : false,
					'check_remove_metabox'	=> isset($_POST[self::$prefix1 . 'check_remove_metabox']) && $_POST[self::$prefix1 . 'check_remove_metabox'] ? true : false,
					'check_author_link'	=> isset($_POST[self::$prefix1 . 'check_author_link']) && $_POST[self::$prefix1 . 'check_author_link'] ? true : false,
					'check_post_revision'	=> isset($_POST[self::$prefix1 . 'check_post_revision']) && $_POST[self::$prefix1 . 'check_post_revision'] ? true : false,
					'check_link'	=> isset($_POST[self::$prefix1 . 'check_link']) && $_POST[self::$prefix1 . 'check_link'] ? true : false,
					'check_admin'	=> isset($_POST[self::$prefix1 . 'check_admin']) && $_POST[self::$prefix1 . 'check_admin'] ? true : false,
					'check_auto_update'	=> isset($_POST[self::$prefix1 . 'check_auto_update']) && $_POST[self::$prefix1 . 'check_auto_update'] ? true : false,
					'check_rss'	=> isset($_POST[self::$prefix1 . 'check_rss']) && $_POST[self::$prefix1 . 'check_rss'] ? true : false
					
					
				);
				update_option(self::$prefix1 . 'settings', $settings);
				
				
/*				
//add_action('admin_enqueue_scripts', 'my_admin_scripts');
wp_enqueue_media();
 wp_register_script( 'my-plugin-script', plugins_url( 'js/image.js', __FILE__ ) );
		//wp_register_script('my-admin-js', WP_PLUGIN_URL.'/js/image.js', array('jquery'));
		wp_enqueue_script('my-plugin-script');*/
				
			}
			require('admin/settings.php');
		}


		/**
		 * Output the image
		 */
		function column_data( $column_name, $post_id ) {
			global $post;
			
			if ( 'featured-image' != $column_name )
				return;			
			
			$image_src = self::get_the_image( $post_id );
						
			if ( empty( $image_src ) ) {
				echo "&nbsp;"; // This helps prevent issues with empty cells
				return;
			}
			
			echo '<img alt="' . esc_attr( get_the_title() ) . '" src="' . esc_url( $image_src ) . '" />';
		}
		
		/**
		 * Allowed post types
		 *
		 * @since 	0.2
		 * @ref		http://wordpress.org/support/topic/plugin-featured-image-column-filter-for-post-types?replies=5
		 */
		function included_post_types( $post_type ) {
			
			$post_types = array();
			$get_post_types = get_post_types();
			
			foreach ( $get_post_types as $type )
				if ( post_type_supports( $type, 'thumbnail' ) )
					$post_types[] = $type;
			
			$post_types = apply_filters( 'Custom_Functions_Starter_Kit_post_types', $post_types );
			
			if ( defined( 'WP_LOCAL_DEV' ) && WP_LOCAL_DEV ) {
				print_r( $post_types );
			}
			
			if ( in_array( $post_type, $post_types ) )
				return true;
			else
				return false;
		}
		
		/**
		 * Function to get the image
		 *
		 * @since	0.1
		 * @updated	0.1.3 - Added wp_cache_set()
		 * @updated 0.1.9 - fixed persistent cache per post_id
		 *		@ref	http://www.ethitter.com/slides/wcmia-caching-scaling-2012-02-18/#slide-11
		 */
		function get_the_image( $post_id = false ) {			
			$post_id	= (int)$post_id;
			$cache_key	= "featured_image_post_id-{$post_id}-_thumbnail";
			$cache		= wp_cache_get( $cache_key, null );
			
			if ( !is_array( $cache ) )
				$cache = array();
		
			if ( !array_key_exists( $cache_key, $cache ) ) {
				if ( empty( $cache) || !is_string( $cache ) ) {
					$output = '';
						
					if ( has_post_thumbnail( $post_id ) ) {
						$image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), array( 36, 32 ) );
						
						if ( is_array( $image_array ) && is_string( $image_array[0] ) )
							$output = $image_array[0];
					}
					
					if ( empty( $output ) ) {
						$output = plugins_url( 'images/default.png', __FILE__ );
						$output = apply_filters( 'Custom_Functions_Starter_Kit_default_image', $output );
					}
					
					$output = esc_url( $output );
					$cache[$cache_key] = 
					$output;
					
					wp_cache_set( $cache_key, $cache, null, 60 * 60 * 24 /* 24 hours */ );
				}
			}

			return $output;
		}

	}	
	$Custom_Functions_Starter_Kit = new Custom_Functions_Starter_Kit();

};