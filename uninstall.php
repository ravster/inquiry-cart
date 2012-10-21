<?php
// If uninstall not called from wordpress, exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

// Delete the options saved for this plugin
delete_option( 'rd_ic_options' );
