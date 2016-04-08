<?php


define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','paperwal_wholesale');


define('PROJECT_NAME', 'wholesale');
define('ROOT_DIRECTORY_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.PROJECT_NAME.'/');
define('ROOT_PATH', 'http://localhost/'.PROJECT_NAME.'/');


/**
 * Table name specification
 */
define('WS_PRODUCTS', 			'wholesale_products');
define('WS_IMAGES', 			'wholesale_images');
define('WS_ALL_ORDERS', 		'wholesale_all_orders');
define('WS_ALL_ORDERS_LIST', 	'all_order_list');
define('CATEGORY', 				'category');
/***********************/


require_once(ROOT_DIRECTORY_PATH.'admin/include/mysqlDbClass.php');
require_once(ROOT_DIRECTORY_PATH.'admin/include/formFieldsValidation.php');
require_once(ROOT_DIRECTORY_PATH.'admin/include/common.php');

require_once(ROOT_DIRECTORY_PATH.'admin/include/functions.php');

$mysqlDbOb              = new mysqlDbClass();
$formFieldsValidationOb = new formFieldsValidation();
?>