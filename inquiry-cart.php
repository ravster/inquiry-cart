<?php
	/*
	Plugin Name: RaviDesai inquiry cart plugin
	Plugin URI: ravidesai.com
	Author: Ravi Desai
	Author URI: ravidesai.com
	Version: 0
	Description: Add an inquiry cart to your website that allows end-users to ask questions about posts or products.
	License: AGPLv3 or later
	*/
/*
	This plugin has been inspired by the 'quote-cart' plugin by http://churchmediaresource.com/
	Thank you
*/

/*
	Activate the plugin
*/
register_activation_hook( __FILE__, 'rd_ic_plugin_activate' );
function rd_ic_plugin_activate(){
	// array of information that the plugin requires
	$options = array(
		'email_to' => get_option('admin_email'),
		'email_subject' => get_option('blogname') . ' - My inquiries',
		'msg_fail' => '<p>Failed sending email</p>',
		'msg_sent' => '<p>Inquiry sent</p>'
	);
	add_option( 'rd_ic_options', $options );
}


/*
	Make sure sessions are running.
*/
add_action( 'init', 'rd_ic_init_sessions' );
function rd_ic_init_sessions(){
	// If there is no session made, make one.
	if( !session_id() )
		session_start();

	// Create the session variable if it does not exist
	if( !isset( $_SESSION['rd_ic'] ) )
		$_SESSION['rd_ic'] = array();
}


/*
	Menu code
*/

// Add menu page
add_action( 'admin_menu', 'rd_ic_create_menu' );
function rd_ic_create_menu() {
// This function adds the menu page for the Inquiry cart plugin.
// This is kept as a submenu of the 'Settings' menu.  Hence we are using 'add_options_page' instead of 'add_menu_page'.
	add_options_page( 'Inquiry Cart', // Page title
		'Inquiry Cart', // Menu title in the admin bar
		'manage_options', // Capability of the user for this to be shown
		__FILE__, // slug of this menu
		'rd_ic_settings_page' // Function to call
	);
}

function rd_ic_settings_page(){
// Display the settings page.
	include_once( plugin_dir_path( __FILE__ ) . 'includes/settings-page.php' );
}


/*
	Shortcode
*/

// We want a shortcode that goes into a post (Or page) that will either add or remove an item from the cart.
// We also want a shortcode that goes into a page that will serve as the inquiry cart itself, with the form that needs to be sent along with the list of items that the end-user is inquiring about.

// Shortcode for adding and removing an item from the cart
include_once( plugin_dir_path( __FILE__ ) . 'includes/add-remove-shortcode.php' );

// Shortcode for the inquiry cart
include_once( plugin_dir_path( __FILE__ ) . 'includes/inquiry-cart-shortcode.php' );
