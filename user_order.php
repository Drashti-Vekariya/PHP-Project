<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>INTERIOR</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
<?php
include_once("header.php");
include_once("config.php"); // Ensure config.php is included

// $email = $_SESSION['user_id'];
$q = "SELECT * FROM orders";
$result = mysqli_query($conn, $q);

// $q1 = "SELECT * FROM user_form WHERE email='$email'";
$q1 = "SELECT * FROM user_form";
$result1 = mysqli_fetch_assoc(mysqli_query($conn, $q1));

// Check if the query returned a result
if ($user) {
    $user_name = $user['name'];
    $email = $user['email'];  // Now we have the user's email
} else {
    $user_name = "Guest";  // Default value if user not found
    $email = "";  // Default email for guest users
}


?>


<div class="container">
    <div class="row text-center">
        <div class="col-12 bg-dark text-white p-2 align-center">
            <!-- <h1><?php echo $result1['user_name'] . "'s Orders"; ?></h1> -->
            <h2>
                     <b><?php echo $user_name; ?>'s Orders</b><br> 
                </h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sr.NO</th>
                            <th scope="col">Order ID</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Order Status</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $pid = $row['p_id'];
                            $p = "SELECT * FROM products WHERE p_id=$pid";
                            $p_result = mysqli_fetch_assoc(mysqli_query($conn, $p));
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['order_id']; ?></td>
                            <td><img src="img/<?php echo $p_result['p_img']; ?>" height="50px"></td>
                            <td><?php echo $row['qty']; ?></td>
                            <td><?php echo $row['sub_total']; ?></td>
                            <td><?php echo $row['delivery_status']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td>
                                <?php
                                if ($row['rating'] == NULL && $row['review'] == NULL) {
                                ?>
                                <a href="user_review_product.php?id=<?php echo $row['sub_order_id']; ?>" class="btn btn-success">Review</a>
                                <?php
                                }
                                ?>
                                <a href="user_view_order.php?id=<?php echo $row['sub_order_id']; ?>" class="btn btn-info">View</a>
                                <a href="user_cancel_order.php?id=<?php echo $row['sub_order_id']; ?>" class="btn btn-danger">Cancel</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/datepicker.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
</body>
</html>
