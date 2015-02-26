<?php

	/* if uninstall not called from WordPress exit */

	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit ();

	/* Delete all existence of this plugin */

	global $wpdb;

	if ( !is_multisite() ) {

		/* Delete blog option */

		delete_option('nnr_custom_functions_version');
		delete_option('nnr_custom_functions_settings');
	}

	else {

		/* Delete site option */

		delete_site_option('nnr_custom_functions_version');

		/* Used to delete each option from each blog */

	    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

	    foreach ( $blog_ids as $blog_id ) {
	        switch_to_blog( $blog_id );

	        /* Delete blog option */

			delete_option('nnr_custom_functions_settings');
	    }

	    restore_current_blog();
	}
?>