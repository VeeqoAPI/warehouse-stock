<?php extract(require('fetch-products.php')); ?>
<!--/**
 * Created by PhpStorm.
 * User: philr
 * Date: 13/7/2017
 * Time: 8:14 AM
 */-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Veeqo - API Dashboard">
    <meta name="author" content="Phil Reynolds">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Veeqo-Warehouse-Stock</title>

    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Theme CSS -->
    <link href="main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body>
<!--
    ==========
    Navigation
    ==========
              -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Veeqo Warehouse Stock</a>
        </div>

    </div>
    <!-- /.container -->
</nav>
<!--
    ==========
     Content
    ==========
              -->

<div class="container">
    <hr>

    <!-- Title -->
    <div class="row">
        <div class="col-lg-12">
            <h3></h3>
        </div>
    </div>

    <?php
    $api_key = htmlentities($_POST['api-key']);
    $warehouse_id = htmlentities($_POST['warehouse_id']);
    $page_size = htmlentities($_POST['page_size']);
    $page = htmlentities($_POST['page']);
    ?>

        <form id="fetch_warehouse_stock" action="index.php" method="post">

            <?php if(!isset($_POST['api-key']) || ($error)): ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                            <h2>Enter your API key:</h2>
                            <input class="form-control input-sm"
                                   type="text"
                                   name="api-key"
                                   value="">
                        <div class="blue-line"></div>
                    </div>
                </div><!-- /.row -->
            <?php endif; ?>

            <?php if(isset($_POST['api-key']) && (!$error)): ?>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <h2>Your API Key: </h2>
                        <h3><?php echo $api_key ?></h3>
                        <div class="blue-line"></div>
                    </div>

                </div><!-- /.row -->
            <?php endif; ?>

            <?php if(!isset($_POST['warehouse_id']) || ($error)): ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                            <h2>Enter Warehouse ID:</h2>
                            <input class="form-control input-sm"
                                   type="text"
                                   name="warehouse_id"
                                   value="">
                        <div class="blue-line"></div>
                    </div>
                </div><!-- /.row -->
            <?php endif; ?>

            <?php if(isset($_POST['warehouse_id']) && (!$error)): ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <h2>Warehouse Name: </h2>
                        <h3><?php echo $warehouse['name'] ?></h3>
                        <div class="blue-line"></div>
                    </div>

                </div><!-- /.row -->
            <?php endif; ?>

            <?php if(!isset($_POST['warehouse_id']) || !isset($_POST['api-key']) || ($error)): ?>
                <div class="text-center">
                    <label for="page_size">Products per Page: </label>
                    <select id="page_size" name="page_size">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100" selected>100</option>
                    </select>
                </div>
                <div class="text-center">
                    <input class="btn btn-primary veeqo-background" type="submit" value="Get Products" />
                </div>
            <?php endif; ?>

            <?php if(isset($_POST['warehouse_id']) && isset($_POST['api-key']) && (!$error)): ?>
                <div class="text-center">
                    <div class="text-center">
                        <label for="page_size">Products per Page: </label>
                        <select id="page_size" name="page_size">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100" selected>100</option>
                        </select>
                    </div>
                    <input type="hidden"  name="api-key" value="<?php echo $api_key ?>">
                    <input type="hidden"  name="warehouse_id" value="<?php echo $warehouse_id ?>">
<!--                    <input class="btn btn-success" type="button" value="Refresh Page" onclick="window.location.reload(true)" />-->
<!--                    <input class="btn btn-danger" type="submit" value="Clear Values" />-->
                    <input class="btn btn-primary veeqo-background" type="submit" value="Refresh" />
                </div>
                <?php if($headers_arr['X-Total-Count']>$page_size): ?>
                    <?php $page_count = ceil($headers_arr['X-Total-Count']/$page_size) ?>
                    <div>
                       <p><?php echo $page_count ?></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>



        </form>



    <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert"><?= $error; ?></div>



    <?php else: ?>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Product Title</th>
                    <th scope="col">Sellable Title</th>
                    <th scope="col">Total Quantity Sold</th>
                    <th scope="col">Physical Stock Level</th>
                    <th scope="col">Allocated Stock Level</th>
                    <th scope="col">Available Stock Level</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
                <?php foreach ($product['sellables'] as $sellable): ?>
                    <tr>
                        <th><?= $sellable['product_title'] ?></th>
                        <th><?= $sellable['sellable_title'] ?></th>
                        <th><?= $sellable['total_quantity_sold'] ?></th>
                        <?php foreach ($sellable['stock_entries'] as $stock_entry): ?>
                            <?php if ($stock_entry['warehouse_id'] == $warehouse_id): ?>
                                <th><?= $stock_entry['physical_stock_level'] ?></th>
                                <th><?= $stock_entry['allocated_stock_level'] ?></th>
                                <th><?= $stock_entry['available_stock_level'] ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>


        <?php foreach (array_chunk($products, 4) as $group): ?>
            <div class="row text-center">
                <div class="blue-line"></div>
                <?php foreach ($group as $product): ?>
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                            <img src="<?= isset($product['image']) ? $product['image'] : 'http://placehold.it/800x500' ?>" alt="">
                            <div class="caption">
                                <h3><?= $product['title'] ?></h3>
<!--                                <p>--><?//= $product['description'] ?><!--</p>-->
                                <p>Total Available Stock: <?= $product['total_available_stock_level'] ?></p>
                                <p>Total Allocated Stock: <?= $product['total_allocated_stock_level'] ?></p>
                                <p><strong>NOTE: Stock values are from all warehouses.</strong></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- /.row -->
        <?php endforeach; ?>
    <?php endif; ?>

    <hr>
    <!-- Footer -->
    <footer class="text-center">
        <div class="row">
            <div class="col-lg-12">
                <p>Stats for Geeks</p>
                <p>API request took <?= $time ?>s, response
                    size <?= $responseSize ?> bytes</p>
                <p>API Reponse Code: <?= $responseCode ?></p>
                <p>Total Products: <?= $headers_arr['X-Total-Count'] ?></p>
                <p> &copy; Veeqo 2018 Ltd</p>
            </div>
        </div>
    </footer>
</div>
<!-- /.container -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
        crossorigin="anonymous"></script>
</body>
</html>