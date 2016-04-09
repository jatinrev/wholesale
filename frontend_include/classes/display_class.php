<?php
require_once ROOT_DIRECTORY_PATH."admin/classes/list_class.php";
/**
*
*/
class display_class extends list_class
{
	public $all_products = array();

	/**
	 * @param  [type] $category ('clutch', 'standard_wallet', 'classic_wallet', 'coin_pouch', 'card_holder')
	 * @return [type]           [description]
	 */
	function get_product($category) {
		$sql = "select id, productName, productSKU, product_description, product_wholesale_quantity, product_inventory, product_date, category_field, productPrice, product_status from ".WS_PRODUCTS." where category_field='".$category."' and product_status=1";
		$query = $this->mysqlDbOb->execute_mysql_query($sql);
		if( mysqli_num_rows($query) > 0 ) {
			while ( $fetch_query = mysqli_fetch_assoc($query) ) {
				$this->all_products[$category][$fetch_query['id']] = array(
							'productName'                => $fetch_query['productName'],
							'productSKU'                 => $fetch_query['productSKU'],
							'product_description'        => $fetch_query['product_description'],
							'product_wholesale_quantity' => $fetch_query['product_wholesale_quantity'],
							'product_inventory'          => $fetch_query['product_inventory'],
							'product_date'          	 => date('F d,Y', strtotime($fetch_query['product_date'])),
							'category_field'             => $fetch_query['category_field'],
							'productPrice'               => $fetch_query['productPrice'],
							'product_status'             => $fetch_query['product_status'],
							'product_images'			 => $this->get_product_images_croped($fetch_query['id'])
																		   );
			}
		}
		return $this;
	}

	/**
	 * gives html of single-single product.
	 * @return string
	 */
	function get_html_of_products($category) {
		if( !is_array($this->all_products[$category]) || is_array($this->all_products[$category]) && count($this->all_products[$category]) < 1 ) {
			return '';
		}
		$str = '';
		foreach ( $this->all_products[$category] as $key => $product_attr) {
			$str .=
			'<div class="col-md-2 padding_leftRight_zero product-item margin-col-md-half margin-bottom-40">' .
				'<input type="hidden" name="product_price" class="product_price_input" value="'.$product_attr['productPrice'].'">' .
				'<img class="col-md-12 padding_leftRight_zero" src="'.getImage('admin/images/'.current($product_attr['product_images']), 250,250).'">' .
				'<div class="col-md-12 padding_leftRight_zero text-center padding-tb-5 font_bold">' .
					$product_attr['productName'] .
				'</div>' .
				'<div class="col-md-12">' .
					'<div class="col-md-3 padding_leftRight_zero text-center"><i class="border_radius_3 minus_button_style background_grey fa fa-minus"></i></div>' .
					'<div class="col-md-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 padding_leftRight_zero" type="text" name="quantity"></div>' .
					'<div class="col-md-3 padding_leftRight_zero text-center"><i class="border_radius_3 plus_button_style background_grey fa fa-plus"></i></div>' .
				'</div>' .
			'</div>';
		}
		return $str;
	}

	function get_product_stuff($product_id, $key) {
		return $this->mysqlDbOb->get_from_table(WS_PRODUCTS, $key, 'id', $product_id);
	}

	function get_country_from_id($id) {
		return $this->mysqlDbOb->get_from_table('countries', 'name', 'id', $id);
	}

	function send_mail( $to_email, $send_data = array(), $subject, $random_number) {
		$to            =  $to_email;
		$subject       =  'Paperwallet Wholesale Order Po-'.$random_number;

        $message =  "<table  border='0' cellpadding='4' cellspacing='4'>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan='3'>Hello ".$send_data['user_details']['name']."</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan='3'>Thank you for your order!</td>
						</tr>
						<tr>
							<td colspan='3'>We are reviewing your order and will get back to you soon to finalize the order and get it to you ASAP!</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan='3'>Please review the detials of your order and shipping info below:</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</table>
					<table  cellpadding='4' cellspacing='4' style='border-collapse: collapse; border: 1px solid black; margin-left: 50px; margin-top: 30px;'>
						<tr style='border: 1px solid black;'>
							<th style='border: 1px solid black;'>ORDER NUMBER</th>
							<th colspan='2' style='border: 1px solid black;'>PO-".$random_number."</th>
							<th style='border: 1px solid black;'></th>
							<th style='border: 1px solid black;'></th>
						</tr>
						<tr style='border: 1px solid black;'>
							<th style='border: 1px solid black;'>TYPE</th>
							<th style='border: 1px solid black;'>SKU</th>
							<th style='border: 1px solid black;'>DESCRIPTION</th>
							<th style='border: 1px solid black;'>QUANTITY</th>
							<th style='border: 1px solid black;'>SUBTOTAL</th>
						</tr>";
						$total_price = 0;
						$type_name = '';
						foreach ($send_data['order_details'] as $product_name => $product_details) {
							foreach ($product_details as $product_id => $product_quantity) {
								$type_name_in_foreach = $product_name;
								$product_price        = ($this->get_product_stuff($product_id, 'productPrice'))*$product_quantity;
								$total_price          = $total_price+$product_price;
				$message .= 	"<tr style='border: 1px solid black;'>";

								if( $type_name_in_foreach != $type_name ) {
									$type_name 		  = $type_name_in_foreach;
				$message .=				"<td style='border: 1px solid black;'>".$this->get_shorthand_name(str_replace('_', " ", $product_name))."</td>";
								} else {
				$message .=				"<td style='border: 1px solid black;'></td>";
								}

				$message .= 			"<td style='border: 1px solid black;'>".$this->get_product_stuff($product_id, 'productSKU')."</td>
									<td style='border: 1px solid black;'>".$this->get_product_stuff($product_id, 'product_description')."</td>
									<td style='border: 1px solid black;'>".$product_quantity."</td>
									<td style='border: 1px solid black;'>".$product_price."</td>
								</tr>";
							}
						}
			$message .= 	"<tr style='border: 1px solid black;'>
								<td style='border: 1px solid black;'></td>
								<td style='border: 1px solid black;'></td>
								<td style='border: 1px solid black;'></td>
								<td style='border: 1px solid black;'>Total : </td>
								<td style='border: 1px solid black;'>".$total_price."</td>
							</tr>";
			$message .=		"
					</table>
					<table border='0' cellpadding='4' cellspacing='4' style='margin-left: 50px; margin-top: 50px;'>
						<tr>
							<td style='font-weight: 700;'>SHIPPING ADDRESS:</td>
						</tr>
					</table>
					<table border='0' cellpadding='4' cellspacing='4' width='400' style='border-collapse: collapse; border: 1px solid black; margin-left: 50px;'>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Name:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['name']."</td>
						</tr>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Company:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['company']."</td>
						</tr>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Address:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['address']."</td>
						</tr>";
			if( trim($send_data['user_details']['city']) != '' ) {
			$message .=	"<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>City:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['city']."</td>
						</tr>";
			}
			$message .=	"<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>State / Province:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['state']."</td>
						</tr>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Postal Code:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['postal_code']."</td>
						</tr>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Country:</td>
							<td style='border: 1px solid black; text-align: center;'>".$this->get_country_from_id($send_data['user_details']['country'])."</td>
						</tr>
						<tr style='border: 1px solid black;'>
							<td style='border: 1px solid black;' width='120'>Phone:</td>
							<td style='border: 1px solid black; text-align: center;'>".$send_data['user_details']['phone']."</td>
						</tr>
					</table>
					<table  border='0' cellpadding='4' cellspacing='4' style='margin-top:50px;'>
						<tr>
							<td>You can reply to this email if you have any questions or comments.</td>
						</tr>
						<tr>
							<td>I am here to help :)</td>
						</tr>
					</table>
					<table  border='0' cellpadding='4' cellspacing='4' style='margin-top:20px;'>
						<tr>
							<td>Your truly,</td>
						</tr>
						<tr>
							<td>Jack</td>
						</tr>
						<tr>
							<td>Paperwallet Customer Care</td>
						</tr>
					</table>";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		// Additional headers
		$headers .= 'From: Paperwallet <Support@paperwallet.com>' . "\r\n";
		echo $message;
		die;
      	mail($to, $subject, $message, $headers);
        mail('Support@paperwallet.com', $subject, $message, $headers);
	}

	function get_shorthand_name($input) {
		$input = trim($input);
		$category_name = array('THE ORIGAMI (STANDARD WALLET)'   =>	'ORIGAMI',
							   'THE ORLY (Clutch)'               =>	'ORLY',
							   'THE ESSENTIALS (Classic Wallet)' =>	'ESSENTIALS',
							   'THE MAGIC COIN POUCH'            =>	'COIN POUCH',
							   'THE MINIMALIST (Card Holder)'    =>	'MINIMALIST'
							   );
		return $category_name[$input];
	}

	function get_all_countries() {
		$output = array();
		//-------Country start
		$query = $this->mysqlDbOb->select_query_multiple_where(
															   array('id', 'name'),
															   'countries',
															   array()
															   );
		if ( mysqli_num_rows($query) > 0 ) {
			while ( $fetch_query = mysqli_fetch_assoc($query) ) {
				$output['countries'][$fetch_query['id']] = $fetch_query['name'];
			}
		}
		//-------State start
		$output['states'] = array();
		/*$query_states = $this->mysqlDbOb->select_query_multiple_where(
																	  array('id', 'name', 'country_id'),
																	  'states',
																	  array()
																	  );
		if(mysqli_num_rows($query_states) > 0) {
			while ( $fetch_query_states = mysqli_fetch_assoc($query_states) ) {
				$output['states'][$fetch_query_states['id']] = array( $fetch_query_states['country_id'], $fetch_query_states['name'] );
			}
		}*/
		//-------Cities start
		$output['cities'] = array();
		/*$query_cities = $this->mysqlDbOb->select_query_multiple_where(
																	  array('id', 'name', 'state_id'),
																	  'cities',
																	  array()
																	  );
		if(mysqli_num_rows($query_cities) > 0) {
			while ( $fetch_cities = mysqli_fetch_assoc($query_cities) ) {
				$output['cities'][$fetch_cities['id']] = array( $fetch_cities['state_id'], $fetch_cities['name']);
			}
		}*/
		return $output;
	}

	function making_string_for_mail($product_id, $product_quantity) {
		return array('product_id' 		=> $product_id,
					 'product_quantity' => $product_quantity
					 );
	}

}

?>