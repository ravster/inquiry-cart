<?php
// Register shortcode [rd_ic]
add_shortcode( 'rd_ic', 'rd_ic_shortcode' );

function rd_ic_shortcode( $attr = array( 'title' => 'This item', ) ){
// Replace the [rd_ic title=?] shortcode.
// $attr is an array of attribute => value pairs.
// This has got to return a value.  echo'ing a value will not work.

	// Save the title in a variable
	$title = $attr['title'];

	// This is the string to return to be put in place of the shortcode
	$string_to_return = "";

	// If a product is removed from the cart, do so.
	if( isset( $_REQUEST['remove-item'] ) ){
		$name_of_item = $_REQUEST['remove-item'];
		unset( $_SESSION['rd_ic'][$name_of_item] );
	} elseif ( isset( $_REQUEST['add-item'] ) ) {	// Add item to cart
		$name_of_item = $_REQUEST['add-item'];
		// Add the item to the rd_ic array.
		$_SESSION['rd_ic'][$name_of_item] = 0;
	}

	// If the item is in the cart, then put in a link to remove it, else put in a link to add it.
	if( isset( $_SESSION['rd_ic'][$title] ) ){
		$string_to_return .= "<form action='' method='post' class='rd-ic-shortcode'>
$title - 
<input type='hidden' name='remove-item' value=\"$title\" />
<input type='submit' value='remove from cart' />
</form>";
	} else {
		$string_to_return .= "<form action='' method='post' class='rd-ic-shortcode'>
$title - 
<input type='hidden' name='add-item'value=\"$title\" />
<input type='submit' value='add to cart' />
</form>";
	}

	return $string_to_return;
}