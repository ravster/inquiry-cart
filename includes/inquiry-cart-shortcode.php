<?php
add_shortcode( 'rd_ic_cart', 'rd_ic_cart_process_form' );

function rd_ic_cart_process_form(){
// This function returns the HTML that will be put in place of the shortcode.

	if( isset( $_POST['is-form-submitted']) && 'y' == $_POST['is-form-submitted'] ){
		// If the form is submitted, process it and put up a sign thanking the user.
		$name = $_POST['end-user-name'];
		$end_user_address = $_POST['end-user-address'];
		$end_user_inquiry = $_POST['end-user-inquiry'];
		$items_in_inquiry = print_r( $_SESSION['rd_ic'], true );

		// Get the settings for the plugin
		$options = get_option('rd_ic_options');
		$msg_to = $options['email_to'];
		$subject = $options['email_subject'];
		$msg_sent = $options['msg_sent'];
		$msg_fail = $options['msg_fail'];

		// Set the headers to send the email to the end-user too
		$headers[] = "Cc: $end_user_address";

		// Message that will be sent
		$message = "New inquiry from $name.\n\n$end_user_inquiry\n\n-----------------------\n\nProducts:\n$items_in_inquiry";

		// Send the mail
		$success = wp_mail( $msg_to, $subject, $message, $headers );

		// Print out a message saying whether sending the message was successful or not
		if( $success )
			return $msg_sent;
		else
			return $msg_fail;

	} else {
		// Display the form by default
		return rd_ic_cart_shortcode();
	}
}

function rd_ic_cart_shortcode(){
// This function returns the html that will be put in place of the shortcode.

	// If someone comes to the cart and then removes a product, we should remove the product from the list and then continue with printing the form (With the remaining products).
	if( isset($_GET['remove-item']) ){
		$name_of_item = $_GET['remove-item'];
		unset( $_SESSION['rd_ic'][$name_of_item] );
	}

	// This is the variable that will hold the string of the final html.
	$string_to_return =
		'<form method="post" action="">
			<p>Your name:</p>
			<p><input type="text" name="end-user-name" value="" /></p>
			<p>Your email address:</p>
			<p><input type="text" name="end-user-address" value="" /></p>
			<p>Your inquiry:</p>
			<p><textarea name="end-user-inquiry" rows="7" cols="50">
					Enter your inquiry here.
				</textarea>
			</p>
			<p>The items you are inquiring about:</p>';

	// Make a string that will hold the list of items in the cart
	$list_of_items = "<ul>";
	
	$inquiry_cart = $_SESSION['rd_ic'];
	foreach( $inquiry_cart as $item_in_cart => $item_value ){
		// The link that will put the remove item from cart command into the URL.
		$remove_link = "?remove-item=$item_in_cart";
		
		$list_of_items .=
			"<li>$item_in_cart <a href=\"$remove_link\">remove</a></li>";
	} unset( $item_in_cart );	// Because the reference to it survives the loop.
	// At the end of the loop, close the <ul>
	$list_of_items .= '</ul>';

	// Append the list of items to the string that is being returned.
	$string_to_return .= $list_of_items;

	// Add the submit button and end the form.
	$string_to_return .=
		'<input type="hidden" name="is-form-submitted" value="y" />
		<input type="submit" value="Send your inquiry" />
		</form>';

	return $string_to_return;
}	// End rd_ic_cart_shortcode();