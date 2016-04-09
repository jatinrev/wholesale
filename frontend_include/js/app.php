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

		$scope.master         = [];
		$scope.master_helper  = {};
		$scope.product_helper = {};

		$http({
		  	method: 'GET',
		  	url: '<?php echo 'frontend_include/ajax.php'; ?>?action=get_all_products'
		}).then(function successCallback(response) {
			console.log(response);
			$scope.master = response.data.all_products;
			console.log($scope.master);

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
			return response;

		}, function errorCallback(response) {
			// called asynchronously if an error occurs
			// or server returns response with an error status.
		})
		.then(function (response) {
			var res = response.data;
			console.log(res);
			$scope.master_helper.master_headings = function (input) {
				for (i in res.all_categories) {
					if( input == res.all_categories[i].sorting_order ) {
						return { master_heading : res.all_categories[i].category_name,
								 master_price 	: res.all_categories[i].category_price
								};
					}
				};
			};

			/*$scope.product_helper.pricee = function () {
				console.log($scope.product_helper.particular_product_requirement);
			};*/

			$scope.master_helper.subtotal_cost = function (sorting_key) {
				total_cost = 0;
				for(product_id in $scope.master[sorting_key]) {
					// required_product_id is the product which is required by the user.
					for( required_product_id in $scope.product_helper.particular_product_requirement ) {
						if( $scope.product_helper.particular_product_requirement[required_product_id] < 0 ) {
							$scope.product_helper.particular_product_requirement[required_product_id] = 0;
						} // checking if user try to purchese -ve products
						if( product_id == required_product_id ) {
							total_cost += +$scope.product_helper.particular_product_requirement[required_product_id] * +$scope.master[sorting_key][product_id].productPrice;
						}
					}
				}
				return total_cost;
			};

			$scope.master_helper.totol_cost = function () {
				total_cost = 0;
				for(sorting_key in $scope.master) {
					total_cost += +$scope.master_helper.subtotal_cost(sorting_key);
				}
				return total_cost;
			};

		});

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

		        modalInstance
		        .result
		        .then(function (form_data) {
				    form_data = convArrToObj(form_data);

				    var product_requirement_data = [];
				    /*** Start : getting category of products ***/
				    for(sorting_key in $scope.master) {
				    	for( product_ids in $scope.master[sorting_key] ) {
				    		for( required_product_id in $scope.product_helper.particular_product_requirement ) {
						    	if( product_ids == required_product_id ) {
						    		product_requirement_data.push({
						    			product_id 		 : product_ids,
						    			product_quantity : $scope.product_helper.particular_product_requirement[product_ids],
						    			product_category : $scope.master[sorting_key][product_ids].category_field
						    		});
						    	}
					    	}
					    }
				    }

		        	var data_to_send = {
								product_requirement : product_requirement_data,
								form_data_key 		: form_data
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