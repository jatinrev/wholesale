<?php
include 'include/header.php';

$insert_output = array();
$go_edit       = false;

if ( isset($_REQUEST['addProductCategory']) 		&&
	 isset($_REQUEST['productCategoryName']) 		&& trim($_REQUEST['productCategoryName']) != '' 	 &&
	 isset($_REQUEST['product_minimum_quantity']) 	&& is_numeric($_REQUEST['product_minimum_quantity']) &&
	 isset($_REQUEST['product_category_price']) 	&& is_numeric($_REQUEST['product_category_price'])   &&
	 isset($_REQUEST['product_sorting_order']) 		&& is_numeric($_REQUEST['product_sorting_order'])
	  ) {
	// THIS IS TO ADD PRODUCT CATEGORY.
	$productCategoryName      = $_REQUEST['productCategoryName'];
	$product_minimum_quantity = $_REQUEST['product_minimum_quantity'];
	$product_category_price   = $_REQUEST['product_category_price'];
	$product_sorting_order    = $_REQUEST['product_sorting_order'];

	$insert_result = $mysqlDbOb->InsertInDatabase(array('category_name'  => $productCategoryName,
														'min_quantity'   => $product_minimum_quantity,
														'category_price' => $product_category_price,
														'sorting_order'  => $product_sorting_order,
														'date_added'     => get_current_date()
														),
												  CATEGORY
												  );
	if($insert_result) {
		$insert_output = array('output_message' => 'Data Inserted',
							   'output_code'	=> 1
							   );
	} else {
		$insert_output = array('output_message' => 'Could not insert',
							   'output_code'	=> 0
							   );
	}
} else if( isset($_REQUEST['editProductCategory']) 		&&
		   isset($_REQUEST['categoryId']) 				&&
		   isset($_REQUEST['productCategoryName']) 		&& trim($_REQUEST['productCategoryName']) != '' 	 &&
		   isset($_REQUEST['product_minimum_quantity']) && is_numeric($_REQUEST['product_minimum_quantity']) &&
		   isset($_REQUEST['product_category_price']) 	&& is_numeric($_REQUEST['product_category_price'])   &&
		   isset($_REQUEST['product_sorting_order']) 	&& is_numeric($_REQUEST['product_sorting_order'])
		  ) {
	// THIS IS TO EDIT PRODUCT CATEGORY.
	$productCategoryId        = $_REQUEST['categoryId'];
	$productCategoryName      = $_REQUEST['productCategoryName'];
	$product_minimum_quantity = $_REQUEST['product_minimum_quantity'];
	$product_category_price   = $_REQUEST['product_category_price'];
	$product_sorting_order    = $_REQUEST['product_sorting_order'];

	$update_result = $mysqlDbOb->update_database(array('category_name'  => $productCategoryName,
													   'min_quantity'   => $product_minimum_quantity,
													   'category_price' => $product_category_price,
													   'sorting_order'  => $product_sorting_order,
													   'date_added'     => get_current_date()
												 	   ),
												 CATEGORY,
												 'id',
												 $productCategoryId
												 );

	if( $update_result ) {
		$insert_output = array('output_message' => 'Data Updated.',
							   'output_code'	=> 1
							   );
	} else {
		$insert_output = array('output_message' => 'Could not Update',
							   'output_code'	=> 0
							   );
	}

} else if( isset($_REQUEST['addProductCategory']) && isset($_REQUEST['editProductCategory']) ) {
	// THIS IS ERROR MESSAGE CONDITION IF DATA IS NOT ACCORDINGLY, THEN THIS WILL SEND ERROR MSG.
	$insert_output = array('output_message' => 'Please fill all the fields.',
						   'output_code'	=> 0
							   );
} else if( isset($_REQUEST['categoryId']) && is_numeric($_REQUEST['categoryId']) ) {
	$go_edit = true;
	//get data by category id.
	$categoryId = $_REQUEST['categoryId'];
	$query = $mysqlDbOb->select_query_multiple_where(array('category_name', 'min_quantity', 'category_price', 'sorting_order'),
													 CATEGORY,
													 array('id' => $categoryId)
													 );
	if( mysqli_num_rows($query) > 0 ) {
		$fetch_query = mysqli_fetch_assoc($query);
	} else {
		$fetch_query = array(
							'category_name'  => '',
							'min_quantity'   => '',
							'category_price' => '',
							'sorting_order'  => ''
							);
		$insert_output = array('output_message' => 'Category not present',
							   'output_code'	=> 2
							   );
	}
}

?>
<style type="text/css">
  .add_category a {
    background-color: #e7e7e7;
    color: #555555;
  }
</style>

<script src="js/angular_methods.js"></script>

<div class="col-md-12 margin-bottom-20"><h1>Add product category here</h1></div>
<div class="col-md-6 margin-bottom-40">
  <form method="POST" class="wholesaleForm" action="add_category.php" enctype="multipart/form-data">

	<?php
	if( count($insert_output) > 0 && $insert_output['output_code'] == 1 ) {
		echo '<div class="form-group alert alert-success">'.$insert_output['output_message'].'</div>';
	} else if( count($insert_output) > 0 &&
			   ($insert_output['output_code'] == 0 || $insert_output['output_code'] == 2)
			  ) {
		echo '<div class="form-group alert alert-danger">'.$insert_output['output_message'].'</div>';
	}
	?>

	<input type="hidden" name="categoryId" value="<?php echo $go_edit ? $categoryId : ''; ?>">

    <div class="form-group">
      <label for="productCategoryName">Product Category Name</label>
      <input type="text" name="productCategoryName" class="form-control" id="productCategoryName" value="<?php echo $go_edit ? $fetch_query['category_name'] : ''; ?>" placeholder="Product Category Name">
    </div>

    <div class="form-group">
      <label for="product_minimum_quantity">Product Minimum quantity(This is the minimum quantity which user need to buy while purchasing the product.)</label>
      <input type="number" name="product_minimum_quantity" class="form-control" id="product_minimum_quantity" value="<?php echo $go_edit ? $fetch_query['min_quantity'] : ''; ?>" placeholder="Product Minimum Quantity">
    </div>

    <div class="form-group">
      <label for="product_category_price">Category Price</label>
      <input type="text" name="product_category_price" class="form-control" id="product_category_price" value="<?php echo $go_edit ? $fetch_query['category_price'] : ''; ?>" placeholder="Product Category Price">
    </div>

	<div class="form-group">
      <label for="product_sorting_order">Sorting Order</label>
      <input type="text" name="product_sorting_order" class="form-control" id="product_sorting_order" value="<?php echo $go_edit ? $fetch_query['sorting_order'] : ''; ?>" placeholder="Product Sorting Order">
    </div>
	<?php
	if( $go_edit ) {
		echo '<input type="submit" name="editProductCategory" class="btn btn-primary" value="Edit Product">';
	} else if( count($insert_output) > 0 && $insert_output['output_code'] == 2 ) {
		//get data by category id. (eh oh vali condition hai jisch user edit kr reha but oh category nhi mili)
		echo '<input type="submit" name="addProductCategory" class="btn btn-primary" value="Add Product">';
	} else {
    	echo '<input type="submit" name="addProductCategory" class="btn btn-primary" value="Add Product">';
	}
	?>
  </form>
</div>

<div class="col-md-6 margin-bottom-40">
	<?php

	$getAllCategoryquery = $mysqlDbOb->select_query_multiple_where_args(
													 array('id', 'category_name', 'min_quantity', 'category_price', 'sorting_order'),
													 CATEGORY,
													 array(),
													 ' ORDER BY sorting_order ASC '
													 );
	if( mysqli_num_rows($getAllCategoryquery) > 0 ) {
	?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Category Name</th>
					<th>Category Price</th>
					<th>Minimum Quantity</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	<?php
		while( $fetchAllCategory = mysqli_fetch_assoc($getAllCategoryquery) ) {
	?>
				<tr>
					<td><?php echo $fetchAllCategory['sorting_order']; ?></td>
					<td><?php echo $fetchAllCategory['category_name']; ?></td>
					<td><?php echo $fetchAllCategory['category_price']; ?></td>
					<td><?php echo $fetchAllCategory['min_quantity']; ?></td>
					<td><button type="button" onclick="edit('<?php echo $fetchAllCategory['id']; ?>')" class="btn btn-warning">Edit</button></td>
				</tr>
	<?php
		} // while
	?>
			</tbody>
		</table>
	<?php
	}
	?>
</div>
<script type="text/javascript">
	function edit(id) {
		window.location.href = '<?php echo ROOT_PATH.'add_category.php?categoryId='; ?>'+id;
	}
</script>

<?php include 'include/footer.php'; ?>