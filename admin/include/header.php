<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paperwallet - Wholesale</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo ROOT_PATH; ?>css/docs.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

    <script src="js/jquery-1.12.0.js"></script>
    <script src="js/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
    <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.1.0.js"></script>
    <!-- <script src=""></script> -->
</head>
<body>
    <div class="container">
      <div class="col-md-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <span class="navbar-brand">Wholesale Admin</span>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                  <li class="index_class"><a href="<?php echo ROOT_PATH.'index.php'; ?>">Add Product</a></li>
                  <li class="list_class"><a href="<?php echo ROOT_PATH.'list.php'; ?>">All Products</a></li>
                  <li class="order_listing_class"><a href="<?php echo ROOT_PATH.'order_listing.php'; ?>">Orders</a></li>
                  <li class="add_category"><a href="<?php echo ROOT_PATH.'add_category.php'; ?>">Category</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
      </div>

        <div class="col-md-12">