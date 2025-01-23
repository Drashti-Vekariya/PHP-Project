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
    <style>
        .blurred {
    filter: blur(1.0px); /* Apply a blur effect */
    opacity: 0.5; /* Optionally reduce the opacity to make it more subtle */
}

        </style>
    

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <?php include("header.php"); ?>
    </div>

    <section class="banner banner-secondary" id="top" style="background-color:rgba(255, 0, 0, 0.66);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <h3 style="color:white; text-align:center;">Products</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <?php
                    include("config.php");
                    // SQL query to fetch product data including discount
                    $sql = "SELECT * FROM products ORDER BY p_price";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // Loop through the rows of the result
                        while ($row = $result->fetch_assoc()) {
                            // Access individual columns using the column name
                            $p_id = $row['p_id'];
                            $p_name = $row['p_name'];
                            $p_img = $row['p_img'];
                            $p_mrp = $row['p_mrp'];
                            $p_price = $row['p_price'];
                            $p_desc = $row['p_desc'];
                            $qty = $row['qty']; // Assuming 'p_qty' stores the product quantity
                            $p_discount = $row['p_discount'];
                            
                            // Calculate the final price after applying the discount
                            if ($p_discount > 0) {
                                $final_price = $p_price - ($p_price * $p_discount / 100);
                            } else {
                                $final_price = $p_price; // No discount
                            }

                            // Convert MRP to proper format with currency symbol
                            $formatted_mrp = number_format($p_mrp, 2);
                            $formatted_final_price = number_format($final_price, 2);
                            $formatted_price = number_format($p_price, 2);
                            ?>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="featured-item">
                                    <div class="thumb">
                                        <img src="img/<?php echo "$p_img"; ?>" alt=""  class="<?php echo ($qty > 0) ? '' : 'blurred'; ?>">
                                    </div>
                                    <div class="down-content">
                                        <h4>
                                            <?php echo "$p_name"; ?>
                                        </h4>

                                        <span>
                                            <?php if ($p_discount > 0) { ?>
                                                <!-- Show the original price (crossed out) and the discounted price -->
                                                <del><sup>₹</sup><?php echo "$formatted_price"; ?></del> 
                                                <strong><sup>₹</sup><?php echo "$formatted_final_price"; ?></strong>
                                                 <!-- Show discount percentage -->
                                              
                                                 <small style="color: green;">(<?php echo $p_discount; ?>% off)</small>
                                            <?php } else { ?>
                                                <!-- If there's no discount, just show the original price -->
                                                <strong><sup>₹</sup><?php echo "$formatted_price"; ?></strong>
                                            <?php } ?>
                                        </span>

                                        <!-- <div class="text-button">
                                            <a href="product-details.php?p_id=<?php echo $p_id; ?>">Buy now</a>
                                        </div> -->
                                        <div class="text-button">
                    <?php if ($qty > 0) { ?>
                        <!-- Show the "Buy Now" button if the product is in stock -->
                        <a href="product-details.php?p_id=<?php echo $p_id; ?>">Buy now</a>
                    <?php } else { ?>
                        <!-- Display "Out of Stock" if the product quantity is zero -->
                        <span style="color: red; font-weight: bold;">Out of Stock</span>
                    <?php } ?>
                </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No data found.";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <?php include("footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
