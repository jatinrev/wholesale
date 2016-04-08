<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


include 'include/header.php';
include 'classes/list_class.php';

$list_class_ob = new list_class();

if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'delete_product' && isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
	$list_class_ob->delete_full_product( trim($_REQUEST['id']) );
	die;
} else if( isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'delete_image' && isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) {
	$list_class_ob->delete_image_by_id($_REQUEST['id']);
	die;
}

$list = $mysqlDbOb->select_query_multiple_where(
												array( 'id',
													   'productName',
													   'productSKU',
													   'product_description',
													   'product_wholesale_quantity',
													   'product_inventory',
													   'category_field',
													   'productPrice',
													   'product_status'
													  ),
												WS_PRODUCTS,
												array()
												);
?>
<style type="text/css">
  .list_class a {
    background-color: #e7e7e7;
    color: #555555;
  }
</style>
	<div class="col-md-12 padding_leftRight_zero section_outer">
		<?php
		$counter = 1;
		while ( $fetchlist = mysqli_fetch_assoc($list) ) {
		?>
		<div class="col-md-12 highlight padding_leftRight_zero section margin_bottom_15">
			<div class="col-md-9">
				<h4 class="col-md-6 padding_leftRight_zero">Product Name : <?php echo $fetchlist['productName']; ?></h4>
				<h4 class="col-md-6 padding_leftRight_zero text-right">Product SKU : <?php echo $fetchlist['productSKU']; ?></h4>
				<span class="col-md-12">Product Description : <?php echo $fetchlist['product_description']; ?></span>
				<span class="col-md-12">
					Product wholesale quantity : <?php echo $fetchlist['product_wholesale_quantity']; ?>,&nbsp
					Product inventory : <?php echo $fetchlist['product_inventory']; ?>,&nbsp
					Product category : <?php echo $fetchlist['category_field']; ?>,&nbsp
					Product Price : <?php echo '$'.number_format($fetchlist['productPrice'], 2); ?>
				</span>
				<div class="col-md-12">
					<?php
					$product_images = $list_class_ob->get_product_images($fetchlist['id']);
					foreach ($product_images as $key => $value) {
						echo "<div class='col-md-3'><img src='".ROOT_PATH."images/".$value."' class='img-thumbnail'></div>";
					}
					?>
				</div>
			</div>
			<div class="col-md-3 text-center margin-tb-10">
				<button type="button" class="btn btn-danger" onclick="delete_id('<?php echo $fetchlist['id']; ?>')">Delete</button>
				<button type="button" class="btn btn-info" onclick="window.location.href='<?php echo ROOT_PATH.'edit.php?id='.$fetchlist['id']; ?>'">Edit</button>
			  <?php if( $fetchlist['product_status'] == 1 ) { ?>
				<button type="button" class="btn btn-warning" onclick="change_status('<?php echo $fetchlist['id']; ?>', 0)">Deactivate</button>
			  <?php } else { ?>
				<button type="button" class="btn btn-default" onclick="change_status('<?php echo $fetchlist['id']; ?>', 1)">Activate</button>
			  <?php } ?>
			</div>
		</div>
		<?php
		$counter++;
		}
		?>
	</div>

	<script type="text/javascript">
		function delete_id(id) {
			var conferm_result = confirm('do you want to delete this?');
			if(conferm_result) {
				$.ajax({
					url: 'list.php',
					type: 'POST',
					crossDomain:true,
					async: true,
					dataType: 'jsonp',
					data: 'action=delete_product&id='+id
				})
				.done(function() {
					alert('The product has been deleted, press ok!');
					window.location.reload();
				});
			}
		}

		function edit(id) {

		}

		function change_status(id, status) {
			$.ajax({
				url: '<?php echo "ajax.php"; ?>',
				type: 'POST',
				//crossDomain:true,
				//dataType: 'json',
				data: {action: 'change_status', product_id: id, status: status}
			})
			.done(function(res) {
				if(res == 1) {
					alert('Product status has been changed, press ok!');
					window.location.reload();
				} else {
					alert('could not update.');
				}
			});
		}
	</script>

<?php include 'include/footer.php'; ?>