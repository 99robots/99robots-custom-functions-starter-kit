<?php
/**
 * Plugin Name:        Custom Functions Starter Kit
 * Plugin  URI:        https://draftpress.com/plugins/custom-functions-starter-kit/
 * Description:        The Custom Functions Start Kit offers over a dozen easy to use fixes and functions for your WordPress site.
 * Version:            2.1.6
 * Author:            DraftPress
 * Author URI:        https://draftpress.com
 * License:            GPL2
 * Text Domain:        'nnr-custom-functions'
 * Domain Path:        /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Include Base Class.
 * From which all other classes are derived.
 */
include_once dirname(__FILE__) . '/class-custom-functions-base.php';

/**
 *  Custom_Functions main class
 *
 * @since 1.0.0
 */
class Custom_Functions extends Custom_Functions_Base
{

    /**
     * Custom_Functions version.
     * @var string
     */
    public $version = '2.1.6';

    /**
     * The single instance of the class.
     * @var Custom_Functions
     */
    protected static $_instance = null;

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
        'checkbox-1' => false,
        'checkbox-2' => false,
        'checkbox-3' => false,
        'checkbox-4' => false,
        'checkbox-5' => false,
        'checkbox-6' => false,
        'checkbox-7' => false,
        'checkbox-8' => false,
        'checkbox-9' => false,
        'checkbox-10' => false,
        'checkbox-11' => false,
        'checkbox-12' => false,
        'checkbox-13' => false,
        'checkbox-14' => false,
        'checkbox-15' => false,
        'checkbox-16' => false,
        'checkbox-17' => false,
        'checkbox-18' => false,
        'checkbox-19' => false,
        'checkbox-20' => false,
        'checkbox-21' => false,
        'checkbox-22' => false,
    );

    /**
     * Plugin url.
     * @var string
     */
    private $plugin_url = null;

    /**
     * Plugin path.
     * @var string
     */
    private $plugin_dir = null;

    /**
     * Hold plugin settings
     * @var boolean|array
     */
    private $settings = false;

    /**
     * Cloning is forbidden.
     */
    public function __clone()
    {
        wc_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'nnr-custom-functions'), $this->version);
    }

    /**
     * Unserializing instances of this class is forbidden.
     */
    public function __wakeup()
    {
        wc_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'nnr-custom-functions'), $this->version);
    }

    /**
     * Main Custom_Functions instance.
     *
     * Ensure only one instance is loaded or can be loaded.
     *
     * @return Custom_Functions
     */
    public static function instance()
    {

        if (is_null(self::$_instance) && !(self::$_instance instanceof Custom_Functions)) {
            self::$_instance = new Custom_Functions();
            self::$_instance->includes();
            self::$_instance->hooks();
        }

        return self::$_instance;
    }

    /**
     * Custom_Functions constructor.
     */
    private function __construct()
    {

    }

    /**
     * Include required core files used in admin and on the frontend.
     * @return void
     */
    private function includes()
    {

    }

    /**
     * Add hooks to begin.
     * @return void
     */
    private function hooks()
    {

        $plugin = plugin_basename(__FILE__);

        $this->add_action('plugins_loaded', 'load_plugin_textdomain');
        $this->add_filter("plugin_action_links_$plugin", 'plugin_links');
        $this->add_action('init', 'do_custom_functions');
        $this->add_action('pre_ping', 'disable_self_ping');
        $this->add_filter('pre_get_posts', 'posts_for_current_author');
        $this->add_filter('the_excerpt_rss', 'featured_image_in_rss');
        $this->add_filter('the_content_feed', 'featured_image_in_rss');
        $this->add_filter('wp_revisions_to_keep', 'disable_post_revisions', 10, 2);

        // Admin Only
        if (is_admin()) {
            $this->add_action('admin_init', 'do_admin_functions');
            $this->add_action('admin_menu', 'register_pages');
            $this->add_action('admin_notices', 'handle_admin_notices');
            $this->add_action('admin_head', 'hide_core_update');
            $this->add_action('admin_print_scripts-profile.php', 'hide_admin_bar_settings');

            // Add Thumbnails in Manage Posts/Pages List
            $this->add_filter('manage_posts_columns', 'add_thumb_column');
            $this->add_filter('manage_pages_columns', 'add_thumb_column');
            $this->add_action('manage_posts_custom_column', 'add_thumb_value', 10, 2);
            $this->add_action('manage_pages_custom_column', 'add_thumb_value', 10, 2);
        }
    }

    /**
     * Load the plugin text domain for translation.
     * @return void
     */
    public function load_plugin_textdomain()
    {

        $locale = apply_filters('plugin_locale', get_locale(), 'nnr-custom-functions');

        load_textdomain(
            'nnr-custom-functions',
            WP_LANG_DIR . '/99robots-custom-functions-starter-kit/99robots-custom-functions-starter-kit-' . $locale . '.mo'
        );

        load_plugin_textdomain(
            'nnr-custom-functions',
            false,
            $this->plugin_dir() . '/languages/'
        );
    }

    /**
     * Hooks to 'plugin_action_links_' filter
     *
     * @since 1.0.0
     */
    public function plugin_links($links)
    {

        $settings_link = '<a href="tools.php?page=' . self::$settings_page . '">Settings</a>';
        array_unshift($links, $settings_link);

        return $links;
    }

    /**
     * Register setting page
     *
     * @since 1.0.0
     */
    public function register_pages()
    {

        // Cast the first sub menu to the tools menu
        $settings_page_load = add_submenu_page(
            'tools.php',
            esc_html__('Custom Functions', 'nnr-custom-functions'),
            esc_html__('Custom Functions', 'nnr-custom-functions'),
            'manage_options',
            self::$settings_page,
            array($this, 'page_settings')
        );
        $this->add_action("load-$settings_page_load", 'enqueue_scripts');
    }

    /**
     * Enqueue styles and scripts
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {

        // Styles
        wp_enqueue_style(self::$prefix . 'settings_css', $this->plugin_url() . 'css/settings.css');
        wp_enqueue_style(self::$prefix . 'bootstrap_css', $this->plugin_url() . 'css/nnr-bootstrap.min.css');
        wp_dequeue_style('forms');

        // Scripts
        wp_enqueue_script(self::$prefix . 'bootstrap_js', $this->plugin_url() . 'include/bootstrap-3.2.0-dist/js/bootstrap.js', array('jquery'));
    }

    /**
     * Displays the HTML for the 'general-admin-menu-settings' admin page
     *
     * @since 1.0.0
     */
    public function page_settings()
    {

        $settings = $this->get_settings();

        // Save data and check nonce
        if (isset($_POST['submit']) && check_admin_referer(self::$prefix . 'admin_settings')) {

            for ($i = 1; $i <= 22; $i++) {
                $key = 'checkbox-' . $i;
                $settings[$key] = isset($_POST[self::$prefix . $key]) && $_POST[self::$prefix . $key] ? true : false;
            }

            update_option(self::$prefix . 'settings', $settings);
        }

        require 'admin/settings.php';
    }

    /**
     * Checks $settings and enables individual functions
     *
     * @since 1.0.0
     */
    public function do_custom_functions()
    {

        $settings = $this->get_settings();

        // Hide WordPress Version & Meta Data
        if (!is_admin() && isset($settings['checkbox-1']) && $settings['checkbox-1']) {
            remove_action('wp_head', 'wp_generator');
            // Pick out the version number from scripts and styles
            function remove_version_from_style_js($src)
            {
                if (strpos($src, 'ver=' . get_bloginfo('version'))) {
                    $src = remove_query_arg('ver', $src);
                }

                return $src;
            }
            add_filter('style_loader_src', 'remove_version_from_style_js');
            add_filter('script_loader_src', 'remove_version_from_style_js');

        }

        // Hide WordPress Login Errors
        if (isset($settings['checkbox-2']) && $settings['checkbox-2']) {
            $this->add_filter('login_errors', 'something_is_wrong');
        }

        // Disable WordPress Automatic Updates
        if (isset($settings['checkbox-4']) && $settings['checkbox-4']) {
            add_filter('allow_minor_auto_core_updates', '__return_false');
        } else {
            add_filter('allow_minor_auto_core_updates', '__return_true');
        }

        // Disable WordPress admin bar from all users except admin
        if (isset($settings['checkbox-22']) && $settings['checkbox-22'] && !current_user_can('administrator')) {
            add_filter('show_admin_bar', '__return_false');
        }
    }

    public function something_is_wrong()
    {
        return esc_html__('Something is wrong!', 'nnr-custom-functions');
    }

    /**
     * Checks $settings and handles admin notices
     *
     * @since 1.0.0
     */
    public function handle_admin_notices()
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-3']) && $settings['checkbox-3']) {

            // Get user by login name 'admin'
            $bloguser = get_user_by('login', 'admin');

            // Check if object exists
            if ($bloguser) {

                // Double-check if object is 'admin'
                if ('admin' === $bloguser->user_login) {

                    // check if administrator
                    if (current_user_can('manage_options')) {

                        // Display admin notice
                        echo '<div class="error"><p>';
                        echo wp_kses_post(__('WARNING! An administrator is using the "admin" username, which is highly targetted by <a href="https://draftpress.com/wordpress-security-checklist/">brute force bot-net attacks</a>. Please create a new administrator user and delete the "admin" username.', 'nnr-custom-functions'));
                        echo '</p></div>';
                    }
                }
            }
        }
    }

    /**
     * Checks $settings and enables individual functions
     *
     * @since 1.0.0
     */
    public function do_admin_functions()
    {

        $settings = $this->get_settings();

        // Checks $settings and hides plugin and theme editors
        if (isset($settings['checkbox-5']) && $settings['checkbox-5']) {
            remove_submenu_page('themes.php', 'theme-editor.php');
            remove_submenu_page('plugins.php', 'plugin-editor.php');
        }

        // Checks $settings and allows contributors to upload images
        $contributor = get_role('contributor');
        if (isset($settings['checkbox-20']) && $settings['checkbox-20']) {
            $contributor->add_cap('upload_files');
        } else {
            $contributor->remove_cap('upload_files');
        }
    }

    /**
     * Checks $settings and Hide WP Update notice from non-admins
     *
     * @since 1.0.0
     */
    public function hide_core_update()
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-6']) && $settings['checkbox-6']) {

            if (!current_user_can('update_core')) {
                remove_action('admin_notices', 'update_nag', 3);
            }
        }
    }

    /**
     * Checks $settings and Hide WP admin bar settings from non-admins
     *
     * @since 1.0.0
     */
    public function hide_admin_bar_settings()
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-22']) && $settings['checkbox-22'] && !current_user_can('administrator')): ?>

			<style type="text/css"> .show-admin-bar { display: none; } </style>
		<?php
endif;
    }

    /**
     * Checks $settings and adds thumnail column to admin list
     * @since 1.0.0
     */
    public function add_thumb_column($cols)
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-10']) && $settings['checkbox-10']) {
            $cols['thumbnail'] = __('Thumbnail');
        }

        return $cols;
    }

    /**
     * Checks $settings and adds thumbnails to thumbnail column
     * @since 1.0.0
     */
    public function add_thumb_value($column_name, $post_id)
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-10']) && $settings['checkbox-10']) {

            $width = (int) 60;
            $height = (int) 60;

            if ('thumbnail' === $column_name) {

                if ($thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true)) {
                    echo wp_get_attachment_image($thumbnail_id, array($width, $height), true);

                    return;
                }

                // Image from gallery
                $attachments = get_children(array(
                    'post_parent' => $post_id,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                ));

                if (!empty($attachments)) {
                    foreach ($attachments as $attachment_id => $attachment) {
                        $thumb = wp_get_attachment_image($attachment_id, array($width, $height), true);
                        if ($thumb) {
                            echo $thumb;
                            return;
                        }
                    }
                }

                echo esc_html__('None', 'nnr-custom-functions');
            }
        }
    }

    /**
     * Checks $settings and disables self pinging
     * @since 1.0.0
     */
    public function disable_self_ping(&$links)
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-13']) && $settings['checkbox-13']) {

            $home = get_option('home');

            foreach ($links as $l => $link) {

                if (0 === strpos($link, $home)) {

                    unset($links[$l]);
                }
            }
        }
    }

    /**
     * Checks $settings and prevents authors from seeing other posts
     * @since 1.0.0
     */
    public function posts_for_current_author($query)
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-21']) && $settings['checkbox-21'] && !current_user_can('manage_options')) {

            global $user_ID;
            $query->set('author', $user_ID);
        }

        return $query;
    }

    /**
     * Checks $settings and display image in rss feeds
     * @since 1.0.0
     */
    public function featured_image_in_rss($content)
    {

        global $post;

        $settings = $this->get_settings();

        if (isset($settings['checkbox-12']) && $settings['checkbox-12'] && has_post_thumbnail($post->ID)) {
            $content = get_the_post_thumbnail($post->ID, 'large', array('style' => 'margin-bottom:10px;')) . $content;
        }

        return $content;
    }

    /**
     * Checks $settings and disables post revisions
     * @since 1.0.0
     */
    public function disable_post_revisions($num, $post)
    {

        $settings = $this->get_settings();

        if (isset($settings['checkbox-11']) && $settings['checkbox-11']) {

            // Set limit to 1 post
            $num = 1;

        } else {

            // Reset to unlimited saved posts
            $num = -1;
        }

        return $num;

    }

    // Options -----------------------------------------------------------

    public function generate_settings($title = '', $fields)
    {

        $settings = $this->get_settings();
        $codex_page = '&nbsp;-&nbsp;<a href="https://draftpress.com/docs/custom-functions-starter-kit/">Learn More</a>';
        ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $title ?></h3>
			</div>
			<div class="panel-body">

				<?php
foreach ($fields as $field):
            $fullopid = self::$prefix . 'checkbox-' . $field['id'];
            $settopid = 'checkbox-' . $field['id'];
            ?>
									<div class="form-group">

										<div class="pull-left">
											<input type="checkbox" id="<?php echo $fullopid ?>" name="<?php echo $fullopid ?>" class="form-control"<?php echo isset($settings[$settopid]) && $settings[$settopid] ? ' checked="checked"' : ''; ?>>
										</div>

										<label for="<?php echo $fullopid ?>" class="col-sm-9 pull-left">
											<?php
    echo $field['title'];

            if (isset($field['is_codex']) && $field['is_codex']) {
                echo $codex_page;
            }
            ?>
										</label>

										<div class="clearfix"></div>

										<?php if (isset($field['help']) && $field['help']): ?>
										<em class="help-block">
											<?php echo wp_kses_post($field['help']) ?>
										</em>
										<?php endif;?>

				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php
}

    public function get_general_settings()
    {
        $settings = array(

            array(
                'id' => '1',
                'title' => esc_html__('Hide WordPress Version & Meta Data (recommended)', 'nnr-custom-functions'),
                'help' => esc_html__('This will prevent hackers from discovering your WP version number.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '2',
                'title' => esc_html__('Hide WordPress Login Errors (recommended)', 'nnr-custom-functions'),
                'help' => esc_html__('Prevent users from seeing the default WP login errors, which may lead to hackers guessing registered usernames.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '3',
                'title' => esc_html__('Check for "Admin" Security Vulnerability (recommended)', 'nnr-custom-functions'),
                'help' => esc_html__('Checks WP for the username "admin" (an easy target for hackers) and notifies the site owner.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '4',
                'title' => esc_html__('Disable WordPress Automatic Updates', 'nnr-custom-functions'),
                'help' => esc_html__('Disables WP from automatically updating the core files.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '5',
                'title' => esc_html__('Disable Theme and Plugin Editors', 'nnr-custom-functions'),
                'help' => esc_html__('Removes the theme and plugin editor from all users, limiting hackers (or users) from damaging your site if they gain access.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '6',
                'title' => esc_html__('Show WordPress Update Notification to Admins Only', 'nnr-custom-functions'),
                'help' => esc_html__('This will remove the "WordPress Update" notification from non-admin users.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),
        );

        return apply_filters('custom_functions_general_settings', $settings);
    }

    public function get_general_content_settings()
    {
        $settings = array(

            array(
                'id' => '10',
                'title' => esc_html__('Display the Featured Image on the "All Posts" Admin Screen', 'nnr-custom-functions'),
                'help' => esc_html__('This will add a column in the "All Posts" admin screen that will display the featured image of the post.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '11',
                'title' => esc_html__('Disable Post Revisions', 'nnr-custom-functions'),
                'help' => esc_html__('Save room in your database by disabling post revisions except one autosave.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '12',
                'title' => esc_html__('Include Featured Image in RSS Feed', 'nnr-custom-functions'),
                'help' => esc_html__('Adds the featured image to the RSS feed.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '13',
                'title' => esc_html__('Disable Self-Pinging', 'nnr-custom-functions'),
                'help' => esc_html__('Prevents WordPress from sending and showing a ping to your site from your site.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),
        );

        return apply_filters('custom_functions_general_content_settings', $settings);
    }

    public function get_general_user_settings()
    {
        $settings = array(

            array(
                'id' => '20',
                'title' => esc_html__('Allow Contributors to Upload Photos', 'nnr-custom-functions'),
                'help' => esc_html__('This will give the user role "contributor" permission to upload images.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '21',
                'title' => esc_html__('Restrict Authors to View Only Their Own Posts', 'nnr-custom-functions'),
                'help' => esc_html__('This will prevent authors from viewing any content besides their own.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),

            array(
                'id' => '22',
                'title' => esc_html__('Hide Admin Bar from Non-Admins', 'nnr-custom-functions'),
                'help' => esc_html__('Hides the WP admin bar from all users except administrators.', 'nnr-custom-functions'),
                'is_codex' => true,
            ),
        );

        return apply_filters('custom_functions_general_user_settings', $settings);
    }

    // Helpers -----------------------------------------------------------

    /**
     * Get plugin directory.
     * @return string
     */
    public function plugin_dir()
    {

        if (is_null($this->plugin_dir)) {
            $this->plugin_dir = untrailingslashit(plugin_dir_path(__FILE__)) . '/';
        }

        return $this->plugin_dir;
    }

    /**
     * Get plugin uri.
     * @return string
     */
    public function plugin_url()
    {

        if (is_null($this->plugin_url)) {
            $this->plugin_url = untrailingslashit(plugin_dir_url(__FILE__)) . '/';
        }

        return $this->plugin_url;
    }

    /**
     * Get settings.
     *
     * @return array
     */
    public function get_settings()
    {

        $settings = get_option(self::$prefix . 'settings');

        // Default values
        if (false === $settings) {
            $settings = self::$default;
        }

        return $settings;
    }

    /**
     * Get plugin version
     *
     * @return string
     */
    public function get_version()
    {
        return $this->version;
    }
}

/**
 * Main instance of Custom_Functions.
 *
 * Returns the main instance of Custom_Functions to prevent the need to use globals.
 *
 * @return Custom_Functions
 */
function custom_functions()
{
    return Custom_Functions::instance();
}

// Init the plugin.
custom_functions();
