<?php
/**
 * Plugin Name: Field and Vine Development Application Password Header
 * Description: On Development only, takes an application password from the X-FV-Application-Authorization header and hands it to WordPress's own application password check.
 * Version: 1.0.0
 *
 * WP Engine's password protection on Development and WordPress's application
 * passwords both use the Authorization header. A client sends the site
 * password in Authorization and the application password, in the same
 * "Basic base64(username:password)" form, in X-FV-Application-Authorization.
 *
 * This file only moves the decoded username and password into
 * $_SERVER['PHP_AUTH_USER'] and $_SERVER['PHP_AUTH_PW'], where WordPress's
 * wp_validate_application_password() reads them. WordPress then makes every
 * decision itself: whether the request is a REST or XML-RPC request, whether
 * application passwords are available to the user, and whether the password
 * is valid. This file never logs or prints the header's value.
 *
 * @package Field_And_Vine
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hands credentials from X-FV-Application-Authorization to WordPress's
 * application password check, on Development only.
 */
function field_and_vine_development_application_password_header() {
	// Development only: WP Engine defines PWP_NAME as the environment's name.
	if ( ! defined( 'PWP_NAME' ) || 'fieldandvindev' !== PWP_NAME ) {
		return;
	}

	if ( ! isset( $_SERVER['HTTP_X_FV_APPLICATION_AUTHORIZATION'] ) ) {
		return;
	}

	$header = $_SERVER['HTTP_X_FV_APPLICATION_AUTHORIZATION'];
	unset( $_SERVER['HTTP_X_FV_APPLICATION_AUTHORIZATION'] );

	// The request asked for application password access, so the site
	// password from Authorization is never offered to WordPress in its place.
	unset( $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'] );

	if ( ! is_string( $header ) || 0 !== stripos( $header, 'Basic ' ) ) {
		return;
	}

	$credentials = base64_decode( trim( substr( $header, 6 ) ), true );
	if ( false === $credentials || false === strpos( $credentials, ':' ) ) {
		return;
	}

	list( $username, $password ) = explode( ':', $credentials, 2 );
	$_SERVER['PHP_AUTH_USER']    = $username;
	$_SERVER['PHP_AUTH_PW']      = $password;
}
field_and_vine_development_application_password_header();
