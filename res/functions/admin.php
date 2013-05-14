<?php
/**
 * login css hijacking
 */
add_action('login_head', 'custom_login_css');

function custom_login_css() {
	echo '<link rel="stylesheet" href="' . get_template_directory_uri() . '/res/css/admin.css" type="text/css" media="all" />';
}

if (is_admin()) { // why execute all the code below at all if we're not in admin?

// call in custom admin stylesheet - this will be global for admin and also login

	add_action('admin_print_styles', 'load_custom_admin_css');

	function load_custom_admin_css() {
		wp_enqueue_style('custom_admin_css', get_template_directory_uri() . '/res/css/admin.css');
	}

// overriding footer "credit" text

	add_filter('admin_footer_text', 'custom_footer_text');

	function custom_footer_text($default_text) {
		return '<span id="footer-thankyou">Site managed by <a href="http://www.viastudio.com">VIA Studio</a> | Powered by <a href="http://www.wordpress.org">WordPress</a></span>';
	}

	/**
	 * cleaning up and customizing the dashboard
	 */

	add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

	function custom_dashboard_widgets() {
		global $wp_meta_boxes;

		// remove unnecessary widgets
		// var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);

		//custom dashboard widgets
		wp_add_dashboard_widget('custom_help_widget', 'Help and Support', 'custom_dashboard_help'); // add a new custom widget for help and support
	}

	function custom_dashboard_help() {
		echo '
					<p style="text-align:center;"><img src="' . get_template_directory_uri() . '/res/img/logo_via_dashboard.png">
					<h2>Need help?</h2>
					<p>That "help" tab up top provides contextual help throughout the administrative panel. If you need additional support, you can contact your web team at <a href="http://www.viastudio.com">VIA Studio</a>:</p>
					<p><strong>Phone:</strong> 502-498-8477</p>
					<p><strong>Email:</strong> <a href="mailto:support@viastudio.com">support@viastudio.com</a></p>
				';
	}

	/**
	 * custom contextual help - tack on our support information to the end of the contextual help
	 */

	add_filter('contextual_help', 'custom_help_support', 100); //giving a very low priority to make sure it's always at the end

	function custom_help_support($help) {
		$help .= '
					<p><strong>Additional support</strong> - Contact the web team at <a href="http://www.viastudio.com">VIA Studio</a>
					by phone at 502-498-8477 or by email at <a href="mailto:support@viastudio.com">support@viastudio.com</a>.</p>
				';
		return $help;
	}

} //wrapper for admin functions
// End Custom Admin functions
?>