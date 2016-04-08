<?php require_once "frontend_include/header.php"; ?>
<img class="slider_class" src="<?php echo ROOT_PATH; ?>frontend_include/images/slider_img.jpg">
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1>Thank you for your order!</h1>
			<p class="font_bold order_number">ORDER NUMBER:<?php echo $_REQUEST['order_number']; ?></p>
			<p class="margin_bottom_15">You will receive an email confirmation with your order details shortly.</p>
			<p class="margin-0">For anything else please email us</p>
			<p><a class="font-blue font_underline" href="">support@paperwallet.com</a></p>
			<p><a class="font-blue font_bold font_underline font_16" href="http://www.paperwallet.com">Back to Paperwallet</a></p>
		</div>

	</div>
</div>
<style type="text/css">
	.order_number {
		color: #0000ff;
	    font-size: 18px;
	    margin-bottom: 35px;
	    margin-top: 35px;
	}
</style>

<?php require_once "frontend_include/footer.php"; ?>