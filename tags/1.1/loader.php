<?php
/*
Plugin Name: BuddyPress Group Tiny Chat
Plugin URI: http://wordpress.org/extend/plugins/bp-group-tinychat/
Description: This plugin base on bp-group-livechat of  David Cartwright, thanks to him. chat room for groups use tinychat, with pro version ( goto <a href="http://teen-diary.com/wp-plugins/" ></a> )user can login to chat room auto with wordpress username. If you are using Advanced AJAX Page Loader or Ajaxify Wordpress Site(AWS), please add "group-chat" to "HREF Ignore List" in setting box of that plugin.
Version: 1.1
Revision Date: Feb 2 2013
Requires at least: WordPress 3.1.0, BuddyPress 1.2.8
Tested up to: WordPress 3.7 / BuddyPress 1.8.1
License: AGPL
Author: Van dat
Author URI: http://wordpress.org/extend/plugins/bp-group-tinychat/
Site Wide Only: true
*/

/* Only load the component if BuddyPress is loaded and initialized. */
function bp_group_tinychat_init() {
	require( dirname( __FILE__ ) . '/includes/bp-group-tinychat-core.php' );
}
add_action( 'bp_init', 'bp_group_tinychat_init' );

// create the tables
function bp_group_tinychat_activate() {
	global $wpdb;

	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

	$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_group_tinychat (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  		group_id bigint(20) NOT NULL,
		  		user_id bigint(20) NOT NULL,
		  		message_content text
		 	   ) {$charset_collate};";

	$sql[] = "CREATE TABLE {$wpdb->base_prefix}bp_group_tinychat_online (
		  		id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  		group_id bigint(20) NOT NULL,
		  		user_id bigint(20) NOT NULL,
		  		timestamp int(11) NOT NULL
		 	   ) {$charset_collate};";

	require_once( ABSPATH . 'wp-admin/upgrade-functions.php' );

	dbDelta($sql);

	update_site_option( 'bp-group-tinychat-db-version', BP_GROUP_tinychat_DB_VERSION );
}
register_activation_hook( __FILE__, 'bp_group_tinychat_activate' );

?>