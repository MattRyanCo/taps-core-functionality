<?php
/**
 * Tweak and manage media
 *
 * This file includes any customizations to media and library management 
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/capwebsolutions/taps-core-functionality
 * @author       Matt Ryan <matt@capwebsolutions.com>
 * @copyright    Copyright (c) 2026, Cap Web Solutions
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

 /**
 * Change color of admin bar if using dev site. 
 */
function devsite_admin_bar() {
	$site_url = site_url();
	// Local Dev site
	if ( strpos( $site_url, '.local' ) !== false || 
		strpos($site_url, '.test') !== false || 
		strpos($site_url, '.dev') !== false) {
			echo '<style>#wpadminbar { background-color: #996a29; }</style>';
		}

	// Live Staging site 
	if ( strpos( $site_url, 'staging.') !== false || 
		strpos($site_url, 'penncat.capwebsolutions.com') !== false) {
			echo '<style>#wpadminbar { background-color: #ff0000; }</style>';
		}
}
add_action('admin_head', 'devsite_admin_bar');
add_action('wp_head', 'devsite_admin_bar');

// Change Howdy in admin area. 

function change_howdy_greeting( $wp_admin_bar ) {
    $user_id = get_current_user_id();
    $user = get_userdata( $user_id );
    
    if ( $user ) {
        $greeting = 'Hello, you are logged in as ' . $user->display_name;
        $wp_admin_bar->add_menu( array(
            'id'    => 'my-account',
            'title' => $greeting,
        ) );
    }
}
add_action( 'admin_bar_menu', 'change_howdy_greeting', 10 );

function reusable_blocks_admin_menu() {
/**
 * Reusable Blocks accessible in backend under Appearence nav 
 * 
 * @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
 * 
 * @since    1.0.0
 *
 */

// Load this function in private function define_admin_hooks in class Ccphoto_Core_Functionality 

	add_submenu_page( 'themes.php', 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '' );

}
add_action( 'admin_menu', 	'reusable_blocks_admin_menu', 10 );