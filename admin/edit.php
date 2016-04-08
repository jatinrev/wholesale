<?php
include 'include/header.php';
include 'classes/list_class.php';

$list_class_ob = new list_class();

if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'update_product' ) {
    $getQuery = $mysqlDbOb->update_database( array(
                            'productName'                => $_REQUEST['productName'],
                            'productSKU'                 => $_REQUEST['productSKU'],
                            'product_description'        => $_REQUEST['product_description'],
                            'product_wholesale_quantity' => $_REQUEST['product_wholesale_quantity'],
                            'product_inventory'          => $_REQUEST['product_inventory'],
                            'product_date'				 => $_REQUEST['product_date'],
                            'category_field'             => $_REQUEST['category_field'],
                            'productPrice'               => $_REQUEST['productPrice']
                                                   ),
                                             WS_PRODUCTS,
                                             'id',
                                             $_REQUEST['product_id']
                                             );
    $insertID = $_REQUEST['product_id'];
    // Inserting Product Images
    $counter = 0;
    $imageUploadLength = count($_FILES['productImage']['name']);

    while($counter<$imageUploadLength) {
      $fileName         = date('Ymshis').makeFileNameForUpload($_FILES['productImage']['name'][$counter]);
      $fileOriginalName = $_FILES['productImage']['name'][$counter];
      if(move_uploaded_file($_FILES['productImage']['tmp_name'][$counter], 'images/'.$fileName)) {
        $res['res']     = $fileName;
        $insert_contract_attach_file_arr = array(
                            'productID'           => $insertID,
                            'image'               => $fileName,
                            'image_original_name' => $_FILES['productImage']['name'][$counter]
                                                 );
        $mysqlDbOb->InsertInDatabase($insert_contract_attach_file_arr, WS_IMAGES);
      }
      $counter++;
    }
    header('Location: '.ROOT_PATH.'list.php');
    exit;


} else if ( isset($_REQUEST['id']) && trim($_REQUEST['id']) != '' && is_numeric($_REQUEST['id']) && (int)$_REQUEST['id'] > 0 ) {
	$id = (int)$_REQUEST['id'];
	$product_detail = $list_class_ob->get_single_product($id);
} else {
	die;
}

?>

<script src="js/angular_methods.js"></script>

	<div class="col-md-12 margin-bottom-20"><h1>Edit product here</h1></div>
	<div class="col-md-6 margin-bottom-40">
	  <form method="POST" class="wholesaleForm" enctype="multipart/form-data">
	  	  <input type="hidden" name="product_id" value="<?php echo $id; ?>">
	  	  <input type="hidden" name="action" value="update_product">
	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="productName">Product Name</label>
	      <input type="text" name="productName" value="<?php echo $product_detail['productName']; ?>" class="form-control" id="productName" placeholder="Product Name">
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="productSKU">Product SKU</label>
	      <input type="text" name="productSKU" value="<?php echo $product_detail['productSKU']; ?>" class="form-control" id="productSKU" placeholder="Product SKU">
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="product_description">Product Descrition</label>
	      <textarea name="product_description" class="form-control" id="product_description" placeholder="product Description"><?php echo $product_detail['product_description']; ?></textarea>
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="product_wholesale_quantity">Wholesale quantity</label>
	      <input type="number" name="product_wholesale_quantity" value="<?php echo $product_detail['product_wholesale_quantity']; ?>" class="form-control" id="product_wholesale_quantity" placeholder="Product Wholesale Quantity">
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <?php
	      	$product_detail['product_inventory'] = trim($product_detail['product_inventory']);
	      ?>
	      <label for="product_inventory">Product Inventory</label>
	      <select name="product_inventory" id="product_inventory" class="form-control">
	        <option <?php echo ($product_detail['product_inventory'] == 'available' ? 'selected' : '' ); ?> value="available">Available</option>
	        <option <?php echo ($product_detail['product_inventory'] == 'sold_out' ? 'selected' : '' ); ?> value="sold_out">Sold out</option>
	        <option <?php echo ($product_detail['product_inventory'] == 'coming_soon' ? 'selected' : '' ); ?> value="coming_soon">Coming Soon</option>
	      </select>
	    </div>

		<div ng-app="admin_app" class="form-group" ng-controller="add_product_form">
	      <label for="product_date">Product date</label>
	      <input type="text" value="<?php echo $product_detail['product_date']; ?>" class="form-control date_first" name="product_date" id="product_date" ng-click="open1();" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" min-date="minDate" max-date="maxDate" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" alt-input-formats="altInputFormats">
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <?php
	      	$product_detail['category_field'] = trim($product_detail['category_field']);
	      ?>
	      <label for="category_field">Category field</label>
	      <select name="category_field" id="category_field" class="form-control">
	        <option <?php echo ($product_detail['category_field'] == 'standard_wallet' ? 'selected' : '' ); ?> value="standard_wallet">standard wallet</option>
	        <option <?php echo ($product_detail['category_field'] == 'clutch' ? 'selected' : '' ); ?> value="clutch">clutch</option>
	        <option <?php echo ($product_detail['category_field'] == 'bag' ? 'selected' : '' ); ?> value="bag">Rope (Bag)</option>
	        <option <?php echo ($product_detail['category_field'] == 'duffle_bag' ? 'selected' : '' ); ?> value="duffle_bag">Duffle (Bag)</option>
	        <option <?php echo ($product_detail['category_field'] == 'tote_bag' ? 'selected' : '' ); ?> value="tote_bag">Tote (Bag)</option>
	        <option <?php echo ($product_detail['category_field'] == 'classic_wallet' ? 'selected' : '' ); ?> value="classic_wallet">classic wallet</option>
	        <option <?php echo ($product_detail['category_field'] == 'coin_pouch' ? 'selected' : '' ); ?> value="coin_pouch">coin pouch</option>
	        <option <?php echo ($product_detail['category_field'] == 'card_holder' ? 'selected' : '' ); ?> value="card_holder">card holder</option>
	      </select>
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="productPrice">Product Price</label>
	      <input type="text" name="productPrice" value="<?php echo $product_detail['productPrice']; ?>" class="form-control" id="productPrice" placeholder="Product Price">
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	      <label for="productImage">Product Image (Images uploaded would be added to the product).</label>
	      <input type="file" name="productImage[]" class="" id="productImage" name="productImage[]" placeholder="Product Image" multiple>
	    </div>

	    <div class="form-group pull-left col-md-12 padding_leftRight_zero">
	    	<input type="submit" name="addProduct" class="btn btn-primary" value="Update product">
	    </div>
	  </form>
	</div>
	<div class="col-md-6">
		<div class="form-group pull-left col-md-12 padding_leftRight_zero">
		  <?php
		  foreach ( $product_detail['product_images'] as $image_key => $image_name ) {
			echo '<span class="remove-button pull-left">'.$image_name['original_name'].' <i class="fa fa-times cursor-pointer" onclick="delete_image(\''.$image_key.'\');"></i></span>';
		  }
		  ?>
	    </div>
	</div>


	<script type="text/javascript">
		function delete_image(id) {
			var conferm_result = confirm('do you want to delete this?');
			if(conferm_result) {
				$.ajax({
					url: 'list.php',
					type: 'POST',
					data: 'action=delete_image&id='+id,
				})
				.done(function() {
					window.location.reload();
				});
			}
		}
	</script>

<?php include 'include/footer.php'; ?>