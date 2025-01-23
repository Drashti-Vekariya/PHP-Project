

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

    <div class="wrap">
        <?php include("header.php"); ?>
    </div>

    <section class="featured-places">

        <?php
        include("config.php");

        
        
        $p_id = $_GET['p_id'];
        $sql = "SELECT * FROM products WHERE p_id=$p_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $p_id = $row['p_id'];
                $p_name = $row['p_name'];
                $p_img = $row['p_img'];
                $p_mrp = $row['p_mrp'];
                $p_price = $row['p_price'];
                $p_desc = $row['p_desc'];
                $p_discount = $row['p_discount']; // Discount percentage
                $qty = $row['qty']; // Assuming 'p_qty' is the column for product quantity

                // Calculate the discounted price
                $discounted_price = $p_price - ($p_price * ($p_discount / 100));

                // Assuming you have already fetched the product details in the $qty variable (available stock)
    // $max_qty = $qty;  // Max available quantity from the database
    // $requested_qty = isset($_POST['qty']) ? $_POST['qty'] : 1;  // Requested quantity from the user (default is 1)

    // // Check if the requested quantity exceeds the available stock
    // if ($requested_qty > $max_qty) {
    //     // Display a message if the quantity exceeds available stock
    //     echo "<h4 class='text-danger'>Only $max_qty items available. You can add up to $max_qty items.</h4>";
    // }
                ?>



                <section class="banner banner-secondary" id="top"
                    style="background-color:rgba(255, 0, 0, 0.66); margin-top:-80px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="banner-caption">
                                    <h3 style="color:white; text-align:center;">
                                        <?php echo $p_name; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="container" style="margin-top:20px;">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div>
                                <img src="img/<?php echo $p_img; ?>" alt="" class="img-responsive wc-image">
                            </div>
                        </div>

                        <div class="col-md-6 col-xs-12">
                            <form action="#" method="post" class="form">
                                <h3><?php echo $p_name; ?></h3>
                                
                                <!-- Show Discount and Final Price if Discount > 0 -->
<?php if ($p_discount > 0): ?>
    <h4><small><del>₹<?php echo $p_price; ?></del></small></h4>
    <h2><small class="text-muted">Discount: <?php echo $p_discount; ?>%</small></h2>
<?php endif; ?>
<h2><strong class="text-danger">₹<?php echo number_format($discounted_price, 2); ?></strong></h2>

                                <p class="lead"><?php echo $p_desc; ?></p>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label">Quantity</label>
                                        <div class="form-group">
                                            <input type="number" name="qty" class="form-control" value="1" min="1" max="5"
                                                required>
                                        </div>
                                    </div>
                                </div>

                            <!-- If product is out of stock (p_qty <= 0), show "Out of Stock" message -->
    <?php if ($qty <= 0): ?>
        <h4 class="text-danger">Out of Stock</h4>
    <?php else: ?>
        <!-- Check for quantity limit when form is submitted -->
        <?php
        if (isset($_POST['qty'])) {
            $requested_qty = $_POST['qty']; // Get requested quantity from form submission

            // Check if requested quantity exceeds available stock
            if ($requested_qty > $qty) {
                echo "<h4 class='text-danger'>Only $qty items available. .</h4>";
            }
        }
        ?>
                    <div class="blue-button">
                        <?php
                            if (!isset($_SESSION['u_id'])) { ?>
                                <input type="submit" value="Add to Cart" name="noLogin">
                                <input type="submit" value="❤" name="noWish">
                        <?php } else { ?>
                                <input type="submit" value="Add to Cart" name="addtocart">
                                <input type="submit" value="❤" name="wishlist">
                        <?php } ?>
                    </div>
                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "No data found.";
        }
        mysqli_free_result($result);
        mysqli_close($conn);



        include 'config.php';
        if (isset($_POST['noWish'])) {
            echo 
            '<script>
            alert("Please login to add product in wishlist");
             window.location.href = "login_form.php"; // Redirect to the login page
            </script>';
            
        }

        if (isset($_POST['noLogin'])) {
            echo 
            '<script>
            alert("Please login to purchase product");
            window.location.href = "login_form.php"; // Redirect to the login page
            </script>';
        }

        if (isset($_POST['addtocart'])) {
            $p_id = $_GET['p_id'];
            $sql = "SELECT * FROM products where p_id=$p_id;";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Loop through each row and print the product data
                while ($row = mysqli_fetch_assoc($result)) {
                    $u_id = $_SESSION['u_id'];
                    $p_id = $row["p_id"];
                    $p_name = $row["p_name"];
                    $p_img = $row["p_img"];
                    $p_price = $row["p_price"];
                    $p_desc = $row["p_desc"];
                    $qty = $row['qty']; // Available stock quantity

                    $requested_qty = isset($_POST['qty']) ? $_POST['qty'] : 1; // Default quantity is 1 if not set

                    if ($requested_qty > $qty) {
                        echo '<script>alert("Only ' . $qty . ' items available.");</script>';
                    } else {

                    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE p_id='$p_id' AND user_id='$u_id'") or die('query failed');
                
            
            if (mysqli_num_rows($check_cart_numbers) > 0) {
                echo '<script>alert("already added to cart!");</script>';
            } else {
                mysqli_query($conn, "INSERT INTO cart (user_id,p_id,p_name,p_img,p_price,p_desc,qty) 
                VALUES('$u_id','$p_id','$p_name','$p_img','$p_price',\"$p_desc\",'$qty')");

                echo '<script>alert("product added to cart");';
                echo "window.location.href ='cart.php'</script>";
            }
        }
    }
}
        
    }

       if (isset($_POST['wishlist'])) {
    $p_id = $_GET['p_id'];
    $sql = "SELECT * FROM products WHERE p_id=$p_id;";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $u_id = $_SESSION['u_id'];
            $p_id = $row["p_id"];
            $p_name = $row["p_name"];
            $p_img = $row["p_img"];
            $p_price = $row["p_price"];
            $p_discount = $row["p_discount"];
            $p_desc = $row["p_desc"];

            // Calculate discounted price
            $discounted_price = $p_price - ($p_price * ($p_discount / 100));

            $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE p_id='$p_id' AND user_id='$u_id'") or die('query failed');

            if (mysqli_num_rows($check_cart_numbers) > 0) {
                echo '<script>alert("Already added to your wishlist!");</script>';
            } else {
                mysqli_query($conn, "INSERT INTO `wishlist`(user_id, p_id, p_name, p_img, p_price, p_discount, p_desc) 
                VALUES('$u_id', '$p_id', '$p_name', '$p_img', '$discounted_price', '$p_discount', \"$p_desc\")") or die('query failed');

                echo '<script>alert("Product added to your wishlist!");';
                echo "window.location.href ='wishlist.php'</script>";
            }
        }
    }
}

        ?>

        </form>
        </div>
        </div>
        </div>
        </div>


        <script>
            $(document).ready(function () {
    // Trigger when quantity is changed
    $("input[name='qty']").on("input", function () {
        var max_qty = <?php echo $qty; ?>; // Available quantity from PHP
        var requested_qty = $(this).val(); // Requested quantity from input field
        
        // Check if the requested quantity exceeds available stock
        if (requested_qty > max_qty) {
            $(".stock-warning").text("Only " + max_qty + " items available.").show();
        } else {
            $(".stock-warning").hide(); // Hide message if quantity is within stock
        }
    });

    // Prevent the form from submitting when the quantity changes
    $("form").on("submit", function (e) {
        e.preventDefault();
    });
});


            </script>

        <?php include("footer.php"); ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/datepicker.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
</body>

</html>