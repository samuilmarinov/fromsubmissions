<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://samuilmarinov.co.uk
 * @since             1.0.0
 * @package           Form_Submissions
 *
 * @wordpress-plugin
 * Plugin Name:       Form Submissions
 * Plugin URI:        samuilmarinov.co.uk
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            samuil marinov
 * Author URI:        https://samuilmarinov.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       form-submissions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FORM_SUBMISSIONS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-form-submissions-activator.php
 */
function activate_form_submissions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-form-submissions-activator.php';
	Form_Submissions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-form-submissions-deactivator.php
 */
function deactivate_form_submissions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-form-submissions-deactivator.php';
	Form_Submissions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_form_submissions' );
register_deactivation_hook( __FILE__, 'deactivate_form_submissions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-form-submissions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_form_submissions() {

	$plugin = new Form_Submissions();
	//START

	//PLUGIN SETTINGS KINK
	function action_links( $links ) {

        $links = array_merge( array(
            '<a href="' . esc_url( admin_url( '/options-general.php?page=Form_Submissions' ) ) . '">' . __( 'Settings', 'Form_Submissions' ) . '</a>'
        ), $links );

        return $links;

    }
	add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'action_links' );
	//PLUGIN SETTINGS LINK

	//FORM CONTENT
	function html_form_code() {
		global $wp;
		global $wp_query;

		include plugin_dir_path( __FILE__ ) . 'includes/templates/form-template.php';

	}
	//FORM CONTENT

	//HTML RENDER
	add_filter( 'wp_mail_content_type', 'set_content_type' );
	function set_content_type( $content_type ){
		return 'text/html';
	}

	//SUBMIT FORM
	function submit_form() {

		global $wpdb;
		$tablename = $wpdb->prefix.'submissions';
		
		 // if the submit button is clicked, send the email
		 if ( isset( $_POST['submitted'] ) ) {
		
			$name_1 = sanitize_text_field( $_POST["cf-name"] );
			$name_2 = sanitize_text_field( $_POST["cf-name-last"] );
			$space = ' ';
			
			$name = $name_1.$space.$name_2;
			$email = sanitize_email( $_POST["cf-email"] );
			$phone = sanitize_text_field( $_POST["cf-phone"] );


			$wpdb->insert( $tablename, array(
				'name' => $name,
				'email' => $email,
				'phone' => $phone),
				array( '%s', '%s', '%s' )
			);

			$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
					<title>New Request - Van Booking</title>
					<!-- Responsive css-->
				<style>
				body { font-family: "Open Sans", sans-serif; line-height: 1.25; } table { border: 1px solid #ccc; border-collapse: collapse; margin: 0; padding: 0; width: 100%; table-layout: fixed; } table caption { font-size: 1.5em; margin: .5em 0 .75em; } table tr { background-color: #f8f8f8; border: 1px solid #ddd; padding: .35em; } table th, table td { padding: .625em; text-align: center; } table th { font-size: .85em; letter-spacing: .1em; text-transform: uppercase; } @media screen and (max-width: 600px) { table { border: 0; } table caption { font-size: 1.3em; } table thead { border: none; clip: rect(0 0 0 0); height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; } table tr { border-bottom: 3px solid #ddd; display: block; margin-bottom: .625em; } table td { border-bottom: 1px solid #ddd; display: block; font-size: .8em; text-align: right; } table td::before { /* * aria-label has no advantage, it wont be read inside a table content: attr(aria-label); */ content: attr(data-label); float: left; font-weight: bold; text-transform: uppercase; } table td:last-child { border-bottom: 0; } }
				</style>
				</head>
				<body style="margin:0px; padding:0px; background:#ffffff;">
					<table>
					  <caption>NEW BOOKING REQUEST</caption>
					  <thead>
					    <tr>
					      <th scope="col">From</th>
					      <th scope="col">Telephone</th>
					      <th scope="col">Email</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td data-label="From">'.$name.'</td>
					      <td data-label="Telephone">'.$phone .'</td>
					      <td data-label="Email">'.$email.'</td>
					      <td data-label=""></td>
					    </tr>
					  </tbody>
					</table>
					<div class="gmailfix" style="display: none; white-space:nowrap; font:15px courier; line-height:0; color:#ffffff; background-color:#ffffff;">
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
				</body>
			</html>';

			$to = 'marinovs1988@gmail.com';
            $headers = "From: $name <$email>" . "\r\n";
			$subject = "New Submission";

            // If email has been process for sending, display a success message
            if (wp_mail( $to, $subject, $body, $headers ) ) {
				echo "<script>window.location.replace('/thank-you/');	</script>";
            } else {
				echo '<div>';
                echo '<p>An unexpected error occurred</p>';
				echo '</div>';
            }
		}
	}
	//SUBMIT FORM


	//FORM SHORTCODE
	    // [custom_form_shortcode]
		function shortcode_html_form() {
			ob_start();
			submit_form();
			html_form_code();
			return ob_get_clean();
		}
		add_shortcode( 'custom_form_shortcode', 'shortcode_html_form' );
	//FORM SHORTCODE

	//END
	$plugin->run();

}
run_form_submissions();
