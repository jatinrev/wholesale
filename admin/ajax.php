<?php

    header("Access-Control-Allow-Origin: *");

require_once 'include/config.php';

if (isset($_REQUEST['action']) && trim($_REQUEST['action']) == 'change_status' &&
	isset($_REQUEST['product_id']) && trim($_REQUEST['product_id']) != '' &&
	isset($_REQUEST['status']) && trim($_REQUEST['status']) != ''
	) {
	require_once ROOT_DIRECTORY_PATH."classes/list_class.php";
	$list_class_ob = new list_class();
	echo $list_class_ob->change_product_status($_REQUEST['product_id'], $_REQUEST['status']);
}

?>