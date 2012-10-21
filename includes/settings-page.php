<?php
// We want the settings page to show a form that the administrator can use to modify the settings of the plugin.
// The form itself will be at the bottom of this page.  It will display the current settings that exist for the plugin.
// The current settings will be pulled from the database.  If this has already been done and the form has been submitted, the _POST variable will be filled and it will have a hidden input activated.  In this case, the displayed information will be that which was submitted in the form through the _POST variable.  These values will also be updated in the database, and then the form will be displayed again with the new data shown.

	if( isset($_POST['rd-ic-hidden']) && 'y' == $_POST['rd-ic-hidden'] ){	// This is the hidden variable that shows whether we have already submitted the form.
		// Save the new settings in the variables.  These will be displayed in the form.
		$msg_to = $_POST['send-message-to'];
		$subject = $_POST['subject'];
		$msg_sent = $_POST['message-sent'];
		$msg_fail = $_POST['message-not-sent'];

		// Put the new settings in an array.
		$options = array(
			'email_to' => $msg_to,
			'email_subject' => $subject,
			'msg_sent' => $msg_sent,
			'msg_fail' => $msg_fail,
		);
		// Save the array of new values in the WP database.
		update_option( 'rd_ic_options', $options );
	} else {
		// Get the current settings from the database.
		$options = get_option( 'rd_ic_options' );
		// Populate these variables with the current settings.  These will then be displayed in the form.
		$msg_to = $options['email_to'];
		$subject = $options['email_subject'];
		$msg_sent = $options['msg_sent'];
		$msg_fail = $options['msg_fail'];
	}
?>
<div class="wrap">
	<h2>Shortcodes to use</h2>
		<h3>To add a product</h3>
			<p>[rd_ic title="name of your product"]</p>
			<p>This will insert a link in your post or page that will allow the user of the website to add or remove the product from the inquiry cart</p>
		<h3>To show the inquiry cart</h3>
			<p>[rd_ic_cart]</p>
			<p>Put this where you want the the inquiry cart form to be displayed.</p>
	<h2>Settings</h2>
	<p>The current settings of the form are shown below.  If you want to change them, edit and save them.</p>
	<form name="rd-ic-options-form" action="" method="post">
		<input type="hidden" name="rd-ic-hidden" value="y" />

		<h4>Inquiry Cart settings</h4>
		<p>Send form to: <input type="text" name="send-message-to" value="<?php echo $msg_to ?>" /></p>
		<p>Subject of inquiry: <input type="text" name="subject" value="<?php echo $subject ?>" /></p>
		<p>Message if email sent successfully: <input type="text" name="message-sent" value="<?php echo $msg_sent ?>" /></p>
		<p>Message if email send failed: <input type="text" name="message-not-sent" value="<?php echo $msg_fail ?>" /></p>

		<p class="submit">
			<input type="submit" value="Save new settings" />
		</p>
	</form>
</div>
