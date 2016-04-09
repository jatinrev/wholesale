<?php
require_once "frontend_include/header.php";
require_once ROOT_DIRECTORY_PATH."frontend_include/classes/display_class.php";

$display_class_ob = new display_class();

?>

<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero margin-bottom-40" ng-app="index_app">
	<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-controller="index_controller">

		<!-- Start : Model -->
		<script type="text/ng-template" id="myModalContent.html">
	        <form novalidate name="myform" >
	            <div class="modal-header ">
	                <h3 class="modal-title">{{ model_heading }}</h3>
	            </div>
	            <div class="modal-body ">
	            	<div class="row margin-bottom-5">
	            		<div class="col-md-12">
	            			<div class="order_form_error_div alert alert-danger" ng-show="order_show_error">
	            				<p ng-repeat="value in order_all_errors.form_error">{{ value }}</p>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="row" ng-show="model_click_counter == 0 ? true : false">
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Name</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="name" class="form-control" type="text" placeholder="Name" ng-model="form_data.name" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Email</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="email" ng-pattern="/^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/" class="form-control" type="email" placeholder="Email" ng-model="form_data.email" required>
		            		</div>
		            	</div>
		            </div>
					<div class="row" ng-show="model_click_counter == 0 ? false : true">
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Name</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="shipping_name" class="form-control" type="text" placeholder="Name" ng-model="form_data.shipping_name" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Company</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="company" class="form-control" type="text" placeholder="Company" ng-model="form_data.company" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Address</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="address" class="form-control" type="text" placeholder="Address" ng-model="form_data.address" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Country</label>
		            		</div>
		            		<div class="col-md-6">
								<select name="country" class="form-control" ng-model="form_data.country" required>
									<option ng-repeat="(key, country_name) in countries_data.all_countries" value="{{ key }}">{{ country_name }}</option>
								</select>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >State/Province</label>
		            		</div>
		            		<div class="col-md-6 state_class">
		            			<input name="other_country_state" type="text" placeholder="State/Province" ng-model="form_data.other_country_state" class="form-control state_input_box" >
		            			<select name="us_state" ng-model="form_data.us_state" class="form-control state_select_box">
			            			<option ng-repeat="(key, value) in state_dropdown.united_state_countires" value="{{ key }}">{{ value }}</option>
			            		</select>
			            		<input type="hidden" name="state" ng-model="form_data.state" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >City</label>
		            		</div>
		            		<div class="col-md-6 city_class">
								<input name="city" type="text" class="form-control" placeholder="City" ng-model="form_data.city" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Postal code</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="postal_code" class="form-control" type="text" placeholder="Postal code" ng-model="form_data.postal_code" required>
		            		</div>
		            	</div>
		            	<div class="col-md-12 padding_leftRight_zero margin-bottom-5">
		            		<div class="col-md-3">
		            			<label >Phone</label>
		            		</div>
		            		<div class="col-md-6">
		            			<input name="phone" class="form-control" type="text" placeholder="Phone" ng-model="form_data.phone" required>
		            		</div>
		            	</div>
		            </div>
	            </div>
	            <div class="modal-footer">
	            	<!-- <button type="button" class="btn btn-info" ng-click="test()">test</button> -->
	                <button class="btn btn-primary modal-button button-background-00A7E5" type="button" ng-click="ok_counter(myform)">{{ ok_button }}</button>
	                <!-- <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button> -->
	            </div>
			</form>
        </script>
        <!-- End : Model -->

		<form id="wholesale_form">
			<img class="slider_class" src="<?php echo ROOT_PATH; ?>frontend_include/images/slider_img.jpg">
			<h2 class="text-center margin_topBottom_74 open_sans font_bold font_black">PLACE YOUR ORDER</h2>

			<?php /**** START : all ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-repeat="(sorting_key, products) in master">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero"><!-- ng-show="bag.show()" -->
					<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
						<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
							<span class="col-md-6 col-sm-8  col-xs-12 text-left">{{ master_helper.master_headings(sorting_key).master_heading }}</span>
							<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE ${{ master_helper.master_headings(sorting_key).master_price }} </span>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
							<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in products">
								<div class="padding_leftRight_zero {{ value.product_inventory }}"></div>
								<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
								<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
								<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
									{{ value.productName }}
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
									<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="product_helper.particular_product_requirement[product_id] = product_helper.particular_product_requirement[product_id]-1"></i></div>
									<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="product_helper.particular_product_requirement[product_id]" name="quantity" value="0"></div>
									<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="product_helper.particular_product_requirement[product_id] = product_helper.particular_product_requirement[product_id]+1"></i></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="container margin_topBottom_86">
							<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ master_helper.subtotal_cost(sorting_key) | currency }}</span></div>
						</div>
					</div>
				</div>
			</div>
			<?php /***** END : all *****/ ?>


			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24 fixxx">
				<div class="container font_black padding-tb-10 text-center font-weight-400 padding_leftRight_zero">
					<span class="text-center font_27">Total: {{ master_helper.totol_cost() | currency }}</span>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero padding-tb-10 font_24 margin-bottom-20">
				<div class="container text-center margin-top-15 submit-button">
				{{ product_helper.particular_product_requirement }}
					<a type="button" class="button-background-00A7E5 text-decoration-none order_button btn-lg btn-primary {{ master_helper.totol_cost() > 0 ? '' : 'hide' }}" ng-click="open()">Submit order</a>
				</div>
			</div>
		</form>
	</div>
</div>


<?php
require_once "frontend_include/js/app.php";

require_once "frontend_include/footer.php";
?>