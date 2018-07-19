<?php extract(require('fetch-dashboard.php')); ?>
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
    <title>Veeqo-Dashboard</title>

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
            <a class="navbar-brand" href="#">Veeqo Dashboard</a>
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

    <form id="fetch_warehouse_stock">
    <?php if(!isset($_POST['api-key']) || ($error)): ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <!--<form>-->
                    <h2>Enter your API key:</h2>
                    <input class="form-control input-sm"
                           type="text"
                           name="api-key"
                           value="">
                <!--</form>-->
                <div class="blue-line"></div>
            </div>
        </div><!-- /.row -->
    <?php endif; ?>

    <?php if(isset($_POST['api-key'])): ?>

        <?php $api_key = htmlentities($_POST['api-key']); ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <h2>Your API Key: </h2>
                <h3><?php echo $api_key ?></h3>
            </div>
            <div class="blue-line"></div>
        </div><!-- /.row -->
    <?php endif; ?>

    <?php if(!isset($_POST['warehouse_id']) || ($error)): ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <!--<form>-->
                    <h2>Enter Warehouse ID:</h2>
                    <input class="form-control input-sm"
                           type="text"
                           name="warehouse_id"
                           value="">
                <!--</form>-->
                <div class="blue-line"></div>
            </div>
        </div><!-- /.row -->
    <?php endif; ?>

    <?php if(isset($_POST['warehouse_id'])): ?>

        <?php $warehouse_id = htmlentities($_POST['warehouse_id']); ?>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <h2>Warehouse ID: </h2>
                <h3><?php echo $warehouse_id ?></h3>
            </div>
            <div class="blue-line"></div>
        </div><!-- /.row -->
    <?php endif; ?>

    <button type="submit" formaction="#" form=fetch_warehouse_stock">Click Me!</button>
    </form>



    <?php if ($error): ?>
        <div class="alert alert-danger text-center" role="alert"><?= $error; ?></div>

    <?php else: ?>
        <?php foreach (array_chunk($products, 4) as $group): ?>
            <div class="row text-center">
                <?php foreach ($group as $product): ?>
                    <div class="col-md-3 col-sm-6 hero-feature">
                        <div class="thumbnail">
                            <img src="<?= isset($product['image']) ? $product['image'] : 'http://placehold.it/800x500' ?>" alt="">
                            <div class="caption">
                                <h3><?= $product['title'] ?></h3>
                                <p><?= $product['description'] ?></p>
                                <p>Available Stock: <?= $product['total_available_stock_level'] ?></p>
                                <p>Allocated Stock: <?= $product['total_allocated_stock_level'] ?></p>
                                <p>
                                    <a href="<?= $product['buyUrl'] ?>" class="btn btn-primary">Buy Now!</a> <a href="<?= $product['infoUrl'] ?>" class="btn btn-default">More Info</a>
                                </p>
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
                <p>API request took <?= $time ?>s, response
                    size <?= $responseSize ?> bytes</p>
                <p> &copy; Veeqo 2017 Ltd</p>
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