<?php

define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','paperwal_wholesale');


define('PROJECT_NAME','wholesale/admin');
define('ROOT_DIRECTORY_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.PROJECT_NAME.'/');
define('ROOT_PATH', 'http://localhost/'.PROJECT_NAME.'/');

// echo '('.ROOT_DIRECTORY_PATH.')('.ROOT_PATH.')';

/**
 * Table name specification
 */
define('WS_PRODUCTS', 'wholesale_products');
define('WS_IMAGES', 'wholesale_images');
define('CATEGORY', 'category');
/***********************/

require_once('include/mysqlDbClass.php');
require_once('include/formFieldsValidation.php');
require_once('include/common.php');

require_once('include/functions.php');
require_once('classes/list_class.php');

$mysqlDbOb              = new mysqlDbClass();
$formFieldsValidationOb = new formFieldsValidation();
$list_class_ob          = new list_class();


?>