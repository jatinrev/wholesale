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
			<?php /**** START : STANDARD_WALLET ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="standard_wallet.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding -tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">THE ORIGAMI (STANDARD WALLET)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $6.80 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in standard_wallet.all_products">
							<div  class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-bottom-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="standard_wallet.user_quantity_requirement[product_id] = standard_wallet.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="standard_wallet.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="standard_wallet.user_quantity_requirement[product_id] = standard_wallet.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ standard_wallet.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : STANDARD_WALLET *****/ ?>
			<?php /**** START : CLUTCH ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="clutch.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">THE ORLY (Clutch)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $7.60 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in clutch.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="clutch.user_quantity_requirement[product_id] = clutch.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="clutch.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="clutch.user_quantity_requirement[product_id] = clutch.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ clutch.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : CLUTCH *****/ ?>
			<?php /**** START : ROP-BAG(BAG) ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="bag.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">ROPE (BAGS)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $14 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in bag.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="bag.user_quantity_requirement[product_id] = bag.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="bag.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="bag.user_quantity_requirement[product_id] = bag.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ bag.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : ROP-BAG(BAG) *****/ ?>
			<?php /**** START : DUFFLE-BAG(BAG) ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="duffle_bag.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">DUFFLE (BAGS)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $20 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in duffle_bag.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="duffle_bag.user_quantity_requirement[product_id] = duffle_bag.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="duffle_bag.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="duffle_bag.user_quantity_requirement[product_id] = duffle_bag.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ duffle_bag.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : DUFFLE-BAG(BAG) *****/ ?>
			<?php /**** START : TOTE-BAG(BAG) ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="tote_bag.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">TOTE (BAGS)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $12 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in tote_bag.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="tote_bag.user_quantity_requirement[product_id] = tote_bag.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="tote_bag.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="tote_bag.user_quantity_requirement[product_id] = tote_bag.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ tote_bag.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : TOTE-BAG(BAG) *****/ ?>
			<?php /**** START : CLASSIC_WALLET ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="classic_wallet.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">THE ESSENTIALS (Classic Wallet)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $9.60 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in classic_wallet.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="classic_wallet.user_quantity_requirement[product_id] = classic_wallet.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="classic_wallet.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="classic_wallet.user_quantity_requirement[product_id] = classic_wallet.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ classic_wallet.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : CLASSIC_WALLET *****/ ?>
			<?php /**** START : COIN_POUCH ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="coin_pouch.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">THE MAGIC COIN POUCH</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $7.60 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in coin_pouch.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="coin_pouch.user_quantity_requirement[product_id] = coin_pouch.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="coin_pouch.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="coin_pouch.user_quantity_requirement[product_id] = coin_pouch.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12"><span class="pull-right font_24 font_black">Subtotal: {{ coin_pouch.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : COIN_POUCH *****/ ?>
			<?php /**** START : CARD_HOLDER ****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" ng-show="card_holder.show()">
				<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24">
					<div class="container font_black padding-tb-10 font-weight-400 padding_leftRight_zero">
						<span class="col-md-6 col-sm-8  col-xs-12 text-left">THE Minimalist (Card Holder)</span>
						<span class="col-md-6 col-sm-4 col-xs-12 text-left-sm text-right">WHOLESALE $5.60 </span>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_top_70 all_products_container padding_leftRight_zero_vs" >
						<div ng-mouseover="show_date = 1" ng-mouseleave="show_date = 0" class="col-md-2 col-sm-3 col-xs-6 padding_leftRight_zero_sm padding_leftRight_zero product-item margin-col-md-half margin-bottom-40 {{ value.product_inventory == 'coming_soon' || value.product_inventory == 'sold_out' ? 'margin-bottom-64' : 'nothing' }}" ng-repeat="(product_id, value) in card_holder.all_products">
							<div class="padding_leftRight_zero {{ value.product_inventory }}" ></div>
							<div class="padding_leftRight_zero padding-right-15-sm font-size-23-sm {{ value.product_inventory }}_text">{{ show_date == 1 && value.product_inventory == "coming_soon" ? value.product_date : value.product_inventory.replace("_", " ") }}</div>
							<img class="col-md-12 col-sm-12 col-xs-12 padding-tb-15" src="{{ value.product_images[0] }}">
							<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero text-center padding-tb-5 font_bold">
								{{ value.productName }}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 {{ value.product_inventory }}_display">
								<div class="col-md-3 col-sm-3 col-xs-3 padding-right-3 padding_left_0 text-right"><i class="border_radius_3 minus_button_style background_grey fa fa-minus cursor-pointer" ng-click="card_holder.user_quantity_requirement[product_id] = card_holder.user_quantity_requirement[product_id]-1"></i></div>
								<div class="col-md-6 col-sm-6 col-xs-6 padding_leftRight_zero"><input class="text_input_price_style col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero" type="text" ng-model="card_holder.user_quantity_requirement[product_id]" name="quantity" value="0"></div>
								<div class="col-md-3 col-sm-3 col-xs-3 padding-left-3 padding-right-0 text-left"><i class="border_radius_3 plus_button_style background_grey fa fa-plus cursor-pointer" ng-click="card_holder.user_quantity_requirement[product_id] = card_holder.user_quantity_requirement[product_id]+1"></i></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="container margin_topBottom_86">
						<div class="col-md-12 col-sm-12 col-xs-12"><span class="pull-right font_24 font_black">Subtotal: {{ card_holder.total_cost() | currency }}</span></div>
					</div>
				</div>
			</div>
			<?php /***** END : CARD_HOLDER *****/ ?>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero background_grey font_24 fixxx">
				<div class="container font_black padding-tb-10 text-center font-weight-400 padding_leftRight_zero">
					<span class="text-center font_27">Total: {{ total_cost_all_product() | currency }}</span>
				</div>
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12 padding_leftRight_zero padding-tb-10 font_24 margin-bottom-20">
				<div class="container text-center margin-top-15 submit-button">
					<a type="button" class="button-background-00A7E5 text-decoration-none order_button btn-lg btn-primary {{ total_cost_all_product() > 0 ? '' : 'hide' }}" ng-click="open()">Submit order</a>
				</div>
			</div>
		</form>
	</div>
</div>




<script type="text/javascript">
	var convArrToObj = function(array) {
        var thisEleObj = new Object();
        if(typeof array == "object"){
            for(var i in array){
                var thisEle = convArrToObj(array[i]);
                thisEleObj[i] = thisEle;
            }
        } else {
            thisEleObj = array;
        }
        return thisEleObj;
    };
	var app = angular.module('index_app', ['ngAnimate', 'ui.bootstrap']);
	app.controller('index_controller', function($scope, $http, $uibModal){
		$scope.form_data       = [];
		$scope.standard_wallet = [];
		$scope.clutch          = [];
		$scope.bag             = [];
		$scope.duffle_bag      = [];
		$scope.tote_bag        = [];
		$scope.classic_wallet  = [];
		$scope.coin_pouch      = [];
		$scope.card_holder     = [];

		$http({
		  	method: 'GET',
		  	url: '<?php echo 'frontend_include/ajax.php'; ?>?action=get_all_products'
		}).then(function successCallback(response) {
			console.log(response);
			$scope.standard_wallet.all_products = response.data.all_products.standard_wallet;
			$scope.clutch.all_products          = response.data.all_products.clutch;
			$scope.bag.all_products             = response.data.all_products.bag;
			$scope.duffle_bag.all_products      = response.data.all_products.duffle_bag;
			$scope.tote_bag.all_products        = response.data.all_products.tote_bag;
			$scope.classic_wallet.all_products  = response.data.all_products.classic_wallet;
			$scope.coin_pouch.all_products      = response.data.all_products.coin_pouch;
			$scope.card_holder.all_products     = response.data.all_products.card_holder;

			var array_all = ['standard_wallet', 'clutch', 'classic_wallet', 'coin_pouch', 'card_holder'];



			$scope.standard_wallet.show = function () {
				if( Object.keys($scope.standard_wallet.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.clutch.show = function () {
				if( Object.keys($scope.clutch.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.bag.show = function () {
				if( Object.keys($scope.bag.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.duffle_bag.show = function () {
				if( Object.keys($scope.duffle_bag.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.tote_bag.show = function () {
				if( Object.keys($scope.tote_bag.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.classic_wallet.show = function () {
				if( Object.keys($scope.classic_wallet.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.coin_pouch.show = function () {
				if( Object.keys($scope.coin_pouch.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}
			$scope.card_holder.show = function () {
				if( Object.keys($scope.card_holder.all_products).length > 0 ) {
					return true;
				} else {
					return false;
				}
			}

		}, function errorCallback(response) {
			// called asynchronously if an error occurs
			// or server returns response with an error status.
		});


		/**** START : CALCULATING PRICE ****/
		$scope.standard_wallet.total_cost = function () {
			total_cost = 0;
			for(i in $scope.standard_wallet.user_quantity_requirement) {
				if( $scope.standard_wallet.user_quantity_requirement[i] < 0 ) {
					$scope.standard_wallet.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.standard_wallet.user_quantity_requirement[i] * +$scope.standard_wallet.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.clutch.total_cost          = function () {
			total_cost = 0;
			for(i in $scope.clutch.user_quantity_requirement) {
				if( $scope.clutch.user_quantity_requirement[i] < 0 ) {
					$scope.clutch.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.clutch.user_quantity_requirement[i] * +$scope.clutch.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.bag.total_cost          = function () {
			total_cost = 0;
			for(i in $scope.bag.user_quantity_requirement) {
				if( $scope.bag.user_quantity_requirement[i] < 0 ) {
					$scope.bag.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.bag.user_quantity_requirement[i] * +$scope.bag.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.duffle_bag.total_cost          = function () {
			total_cost = 0;
			for(i in $scope.duffle_bag.user_quantity_requirement) {
				if( $scope.duffle_bag.user_quantity_requirement[i] < 0 ) {
					$scope.duffle_bag.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.duffle_bag.user_quantity_requirement[i] * +$scope.duffle_bag.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.tote_bag.total_cost          = function () {
			total_cost = 0;
			for(i in $scope.tote_bag.user_quantity_requirement) {
				if( $scope.tote_bag.user_quantity_requirement[i] < 0 ) {
					$scope.tote_bag.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.tote_bag.user_quantity_requirement[i] * +$scope.tote_bag.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.classic_wallet.total_cost  = function () {
			total_cost = 0;
			for(i in $scope.classic_wallet.user_quantity_requirement) {
				if( $scope.classic_wallet.user_quantity_requirement[i] < 0 ) {
					$scope.classic_wallet.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.classic_wallet.user_quantity_requirement[i] * +$scope.classic_wallet.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.coin_pouch.total_cost      = function () {
			total_cost = 0;
			for(i in $scope.coin_pouch.user_quantity_requirement) {
				if( $scope.coin_pouch.user_quantity_requirement[i] < 0 ) {
					$scope.coin_pouch.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.coin_pouch.user_quantity_requirement[i] * +$scope.coin_pouch.all_products[i].productPrice;
			}
			return total_cost;
		};
		$scope.card_holder.total_cost     = function () {
			total_cost = 0;
			for(i in $scope.card_holder.user_quantity_requirement) {
				if( $scope.card_holder.user_quantity_requirement[i] < 0 ) {
					$scope.card_holder.user_quantity_requirement[i] = 0;
				}
				total_cost += +$scope.card_holder.user_quantity_requirement[i] * +$scope.card_holder.all_products[i].productPrice;
			}
			return total_cost;
		};
		/***** END : CALCULATING PRICE *****/

		$scope.total_cost_all_product = function () {
			// console.log($scope.standard_wallet.total_cost());
			return +$scope.standard_wallet.total_cost() + +$scope.clutch.total_cost() + +$scope.bag.total_cost() + +$scope.duffle_bag.total_cost() + +$scope.tote_bag.total_cost() + +$scope.classic_wallet.total_cost() + +$scope.coin_pouch.total_cost() + +$scope.card_holder.total_cost();
		};

		$scope.open = function () {
			// if( $scope.total_cost_all_product > 0 ) {
		        var modalInstance = $uibModal.open({
		          animation: true,
		          templateUrl: 'myModalContent.html',
		          controller: 'model_controller',
		          resolve: {
		            form_data: function () {
		              return $scope.form_data;
		            }
		          }
		        });

		        modalInstance.result.then(function (form_data) {
				    form_data = convArrToObj(form_data);
		        	var data_to_send = {
								standard_wallet : $scope.standard_wallet.user_quantity_requirement,
							 	clutch 			: $scope.clutch.user_quantity_requirement,
							 	classic_wallet 	: $scope.classic_wallet.user_quantity_requirement,
							 	coin_pouch 		: $scope.coin_pouch.user_quantity_requirement,
								card_holder	    : $scope.card_holder.user_quantity_requirement,
								form_data_key 	: form_data
							   };
					data_to_send = JSON.stringify(data_to_send);
					show_loading();
					$http({
						method: 'POST',
						url: '<?php echo 'frontend_include/ajax.php'; ?>',
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
						transformRequest: function(obj) {
					        var str = [];
					        for(var p in obj)
					        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
					        return str.join("&");
					    },
						data: { action : 'submit_wholesale', data_key : data_to_send }
					}).then(function(response){
						hide_loading();
						if(response.data.output == 1) {
							window.location.href = '<?php echo ROOT_PATH."thank_you.php?order_number="; ?>'+response.data.order_number;
						} else {
							angular.element('.order_form_error_div').html(response);
						}
					}, function errorCallback(response){

					});
		        }, function (response) {
		          	// $log.info('Modal dismissed at: ' + new Date());
		        });
		    // }
	    };

	})
	.controller('model_controller', function($scope, $uibModalInstance, $http){
		/***** Start : model methods *****/
		$scope.form_making = [];

		$scope.form_data           = [];
		$scope.order_show_error    = false;
		$scope.order_all_errors    = [];

		$scope.model_click_counter = 0;
		$scope.model_heading = 'Contact info';
		$scope.ok_button     = 'Next';
		$scope.ok_counter = function (myform) {
			var error = [];
			if( $scope.model_click_counter == 0 ) {
				if ( !myform.name.$valid ) {
		    		error.push('Name is required');
		    	} if ( !myform.email.$valid ) {
		    		error.push('Email is not valid.');
		    	}
		    	if( error.length > 0 ) {
					$scope.order_all_errors.form_error = error;
					$scope.order_show_error            = true;
		    	} else {
		    		/****HIDE ERROR BLOCK****/
		    		$scope.order_all_errors.form_error = [];
					$scope.order_show_error            = false;
					/****HIDE ERROR BLOCK****/
					$scope.model_heading           = 'Shipping info';
					$scope.ok_button               = 'Done';
					$scope.form_data.shipping_name = $scope.form_data.name;
					$scope.model_click_counter = $scope.model_click_counter+1;
	        	}
	        } else {
	        	$scope.ok(myform);
	        }
		};

	    $scope.ok = function (myform) {
	    	var error                  = [];
	    	/****Start : manage country****/
	    	if( $scope.form_data.country == 231 ) {
	    		$scope.form_data.state = $scope.form_data.us_state;
	    	} else {
	    		$scope.form_data.state = $scope.form_data.other_country_state;
	    	}
	    	/*****End : manage country*****/
			var required_fields = [];
	    	if ( !myform.shipping_name.$valid ) {
	    		error.push('Shipping name is required');
	    	} if ( !myform.company.$valid ) {
	    		error.push('Company is required');
	    	} if ( !myform.address.$valid ) {
	    		error.push('Address is required');
	    	} if ( !myform.country.$valid ) {
	    		error.push('Country is required');
	    	} if ( !myform.state.$valid ) {
	    		error.push('State is required');
	    	} if ( !myform.postal_code.$valid ) {
	    		error.push('Postal code is required');
	    	} if ( !myform.phone.$valid ) {
	    		error.push('Phone is required');
	    	}

	    	if( error.length > 0 ) {
				$scope.order_all_errors.form_error = error;
				$scope.order_show_error            = true;
	    	} else {
        		$uibModalInstance.close($scope.form_data);
        	}
      	};
      	$scope.cancel = function () {
        	$uibModalInstance.dismiss('cancel');
        };
        $scope.test = function () {
        	console.log('test ui here.');
        }

        $scope.countries_data = [];

        $scope.state_dropdown = [];
        $scope.state_dropdown.united_state_countires = {
			"Alabama" : "Alabama",
			"Alaska" : "Alaska",
			"Arizona" : "Arizona",
			"Arkansas" : "Arkansas",
			"California" : "California",
			"Colorado" : "Colorado",
			"Connecticut" : "Connecticut",
			"Delaware" : "Delaware",
			"Florida" : "Florida",
			"Georgia" : "Georgia",
			"Hawaii" : "Hawaii",
			"Idaho" : "Idaho",
			"Illinois" : "Illinois",
			"Indiana" : "Indiana",
			"Iowa" : "Iowa",
			"Kansas" : "Kansas",
			"Kentucky" : "Kentucky",
			"Louisiana" : "Louisiana",
			"Maine" : "Maine",
			"Maryland" : "Maryland",
			"Massachusetts" : "Massachusetts",
			"Michigan" : "Michigan",
			"Minnesota" : "Minnesota",
			"Mississippi" : "Mississippi",
			"Missouri " : "Missouri ",
			"Montana" : "Montana",
			"Nebraska" : "Nebraska",
			"Nevada" : "Nevada",
			"New_Hampshire" : "New Hampshire",
			"New_Jersey" : "New Jersey",
			"New_Mexico" : "New Mexico",
			"New_York" : "New York",
			"North_Carolina" : "North Carolina",
			"North_Dakota" : "North Dakota",
			"Ohio" : "Ohio",
			"Oklahoma" : "Oklahoma",
			"Oregon" : "Oregon",
			"Pennsylvania" : "Pennsylvania",
			"Rhode_Island" : "Rhode Island",
			"South_Carolina" : "South Carolina",
			"South_Dakota" : "South Dakota",
			"Tennessee" : "Tennessee",
			"Texas" : "Texas",
			"Utah" : "Utah",
			"Vermont" : "Vermont",
			"Virginia" : "Virginia",
			"Washington" : "Washington",
			"West_Virginia" : "West Virginia",
			"Wisconsin" : "Wisconsin",
			"Wyoming" : "Wyoming",
		};

	    function enable_state_input_box() {
	    	angular.element('.state_select_box').css('display', 'none'); /*.removeAttr('ng-model')*/
	    	angular.element('.state_input_box').css('display', 'block'); /*.attr('ng-model', 'form_data.state')*/
	    	$scope.form_data.state = $scope.form_data.other_country_state;
	    }
		function enable_state_select_box() {
			angular.element('.state_input_box').css('display', 'none'); /*.removeAttr('ng-model')*/
			angular.element('.state_select_box').css('display', 'block'); /*.attr('ng-model', 'form_data.state')*/
	    	$scope.form_data.state = $scope.form_data.us_state;
		}

        $http({
			method: 'POST',
			url: '<?php echo 'frontend_include/ajax.php'; ?>',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			transformRequest: function(obj) {
		        var str = [];
		        for(var p in obj)
		        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
		        return str.join("&");
		    },
			data: { action : 'get_countries' }
		}).then(function(response) {
			$scope.countries_data.all_countries = response.data.countries;

			$scope.countries_data.valid_state 	= function () {
				var output_array = [];
				for(i in response.data.states) {
					if( response.data.states[i][0] == $scope.form_data.country ) {
						output_array.push({ primary_key : i, value : response.data.states[i][1] });
					}
				}
				return output_array;
			};

			$scope.countries_data.valid_cities	= function () {
				var output_array = [];
				for(i in response.data.cities) {
					if( response.data.cities[i][0] == $scope.form_data.state ) {
						output_array.push({ primary_key : i, value : response.data.cities[i][1] });
					}
				}
				return output_array;
			}

			$scope.$watch('form_data.country', function() {
				if( $scope.form_data.country == 231 ) {
					enable_state_select_box();
				} else {
					enable_state_input_box();
				}
			}, true);
			/****Start : manage country****/
			$scope.$watch('form_data.other_country_state', function() {
				if( $scope.form_data.country == 231 ) {
		    		$scope.form_data.state = $scope.form_data.us_state;
		    	} else {
		    		$scope.form_data.state = $scope.form_data.other_country_state;
		    	}
			}, true);
			$scope.$watch('form_data.us_state', function() {
				if( $scope.form_data.country == 231 ) {
		    		$scope.form_data.state = $scope.form_data.us_state;
		    	} else {
		    		$scope.form_data.state = $scope.form_data.other_country_state;
		    	}
			}, true);
			/*****End : manage country*****/
		}, function errorCallback(response) {

		});

      	/****** End : model methods ******/
	});
</script>

<?php require_once "frontend_include/footer.php"; ?>