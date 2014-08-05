=== Featured Image Column ===
Contributors: austyfrosty, DH-Shredder, MartyThornley, chrisjean,
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XQRHECLPQ46TE
Tags: featured image, admin, column
Requires at least: 3.0
Tested up to: 3.8
Stable tag: trunk

Adds a column to the edit screen with the featured image if it exists.

== Description ==

This plugin has no options. It simply adds a column before the title (far left) the show's the posts featured image if it's supported and/or exists.

Add a defualt image simply by filtering you own image in. Use `featured_image_column_default_image` or filter your own CSS by using `featured_image_column_css`.

**Add support for a custom default image**

`
function my_custom_featured_image_column_image( $image ) {
	if ( !has_post_thumbnail() )
		return trailingslashit( get_stylesheet_directory_uri() ) . 'images/featured-image.png';
}
add_filter( 'featured_image_column_default_image', 'my_custom_featured_image_column_image' );
`

**Add/remove support for post types**

`
function my_custom_featured_image_column_post_type( $post_types ) {
	foreach( $post_types as $key => $post_type ) {
		if ( 'post-type' === $post_type ) // Post type you'd like removed. Ex: 'post' or 'page'
			unset( $post_types[$key] );
	}
	return $post_types;
}
add_filter( 'featured_image_column_post_types',	'my_custom_featured_image_column_post_type', 13 );
`

**Add your own CSS to change the size of the image.**

`
/**
 * @use '.featured-image.column-featured-image img {}'
 */
function my_custom_featured_image_css() {
	return trailingslashit( get_stylesheet_directory_uri() ) . 'css/featured-image.css'; //URL to your css
}
add_filter( 'featured_image_column_css', 'my_custom_featured_image_css' );
`

For question please visit my blog @ [http://austinpassy.com](http://austinpassy.com/wordpress-plugins/featured-image-column/)

== Installation ==

Follow the steps below to install the plugin.

1. Upload the `featured-image-column` directory to the /wp-content/plugins/ directory. OR click add new plugin in your WordPress admin.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Nothing yet =

== Screenshots ==

1. Post edit.php screen.

== Changelog ==

= Version 0.2.1 (12/3/13) =

* Fixed custom post type support.

= Version 0.2.0 (12/2/13) =

* Updated version to WordPress 3.8 compatable and PHP 5.3+
* Added new filter `featured_image_column_post_types` for post type support (add/remove).
* Removed closing PHP.

= Version 0.1.10 (9/5/13) =

* Fixed `PHP Deprecated:  Assigning the return value of new by reference is deprecated in /featured-image-column/featured-image-column.php on line 157`.

= Version 0.1.9 (3/11/12) =

* Fixed repeat images per posts.
* Added filter to style sheet, (use your own CSS to make the thumbnail bigger).

= Version 0.1.8 (2/16/12) =

* Updated `wp_cache_set/get`

= Version 0.1.7 (1/18/12) =

* Tried to update some code to fix repeated images.

= Version 0.1.6 (11/21/11) =

* Code edits by Chris Jean of ithemes.com.

= Version 0.1.5 (10/18/11) =

* Fixed latest post image showing up across all posts.
* Reset the query check.

= Version 0.1.4 (10/17/11) =

* Added filter for `post_type`'s, thanks to [Bill Erickson](http://wordpress.org/support/topic/plugin-featured-image-column-filter-for-post-types?replies=1)
* Fixed error when zero posts exists (very rare).

= Version 0.1.3 (10/17/11) =

* Added a light caching script for the images.
* Updated a contributors .org profile name.

= Version 0.1.2 (9/30/11) =

* Removed PHP4 constructor.
* TODO: Fix error when no posts exists.

= Version 0.1.1 (9/20/11) =

* Add support for public `$post_type`'s that support `'post-thumbnails'`.

= Version 0.1 (9/14/11) =

* Initial release.

== Upgrade Notice ==

= 0.2.1 =

* Happy holidays! If you like the updates please consider donating. PayPal: austin@thefrosty.com. WP 3.8 and PHP 5.3+ compat.

= 0.1.9 =

* Happy 311 day! Finally fixed duplicate image output. Yay for cache array().

= 0.1.7 =

* Working on fixed repeating images.

= 0.1.6 =

* Cleaned up code thanks to Chris @ iThemes. All errors should be suppressed and clear.

= 0.1.2 =

* Code cleanup, attempt at fixing a fatal error when no posts exist (still in progress).

= 0.1.1 =

* Adds support for public $post_type's that support 'post-thumbnails'.