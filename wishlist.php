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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <div class="wrap">
        <?php include("header.php"); ?>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
        </div>
    </div>

    <?php

    if (!isset($_SESSION['u_id'])) {
        $u_id = "";
    } else {
        $u_id = $_SESSION['u_id'];
    }

    // Fetch the user's name
    $select_user = mysqli_query($conn, "SELECT name FROM `user_form` WHERE user_id = '$u_id'") or die('query failed');
     $user = mysqli_fetch_assoc($select_user);
  
    // Check if the query returned a result
    if ($user) 
    {
        $user_name = $user['name'];
    } 
    else 
    {
        $user_name = "Guest";  // Default value if user not found
    }

    $wishlist_rows_number = 0;
    $select_wish_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$u_id'") or die('query failed');
    $wishlist_rows_number = mysqli_num_rows($select_wish_number);
    ?>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12" style="margin-top:-10px;">
                    <!-- <h3 class="  display-5 mb-2 text-center">Wishlist</h3> -->
                    <p class="mb-5 text-center">
                    <center> <h2><b><?php echo $user_name; ?>'s Wishlist</b><br> </h2>
                        <h3>
                        <b>
                            <?php echo $wishlist_rows_number; ?>
                        </b> items in your Wishlist </h3></center>
                    </p>
                    <?php
                    include("config.php");
                    if (isset($_SESSION['u_id'])) {
                        ?>
                        <table id="shoppingCart" class="table table-condensed table-responsive" style="">
                            <thead>
                                <tr>
                                    <th style="width:60%">Product</th>
                                    <th style="width:12%">Price</th>
                                    <th style="width:16%">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $user_id = $_SESSION['u_id'];
                                $sql = "SELECT * FROM `wishlist` WHERE user_id = '$u_id'";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    // Loop through each row and print the product data
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $wish_id = $row['wish_id'];
                                        $p_id = $row["p_id"];
                                        $p_name = $row["p_name"];
                                        $p_img = $row["p_img"];
                                        $qty = $row['qty'];
                                        $p_price = $row["p_price"];
                                        $p_desc = $row["p_desc"];


                                        if (isset($_POST['cart'])) {
                                            $sql = "SELECT * FROM products where p_id=$p_id;";
                                            $result = mysqli_query($conn, $sql);
                                            if (mysqli_num_rows($result) > 0) {

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $u_id = $_SESSION['u_id'];
                                                    $p_id = $row["p_id"];
                                                    $p_name = $row["p_name"];
                                                    $p_img = $row["p_img"];
                                                    $qty = $row['qty'];
                                                    $p_price = $row["p_price"];
                                                    $p_desc = $row["p_desc"];

                                                    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE p_id = '$p_id' AND user_id = '$user_id'") or die('query failed');
                                                }
                                            }
                                            if (mysqli_num_rows($check_cart_numbers) > 0) {
                                                echo '<script>alert("already added to cart!");</script>';
                                            } else {
                                                mysqli_query($conn, "INSERT INTO `cart`(user_id, p_id, p_name, p_img, p_price, p_desc, qty) VALUES
        ('$u_id', '$p_id', '$p_name', '$p_img', '$p_price' ,\"$p_desc\", '$qty')") or die('query failed');
                                                echo '<script>alert("product added to cart");';
                                                echo "window.location.href ='cart.php'</script>";
                                            }
                                        }
                                        if (isset($_POST['delete_' . $p_id])) {
                                            $delete_id = $wish_id;
                                            mysqli_query($conn, "DELETE FROM `wishlist` WHERE `wish_id` = '$delete_id'") or die('query failed');
                                            echo "<script>alert('product remove form the wishlist');";
                                            echo "window.location.href ='wishlist.php'</script>";
                                        }

                                        ?>

                                        <tr>
                                            <td data-th="Product">
                                                <div class="row">
                                                    <div class="col-md-3 text-left">
                                                        <img src="img\<?php echo $p_img; ?>" alt=""
                                                            class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                    </div>
                                                    <div class="col-md-9 text-left mt-sm-2">
                                                        <h4>
                                                            <?php echo $p_name; ?>
                                                        </h4>

                                                    </div>
                                                </div>
                                            </td>
                                            <td data-th="Price">₹
                                                <?php echo $p_price; ?>
                                            </td>
                                            <td class="actions" data-th="Operation">
                                                <div class="text-left">
                                                    <form action="" method="post">
                                                        <!-- <button class="btn btn-white border-secondary bg-white btn-md mb-2"
                                                            name="cart" value="cart">
                                                            <i class="fa fa-shopping-cart" style="font-size:20px"></i>
                                                        </button> -->
                                                        <button class="btn btn-white border-secondary bg-white btn-md mb-2"
                                                            name="delete_<?php echo $p_id; ?>" value="delete">
                                                            <i class="fa fa-trash" style="font-size:20px"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {?>
                                <center>
                                    <b><p>You don't have any wished products</p></b>
                                </center><?php
                                }
                                mysqli_free_result($result);
                                mysqli_close($conn);
                    }
                    ?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="row mt-4 d-flex align-items-right">
                <div class="display-5 mb-2 text-center">
                    <a href="products.php" class="btn btn-danger mb-4 btn-lg pl-5 pr-5"
                        style="margin-top:50px;">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>



    <?php include("footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>