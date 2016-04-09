<?php
require_once "config.php";
require_once ROOT_DIRECTORY_PATH."frontend_include/classes/display_class.php";
$display_class_ob = new display_class();

if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'get_all_products' ) {
	$all_categories = $display_class_ob->get_product_categories()->all_categories;

	foreach ($all_categories as $value) {
		$display_class_ob->get_product($value['id']);
	}

	echo json_encode( $display_class_ob );

} else if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'submit_wholesale' &&
		   isset($_REQUEST['data_key']) && trim($_REQUEST['data_key']) != ''
		  ) {

	function get_stuff_from_product_id($product_id, $key, $all_category) {
		foreach ($all_category as $value) {
			if($product_id == $value['id']) {
				return $value[$key];
			}
		}
	}

	$submit_response = json_decode($_REQUEST['data_key'], true);

	$submit_response['form_data_key']['city'] = (isset($submit_response['form_data_key']['city']) ? trim($submit_response['form_data_key']['city']) : '' );
	$error = array();

	if( !isset($submit_response['form_data_key']['name']) || (isset($submit_response['form_data_key']['name']) && trim($submit_response['form_data_key']['name']) == '') ) {
		$error[] = 'Please enter name.';
	} if( !isset($submit_response['form_data_key']['email']) || (isset($submit_response['form_data_key']['email']) && trim($submit_response['form_data_key']['email']) == '') ) {
		$error[] = 'Please enter email.';
	} if( !isset($submit_response['form_data_key']['shipping_name']) || (isset($submit_response['form_data_key']['shipping_name']) && trim($submit_response['form_data_key']['shipping_name']) == '') ) {
		$error[] = 'Please enter shipping name.';
	} if( !isset($submit_response['form_data_key']['company']) || (isset($submit_response['form_data_key']['company']) && trim($submit_response['form_data_key']['company']) == '') ) {
		$error[] = 'Please enter company name.';
	} if( !isset($submit_response['form_data_key']['address']) || (isset($submit_response['form_data_key']['address']) && trim($submit_response['form_data_key']['address']) == '') ) {
		$error[] = 'Please enter address.';
	} if( !isset($submit_response['form_data_key']['state']) || (isset($submit_response['form_data_key']['state']) && trim($submit_response['form_data_key']['state']) == '') ) {
		$error[] = 'Please enter state name.';
	} if( !isset($submit_response['form_data_key']['postal_code']) || (isset($submit_response['form_data_key']['postal_code']) && trim($submit_response['form_data_key']['postal_code']) == '') ) {
		$error[] = 'Please enter postal code.';
	} if( !isset($submit_response['form_data_key']['country']) || (isset($submit_response['form_data_key']['country']) && trim($submit_response['form_data_key']['country']) == '') ) {
		$error[] = 'Please enter country.';
	} if( !isset($submit_response['form_data_key']['phone']) || (isset($submit_response['form_data_key']['phone']) && trim($submit_response['form_data_key']['phone']) == '') ) {
		$error[] = 'Please enter phone.';
	}

	if( count($error) > 0 ) {
		echo implode('<br>', $error);
		die;
	}


	if( isset($submit_response['form_data_key']['city']) && trim($submit_response['form_data_key']['city']) != '' ) {
		$submit_response['form_data_key']['city'] = str_replace('_', ' ', $submit_response['form_data_key']['city']);
	}

	$insert_data = array('name'          => $submit_response['form_data_key']['name'],
						 'email'         => $submit_response['form_data_key']['email'],
						 'shipping_name' => $submit_response['form_data_key']['shipping_name'],
						 'company'       => $submit_response['form_data_key']['company'],
						 'address'       => $submit_response['form_data_key']['address'],
						 'city'          => $submit_response['form_data_key']['city'],
						 'state'         => $submit_response['form_data_key']['state'],
						 'postal_code'   => $submit_response['form_data_key']['postal_code'],
						 'country'       => $submit_response['form_data_key']['country'],
						 'phone'         => $submit_response['form_data_key']['phone']
						 );

	$insert_query_result = $mysqlDbOb->InsertInDatabase(
														array_merge( array('date_added' => get_current_date()),
																	 $insert_data
																	),
														WS_ALL_ORDERS
														);

	$product_category = $display_class_ob->get_product_categories()->all_categories;

	// inserting in order detail page.
	foreach ($submit_response['product_requirement'] as $requirement_data) {
		$display_class_ob->submit_order($insert_query_result, $requirement_data['product_category'], $requirement_data['product_id'], $requirement_data['product_quantity']);
	}

	$category_name = array('standard_wallet' => 'THE_ORIGAMI_(STANDARD WALLET)',
						   'clutch'			 => 'THE_ORLY_(Clutch)',
						   'classic_wallet'	 => 'THE_ESSENTIALS_(Classic Wallet)',
						   'coin_pouch'		 => 'THE_MAGIC_COIN_POUCH',
						   'card_holder'	 => 'THE_MINIMALIST_(Card Holder)'
						   );
	$order_array_for_mail = array();

	foreach ($array as $category_slug) { // $category_slug = standard_wallet
		if( isset($submit_response[$category_slug]) && count($submit_response[$category_slug]) > 0 ) {
			$order_array_for_mail[ $category_name[$category_slug] ] = $submit_response[$category_slug];
		}
	}

	$send_data = array('user_details'  => $insert_data,
					   'order_details' => $order_array_for_mail
					   );

	$order_number = rand();
	$display_class_ob->send_mail( $submit_response['form_data_key']['email'], $send_data, $subject='Paperwallet Wholesale',$order_number );
	echo json_encode( array('output'=>1, 'order_number'=>$order_number) );
} else if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'get_countries' ) {
	echo json_encode( $display_class_ob->get_all_countries() );
}


?>