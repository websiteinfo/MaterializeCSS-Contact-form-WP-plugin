<?php
/*
Plugin Name: MaterializeCSS Contact Form
Plugin URI: https://website.info.pl
Description: MaterializeCSS Simple Contact Form WP Plugin
Version: 1.0
*/
function html_form_code() {
	echo '<div class="row">';
	echo '<div class="col s12 m12">';
	echo '<div class="card grey lighten-5">';
	echo '<div class="card-content">';
	echo '<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
	echo '<h4>Contact:</h4>';
	echo '<label>';
	echo '<span>Name :</span>';
	echo '<input required  type="text" placeholder="Name" name="name" pattern="[a-zA-Z0-9 ]+" value="' . (isset($_POST["name"]) ? esc_attr($_POST["name"]) : '') . '" size="40" />';
	echo '</label>';

	echo '<label>';
	echo '<span>Email :</span>';
	echo '<input required type="email" placeholder="Email" name="email" value="' . (isset($_POST["email"]) ? esc_attr($_POST["email"]) : '') . '" size="40" />';
	echo '</label>';

	echo '<label>';
	echo '<span>Subject :</span>';
	echo '<input required type="text" placeholder="Subject" name="subject" pattern="[a-zA-Z ]+" value="' . (isset($_POST["subject"]) ? esc_attr($_POST["subject"]) : '') . '" size="40" />';
	echo '</label>';

	echo '<label>';
	echo '<span>Message :</span>';
	echo '<textarea required placeholder="Message" rows="8" id="textarea1" class="materialize-textarea" cols="35" name="message">' . (isset($_POST["message"]) ? esc_attr($_POST["message"]) : '') . '</textarea>';
	echo '</label> ';

	echo '<button class="btn waves-effect waves-light light-blue darken-3" type="submit" name="submit" value="Send">Send';
	echo '<i class="material-icons right">send</i>';
	echo '</button>';
	echo '</form>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}


function deliver_mail() {

	if ( isset( $_POST['submit'] ) ) {

		$name    = sanitize_text_field( $_POST["name"] );
		$email   = sanitize_email( $_POST["email"] );
		$subject = sanitize_text_field( $_POST["subject"] );
		$message = esc_textarea( $_POST["message"] );

		$to = get_option( 'admin_email' );

		$headers = "From: $name <$email>" . "\r\n";

		if ( wp_mail( $to, $subject, $message, $headers ) ) {
			echo '<div>';
			echo '<p>Thank you for your message.</p>';
			echo '</div>';
		} else {
			echo '<p>Error sending mail.</p>';
		}
	}
}
function materialize_shortcode() {
	ob_start();
	deliver_mail();
	html_form_code();

	return ob_get_clean();
}
function materialize_contact_shortcodes() {
	add_shortcode( 'materialize_contact_form', 'materialize_shortcode' );
}
add_action( 'init', 'materialize_contact_shortcodes' );
