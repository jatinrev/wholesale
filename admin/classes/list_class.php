<?php

class list_class extends common
{
	public $all_categories = array();

	function get_product_images($id) {
		$output = array();
		$query	=	$this->mysqlDbOb->select_query_multiple_where(
											array('id', 'image'),
											WS_IMAGES,
											array('productID' => $id)
																  );
		if( mysqli_num_rows($query) > 0 ) {
			while ( $fetch_query = mysqli_fetch_assoc($query) ) {
				$output[$fetch_query['id']] = $fetch_query['image'];
			}
			return $output;
		} else {
			return array();
		}
	}

	function get_product_images_croped($id) {
		$all_images = $this->get_product_images($id);
		return array( getImage('admin/images/'.current($all_images),215,250) );
	}

	function delete_image_by_id($image_id) {
		$output                 = array();
		$counter                = 1;
		$image_table_primaryKey = $image_id;
		$image_full_path 		= $this->mysqlDbOb->get_from_table(WS_IMAGES,
																   'image',
																   'id',
																   $image_id
																   );
		$fullpath_of_filename 	= ROOT_DIRECTORY_PATH.'images/'.$image_full_path;
		if ( file_exists($fullpath_of_filename) ) {
			unlink($fullpath_of_filename);
			$output[$counter]	=	$this->mysqlDbOb->delete_database(
														WS_IMAGES,
														array('id' => $image_table_primaryKey)
																	  );
		} else {
			$this->mysqlDbOb->delete_database(
											  WS_IMAGES,
											  array('id' => $image_table_primaryKey)
											  );
			$output[$counter] = 'Image not found in directory.';
		}
		$counter++;
	}

	function get_single_product($id) {
		$list = $this->mysqlDbOb->select_query_multiple_where(
														array( 'productName',
															   'productSKU',
															   'product_description',
															   'product_wholesale_quantity',
															   'product_inventory',
															   'product_date',
															   'category_field',
															   'productPrice'
															  ),
														WS_PRODUCTS,
														array('id' => $id)
															  );
		$fetch_list 	= mysqli_fetch_assoc($list);
		$product_images = $this->mysqlDbOb->select_query_multiple_where(
														array('id', 'image', 'image_original_name'),
														WS_IMAGES,
														array('productID' => $id)
																		);
		$all_images 	= array();
		if( mysqli_num_rows($product_images) > 0 ) {
			while ( $fetch_images = mysqli_fetch_assoc($product_images) ) {
				$all_images[$fetch_images['id']] = array( 'image' 		  => $fetch_images['image'],
														  'original_name' => $fetch_images['image_original_name']
														 );
			}
		}
		$fetch_list['product_images'] = $all_images;
		return $fetch_list;
	}

	function add_images_for_product($id) {

	}

	function delete_full_product($id) {
		$this->delete_product_images_only($id);
		$this->delete_only_product($id);
		return 1;
	}

	function delete_product_images_only($id) {
		$output         = array();
		$product_images = $this->get_product_images($id);
		$counter        = 1;
		foreach ($product_images as $image_table_primaryKey => $image_full_path) {
			$fullpath_of_filename = ROOT_DIRECTORY_PATH.'images/'.$image_full_path;
			if ( file_exists($fullpath_of_filename) ) {
				unlink($fullpath_of_filename);
				$output[$counter]	=	$this->mysqlDbOb->delete_database(
												WS_IMAGES,
												array('id' => $image_table_primaryKey)
																		  );
			} else {
				$this->mysqlDbOb->delete_database(
												  WS_IMAGES,
												  array('id' => $image_table_primaryKey)
												  );
				$output[$counter] = 'Image not found in directory.';
			}
			$counter++;
		}
	}

	function delete_only_product($id) {
		return $this->mysqlDbOb->delete_database(WS_PRODUCTS ,
									  			 array('id' => $id)
												 );
	}

	function change_product_status($id, $status) {
		$status = ( $status == 1 ? 1 : 0 );
		$query = $this->mysqlDbOb->update_database_multiple_where(
													array('product_status' => $status,
														  'date_modified'  => get_current_date()
														  ),
													WS_PRODUCTS,
													array('id' => $id)
																  );
		return $query;
	}

	function submit_order($all_order_id, $category, $product_id, $product_quantity)  {
		$insert_result = $this->mysqlDbOb->InsertInDatabase(
											array('all_order_id' 	   => $all_order_id,	//primary_id of wholesale_all_order table
												  'category'	 	   => $category,
												  'product_primary_id' => $product_id,
												  'product_quantity'   => $product_quantity,
												  'date_added'		   => get_current_date()
												  ),
											WS_ALL_ORDERS_LIST
															);
		return $insert_result;
	}

	function get_product_categories() {
		$output = array();
		$getAllCategoryquery = $this->mysqlDbOb->select_query_multiple_where_args(
													 array('id', 'category_name', 'min_quantity', 'category_price', 'sorting_order'),
													 CATEGORY,
													 array(),
													 ' ORDER BY sorting_order ASC '
													  							  );
		if( mysqli_num_rows($getAllCategoryquery) > 0 ) {
			while ( $fetch = mysqli_fetch_assoc($getAllCategoryquery) ) {
				$output[] = array('id'             => $fetch['id'],
								  'category_name'  => $fetch['category_name'],
								  'min_quantity'   => $fetch['min_quantity'],
								  'category_price' => $fetch['category_price'],
								  'sorting_order'  => $fetch['sorting_order']
								  );
			}
			$this->all_categories = $output;
			return $this;
		}
	}

}

?>