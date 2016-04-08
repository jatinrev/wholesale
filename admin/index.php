<?php
include 'include/header.php';
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
if( isset($_REQUEST['addProduct']) ){
    // Inserting Product Information

    $getQuery = $mysqlDbOb->InsertInDatabase(array(
                            'productName'                => $_REQUEST['productName'],
                            'productSKU'                 => $_REQUEST['productSKU'],
                            'product_description'        => $_REQUEST['product_description'],
                            'product_wholesale_quantity' => $_REQUEST['product_wholesale_quantity'],
                            'product_inventory'          => $_REQUEST['product_inventory'],
                            'productPrice'               => $_REQUEST['productPrice'],
                            'product_date'               => $_REQUEST['product_date'],
                            'category_field'             => $_REQUEST['category_field'],
                            'product_status'             => 1,
                            'date_added'                 => get_current_date()
                                                   ),
                                             WS_PRODUCTS
                                             );
    $insertID = $getQuery;
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
}

?>
<style type="text/css">
  .index_class a {
    background-color: #e7e7e7;
    color: #555555;
  }
</style>

<script src="js/angular_methods.js"></script>

<div class="col-md-12 margin-bottom-20"><h1>Add product here</h1></div>
<div class="col-md-6 margin-bottom-40" ng-app="admin_app">
  <form method="POST" class="wholesaleForm" action="index.php" enctype="multipart/form-data">

    <div class="form-group">
      <label for="productName">Product Name</label>
      <input type="text" name="productName" class="form-control" id="productName" placeholder="Product Name">
    </div>

    <div class="form-group">
      <label for="productSKU">Product SKU</label>
      <input type="text" name="productSKU" class="form-control" id="productSKU" placeholder="Product SKU">
    </div>

    <div class="form-group">
      <label for="product_description">Product Descrition</label>
      <textarea name="product_description" class="form-control" id="product_description" placeholder="product Description"></textarea>
    </div>

    <div class="form-group">
      <label for="product_wholesale_quantity">Wholesale quantity</label>
      <input type="number" name="product_wholesale_quantity" class="form-control" id="product_wholesale_quantity" placeholder="Product Wholesale Quantity">
    </div>

    <div class="form-group">
      <label for="product_inventory">Product Inventory</label>
      <select name="product_inventory" id="product_inventory" class="form-control" ng-model="product_inventory">
        <option value="available">Available</option>
        <option value="sold_out">Sold out</option>
        <option value="coming_soon">Coming Soon</option>
      </select>
    </div>

    <div ng-show="product_inventory == 'coming_soon' ? true : false" class="form-group" ng-controller="add_product_form">
      <label for="product_date">Product date</label>
      <input type="text" class="form-control date_first" name="product_date" id="product_date" ng-click="open1();" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="popup1.opened" min-date="minDate" max-date="maxDate" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" alt-input-formats="altInputFormats">
    </div>

    <div class="form-group">
      <label for="category_field">Category field</label>
      <select name="category_field" id="category_field" class="form-control">
        <option value="standard_wallet">standard wallet</option>
        <option value="clutch">clutch</option>
        <option value="bag">Rope (Bag)</option>
        <option value="duffle_bag">Duffle (Bag)</option>
        <option value="tote_bag">Tote (Bag)</option>
        <option value="classic_wallet">classic wallet</option>
        <option value="coin_pouch">coin pouch</option>
        <option value="card_holder">card holder</option>
      </select>
    </div>

    <div class="form-group">
      <label for="productPrice">Product Price</label>
      <input type="text" name="productPrice" class="form-control" id="productPrice" placeholder="Product Price">
    </div>

    <div class="form-group">
      <label for="productImage">Product Image</label>
      <input type="file" name="productImage[]" class="" id="productImage" name="productImage[]" placeholder="Product Image" multiple>
    </div>

    <input type="submit" name="addProduct" class="btn btn-primary" value="Add Product">
  </form>
</div>
<script type="text/javascript">

</script>

<?php include 'include/footer.php'; ?>